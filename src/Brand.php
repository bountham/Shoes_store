<?php
class Brand
  {
        private $id;
        private $name;
    function __construct($new_name, $new_id = null)
        {
        $this->name = $new_name;
        $this->id = $new_id;
        }

//SETTERS
    function setId($new_id)
        {
        $this->id = (int) $new_id;
        }
    function setName($new_name)
        {
        $this->name = $new_name;
        }

//GETTERS
    function getId()
        {
         return $this->id;
        }
    function getName()
        {
        return $this->name;
        }

    function save()
        {
          $statement = $GLOBALS['DB']->query("INSERT INTO brands (name) VALUES ('{$this->getName()}') RETURNING id;");
          $id_row = $statement->fetch(PDO::FETCH_ASSOC);
          $this->setId($id_row['id']);
        }
    function delete()
        {
          $GLOBALS['DB']->exec("DELETE FROM brands * WHERE id = {$this->getId()};");
          $GLOBALS['DB']->exec("DELETE FROM brands_stores * WHERE brand_id = {$this->getId()};");
        }


        function getStores()
            {
            //use a join statement to get all the stores associated with this brand
            $statement = $GLOBALS['DB']->query("SELECT stores.* FROM brands
            JOIN brands_stores ON (brands.id = brands_stores.brand_id)
            JOIN stores ON(stores.id = brands_stores.store_id)
            WHERE brands.id = {$this->getId()};");
            $store_rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            $stores = array();
            foreach($store_rows as $row)
            {
            $id = $row['id'];
            $name = $row['name'];
            array_push($stores, new Store($name, $id));
            }
            return $stores;
            }

        function addStore($store)
        {
        $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        //STATIC FUNCTIONS
    static function getAll()
        {
        $statement = $GLOBALS['DB']->query("SELECT * FROM brands;");
        $brand_rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $brands = array();
        foreach($brand_rows as $row)
        {
        $id = $row['id'];
        $name = $row['name'];
        $new_brand = new Brand($name, $id);
        array_push($brands, $new_brand);
        }
        return $brands;
        }
    static function deleteAll()
        {
        //delete all brands
        $GLOBALS['DB']->exec("DELETE FROM brands *;");
        //delete all store associations
        $GLOBALS['DB']->exec("DELETE FROM brands_stores *;");
        }
    static function findById($search_id)
        {
        //save database information to statement
        $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$search_id};");
        //id is unique so we only find one row
        $brand_row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $found_brand = null; //in case no rows match
        foreach($brand_row as $row)
        {
        //grab the only row out of the returned array
        //and turn the data into our actual found object
        $id = $row['id'];
        $name = $row['name'];
        $found_brand = new Brand($name, $id);
        }
        return $found_brand;
        }
    static function findName($search_name)
        {
        $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE name LIKE '%{$search_name}%';");
        $brand_rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $brands = array();
        foreach($brand_rows as $row)
        {
        $id = $row['id'];
        $name = $row['name'];
        array_push($brands, new Brand($name, $id));
        }
        return $brands;
        }
 }
