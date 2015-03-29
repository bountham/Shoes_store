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
            $this->name = $new_name;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO brands (name) VALUES ('{$this->getName()}') RETURNING id;");
            $id_row = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($id_row['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands * WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores * WHERE brand_id = {$this->getId()};");
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        }

        function getStores()
        {
            $statement = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                JOIN stores ON(stores.id = brands_stores.store_id)
                WHERE brands.id = {$this->getId()};");

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

        function getOtherStores()
        {
            $statement = $GLOBALS['DB']->query("SELECT DISTINCT stores.* FROM brands
                JOIN brands_stores ON (brands.id = brands_stores.brand_id)
                JOIN stores ON(stores.id = brands_stores.store_id)
                WHERE stores.id NOT IN
                (SELECT stores.id FROM stores
                JOIN brands_stores ON (stores.id = brands_stores.store_id)
                JOIN brands ON (brands.id = brands_stores.brand_id)
                WHERE brands.id = {$this->getId()});");

            $store_tb = $statement->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach($statement as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                array_push($stores, new Store($name, $id));
            }
            return $stores;
        }



        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brand_tb = $statement->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach($brand_tb as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }


        static function deleteAll()
        {

            $GLOBALS['DB']->exec("DELETE FROM brands *;");

            $GLOBALS['DB']->exec("DELETE FROM brands_stores *;");
        }

        static function findById($search_id)
        {

            $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$search_id};");

            $brand_tb = $statement->fetchAll(PDO::FETCH_ASSOC);

            $brand_found = null;
            foreach($brand_tb as $tables)
            {

                $id = $tables['id'];
                $name = $tables['name'];
                $brand_found = new Brand($name, $id);
            }
            return $brand_found;
        }



        static function findByName($search_name)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM brands WHERE name LIKE '%{$search_name}%';");
            $brand_tb = $statement->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach($brand_tb as $tables)
            {
                $id = $tables['id'];
                $name = $tables['name'];
                array_push($brands, new Brand($name, $id));
            }
            return $brands;
        }
    }

 ?>
