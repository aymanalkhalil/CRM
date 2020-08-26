<?php include '../includes/header_admin.php'; ?>
<?php
include '../includes/config.php';
global $con;
$msg = "";
if (isset($_POST['add'])) {
    $full_name = $_POST['full_name'];
    $email    = $_POST['email'];
    /* Encrypt a password */
    $password = $_POST['password'];
    $phone    = $_POST['phone'];
    $work_from = $_POST['work_from'];
    $work_to = $_POST['work_to'];

    if ($_FILES['img']['error'] == 0) {
        $target = "../images/avatar/" . time() . $_FILES['img']['name'];
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $insert = "INSERT INTO employee(emp_name,emp_email,emp_password, emp_phone, emp_img,work_from,work_to) VALUES
          ('$full_name','$email','$password', '$phone', '$target','$work_from','$work_to')";
            $result = mysqli_query($con, $insert);
        }
    }
    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Employee Added Successfully - تم اضافة الموظف </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'employee.php';
             }, 2000);</script>";
    } else {

        echo "Error In Adding Employee " . mysqli_error($con);
    }
}

/* check if user exist */
// $sql = "SELECT email FROM employee WHERE emp_email='$email'";
// $result = mysqli_query($con, $sql);

// if (mysqli_num_rows($result) > 0) {
//      $msg = "This employee is exist";
// } else {


// }



if (isset($_POST['remove'])) {
    $id      = $_POST['id'];
    $delete  = "DELETE FROM employee WHERE emp_id='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Employee Deleted Successfully - تم حذف الموظف </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'employee.php';
             }, 2000);</script>";
    } else {

        echo "Error In Deleting Employee " . mysqli_error($con);
    }
}

if (isset($_POST['edit'])) {
    $id       = $_POST['id'];
    $name     = $_POST['full_name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $phone    = $_POST['phone'];
    $old_img  = $_POST['old_img'];
    $edit_work_from = $_POST['edit_work_from'];
    $edit_work_to = $_POST['edit_work_to'];

    if ($_FILES['img']['error'] == 0) {
        $target = "../images/avatar/" . time() . $_FILES['img']['name'];
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            if ($password == '') {
                $update   = "UPDATE employee SET emp_name='$name', emp_email='$email', emp_phone='$phone', emp_img='$target' , work_from='$edit_work_from' ,work_to='$edit_work_to' WHERE emp_id='$id'";
                $result = mysqli_query($con, $update);
            } else {
                $update   = "UPDATE employee SET emp_name='$name', emp_email='$email', emp_phone='$phone', emp_password='$password', emp_img='$target', work_from='$edit_work_from' ,work_to='$edit_work_to' WHERE emp_id='$id'";
                $result = mysqli_query($con, $update);
            }
            unlink($old_img);
        }
    } else {
        if ($password == '') {
            $update   = "UPDATE employee SET emp_name='$name', emp_email='$email', emp_phone='$phone', work_from='$edit_work_from' ,work_to='$edit_work_to' WHERE emp_id='$id'";
            $result = mysqli_query($con, $update);
        } else {
            $update   = "UPDATE employee SET emp_name='$name', emp_email='$email', emp_phone='$phone', emp_password='$password', work_from='$edit_work_from' ,work_to='$edit_work_to' WHERE emp_id='$id'";
            $result = mysqli_query($con, $update);
        }
    }
    // header('Location: employee.php');

}

?>

