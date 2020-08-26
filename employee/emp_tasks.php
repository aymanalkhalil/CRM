<?php
include '../includes/header_emp.php';
include '../includes/config.php';


global $con;
$msg = "";

if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_id'];
}

if (!isset($_SESSION['cat_id'])) {
    $_SESSION['cat_id'] = -1;
}
if (isset($_GET['cat_id'])) {
    $_SESSION['cat_id'] = $_GET['cat_id'];

    echo '<script> window.top.location="emp_tasks.php"; </script>';
}

if(!isset($_SESSION['num_rows'])){
    $_SESSION['num_rows'] = 15;
}

if(isset($_POST['sub_num'])){
    $_SESSION['num_rows'] = $_POST['num_row'];
    echo '<script>window.top.location = "emp_tasks.php"</script>';
}



if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * $_SESSION['num_rows']) - $_SESSION['num_rows'];
if($_SESSION['cat_id'] < 0){
    $totalLeadsSQL = "SELECT * FROM lead where lead_emp_id={$_SESSION['emp_id']}";
}else{
$totalLeadsSQL = "SELECT * FROM lead where lead_emp_id={$_SESSION['emp_id']} AND lead_cat_id={$_SESSION['cat_id']}";
}
$allLeadsResult = mysqli_query($con, $totalLeadsSQL);
$totalLeads = mysqli_num_rows($allLeadsResult);
$lastPage = ceil($totalLeads / $_SESSION['num_rows']);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;

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
                            <div class="col-4 d-flex align-items-center">
                                <strong class="card-title m-0 ">Leads</strong>
                            </div>
                            <!-- <div class="col-4">
                                <form action="" method="post" role="search">
                                    <div class="input-group">
                                        <input class="form-control" type="search" name="search"a autocomplete="off" id="search" placeholder="Search (Name, Category, University)">
                                    </div>
                                </form>
                            </div> -->

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-4"> </div>
                            <div class="col-4">
                                <div class="form-group" style="text-align: center;">
                                    <label class="form-control-label">Choose Category</label>

                                    <?php
                                    $query = "SELECT * FROM categorie";

                                    $result = mysqli_query($con, $query);

                                    echo "<select id='select_cat' name='cat_name' class='form-control'><option value='-1'>All</option>";
                                    while ($cat_data = mysqli_fetch_assoc($result)) {

                                        if ($_SESSION['cat_id'] == $cat_data['cat_id']) {
                                            echo "<option selected value='" . $cat_data['cat_id'] . "'>" . $cat_data['cat_name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $cat_data['cat_id'] . "'>" . $cat_data['cat_name'] . "</option>";
                                        }
                                    }

                                    echo "</select>";
                                    ?>
                                </div>
                            </div>
                        </div>

                        <nav aria-label="Page navigation example">
                            <div class="row">
                                <?php
                                if ($_SESSION['cat_id'] < 0) {
                                    $retrieveData = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id "
                                    . "LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id"
                                    . " where lead_calls.call_note is null AND lead_emp_id = {$_SESSION['emp_id']} "
                                    . " ORDER BY lead.lead_id DESC LIMIT {$startFrom} ,{$_SESSION['num_rows']}";
                                } else {
                                    $retrieveData = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id "
                                    . "LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id"
                                    . " where lead_calls.call_note is null AND lead_emp_id = {$_SESSION['emp_id']} "
                                    . " AND lead_cat_id={$_SESSION['cat_id']} ORDER BY lead.lead_id DESC LIMIT {$startFrom} ,{$_SESSION['num_rows']}";

                                }

                                // $sql = "SELECT * FROM lead WHERE lead_cat_id = '{$_SESSION['cat_id']}' AND lead_emp_id IS NULL ORDER BY lead.lead_id ASC LIMIT $startFrom ,100";
                                $resultRetrieve = mysqli_query($con, $retrieveData);

                                ?>
                                <div class="col">
                                    <ul class="pagination justify-content-start">
                                        <?php if ($currentPage != $firstPage): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $firstPage ?>"  tabindex="-1">First Page</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if ($currentPage >= 2) : ?>
                                            <li class="page-item"><a class="page-link" href="?page=<?php echo $previousPage ?>">
                                                <?php echo $previousPage ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <li class="page-item"><a class="page-link" href="?page=<?php echo $currentPage ?>">
                                            <?php echo $currentPage ?></a></li>

                                            <?php if ($currentPage != $lastPage) : ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo $nextPage ?>"><?php echo $nextPage ?></a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?php echo $lastPage ?>">Last Page</a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>

                                    <?php
                           if ($_SESSION['cat_id'] < 0) {
                            $num_rows = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id "
                            . "LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id"
                            . " WHERE lead_calls.call_note IS NULL AND lead_emp_id = {$_SESSION['emp_id']}";
                            $res =  mysqli_query($con, $num_rows);
                        } else {
                            $num_rows = "SELECT * FROM lead LEFT JOIN lead_calls ON lead.lead_id=lead_calls.call_lead_id "
                            . "LEFT JOIN categorie on categorie.cat_id = lead.lead_cat_id"
                            . " WHERE lead_calls.call_note IS NULL AND lead_emp_id = {$_SESSION['emp_id']} AND lead_cat_id={$_SESSION['cat_id']} ";
                            $res =  mysqli_query($con, $num_rows);
                        }

                                      $number_of_leads =  mysqli_num_rows($res);

                              if($number_of_leads){

                                   echo "<div class='col-3 mt-2 text-success'>Total Leads Left : " . $number_of_leads ;

                                  }else{

                                   echo  "<div class='col-3 mt-2 text-danger'>You Don't Have Any Leads Yet.";

                                  }

                                   ?>
                                   </div>



                                    <div class="col-6">
                                        <form action="" method="post" role="form">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <label for="num_row" class="col-sm-3 col-form-label">Rows</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" name="num_row" id="num_row">
                                                                <option <?php echo $_SESSION['num_rows'] == 10? 'selected': ''; ?> value="10">10</option>
                                                                <option <?php echo $_SESSION['num_rows'] == 15? 'selected': ''; ?> value="15">15</option>
                                                                <option <?php echo $_SESSION['num_rows'] == 20? 'selected': ''; ?> value="20">20</option>
                                                                <option <?php echo $_SESSION['num_rows'] == 50? 'selected': ''; ?> value="50">50</option>
                                                                <option <?php echo $_SESSION['num_rows'] == 100? 'selected': ''; ?> value="100">100</option>
                                                                <option <?php echo $_SESSION['num_rows'] == 250? 'selected': ''; ?> value="250">250</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <input type="submit" id="sub_num" name="sub_num" value="Submit" class="form-control btn btn-primary">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </nav>


                            <form action="" method="post">
                                <div class="table-responsive">
                                    <div id="row">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>University</th>
                                                    <th>Mobile</th>
                                                    <th>Major</th>
                                                    <th>Category</th>

                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $i=1;
                                                while ($row = mysqli_fetch_assoc($resultRetrieve)) {

                                                    ?>

                                                    <tr>

                                                        <td><?php echo $i; ?></td>
                                                        <td><a class="btn-link" href='lead_profile.php?lead_id=<?php echo $row['lead_id'];?>'> <?php echo $row['lead_name']; ?></a></td>
                                                        <td><?php echo $row['lead_university']; ?></td>
                                                        <td><?php echo $row['lead_mobile']; ?></td>
                                                        <td><?php echo $row['lead_major']; ?></td>
                                                        <td><?php echo $row['cat_name']; ?></td>
                                                        </td>

                                                    </tr>
                                                    <?php
                                        $i++;
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
     $(document).ready(function () {
            $('#select_cat').change(function () {
                window.top.location = "emp_tasks.php?cat_id=" + $(this).val();
            });

        });
    </script>
</body>

</html>