<?php



    abstract class Dao{

        protected $data;

        public function __construct($db){

            $this->data = $db;

        }

        public function setDb($db){

            $this->data = $db;

        }

        public function getDb(){

            return $this->data;

        }

    };

?>