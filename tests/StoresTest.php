      <?php
      /**
      *@backupGlobals disabled
      *@backupStaticAttributes disabled
      */
      require_once 'src/Stores.php';
      require_once 'src/Brand.php';

      $DB = new PDO('pgsql:host=localhost;dbname=shoe_test');

  class StoreTest extends PHPUnit_Framework_TestCase
      {

      protected function tearDown()
      {

      Store::deleteAll();
      Brand::deleteAll();
      }



  function test_delete_getStores()
      {
      //arrange
      $test_store = new Store("thaishoe");
      $test_store->save();

      $test_brand = new Brand("Golf");
      $test_brand->save();

      $test_brand2 = new Brand("Nice");
      $test_brand2->save();

      $test_store->addBrand($test_brand);
      $test_store->addBrand($test_brand2);



      //act
      $test_store->delete();
      $result = $test_brand->getStores();



      //assert
      $this->assertEquals([], $result);
      }



  function test_addBrand()
      {

      //arrange
      $test_store = new Store("Thai Shoes");
      $test_store->save();

      $test_brand = new Brand("addidas");
      $test_brand->save();

      $test_brand2 = new Brand("nike");
      $test_brand2->save();


      //act
      $test_store->addBrand($test_brand);
      $test_store->addBrand($test_brand2);
      $result = $test_store->getBrands();
      //assert


      $this->assertEquals([$test_brand, $test_brand2], $result);
      }


  function test_delete_getBrands()
      {

      //arrange
      $test_store = new Store("Thai shoe");
      $test_store->save();

      $test_brand = new Brand("Golf");
      $test_brand->save();

      $test_brand2 = new Brand("nic");
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
      $test_store = new Store("new style");
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
      $test_store = new Store("Nice shoes");
      $test_store->save();

      //act
      $test_store->update("golf shoes");
      $result = Store::ById($test_store->getId());

      //assert
      $this->assertEquals("golf shoes", $result->getName());
      }



  function test_update()
      {


      //arrange
      $test_store = new Store("Secret shoes");
      $test_store->save();

      //act
      $test_store->update("we shoes");
      $result = $test_store->getName();


      //assert
      $this->assertEquals("we shoes", $result);
      }


  function test_findByName()
      {

      //arrange
      $test_store = new Store("vancouver shoes");
      $test_store->save();

      $test_store2 = new Store("nice");
      $test_store2->save();

      $test_store3 = new Store("lots ice");
      $test_store3->save();
      
      //act
      $result = Store::findName("nois");

      //assert
      $this->assertEquals([$test_store, $test_store2], $result);
      }



  function test_findById()
      {


      //arrange
      $test_store = new Store("nic shoe");
      $test_store->save();


      //act
      $result = Store::ById($test_store->getId());



      //assert
      $this->assertEquals($test_store, $result);
      }



  function test_save()
      {
      //arrange
      $test_store = new Store("Tb Shoe");


      //act
      $test_store->save();
      $result = Store::getAll();


      //assert
      $this->assertEquals([$test_store], $result);
      }


  function test_setName()
      {

      //arrange
      $test_store = new Store("Tb Shoe", 1);

      //act
      $test_store->setName("shoes one");
      $result = $test_store->getName();


      //assert
      $this->assertEquals("shoes one", $result);
      }



  function test_getName()
      {

      //arrange
      $test_store = new Store("tb Shoes", 1);

      //act
      $result = $test_store->getName();

      //assert
      $this->assertEquals("tb Shoes", $result);
      }



  function test_setId()
      {

      //arrange
      $test_store = new Store("Nice Shoe", 1);

      //act
      $test_store->setId(22);
      $result = $test_store->getId();


      //assert
      $this->assertEquals(22, $result);
      }



  function test_getId()
      {
      //arrange
      $test_store = new Store("Vancouver shoe", 1);

      //act
      $result = $test_store->getId();

      //assert
      $this->assertEquals(1, $result);
      }
  }
      ?>
