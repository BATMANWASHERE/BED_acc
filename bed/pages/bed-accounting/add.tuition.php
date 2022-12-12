<?php
require '../../includes/conn.php';
session_start();
ob_start();


require '../../includes/bed-session.php';
?>

<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>Add Tuition Fee | SFAC Bacoor</title>
    <?php include '../../includes/bed-head.php'; ?>
    <script>
        function cash()
        {
            num1 = 0;
           

            var num1 = parseFloat(document.getElementById("cash_basis").value * 1);

            var total = Math.abs((num1 * 0.10) - num1 ).toFixed(2);


            document.getElementById('tuition_fee').value = total.toLocaleString("en-US");

        }


        function reSum()
        {
            num1 = 0;
            num2 = 0;
            num3 = 0;
            num4 = 0;

            var num1 = parseFloat(document.getElementById("tuition_fee").value * 1);
            var num2 = parseFloat(document.getElementById("miscell_fee").value * 1);
            var num3 = parseFloat(document.getElementById("lms").value * 1);
            var num4 = parseFloat(document.getElementById("instruct_mat").value * 1);

            var total = +(num1 + num2 + num3 + num4).toFixed(2);


            document.getElementById('total').value = total.toLocaleString("en-US");

        }

        function reSum1()
        {
            num1 = 0;
            num2 = 0;
            num3 = 0;
            num4 = 0;

            var num1 = parseFloat(document.getElementById("upon_enrollment_tri").value * 1);
            var num2 = parseFloat(document.getElementById("first_tri").value * 1);
            var num3 = parseFloat(document.getElementById("second_tri").value * 1);

            var total = +(num1 + num2 + num3).toFixed(2);


            document.getElementById('total_tri').value = total.toLocaleString("en-US");

        }

        function reSum2()
        {
            num1 = 0;
            num2 = 0;
            num3 = 0;
            num4 = 0;

            var num1 = parseFloat(document.getElementById("upon_enrollment_quar").value * 1);
            var num2 = parseFloat(document.getElementById("first_quar").value * 1);
            var num3 = parseFloat(document.getElementById("second_quar").value * 1);
            var num4 = parseFloat(document.getElementById("third_quar").value * 1);
            var num5 = parseFloat(document.getElementById("fourth_quar").value * 1);

            var total = +(num1 + num2 + num3 + num4 + num5).toFixed(2);


            document.getElementById('total_quar').value = total.toLocaleString("en-US");

        }
       


    </script>

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
                    <a href="#" class="nav-link disabled text-light">Add Tuition Fee</a>
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
                            <div class="col-md-12">
                                <div class="card card-purple shadow-lg">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Tuition Fee
                                        </h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <!-- form start -->

                                    <form action="userData/ctrl.addTuition.php" method="POST">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Grade</b></span>
                                                    </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Grade" name="grade" required>
                                                        <option selected disabled></option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_grade_levels");
                                                            while($row = mysqli_fetch_array($query)) {
                                                                echo '<option value="'.$row['grade_level_id'].'">'.$row['grade_level'].'</option>';
                                                            }
                                                        ?>
                                                    </select>

                                                </div>
                                                
                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Cash Basis</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="cash_basis" id="cash_basis" onkeyup="cash();" placeholder="Php 0.00" required>
                                                        
                                                </div>

                                                
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-sm"><b>
                                                            Academic Year</b></span>
                                                </div>
                                                    <select class="form-control custom-select select2 select2-purple"
                                                        data-dropdown-css-class="select2-purple"
                                                        data-placeholder="Select Year" name="ay" required>
                                                        <option selected disabled></option>
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_acadyears");
                                                            while($row = mysqli_fetch_array($query)) {
                                                                echo '<option value="'.$row['ay_id'].'">'.$row['academic_year'].'</option>';
                                                            }
                                                        ?>
                                                    </select>

                                                </div>

                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Tuition Fee</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="tuition_fee" id="tuition_fee" onkeyup="reSum();" placeholder="Php 0.00" required>
                                                        
                                                </div>

                                                
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                
                                                </div>

                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Miscellaneous Fee</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="miscell_fee" id="miscell_fee" onkeyup="reSum();" placeholder="Php 0.00" required>
                                                        
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Learning Management System</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="lms" id="lms" onkeyup="reSum();" placeholder="Php 0.00" required>
                                                        
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Instructional Materials</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="instruct_mat" id="instruct_mat" onkeyup="reSum();" placeholder="Php 0.00" required>
                                                        
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">
                                                </div>
                                                <div class="input-group col-md-8 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Total</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="total" id="total" placeholder="Php 0.00">
                                                        
                                                </div>
                                            </div>

                                            <hr class="bg-navy">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-3 mb-2">
                                                    <h7><b>Trimestral Basis</b></h7>
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_tri_1" id="date_tri_1" placeholder="">
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_tri_2" id="date_tri_2" placeholder="">
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upon Enrollment</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="upon_enrollment_tri" id="upon_enrollment_tri" onkeyup="reSum1();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">1st Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="first_tri" id="first_tri" onkeyup="reSum1();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Second Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="second_tri" id="second_tri" onkeyup="reSum1();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-3 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Total</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="total_tri" id="total_tri" placeholder="Php 0.00">
                                                </div>
                                            </div>

                                            <hr class="bg-navy">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-2 mb-2">
                                                    <h7><b>Quarterly Basis</b></h7>
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_quar_1" id="date_quart_1" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_quar_2" id="date_quart_2" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Dater</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_quar_3" id="date_quart_3" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Due Date</span>
                                                    </div>
                                                    <input type="date" class="form-control" name="date_quar_4" id="date_quart_4" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Upon Enrollment</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="upon_enrollment_quar" id="upon_enrollment_quar" onkeyup="reSum2();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">First Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="first_quar" id="first_quar" onkeyup="reSum2();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">2nd Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="second_quar" id="second_quar" onkeyup="reSum2();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">3rd Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="third_quar" id="third_quar" onkeyup="reSum2();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">4th Quarter</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="fourth_quar" id="fourth_quar" onkeyup="reSum2();" placeholder="Php 0.00">
                                                </div>
                                                <div class="input-group col-md-2 mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Total</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="total_quar" id="total_quar" placeholder="Php 0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" name="submit" class="btn bg-purple"><i
                                                    class="fas fa-calendar-check m-1"> </i> Set Tuition Fee</button>
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




</body>

</html>