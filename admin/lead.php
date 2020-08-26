<?php
include '../includes/header_admin.php';
include '../includes/config.php';

global $con;
$msg = "";
$date_Upload = date("Y-m-d");

if (!isset($_SESSION['num_rows'])) {
    $_SESSION['num_rows'] = 15;
}

if (isset($_POST['sub_num'])) {
    $_SESSION['num_rows'] = $_POST['num_row'];
    echo '<script>window.top.location = "lead.php"</script>';
}


if (isset($_POST['add_lead'])) {

    $name       =    $_POST['name'];
    $email      =    $_POST['email'];
    $mobile     =    $_POST['mobile'];
    $major      =    $_POST['major'];
    $university =    $_POST['university'];
    $address    =    $_POST['address'];
    $interested =    $_POST['interested'];
    $source     =    $_POST['source'];
    $category   =    $_POST['category'];

    if (!empty($category && $interested)) {
        $insert = "INSERT INTO lead(lead_name, lead_email, lead_mobile, lead_major, lead_university, lead_address, lead_interested, lead_source,lead_cat_id,leads_date_upload) VALUES
                        ('$name', '$email', '$mobile', '$major', '$university', '$address', '$interested', '$source','$category','$date_Upload')";

        if (mysqli_query($con, $insert)) {

            echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Manual Lead Added Successfully </div>";

            echo "<script type='text/Javascript'>
                  window.setTimeout(function() {
                    window.location.href = 'lead.php';
                    }, 2000);</script>";

        } else {

            echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>Error In Adding Manual Lead </div>" . mysqli_error($con);
        }
    }
}

if (isset($_POST['import_leads'])) {
    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'text/csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    $category = $_POST['category'];
    $source = $_POST['source'];



    ini_set('max_execution_time', 300);
    set_time_limit(300);

    if ($_FILES['file_excel']['error'] == 0) {
        if (in_array($_FILES['file_excel']['type'], $allowedFileType)) {
            $fileName = $_FILES["file_excel"]["tmp_name"];
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $insert = "INSERT INTO lead(lead_name,lead_email,lead_mobile,lead_major,lead_university, lead_address,lead_interested,lead_source,lead_cat_id,leads_date_upload) VALUES
                                           ('$column[0]', '$column[1]','$column[2]','$column[3]', '$column[4]', '$column[5]','$column[6]','$source','$category','$date_Upload')";
                $res = mysqli_query($con, $insert);
            }
            echo '<script>window.top.location = "lead.php"</script>';
            //header("Location: lead.php");
        } else {
            $msg = "Invalid File Type. Upload Excel File.";
        }
    } else {
        $msg = "Invalid File Type. Upload Excel File.";
    }
}

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * $_SESSION['num_rows']) - $_SESSION['num_rows'];
$totalLeadsSQL = "SELECT * FROM lead";
$allLeadsResult = mysqli_query($con, $totalLeadsSQL);
$totalLeads = mysqli_num_rows($allLeadsResult);
$lastPage = ceil($totalLeads / $_SESSION['num_rows']);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;
?>


