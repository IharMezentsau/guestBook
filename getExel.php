<?php

session_start();

include_once ('class/Db.php');
include_once ('PHPExcel/Classes/PHPExcel.php');
include_once ('PHPExcel/Classes/PHPExcel/Writer/Excel5.php');

$DB = new Db();
$dataBase = $DB->getDb();

$user = new UserDao($dataBase);
$dataUser = $user->getById($_SESSION['user_id']);

if (isset($_SESSION['user_id']) & ($dataUser->admin == true)){

    $dateXls = date("Y_m_d_H_i_s");

    $exel = "xls/" . $dateXls. "_" . $_SESSION['user_id'] . ".xlsx";

    $messages = new MessageDao($dataBase);
    $messages->getJsonMessages();
    $arrayMessage = $messages->getMessages();

    $objPHPExel = new PHPExcel();
    $objPHPExel->setActiveSheetIndex(0);

    $activeSheet = $objPHPExel->getActiveSheet();

    $activeSheet->setTitle('Книга отзывов');

    $activeSheet->setCellValue("A1", "Имя автора");
    $activeSheet->setCellValue("B1", "Дата размещения отзыва");
    $activeSheet->setCellValue("C1", "Оценка");
    $activeSheet->setCellValue("D1", "Отзыв");

    $activeSheet->getStyle("A1:D1")->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID);
    $activeSheet->getStyle("A1:D1")->getFill()->getStartColor()->setRGB('EEEEEE');

    $i = 2;

    foreach ($arrayMessage as $item){
        //$name = ;
        $activeSheet->setCellValueByColumnAndRow(0, $i, $item->name . $item->familyname);
        $activeSheet->setCellValueByColumnAndRow(1, $i, $item->date);
        $activeSheet->setCellValueByColumnAndRow(2, $i, $item->rating);
        $activeSheet->setCellValueByColumnAndRow(3, $i, $item->message);
        $i++;
    };

    $activeSheet->getColumnDimension('A')->setWidth(30);
    $activeSheet->getColumnDimension('B')->setWidth(25);
    $activeSheet->getColumnDimension('C')->setWidth(8);
    $activeSheet->getColumnDimension('D')->setWidth(100);


    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExel, 'Excel5');
    $objWriter->save($exel);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($exel));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($exel));
    // читаем файл и отправляем его пользователю
    readfile($exel);

};