<?php

    include_once ('Dao.php');
    include_once ('Entity.php');
    include_once ('Message.php');
    include_once ('MessageDao.php');
    include_once ('User.php');
    include_once ('UserDao.php');


    class Db{

        private $_host = '127.0.0.1';
        private $_username = 'root';
        private $_password = 'V!perD0bge';
        private $_database = 'guest_book';

        protected $DBH;

        public function __construct(){
            if (!isset($this->DBH)){

                $this->DBH = new PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);

                if (!$this->DBH){
                    echo 'Не удалось подключиться к серверу';
                    exit;
                }

            }

        }

        public function getDb(){

            return $this->DBH;

        }

    };

?>