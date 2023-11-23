<?php
require 'vendor/autoload.php';

class RenderManager
{
    private $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
        ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function render($template, $variables = [])
    {
        $currentRoute = $_SERVER['REQUEST_URI'];
        $variables['currentRoute'] = $currentRoute;

        echo $this->twig->render($template, $variables);
    }
}
