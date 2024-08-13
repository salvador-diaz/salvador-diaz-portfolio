# 📙 Portfolio Website
Portfolio web application implementing the LAMP stack architecture (Linux, Apache2, Mysql, PHP). Deployed on AWS EC2.
The project showcases a minimalist, fundamentals view of the MVC pattern.

# Project structure
```
salvador-diaz-lamp
 ├── README.md
 ├── composer.json
 ├── composer.lock
 ├── env.php                # Sensitive variables.
 ├── env.php.example        # Overview of sensitive variables.
 ├── index.php              # Entry point to the entire application.
 ├── .htaccess              # Web server rules applied at runtime.
 └── src                    # Source code folder.
      ├── Router.php        # Establishes the available routes and request methods.
      ├── View.php          # Estbalishes rendering logic.
      ├── controllers       # Gets request from router, applies business logic and optionally renders a view.
      │     └── ...
      ├── db.php            # Establishes the database connection.
      ├── models            # Interaction with the database tables.
      │     └── ...
      ├── services          # Apply repetitive business logic not specific to a controller.
      │     └── ...
      ├── storage           # Holds files and images.
      │     └── ...
      ├── utils             # Apply generic and repetitive logic (eg: date formatting).
      ├── vendor            # Hold dependencie's source code.
      │     └── ...
      └── views             # Rendering content.
           ├── assets       # CSS and JS files.
           │    └── ...
           ├── components   # Reusable portions of content for views (eg: the navbar).
           │    └── ...
           └── ...
```

# Deployment
Current deployment consists of an EC2 Ubuntu instance located on the `sa-east-1` region.  
Ports 22, 80, and 443 are open.  

General overview for a fresh instance deploy. Restricted. Not all deployment steps are listed (eg: certificate issuing with certbot).
```bash
sudo apt update # update server binaries
sudo apt install apache2 -y # install web server
sudo a2enmod headers # enable RequestHeader directives module
sudo a2enmod ssl # enable ssl directives module
sudo a2enmod rewrite # enable rewrite directives module
# define `DocumentRoot  /var/www/salvador-diaz-lamp` in /etc/apache2/sites-available/000-default.conf
# also define `AllowOverride All` to enable .htaccess files
sudo service apache2 restart
cd /var/www
sudo git clone https://github.com/salvador-diaz/salvador-diaz-lamp
cd salvador-diaz-lamp
cp env.php.example env.php # on later steps, fill database an Gooogle API env variables
sudo apt intall php -y
sudo apt install php-pdo php-mysql -y # database connector module
sudo apt install certbot -y # SSL certificate issuing
sudo apt install mysql-server -y # on later steps, pass a database dump with the tables
sudo mysql -e "ALTER USER '<DB_USER>'@'<DB_USER>' IDENTIFIED WITH mysql_native_password BY '<DB_PASS>';" # db access for the app
sudo apt install composer -y # project dependency manager. For latest see: https://getcomposer.org/download/
sudo composer install # install project dependencies
yes
```

# 📋 Notes
