<?php

session_start();

include_once ('class/Db.php');

if (isset($_SESSION['user_id'])) {
    $DB = new Db();
    $dataBase = $DB->getDb();

    $answer = new MessageDao($dataBase);

    echo json_encode($answer->getMessageById($_GET['id']));
};