<!DOCTYPE html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Гостевая книга</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="lib/node_modules/bootstrap3/dist/css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="lib/node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">
    <link rel="stylesheet" href="lib/node_modules/admin-lte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="lib/node_modules/admin-lte/dist/css/skins/skin-purple.css">
    <link rel="stylesheet" href="lib/node_modules/raty-js/lib/jquery.raty.css">

    <script id="reviewTmpl" type="text/x-jquery-tmpl">

            <div class="post container">
                <div class="user-block">
                    <img class="img-circle img-bordered-sm" src=" ${ avatar } " alt="user image">
                    <span class="username">
                        <a href="#"> ${ name } ${ familyname }</a>
                    </span>
                    <span class="description">Опубликовано - ${ date } </span>
                </div>
                <!-- /.user-block -->
                {%if image%}
                <div class="row margin-bottom">
                    <div class="col-sm-6">
                      <img class="img-responsive" src=" ${ image } " alt="Photo">
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                      <div class="row">
                        <p>
                            ${ message }
                        </p>
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                {%else%}
                <p>
                    ${ message }
                </p>
                {%/if%}
                <ul class="list-inline container">
                    <li>
                        <div class="rating" data-score="${rating}">
                        </div>
                    </li >

                {%if auth%}
                    <li class="pull-right">
                        <button data-delete="${ id }" class="deleteMessage link-black text-sm">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <button data-update="${ id }" class="link-black text-sm updateMessage">
                            Редактировать
                        </button>
                    </li>
                {%/if%}
                </ul>
            </div>
            <!-- /.post -->



    </script>

</head>
<body class="hold-transition skin-purple sidebar-mini layout-top-nav" >
    <div >
        <?php
            session_start();

            include_once ('class/Db.php');

            $DB = new Db();
            $dataBase = $DB->getDb();

            include_once ('validAuth.php');
            include_once ('regForm.php');
            include_once ('menu.php');
            include_once ('blog.php');

        ?>
    </div>

    <script src="lib/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="lib/node_modules/bootstrap3/dist/js/bootstrap.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
    <script src="lib/node_modules/admin-lte/dist/js/adminlte.min.js"></script>
    <script src="js/jquery-tmpl/jquery.tmpl.js"></script>
    <script src="lib/node_modules/admin-lte/dist/js/demo.js"></script>
    <script src="lib/node_modules/raty-js/lib/jquery.raty.js"></script>

    <script src="js/tooltips.js" type="text/javascript"></script>
    <script src="js/documentReady.js" type="text/javascript"></script>
    <script src="js/modalWindow.js" type="text/javascript"></script>
    <script src="js/onClick.js" type="text/javascript"></script>
    <script src="js/getReview.js" type="text/javascript"></script>
    <script src="js/nameFileUpload.js" type="text/javascript"></script>

    <?php
    if (!isset($_SESSION['user_id'])){
        echo "<script src='js/registration.js' type='text/javascript'></script>";
    };
    ?>
    <script>
        window.isAutorise = <?php if (isset($_SESSION['user_id'])){$autorise = 1;}else{$autorise = 0;}; echo $autorise ?>;
    </script>

</body>
</html>