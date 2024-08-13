<nav>
    <ul>
        <li><a id="test" href="/">Home</a></li>
        <li><a href="/posts">Posts</a></li>
        <!-- <li><Link to={'/memes'}>Memes</Link></li> -->
        <!-- <li><Link to={'/my-sites'}>My Sites</Link></li> -->
        <?php
        if (isset($_SESSION["user"])) {
            echo <<<HTML
                <li id="nav-user">
                    <img src="{$_SESSION["user"]->picture}">
                    <span>{$_SESSION["user"]->givenName}</span>
                    <a href='/logout' style="font-size: 1rem">(logout)</a>
                </li>
            HTML;
        } else {
            echo <<<HTML
                    <li>
                    <a class="google-sign-in-button" href="{$this->params["authurl"]}">
                    Sign in with Google
                    </a>
                </li>
            HTML;
        }
        ?>
    </ul>
</nav>
