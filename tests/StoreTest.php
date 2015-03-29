<?php

    /**
      *  @backupGlobals disabled
      *  @backupStaticAttributes disabled
    */

    require_once 'src/Store.php';

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_addBrand()
        {
            //arrange
            $test_store = new Store("Vancouver shoe store");
            $test_store->save();

            $test_brand = new Brand("puma");
            $test_brand->save();
            $test_brand2 = new Brand("addies");
            $test_brand2->save();

            //act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);
            $result = $test_store->getBrands();

            //assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_delete_getStores()
        {
            //arrange
            $test_store = new Store("Vancouver shoe");
            $test_store->save();

            $test_brand = new Brand("hth");
            $test_brand->save();
            $test_brand2 = new Brand("lol");
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //act
            $test_store->delete();
            $result = $test_brand->getStores();

            //assert
            $this->assertEquals([], $result);
        }

        function test_delete_getBrands()
        {
            //arrange
            $test_store = new Store("lovewill");
            $test_store->save();

            $test_brand = new Brand("love");
            $test_brand->save();
            $test_brand2 = new Brand("nie");
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            //act
            $test_store->delete();
            $result = $test_store->getBrands();

            //assert
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            //arrange
            $test_store = new Store("vancouver shoe");
            $test_store->save();

            //act
            $test_store->delete();
            $result = Store::getAll();

            //assert
            $this->assertEquals([], $result);
        }

        function test_update_database()
        {
            //arrange
            $test_store = new Store("Lover golf");
            $test_store->save();

            //act
            $test_store->update("Golf shoe");
            $result = Store::findById($test_store->getId());

            //assert
            $this->assertEquals("Golf shoe", $result->getName());
        }

        function test_update()
        {
            //arrange
            $test_store = new Store("to you");
            $test_store->save();

            //act
            $test_store->update("nice shoe");
            $result = $test_store->getName();

            //assert
            $this->assertEquals("nice shoe", $result);
        }


        function test_findById()
        {
            //arrange
            $test_store = new Store("Vancouver shoe store");
            $test_store->save();

            //act
            $result = Store::findById($test_store->getId());

            //assert
            $this->assertEquals($test_store, $result);
        }

        function test_save()
        {
            //arrange
            $test_store = new Store("tommy shoe");

            //act
            $test_store->save();
            $result = Store::getAll();

            //assert
            $this->assertEquals([$test_store], $result);
        }







        function test_getName()
        {
            //arrange
            $test_store = new Store("what as shoe", 1);

            //act
            $result = $test_store->getName();

            //assert
            $this->assertEquals("what as shoe", $result);
        }


        function test_setName()
        {
            //arrange
            $test_store = new Store("No shoe", 1);

            //act
            $test_store->setName("what as shoe");
            $result = $test_store->getName();

            //assert
            $this->assertEquals("what as shoe", $result);
        }


        function test_findByName()
        {
            //arrange
            $test_store = new Store("vancouver shoe nice");
            $test_store->save();
            $test_store2 = new Store("nice shoe");
            $test_store2->save();
            $test_store3 = new Store("love shoe nice");
            $test_store3->save();

            //act
            $result = Store::findByName("nice");

            //assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }


        function test_setId()
        {
            //arrange
            $test_store = new Store("what as shoe", 1);

            //act
            $test_store->setId(15);
            $result = $test_store->getId();

            //assert
            $this->assertEquals(15, $result);
        }

        function test_getId()
        {
            //arrange
            $test_store = new Store("what as shoe", 1);

            //act
            $result = $test_store->getId();

            //assert
            $this->assertEquals(1, $result);
        }
    }







 ?>
