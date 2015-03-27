<?php
class Store
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

          $this->name = (string) $new_name;

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

      $returns_store = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
      $result = $returns_store->fetch(PDO::FETCH_ASSOC);
      $this->setId($result['id']);
      }


    function update($new_name)
      {

      $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setName($new_name);
      }



    function addBrand($brand)
      {

      $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ('{$brand->getId()}', '{$this->getId()}');");
      }


    function delete()

      {


      $GLOBALS['DB']->exec("DELETE FROM stores * WHERE id = {$this->getId()};");

      $GLOBALS['DB']->exec("DELETE FROM brands_stores * WHERE store_id = {$this->getId()};");

      }


    function getBrands()
      {

        $return_tb = $GLOBALS['DB']->query("SELECT brands.* FROM stores
        JOIN brands_stores ON (stores.id = brands_stores.store_id)
        JOIN brands ON (brands.id = brands_stores.brand_id)
        WHERE stores.id = {$this->getId()};");

        $brands_tb = $return_tb->fetchAll(PDO::FETCH_ASSOC);
        $brands = array();
        foreach($brands_tb as $brand)
      {
        $id = $brand['id'];
        $name = $brand['name'];
        array_push($brands, new Brand($name, $id));
      }
      return $brands;
      }




      static function getAll()
      {
      $return_tb  = $GLOBALS['DB']->query("SELECT * FROM stores;");

          $store_tb = $return_tb ->fetchAll(PDO::FETCH_ASSOC);
          $stores = array();
          foreach($store_tb as $brand)
          {
          $id = $brand['id'];
          $name = $brand['name'];
          array_push($stores, new Store($name, $id));
      }
      return $stores;
      }



    static function deleteAll()
      {

      $GLOBALS['DB']->exec("DELETE FROM stores *;");

      $GLOBALS['DB']->exec("DELETE FROM brands_stores *;");
      }




    static function ById($search_id)
      {
        $statement = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$search_id};");
        $result_tb = $statement->fetchAll(PDO::FETCH_ASSOC);
        $find_store = null;
        foreach($result_tb as $tb)
      {
        $id = $tb['id'];
        $name = $tb['name'];
        $find_store = new Store($name, $id);
      }
        return $find_store;
      }

      static function findName($search_name)
      {

        $return_tb = $GLOBALS['DB']->query("SELECT * FROM stores WHERE name LIKE '%{$search_name}%';");
        $result_tb= $return_tb->fetchAll(PDO::FETCH_ASSOC);
        $find_stores = array();
      foreach($result_tb as $tb)
      {
          $id = $tb['id'];
          $name = $tb['name'];
          $new_store = new Store($name, $id);
          array_push($find_stores, $new_store);
      }
        return $find_stores;
      }
}
?>
