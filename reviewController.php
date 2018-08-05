<?php

session_start();

include_once ('class/Db.php');


$DB = new Db();
$dataBase = $DB->getDb();

switch ($_SERVER['REQUEST_METHOD']){
    case 'POST':

        $dateMessage = date("Y/m/d H.i.s");

        if (!empty($_FILES)) {

            // Пути загрузки файлов
            $path = 'img/img/';
            $tmp_path = 'tmp/';
            // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
            // Максимальный размер файла
            $size = 10240000;


            $dateImage = date("Y_m_d_H_i_s");
            $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $nameImage = $_SESSION['user_id'] . $dateImage . "." . $fileExtension;

            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                @copy($_FILES['file']['tmp_name'], $path . $nameImage);
            };
        };

        if ($_POST['_method'] == 'POST'){

            $messageDao = new MessageDao($dataBase);
            // Обработка запроса
            if (!empty($_FILES)) {
                $messageDao->newMessage($dateMessage, $_SESSION['user_id'], $_POST['message'], $_POST['rating'], $path . $nameImage);
            }
            else{
                $messageDao->newMessage($dateMessage, $_SESSION['user_id'], $_POST['message'], $_POST['rating']);
            };
        }
        elseif($_POST['_method'] == 'PUT'){

            if (!empty($_FILES)) {
                MessageDao::updateMessage($dataBase, $_POST['id'], $_POST['message'], $_POST['rating'], $path . $nameImage);
            }
            else{
                MessageDao::updateMessage($dataBase, $_POST['id'], $_POST['message'], $_POST['rating']);
            };

        };
        break;

    case 'GET':
        $reviews = new MessageDao($dataBase);

        echo "[" . implode(",", $reviews->getJsonMessages()) . "]";

        break;
    case 'DELETE':
        if (isset($_SESSION['user_id'])) {
            MessageDao::deleteMessage($_GET['id'], $dataBase);
        };
        break;
};

