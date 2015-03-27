<?php
    class Stores
    {
        private $name;
        private $id;

        function __construct( $name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }
        function setName($new_name)
        {
          $this->name = (string) $new_name;

        }
        function getName()
        {
          return $this->name;
        }
        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function update($new_name)
        {

        $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
        
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }


        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store) {
                $name = $store['name'];
               $id = $store['id'];
                $new_store = new Stores($name,$id);
                array_push($stores, $new_store);
            }
            return $stores;
        }



        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM stores *;");
        }


 }
?>
