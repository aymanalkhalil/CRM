<?php include '../includes/header_emp.php'; ?>
<?php include '../includes/config.php'; ?>


<!--substring(lead_calls.call_date_time,1,10)-->
<?php
date_default_timezone_set('EET');
$date = date('Y-m-d');

$query1 =  "SELECT * FROM lead_calls INNER JOIN lead ON lead_calls.call_lead_id=lead.lead_id
                   WHERE lead_emp_id={$_SESSION['emp_id']} AND call_date='$date'";

$result1 = mysqli_query($con, $query1);


if (isset($_POST['send_reply'])) {

    $reply = $_POST['reply'];
    $notify_id = $_POST['notify_id'];


    $replyQuery = "UPDATE emp_notification SET notification_reply='$reply' where notification_id=$notify_id";


    $result2 = mysqli_query($con, $replyQuery);
    if ($result2) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Reply Send Successfully - تم ارسال الرد </div>";

        echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'index.php';
         }, 2000);</script>";
    } else {

        echo "Error In Sending Reply " . mysqli_error($con);
    }
}
if (isset($_GET['check_in'])) {
    echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>تم تسجيل دخولك للدوام </div>";

    echo "<script type='text/Javascript'>
     window.setTimeout(function() {
     window.location.href = 'index.php';
     }, 2000);</script>";
}
if (isset($_GET['check_out'])) {
    echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>تم تسجيل خروجك من الدوام </div>";

    echo "<script type='text/Javascript'>
     window.setTimeout(function() {
     window.location.href = 'index.php';
     }, 2000);</script>";
}

if (isset($_GET['check_in_twice'])) {

    echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>  لا يمكنك تسجيل الدخول للدوام مرتان </div>";

    echo "<script type='text/Javascript'>
     window.setTimeout(function() {
     window.location.href = 'index.php';
     }, 2000);</script>";
}



?>

<style>
    #blink {
        opacity: 0;
        animation: blinker 1.25s ease-out infinite;
    }



    #blink:hover {
        animation-name: blinker;
        animation-play-state: paused;
        background-color: #00f;
        color: #fff;
    }

    @keyframes blinker {
        to {
            opacity: 0;

        }

        from {
            opacity: 1;
            background-color: #00f;
        }
    }

    @keyframes blinker {
        from {
            opacity: 1;
        }
    }

    .display a {
        display: contents;
    }

    .tdl-holder li span {
        margin-left: 25px !important;
        vertical-align: middle;
        -webkit-transition: all 0.2s linear;
        transition: all 0.2s linear;
    }
