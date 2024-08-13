<?php declare(strict_types=1);

/**
 * Modelo para tabla user
 */
class User {
    /** Conexión del modelo a la base de datos */
    protected $db;

    public function __construct(object $db) {
        $this->db = $db;
    }

    public function create(
        string $firstname,
        string $lastname,
        string $email,
        string $imageUrl,
        int $verifiedEmail,
        string $googleId,
    ): int {
        $statement = $this->db->prepare("
            INSERT INTO user
                (firstname, lastname, email, img_url, verified_email, google_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $statement->execute(
            [$firstname, $lastname, $email, $imageUrl, $verifiedEmail, $googleId]
        );
        return (int) $this->db->lastInsertId();
    }

    /**
     * Busca un usuario por su email
     * 
     * @return Un objeto con los datos del usuario. o false si no existe
     */
    public function getOne($email): object|bool {
        $statement =  $this->db->prepare("SELECT * FROM user where email = (?)");
        $statement->execute([$email]);
        if (!$statement)
            die(print_r($this->db->errorInfo(), true));
        else
            return $statement->fetch(PDO::FETCH_OBJ);
    }
}
