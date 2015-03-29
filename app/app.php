<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Store.php';
    require_once __DIR__.'/../src/Brand.php';

    $DB = new PDO("pgsql:host=localhost;dbname=shoes_db");

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
    });

    $app->delete('/', function() use ($app) {

        if(!empty($_POST['stores'])) {
            Store::deleteAll();
        }
        else {
            Brand::deleteAll();
        }

        return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
    });

        //stores
        $app->get('/stores', function() use ($app) {

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });

        $app->post('/stores', function() use ($app) {

            $name = $_POST['add_store'];
            $new_store = new Store($name);
            $new_store->save();

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });


        $app->delete('/stores', function() use ($app) {
            $store = Store::findById($_POST['delete_store']);
            $store->delete();

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });


        $app->get('/brands', function() use ($app) {

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });

        $app->post('/brands', function() use($app) {

            $name = $_POST['add_brand'];
            $new_brand = new Brand($name);
            $new_brand->save();

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });

        //single brand deletion
        $app->delete('/brands', function() use ($app) {
            $brand = Brand::findById($_POST['delete_brand']);
            $brand->delete();

            return $app['twig']->render('index.twig', array('new_store' => Store::getAll(), 'new_brand' => Brand::getAll()));
        });


    $app->get('/stores/{id}', function($id) use ($app) {
        $store = Store::findById($id);

        return $app['twig']->render('store.twig', array('store' => $store, 'new_brand' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->post('/stores/{id}', function($id) use ($app) {
        $store = Store::findById($id);
        $brand = Brand::findById($_POST['store_brand']);
        $store->addBrand($brand);

        return $app['twig']->render('store.twig', array('store' => $store, 'new_brand' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->patch('/stores/{id}', function($id) use ($app) {
        $store = Store::findById($id);
        $store->update($_POST['edit_store']);

        return $app['twig']->render('store.twig', array('store' => $store, 'new_brand' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    //SINGLE BRAND ROUTES
    $app->get('/brands/{id}', function($id) use ($app) {
        $brand = Brand::findById($id);

        return $app['twig']->render('brand.twig', array('brand' => $brand, 'new_store' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->post('/brands/{id}', function($id) use ($app) {
        $brand = Brand::findById($id);
        $store = Store::findById($_POST['brand_store']);
        $brand->addStore($brand);

        return $app['twig']->render('brand.twig', array('brand' => $brand, 'new_store' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->patch('/brands/{id}', function($id) use ($app) {
        $brand = Brand::findById($id);
        $brand->update($_POST['edit_brand']);

        return $app['twig']->render('brand.twig', array('brand' => $brand, 'new_store' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });



    return $app;
 ?>
