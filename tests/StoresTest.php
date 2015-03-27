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

        function testSetName()
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

            $this->assertEquals("Golf", $result);
        }



        function testGetId()
        {
            //Arrange
            $id = 1;
            $name = "Wash the dog";
            $test_stores = new Stores($name, $id);

            //Act
            $result = $test_stores->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        // function testSave()
        // {
        //     //Arrange
        //     $description = "Wash the dog";
        //     $id = 1;
        //     $test_task = new Stores($description, $id);
        //
        //     //Act
        //     $test_task->save();
        //
        //     //Assert
        //     $result = Stores::getAll();
        //     $this->assertEquals($test_task, $result[0]);
        // }



    }
?>
