<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stores.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_db');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));


    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->post("/stores", function() use ($app) {
      $store_name = new Store($_POST['name']);
      $store_name->deleteAll();
      return $app['twig']->render('stores.html.twig', array('newStore' => Store::getAll()));
    });






    return $app;




 ?>
