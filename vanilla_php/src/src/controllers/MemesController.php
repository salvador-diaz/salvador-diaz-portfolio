<?php declare(strict_types=1);

require_once __DIR__."/../db.php";

class MemesController {

    public function index() {
        $db = DB::connect();

        $query = $db->query('SELECT * FROM test');
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        echo "
            <h1>Memes</h1>
        ";
        print_r($result);
    }
}
