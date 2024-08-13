<html>
    <head>
        <link rel="icon" type="image/png" href="src/storage/icon.png">
        <!-- Archivo Narrow font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- -->

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="src/views/assets/general.css">
        <link rel="stylesheet" href="src/views/assets/buttons.css">
        <link rel="stylesheet" href="src/views/assets/nav.css">
        <link rel="stylesheet" href="src/views/assets/post.css">
    </head>
    <body>
        <?php include RUTA_VISTAS."/components/nav.php"; ?>
        <div id="page-content-div">
            <h1><?= $this->params["post"]->title ?></h1>
            <?php
                if (!empty($this->params["post"]->url))
                    echo "<a target='_blank' href='{$this->params["post"]->url}'>See original article</a>";
                echo "<p style='white-space: pre-line'>{$this->params["post"]->content}</p>";
            ?>
        </div>
    </body>
</html>
