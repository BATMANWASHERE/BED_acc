<?php
require '../../includes/conn.php';
require '../bed-accounting/accountConn/conn.php';
session_start();
ob_start();

require '../../includes/bed-session.php';

$get_active_sem = mysqli_query($conn, "SELECT * FROM tbl_active_semesters AS asem
LEFT JOIN tbl_semesters AS sem ON sem.semester_id = asem.semester_id");
while ($row = mysqli_fetch_array($get_active_sem)) {
    $sem = $row['semester_id'];
    $sem_n = $row['semester'];
}

$get_active_acad = mysqli_query($conn, "SELECT * FROM tbl_active_acadyears AS aay
LEFT JOIN tbl_acadyears AS ay ON ay.ay_id = aay.ay_id");
while ($row = mysqli_fetch_array($get_active_acad)) {
    $acad = $row['ay_id'];
    $acad_n = $row['academic_year'];
}
?>



<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Dashboard | SFAC Bacoor</title>
    <?php include '../../includes/bed-head.php'; ?>

<script>

</script>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <?php
        if (isset($_SESSION['pre-loader'])) {
            echo ' <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="../../../assets/img/logo.png" alt="logo-preloader" height="100" width="100">
    </div>';
        }
        unset($_SESSION['pre-loader']); ?>


        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Accounting Dashboard</a>
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

                <!-- Main content -->
                <?php if ($_SESSION['role'] == "Accounting") { ?>

<?php
$active_ay = mysqli_query($conn, "SELECT * FROM tbl_active_acadyears");
while ($row = mysqli_fetch_array($active_ay)) {
    $ay_id = $row['ay_id'];
} ?>

<?php $active_ay = mysqli_query($conn, "SELECT * FROM tbl_active_semesters");
while ($row = mysqli_fetch_array($active_ay)) {
    $sem_id = $row['semester_id'];
} ?>


<!-- Main content -->
<section class="content">
 <div class="container-fluid ">
     <!-- Small boxes (Stat box) -->
     <div class="row">
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-info">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT stud_no) as total_stud FROM tbl_assessed_tf WHERE ay_id = '$ay_id'") or die(mysqli_error($acc));

                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>
                     <p><small>Total No. of</small> <b>Assessed Fees</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-people"></i>
                 </div>
                 <a href="db.enrolledStudents.php" class="small-box-footer">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT stud_no) as total_stud FROM tbl_assessed_tf WHERE ay_id = '$ay_id' AND payment = 'cash' ") or die(mysqli_error($acc));
                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>
                     <p><small class="black">Total No. of</small> <b>Assessed Fees - Cash Basis</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-person-stalker"></i>
                 </div>
                 <a href="db.newStudents.php" class="small-box-footer">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT stud_no) as total_stud FROM tbl_assessed_tf WHERE ay_id = '$ay_id' AND payment = 'trimestral'") or die(mysqli_error($acc));
                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>
                     <p><small>Total No. of</small> <b>Assessed Fees - Trimestral Basis</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-people"></i>
                 </div>
                 <a href="db.oldStudents.php" class="small-box-footer">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT stud_no) as total_stud FROM tbl_assessed_tf WHERE ay_id = '$ay_id' AND payment = 'quarterly'") or die(mysqli_error($acc));
                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>

                     <p><small>Total No. of</small>
                     <b>Assessed Fees - Quarterly Basis</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-clock"></i>
                 </div>
                 <a href="db.pendingEnrollees.php" class="small-box-footer text-gray-dark">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-info">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT disc_id) as total_stud FROM tbl_discounts WHERE ay_id = '$ay_id'") or die(mysqli_error($acc));

                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>
                     <p><small>Active</small> <b>Discounts (<?php echo $acad_n;?>)</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-people"></i>
                 </div>
                 <a href="db.enrolledStudents.php" class="small-box-footer">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
         <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-success">
                 <div class="inner">
                     <?php $stud_count = mysqli_query($acc, "SELECT COUNT(DISTINCT stud_no) as total_stud FROM tbl_assessed_tf WHERE ay_id = '$ay_id' AND payment = 'quarterly'") or die(mysqli_error($acc));
                        while ($row = mysqli_fetch_array($stud_count)) { ?>
                     <h3><?php echo $row['total_stud']; ?></h3>
                     <?php } ?>

                     <p><small>Total No. of</small>
                     <b>Assessed Fees - Quarterly Basis</b></p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-clock"></i>
                 </div>
                 <a href="db.pendingEnrollees.php" class="small-box-footer text-gray-dark">View Details <i
                         class="fas fa-arrow-circle-right"></i></a>
             </div>
         </div>
     </div>
     <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Data Analysis</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group row mb-2">
                                <br>
                            </div>
                            <form action="">
                            <div class="input-group row mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-sm"><b>
                                    Grade</b></span>
                                </div>
                                <select class="form-control custom-select select2 select2-purple" data-dropdown-css-class="select2-purple" data-placeholder="Select Grade" name="grade" onchange="gradeHINT(this.value)">
                                    <option selected disabled>Select Grade Level</option>
                                    <?php
                                        $query = mysqli_query($conn, "SELECT * FROM tbl_grade_levels");
                                        while($row2 = mysqli_fetch_array($query)) {
                                            echo '<option value="'.$row2['grade_level_id'].'">'.$row2['grade_level'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div class="input-group row mb-2">
                                <p><span id="demo"></span></p>
                            <div>

                            </div>
                            </form>
                        </div>          
                    </div>
                </div>
                <div class="card-footer">
                    <a href="linear.regression.php" type="button" class="btn bg-green text-sm p-2 mb-md-2">
                        <i class="fa fa-trash"></i> Estimate number of students
                    </a>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

     </div>
     <!-- /.row -->
     <!-- Main row -->

     <!-- /.row (main row) -->
 </div><!-- /.container-fluid -->
</section>
<!-- /.content --> 
<?php
    } 
?>
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


            </div>
            <!-- /.content-wrapper -->


            <!-- Footer and script -->
            <?php include '../../includes/bed-footer.php';  ?>
<script>
   
   function gradeHINT(kingina) {

    const array1 = [ <?php 
            foreach ($array_chart1 as $value_array) {
                echo $value_array .", ";
        }?>
    ];


    const data2 = [];
    const data2_x = [];
    
    let sum_of_x = 0;
    let sum_of_y = 0;
    let i = 0;

    array1.forEach(function1);
    data2.forEach(function2);


    function function1 (arr_value) {
        if (arr_value.grade == kingina) {
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

    data2.forEach(products);

    function products(data_value) {
        sumofproducts += Math.pow((data_value.x - mean_x), 2);

    }

    let sumofsquares = 0;

    data2.forEach(squares);

    function squares(data_value) {
        sumofsquares += (data_value.x - mean_x) * (data_value.y - mean_y);
    }

    console.log(sumofproducts);
    console.log(sumofsquares);

    let b = sumofsquares/sumofproducts;
    let a = mean_y - (b * mean_x);


    let lowest_y = ((b * lowest_x) + a).toFixed(2);
    let highest_y = ((b * highest_x) + a).toFixed(2);

    var xhttp;
    if (kingina.length == 0) { 
        document.getElementById("grade_text").innerHTML = "";
        return;
    }

    document.getElementById("demo").innerHTML = "Line of Regression y = (aX + b):<b> "+(b).toFixed(4) +"X + " + (a).toFixed(2)+ "</br>";

    xhttp = new XMLHttpRequest();

    // xhttp.onreadystatechange = function() {

    // if (this.readyState == 4 && this.status == 200) {

    //     document.getElementById("grade_text").innerHTML = this.responseText;
    //     }
    // };
    // xhttp.open("GET", "gethint.php?q="+kingina, true);
    // xhttp.send();   


    

    //////////
    
    

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

   }

</script>


</body>

</html>