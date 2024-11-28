<?php

namespace App\Services;
use App\Exceptions\JwtExpiredException;

/**
 * Servicio para crear y validar JSON Web Tokens (JWT) siguiendo el estándar RFC 7519.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc7519
 */
class JwtService {
    
    /**
     * Dado un header y payload, devuelve un JWT con su firma en SHA256.
     */
    public static function createJwt(array|object $header, array|object $payload): string {
        // Codificar header y payload
        $base64UrlHeader = self::base64UrlEncode(json_encode($header));
        $base64UrlPayload = self::base64UrlEncode(json_encode($payload));

        $secret = env("JWT_SECRET");

        // Crear firma (cifrado con sha256)
        $signature = hash_hmac('sha256', $base64UrlHeader.".".$base64UrlPayload, $secret, true);
        // También codificar firma
        $base64UrlSignature = self::base64UrlEncode($signature);

        // Crear y devolver JWT
        $jwt = $base64UrlHeader.".".$base64UrlPayload.".".$base64UrlSignature;
        return $jwt;
    }

    /**
     * Toma un string y lo codifica en base64 y url-safe.
     * @see https://datatracker.ietf.org/doc/html/rfc7515#appendix-C
     */
    public static function base64UrlEncode(string $str): string {
        return str_replace(
                    ['+', '/', '='],
                    ['-', '_', ''],
                    base64_encode($str)
        );
    }

    /**
     * Toma un string en base64 y url-safe y lo decodifica.
     * @see https://datatracker.ietf.org/doc/html/rfc7515#appendix-C
     */
    public static function base64UrlDecode(string $encoded): string {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $encoded)); 
    }

    /**
     * Verifica que el JWT es válido para la clave del servidor.
     */
    public static function validateJwt(string $jwt) {
        // separar el token
        $tokenParts = explode('.', $jwt);
        $headerJson = self::base64UrlDecode($tokenParts[0]);
        $payloadJson = self::base64UrlDecode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $header = json_decode($headerJson);
        $payload = json_decode($payloadJson);

        // Verificar expiración (si existe)
        if(isset($payload->exp) && $payload->exp < time())
            throw new JwtExpiredException();

        $secret = env("JWT_SECRET");
        $signature = hash_hmac('sha256', $tokenParts[0].".".$tokenParts[1], $secret, true);
        $base64UrlSignature = self::base64UrlEncode($signature);
        
        // verify it matches the signature provided in the token
        $signatureValid = ($base64UrlSignature === $signatureProvided);

        if (!$signatureValid)
            throw new \Exception();

        return [
            "header" => $header,
            "payload" => $payload
        ];
    }
}
