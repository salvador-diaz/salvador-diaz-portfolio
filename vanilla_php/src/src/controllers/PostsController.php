<?php declare(strict_types=1);

require_once "src/View.php";
require_once "src//models/Post.php";
require_once __DIR__."/../db.php";

/**
 * Controlador para funciones de posts
 */
class PostsController {
    
    private object $google_auth_service;

    public function __construct(object $googleAuthService) {
        $this->google_auth_service = $googleAuthService;
    }

    public function index() {
        $client = $this->google_auth_service->getClient();

        $db = DB::connect();
        $post = new Post($db);

        $posts = $post->getAll();
        
        $view = new View("posts/index", [
            "posts" => $posts,
            "authurl" => $client->createAuthUrl()
        ]);
        echo $view->render();
    }

    public function post() {
        $client = $this->google_auth_service->getClient();

        $db = DB::connect();
        $post = new Post($db);

        $post = $post->getOne($_GET["id"]);
        
        $view = new View("posts/post", [
            "post" => $post,
            "authurl" => $client->createAuthUrl()
        ]);
        echo $view->render();
    }
}
