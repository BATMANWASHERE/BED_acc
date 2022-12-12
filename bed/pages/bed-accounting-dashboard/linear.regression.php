<?php
require '../../includes/conn.php';
require '../bed-accounting/accountConn/conn.php';
session_start();
ob_start();


require '../../includes/bed-session.php';
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Add Payment | SFAC Bacoor</title>
    <?php include '../../includes/bed-head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Add Payment</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Basic Education</a>
                </li>
            </ul>
            <?php include '../../includes/bed-navbar.php'; ?>

            <!-- sidebar menu -->
            <?php include '../../includes/bed-sidebar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper pt-4">

                <section class="content">
                    <div class="container-fluid pl-5 pr-5 pb-3">
                        <div class="row justify-content-center mb-4">
                            <div class="col-md-8">
                                <div class="card card-green shadow-lg">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Payment
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <form action="" method="POST">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="col-md-8">
                                                    <div class="chart">
                                                        <canvas id="myChart" ></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-6 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text text-sm"><b>
                                                               Grade</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-green"
                                                        data-dropdown-css-class="select2-green"
                                                        data-placeholder="Select Year" name="grade" id="grade" onchange="estimation()">
                                                        <option selected disabled>Select Grade Level</option>
                                                        <?php
                                                            $query = mysqli_query($conn, "SELECT * FROM tbl_grade_levels");
                                                            while($row2 = mysqli_fetch_array($query)) {
                                                                echo '<option value="'.$row2['grade_level_id'].'">'.$row2['grade_level'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="input-group col-md-6 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Estimated Tuition</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="payment" id="estimation_fee" onkeyup="estimation()" placeholder="Input Estimated Tuition">

                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-6">
                                                    <p><span id="demo"></span></p>
                                                </div>
                                                <div class="input-group col-md-6">
                                                    <p><span id="estimation_total"></span></p>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-6">
                                                    <p><span id="pearson"></span></p>
                                                </div>
                                                <div class="input-group col-md-6">
                                                    <p><span id="rsquared"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn bg-green"><i
                                                    class="fas fa-calendar-check m-1"> </i> Add Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </section>
                <!-- Main content -->


            </div><!-- /.container-fluid -->

            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Footer and script -->
    <?php include '../../includes/bed-footer.php'; ?>
    <?php
        $array_chart1 = [];

        $data = mysqli_query($acc,"SELECT * FROM mytable"); //values for data

        while ($data_fetch = mysqli_fetch_array($data)) {
           $x_value = $data_fetch['tuition_fee'];
           $y_value = $data_fetch['number_of_students'];
           $p_value = $data_fetch['grade'];
           $s_value = $data_fetch['year'];
        
           $array_chart1[] = "{year: ".$data_fetch['year'].", tuitionfee: ".$data_fetch['tuition_fee'].", students: ".$data_fetch['number_of_students'].", grade: ".$data_fetch['grade']."}";

        }

        ?>

<script>

    function estimation() {
        var grade = parseFloat(document.getElementById("grade").value * 1);
        var estimation_fee = parseFloat(document.getElementById("estimation_fee").value * 1);

        console.log(grade);
        console.log(estimation_fee);

        if (estimation_fee != 0 && grade != 0) {

            const array1 = [ <?php 
            foreach ($array_chart1 as $value_array) {
                echo $value_array .", ";
            }?>
            ];
            
            const data2 = []; //sorted_array
            const data2_x = [];
            
            let sum_of_x = 0;
            let sum_of_y = 0;
            let i = 0;

            array1.forEach(function1);
            data2.forEach(function2);


            function function1 (arr_value) {
                if (arr_value.grade == grade) {
                    const temp_object = {};
                    temp_object['x'] = arr_value.tuitionfee;
                    temp_object['y'] = arr_value.students;

                    data2.push(temp_object);
                } else {
                }
            }

            function function2 (data_value) {
                data2_x.push(data_value.x)

                sum_of_x += data_value.x;
                sum_of_y += data_value.y;
                i += 1;
                
            }

            let highest_x = Math.max(...data2_x);
            let lowest_x = Math.min(...data2_x);

            let mean_x = sum_of_x/i;
            let mean_y = sum_of_y/i;

            let sumofproducts = 0;
            let sumofproductsy = 0;

            data2.forEach(products);

            function products(data_value) {
                sumofproducts += Math.pow((data_value.x - mean_x), 2);
                sumofproductsy += Math.pow((data_value.y - mean_y), 2);

            }

            let sumofsquares = 0;

            data2.forEach(squares);

            function squares(data_value) {
                sumofsquares += (data_value.x - mean_x) * (data_value.y - mean_y);
            }

            let b = sumofsquares/sumofproducts;
            let a = mean_y - (b * mean_x);


            let lowest_y = ((b * lowest_x) + a).toFixed(2);
            let highest_y = ((b * highest_x) + a).toFixed(2);

            let estimation_y = ((b * estimation_fee) + a).toFixed(0);

            let pearson_r = (sumofsquares / Math.sqrt((sumofproducts*sumofproductsy)));

            let rsquared = Math.pow(pearson_r, 2);

            var xhttp;
            if (grade.length == 0) { 
                document.getElementById("grade_text").innerHTML = "";
                return;
            }

            document.getElementById("demo").innerHTML = "Line of Regression y = (aX + b):<b> "+(b).toFixed(4) +"X + " + (a).toFixed(2)+ "</b>";
            document.getElementById("estimation_total").innerHTML = "Estimated Number of Students as per "+ estimation_fee +" fee:<br> "+(b).toFixed(4) +"("+ estimation_fee +")"+"+ " + (a).toFixed(2)+ " = <b>"+ estimation_y +" number of students</b>";
            document.getElementById("pearson").innerHTML = "Pearson's r: <b>"+ (pearson_r).toFixed(4)+"</b>";
            document.getElementById("rsquared").innerHTML = "Coefficient of Determination: <b>"+ (rsquared).toFixed(4)+"</b>";

            xhttp = new XMLHttpRequest();

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'scatter',
            data: {
                
                datasets: [{
                    label: '(Tuition fee, Number of Students)',
                    data: data2,
                    backgroundColor: 'black',
                    borderColor: 'black',
                    tension: 0
                }, {
                    label: 'line of regression',
                    type: 'line',
                    data: [
                        {x:lowest_x , y:lowest_y}
                        , {x:highest_x , y:highest_y}
                    ],
                    backgroundColor: 'transparent',
                    borderColor: 'green',
                    tension: 0
                },{
                    label: 'Estimated number of Student',
                    type: 'line',
                    data: [
                        {x:estimation_fee , y:estimation_y}
                    ],
                    backgroundColor: 'red',
                    borderColor: 'red',
                    tension: 0
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Linear Regression Model (Total number of Students and Tuition Fee)',
                },
                scales: {
                    yAxes: [{
                        display: true,
                        text: 'awit',
                        
                    }]
                }
            }
            });






        } else {
        }
    }
    

</script>




</body>

</html>
