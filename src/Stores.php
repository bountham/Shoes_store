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

        // function save()
        // {
        //     $statement = $GLOBALS['DB']->query("INSERT INTO stores (description) VALUES ('{$this->getDescription()}') RETURNING id;");
        //     $result = $statement->fetch(PDO::FETCH_ASSOC);
        //     $this->setId($result['id']);
        // }

 }
?>