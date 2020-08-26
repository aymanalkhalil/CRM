<?php include '../includes/config.php'; ?>
<table id="bootstrap-data-table" class="table table-striped table-bordered">

    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>University</th>
            <th>Mobile</th>
            <th>Major</th>
            <th>Category</th>
            <th>Notes</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $query = "SELECT * FROM lead, categorie WHERE (lead.lead_name LIKE '%{$_GET['search']}%' OR categorie.cat_name LIKE '%{$_GET['search']}%' OR lead.lead_university LIKE '%{$_GET['search']}%') AND lead.lead_cat_id = categorie.cat_id";

        $resultRetrieve=  mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($resultRetrieve)) {
            ?>
            <tr>
                <td><?php echo $row['lead_id']; ?></td>
                <td><?php echo $row['lead_name']; ?></td>
                <td><?php echo $row['lead_university']; ?></td>
                <td><?php echo $row['lead_mobile']; ?></td>
                <td><?php echo $row['lead_major']; ?></td>
                <td><?php echo $row['cat_name']; ?></td>
                <td><?php echo $row['lead_note']; ?></td>
            </tr>
            <?php
            // $i++;
        }
//}
        ?>
    </tbody>
</table>
