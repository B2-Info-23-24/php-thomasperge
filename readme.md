
# ⛽ Rust-eze  - Vehicle booking

Welcome to Rust-Eze, your destination for simple, hassle-free car hire. Whether you're planning a road trip, a move or a last-minute getaway, Rust-Eze is here to make your life easier.

## Technologies used

- PHP
- MySQL
- Twig/CSS
- Docker

## User & Admin (Signin)
user: ``user@gmail.com`` \
password: ``user``

admin: ``admin@gmail.com`` \
password: ``admin``

## Installation



To deploy this project run :

#### Clone project
```bash
git clone https://github.com/B2-Info-23-24/php-thomasperge.git
```

#### Create a docker-compose.yml (if not exists)
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

#### Create a Dockerfile (if not exists)
```bash
FROM php:8.0-apache

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN a2enmod rewrite
RUN service apache2 restart
```

#### Create a .htaccess (in src folder, if not exists)
```bash
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php [QSA,L]
```

### Create a composer.json in your src/vendor folder (if composer.json does not exist)
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
cd src
composer install
```

### Build Docker
```bash
docker-compose up --build
```

### MVC architecture

![App Screenshot](https://cdn.discordapp.com/attachments/1085669963605491753/1182387825925169254/image.png?ex=65848379&is=65720e79&hm=b3e202b391f102ab35db0fc729d38da53c1125ac8bedcc09622c17c4d87fb5e4&)

The project should run on your locahost

Thomas Kauffmant
