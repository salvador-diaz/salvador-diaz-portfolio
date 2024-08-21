<?php declare(strict_types=1);
/**
 * Conexión minimalista a la base de datos
 */

// Variables sensibles
require_once __DIR__."/../env.php";

class DB {

    /**
     * Devuelve una conexión a la base de datos
     */
    public static function connect(): PDO {
        // Intentar conexión
        try {
            $db = new PDO(
                "mysql:host=mysql_server;dbname=".$_ENV["MYSQL_DATABASE"],
                $_ENV["MYSQL_USER"],
                $_ENV["MYSQL_PASSWORD"],
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        // De no haber errores, devolver la conexión
        return $db;
    }
}
