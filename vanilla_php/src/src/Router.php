<?php declare(strict_types=1);

/**
 * Gestiona las rutas de la aplicación.
 * Va a ser llamado al requerirse cualquier página/url.
 */
class Router {
   
    private $routes = [];

    /**
     * Almacena la acción correspondiente a una petición, puede ser:
     *  - Función correspondiente a ejecutar, o
     *  - El método del controlador a ejecutar.
     *
     *  @param $method : Método de la peticion (GET, POST, ...)
     *  @param $route : Ruta de la peticion (/, /login, ...)
     */
    public function register(string $method, string $route, callable|array $action): self {
        $this->routes[$route][$method] = $action;

        return $this;
    }

    /**
     * Devuelve las rutas registradas en el router
     */
    public function getRoutes(): array {
        return $this->routes;
    }

    /**
     * Ejecuta la funcion o método de controlador correspondiente
     * de la ruta pasada como argumento (si es que existe).
     */
    public function resolve(string $method, string $requestUri) {
        /** "/la/ruta/sacada/del?navegador */
        $route = explode("?", $requestUri)[0];

        $action = $this->routes[$route][$method] ?? null;
        if (!$action) { //TODO: página 404
            //header("Location: /");
            //exit;
            throw new Exception("La ruta no existe");
        }

        // TODO: resolver parámetros dinámicos ej: /posts/1, posts/2 etc

        // es una función
        if (is_callable($action)) {
            return $action();
        }

        // o una [clase, método] (controlador)
        $controller = $action[0];
        $method = $action[1];
        if (class_exists($controller) && method_exists($controller, $method)) {
            $controller = new $controller(new GoogleAuthService);
            return $controller->$method();
        }

        throw new Exception("La ruta no existe");
    }
}
