<?php declare(strict_types=1);

/**
 * Modelo para tabla post
 */
class Post {

    /** Conexión del modelo a la base de datos */
    protected $db;

    public function __construct(object $db) {
        $this->db = $db;
    }

    public function create(string $title, string $content, string $url): int {

        // created_at y updated_at gestionados automáticamente por db
        $statement = $this->db->prepare("
            INSERT INTO post (title, content, url)
            VALUES (?, ?, ?)
        ");
        $statement->execute([$title, $content, $url]);

        return (int) $this->db->lastInsertId();
            
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM post")->fetchAll(PDO::FETCH_OBJ);
    }

    /** DEvuelve un solo post */
    public function getOne($id) {
        $statement =  $this->db->prepare("SELECT * FROM post where id = (?)");
        $statement->execute([$id]);
        if (!$statement)
            die(print_r($this->db->errorInfo(), true));
        else
            return $statement->fetch(PDO::FETCH_OBJ);
    }
}
