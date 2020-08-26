<?php
include '../includes/header_admin.php';
include '../includes/config.php';
//date_default_timezone_set('EET');
//$date= date('Y-m-d h:i:s A D');
//print_r($date);die;

global $con;
$msg = "";



if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = -1;
}
if (!isset($_SESSION['cat_id'])) {
    $_SESSION['cat_id'] = -1;
}
if (!isset($_SESSION['status_id'])) {
    $_SESSION['status_id'] = 0;
}
if(!isset($_SESSION['source_name'])){
    $_SESSION['source_name'] = "Please Select Source";
}

if (isset($_GET['emp_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_id'];
    echo '<script> window.top.location="lead_employee.php"; </script>';
}

if (isset($_GET['cat_id'])) {
    $_SESSION['cat_id'] = $_GET['cat_id'];
    echo '<script> window.top.location="lead_employee.php"; </script>';
}

if (isset($_GET['status_id'])) {
    $_SESSION['status_id'] = $_GET['status_id'];
    echo '<script> window.top.location="lead_employee.php"; </script>';
}
if(isset($_GET['source_name'])){
    $_SESSION['source_name'] = $_GET['source_name'];
    echo '<script> window.top.location="lead_employee.php"; </script>';
}






if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * 100) - 100;
$totalLeadsSQL = "SELECT * FROM lead where lead_emp_id='{$_SESSION['emp_id']}'";
$allLeadsResult = mysqli_query($con, $totalLeadsSQL);
$totalLeads = mysqli_num_rows($allLeadsResult);
$lastPage = ceil($totalLeads / 100);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;
?>
<style>
    /*    .modal fade bd-example-modal-lg show{
            padding-right: 350px !important;
            display: block !important;
        }*/


