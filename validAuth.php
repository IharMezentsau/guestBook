<?php
    if (isset($_POST['userName']) && isset($_POST['userPassword']))
    {

        $login = $_POST['userName'];
        $password = md5($_POST['userPassword']);

        // делаем запрос к БД
        // и ищем юзера с таким логином и паролем
        $authorisation = new UserDao($dataBase);
        $user = $authorisation->authorisation($login, $password);

        if ($user->authorisation == 1){
            $_SESSION['user_id'] = $user->id;
        }
        else {
            header('Location:authorisation.php');
            die();
        }
    };

?>