</style>
<div class="content">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header bg-primary text-light ">
                <div class="col-12">
                    <strong class="card-title m-0 d-flex justify-content-center"> <?php echo $date ?> نشاطاتك خلال اليوم </strong>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-3">
                        <div class="card">

                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="fa fa-user-check"></i>
                                    </div>
                                    <?php

                                    $query2 = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                            INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['emp_id']}'
                                             AND lead_calls.call_result='Registered Successfully - تم التسجيل' AND substring(lead_calls.call_date_time,1,10)='$date'";
                                    $result2 = mysqli_query($con, $query2);

                                    $row2  = mysqli_fetch_assoc($result2);

                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"><span class="count"><?php echo  mysqli_num_rows($result2); ?></span></div>
                                                <div class="stat-heading text-success">تم التسجيل</div>
                                            </div>
                                        </div>
                                    <?php } else {  ?>

                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"><span class="count"><?php echo 0; ?></span></div>
                                                <div class="stat-heading text-success">تم التسجيل</div>
                                            </div>
                                        </div>

                                    <?php  }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="fa fa-user-check"></i>
                                    </div>
                                    <?php
                                    $query3 = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                    INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['emp_id']}'
                                     AND lead_calls.call_result='Interested - مهتم' AND substring(lead_calls.call_date_time,1,10)='$date'";
                                    $result3 = mysqli_query($con, $query3);
                                    $row3  = mysqli_fetch_assoc($result3);


                                    if ($date == $row3['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"> <span class="count"><?php echo mysqli_num_rows($result3); ?></span></div>
                                                <div class="stat-heading text-success">مهتم</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"> <span class="count"><?php echo 0; ?></span></div>
                                                <div class="stat-heading text-success">مهتم</div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="fas fa-exclamation"></i>
                                    </div>
                                    <?php
                                    $query4 = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                                INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['emp_id']}'
                                                AND lead_calls.call_result='Hesitant - متردد' AND substring(lead_calls.call_date_time,1,10)='$date'";


                                    $result4 = mysqli_query($con, $query4);
                                    $row4  = mysqli_fetch_assoc($result4);

                                    if ($date == $row4['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#fd7e14'><?php echo mysqli_num_rows($result4); ?></span></div>
                                                <div class="stat-heading" style='color:#fd7e14'>متردد</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#fd7e14'><?php echo 0; ?></span></div>
                                                <div class="stat-heading" style='color:#fd7e14'>متردد</div>
                                            </div>
                                        </div>



                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  Not interested -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <?php
                                    $query5 = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                              INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['emp_id']}'
                                              AND lead_calls.call_result='Not Interested - غير مهتم' AND substring(lead_calls.call_date_time,1,10)='$date'";


                                    $result5 = mysqli_query($con, $query5);
                                    $row5  = mysqli_fetch_assoc($result5);

                                    if ($date == $row5['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-primary"><?php echo mysqli_num_rows($result5); ?></span></div>
                                                <div class="stat-heading" style='color:#03a9f3'>غير مهتم</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-primary"><?php echo 0; ?></span></div>
                                                <div class="stat-heading" style='color:#03a9f3'>غير مهتم</div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Not interested -->
             <!-- Total Leads Start -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3" style='color:#17a2b8;'>
                                    <i class="fas fa-address-book"></i>
                                    </div>
                                    <?php
                                    $query7 = "SELECT * FROM lead WHERE lead_emp_id={$_SESSION['emp_id']}";


                                    $result7 = mysqli_query($con, $query7);
                                    // $row7  = mysqli_fetch_assoc($result7);


                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-info"><?php echo mysqli_num_rows($result7) > 0 ? mysqli_num_rows($result7) : "0" ?></span></div>
                                                <div class="stat-heading" style='color:#17a2b8'>مجموع الارقام </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Total Leads END -->
                <!-- Total Leads Done Start -->
                <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3" style='color:#575BDA;'>
                                    <i class="fa fa-phone-alt"></i>
                                    </div>
                                    <?php
                                    $query8 = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id
                                    LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id
                                    WHERE not lead_calls.call_note='Not Used - غير مستعمل' AND lead_emp_id = {$_SESSION['emp_id']}";


                                    $result8 = mysqli_query($con, $query8);
                                    // $row7  = mysqli_fetch_assoc($result7);


                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#575BDA;'><?php echo mysqli_num_rows($result8) > 0 ? mysqli_num_rows($result8) : "0" ?></span></div>
                                                <div class="stat-heading" style='color:#575BDA'> المنجز منها</div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Leads Done END -->

                    <!-- Not USED Start -->
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <?php
                                    $query333 = "SELECT check_emp_id,check_in,substring(check_in,1,10) AS day
                                    FROM check_time WHERE check_emp_id='{$_SESSION['emp_id']}' AND substring(check_in,1,10)='$date' order by check_id DESC";
                                    $result212 = mysqli_query($con, $query333);
                                    $row2222 = mysqli_fetch_assoc($result212);
                                    ?>


                                    <?php if (!empty($row2222['check_in'])) { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="text" style='color:#6f42c1;font-size:14px'><?php echo date('Y-m-d h:i A ', strtotime($row2222['check_in'])) ?></span></div>
                                                <div class="stat-heading" style='color:#6f42c1'>تسجيل دخول</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="text" style='color:#6f42c1;font-size:14px'><?php echo "لم يتم تسجيل الدخول" ?></span></div>
                                                <!-- <div class="stat-heading" style='color:#6f42c1'>Check-In</div> -->
                                            </div>
                                        </div>

                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-6">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <?php
                                    $query3433 = "SELECT check_emp_id,check_out,substring(check_in,1,10) AS day
                                    FROM check_time WHERE check_emp_id='{$_SESSION['emp_id']}' AND substring(check_in,1,10)='$date' order by check_id DESC";
                                    $result2121 = mysqli_query($con, $query3433);
                                    $row113 = mysqli_fetch_assoc($result2121);
                                    ?>
                                    <?php if (!empty($row113['check_out'])) { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text" style='color:#5c6bc0;font-size:14px'><span class="text"><?php echo date('Y-m-d h:i A ', strtotime($row113['check_out'])) ?></span></div>
                                                <div class="stat-heading" style='color:#5c6bc0'>تسجيل خروج</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text" style='color:#5c6bc0;font-size:14px'><span class="text"><?php echo "تسجيل الخروج عند انتهاء الدوام" ?></span></div>
                                                <!-- <div class="stat-heading" style='color:#5c6bc0'>Check-Out</div> -->
                                            </div>
                                        </div>

                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </div>







        <div class="row">
            <div class="col-6">
                <div class="card ">
                    <div class="card-body">
                        <h4 class="card-title box-title">

                            لديك <?php
                                    echo !empty(mysqli_num_rows($result1)) ?
                                        "<span class='text-primary' >" . mysqli_num_rows($result1) . "</span>" : "<span class='text-danger '>" . 0 . "</span>";
                                    ?> تذكيرات اليوم
                        </h4>


                        <?php


                        while ($row = mysqli_fetch_assoc($result1)) {

                            ?>
                            <div class="card-content">
                                <div class="todo-list">
                                    <div class="tdl-holder">
                                        <div class="tdl-content">
                                            <ul>
                                                <li>
                                                    <label class='display'>

                                                        <?php
                                                            $query = "SELECT call_date_time FROM lead_calls
                                                          where call_lead_id = {$row['call_lead_id']} ORDER BY call_id DESC LIMIT 1";

                                                            $res  =    mysqli_query($con, $query);

                                                            $row2  = mysqli_fetch_assoc($res);
                                                            $timestamp = strtotime($row2['call_date_time']);
                                                            $cut = date('Y-m-d', $timestamp);


                                                            if ($date == $cut) {

                                                                echo  "<s>" .  "You Have To Call " .  "<a class='name-color' href='lead_profile.php?lead_id={$row['lead_id']}'" . "</s>";
                                                                echo  "<s>"  . $row['lead_name']  . "</s>"  . "</a>";
                                                                echo  " <s>" . "At " . date('h:i A ', strtotime($row['call_time'])) . "</s>";
                                                                echo  "</s>";
                                                            } else {

                                                                echo   "<span>" .  "You Have To Call " .  "<a class='name-color' href='lead_profile.php?lead_id={$row['lead_id']}'" . "</span>";
                                                                echo   "<span>"  . $row['lead_name']  . "</span>"  . "</a>";
                                                                echo   "<span>" . "At " . date('h:i A ', strtotime($row['call_time'])) . "</span>";
                                                                echo   "</span>";
                                                            }


                                                            ?>

                                                    </label>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }

                        // }

                        ?>
                    </div>
                </div>
            </div>
            <?php
            $query4 = "SELECT * FROM emp_notification where notification_emp_id = {$_SESSION['emp_id']}
         and notification_appear='$date' order by notification_id DESC LIMIT 5";
            $result2 = mysqli_query($con, $query4);

            ?>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title box-title">
                            <?php

                            $number = "SELECT notification_id,notification_emp_id FROM emp_notification
                             WHERE notification_emp_id = {$_SESSION['emp_id']} AND notification_appear='$date'";

                            $number_q = mysqli_query($con, $number);

                            ?>
                            لديك <?php
                                    echo !empty(mysqli_num_rows($number_q)) ?
                                        "<span class='text-primary'>" . mysqli_num_rows($number_q) . "</span>" : "<span class='text-danger '>" . 0 . "</span>";
                                    ?> تنبيهات اليوم

                        </h4>
                        <?php
                        $i = 1;
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
                                                        <?php if (empty($row3['notification_reply'])) { ?>
                                                            <!-- Button trigger modal -->
                                                            <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id']; ?>'>
                                                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#add_reply<?php echo $i ?>">
                                                                ارسال الرد
                                                            </button>
                                                        <?php } else { ?>
                                                            <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id']; ?>'>
                                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_reply<?php echo $i ?>">
                                                                تم الرد
                                                            </button>

                                                        <?php } ?>
                                                        <?php

                                                            echo "<span dir='rtl'>" .  $row3['notification_message'] . "  علماً بأن الحد الاقصى لإنهاء المهمة في تاريخ " . $row3['notification_due_date'] . "</span>";

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
                                            <h5 class="modal-title d-inline-block pull-right" id="exampleModalLabel">ارسال الرد</h5>
                                            <button type="button" class="close text-light pull-left" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST" role="form">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for='message' class='pull-right'>الرسالة المستلمة</label>
                                                    <textarea rows=8 class="form-control" dir='rtl' name='message' readonly><?php echo $row3['notification_message'] . "  علماً بأن الحد الاقصى لإنهاء المهمة في تاريخ " . $row3['notification_due_date'] ?></textarea>
                                                </div>
                                                <?php if (empty($row3['notification_reply'])) { ?>
                                                    <div class="form-group">
                                                        <label for='reply' class='pull-right'>الرد</label>
                                                        <textarea rows=8 class="form-control" dir='rtl' name='reply' required></textarea>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="form-group">
                                                        <label for='reply' class='pull-right'>الرد</label>
                                                        <textarea rows=8 class="form-control" dir='rtl' name='reply' readonly required><?php echo $row3['notification_reply'] ?></textarea>
                                                    </div>
                                                <?php
                                                        echo "<div class='col-12 btn btn-danger'>" . "تم الرد على هذه الرسالة  " . "</div>";
                                                    } ?>
                                            </div>
                                            <?php if (empty($row3['notification_reply'])) { ?>
                                                <div class="modal-footer pull-left">
                                                    <input type='hidden' name='notify_id' value='<?php echo $row3['notification_id']; ?>'>
                                                    <button type="submit" name='send_reply' class="btn btn-primary ">ارسال الرد</button>
                                                </div>
                                            <?php } ?>



                                    </div>

                                    </form>
                                </div>
                            </div>
                        <?php
                            $i++;
                        }
                        ?>
                        <?php
                        if (mysqli_num_rows($number_q) > 5) {
                            ?>
                            <div class="col-3 pull-right blink">

                                <a href="view_notify.php" class="btn btn-info" id="blink">View More </a>

                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>



            <!-- row -->
        </div>

        <!-- animated Fade-In -->
    </div>
    <!-- content -->
</div>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include '../includes/footer.php'; ?>
<script>
    $("document").ready(function() {
        $(".display:odd").css({
            "background-color": "#F5F5F5",
            "color": "#000"
        });
        $(".display:even").css({
            "background-color": "#808080",
            "color": "#fff"
        });
        $(".name-color:even").css("color", "#fff");
        $(".name-color:odd").css("color", "#000");
    });
</script>