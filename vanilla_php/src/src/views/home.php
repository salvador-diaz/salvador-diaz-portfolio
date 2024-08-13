<html>
    <head>
        <link rel="icon" type="image/png" href="src/storage/icon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Archivo Narrow font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Archivo+Narrow:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <!-- -->

        <link rel="stylesheet" href="src/views/assets/general.css">
        <link rel="stylesheet" href="src/views/assets/home.css">
        <link rel="stylesheet" href="src/views/assets/buttons.css">
        <link rel="stylesheet" href="src/views/assets/nav.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    </head>
    <body>
        <?php include RUTA_VISTAS."/components/nav.php"; ?>
        <div id="orange-welcome-div">
            <div>
                <img src="src/storage/me.jpg" alt='me' />
            </div>
            <div class='title-and-links'>
                <h1>Salvador Diaz</h1>
                <div>
                    <a href='https://github.com/salvador-diaz' target="_blank" rel="noopener noreferrer">My Github</a>
                    <a href='https://www.linkedin.com/in/salvador-d' target="_blank" rel="noopener noreferrer">My LinkedIn</a>
                </div>
            </div>
        </div>

        <div id="buttons">
            <button id='my-cv-button' class="orange-btn">My Curriculum</button>
            <button id='this-website-button' class="orange-btn">This Website</button>
        </div>

        <div id="home-content-div">
            <div id="cv-div">
                <h2>Experience</h2>

                <div class="section-div">
                    <div>
                        <img src="src/storage/netuy.svg" width='80px' />
                    </div>
                    <div>
                        <p><b>Netuy</b> - Full Stack Developer | Mar. 2023 - present (1 year 3 months)</p>
                            <ul>
                            <li>Created web software solutions involving every step (planning, developing, auditing, deploying, validating).</li>
                            <li>Participated in a broad range of projects (Payment gateway, Whatsapp bot, survey module, file processing, and more).</li>
                            <li>Implemented automated integration testing standard used to date by the company.</li>
                        </ul>
                    </div>
                </div>
                <br />

                <div class="section-div">
                    <div>
                        <img src="src/storage/tcs.png" width='80px' />
                    </div>
                    <div>
                        <p><b>Tata Consultancy Services</b> - IT Technician | Aug. 2022 - Dec. 2022 (5 months)</p>
                        <ul>
                            <li>Provided assistance to Microsoft customers having issues with <i>Dynamics 365 CRM</i>.</li>
                            <li>Worked daily in english with customers and teammates via email and meetings.</li>
                            <li>Constant troubleshooting and teamwork required to come up with a solution to the customers.</li>
                        </ul>
                    </div>
                </div>
                <br />

                <h2>Education</h2>

                <div class="section-div">
                    <div>
                        <img src="src/storage/hb.png" width='80px' height='80px' />
                    </div>
                    <div>
                        <p><b>Holberton School Uruguay</b> - Software engineering bootcamp | Sep. 2021 - Jul. 2022 (10 months)</p>
                        <ul>
                            <li>1st trimester: Git, Linux and Bash, Low level with C language. - github: <a href='https://github.com/salvador-diaz/holbertonschool-low_level_programming' target="_blank" rel="noopener noreferrer">here</a></li>
                            <li>2nd trimester: High level with Python language, OOP, Algorithms. - github: <a href='https://github.com/salvador-diaz/holbertonschool-higher_level_programming' target="_blank" rel="noopener noreferrer">here</a> and <a href='https://github.com/salvador-diaz/sorting_algorithms'>here</a></li>
                            <li>3rd trimester: Web Architecture, final project MVP (stockIT MVP). - github: <a href='https://github.com/salvador-diaz/stockIT' target="_blank" rel="noopener noreferrer">here</a></li>
                        </ul>
                    </div>
                </div>
                <br />

                <div class="section-div">
                    <div>
                        <img src="src/storage/utu.png" width='80px' height='80px' />
                    </div>
                    <div>
                        <p><b>Escuela Superior de Informática</b> - Technical Higschool | 2016 - 2019</p>
                        <ul>
                            <li>Introduction to Programming, OOP, Networks, Basic Linux and Bash, and MySQL</li>
                        </ul>
                    </div>
                </div>
                <br />

                <h2>Projects</h2>

                <h3>This Website :)</h3>
                <p><b>Full Stack Application</b> | May. 2024 | github: <a target="_blank" href='https://github.com/salvador-diaz/salvador-diaz-lamp' target="_blank" rel="noopener noreferrer">here</a></p>
                <p>
                    Portfolio web application implementing the LAMP stack architecture (Linux, Apache2, Mysql, PHP). Deployed on AWS EC2. The project showcases a minimalist, fundamentals view of the MVC pattern.
                    For more information refer to the <i>This Website</i> tab above.
                </p>
                <br />

                <h3>stockIT MVP</h3>
                <p><b>Holberton School final team project</b> | Jul. 2022 | github: <a target="_blank" href='https://github.com/salvador-diaz/stockIT' target="_blank" rel="noopener noreferrer">here</a></p>
                <p>
                    (See my live presentation on youtube <a target="_blank" href="https://www.youtube.com/live/ohsMjuoY3_c?si=ciZ3YYKBxKerMwys&t=4798">here!</a>) In the span of 2 months, our team of four people designed, developed, deployed, and presented a Python Flask web-app that lets users manage their own online inventory, adding and updating products and branches, while also see graphs and charts generated by their data.
                </p>

                <h2>Certifications</h2>
                <div data-iframe-width="350" data-iframe-height="270" data-share-badge-id="a72bb2cc-5aaa-43f5-bcbe-071a5699936c" data-share-badge-host="https://www.credly.com"></div>
                <script type="text/javascript" async src="//cdn.credly.com/assets/utilities/embed.js"></script>
            </div>
            <div id="this-website-div" style="display: none">
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>
    <script type="text/javascript">
        let home_content_div = document.getElementById("home-content-div");

        let my_cv_button = document.getElementById("my-cv-button");
        let cv_div = document.getElementById("cv-div");

        let this_website_button = document.getElementById("this-website-button");
        let this_website_div = document.getElementById("this-website-div");

        getReadme();
        this_website_button.addEventListener("click", changeContent); 
        my_cv_button.addEventListener("click", changeContent);

        /**
         * Obtener README dinámicamente con JS
         */
        async function getReadme() {
            const rawReadmeResponse = await fetch("/README.md")
            const rawReadmeContent = await rawReadmeResponse.text();
            this_website_div.innerHTML = new showdown.Converter().makeHtml(rawReadmeContent);
            hljs.highlightAll();
        }

        function changeContent(e) {
            if (e.target.id === "this-website-button") {
                cv_div.style.display = "none";
                this_website_div.style.display = "block";
            } else {
                cv_div.style.display = "block";
                this_website_div.style.display = "none";
            }
        }

    </script>
</html>
