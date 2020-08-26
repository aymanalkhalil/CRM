<?php include_once "../includes/header_emp.php"; ?>


<?php
    $lead_id = $_GET['lead_id'];
if (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile_no'];
    $major = $_POST['major'];
    $university = $_POST['university'];
    $address = $_POST['address'];
    $interested = $_POST['interested'];
    $source = $_POST['source'];


    $update="UPDATE lead SET lead_name='$name',lead_email='$email',lead_mobile='$mobile',"
            . "lead_major='$major',lead_university='$university',lead_address='$address',"
            . "lead_interested='$interested',lead_source='$source'"
            . " where lead_id=$lead_id";
    $res = mysqli_query($con, $update);
    if($res){
         echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Update Lead Info  Successfully - تم تعديل البيانات </div>";

      echo "<script type='text/Javascript'>
      window.setTimeout(function() {
        window.location.href = 'lead_profile.php?lead_id=$lead_id';
    }, 2000);</script>";

    }else{
        echo "Error In Update Lead " . mysqli_error($con);
    }

}
?>
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">


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

                            <div class="col-12 text-right" >
                                <h4><?php echo $row['lead_name']; ?> <a class="btn btn-link text-light" href="lead_profile.php?lead_id=<?php echo $lead_id; ?>">Back <i class="fa fa-arrow-right"></i></a></h4>
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
                                            <input type="text" name="name" autocomplete="off"  value="<?php echo $row['lead_name'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email</label>
                                            <input type="text" name="email" autocomplete="off"  value="<?php echo $row['lead_email'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Mobile Number</label>
                                            <input type="text" name="mobile_no" autocomplete="off"  value="<?php echo $row['lead_mobile'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Major</label>
                                            <input type="text" name="major" autocomplete="off"  value="<?php echo $row['lead_major'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">University</label>
                                            <input type="text" name="university" autocomplete="off"  value="<?php echo $row['lead_university'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Address</label>
                                            <input type="text" name="address" autocomplete="off"   value="<?php echo $row['lead_address'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Interested</label>
                                            <input type="text" name="interested" autocomplete="off" value="<?php echo $row['lead_interested'] ?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Source</label>
                                            <input type="text" name="source" autocomplete="off"  value="<?php echo $row['lead_source'] ?>" class="form-control">
                                        </div>
                                    </div>

<!--                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Category</label>
                                            <input type="text" name="category" autocomplete="off"  value="<?php echo $row['cat_name'] ?>" class="form-control">
                                        </div>
                                    </div>-->
<!--                                    <div class="col-lg-6">  </div>-->


                                    <div class="col-lg-4">
                                        <div class="form-group">

                                            <input type="submit" name="edit"  value="Update" autocomplete="off"  class="btn btn-success">
                                        </div>
                                    </div>





                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>






<?php include_once "../includes/footer.php"; ?>