<div class='container'>
    <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">

            <!-- add admin -->
            <div class="row-fluid">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-light">
                            <strong class="card-title">Add Employee</strong>
                        </div>
                        <div class="card-body card-block position-relative">
                            <form id="add_emp" action="" method="POST" class="" validate role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                        <input type="text" id="full_name" name="full_name" placeholder="Full Name" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-phone-alt"></i></div>
                                        <input type="text" id="phone" name="phone" placeholder="Phone Number" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                        <input type="email" id="email" name="email" placeholder="Email" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                        <input type="password" id="password" name="password" placeholder="Password" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                        <input type="password" id="Cpassword" name="Cpassword" placeholder="Confirm Password" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-user-clock"></i></div>
                                        <input type="time" name="work_from" placeholder="Work Time From" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-user-clock"></i></div>
                                        <input type="time" name="work_to" placeholder="Work Time To" class="form-control" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-image"></i></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="img" id="customFile" required accept="image/*">
                                            <label class="custom-file-label" for="customFile">Choose Image</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions form-group"><button type="submit" class="btn btn-success btn-sm" name="add" value="add">Submit</button></div>
                            </form>
                            <?php if ($msg != "") { ?>
                                <div class="alert alert-danger position-absolute w-50 p-2 text-center" style="right:10px;bottom:10px">
                                    <?php echo $msg; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- / .add admin -->

            <!-- display admin -->
            <div class="row-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-light">
                            <strong class="card-title">Employee</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Work time from</th>
                                            <th>Work time to</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $retrieveData   = "SELECT * FROM employee";
                                        $resultRetrieve = mysqli_query($con, $retrieveData);
                                        if (mysqli_num_rows($resultRetrieve) > 0) {
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><img src="<?php echo $row['emp_img'] ?>" width="45px" height="45px" class="rounded-circle"></td>
                                                    <td><?php echo $row['emp_name']; ?></td>
                                                    <td><?php echo $row['emp_email']; ?></td>
                                                    <td><?php echo $row['emp_phone']; ?></td>
                                                    <td><?php echo date('h:i A', strtotime($row['work_from'])) ?></td>
                                                    <td><?php echo date('h:i A', strtotime($row['work_to'])) ?></td>
                                                    <td>
                                                        <!-- modal -->
                                                        <!-- Button trigger modal -->
                                                        <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modal<?php echo $i; ?>'>
                                                            Edit
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class='modal fade' id='modal<?php echo $i; ?>' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                                                            <div class='modal-dialog modal-dialog-centered' role='document'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header bg-primary text-light'>
                                                                        <h5 class='modal-title d-inline' id='exampleModalLongTitle<?php echo $i; ?>'>Edit Employee
                                                                        </h5>
                                                                        <button type='button' class='close text-light' data-dismiss='modal' aria-label='Close'>
                                                                            <span aria-hidden='true'>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class='modal-body pb-0'>
                                                                        <!-- form edit admin -->
                                                                        <form id='edit_emp<?php echo $i; ?>' action='' method='POST' class="" role="form" enctype="multipart/form-data">
                                                                            <input type='hidden' name='id' value='<?php echo $row['emp_id']; ?>'>
                                                                            <input type="hidden" name="old_img" value="<?php echo $row['emp_img']; ?>">
                                                                            <div class='form-group'>
                                                                                <div class='input-group'>
                                                                                    <div class='input-group-addon'><i class='fa fa-user'></i></div>
                                                                                    <input type='text' id='efull_name<?php echo $i; ?>' name='full_name' placeholder='Fall Name' class='form-control' required autocomplete='off' value="<?php echo $row['emp_name']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-addon"><i class="fa fa-phone-alt"></i></div>
                                                                                    <input type="text" id="phone<?php echo $i; ?>" name="phone" placeholder="Phone Number" class="form-control" required autocomplete="off" value="<?php echo $row['emp_phone']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class='form-group'>
                                                                                <div class='input-group'>
                                                                                    <div class='input-group-addon'><i class='fa fa-envelope'></i></div>
                                                                                    <input type='email' id='eEmail<?php echo $i; ?>' name='email' placeholder='Email' class='form-control' required autocomplete='off' value="<?php echo $row['emp_email']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class='form-group'>
                                                                                <div class='input-group'>
                                                                                    <div class='input-group-addon'><i class='fa fa-asterisk'></i></div>
                                                                                    <input type='password' id='ePassword<?php echo $i; ?>' name='password' placeholder='Password' class='form-control' autocomplete='off'>
                                                                                </div>
                                                                            </div>
                                                                            <div class='form-group'>
                                                                                <div class='input-group'>
                                                                                    <div class='input-group-addon'><i class='fa fa-asterisk'></i></div>
                                                                                    <input type='password' id='eCpassword<?php echo $i; ?>' name='Cpassword' placeholder='Confirm Password' class='form-control' autocomplete='off'>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-addon"><i class="fas fa-user-clock"></i></div>
                                                                                    <input type="time" name="edit_work_from" value='<?php echo $row['work_from'] ?>' class="form-control" autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-addon"><i class="fas fa-user-clock"></i></div>
                                                                                    <input type="time" name="edit_work_to" value='<?php echo $row['work_to'] ?>' class="form-control" autocomplete="off">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-addon"><i class="fa fa-image"></i></div>
                                                                                    <div class="custom-file">
                                                                                        <input type="file" class="custom-file-input" name="img" id="customFile<?php echo $i; ?>" accept="image/*">
                                                                                        <label class="custom-file-label" for="customFile<?php echo $i; ?>">Choose Image</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class='modal-footer'>
                                                                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                                                                <button type='submit' class='btn btn-primary' name="edit" value="edit">Save changes</button>
                                                                            </div>
                                                                        </form>
                                                                        <!-- end form -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end modal -->
                                                        <form id='option<?php echo $i; ?>' action='employee.php' method='POST' class='d-inline'>
                                                            <input type='hidden' name='id' value='<?php echo $row['emp_id']; ?>'>
                                                            <button class='btn btn-danger btn-sm' type='submit' name='remove' vlaue='remove'>Remove</button>
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
            <!-- / .display admin -->

        </div>
        <!-- / .Animated -->

    </div>
    <!-- /.content -->
</div>

<?php include '../includes/footer.php'; ?>
<script>
    $(document).ready(function() {
        $("#add_admin").submit(function(event) {
            if ($('#password').val() == $('#Cpassword').val()) {
                return;
            } else {
                $('#Cpassword').css('border-color', 'red');
            }
            event.preventDefault();
        });
    });
</script>
</body>

</html>