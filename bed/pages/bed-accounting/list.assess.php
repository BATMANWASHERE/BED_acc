<?php
require '../../includes/conn.php';
require 'accountConn/conn.php';

session_start();
ob_start();

require '../../includes/bed-session.php';

if (isset($_GET['ay_id'])) {
    $ay_id = $_GET['ay_id'];
} else {
    $get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
    $row_ay = mysqli_fetch_array($get_ay_id);
    $ay_id = $row_ay['ay_id'];

    
}

?>


<!DOCTYPE html>
<html lang="en">

<!-- Head and links -->

<head>
    <title>List of Assessed Fees | SFAC Bacoor</title>
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
                    <a href="#" class="nav-link disabled text-light">List of Assessed Fees</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link disabled text-light">Basic Education</a>
                </li>
            </ul>
            <?php include '../../includes/bed-navbar.php'; ?>

            <!-- sidebar menu -->
            <?php include '../../includes/bed-sidebar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper pt-4 pb-2">

                <!-- tables -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow">
                                    <div class="card-header bg-navy p-3">
                                        <h3 class="card-title text-lg">Assessed Fees</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <form method="GET">
                                            <div class="row justify-content-center">
                                                <div class="input-group col-md-4 mb-2">

                                                </div>
                                                <div class="input-group col-md-4 mb-2">
                                                    <form method="GET">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Academic Year</span>
                                                    </div>
                                                        
                                                    <select class="form-control custom-select select2 select2-purple"
                                                            data-dropdown-css-class="select2-purple"
                                                            data-placeholder="Select Year" name="ay_id">
                                                        <?php
                                                        $query_selected = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE ay_id = '$ay_id'");
                                                        while ($row3 = mysqli_fetch_array($query_selected)) {
                                                            echo '<option selected value="'.$row3['ay_id'].'" name="ay_id">'.$row3['academic_year'].'</option>';
                                                        }
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE NOT ay_id = '$ay_id'");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="'.$row['ay_id'].'" name="ay_id">'.$row['academic_year'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn bg-navy"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Search">
                                                                <i class="fa fa-search"></i>
                                                                Filter
                                                            </button>
                                                    </div>
                                                    </form>
                                                </div>
                                                <div class="input-group col-md-4 mb-2 justify-content-end">
                                                    <a class="btn bg-navy"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Change Student's Payment Type if Exceeded in Due Date" href="edit.payment.type.php" disabled>
                                                                <i class="fas fa-cog"></i> Change Payment Types</a>
                                                </div>
                                            </div>
                                        </form>

                                        <hr class="bg-navy">
                                        <table id="example2" class="table table-hover">
                                            <thead class="bg-gray-light">
                                                <tr>
                                                    <th>Student ID</th>
                                                    <th>Student Name</th>
                                                    <th>Grade Level</th>
                                                    <th>School Year</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="border-bottom">
                                                <tr>
                                                <?php
                                                    $get_tf_info = mysqli_query($acc, "SELECT DISTINCT stud_no, tbl_assessed_tf.ay_id, payment  FROM tbl_assessed_tf
                                                    LEFT JOIN tbl_discounts ON tbl_discounts.disc_id = tbl_assessed_tf.disc_id
                                                    LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE tbl_assessed_tf.ay_id = '$ay_id'")or die(mysqli_error($acc));
                                                    
                                                        while ($row = mysqli_fetch_array($get_tf_info)) {
                                                            
                                                        $id = $row['stud_no']; 
                                                        $aySec = mysqli_query($conn, "SELECT * FROM tbl_acadyears WHERE ay_id = '$row[ay_id]'") ;
                                                        $ayFetch = mysqli_fetch_array($aySec);
                                        
                                                        $student_info = mysqli_query($conn, "SELECT *, CONCAT(tbl_students.student_lname, ', ', tbl_students.student_fname, ' ', tbl_students.student_mname) AS fullname FROM tbl_schoolyears
                                                        LEFT JOIN tbl_students ON tbl_schoolyears.student_id = tbl_students.student_id
                                                        LEFT JOIN tbl_grade_levels ON tbl_schoolyears.grade_level_id = tbl_grade_levels.grade_level_id
                                                        WHERE tbl_students.stud_no = '$row[stud_no]' AND ay_id = '$ay_id'") or die(mysqli_error($conn));

                                                        $row2 = mysqli_fetch_array($student_info);

                                                ?>
                                                    <td><?php echo $row2['stud_no']; ?></td>
                                                    <td><?php echo $row2['fullname']; ?></td>
                                                    <td><?php echo $row2['grade_level']; ?></td>
                                                    <td><?php echo $ayFetch['academic_year']; ?></td>

                                                    
                                                    <td><a href="assessment.fee.<?php echo $row['payment']?>.php<?php echo '?stud_no=' . $id; ?>"
                                                            type="button"
                                                            class="btn bg-lightblue text-sm p-2 mb-md-2"><i
                                                                class="fa fa-eye"></i>
                                                            See Details
                                                        </a>

                                                        <!-- Button trigger modal -->
                                                        <a type="button" class="btn bg-red text-sm p-2 mb-md-2"
                                                            data-toggle="modal"
                                                            data-target="#exampleModal<?php echo $id ?>"><i
                                                                class="fa fa-trash"></i>
                                                            Delete
                                                        </a>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal<?php echo $id ?>"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-red">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            <i class="fa fa-exclamation-triangle"></i>
                                                                            Confirm Delete
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body p-3">
                                                                        Are you sure you want to delete <b><?php echo $row2['fullname']; ?></b> assessment?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <a href="userData/ctrl.delAssessment.php<?php echo '?stud_no=' . $id; ?>"
                                                                            type="button"
                                                                            class="btn btn-danger">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr><?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
                </section>
                <!-- /.content -->

            </div>
            <!-- /.content-wrapper -->


            <!-- Footer and script -->
            <?php include '../../includes/bed-footer.php';
            if (isset($_SESSION['success-del'])) {
                echo "<script>
                $(function() {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    }); 
            $('.swalDefaultSuccess') 
            Toast.fire({
            icon: 'success',
            title: 'Successfully Deleted.'
            })
            }); 
            </script>";
            }
            unset($_SESSION['success-del']);
            ?>
            <!-- Page specific script -->
            <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
            </script>


</body>

</html>