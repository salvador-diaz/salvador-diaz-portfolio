<html>
    <head>
        <link rel="stylesheet" href="src/views/assets/general.css">
        <link rel="stylesheet" href="src/views/assets/home.css">
        <link rel="stylesheet" href="src/views/assets/buttons.css">
        <link rel="stylesheet" href="src/views/assets/nav.css">

        <link rel="icon" type="image/png" href="src/storage/icon.png">

        <!-- Archivo Narrow font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- -->
    </head>
    <body>
        <?php
            include RUTA_VISTAS."/components/nav.php";
            
            if (isset($this->params["error"]))
                echo "<p>".$this->params["error"]."</p>";
        ?>
    </body>
</html>
