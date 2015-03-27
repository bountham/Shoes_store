<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */
    require_once 'src/Brand.php';

    $DB = new PDO("pgsql:host=localhost;dbname=shoe_test;");
    class BrandTest extends PHPUnit_Framework_TestCase
    {
    protected function tearDown()
    {
    Brand::deleteAll();
    Store::deleteAll();
    }
    function test_addStore()
    {
    //arrange
    $test_store = new Store("louness shoe");
    $test_store->save();

    $test_brand = new Brand("Nike");
    $test_brand->save();

    $test_store2 = new Store("VancouverShoes");
    $test_store2->save();

    //act
    $test_brand->addStore($test_store);

    $test_brand->addStore($test_store2);

    $result = $test_brand->getStores();

    //assert
    $this->assertEquals([$test_store, $test_store2], $result);
    }


  function test_delete_getStores()
    {
    //arrange
    $test_brand = new Brand("nice");
    $test_brand->save();


    $test_store = new Store("tbountham");
    $test_store->save();


    $test_store2 = new Store("lovel shoe");
    $test_store2->save();


    $test_brand->addStore($test_store);
    $test_brand->addStore($test_store2);


    //act
    $test_brand->delete();
    $result = $test_brand->getStores();


    //assert
    $this->assertEquals([], $result);
    }


    function test_delete_getBrands()
    {


    //arrange
    $test_brand = new Brand("nice");
    $test_brand->save();


    $test_store = new Store("bountham");
    $test_store->save();


    $test_store2 = new Store("Vancouver shoe");
    $test_store2->save();


    $test_brand->addStore($test_store);
    $test_brand->addStore($test_store2);


    //act
    $test_brand->delete();
    $result = $test_store->getBrands();


    //assert
    $this->assertEquals([], $result);


    }

    function test_delete()
    {

    //arrange
    $test_brand = new Brand("nice");
    $test_brand->save();

    //act
    $test_brand->delete();
    $result = Brand::findById($test_brand->getId());

    //assert
    $this->assertEquals(null, $result);

    }

    function test_findByName()
    {

    //arrange
    $test_brand = new Brand("what a shoe");
    $test_brand->save();

    //act
    $result = Brand::findName("nice");

    //assert
    $this->assertEquals([$test_brand], $result);

    }

    function test_findById()
    {
    //arrange
    $test_brand = new Brand("Nike");
    $test_brand->save();

    //act
    $result = Brand::findById($test_brand->getId());

    //assert
    $this->assertEquals($test_brand, $result);
    }

    function test_deleteAll()
    {

    //arrange
    $test_brand = new Brand("Addidas");
    $test_brand->save();
    $test_brand2 = new Brand("New_ba");
    $test_brand2->save();

    //act
    Brand::deleteAll();
    $result = Brand::getAll();

    //assert
    $this->assertEquals([], $result);

    }

    function test_save()
    {

    //arrange
    $test_brand = new Brand("convert");
    $test_brand->save();

    //act
    $result = Brand::getAll();

    //assert
    $this->assertEquals([$test_brand], $result);

    }

    function test_getId()
    {

    //arrange
    $test_brand = new Brand("Nike", 1);

    //act
    $result = $test_brand->getId();

    //assert
    $this->assertEquals(1, $result);
    }


    function test_getName()
    {

    //arrange
    $test_brand = new Brand("Convert");

    //act
    $result = $test_brand->getName();

    //assert
    $this->assertEquals("Convert", $result);

    }

    function test_setName()
    {

    //arrange
    $test_brand = new Brand("vone");

    //act
    $test_brand->setName("vone");
    $result = $test_brand->getName();

    //assert
    $this->assertEquals("vone", $result);

    }



    function test_setId()
    {
    //arrange
    $test_brand = new Brand("Nike", 1);

    //act
    $test_brand->setId(33);
    $result = $test_brand->getId();

    //assert
    $this->assertEquals(33, $result);
    }
}
?>
