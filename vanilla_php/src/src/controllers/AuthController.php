<?php declare(strict_types=1);

require_once "src/View.php";
require_once "src/models/User.php";
require_once __DIR__."/../db.php";

class AuthController {

    private object $google_auth_service;

    public function __construct(object $googleAuthService) {
        $this->google_auth_service = $googleAuthService;
    }

    public function access() {
        $db = DB::connect();
        $user = new User($db);

        if (!isset($_GET['code'])) {
            header("Location: /");
            exit;
        }

        // Crear cliente
        $client = $this->google_auth_service->getClient();

        $user_info = $this->google_auth_service->getUserInfo($_GET['code']);
        if (!empty($user_info->error)) {
            $view = new View("access", [
                "error" => $user_info->error,
                "authurl" => $client->createAuthUrl()
            ]);
            echo $view->render();
            return;
        }

        $db_user = $user->getOne($user_info->email);
        // Si el usario existe
        if ($db_user) {
            echo "Ya existía usuario\n";
        } else {
            echo "No existía usuario\n";
            $createdId = $user->create(
                $user_info->givenName,
                $user_info->familyName,
                $user_info->email,
                $user_info->picture,
                (int) $user_info->verifiedEmail,
                $user_info->id,
            );
        }

        $_SESSION["user"] = $user_info;
        header("Location: /");

    }

    public function logout() {
        if (isset($_SESSION["user"]))
            unset($_SESSION["user"]);
        header("Location: /");
    }
}
