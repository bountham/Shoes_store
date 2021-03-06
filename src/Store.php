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

        //GETTERS
        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
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


        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {

            $GLOBALS['DB']->exec("DELETE FROM stores * WHERE id = {$this->getId()};");


            $GLOBALS['DB']->exec("DELETE FROM brands_stores * WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ('{$brand->getId()}', '{$this->getId()}');");
        }

        function getBrands()
        {

            $statement = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                JOIN brands_stores ON (stores.id = brands_stores.store_id)
                JOIN brands ON (brands.id = brands_stores.brand_id)
                WHERE stores.id = {$this->getId()};");


            $brand_tbs = $statement->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach($brand_tbs as $talbes)
            {
                $id = $talbes['id'];
                $name = $talbes['name'];
                array_push($brands, new Brand($name, $id));
            }
            return $brands;
        }


        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM stores;");

            $store_tbs = $statement->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach($store_tbs as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                array_push($stores, new Store($name, $id));
            }
            return $stores;
        }

        static function deleteAll()
        {

            $GLOBALS['DB']->exec("DELETE FROM stores *;");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores *;");
        }

        static function findById($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$search_id};");
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $store_found = null;
            foreach($result as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                $store_found = new Store($name, $id);
            }
            return $store_found;
        }

        static function findByName($search_name)
        {

            $statement = $GLOBALS['DB']->query("SELECT * FROM stores WHERE name LIKE '%{$search_name}%';");

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $store_found = array();
            foreach($result as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                $new_store = new Store($name, $id);
                array_push($store_found, $new_store);
            }
            return $store_found;
        }
    }

 ?>
