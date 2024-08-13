<?php declare(strict_types=1);

class View {

    /** ruta al archivo de la vista dentro del directorio RUTA_VISTAS */
    public string $view;
    /** parámetros para la vista */
    public array $params;

    public function __construct(string $view, array $params=[]) {
        $this->view = $view;
        $this->params = $params;
    }

    /**
     * Devuelve el contenido a renderizar como string.
     */
    public function render(): string {
        // Crea un buffer de output
        ob_start();

        if (!file_exists(RUTA_VISTAS."/".$this->view.".php")) {
            // echo RUTA_VISTAS."/".$this->view.".php\n";
            //throw new Exception("vista no encontrada");
            header("Location: /");
        }

        include RUTA_VISTAS."/".$this->view.".php";

        // Devuelve el contenido del buffer como string
        return (string)ob_get_clean();
    }
}
