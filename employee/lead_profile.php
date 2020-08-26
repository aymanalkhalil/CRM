<?php
include '../includes/header_emp.php';

include '../includes/config.php';


$lead_id = $_GET['lead_id'];

$date = date('Y-m-d');

if (isset($_POST['add'])) {

    $call_note = $_POST['call_note'];
    $call_result = $_POST['call_result'];
    $call_date = $_POST['call_date'];
    $call_time = $_POST['call_time'];
    date_default_timezone_set('EET');
    $date_talked = date('Y-m-d h:i:s');


    if ($call_result == "Not Interested - غير مهتم") {

        $insert = "INSERT INTO lead_calls (call_lead_id,call_date_time,call_result,call_note) VALUES ('$lead_id','$date_talked','$call_result','$call_note')";
        $res = mysqli_query($con, $insert);
    } else if ($call_result == "Not Used - غير مستعمل") {

        $insert = "INSERT INTO lead_calls (call_lead_id,call_date_time,call_result,call_note) VALUES ('$lead_id','$date_talked','$call_result','Not Used - غير مستعمل')";
        $res = mysqli_query($con, $insert);
    } else if ($call_result == "Registered Successfully - تم التسجيل") {
        $insert = "INSERT INTO lead_calls (call_lead_id,call_date_time,call_result,call_note) VALUES ('$lead_id','$date_talked','$call_result','Registered Successfully - تم التسجيل')";
        $res = mysqli_query($con, $insert);
    } else {
        $insert = "INSERT INTO lead_calls (call_lead_id,call_date_time,call_result,call_date,call_time,call_note) VALUES ('$lead_id','$date_talked','$call_result','$call_date','$call_time','$call_note')";
        $res = mysqli_query($con, $insert);
    }
    if ($res) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Add Note Successfully - تم اضافة الملاحظة </div>";

        echo "<script type='text/Javascript'>
      window.setTimeout(function() {
        window.location.href = 'lead_profile.php?lead_id=$lead_id';
            }, 2000);</script>";
    } else {

        echo "Error In saving Note" . mysqli_error($con);
    }
}

if (isset($_POST['edit'])) {
    $call_id = $_POST['call_id'];
    $edit_call_result = $_POST['edit_call_result'];
    $edit_call_date = $_POST['edit_call_date'];
    $edit_call_time = $_POST['edit_call_time'];
    $edit_call_note = $_POST['edit_call_note'];

    if ($edit_call_result == "Not Interested - غير مهتم") {

        $update = "UPDATE lead_calls SET call_lead_id='$lead_id', call_result='$edit_call_result',"
            . "call_note='$edit_call_note' WHERE call_id='$call_id'";

        $res = mysqli_query($con, $update);
    } else if ($edit_call_result == "Not Used - غير مستعمل") {
        $update = "UPDATE lead_calls SET call_lead_id='$lead_id', call_result='$edit_call_result',"
            . "call_note='Not Used - غير مستعمل' WHERE call_id='$call_id'";

        $res = mysqli_query($con, $update);
    } else if ($edit_call_result == "Registered Successfully - تم التسجيل") {
        $update = "UPDATE lead_calls SET call_lead_id='$lead_id', call_result='$edit_call_result',"
            . "call_note='Registered Successfully - تم التسجيل' WHERE call_id='$call_id'";

        $res = mysqli_query($con, $update);
    } else {
        $update = "UPDATE lead_calls SET call_lead_id='$lead_id', call_result='$edit_call_result',"
            . "call_date='$edit_call_date',call_time='$edit_call_time',call_note='$edit_call_note' WHERE call_id='$call_id'";

        $res = mysqli_query($con, $update);
    }


    if ($res) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Edit Note Successfully - تم تعديل الملاحظة</div>";

        echo "<script type='text/Javascript'>
      window.setTimeout(function() {
        window.location.href = 'lead_profile.php?lead_id=$lead_id';
    }, 2000);</script>";
    } else {

        echo "Error In Update Note " . mysqli_error($con);
    }
}

