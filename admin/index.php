<?php
include '../includes/header_admin.php';
include '../includes/config.php';
global $con;


$date = date('Y-m-d');
if (!isset($_SESSION['daily_activity'])) {
    $_SESSION['daily_activity'] = '-1';
}
if (isset($_GET['emp_choosed'])) {
    $_SESSION['daily_activity'] = $_GET['emp_choosed'];
    echo '<script> window.top.location="index.php"; </script>';
}


?>

<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <label for="employee"> Employee Daily Activites </label>
                                <select class="form-control" name="emp_id" id="employee_choose" required>
                                    <?php

                                    $sql = "SELECT emp_id,emp_name FROM employee";
                                    $res = mysqli_query($con, $sql);
                                    echo "<option disabled selected value='-1'>Choose Employee</option>";
                                    while ($row = mysqli_fetch_assoc($res)) {

                                        if ($_SESSION['daily_activity'] == $row['emp_id']) {
                                            echo "<option selected value='{$row['emp_id']}'>" . $row['emp_name'] . "</option>";
                                        } else {
                                            echo "<option value='{$row['emp_id']}'>" . $row['emp_name'] . "</option>";
                                        }
                                    }

                                    ?>
                                </select>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="fa fa-user-check"></i>
                                    </div>
                                    <?php

                                    $query = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                            INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['daily_activity']}'
                                             AND lead_calls.call_result='Registered Successfully - تم التسجيل' AND substring(lead_calls.call_date_time,1,10)='$date'";
                                    $result = mysqli_query($con, $query);

                                    $row2  = mysqli_fetch_assoc($result);

                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"><span class="count"><?php echo  mysqli_num_rows($result); ?></span></div>
                                                <div class="stat-heading text-success">Registered</div>
                                            </div>
                                        </div>
                                    <?php } else {  ?>

                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"><span class="count"><?php echo 0; ?></span></div>
                                                <div class="stat-heading text-success">Registered</div>
                                            </div>
                                        </div>

                                    <?php  }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="fa fa-user-check"></i>
                                    </div>
                                    <?php
                                    $query = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                    INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['daily_activity']}'
                                     AND lead_calls.call_result='Interested - مهتم' AND substring(lead_calls.call_date_time,1,10)='$date'";
                                    $result = mysqli_query($con, $query);
                                    $row2  = mysqli_fetch_assoc($result);


                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"> <span class="count"><?php echo mysqli_num_rows($result); ?></span></div>
                                                <div class="stat-heading text-success">Interested</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-success"> <span class="count"><?php echo 0; ?></span></div>
                                                <div class="stat-heading text-success">Interested</div>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="fas fa-exclamation"></i>
                                    </div>
                                    <?php
                                    $query = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                                INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['daily_activity']}'
                                                AND lead_calls.call_result='Hesitant - متردد' AND substring(lead_calls.call_date_time,1,10)='$date'";


                                    $result = mysqli_query($con, $query);
                                    $row2  = mysqli_fetch_assoc($result);

                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#fd7e14'><?php echo mysqli_num_rows($result); ?></span></div>
                                                <div class="stat-heading" style='color:#fd7e14'>Heistant</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#fd7e14'><?php echo 0; ?></span></div>
                                                <div class="stat-heading" style='color:#fd7e14'>Heistant</div>
                                            </div>
                                        </div>



                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  Not interested -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <?php
                                    $query = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                              INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['daily_activity']}'
                                              AND lead_calls.call_result='Not Interested - غير مهتم' AND substring(lead_calls.call_date_time,1,10)='$date'";


                                    $result = mysqli_query($con, $query);
                                    $row2  = mysqli_fetch_assoc($result);

                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-primary"><?php echo mysqli_num_rows($result); ?></span></div>
                                                <div class="stat-heading" style='color:#03a9f3'>Not interested</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-primary"><?php echo 0; ?></span></div>
                                                <div class="stat-heading" style='color:#03a9f3'>Not interested</div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Not interested -->

                    <!-- Not USED Start -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-7">
                                        <i class="fas fa-phone-slash"></i>
                                    </div>
                                    <?php
                                    $query = "SELECT lead.lead_emp_id,lead_calls.call_result,substring(lead_calls.call_date_time,1,10) AS day FROM lead
                                INNER JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id WHERE lead.lead_emp_id='{$_SESSION['daily_activity']}'
                                AND lead_calls.call_result='Not Used - غير مستعمل' AND substring(lead_calls.call_date_time,1,10)='$date'";

                                    $result = mysqli_query($con, $query);

                                    $row2  = mysqli_fetch_assoc($result);

                                    if ($date == $row2['day']) {
                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-dark"><span class="count "><?php echo mysqli_num_rows($result); ?></span></div>
                                                <div class="stat-heading text-dark">Not Used</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text text-dark"><span class="count "><?php echo 0; ?></span></div>
                                                <div class="stat-heading text-dark">Not Used</div>
                                            </div>
                                        </div>


                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Not USED -->


                       <!-- Total Leads Start -->
                       <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3" style='color:#17a2b8;'>
                                    <i class="fas fa-address-book"></i>
                                    </div>
                                    <?php
                                    $query7 = "SELECT * FROM lead WHERE lead_emp_id={$_SESSION['daily_activity']}";


                                    $result7 = mysqli_query($con, $query7);
                                    // $row7  = mysqli_fetch_assoc($result7);


                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count text-info"><?php echo mysqli_num_rows($result7) > 0 ? mysqli_num_rows($result7) : "0" ?></span></div>
                                                <div class="stat-heading" style='color:#17a2b8'>Total Leads </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Total Leads END -->
                   <!-- Total Leads Done Start -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3" style='color:#575BDA;'>
                                    <i class="fa fa-phone-alt"></i>
                                    </div>
                                    <?php
                                    $query8 = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id
                                    LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id
                                    WHERE not lead_calls.call_note='Not Used - غير مستعمل' AND lead_emp_id = {$_SESSION['daily_activity']}";


                                    $result8 = mysqli_query($con, $query8);
                                    // $row7  = mysqli_fetch_assoc($result7);


                                        ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="count" style='color:#575BDA;'><?php echo mysqli_num_rows($result8) > 0 ? mysqli_num_rows($result8) : "0" ?></span></div>
                                                <div class="stat-heading" style='color:#575BDA'>Leads Called</div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Leads Done END -->
<!-- Check in Start -->
<div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <?php
                                    $query333 = "SELECT check_emp_id,check_in,substring(check_in,1,10) AS day
                                    FROM check_time WHERE check_emp_id='{$_SESSION['daily_activity']}' AND substring(check_in,1,10)='$date' order by check_id DESC";
                                    $result212 = mysqli_query($con, $query333);
                                    $row2222 = mysqli_fetch_assoc($result212);
                                    ?>
                                    <?php if (!empty($row2222['check_in'])) { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="text" style='color:#6f42c1;font-size:14px'><?php echo date('Y-m-d h:i A ', strtotime($row2222['check_in'])) ?></span></div>
                                                <div class="stat-heading" style='color:#6f42c1'>Check-In</div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                            <div class="text-left dib">
                                                <div class="stat-text"><span class="text" style='color:#6f42c1;font-size:14px'><?php echo "Employee Didn't Check-In Yet" ?></span></div>
                                                <!-- <div class="stat-heading" style='color:#6f42c1'>Check-In</div> -->
                                            </div>
                                        </div>

                                    <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Check in -->
                    <!-- Not USED Start -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-6">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <?php
                                    $query3433 = "SELECT check_emp_id,check_out,substring(check_in,1,10) AS day
                                    FROM check_time WHERE check_emp_id='{$_SESSION['daily_activity']}' AND substring(check_in,1,10)='$date' order by check_id DESC";
                                    $result2121 = mysqli_query($con, $query3433);
                                    $row113 = mysqli_fetch_assoc($result2121);
                                    ?>
                                     <?php if (!empty($row113['check_out'])) { ?>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text" style='color:#5c6bc0;font-size:14px'><span class="text"><?php echo date('Y-m-d h:i A ', strtotime($row113['check_out'])) ?></span></div>
                                            <div class="stat-heading" style='color:#5c6bc0'>Check-Out</div>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                        <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text" style='color:#5c6bc0;font-size:14px'><span class="text"><?php echo "Employee Didn't Check-Out Yet" ?></span></div>
                                            <!-- <div class="stat-heading" style='color:#5c6bc0'>Check-Out</div> -->
                                        </div>
                                    </div>



                                        <?php  } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Not USED -->
                </div>
                <!-- .row -->
            </div>
            <!-- .card -->
        </div>
        <!-- .card-body -->
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include '../includes/footer.php'; ?>
<script>
    $("document").ready(function() {
        $("#employee_choose").change(function() {
            window.top.location = "index.php?emp_choosed=" + $(this).val();

        });

    });
</script>
</body>

</html>