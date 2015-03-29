<?php

    /**
      *  @backupGlobals disabled
      *  @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';
    require 'setup.config';

    $DB = new PDO("pgsql:host=localhost;dbname=shoes_test");


    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getOtherStores()
        {
            //arrange
            $test_brand = new Brand("nike");
            $test_brand->save();

            $test_store = new Store("Love shoe");
            $test_store->save();
            $test_store2 = new Store("Vancouver shoe");
            $test_store2->save();

            //act
            $test_brand->addStore($test_store);
            $result = $test_brand->getOtherStores();

            //assert
            $this->assertEquals([$test_store2], $result);
        }

        function test_addStore()
        {
            //arrange
            $test_brand = new Brand("nike");
            $test_brand->save();

            $test_store = new Store("Love shoe");
            $test_store->save();
            $test_store2 = new Store("Vancouver shoe");
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
            $test_brand = new Brand("Asaid");
            $test_brand->save();

            $test_store = new Store("Nkhoe");
            $test_store->save();
            $test_store2 = new Store("Lao shoes");
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
            $test_brand = new Brand("Asaid");
            $test_brand->save();

            $test_store = new Store("Nkhoe");
            $test_store->save();
            $test_store2 = new Store("Lao shoes");
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
            $test_brand = new Brand("shoesbrand");
            $test_brand->save();
            //act
            $test_brand->delete();
            $result = Brand::findById($test_brand->getId());

            //assert
            $this->assertEquals(null, $result);
        }

        function test_update_database()
        {
            //arrange
            $test_brand = new Brand("golf");
            $test_brand->save();

            //act
            $test_brand->update("golf Shoes");
            $result = Brand::findById($test_brand->getId());

            //assert
            $this->assertEquals("golf Shoes", $result->getName());
        }

        function test_update()
        {
            //arrange
            $test_brand = new Brand("vone");
            $test_brand->save();

            //act
            $test_brand->update("vone Shoes");
            $result = $test_brand->getName();

            //assert
            $this->assertEquals("vone Shoes", $result);
        }

        function test_findByName()
        {
            //arrange
            $test_brand = new Brand("love to weat");
            $test_brand->save();
            //act
            $result = Brand::findByName("love");

            //assert
            $this->assertEquals([$test_brand], $result);
        }

        function test_findById()
        {
            //arrange
            $test_brand = new Brand("nike");
            $test_brand->save();
            //act
            $result = Brand::findById($test_brand->getId());

            //assert
            $this->assertEquals($test_brand, $result);
        }

        function test_deleteAll()
        {
            //arrange
            $test_brand = new Brand("addis");
            $test_brand2 = new Brand("puma");

            //act
            $test_brand->save();
            $test_brand2->save();
            Brand::deleteAll();
            $result = Brand::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_save()
        {
            //arrange
            $test_brand = new Brand("puma");

            //act
            $test_brand->save();
            $result = Brand::getAll();

            //assert
            $this->assertEquals([$test_brand], $result);
        }


        function test_getName()
        {
            //arrange
            $test_brand = new Brand("too");

            //act
            $result = $test_brand->getName();

            //assert
            $this->assertEquals("too", $result);
        }

        function test_setName()
        {
            //arrange
            $test_brand = new Brand("vonesds");

            //act
            $test_brand->setName("vone");
            $result = $test_brand->getName();

            //assert
            $this->assertEquals("vone", $result);
        }

        function test_getId()
        {
            //arrange
            $test_brand = new Brand("ww", 1);

            //act
            $result = $test_brand->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $test_brand = new Brand("puma", 1);

            //act
            $test_brand->setId(15);
            $result = $test_brand->getId();

            //assert
            $this->assertEquals(15, $result);
        }
    }



 ?>
