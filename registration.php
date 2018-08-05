<?php

    include_once ('bd.php');
    include_once ('class/Db.php');

    $DB = new Db();
    $dataBase = $DB->getDb();

    $user = new UserDao($dataBase);

    $date = date("Y/m/d H.i.s");

    if (empty($_POST['email'])) {
        $emptyEmail = true;
    }
    else{
        $emptyEmail = false;
        $login = $_POST["email"];
    };

    if (empty($_POST['pass'])) {
        $emptyPass = true;
    }
    else{
        $emptyPass = false;
        $password = $_POST["pass"];
        $passwordHash = md5($password);
    };

    if (($emptyEmail != true) & ($emptyPass != true)) {

        $unicueUser = $user->validUnicueLogin($login);

        if ($unicueUser != false){
            if (!empty($_POST['name'])){
                $user->registration($login, $passwordHash, $date, $_POST['name']);
            }
            else{
                $user->registration($login, $passwordHash, $date);
            };
        };

    };

    $answer = array('unicue' => $unicueUser);



echo json_encode($answer);
