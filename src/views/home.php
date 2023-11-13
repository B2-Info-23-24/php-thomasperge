<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <?php
  // home.php
  require 'vendor/autoload.php'; // ajustez le chemin en conséquence

  $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/partials'); // ajustez le chemin en conséquence
  $twig = new \Twig\Environment($loader);

  // Affichage de la navbar
  echo $twig->render('navbar.twig'); ?>


<p>eeee</p>
</body>

</html>