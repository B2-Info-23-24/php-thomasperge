<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Faker\Factory as FakerFactory;
use Ramsey\Uuid\Uuid;

class DefaultTableManager
{
  private $conn;
  private $faker;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->faker = FakerFactory::create();
  }

  public function generateUUID16()
  {
    $uuid = Uuid::uuid4();
    $uuid16 = str_replace('-', '', $uuid->toString());
    return substr($uuid16, 0, 16);
  }

  public function createDefaultTables()
  {
    // Booking
    $queryBooking = "
      CREATE TABLE IF NOT EXISTS `booking` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `id_vehicle` int(11) NOT NULL,
        `id_user` int(11) NOT NULL,
        `start_date` datetime NOT NULL,
        `end_date` datetime NOT NULL,
        `price` int(11) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
    ";

    $this->executeQuery($queryBooking);

    // Brands
    $queryBrands = "
      CREATE TABLE
      `brands` (
        `id` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `brand` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryBrands);

    // Color
    $queryColors = "
      CREATE TABLE
      `colors` (
        `id` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `color` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryColors);

    // Favorite
    $queryFavorite = "
      CREATE TABLE
      `favorite` (
        `id` varchar(255) NOT NULL,
        `id_vehicle` varchar(255) NOT NULL,
        `id_user` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryFavorite);

    // Garage
    $queryGarage = "
      CREATE TABLE
      `favorite` (
        `id` varchar(255) NOT NULL,
        `id_vehicle` varchar(255) NOT NULL,
        `id_user` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryGarage);

    // Rating
    $queryRating = "
      CREATE TABLE
      `rating` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `id_user` varchar(255) NOT NULL,
        `id_vehicle` varchar(255) NOT NULL,
        `rating` int(11) NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryRating);

    // Users
    $queryUsers = "
      CREATE TABLE
      `users` (
        `id` varchar(255) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `firstname` varchar(255) NOT NULL,
        `lastname` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `phone` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `is_garage_owner` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryUsers);

    // Vehicle
    $queryVehicle = "
      CREATE TABLE
      `vehicle` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `id_garage` varchar(255) NOT NULL,
        `brand` varchar(255) NOT NULL,
        `model` varchar(255) NOT NULL,
        `price` int(11) NOT NULL,
        `url_picture` varchar(255) NOT NULL,
        `petrol` varchar(255) NOT NULL,
        `nb_seats` int(11) NOT NULL,
        `colors` varchar(255) NOT NULL,
        `gearbox` varchar(255) NOT NULL,
        `brand_logo` varchar(255) NOT NULL,
        `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `information` text,
        PRIMARY KEY (`id`)
      ) ENGINE = InnoDB AUTO_INCREMENT = 28 DEFAULT CHARSET = latin1
    ";

    $this->executeQuery($queryVehicle);
  }

  public function createDefaultInsert()
  {
    $checkQuery = "SELECT COUNT(*) as count FROM `vehicle`";
    $result = $this->conn->query($checkQuery);
    $rowCount = $result->fetch_assoc()['count'];

    $faker = Faker\Factory::create();

    if ($rowCount == 0) {
      $allVehicle = [
        [
          'brand' => 'Ferrari',
          'brand_logo' => 'public/assets/svg/ferrari.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '496',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/ferrari1.png',
        ],
        [
          'brand' => 'Ferrari',
          'brand_logo' => 'public/assets/svg/ferrari.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Superfast',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/ferrari2.png',
        ],
        [
          'brand' => 'Ferrari',
          'brand_logo' => 'public/assets/svg/ferrari.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Roma',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/ferrari3.png',
        ],
        [
          'brand' => 'Ferrari',
          'brand_logo' => 'public/assets/svg/ferrari.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '496',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/ferrari4.png',
        ],
        [
          'brand' => 'Ferrari',
          'brand_logo' => 'public/assets/svg/ferrari.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'SF-18',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/ferrari5.png',
        ],
        [
          'brand' => 'McLaren',
          'brand_logo' => 'public/assets/svg/mclaren.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '\"LT\" Longtail',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/mclaren1.png',
        ],
        [
          'brand' => 'Nissan',
          'brand_logo' => 'public/assets/svg/nissan.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Gtr',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/nissan3.png',
        ],
        [
          'brand' => 'Nissan',
          'brand_logo' => 'public/assets/svg/nissan.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Note',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/nissan2.png',
        ],
        [
          'brand' => 'Nissan',
          'brand_logo' => 'public/assets/svg/nissan.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'SuperCahrger',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/nissan1.png',
        ],
        [
          'brand' => 'Peugeot',
          'brand_logo' => 'public/assets/svg/peugeot.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '308',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/peugeot1.png',
        ],
        [
          'brand' => 'Peugeot',
          'brand_logo' => 'public/assets/svg/peugeot.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '508',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/peugeot2.png',
        ],
        [
          'brand' => 'Peugeot',
          'brand_logo' => 'public/assets/svg/peugeot.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '407',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/peugeot3.png',
        ],
        [
          'brand' => 'Porsche',
          'brand_logo' => 'public/assets/svg/porsche.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => '911 Carrera',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/porsche2.png',
        ],
        [
          'brand' => 'Porsche',
          'brand_logo' => 'public/assets/svg/porsche.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Gt3 Rs',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/porsche1.png',
        ],
        [
          'brand' => 'Renault',
          'brand_logo' => 'public/assets/svg/renault.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Clio',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/renault3.png',
        ],
        [
          'brand' => 'Renault',
          'brand_logo' => 'public/assets/svg/renault.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Kangoo',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/renault2.png',
        ],
        [
          'brand' => 'Renault',
          'brand_logo' => 'public/assets/svg/renault.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Trophy R',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/renault1.png',
        ],
        [
          'brand' => 'Tesla',
          'brand_logo' => 'public/assets/svg/tesla.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Model S',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/tesla1.png',
        ],
        [
          'brand' => 'Tesla',
          'brand_logo' => 'public/assets/svg/tesla.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Model A',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/tesla2.png',
        ],
        [
          'brand' => 'Volvo',
          'brand_logo' => 'public/assets/svg/volvo.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'W19',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvo1.png',
        ],
        [
          'brand' => 'Volvo',
          'brand_logo' => 'public/assets/svg/volvo.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'W14',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvo2.png',
        ],
        [
          'brand' => 'Volvo',
          'brand_logo' => 'public/assets/svg/volvo.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Model 15',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvo3.png',
        ],
        [
          'brand' => 'Volvwagen',
          'brand_logo' => 'public/assets/svg/volvwagen.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Golf 7',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvwagen1.png',
        ],
        [
          'brand' => 'Volvwagen',
          'brand_logo' => 'public/assets/svg/volvwagen.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Polo 2017',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvwagen2.png',
        ],
        [
          'brand' => 'Volvwagen',
          'brand_logo' => 'public/assets/svg/volvwagen.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'Golf 8',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/volvwagen3.png',
        ],
        [
          'brand' => 'Rust-eze',
          'brand_logo' => 'public/assets/svg/rusteze.svg',
          'colors' => $faker->randomElement(['red', 'blue', 'green', 'yellow', 'black', 'white']),
          'create_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
          'gearbox' => $faker->randomElement(['Manual', 'Automatic']),
          'id_garage' => '554532111ae342ba',
          'information' => $faker->words($nb = 6, $asText = true),
          'model' => 'FlashMcqueen',
          'nb_seats' => $faker->numberBetween(1, 9),
          'petrol' => $faker->randomElement(['Diesel', 'Gasoline', 'Ethanol']),
          'price' => $faker->numberBetween(50, 2500),
          'url_picture' => 'public/assets/car-model/mcqueen.png',
        ],
      ];

      foreach ($allVehicle as $vehicleData) {
        $brand = $vehicleData['brand'];
        $brandLogo = $vehicleData['brand_logo'];
        $colors = $vehicleData['colors'];
        $createdAt = $vehicleData['create_at'];
        $gearbox = $vehicleData['gearbox'];
        $idGarage = $vehicleData['id_garage'];
        $information = $vehicleData['information'];
        $model = $vehicleData['model'];
        $nbSeats = $vehicleData['nb_seats'];
        $petrol = $vehicleData['petrol'];
        $price = $vehicleData['price'];
        $urlPicture = $vehicleData['url_picture'];

        $sql = "INSERT INTO `vehicle` (`brand`, `brand_logo`, `colors`, `create_at`, `gearbox`, `id_garage`, `information`, `model`, `nb_seats`, `petrol`, `price`, `url_picture`) 
                VALUES ('$brand', '$brandLogo', '$colors', '$createdAt', '$gearbox', '$idGarage', '$information', '$model', $nbSeats, '$petrol', $price, '$urlPicture')";

        if ($this->conn->query($sql) !== TRUE) {
          echo "Erreur lors de l'insertion : " . $this->conn->error;
        }
      }
    }
  }

  public function createDefaultUser()
  {
    $checkQuery = "SELECT COUNT(*) as count FROM `users` WHERE `email` IN ('user@gmail.com', 'admin@gmail.com')";
    $result = $this->conn->query($checkQuery);
    $rowCount = $result->fetch_assoc()['count'];

    if ($rowCount == 0) {
      $sql = "INSERT INTO `users` (`created_at`, `email`, `firstname`, `id`, `is_garage_owner`, `lastname`, `password`, `phone`) VALUES 
        ('2023-11-23 16:14:36', 'user@gmail.com', 'user', '8128907ad81345ef', 0, 'user', '$2y$10\$JeGNlgedenDlhXaw2cso1O./mzNOqbb8I9VbjDof1ktHHjE3I3Cn6', '007'),
         
        ('2023-11-24 13:12:58', 'admin@gmail.com', 'admin', 'bb644479943345e2', 1, 'admin', '$2y$10$/gvWrFvD3xcapHMpXhGgK.YwMm/0WnV3BUOXTKTKLrjRQhro6tFgi', '007')";

      $this->conn->query($sql);
    }
  }

  public function createDefaultGarage()
  {
    $checkQuery = "SELECT COUNT(*) as count FROM `garage`";
    $result = $this->conn->query($checkQuery);
    $rowCount = $result->fetch_assoc()['count'];

    if ($rowCount == 0) {
      $sql = "INSERT INTO `garage` (`adress`, `created_at`, `id`, `id_owner`, `name`) VALUES
        ('admin', '2023-11-23 16:00:27', '554532111ae342ba', 'bb644479943345e2', 'admin')";

      $this->conn->query($sql);
    }
  }

  public function createDefaultColors()
  {
    $checkQuery = "SELECT COUNT(*) as count FROM `colors`";
    $result = $this->conn->query($checkQuery);
    $rowCount = $result->fetch_assoc()['count'];

    if ($rowCount == 0) {
      $sql = "INSERT INTO `colors` (`color`, `created_at`, `id`) VALUES
        ('green', '2023-12-04 10:11:55', 'i9j0k1l2m3n4o5p6'),
        ('black', '2023-12-04 10:11:55', '559faf6b415944fe'),
        ('red', '2023-12-01 11:02:11', '94e0d5bc937e4c53'),
        ('blue', '2023-12-01 11:02:11', '94e9d5bc937e4c57'),
        ('white', '2023-12-04 10:11:55', 'a1b2c3d4e5f6g7h8')";

      $this->conn->query($sql);
    }
  }

  public function createDefaultBrands()
  {
    $checkQuery = "SELECT COUNT(*) as count FROM `brands`";
    $result = $this->conn->query($checkQuery);
    $rowCount = $result->fetch_assoc()['count'];

    if ($rowCount == 0) {
      $sql = "INSERT INTO `brands` (`brand`, `created_at`, `id`) VALUES 
        ('tesla', '2023-12-04 10:11:55', 'd6e7f8g9h0i1j2k3'),
        ('renault', '2023-12-04 10:11:55', 'G3H4I5J6K7L8M9N0'),
        ('volvo', '2023-12-04 10:11:55', 'l4m5n6o7p8q9r0s1'),
        ('porsche', '2023-12-04 10:11:55', 'O1P2Q3R4S5T6U7V8'),
        ('ferrari', '2023-12-04 10:11:55', 'q7r8s9t0u1v2w3x4'),
        ('nissan', '2023-12-04 10:11:55', 't2u3v4w5x6y7z8A9'),
        ('mclaren', '2023-12-04 10:11:55', 'W9X0Y1Z2a3b4c5'),
        ('peugeot', '2023-12-04 10:11:55', 'y5z6A7B8C9D0E1F2')";

      $this->conn->query($sql);
    }
  }

  private function executeQuery($query)
  {
    $this->conn->query($query);
  }
}
