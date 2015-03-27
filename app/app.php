<?php
require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stores.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_db');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));


    $app->get("/", function() use ($app) {
        return $app['twig']->render('stores.html.twig');
    });

  $app->get("/stores", function() use ($app) {
     return $app['twig']->render('stores.html.twig');

     });


    return $app;




 ?>
