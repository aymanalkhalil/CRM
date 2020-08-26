<?php include '../includes/header_admin.php'; ?>
<?php
include '../includes/config.php';
global $con;

if (isset($_POST['add'])) {
  $cat_name = $_POST['cat_name'];


  $insert = "INSERT INTO categorie(cat_name) VALUES ('$cat_name')";
  $result = mysqli_query($con, $insert);
  if ($result) {

    echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Category Added Successfully </div>";

    echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'categorie.php';
         }, 2000);</script>";
  } else {

    echo "Error In Adding category " . mysqli_error($con);
  }
}

if (isset($_POST['remove'])) {
  $cat_id = $_POST['cat_id'];
  $delete = "DELETE FROM categorie WHERE cat_id='$cat_id'";
  $result = mysqli_query($con, $delete);
  if ($result) {

    echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Category Deleted Successfully </div>";

    echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'categorie.php';
         }, 2000);</script>";
  } else {

    echo "Error In Deleting Category " . mysqli_error($con);
  }
}

if (isset($_POST['edit'])) {
  $cat_id   = $_POST['cat_id'];
  $cat_name = $_POST['cat_name'];

  $update   = "UPDATE categorie SET cat_name='$cat_name'WHERE cat_id='$cat_id'";
  $result=mysqli_query($con, $update);
  if ($result) {

    echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Category Updated Successfully </div>";

    echo "<script type='text/Javascript'>
         window.setTimeout(function() {
         window.location.href = 'categorie.php';
         }, 2000);</script>";
  } else {

    echo "Error In Updating Category " . mysqli_error($con);
  }
}

?>


<div class='container'>
<!-- Content -->
<div class="content">
  <!-- Animated -->
  <div class="animated fadeIn">

    <!-- add Categorie -->
    <div class="row-fluid">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-primary text-light">
            <strong class="card-title">Add Category</strong>
          </div>
          <div class="card-body card-block position-relative">
            <form id="add_categorie" action="categorie.php" method="POST" class="" validate>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-user"></i></div>
                  <input type="text" id="cat_name" name="cat_name" placeholder="Category Name" class="form-control" required autocomplete="off">
                </div>
              </div>

              <div class="form-actions form-group">
                <button type="submit" class="btn btn-success btn-sm" name="add" value="add">Submit</button></div>
            </form>

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
            <strong class="card-title">Categories</strong>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="bootstrap-data-table" class="table table-striped table-bordered">

                <thead>
                  <tr>
                    <th>#</th>
                    <th>Category Name</th>
                    <th>Option</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $retrieveData   = "SELECT * FROM categorie";
                  $resultRetrieve = mysqli_query($con, $retrieveData);
                  if (mysqli_num_rows($resultRetrieve) > 0) {
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['cat_name']; ?></td>
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
                                  <h5 class='modal-title d-inline' id='exampleModalLongTitle<?php echo $i; ?>'>Edit Categories
                                  </h5>
                                  <button type='button' class='close text-light' data-dismiss='modal' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                  </button>
                                </div>
                                <div class='modal-body pb-0'>
                                  <!-- form edit categorie -->
                                  <form id='edit_categorie<?php echo $i; ?>' action='' method='POST' enctype="multipart/form-data" class="">
                                    <input type='hidden' name='cat_id' value='<?php echo $row['cat_id']; ?>'>

                                    <div class='form-group'>
                                      <div class='input-group'>
                                        <div class='input-group-addon'><i class='fa fa-user'></i></div>
                                        <input type='text' id='cat_name<?php echo $i; ?>' name='cat_name' placeholder='Categorie Name' class='form-control' required autocomplete='off' value="<?php echo $row['cat_name']; ?>">
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
                          <form id='option<?php echo $i; ?>' action='categorie.php' method='POST' class='d-inline'>
                            <input type='hidden' name='cat_id' value='<?php echo $row['cat_id']; ?>'>
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