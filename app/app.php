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

    $app->delete('/', function() use ($app) {

        if(!empty($_POST['stores'])) {
            Store::deleteAll();
        }
        else {
            Brand::deleteAll();
        }

        return $app['twig']->render('index.html.twig', array('newStore' => Store::getAll()));
    });


    $app->post("/stores", function() use ($app) {
      $store_name = new Store($_POST['add_store']);
      $store_name->save();
      return $app['twig']->render('index.html.twig', array('newStore' => Store::getAll()));
    });
  return $app;




 ?>
