<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stores.php";
  //  require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');


    class StoresTest extends PHPUnit_Framework_TestCase
    {

      protected function tearDown()
        {
          Stores::deleteAll();

        }


        function test_getName()
        {
            //Arrange
            $name ="Nike_Store";
            $id = null;
            $test_stores = new Stores($name,$id);

            //Act
            $result = $test_stores->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_SetName()
        {
            //Arrange
            $name = "Nike";
            $id = null;
            $test_stores = new Stores($name, $id);
            $new_name = "Golf";
            //Act
            $test_stores->setName($new_name);
            $result = $test_stores->getName();

            //Assert

            $this->assertEquals($new_name, $result);
        }



        function test_GetId()
        {
            //Arrange
            $id = 1;
            $name = "Nikeg";
            $test_stores = new Stores($name, $id);

            //Act
            $result = $test_stores->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_SetId()
        {
          //Arrange
          $id = 2;
          $name = "Nike";
          $test_stores = new Stores($name, $id);



          //act
          $test_stores->setId(2);


          //assert
          $result = $test_stores->getId();
           $this->assertEquals(2,$result);



        }

        function testSave()
        {
            //Arrange
            $name = "Nike";
            $id = 1;
            $test_stores = new Stores($name, $id);

            //Act
             $test_stores->save();

            //Assert
             $result = Stores::getAll();
            $this->assertEquals($test_stores, $result[0]);
        }



        function test_GetAll()
        {
            //Arrange
            $name = "Nike2";
            $id =3;
            $test_stores = new Stores($name, $id);
            $test_stores->save();


            $name2 = "Nikevone";
            $id2 = 2;
            $test_stores2 = new Stores($name2, $id2);
            $test_stores2->save();

            //Act
            $result = Stores::getAll();

            //Assert
            $this->assertEquals([$test_stores, $test_stores2], $result);
        }

        function test_DeleteAll()
        {
            //Arrange
            $name = "vone";
            $id = 1;
            $test_stores = new Stores($name, $id);
            $test_stores->save();

            $name2 = "Nike2";
            $id2 = 2;
            $test_stores2 = new Stores($name2, $id2);
            $test_stores2->save();

            //Act
            stores::deleteAll();

            //Assert
            $result = stores::getAll();
            $this->assertEquals([], $result);
        }





    }
?>
