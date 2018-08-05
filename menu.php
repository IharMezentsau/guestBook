<header class="main-header">
            <!-- Header Navbar: style can be found in header.less -->

            <nav class="navbar navbar-inverse navbar-static-top">

                    <div class="navbar-header">
<?php

    if (!isset($_SESSION['user_id'])){
        echo '          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
                            <span class="sr-only">Открыть навигацию</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>';
    };
?>
                        <a class="navbar-brand" href="index.php">Гостевая книга</a>
                    </div>

                    <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">



<?php
    if (isset($_POST['authorisation']) && ($_POST['authorisation'] == 'logout')){
        session_unset();
        session_destroy();
    };
    if (isset($_SESSION['user_id'])) {

        $user = new UserDao($dataBase);
        $dataUser = $user->getById($_SESSION['user_id']);

        if ($dataUser->admin) {
                        echo '<li>
                                <a id="getExel" href="getExel.php" class="btn" data-tooltip="tooltip" data-placement="bottom"
                                 title="Сохранить данные в exel"><i class="far fa-file-excel"></i></a>
                             </li>';
        };
        echo                '<li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="' . $dataUser->avatar . '" class="user-image" alt="User Image">
                                    <span class="hidden-xs"> ' . $dataUser->name . ' ' . $dataUser->familyname . '</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="' .  $dataUser->avatar . '" class="img-circle" alt="User Image">
    
                                        <p>
                                            ' . $dataUser->name . ' ' . $dataUser->familyname . '
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <!---->
                                            <div class="pull-left">
                                                <a href="profile.php" class="btn btn-default"
                                                   data-tooltip="tooltip" title="Вход в личный кабинет"><i class="fas fa-user"></i> Профиль</a>
                                            </div>
                                            <div class="pull-right">
                                                <form action="index.php" name="authorisation" id="responsive-menu" method="post">
                                                    <button name="submit" class="btn btn-danger" type="submit" value="logOut">
                                                        <i class="fas fa-door-closed"></i> ВЫЙТИ
                                                    </button>
                                                    <input name="authorisation" class="form-control" type="hidden" value="logout">
                                                </form>
                                            </div>
                                       <!--  -->
                                    </li>
                                </ul>
                            </li>';
    }
    else {
            echo '         
                            <li>
                                <div class="collapse navbar-collapse" id="responsive-menu">
                                    <form action="index.php" name="authorisation" class="navbar-form navbar-right" 
                                            id="responsive-menu" method="post">
                        
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="userName" placeholder="E-mail" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="userPassword" placeholder="Пароль" value="">
                                        </div>
                                        <button type="submit" class="btn btn-primary form-control">
                                            <i class="fas fa-sign-in-alt"></i> ВОЙТИ
                                        </button>
                                        <button type="button" id="#modal-reg" data-toggle="modal" data-tooltip="tooltip" data-target="#registration"
                                                class="btn btn-info form-control" title="Регистрация" data-placement="bottom">
                                             <i class="far fa-address-card"></i>
                                        </button>
                                        
                                    </form>
                                </div>
                            </li>
                            
                            ';
    };
?>

                        <!-- Control Sidebar Toggle Button -->

                        </ul>

                    </div>

            </nav>
        </header>
