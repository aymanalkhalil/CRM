<?php
include '../includes/config.php';

$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$emp_choosed = $_GET['employee'];

$query = "SELECT lead_calls.call_result, COUNT(lead_calls.call_result) AS count , substring(lead_calls.call_date_time,9,2) as day "
    . "from lead left JOIN lead_calls on lead.lead_id=lead_calls.call_lead_id"
    . " WHERE lead_calls.call_date_time BETWEEN '$date_from' AND '$date_to'"
    . " AND lead.lead_emp_id='$emp_choosed' GROUP By substring(lead_calls.call_date_time,9,2),call_result";


$result = mysqli_query($con, $query);
?>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>



<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);


    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Day in Month', 'Hesitant - متردد', 'Interested - مهتم', 'Not Interested - غير مهتم', 'Not Used - غير مستعمل', 'Registered Successfully - تم التسجيل'],


            <?php
            $data = array();

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($data, $row);
            }

            foreach ($data as $val) {

                $day_in_month[$val['day']] = null;
            }
            $call_status = ['Hesitant - متردد', 'Interested - مهتم', 'Not Interested - غير مهتم', 'Not Used - غير مستعمل', 'Registered Successfully - تم التسجيل'];

            foreach ($data as $val) {


                foreach ($day_in_month as $key => $value) {

                    if ($key == $val['day']) {

                        $day_in_month[$key][$val['call_result']] = $val['count'];
                    }
                }
            }
            $finalArray = array();

            foreach ($day_in_month as $kk => $day) {

                foreach ($call_status as $status) {
                    if (!array_key_exists($status, $day)) {
                        $day_in_month[$kk][$status] = 0;
                    }
                }
            }

            $final = array();
            $output = "";
            foreach ($day_in_month as $key => $value) {
                ksort($value);
                $final[$key] = $value;

                foreach ($final[$key] as $kkl => $value2) {
                    global $val1;
                    global $val2;
                    global $val3;
                    global $val4;
                    global $val5;
                    $heistant = array_column($final, 'Hesitant - متردد');
                    $interested = array_column($final, 'Interested - مهتم');
                    $not_interested = array_column($final, 'Not Interested - غير مهتم');
                    $not_used = array_column($final, 'Not Used - غير مستعمل');
                    $registered = array_column($final, 'Registered Successfully - تم التسجيل');

                    foreach ($heistant as $key0 => $value0) {

                        $val1 = $value0;
                    }

                    foreach ($interested as $key1 => $value1) {

                        $val2 = $value1;
                    }
                    foreach ($not_interested as $key2 => $value2) {
                        $val3 = $value2;
                    }
                    foreach ($not_used as $key3 => $value3) {
                        $val4 = $value3;
                    }
                    foreach ($registered as $key4 => $value4) {
                        $val5 = $value4;
                    }
                    echo "[$key,$val1,$val2,$val3,$val4,$val5],";
                }
            }






            ?>

        ]);


        var options = {
            isStacked: true,
            legend: {
                position: 'top',
                maxLines: 20
            },
            bar: {
                groupWidth: '95%'
            },
            title: 'Employee Evaluation Based On Month',

            animation: {
                "startup": true,
                duration: 1000,
                easing: 'inAndOut'
            },
            hAxis: {
                title: 'Calls Made In These Days'
            },
            vAxis: {
                title: 'Number Of Calls In Each Day'
            },
            height: 450,
            width: 985


        };


        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));

        chart.draw(data, options);


    }
</script>