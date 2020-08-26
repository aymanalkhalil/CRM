<?php
include '../includes/header_admin.php';
include '../includes/config.php';


$date = date('Y-m-d');

if (!isset($_SESSION['emp_choosed'])) {
    $_SESSION['emp_choosed']= -1;
}
if(isset($_GET['emp_choosed'])){
    $_SESSION['emp_choosed']= $_GET['emp_choosed'];
    echo '<script> window.top.location="emp_notification.php"; </script>';
}
$emp_id="SELECT emp_id FROM employee";
$ress=mysqli_query($con,$emp_id);
$id_to_insert = array();

// echo "<pre>";
// print_r($ins);
global $emp_choosed;
if (isset($_POST['send'])) {
    $emp_choosed = $_POST['emp_id'];
    $due_date = $_POST['due_date'];
    $message = $_POST['message'];
    $priority = $_POST['priority'];
    $message_appear = $_POST['message_appear'];


    if($_SESSION['emp_choosed']== -1){
    while($rows=mysqli_fetch_assoc($ress)){
        $id_to_insert[]=$rows['emp_id'];
        }

       foreach($id_to_insert as $val){
        $query = "INSERT INTO emp_notification(notification_message,notification_due_date,notification_emp_id,notification_appear,notification_priority)
                      VALUES('$message','$due_date','$val','$message_appear','$priority')";
                       $result = mysqli_query($con, $query);
                }
    } else{

        $query = "INSERT INTO emp_notification(notification_message,notification_due_date,notification_emp_id,notification_appear,notification_priority)
                     VALUES('$message','$due_date','$emp_choosed','$message_appear','$priority')";
                $result = mysqli_query($con, $query);
       }
    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Message Send Successfully - تم ارسال التنبيه </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'emp_notification.php';
             }, 2000);</script>";
    } else {

        echo "Error In Sending Message " . mysqli_error($con);
    }
}

if (isset($_POST['edit'])) {
    $notify_id   = $_POST['notification_id'];
    $notify_msg = $_POST['edit_message'];
    $notify_due = $_POST['edit_due_date'];
    $notify_appear = $_POST['edit_appear'];
    $edit_priority=$_POST['edit_priority'];
    $edit_emp_name=$_POST['edit_emp_name'];

    if($_SESSION['emp_choosed']== -1){
        while($rows=mysqli_fetch_assoc($ress)){
            $id_to_insert[]=$rows['emp_id'];
            }
            foreach($id_to_insert as $val){
                $update   = "UPDATE emp_notification SET notification_message='$notify_msg',notification_due_date='$notify_due'
                ,notification_emp_id='$val',notification_appear='$notify_appear',notification_priority='$edit_priority'
                WHERE notification_id=$notify_id";
                $update_success=mysqli_query($con, $update);
                  }
        } else{

            $update = "UPDATE emp_notification SET notification_message='$notify_msg',notification_due_date='$notify_due'
            ,notification_emp_id='$edit_emp_name',notification_appear='$notify_appear',notification_priority='$edit_priority'
            WHERE notification_id=$notify_id";
                    $update_success = mysqli_query($con, $update);
           }

    if ($update_success) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Message Updated Successfully - تم تعديل التنبيه </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'emp_notification.php';
             }, 2000);</script>";
    } else {

        echo "Error In Updating Message " . mysqli_error($con);
    }
}
if (isset($_POST['remove'])) {
$notification_id=$_POST['notification_id'];

$delete="DELETE FROM emp_notification where notification_id=$notification_id";
$deleteSuccess = mysqli_query($con, $delete);

if($deleteSuccess){
    echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>Message Deleted Successfully - تم حذف التنبيه </div>";

    echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'emp_notification.php';
         }, 2000);</script>";
}else {

    echo "Error In Deleting Message " . mysqli_error($con);
}

}

