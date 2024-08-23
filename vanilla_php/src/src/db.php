<?php declare(strict_types=1);

/**
 * Conexión minimalista a la base de datos
 */
class DB {

    /**
     * Devuelve una conexión a la base de datos
     */
    public static function connect(): PDO {
        // Intentar conexión
        try {
            $db = new PDO(
                "mysql:host=mysql_server;dbname=".getenv("MYSQL_DATABASE"),
                getenv("MYSQL_USER"),
                getenv("MYSQL_PASSWORD"),
            );
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        // De no haber errores, devolver la conexión
        return $db;
    }
}
