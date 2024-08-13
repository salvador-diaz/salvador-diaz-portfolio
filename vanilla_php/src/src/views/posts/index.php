<html>
    <head>
        <link rel="icon" type="/image/png" href="src/storage/icon.png">
        <!-- Archivo Narrow font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="/src/views/assets/general.css">
        <link rel="stylesheet" href="/src/views/assets/buttons.css">
        <link rel="stylesheet" href="/src/views/assets/nav.css">
        <link rel="stylesheet" href="/src/views/assets/posts.css">
    </head>
    <body>
        <?php include RUTA_VISTAS."/components/nav.php"; ?>
        <div id="page-content-div">
            <h1>Posts</h1>
            <div id="posts-div">
            <?php
               foreach ($this->params["posts"] as $post) { 
                    if (strlen($post->content) > 80)
                        $post->content = (substr($post->content, 0, 80)." ...");
                    echo "<div class='post' onclick='window.location.href = \"/post?id=$post->id\"'>
                        <h3><b>$post->title</b></h3>
                        <p>$post->content</p>
                    </div>";
                }
            ?>
            </div>
        </div>
    </body>
</html>
