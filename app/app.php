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
        return $app['twig']->render('index.html.twig', array('newBrand' => Brand::getAll(),'newStore' => Store::getAll()));
    });


    $app->post("/stores", function() use ($app) {
      $store_name = new Store($_POST['add_store']);
      $store_name->save();
      return $app['twig']->render('index.html.twig', array('newBrand' => Brand::getAll(),'newStore' => Store::getAll()));
      });

        $app->post("/brands", function() use ($app) {
          $store_brand = new Brand($_POST['add_brand']);
          $store_brand->save();
          return $app['twig']->render('index.html.twig', array('newBrand' => Brand::getAll(),'newStore' => Store::getAll()));
        });
  return $app;




 ?>
