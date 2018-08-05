<?php


/*    $viewMessage = 10;

    if (isset($_REQUEST['page'])) {
        $p = $_REQUEST['page'];
    }
    else {
        $p = 1;
        $_REQUEST['page'] = $p;
    };

    $numPost = $_REQUEST['page'] * $viewMessage - $viewMessage;

    $messages = $messageDao->getMessages($numPost, $viewMessage);

    $resultCountMessage = $messageDao->getCountMessage();
    $countPage = ceil($resultCountMessage/$viewMessage);
*/
    if (isset($_SESSION['user_id'])) {
        echo '  <form class="form-horizontal" id="sendReview">
                    <ul class="list-inline">
                        <li>
                          <label>Оценка</label>
                          <div class="ratingReview">
                            
                          </div>
                        </li>
                        <li>
                            <input type="file" accept="image/*" id="selectedFile" style="display: none;" >
                            <input type="button" value="Выбрать изображение" class="btn btn-default btn-block" 
                                                    onclick="document.getElementById(\'selectedFile\').click();">
                            <p class="text-muted text-center" id="fileNameLoad"></p>
                        </li>
                    </ul>
                    <div class="input-group">
                        <input id="textReview" class="form-control input-group-lg" autocomplete="off" type="text" placeholder="Напишите отзыв">
                        <span class="input-group-btn">
                            <button type="submit" id="newReview" class="btn btn-group-lg btn-primary btn-flat">
                                                   <i class="fas fa-share-square"></i>
                            </button>
                        </span>
                    </div>
                </form>
                
                <div class="modal fade" id="modal-update" tabindex="-1" role="dialog" aria-label="Сообщение" aria-hidden="true">
                  <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-body">
                        <!-- form update-->
                        <utto role="form">
                          <div class="box-body">
                            <div class="form-group">
                              <div class="updateRating" id="updateRating">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="exampleInputPassword1">Отзыв</label>
                              <textarea class="form-control" rows="8" cols="60" id="textReviewUpdate"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="selectedFileUpdate">Изменить изображение</label>
                                <div id="updateImg"></div>
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group" id="btnDelImg"></div>
                                    <div class="btn-group">  
                                      <input type="button" value="Выбрать изображение" class="btn btn-default btn-block" 
                                                                onclick="document.getElementById(\'selectedFileUpdate\').click();">
                                    </div>
                                </div>
                                    
                                <input type="file" accept="image/*" id="selectedFileUpdate" style="display: none;" >
                                      <p class="help-block" id="fileNameLoadUpdate"></p>
                            </div>
                          </div>
                          <!-- /.box-body -->
            
                          <div class="modal-footer">
                            <button class="btn pull-left removeUpdate" data-dismiss="modal">Закрыть</button>
                            <button class="submitUpdate btn btn-primary pull-right removeUpdate" data-dismiss="modal">Обновить</button>
                          </div>
                          
                        </form>
                      </div>
                    </div>
                  </div>
                </div>';
    };
?>
    <div id="reviewListBag">



<?php
/*    echo                        '<nav class="text-center">
                                    <ul class="pagination pagination-sm">';

    if ($p == 1) {
        echo                            '<li class="disabled">
                                            <a><i class="fas fa-angle-double-left"></i></a>
                                         </li>
                                         <li class="disabled">
                                            <a><i class="fas fa-chevron-circle-left"></i></a>
                                         </li>';
    }
    else{
        echo                            '<li>
                                            <a href="index.php?page=1">
                                                <i class="fas fa-angle-double-left"></i>
                                            </a>
                                         </li>
                                         <li>
                                            <a href="index.php?page=' . ($_REQUEST['page'] - 1) . '">
                                                <i class="fas fa-chevron-circle-left"></i>
                                            </a>
                                         </li>';
    };

    $p = 0;

    if ($countPage <= 10) {
        while ($p++ < $countPage) {

            if ($_REQUEST['page'] == $p) {
                echo '<li class="active" ><a href="index.php?page=' . $p . '" >' . $p . '</a></li >';
            } else {
                echo '<li><a href="index.php?page=' . $p . '" >' . $p . '</a></li >';
            };

        };
    }
    else{
        switch ($_REQUEST['page']){
            case 1:
                $arrayBiggerTen = array( 1, 2, 'null',($countPage - 1), $countPage);
                break;
            case 2:
                $arrayBiggerTen = array( 1, 2, 'null',($countPage - 1), $countPage);
                break;
            case 3:
                $arrayBiggerTen = array( 1, 2, 3, 'null',($countPage - 1), $countPage);
                break;
            case ($countPage - 2):
                $arrayBiggerTen = array( 1, 2, 'null',($countPage - 2), ($countPage - 1), $countPage);
                break;
            case ($countPage - 1):
                $arrayBiggerTen = array( 1, 2, 'null', ($countPage - 1), $countPage);
                break;
            case ($countPage):
                $arrayBiggerTen = array( 1, 2, 'null',($countPage - 1), $countPage);
                break;
            default:
                $arrayBiggerTen = array( 1, 'null',($_REQUEST['page'] - 1), $_REQUEST['page'], ($_REQUEST['page'] + 1), 'null', $countPage);
                break;
        };

        foreach ($arrayBiggerTen as $valueArrayPage) {

            if ($_REQUEST['page'] == $valueArrayPage) {
                echo '<li class="active" ><a href="index.php?page=' . $valueArrayPage . '" >' . $valueArrayPage . '</a></li >';
            }
            elseif ($valueArrayPage == 'null'){
                echo '<li><a>...</a></li >';
            }
            else {
                echo '<li><a href="index.php?page=' . $valueArrayPage . '" >' . $valueArrayPage . '</a></li >';
            };

        };
    };

    if ($_REQUEST['page'] == $countPage) {
        echo                            '<li class="disabled">
                                            <a>
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                         </li>
                                         <li class="disabled">
                                            <a>    
                                                <i class="fas fa-angle-double-right"></i>
                                            </a>
                                         </li>';
    }
    else{
        echo                            '<li>
                                            <a href="index.php?page=' . ($_REQUEST['page'] + 1) . '">
                                                <i class="fas fa-chevron-circle-right"></i>
                                            </a>
                                         </li>
                                         <li>
                                            <a href="index.php?page=' . $countPage . '">
                                                <i class="fas fa-angle-double-right"></i>
                                            </a>
                                         </li>';
    };

    echo                            '</ul>
                                </nav>';
*/
?>