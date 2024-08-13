<?php declare(strict_types=1);
/**
 * Punto de entrada para toda la aplicación
 */

require_once 'vendor/autoload.php';
require_once "src/Router.php";
require_once "src/controllers/HomeController.php";
require_once "src/controllers/MemesController.php";
require_once "src/controllers/AuthController.php";
require_once "src/controllers/PostsController.php";
require_once "src/services/GoogleAuthService.php";


error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();

/** Ruta que contiene todas las vistas de la aplicación */
const RUTA_VISTAS = __DIR__."/src/views";

$router = new Router();
// Registrar rutas
$router
    ->register("GET", "/", ["HomeController", "index"])
    ->register("GET", "/memes", ["MemesController", "index"])
    ->register("GET", "/posts", ["PostsController", "index"])
    ->register("GET", "/post", ["PostsController", "post"])
    ->register("GET", "/access", ["AuthController", "access"])
    ->register("GET", "/logout", ["AuthController", "logout"]);

// Resolver request pedido (ej: "GET" "/posts")
$router->resolve(strtoupper($_SERVER["REQUEST_METHOD"]), $_SERVER["REQUEST_URI"]);

//echo "<pre>".print_r($router->getRoutes(), true)."</pre>";
