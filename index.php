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


    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-tooltip="tooltip"]').tooltip();
        });
    </script>

    <script type="text/javascript">

    $(document).ready(function () {

        getReviews();

        var dataItems;


        function getReviews() {
            $.ajax({
                type:"GET",
                url:"reviewController.php",
                success:
                    function(n) {
                        dataItems = JSON.parse(n);
                        refreshReviews();
                    },
            }, "json")};
        function refreshReviews() {
            if (window.isAutorise == 1){
                $('#sendReview')[0].reset();
            };
            $('#fileNameLoad').empty();
            $('.ratingReview').raty('cancel');
            $("div#reviewListBag").empty();
            $('#reviewTmpl').tmpl(dataItems).appendTo('#reviewListBag');
            $('div.rating').raty({ starType: 'i', readOnly: true});
        };

        $('div.ratingReview').raty({ starType: 'i' });

        $("#newReview").click(function(event) {
            event.preventDefault();
            var message = $("#textReview").val();
            var rating = $('.ratingReview').raty('score');
            var image = $("#selectedFile").prop('files')[0];
            var formImage = new FormData();
            formImage.append('file', image);
            formImage.append('message', message);
            formImage.append('rating', rating);
            formImage.append('_method', 'POST');
            $.ajax({
                type:"POST",
                url:"reviewController.php",
                data:formImage,
                cache: false,
                processData: false,
                contentType: false,
                success:
                    function() {
                        answer();
                    },
            }, "json");
            function answer() {
                getReviews();
            };
        });

        $("body").on('click', ".updateMessage", function (event) {
            var idUpdate = $(this).attr("data-update");
            modalWindow(idUpdate);
        });

        function modalWindow(id) {

            $.ajax({
                type: "GET",
                url: "getUpdate.php?id=" + id,
                success:
                    function (n) {
                        $('#updateImg').empty();
                        $("#btnDelImg").empty();
                        $('#fileNameLoadUpdate').empty();
                        dataUpdate = JSON.parse(n);
                        $('#modal-update').modal("show");
                        $('div.updateRating').raty({starType: 'i', score: dataUpdate.rating});
                        $('#textReviewUpdate').text(dataUpdate.message);
                        $('.submitUpdate').attr("data-update", id);
                        if (dataUpdate.image != null) {
                            $('#updateImg').append("<img alt='image' class='img-responsive' src='" + dataUpdate.image + "'>");
                            $('#btnDelImg').append("<button id='deleteImage' class='btn btn-danger btn-block btn-group'></button>");
                            $('#deleteImage').append("<i class='far fa-trash-alt'></i>");
                        }
                    }
            }, "json");

        }

        $("body").on('click', "#deleteImage", function () {
            var idImage = $(".submitUpdate").attr("data-Update");
            $.ajax({
                type: "GET",
                url: "deleteImage.php?id=" + idImage,
                success:
                    function () {
                        getReviews();
                        modalWindow(idImage);
                    }
            }, "json");
        });

        $("body").on('click', ".submitUpdate", function(event) {
            event.preventDefault();
            var idMessage = $(".submitUpdate").attr("data-Update");
            var message = $("#textReviewUpdate").val();
            var rating = $('.updateRating').raty('score');
            var image = $("#selectedFileUpdate").prop('files')[0];
            var formUpdate = new FormData();
            formUpdate.append('id', idMessage);
            formUpdate.append('file', image);
            formUpdate.append('message', message);
            formUpdate.append('rating', rating);
            formUpdate.append('_method', 'PUT');
            $.ajax({
                type:"POST",
                url:"reviewController.php",
                data: formUpdate,
                cache: false,
                processData: false,
                contentType: false,
                success:
                    function() {
                        getReviews();
                    },
            }, "json");
        });

        $("body").on('click', ".deleteMessage", function(event) {
            var idMessage = $(this).attr("data-delete");
            $.ajax({
                type: "DELETE",
                url: "reviewController.php?id=" + idMessage,
                success:
                    function () {
                        getReviews();
                    },
            }, "json");
        });

    });


    </script>
    <script>
        window.isAutorise = <?php if (isset($_SESSION['user_id'])){$autorise = 1;}else{$autorise = 0;}; echo $autorise ?>;
    </script>

    <script>
        $('#selectedFile').on('change', function (e) {
            console.log(e.target.files[0].name);
            $('#fileNameLoad').text(e.target.files[0].name);
        });
        $('#selectedFileUpdate').on('change', function (e) {
            console.log(e.target.files[0].name);
            $('#fileNameLoadUpdate').text(e.target.files[0].name);
        });
    </script>

    <?php
        if (!isset($_SESSION['user_id'])){
            echo "<script>
                    $(document).ready(function () {

                        $('#regBtn').click(function(event) {
                          event.preventDefault();
                          var regularValidEmail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
                          var email = $('#eMailReg').val();
                          var pass = $('#passwordReg').val();
                          var name = $('#nameId').val();
                          var confirmPass = $('#confirmPasswordReg').val();
                          var data = {email: email, pass: pass, name: name};
                    
                          $('#invalidPass').text(' ');
                          $('#invalidEmail').text(' ');
                    
                          if (regularValidEmail.test(email)){
                              if (pass == confirmPass){
                                  $.ajax({
                                        type: 'POST',
                                        data: data,
                                        url: 'registration.php',
                                        success:
                                            function(answer) {
                                              reg(answer);
                                            }
                                              }, 'json');
                                      
                                      function reg(n) {
                                                var answer = JSON.parse(n);
                                                
                                                if (answer.unicue == true){
                                                    $('#formReg').empty();
                                                    $('#formReg').text('Регистрация успешна!');
                                                }
                                                else{
                                                    $('#invalidEmail').text('Такой пользователь существует');
                                                }
                                              };
                              }
                              else {
                                  $('#invalidPass').text('Пароли не совпадают');
                              }
                          }
                          else{
                              $('#invalidEmail').text('Неверный Email');
                          }
                        });
                    });
                  </script>";
        };
    ?>

</body>
</html>