<?php include '../includes/header_emp.php';?>
<?php include '../includes/config.php'; ?>
<?php

$date=date("Y-m-d");

if(isset($_POST['send_reply'])){

    $reply=$_POST['reply'];
    $notify_id=$_POST['notify_id'];


    $replyQuery = "UPDATE emp_notification SET notification_reply='$reply' where notification_id=$notify_id";


    $result2 = mysqli_query($con, $replyQuery);
    if ($result2) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Reply Send Successfully - تم ارسال الرد </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'view_notify.php';
             }, 2000);</script>";
    } else {

        echo "Error In Sending Reply " . mysqli_error($con);
    }

    }
?>

<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

        <!-- display admin -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">




                        <div class="col-12">

                            <div class="row">
                                <div class="col-4 d-flex-justify-content-start ">
                                    <h2>
                                        <a class="btn btn-link text-light" href="index.php"><i class="fa fa-arrow-left">Back To Home page </a></i>

                                    </h2>

                                </div>

                                <div class="col-3 d-flex justify-content-end text-light">
                                    <strong class="card-title mt-2 ">View All Notification </strong>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php
                    $query4 = "SELECT * FROM emp_notification where notification_emp_id = {$_SESSION['emp_id']}
                       and notification_appear='2019-11-13' order by notification_id DESC ";
                    $result2 = mysqli_query($con, $query4);

                    ?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title box-title text-center">
                                    <?php

                                    $number = "SELECT notification_id,notification_emp_id FROM emp_notification
                                    WHERE notification_emp_id = {$_SESSION['emp_id']} AND notification_appear='2019-11-13'";

                                    $number_q = mysqli_query($con, $number);

                                    ?>

                                    You Have <?php
                                                echo !empty(mysqli_num_rows($number_q)) ?
                                                    "<span class='text-primary'>" . mysqli_num_rows($number_q) . "</span>" : "<span class='text-danger '>" . 0 . "</span>";
                                                ?> Notification Today From The Admin

                                </h4>


                                <?php
                                $i=1;
                                while ($row3 = mysqli_fetch_assoc($result2)) {

                                    if ($row3['notification_priority'] == "High") {

                                        $priority = 'style="background-color:#dc3545;color:#fff"';
                                    } else if ($row3['notification_priority'] == "Medium") {

                                        $priority =  'style="background-color:#fd7e14;color:#000"';
                                    } else if ($row3['notification_priority'] == "Low") {

                                        $priority = 'style="background-color:#ffc107;color:#000"';
                                    }

                                    ?>
                                    <div class="card-content">
                                        <div class="todo-list">
                                            <div class="tdl-holder">
                                                <div class="tdl-content">
                                                    <ul>
                                                        <li>

                                                            <label <?php echo $priority ?>>
                                                            <?php if(empty($row3['notification_reply'])) {?>
                                                        <!-- Button trigger modal -->
                                                        <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id'];?>'>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_reply<?php echo $i ?>">
                                                            ارسال الرد
                                                        </button>
                                                        <?php }else{ ?>
                                                    <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id'];?>'>
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_reply<?php echo $i ?>">
                                                                    تم  الرد
                                                    </button>

                                                       <?php } ?>
                                                                <?php


                                                                      echo "<span>" .  $row3['notification_message'] ."  علماً بأن الحد الاقصى لإنهاء المهمة في تاريخ " . $row3['notification_due_date'] . "</span>";
                                                                    ?>

                                                            </label>
                                                        </li>

                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="add_reply<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-light">
                                            <h5 class="modal-title d-inline-block pull-right" id="exampleModalLabel" >ارسال الرد</h5>
                                            <button type="button" class="close text-light pull-left" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST" role="form">
                                            <div class="modal-body">
                                                <div class="form-group ">
                                                    <label for='message' class='pull-right'> الرسالة المستلمة</label>
                                                    <textarea rows=8 class="form-control" name='message' readonly><?php echo $row3['notification_message'] . "  علماً بأن الحد الاقصى لإنهاء المهمة في تاريخ " . $row3['notification_due_date'] ?></textarea>
                                                </div>
                                                <?php if(empty($row3['notification_reply'])){ ?>
                                                <div class="form-group">
                                                    <label for='reply' class='pull-right'>الرد</label>
                                                    <textarea rows=8 class="form-control" name='reply' required></textarea>
                                                </div>
                                                <?php } else{

                                             echo "<div class='col-12 btn btn-danger'>" . "تم الرد على هذه الرسالة  " . "</div>";



                                                      } ?>
                                            </div>
                                            <?php if(empty($row3['notification_reply'])){ ?>
                                            <div class="modal-footer pull-left">
                                            <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id'];?>'>
                                                <button type="submit" name='send_reply' class="btn btn-primary">ارسال الرد</button>
                                            </div>
                                            <?php }?>



                                    </div>

                                    </form>
                                </div>
                            </div>



                                <?php
                                    $i++;
                                }
                                ?>







                            </div>
                        </div>
                    </div>











                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>