?>
<div class='container'>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

        <!-- display admin -->
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center text-light">
                                <strong class="card-title m-0 ">Send Notification To Employee</strong>
                            </div>

                        </div>

                    </div>

                    <form action="" method="POST">
                        <div class="card-body">

                            <div class='row'>
                                <div class='col-6'>

                                    <div class="form-group">
                                        <label for="employee">Choose Employee </label>
                                        <select class="form-control" name="emp_id" id="employee_choose" required>
                                            <?php

                                            $sql = "SELECT emp_id,emp_name FROM employee";
                                            $res = mysqli_query($con, $sql);
                                            echo "<option selected value='-1'>All Employees</option>";
                                            while ($row = mysqli_fetch_assoc($res)){
                                            if ($_SESSION['emp_choosed']==$row['emp_id']){
                                               echo "<option selected value='{$row['emp_id']}'>". $row['emp_name'] ."</option>";
                                            }else{
                                                echo "<option value='{$row['emp_id']}'>". $row['emp_name'] ."</option>";
                                            }
                                        }

                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="priority">Choose Priority </label>
                                        <select class="form-control" id='priority' name="priority" required>
                                            <option disabled selected>Choose Priority</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>

                                    </div>
                                </div>

                            </div>

                            <div class='row'>
                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="Date Appear">Choose What Date Should This Message Appears </label>
                                        <input type="date" class="form-control" value="<?php echo $date; ?>" name="message_appear" required>
                                    </div>
                                </div>

                                <div class='col-6'>
                                    <div class="form-group">
                                        <label for="Month From">Choose Dead Line For The Task</label>
                                        <input type="date" class="form-control" value="<?php echo $date; ?>" name="due_date" id="date_from" required>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-12'>
                                    <div class="form-group">
                                        <label for="Message">Message</label>
                                        <textarea rows=10 class="form-control" name='message' required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-success" name="send" value="add">Send Message</button>

                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
    <div class="row-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <strong class="card-title">View Notification</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered table-sm">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Recipent </th>
                                    <th>Message</th>
                                    <th>Due Date</th>
                                    <th>Message Appear in</th>
                                    <th>Priority</th>
                                    <th>View Reply</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $retrieveData   = "SELECT * FROM emp_notification INNER JOIN employee
                                ON emp_notification.notification_emp_id=employee.emp_id ORDER BY notification_id DESC";
                                $resultRetrieve = mysqli_query($con, $retrieveData);
                                if (mysqli_num_rows($resultRetrieve) > 0) {
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                        if ($row['notification_priority'] == "High") {

                                            $priority = "style='color:#dc3545'";
                                        } else if ($row['notification_priority'] == "Medium") {
                                            $priority = "style='color:#fd7e14'";
                                        } else if ($row['notification_priority'] == "Low") {
                                            $priority = "style='color:#ffc107'";
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['emp_name']; ?></td>
                                            <td><?php echo "<label dir='rtl'>" . $row['notification_message'] . "</label>" ?></td>
                                            <td><?php echo $row['notification_due_date']; ?></td>
                                            <td><?php echo $row['notification_appear']; ?></td>
                                            <td <?php echo $priority ?>><?php echo $row['notification_priority']; ?></td>
                                            <td>
                                            <?php if(!empty($row['notification_reply'])){ ?>
                                            <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#reply<?php echo $i; ?>'>
                                                    View Reply
                                                </button>
                                            <?php }else{ ?>
                                                <button type='button' class='btn btn-dark btn-sm' data-toggle='modal' data-target='#reply<?php echo $i; ?>'>
                                                    No Reply
                                                </button>

                                          <?php  } ?>



                                                <div class='modal fade' id='reply<?php echo $i; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-primary text-light'>
                                                                <h5 class='modal-title d-inline' id='exampleModalLongTitle'>

                                                                View Reply
                                                                </h5>
                                                                <button type='button' class='close text-light' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body pb-0'>
                                                                <!-- form edit notification -->
                                                                <form id='emp_notification.php<?php echo $i; ?>' action='' method='POST' >

                                                                <div class="form-group">
                                                                    <label for="message">Message That You Sent</label>
                                                                <textarea rows='8' dir='rtl' class='form-control' readonly><?php echo $row['notification_message']; ?> </textarea>
                                                                </div>
                                                                <?php if(!empty($row['notification_reply'])){ ?>
                                                                <div class="form-group">
                                                                    <label for="Respone">Employee Respond</label>
                                                                <textarea rows='8'  dir='rtl' class='form-control' readonly><?php echo $row['notification_reply']; ?> </textarea>
                                                                </div>
                                                                <?php }else{

                                                                    echo "<div class='col-12 btn btn-danger'>" . "No Reply Yet " . "</div>";

                                                                 } ?>





                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>

                                                                    </div>
                                                                </form>
                                                                <!-- end form -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>





                                            </td>


                                            <td>
                                                <!-- modal -->
                                                <!-- Button trigger modal -->
                                                <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal<?php echo $i; ?>'>
                                                    Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class='modal fade' id='modal<?php echo $i; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header bg-primary text-light'>
                                                                <h5 class='modal-title d-inline' id='exampleModalLongTitle'>

                                                                Edit Notification
                                                                </h5>
                                                                <button type='button' class='close text-light' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body pb-0'>
                                                                <!-- form edit notification -->
                                                                <form id='emp_notification.php<?php echo $i; ?>' action='' method='POST' >
                                                                    <input type='hidden' name='notification_id' value='<?php echo $row['notification_id']; ?>'>
                                                                    <div class="form-group">
                                                                            <label for="employee">Choose Employee </label>
                                                                            <select class="form-control" name="edit_emp_name" id="employee" required>
                                                                                <?php
                                                                                        $sql = "SELECT emp_id,emp_name FROM employee";
                                                                                        $res = mysqli_query($con, $sql);
                                                                                        echo "<option selected disabled value='-1'>Choose Employee</option>";
                                                                                        while ($row2 = mysqli_fetch_assoc($res)) {

                                                                                            if ($row2['emp_id'] == $row['emp_id']) {
                                                                                                echo '<option selected value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                                                                            } else {
                                                                                                echo '<option value="' . $row2['emp_id'] . '">' . $row2['emp_name'] . '</option>';
                                                                                            }
                                                                                        }
                                                                                        ?>

                                                                            </select>

                                                                        </div>
                                                                        <div class="form-group">
                                                                        <label for="priority">Choose Priority </label>
                                                                        <select class="form-control" id='priority' name="edit_priority" required>
                                                                            <option disabled selected>Choose Priority</option>
                                                                            <option <?php echo $row['notification_priority'] == 'High' ? 'selected' : ''; ?> value="High">High</option>
                                                                            <option <?php echo $row['notification_priority'] == 'Medium' ? 'selected' : ''; ?> value="Medium">Medium</option>
                                                                            <option <?php echo $row['notification_priority'] == 'Low' ? 'selected' : ''; ?> value="Low">Low</option>
                                                                        </select>

                                                                    </div>

                                                                    <div class='form-group'>
                                                                        <label for="message">Message Appear</label>
                                                                        <div class='input-group'>

                                                                            <input type='date' id='cat_name<?php echo $i; ?>' name='edit_appear' placeholder='Categorie Name' class='form-control' required  value="<?php echo $row['notification_appear']; ?>">

                                                                        </div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for="message">Due Date</label>
                                                                        <div class='input-group'>

                                                                            <input type='date' id='cat_name<?php echo $i; ?>' name='edit_due_date' placeholder='Categorie Name' class='form-control' required value="<?php echo $row['notification_due_date']; ?>">

                                                                        </div>
                                                                    </div>


                                                                            <div class="form-group">
                                                                            <label for="Message">Message</label>
                                                                            <textarea rows=8 dir='rtl' class="form-control" name='edit_message' required><?php echo $row['notification_message']?></textarea>
                                                                        </div>

                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                        <button type='submit' class='btn btn-primary' name="edit" value="edit">Send</button>
                                                                    </div>
                                                                </form>
                                                                <!-- end form -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end modal -->
                                                <form id='option<?php echo $i; ?>' action='emp_notification.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='notification_id' value='<?php echo $row['notification_id']; ?>'>
                                                    <button class='btn btn-danger btn-sm' type='submit' name='remove' vlaue='remove'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
                            </div>

<?php include '../includes/footer.php'; ?>
<script>
    $("document").ready(function() {
        $("#priority").change(function() {
            var Choosed = ($("#priority").val());
            if (Choosed == "High") {
                $("#priority").css("color", "#dc3545");

            } else if (Choosed == "Medium") {
                $("#priority").css("color", "#fd7e14");

            } else if (Choosed == "Low")

                $("#priority").css("color", "#ffc107");


        });

$("#employee_choose").change(function (){
    window.top.location = "emp_notification.php?emp_choosed=" + $(this).val();

});
    });
</script>