if (isset($_POST['remove'])) {
    $call_id = $_POST['call_id'];

    $delete = "DELETE FROM lead_calls WHERE call_id='$call_id'";
    $res = mysqli_query($con, $delete);

    if ($res) {

        echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>Note Deleted Successfully - تم حذف الملاحظة </div>";

        echo "<script type='text/Javascript'>
      window.setTimeout(function() {
        window.location.href = 'lead_profile.php?lead_id=$lead_id';
    }, 2000);</script>";
    } else {

        echo "Error In Deleting Note " . mysqli_error($con);
    }
}
?>


<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- display admin -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <div class="row">
                            <?php
                            $query = "SELECT * FROM lead, categorie WHERE categorie.cat_id = lead.lead_cat_id AND lead_id='$lead_id'";
                            $res = mysqli_query($con, $query);
                            $row = mysqli_fetch_assoc($res);
                            ?>

                            <div class="col-12">
                                <div class="row">

                                    <div class="col-6 d-flex-justify-content-start">
                                        <?php if (strstr($_SERVER['HTTP_REFERER'], 'index.php')) { ?>
                                            <h4>
                                                <a class="btn btn-link text-light" href="index.php"><i class="fa fa-arrow-left">Back To Homepage - الرجوع للصفحة الرئيسية </a></i>

                                            </h4>
                                        <?php } ?>
                                    </div>


                                    <div class="col-6 d-flex-justify-content-end text-right">
                                        <?php if (strstr($_SERVER['HTTP_REFERER'], 'called_leads.php')) { ?>

                                            <h4><?php echo $row['lead_name']; ?><a class="btn btn-link text-light" href="called_leads.php">Back <i class="fa fa-arrow-right"></i></a></h4>

                                        <?php } elseif (strstr($_SERVER['HTTP_REFERER'], 'registered_leads.php')) { ?>

                                            <h4><?php echo $row['lead_name']; ?><a class="btn btn-link text-light" href="registered_leads.php">Back <i class="fa fa-arrow-right"></i></a></h4>

                                        <?php } else { ?>

                                            <h4><?php echo $row['lead_name']; ?><a class="btn btn-link text-light" href="emp_tasks.php">Back <i class="fa fa-arrow-right"></i></a></h4>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Name</label>
                                            <input type="text" name="course_name" autocomplete="off" readonly="on" value="<?php echo $row['lead_name'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_email'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Mobile Number</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_mobile'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Major</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_major'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">University</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_university'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_address'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Interested</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_interested'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Source</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['lead_source'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Category</label>
                                            <input type="text" autocomplete="off" readonly="on" value="<?php echo $row['cat_name'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-2">
                                        <div class="form-group">

                                            <button type="button" data-toggle="modal" data-target="#addnotes" class="btn btn-primary">Add Notes - اضافة ملاحظة </button>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group pull-right">

                                            <a href="update_lead_profile.php?lead_id=<?php echo $lead_id; ?>" class="btn btn-warning">Update Lead Info - تعديل بيانات الطالب</a>
                                        </div>
                                    </div>



                                    <!-- Modal-->

                                    <div class="modal fade" id="addnotes" tabindex="-1" role="dialog" aria-labelledby="import_leadsTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-light">
                                                    <h5 class="modal-title d-inline-block ">Add Notes - اضافة ملاحظة</h5>
                                                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="post" role="form">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="source1">Call Result - نتيجة المكالمة</label>
                                                            <select class="form-control" id="call_result" name="call_result" required>
                                                                <option selected disabled value="0">يرجى اختيار نتيجة المكالمة</option>
                                                                <option value="Registered Successfully - تم التسجيل">Registered Successfully - تم التسجيل</option>
                                                                <option value="Not Interested - غير مهتم">Not Interested - غير مهتم</option>
                                                                <option value="Interested - مهتم">Interested - مهتم</option>
                                                                <option value="Hesitant - متردد">Hesitant - متردد</option>
                                                                <option value="Not Used - غير مستعمل">Not Used - غير مستعمل</option>
                                                            </select>
                                                        </div>
                                                        <div class="show-schedule">
                                                            <div class="form-group">
                                                                <label for="source1">Schedule Next Call - اختيار تاريخ المكالمة القادمة </label>
                                                                <input type="date" name="call_date" class="form-control" value="<?php echo $date; ?>" min="<?php echo $date; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="source1">Schedule Next Call Time - اختيار وقت المكالمة القادمة </label>
                                                                <input type="time" name="call_time" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="show-note">
                                                            <div class="form-group">
                                                                <label for="source1">Note - الملاحظة</label>
                                                                <textarea name="call_note" id="Note" class="form-control" autocomplete="off" required></textarea>
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="add">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->

                                </div>
                            </div>
                        </form>

                        <form action="" method="post">
                            <div class="table-responsive">
                                <div id="row">
                                    <table class="table table-striped table-bordered calls_result">

                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>وقت وتاريخ المكالمة الاولى</th>
                                                <th>نتيجة المكالمة</th>
                                                <th> تاريخ المكالمة القادمة</th>
                                                <th> وقت المكالمة القادمة </th>
                                                <th> الملاحظة </th>
                                                <th>تعديل </th>
                                                <th> مسح</th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                            $retrieveData = "SELECT * FROM lead_calls WHERE call_lead_id='$lead_id'";
                                            $data = mysqli_query($con, $retrieveData);
                                            if (mysqli_num_rows($data) > 0) {
                                                $i = 1;
                                                while ($row = mysqli_fetch_assoc($data)) {
                                                    ?>
                                                    <tr>

                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $row['call_date_time']; ?></td>
                                                        <td class='take_value'><?php echo $row['call_result']; ?></td>
                                                        <td><?php echo isset($row['call_date']) ? $row['call_date'] : 'لا يوجد'; ?></td>
                                                        <td><?php echo isset($row['call_time']) ? date('h:i A ', strtotime($row['call_time'])) : 'لا يوجد' ?></td>
                                                        <td><?php echo $row['call_note']; ?></td>



                                                        <td><input type='hidden' name='call_id' value='<?php echo $row['call_id']; ?>'>
                                                            <button type='button' data-toggle="modal" data-target="#editnotes<?php echo $i; ?>" class='btn btn-info Edit-btn'> Edit </button></td>


                                                        <td>

                                                            <input type='hidden' name='call_id' value='<?php echo $row['call_id']; ?>'>
                                                            <button type='submit' name="remove" class='btn btn-danger'> Delete </button> </td>

                                                    </tr>

                                                    <!-- Modal-->

                                                    <div class="modal fade" id="editnotes<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="import_leadsTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary text-light">
                                                                    <h5 class="modal-title d-inline-block">Edit Notes - تعديل الملاحظة</h5>
                                                                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="" method="POST">
                                                                    <div class="modal-body">

                                                                        <div class="form-group">
                                                                            <label for="source1">Modify Call Result - تعديل نتيجة المكالمة </label>
                                                                            <select class='form-control edit_call_result2' name='edit_call_result' required>
                                                                                <option disabled value='0'>يرجى اختيار نتيجة المكالمة</option>
                                                                                <option <?php echo $row['call_result'] == 'Registered Successfully - تم التسجيل' ? 'selected' : ''; ?> value="Registered Successfully - تم التسجيل">Registered Successfully - تم التسجيل</option>
                                                                                <option <?php echo $row['call_result'] == 'Not Interested - غير مهتم' ? 'selected' : ''; ?> value="Not Interested - غير مهتم">Not Interested - غير مهتم</option>
                                                                                <option <?php echo $row['call_result'] == 'Interested - مهتم' ? 'selected' : ''; ?> value="Interested - مهتم">Interested - مهتم</option>
                                                                                <option <?php echo $row['call_result'] == 'Hesitant - متردد' ? 'selected' : ''; ?> value="Hesitant - متردد">Hesitant - متردد</option>
                                                                                <option <?php echo $row['call_result'] == 'Not Used - غير مستعمل' ? 'selected' : ''; ?> value="Not Used - غير مستعمل">Not Used - غير مستعمل</option>

                                                                            </select>

                                                                        </div>

                                                                        <div class="edit-show-schedule">
                                                                            <div class="form-group">
                                                                                <label for="source1">Modify Next Call Date - تعديل تاريخ المكالمة القادمة </label>
                                                                                <input type="date" name="edit_call_date" class="form-control" value="<?php echo $row['call_date']; ?>" min="<?php echo $row['call_date']; ?>">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="source1">Modify Next Call Time - تعديل وقت المكالمة القادمة </label>
                                                                                <input type="time" name="edit_call_time" class="form-control" value="<?php echo $row['call_time'] ?>">
                                                                            </div>

                                                                        </div>
                                                                        <div class="edit-note">
                                                                            <div class="form-group">
                                                                                <label for="source1">Modify Notes - تعديل الملاحظة</label>
                                                                                <input type='hidden' name='call_id' value='<?php echo $row['call_id']; ?>'>
                                                                                <textarea name="edit_call_note" class="form-control" autocomplete="off" required><?php echo $row['call_note']; ?></textarea>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary" name="edit">Save - حفظ</button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!--end modal -->



                                            <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="row2"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- / .display admin -->
        </div>
        <!-- / .Animated -->
    </div>
</div>
<!-- /.content -->

<?php include '../includes/footer.php'; ?>
<script>
    $("document").ready(function() {

        $(".show-schedule").hide();
        $("#call_result").change(function() {
            var Choosed = ($("#call_result").val());

            if (Choosed == "Interested - مهتم" || Choosed == "Hesitant - متردد") {
                $(".show-schedule").show();
                $(".show-note").show();
            } else {
                $(".show-schedule").hide();
                $(".show-note").show();
            }
            if (Choosed == "Not Used - غير مستعمل" || Choosed == "Registered Successfully - تم التسجيل") {
                $("#Note").removeAttr('required');
                $(".show-note").hide();
            }
        });

        // $(function() {
        //     $('tr td:even').css('background', '#5ae');
        // });

        $(".edit-show-schedule").show();
        $(".edit-note").hide();

            $('.Edit-btn').click(function() {
                var Edit_Choosed = ($(".edit_call_result2").val());
                console.log(Edit_Choosed);
                if (Edit_Choosed == "Interested - مهتم" || Edit_Choosed == "Hesitant - متردد") {
                    $(".edit-show-schedule").show();
                    $(".edit-note").show();

                } else {
                    $(".edit-show-schedule").hide();
                    $(".edit-note").show();
                }
                if (Edit_Choosed == "Not Used - غير مستعمل" || Edit_Choosed == "Registered Successfully - تم التسجيل") {
                    $(".edit-note").removeAttr('required');
                    $(".edit-note").hide();
                    $(".edit-show-schedule").hide();
                }
            });


                $(".edit_call_result2").change(function() {
                    var Change_Choosed = ($(this).val());
                    // alert(Change_Choosed);
                    if (Change_Choosed == "Interested - مهتم" || Change_Choosed == "Hesitant - متردد") {
                        $(".edit-show-schedule").show();
                        $(".edit-note").show();
                    } else {
                        $(".edit-show-schedule").hide();
                        $(".edit-note").show();
                    }
                    if (Change_Choosed == "Not Used - غير مستعمل" || Change_Choosed == "Registered Successfully - تم التسجيل") {
                        $(".edit-note").removeAttr('required');
                        $(".edit-note").hide();
                        $(".edit-show-schedule").hide();
                    }
                });


    });
</script>

</body>

</html>