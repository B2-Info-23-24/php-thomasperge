
# Rust-eze  - Vehicle booking

Welcome to Rust-Eze, your destination for simple, hassle-free car hire. Whether you're planning a road trip, a move or a last-minute getaway, Rust-Eze is here to make your life easier.

# Technologies used

- PHP
- MySQL
- Twig/CSS
- Docker

# Installation



To deploy this project run :

#### Clone project
```bash
git clone https://github.com/B2-Info-23-24/php-thomasperge.git
```

#### Create a docker-compose.yml
```bash
version: '3'

services:
  web:
    build: .
    ports:
      - "8080:80"
    volumes:
      - ./src:/var/www/html

  mysql:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: my-secret-pw
      MYSQL_DATABASE: my_database
      MYSQL_USER: my_user
      MYSQL_PASSWORD: my_password
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  db_data:
```

#### Create a Dockerfile
```bash
FROM php:8.0-apache

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite
RUN service apache2 restart
```

#### Create a .htaccess
```bash
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php [QSA,L]
```

### Start Docker
```bash
sudo service docker start
```

### Get your ip adress
```bash
ip addr show eth0
```

### Put all authorization on you src folder
```bash
sudo chmod 777 -R src
```

### Create a composer.json in your vendor folder (if composer.json doesn't not exist)
```bash
{
    "require": {
        "twig/twig": "^3.8",
        "ramsey/uuid": "4.2.0",
        "fzaninotto/faker": "^1.5"
    }
}

```

### Install all depencies (in src folder)
```bash
composer install
```

The project should run on your locahost

Thomas Kauffmant

