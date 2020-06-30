<?php
namespace Tests;

class Person
    {
        public $name;
        function _construct($name)
        {
            $this->name=$name;
        }
        public function getName()
        {
            return $this->name;
        }
    }
?>