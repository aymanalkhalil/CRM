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



    $insert = "INSERT INTO admin(admin_name,admin_email,admin_password) VALUES
              ('$full_name','$email','$password')";
    $result = mysqli_query($con, $insert);
    //  getAccount($email,$password);

    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Admin Added Successfully - تم اضافة المشرف  </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'admin.php';
             }, 2000);</script>";
    } else {

        echo "Error In Adding Admin " . mysqli_error($con);
    }
}

if (isset($_POST['remove'])) {
    $id      = $_POST['id'];
    $delete  = "DELETE FROM admin WHERE admin_id='$id'";
    $result = mysqli_query($con, $delete);
    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Admin Deleted Successfully - تم حدف المشرف  </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'admin.php';
             }, 2000);</script>";
    } else {

        echo "Error In Deleting Admin " . mysqli_error($con);
    }
}

if (isset($_POST['edit'])) {
    $id       = $_POST['id'];
    $name     = $_POST['full_name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];


    if ($password == '') {
        $update   = "UPDATE admin SET admin_name='$name', admin_email='$email' WHERE admin_id='$id'";
        $result = mysqli_query($con, $update);
    } else {
        $update   = "UPDATE admin SET admin_name='$name', admin_email='$email', admin_password='$password' WHERE admin_id='$id'";
        $result = mysqli_query($con, $update);
    }
    if ($result) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Admin Updated Successfully - تم تعديل بيانات المشرف  </div>";

        echo "<script type='text/Javascript'>
             window.setTimeout(function() {
             window.location.href = 'admin.php';
             }, 2000);</script>";
    } else {

        echo "Error In Updating Admin " . mysqli_error($con);
    }
}
?>



<!-- Content -->
<div class='container'>
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">

        <!-- add admin -->
        <div class="row-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <strong class="card-title">Add Admin</strong>
                    </div>
                    <div class="card-body card-block position-relative">
                        <form id="add_admin" action="admin.php" method="POST" class="" validate>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <input type="text" id="full_name" name="full_name" placeholder="Full Name" class="form-control" required autocomplete="off">
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
                        <strong class="card-title">Admin</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $retrieveData   = "SELECT * FROM admin";
                                    $resultRetrieve = mysqli_query($con, $retrieveData);
                                    if (mysqli_num_rows($resultRetrieve) > 0) {
                                        $i = 1;
                                        while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['admin_name']; ?></td>
                                                <td><?php echo $row['admin_email']; ?></td>
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
                                                                    <h5 class='modal-title d-inline' id='exampleModalLongTitle<?php echo $i; ?>'>Edit Admin
                                                                    </h5>
                                                                    <button type='button' class='close text-light' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body pb-0'>
                                                                    <!-- form edit admin -->
                                                                    <form id='edit_admin<?php echo $i; ?>' action='admin.php' method='POST' enctype="multipart/form-data" class="">
                                                                        <input type='hidden' name='id' value='<?php echo $row['admin_id']; ?>'>
                                                                        <div class='form-group'>
                                                                            <div class='input-group'>
                                                                                <div class='input-group-addon'><i class='fa fa-user'></i></div>
                                                                                <input type='text' id='efull_name<?php echo $i; ?>' name='full_name' placeholder='Fall Name' class='form-control' required autocomplete='off' value="<?php echo $row['admin_name']; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class='form-group'>
                                                                            <div class='input-group'>
                                                                                <div class='input-group-addon'><i class='fa fa-envelope'></i></div>
                                                                                <input type='email' id='eEmail<?php echo $i; ?>' name='email' placeholder='Email' class='form-control' required autocomplete='off' value="<?php echo $row['admin_email']; ?>">
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
                                                    <form id='option<?php echo $i; ?>' action='admin.php' method='POST' class='d-inline'>
                                                        <input type='hidden' name='id' value='<?php echo $row['admin_id']; ?>'>
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