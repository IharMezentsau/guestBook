<?php

session_start();

include_once ('class/Db.php');

if (isset($_SESSION['user_id'])) {
    $DB = new Db();
    $dataBase = $DB->getDb();

    MessageDao::deleteImage($dataBase, $_GET['id']);
};