</style>
<div class='container'>
<!-- Content -->
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
                                <strong class="card-title m-0 ">Leads Taken by Employees</strong>
                            </div>

                        </div>

                    </div>


                    <div class="card-body">
                        <div class='row'>
                            <div class='col-6'>

                                <div class="form-group">
                                    <label for="employee" >Select Employee</label>
                                    <select id="employee" name="employee" class="form-control">
                                        <?php
                                        $sql = "SELECT * FROM employee";
                                        $res = mysqli_query($con, $sql);
                                        echo "<option selected disabled value='-1'>Choose Employee</option>";
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $_SESSION['emp_name'] = $row['emp_name'];
                                            if ($_SESSION['emp_id'] == $row['emp_id']) {
                                                echo '<option selected value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $row['emp_id'] . '">' . $row['emp_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class='col-6'>

                                <div class="form-group">
                                    <label for="category">Select Category</label>
                                    <select id="category" name="category" class="form-control">
                                        <?php
                                        $sql = "SELECT * FROM categorie";
                                        $res = mysqli_query($con, $sql);
                                        echo "<option selected value='-1'>All</option>";
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            if ($_SESSION['cat_id'] == $row['cat_id']) {
                                                echo '<option selected value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>

                               <div class="col-6">
                                <div class="form-group">
                                    <label for="status">Select Source </label>
                                    <select id="source" name="source" class="form-control">
                                       <?php
                                       $sourceQuery="select DISTINCT lead_source from lead";
                                       $result=  mysqli_query($con, $sourceQuery);
                                       echo "<option disabled selected value='Please Select Source'>Please Select Source</option>";
//                                       $source_id=1;
                                       while($source_name=  mysqli_fetch_assoc($result)){
                                           if($_SESSION['source_name'] == $source_name['lead_source']){
                                                echo "<option selected value='{$source_name['lead_source']}'>" . $source_name['lead_source'] . "</option>";
                                           }else{
                                               echo "<option  value='{$source_name['lead_source']}'>" . $source_name['lead_source'] . "</option>";
                                           }
//                                            $source_id++;
                                       }

                                       ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">Select Status</label>
                                    <select id="status" name="status" class="form-control">
                                        <option <?php echo $_SESSION['status_id'] == 0 ? 'selected' : ''; ?> value="0">All</option>
                                        <option <?php echo $_SESSION['status_id'] == 1 ? 'selected' : ''; ?> value="1">Called</option>
                                        <option <?php echo $_SESSION['status_id'] == 2 ? 'selected' : ''; ?> value="2">Not Called</option>
                                        <option <?php echo $_SESSION['status_id'] == 3 ? 'selected' : ''; ?> value="3">Registered</option>
                                    </select>
                                </div>
                            </div>




                            <div class='col-4'>
                                <nav aria-label="Page navigation example"><br>
                                    <div class="row">
                                        <?php
                                        switch ($_SESSION['status_id']) {
                                            case 0:
                                                if ($_SESSION['cat_id'] < 0 ) {
                                                    $retrieveData = "SELECT * FROM lead inner join categorie on lead.lead_cat_id=categorie.cat_id where lead_emp_id='{$_SESSION['emp_id']}' AND lead_source='{$_SESSION['source_name']}' ORDER BY lead.lead_id DESC LIMIT {$startFrom} ,100";
                                                         // echo $retrieveData .  " <br> "  . "  Source ALL ";
                                                } else {
                                                    $retrieveData = "SELECT * FROM lead inner join categorie on lead.lead_cat_id=categorie.cat_id where lead_emp_id='{$_SESSION['emp_id']}' AND lead_cat_id='{$_SESSION['cat_id']}' AND lead_source='{$_SESSION['source_name']}' ORDER BY lead.lead_id DESC LIMIT {$startFrom} ,100";
                                                  //  echo $retrieveData;
                                                }
                                                break;
                                            case 1:
                                                if ($_SESSION['cat_id'] < 0 ) {
                                                    $retrieveData = "SELECT lead.lead_id,lead.lead_name,lead.lead_university,lead.lead_email,lead.lead_major,lead.lead_mobile,lead.lead_address,lead.lead_interested,lead.lead_source,lead.lead_note,categorie.cat_name"
                                                            . ",MAX(lead.lead_emp_id)lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time)"
                                                            . "call_date_time,MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) call_note"
                                                            . " FROM lead LEFT JOIN categorie on lead.lead_cat_id=categorie.cat_id LEFT JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id "
                                                            . "where not lead_calls.call_note='Registered Successfully - تم التسجيل' AND lead.lead_emp_id='{$_SESSION['emp_id']}' AND lead_source='{$_SESSION['source_name']}' "
                                                            . "GROUP BY lead.lead_id  ORDER BY lead.lead_id ASC LIMIT {$startFrom} ,100";
                                                } else {
                                                    $retrieveData = "SELECT lead.lead_id,lead.lead_name,lead.lead_university,lead.lead_email,lead.lead_major,lead.lead_mobile,lead.lead_address,lead.lead_interested,lead.lead_source,lead.lead_note,categorie.cat_name"
                                                            . ",MAX(lead.lead_emp_id)lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time)"
                                                            . "call_date_time,MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) call_note"
                                                            . " FROM lead LEFT JOIN categorie on lead.lead_cat_id=categorie.cat_id LEFT JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id "
                                                            . "where not lead_calls.call_note='Registered Successfully - تم التسجيل' AND lead.lead_emp_id='{$_SESSION['emp_id']}' AND lead.lead_cat_id='{$_SESSION['cat_id']}' AND lead.lead_source='{$_SESSION['source_name']}' "
                                                            . "GROUP BY lead.lead_id ORDER BY lead.lead_id ASC LIMIT {$startFrom} ,100";
                                                           // echo $retrieveData;
                                                }
                                                break;
                                            case 2:
                                                if ($_SESSION['cat_id'] < 0 ) {
                                                    $retrieveData = "SELECT *  FROM lead t1  LEFT JOIN categorie t3 ON t3.cat_id = t1.lead_cat_id LEFT JOIN lead_calls t2 ON t2.call_lead_id = t1.lead_id WHERE t2.call_lead_id IS NULL AND t1.lead_emp_id = '{$_SESSION['emp_id']}' AND lead_source='{$_SESSION['source_name']}' ORDER BY t1.lead_id ASC LIMIT {$startFrom} ,100";
                                                } else {
                                                    $retrieveData = "SELECT *  FROM lead t1  LEFT JOIN categorie t3 ON t3.cat_id = t1.lead_cat_id LEFT JOIN lead_calls t2 ON t2.call_lead_id = t1.lead_id WHERE t2.call_lead_id IS NULL AND t1.lead_emp_id = '{$_SESSION['emp_id']}' AND t3.cat_id = '{$_SESSION['cat_id']}'  AND t1.lead_source='{$_SESSION['source_name']}' ORDER BY t1.lead_id ASC LIMIT {$startFrom} ,100";
                                                    //echo $retrieveData;
                                                }
                                                break;
                                            case 3:
                                                if ($_SESSION['cat_id'] < 0 ) {
                                                    $retrieveData = "SELECT lead.lead_id,lead.lead_name,lead.lead_university,lead.lead_email,lead.lead_major,lead.lead_mobile,lead.lead_address,lead.lead_interested,lead.lead_source,lead.lead_note,categorie.cat_name"
                                                            . ",MAX(lead.lead_emp_id)lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time)"
                                                            . "call_date_time,MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) call_note"
                                                            . " FROM lead LEFT JOIN categorie on lead.lead_cat_id=categorie.cat_id LEFT JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id "
                                                            . "where lead_calls.call_note='Registered Successfully - تم التسجيل' AND lead.lead_emp_id='{$_SESSION['emp_id']}' AND lead_source='{$_SESSION['source_name']}' "
                                                            . "GROUP BY lead.lead_id  ORDER BY lead.lead_id ASC LIMIT {$startFrom} ,100";
                                                          //  echo $retrieveData;
                                                } else {
                                                    $retrieveData = "SELECT lead.lead_id,lead.lead_name,lead.lead_university,lead.lead_email,lead.lead_major,lead.lead_mobile,lead.lead_address,lead.lead_interested,lead.lead_source,lead.lead_note,categorie.cat_name"
                                                            . ",MAX(lead.lead_emp_id)lead_emp_id,MAX(lead.lead_name) lead_name,MAX(lead_calls.call_date_time)"
                                                            . "call_date_time,MAX(lead_calls.call_result) call_result,MAX(lead_calls.call_date) call_date,MAX(lead_calls.call_time) call_time,MAX(lead_calls.call_note) call_note"
                                                            . " FROM lead LEFT JOIN categorie on lead.lead_cat_id=categorie.cat_id LEFT JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id "
                                                            . "where lead_calls.call_note='Registered Successfully - تم التسجيل' AND lead.lead_emp_id='{$_SESSION['emp_id']}' AND lead.lead_cat_id='{$_SESSION['cat_id']}' AND lead.lead_source='{$_SESSION['source_name']}' "
                                                            . "GROUP BY lead.lead_id ORDER BY lead.lead_id ASC LIMIT {$startFrom} ,100";
                                                            //echo $retrieveData;
                                                }
                                                break;
                                        }
                                        $resultRetrieve = mysqli_query($con, $retrieveData);
                                        ?>
                                        <!--SELECT * FROM lead inner join categorie on lead.lead_id=categorie.cat_id where lead_emp_id=2 and lead_cat_id=1-->
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


                                    </div>
                            </div>

                            </nav>



                            <?php
                            if (!empty(mysqli_num_rows($resultRetrieve))) {
                                echo "<div class='col-6' style='margin-top:25px;color:#28a745;'> Number of leads taken by this employee is : " . mysqli_num_rows($resultRetrieve) . "</div>";
                            } else {
                                echo "<div class='col-6' style='margin-top:25px;color:red;'>No Results Found</div>";
                            }
                            ?>


                            <div class="table-responsive">
                                <div class="data_result" id="row">
                                    <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Major</th>
                                                <th>University</th>
                                                <th>Address</th>
                                                <th>Interested </th>
                                                <th>Source</th>
                                                <!-- <th>Note</th> -->
                                                <th>Category</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <!-- Large modal -->

                                                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#model<?php echo $i ?>"> <?php echo $row['lead_name']; ?></button>

                                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"  id="model<?php echo $i ?>"     aria-labelledby="myLargeModalLabel" aria-hidden="true" >
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content" >
                                                                    <div class="modal-header bg-primary text-light ">
                                                                        <h5 class="modal-title d-inline-block" id="exampleModalLabel<?php echo $i; ?>">Operation Done To This Lead : <?php echo "<b>" . $row['lead_name'] . "</b>"; ?></h5>
                                                                        <button type="button" class="close bg-primary text-light" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>

                                                                    </div>

                                                                    <div class="modal-body">

                                                                        <div class="table-responsive">

                                                                            <table id="bootstrap-data-table<?php echo $i; ?>" class="table table-striped table-bordered">

                                                                                <thead class="bg-primary text-light border-dark">
                                                                                    <tr>

                                                                                        <th>Employee Name</th>
                                                                                        <th>First Call Time & Date</th>
                                                                                        <th>Call Result</th>
                                                                                        <th>Next Call Date</th>
                                                                                        <th>Next Call Time</th>
                                                                                        <th>Call Note</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                <?php
                                                                                $query1 = "select * from lead_calls, lead, employee where call_lead_id={$row['lead_id']} AND lead_calls.call_lead_id = lead.lead_id AND employee.emp_id = lead.lead_emp_id";

                                                                                $result = mysqli_query($con, $query1);
                                                                                ?>
                                                                                <tbody>
                                                                                    <?php
                                                                                    if (mysqli_num_rows($result) > 0) {

                                                                                        while ($row2 = mysqli_fetch_assoc($result)) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?php echo $row2['emp_name']; ?></td>
                                                                                                <td><?php echo $row2['call_date_time']; ?></td>
                                                                                                <td><?php echo $row2['call_result']; ?></td>
                                                                                                <td><?php echo isset($row['call_date']) ? $row2['call_date'] : 'لا يوجد'; ?></td>
                                                                                                <td><?php echo isset($row['call_time']) ? date('h:i A ', strtotime($row['call_time'])) : 'لا يوجد' ?></td>
                                                                                                <td><?php echo $row2['call_note']; ?></td>
                                                                                            </tr>

                                                                                        <?php
                                                                                        }
                                                                                    } else {

                                                                                        echo '<tr><td colspan="6" class="text-center text-danger">He didnt talk to him yet</td></tr>';
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </td>

                                                    <td><?php echo $row['lead_email']; ?></td>
                                                    <td><?php echo $row['lead_mobile']; ?></td>
                                                    <td><?php echo $row['lead_major']; ?></td>
                                                    <td><?php echo $row['lead_university']; ?></td>
                                                    <td><?php echo $row['lead_address']; ?></td>
                                                    <td><?php echo $row['lead_interested']; ?></td>
                                                    <td><?php echo $row['lead_source']; ?></td>
                                                    <!-- <td><?php echo $row['lead_note']; ?></td> -->
                                                    <td><?php echo $row['cat_name']; ?></td>
                                                </tr>
                                                <?php
                                                $i++;
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

        <!-- / .display admin -->

    </div>
    <!-- / .Animated -->

</div>

<!-- /.content -->
                                        </div>

<?php include '../includes/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#employee').change(function () {
            window.top.location = "lead_employee.php?emp_id=" + $(this).val();
        });
        $('#category').change(function () {
            window.top.location = "lead_employee.php?cat_id=" + $(this).val();
        });

        $('#status').change(function () {
            window.top.location = "lead_employee.php?status_id=" + $(this).val();
        });
         $('#source').change(function () {
            window.top.location = "lead_employee.php?source_name=" + $(this).val();
        });


    });
</script>
</body>

</html>





















