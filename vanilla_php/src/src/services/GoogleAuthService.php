<?php declare(strict_types=1);

/**
 * Utiliza las librerías de la API de Google para procesar la
 * autenticación y autorización del sitio.
 */
class GoogleAuthService {

    /**
     * Google API Client
     */
    private object $client;

    /**
     * Inicializar cliente de la API de Google.
     */
    public function __construct() {
        $this->client = new Google\Client();
        $this->client->setClientId(getenv("GOOGLE_OAUTH_CLIENTID"));
        $this->client->setClientSecret(getenv("GOOGLE_OAUTH_SECRET"));
        $this->client->setRedirectUri("https://www.salvadordiaz.net/access");
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function getClient(): object {
        return $this->client;
    }

    public function getUserInfo(string $code): object {
        // Request par intentar intercambiar el código por un auth token
        $token = $this->client->fetchAccessTokenWithAuthCode($code);

        if (!isset($token['access_token']))
            return (object)["error" => "Error al proccesar el código de autorización"];

        $this->client->setAccessToken($token['access_token']);

        // Request usando auth token para obtener la información del usuario
        $google_oauth = new Google\Service\Oauth2($this->client);
        return $google_oauth->userinfo->get();
    }
}
