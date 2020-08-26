<?php include '../includes/header_admin.php'; ?>
<?php include '../includes/config.php'; ?>

<?php
//var_dump($_SESSION);

if (!isset($_SESSION['category_id'])) {
    $_SESSION['category_id'] = -1;
}
if (isset($_GET['cat_to_transfer'])) {
    $_SESSION['category_id'] = $_GET['cat_to_transfer'];
    echo '<script> window.top.location="tasks.php"; </script>';
}

if (!isset($_SESSION['emp_id'])) {
    $_SESSION['emp_id'] = -1;
}
if (isset($_GET['emp_from_id'])) {
    $_SESSION['emp_id'] = $_GET['emp_from_id'];
    echo '<script> window.top.location="tasks.php"; </script>';
}

if (!isset($_SESSION['cat_id'])) {
    $_SESSION['cat_id'] = -1;
}
if (isset($_GET['cat_id'])) {
    $_SESSION['cat_id'] = $_GET['cat_id'];

    echo '<script> window.top.location="tasks.php"; </script>';
}


if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
$startFrom = ($currentPage * 100) - 100;
if ($_SESSION['cat_id'] > 0) {
    $totalLeadsSQL = "SELECT * FROM lead,categorie where lead_emp_id IS NULL AND lead.lead_cat_id=categorie.cat_id AND categorie.cat_id='{$_SESSION['cat_id']}'";
} else {
    $totalLeadsSQL = "SELECT * FROM lead where lead_emp_id IS NULL";
}
$allLeadsResult = mysqli_query($con, $totalLeadsSQL);
$totalLeads = mysqli_num_rows($allLeadsResult);
$lastPage = ceil($totalLeads / 100);
$firstPage = 1;
$nextPage = $currentPage + 1;
$previousPage = $currentPage - 1;

//select Employee



if (isset($_POST['add'])) {

    $lead_emp_id = $_POST['emp_name'];

    foreach ($_POST['checkbox'] as $val) {
        $query = "UPDATE lead SET lead_emp_id='$lead_emp_id' where lead_id='$val'";
        $res = mysqli_query($con, $query);
    }

    if ($res) {

        echo "<div style='width:auto;margin:15px' class='alert alert-success role='alert'>Task Given To Employee Successfully </div>";

        echo "<script type='text/Javascript'>
			window.setTimeout(function() {
			window.location.href = 'tasks.php';
			}, 2000);</script>";
    } else {

       echo "<div style='width:auto;margin:15px' class='alert alert-danger role='alert'>ERROR In Give Task" . mysqli_error($con) . "</div>";
    }
}
?>
<div class='container'>
<!-- Content -->
<div class="content">

    <div class="animated fadeIn">


        <div class="row-fluid">
            <div class="col-12">
                <div class="card">

                    <div class="card-header bg-primary text-light">
                        <strong class="card-title">Give Tasks</strong>
                    </div>

                    <div class="card-body card-block position-relative">
                        <form id="" action="" method="POST" class="" validate>
                            <div class="row">
                                <!-- Basic Form-->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Choose Employee</label>

                                        <?php
                                        $query = "SELECT * FROM employee";

                                        $result = mysqli_query($con, $query);

                                        echo "<select required name='emp_name' class='form-control'>";
                                        echo "<option disabled selected hidden value=''>Choose Employee </option>";
                                        while ($emp_data = mysqli_fetch_assoc($result)) {

                                            echo "<option value='" . $emp_data['emp_id'] . "'>" . $emp_data['emp_name'] . "</option>";
                                        }

                                        echo "</select>";
                                        ?>

                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Choose Category</label>

                                        <?php
//                                        $cat_id = -1;
//                                        if (isset($_GET['cat_id'])) {
//                                            $cat_id = $_GET['cat_id'];
//                                        }
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

                                <div class="custom-control custom-checkbox" style="margin-left: 25px; margin-top: 25px;">
                                    <input type="checkbox" name="checkbox"  class="custom-control-input" value="selectall" id="one">&nbsp;&nbsp;
                                    <label class="custom-control-label" for="one">Select All </label>&nbsp;&nbsp;
                                </div>
                                <nav aria-label="Page navigation example" style="margin-left: 25px; margin-top: 18px;">
                                    <div class="row">
                                        <?php
//                                        $retrieveData = "SELECT * FROM lead ORDER BY lead.lead_id ASC LIMIT $startFrom ,100";
                                        ?>
                                        <div class="col">
                                            <ul class="pagination justify-content-start">
                                                <?php if ($totalLeads != 0): ?>
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
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                                <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-success btn-sm mt-3 ml-5"
                                     name="add" value="add" style="width: 90px; height: 40px;">Send Task</button>
                                    </div>


                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">

                                            <thead>
                                                <tr>

                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>

                                            <tbody>

                                                <?php
                                                if ($_SESSION['cat_id'] < 0) {
                                                    $sql = "SELECT * FROM lead WHERE lead_emp_id IS NULL ORDER BY lead.lead_id ASC LIMIT $startFrom ,100 ";
                                                } else {
                                                    $sql = "SELECT * FROM lead WHERE lead_cat_id = '{$_SESSION['cat_id']}' AND lead_emp_id IS NULL ORDER BY lead.lead_id ASC LIMIT $startFrom ,100";
                                                }
                                                $res = mysqli_query($con, $sql);
                                                $i = 0;
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                                    <tr>

                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="checkbox[]" value="<?php echo $row['lead_id']; ?>" class="custom-control-input" id="name<?php echo $i; ?>">&nbsp;&nbsp;
                                                                <label class="custom-control-label" for="name<?php echo $i; ?>"><?php echo $row['lead_name']; ?></label>&nbsp;&nbsp;
                                                            </div>
                                                        </td>
                                                        <td><?php echo $row['lead_email']; ?></td>
                                                        <td><?php echo $row['lead_mobile']; ?></td>

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!--End Content -->

</div>
                                            </div>

<?php include '../includes/footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#select_cat').change(function () {
            window.top.location = "tasks.php?cat_id=" + $(this).val();
        });
        $('#one').click(function () {
            $("input[id^=name]").prop('checked', $(this).prop('checked'));
        });
        // $('#select_emp_from').change(function () {
        //     window.top.location = "tasks.php?emp_from_id=" + $(this).val();
        // });
        // $('#cat_to_transfer').change(function () {
        //     window.top.location = "tasks.php?cat_to_transfer=" + $(this).val();

        // });

        // $('#two').click(function () {
        //     $("input[id^=lead]").prop('checked', $(this).prop('checked'));
        // });
        $(window).scroll(function () {
            sessionStorage.scrollTop = $(this).scrollTop();
        });


        if (sessionStorage.scrollTop != "undefined") {
            //$(window).scrollTop(sessionStorage.scrollTop);
            $('html, body').animate({
                scrollTop: sessionStorage.scrollTop
            }, 2000);

        }


    });
</script>