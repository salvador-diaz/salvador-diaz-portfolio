<?php declare(strict_types=1);

require_once "src/View.php";

class HomeController {

    private object $google_auth_service;

    public function __construct(object $googleAuthService) {
        $this->google_auth_service = $googleAuthService;
    }

    public function index() {

        // Crear cliente
        $client = $this->google_auth_service->getClient();

        $view = new View("home", [
            // renderizar botón de acceso
            "authurl" => $client->createAuthUrl()
         ]);
        echo $view->render();
    }
}
