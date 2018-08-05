<!DOCTYPE html>
<html lang="ru">
    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">


        <title>Б - Блог</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!--<link rel="stylesheet" href="lib/node_modules/bootstrap3/dist/css/bootstrap.css" type="text/css">-->
        <link rel="stylesheet" href="lib/node_modules/bootstrap3/dist/css/bootstrap.css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="lib/node_modules/@fortawesome/fontawesome-free/css/all.css">
        <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
        <link rel="stylesheet" href="lib/node_modules/admin-lte/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="lib/node_modules/admin-lte/dist/css/skins/skin-purple.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    </head>
    <body  class="hold-transition skin-purple sidebar-mini layout-top-nav">
        <?php
            session_start();

            include_once ('class/Db.php');

            $DB = new Db();
            $dataBase = $DB->getDb();

            include_once ('menu.php');

            // Пути загрузки файлов
            $path = 'img/ava/';
            $tmp_path = 'tmp/';
            // Массив допустимых значений типа файла
            $types = array('image/gif', 'image/png', 'image/jpeg', 'image/jpg');
            // Максимальный размер файла
            $size = 10240000;

            if (isset($_REQUEST["deleteAvatar"])) {
                $user->updateAvatar($_SESSION['user_id'], 'NULL');
            };


        // Обработка запроса
            if (isset($_REQUEST['editProfile']) && ($_POST['editProfile'] == 'update')) {

                $dateAva = date("Y_m_d_H_i_s");
                $fileExtension = pathinfo($_FILES['avatarAcc']['name'], PATHINFO_EXTENSION);
                $nameAva = $_SESSION['user_id'] . $dateAva . "." . $fileExtension;

                if (($_POST['gender']) != $dataUser->gender) {
                    $user->updateGender($_SESSION['user_id'], $_POST['gender']);
                };

                if (is_uploaded_file($_FILES['avatarAcc']['tmp_name'])) {
                    if (@copy($_FILES['avatarAcc']['tmp_name'], $path . $nameAva)) {
                        $user->updateAvatar($_SESSION['user_id'], $path . $nameAva);
                    };
                };

                if (($_REQUEST['userName']) != "") {
                    $user->updateName($_SESSION['user_id'], $_REQUEST['userName']);
                };

                if (($_REQUEST['familyName']) != "") {
                    $user->updateFamilyname($_SESSION['user_id'], $_REQUEST['familyName']);
                };

            };

            $dataUser = $user->getById($_SESSION['user_id']);

            $options = array( 'U'=>'Скрыт', 'M'=>'Мужской', 'F'=>'Женский');
            $valueSex = $options[$dataUser->gender];

            echo '<div class="conteiner">

                      <!-- Profile Image -->
                      <div class="box box-primary">
                        <div class="box-body box-profile">
                          <img class="profile-user-img img-responsive img-circle" src="' . $dataUser->avatar . '" alt="User profile picture">';

            if (isset($_POST['editProfile']) && ($_POST['editProfile'] == 'change')){

                echo        '<form enctype="multipart/form-data" class="form-horizontal" method="post" action="profile.php">
                                
                                    <input type="file" accept="image/*" name="avatarAcc" id="selectedFile" style="display: none;" >
                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <div class="btn-group btn-group-justified">';
                if ($dataUser->avatar != 'img/male.jpg' && $dataUser->avatar != 'img/female.jpg' && $dataUser->avatar != 'img/unknow.jpg') {
                    echo                '    <div class="btn-group">
                                                <button type="submit" name="deleteAvatar"  class="btn btn-danger btn-block btn-group">
                                                    <i class="far fa-trash-alt"></i> Удалить аватар
                                                </button>
                                            </div>';
                };
                echo                           '<div class="btn-group">
                                            <input type="button" value="Выбрать аватар" class="btn btn-default btn-block" 
                                                    onclick="document.getElementById(\'selectedFile\').click();">
                                                </div>    
                                            </div>
                                            <p class="text-muted text-center" id="fileNameLoad"></p>  
                                        </li>
                                    </ul>          
                                
                                <h3 class="profile-username text-center">' . $dataUser->name . ' ' . $dataUser->familyname . '</h3>
                                <p class="text-muted text-center">eMail: ' . $dataUser->email . '</p>
                                                        
                                      <div class="box-body">
                                        <div class="form-group">
                                          <label for="inputName" class="col-sm-2 control-label">Имя</label>                                            
                                          <div class="col-sm-10">
                                            <input type="text" class="form-control" name="userName" id="inputName" placeholder="' . $dataUser->name . '">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="inputFamilyName" class="col-sm-2 control-label">Фамилия</label>
                                          <div class="col-sm-10">
                                            <input type="text" class="form-control" name="familyName" id="inputFamilyName" placeholder="' . $dataUser->familyname . '">
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="inputSex" class="col-sm-2 control-label">Пол</label>
                                          <div class="col-sm-10">
                                            <select name="gender" class="form-control" id="inputSex" size="3">';

                foreach($options as $value=>$name) {
                    if($value == $dataUser->gender) {
                        echo                    '<option selected value="' . $value . '">' . $name . '</option>';
                    }
                    else {
                        echo                    '<option value="' . $value . '">' . $name . '</option>';
                    };
                };

            echo                            '</select>
                                          </div>
                                        </div>
                                      </div>

                                      <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit"  name="editProfile" value="cancel" class="btn btn-default">Отмена</button>
                                        <button type="submit" name="editProfile" value="update" class="btn btn-info pull-right">
                                            <i class="fas fa-file-upload"></i> Обновить данные
                                        </button>
                                    </div>
                                      <!-- /.box-footer -->    
                            
                            </form>';
            }
            else {
                echo            '<h3 class="profile-username text-center">' . $dataUser->name . ' ' . $dataUser->familyname . '</h3>
                
                                <p class="text-muted text-center">eMail: ' . $dataUser->email . '</p>
                                    
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                      <b>Дата регистрации</b> <a class="pull-right">' . $dataUser->date . '</a>
                                    </li>
                                    <li class="list-group-item">
                                      <b>Пол</b> <a class="pull-right">' . $valueSex . '</a>
                                    </li>
                                </ul>
                                <form enctype="multipart/form-data"  method="post" action="profile.php">
                                      <button type="submit" name="editProfile" value="change" class="btn btn-primary btn-block">
                                            <b>Изменить данные</b>
                                      </button>
                                </form>';

            echo            '</div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /.box -->
                    
                              
                        </div>
                        <!-- /.col -->';
            };

        ?>



        <!--<script src="js/validationReg.js" type="text/javascript"></script>-->
        <script src="lib/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="lib/node_modules/bootstrap3/dist/js/bootstrap.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
        <script src="lib/node_modules/admin-lte/dist/js/adminlte.min.js"></script>
        <script src="lib/node_modules/admin-lte/dist/js/demo.js"></script>

        <!--<script src="js/validator.js"></script>-->

        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-tooltip="tooltip"]').tooltip();
            });
            $('#selectedFile').on('change', function (e) {
                console.log(e.target.files[0].name);
                $('#fileNameLoad').text(e.target.files[0].name);
            });
        </script>

        <script>
            // just for the demos, avoids form submit

            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $("#formReg").validate({
                onsubmit: false,
                submitHandler: function(form) {
                    if ($(form).valid())
                    {
                        form.submit();
                    }
                    return false; // prevent normal form posting
                },
                rules: {
                    passwordReg: "required",
                    confirmPasswordReg: {
                        equalTo: "#passwordReg"
                    }
                }
            });
        </script>
        <!--<script src="js/validationReg.js"></script>-->

    </body>
</html>