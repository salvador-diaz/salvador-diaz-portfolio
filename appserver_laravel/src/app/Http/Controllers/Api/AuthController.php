<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Helper para hacer peticiones http
use App\Services\JwtService;
use App\Exceptions\JwtExpiredException;
use App\Models\User;

class AuthController extends Controller
{
    public const GOOGLE_OAUTH_ENDPOINT = "https://accounts.google.com/o/oauth2";


    public function createJwt(Request $request) {
        $header = [ "alg" => "HS256", "typ" => "JWT"];
        return JwtService::createJwt($header, $request->all());
    }

    public function validateJwt(Request $request) {
        try {
            return JwtService::validateJwt($request->query("jwt"));
        } catch (JwtExpiredException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to verify JWT'], 400);
        }
    }

    public function checkAuth(Request $request)
    {
        // Verifica si la cookie con el JWT está presente
        $token = $request->cookie('jwt');

        if (!$token) {
            return response()->json(['auth' => false], 200)->withoutCookie('jwt');
        }

        try {
            $decodedJwt = JwtService::validateJwt($token);
            return response()->json(['payload' => $decodedJwt["payload"]]);
        } catch (JwtExpiredException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to verify JWT'], 400);
        }
    }

    /**
     * Redirigir al usuario a autenticarse en el portal de Google
     */
    //public function redirectToGoogle() {
    //    $clientId = config("");
    //    $redirectUri = config("VITE_GOOGLE_OAUTH_REDIRECT_URI");
    //    $scope = "email%20profile";

    //    return redirect(self::GOOGLE_OAUTH_ENDPOINT."/auth?client_id=$clientId&redirect_uri=$redirectUri&response_type=code&scope=$scope");
    //}

    /**
     * Si el usuario se autenticó correctamente en el portal de Google,
     * este último nos envía los datos mediante callback a esta ruta.
     */
    public function handleGoogleCallback(Request $request) {
        $code = $request->query('code');
        if (empty($code))
            return response()->json(['error' => 'Authorization code not provided'], 400);

        // Exchange the authorization code for an access token
        $response = Http::post(self::GOOGLE_OAUTH_ENDPOINT.'/token', [
            'code'          => $code,
            'client_id'     => config('auth.google.clientId'),
            'client_secret' => config('auth.google.clientSecret'),
            'redirect_uri'  => config('auth.google.redirectUri'),
            'grant_type'    => 'authorization_code',
        ]);

        $tokens = $response->json();

        if (isset($tokens['access_token'])) {
            $accessToken = $tokens['access_token'];

            $userData = $this->getGoogleUserData($accessToken);

            $user = User::firstOrCreate(
                ["email" => $userData["email"]],
                [
                    "firstname" => $userData["given_name"],
                    "lastname"  => $userData["family_name"],
                    "email"     => $userData["email"],
                    "google_id" => $userData["sub"],
                    "picture_url" => $userData["picture"]
                ]
            );

            // Crear token con 8 horas de duración
            $expirationMinutes = 8*60;
            $expirationSeconds = $expirationMinutes*60;
            $jwt = JwtService::createJwt(
                    [ "alg" => "HS256", "typ" => "JWT"],
                    [
                       "email" => $user->email,
                       "firstname" => $user->firstname,
                       "lastname" => $user->lastname,
                       "picture_url" => $user->picture_url,
                       "exp" => time()+$expirationSeconds
                    ]
            );

            return redirect("/")->withCookie("jwt", $jwt);
        }

        return response()->json(['error' => 'Failed to obtain access token'], 400);
    }

    /**
     * Obtrener datos de usuario a través del token de accesso obtenido,
     */
    private function getGoogleUserData($accessToken) {
        $response = Http::get('https://www.googleapis.com/oauth2/v3/userinfo', [
            'access_token' => $accessToken,
        ]);
        return $response->json();
  }

    public function logout() {
    }
}