<div class='container'>
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">


        <!-- display admin -->
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <div class="row">
                            <div class="col-4 d-flex align-items-center">
                                <strong class="card-title m-0">Leads</strong>
                            </div>
                            <div class="col-4">
                                <form action="" method="post" role="search">
                                    <div class="input-group">
                                        <input class="form-control" type="search" name="search" a autocomplete="off" id="search" placeholder="Search (Name, Category, Source, University)">
                                    </div>
                                </form>
                            </div>
                            <div class="col-4 d-flex justify-content-end align-items-center">
                                <!-- Start Button -->
                                <button type="button" class="btn btn-primary text-light mx-2" data-toggle="modal" data-target="#add_lead">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#import_leads">
                                    <i class="fa fa-file-import"></i>
                                </button>
                                <!-- End Button -->

                                <!-- Modal | Add lead -->
                                <div class="modal fade" id="add_lead" tabindex="-1" role="dialog" aria-labelledby="add_leadTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-light">
                                                <h5 class="modal-title d-inline-block " id="add_leadTitle">Add Lead</h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="post" role="form">
                                                <div class="modal-body text-dark">

                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" id="name" placeholder="Name" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" id="email" placeholder="Email" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mobile">Mobile</label>
                                                        <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="major">Major</label>
                                                        <input type="text" name="major" id="major" placeholder="Major" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="university">University</label>
                                                        <input type="text" name="university" id="university" placeholder="University" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" name="address" id="address" placeholder="Address" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="interested">Interested</label>

                                                        <?php

                                                        $query = "SELECT * FROM categorie";
                                                        $result = mysqli_query($con, $query);
                                                        echo  "<select name='interested' class='form-control' required>";
                                                        echo "<option disabled selected value='-1'>Choose Category</option>";
                                                        while ($row = mysqli_fetch_assoc($result)) {

                                                            echo "<option value='{$row['cat_name']}'>" . $row['cat_name'] . "</option>";
                                                        }
                                                        ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="source">Source</label>
                                                        <input type="text" name="source" id="source" placeholder="Source" class="form-control" autocomplete="off">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="category">Category</label>

                                                        <?php
                                                        $sql = "SELECT * FROM categorie";
                                                        $res = mysqli_query($con, $sql);
                                                        echo  "<select name='category' class='form-control' required>";
                                                        echo "<option disabled selected value='-1'>Choose Category</option>";
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                                                        }
                                                        echo "</select>";
                                                        ?>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="add_lead">Save</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal | Import leads -->
                                <div class="modal fade" id="import_leads" tabindex="-1" role="dialog" aria-labelledby="import_leadsTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-light">
                                                <h5 class="modal-title d-inline-block" id="import_leadsTitle">Import Leads</h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="post" role="form" enctype="multipart/form-data">
                                                <div class="modal-body text-dark">
                                                    <div class="form-group">
                                                        <label for="source1">Source</label>
                                                        <input type="text" name="source" id="source1" placeholder="Source" class="form-control" autocomplete="off">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="category1">Category</label>
                                                        <select id="category1" name="category" class="form-control">
                                                            <?php
                                                            $sql = "SELECT * FROM categorie";
                                                            $res = mysqli_query($con, $sql);
                                                            while ($row = mysqli_fetch_assoc($res)) {
                                                                echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-file">

                                                            <input type="file" name="file_excel" class="custom-file-input" id="customFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                            <label class="custom-file-label" for="customFile">Choose Excel Sheet (CSV)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="import_leads">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <nav aria-label="Page navigation example">
                            <div class="row">
                                <?php
                                $retrieveData = "SELECT * FROM lead, categorie WHERE categorie.cat_id = lead.lead_cat_id ORDER BY lead.lead_id DESC LIMIT {$startFrom} ,{$_SESSION['num_rows']}";
                                $resultRetrieve = mysqli_query($con, $retrieveData);
                                ?>
                                <div class="col">
                                    <ul class="pagination justify-content-start">
                                        <?php if ($currentPage != $firstPage) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $firstPage ?>" tabindex="-1">First Page</a>
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
                                <div class="col-6">
                                    <form action="" method="post" role="form">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group row">
                                                    <label for="num_row" class="col-sm-3 col-form-label">Rows</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="num_row" id="num_row">
                                                            <option <?php echo $_SESSION['num_rows'] == 10 ? 'selected' : ''; ?> value="10">10</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 15 ? 'selected' : ''; ?> value="15">15</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 20 ? 'selected' : ''; ?> value="20">20</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 50 ? 'selected' : ''; ?> value="50">50</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 100 ? 'selected' : ''; ?> value="100">100</option>
                                                            <option <?php echo $_SESSION['num_rows'] == 250 ? 'selected' : ''; ?> value="250">250</option>
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
                        <div class="table-responsive">
                            <div id="row">
                                <table id="bootstrap-data-table" class="table table-striped table-bordered table-sm">

                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Major</th>
                                            <th>University</th>
                                            <th>Address</th>
                                            <th>Interested</th>
                                            <th>Source</th>
                                            <th>Category</th>
                                            <th>Date Upload</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($resultRetrieve)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['lead_id']; ?></td>
                                                <td><?php echo $row['lead_name']; ?></td>
                                                <td><?php echo $row['lead_email']; ?></td>
                                                <td><?php echo $row['lead_mobile']; ?></td>
                                                <td><?php echo $row['lead_major']; ?></td>
                                                <td><?php echo $row['lead_university']; ?></td>
                                                <td><?php echo $row['lead_address']; ?></td>
                                                <td><?php echo $row['lead_interested']; ?></td>
                                                <td><?php echo $row['lead_source']; ?></td>
                                                <td><?php echo $row['cat_name']; ?></td>
                                                <td><?php echo $row['leads_date_upload']; ?></td>
                                            </tr>
                                        <?php
                                            // $i++;
                                        }
                                        //}
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="row2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / .display admin -->

        </div>
        <!-- / .Animated -->

    </div>
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

        $("#search").keyup(function() {
            var search = $("#search").val();

            if (search !== "") {
                $("#row2").show();
                $("#row").hide();

                $.ajax({
                    type: "GET",
                    url: "search_lead_ajax.php?search=" + search,
                    cache: false,
                    success: function(data) {
                        $("#row2").html(data);


                    }

                });
            } else {
                $("#row").show();
                $("#row2").hide();

                //                 $("#row2").html("");
            }


        });

    });
</script>
</body>

</html>