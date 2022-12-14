<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

if (isset($_POST['submit'])) {

    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);

    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $ay = mysqli_real_escape_string($conn, $_POST['ay']);
    $cash_basis = mysqli_real_escape_string($conn, $_POST['cash_basis']);
    $tuition_fee = mysqli_real_escape_string($conn, $_POST['tuition_fee']);
    $miscell_fee = mysqli_real_escape_string($conn, $_POST['miscell_fee']);
    $lms = mysqli_real_escape_string($conn, $_POST['lms']);
    $instruct_mat = mysqli_real_escape_string($conn, $_POST['instruct_mat']);
    $total= $tuition_fee + $miscell_fee + $lms + $instruct_mat;
    $updated_by = $row['fullname'] .' - '. $_SESSION['role'];

    $date_tri_1 = mysqli_real_escape_string($conn, $_POST['date_tri_1']);
    $date_tri_2 = mysqli_real_escape_string($conn, $_POST['date_tri_2']);
    $upon_enrollment_tri = mysqli_real_escape_string($conn, $_POST['upon_enrollment_tri']);
    $first_tri = mysqli_real_escape_string($conn, $_POST['first_tri']);
    $second_tri = mysqli_real_escape_string($conn, $_POST['second_tri']);

    $total_tri = $upon_enrollment_tri + $first_tri + $second_tri;
    
    $date_quar_1 = mysqli_real_escape_string($conn, $_POST['date_quar_1']);
    $date_quar_2 = mysqli_real_escape_string($conn, $_POST['date_quar_2']);
    $date_quar_3 = mysqli_real_escape_string($conn, $_POST['date_quar_3']);
    $date_quar_4 = mysqli_real_escape_string($conn, $_POST['date_quar_4']);
    $upon_enrollment_quar = mysqli_real_escape_string($conn, $_POST['upon_enrollment_quar']);
    $first_quar = mysqli_real_escape_string($conn, $_POST['first_quar']);
    $second_quar = mysqli_real_escape_string($conn, $_POST['second_quar']);
    $third_quar = mysqli_real_escape_string($conn, $_POST['third_quar']);
    $fourth_quar = mysqli_real_escape_string($conn, $_POST['fourth_quar']);

    $total_quar = $upon_enrollment_quar + $first_quar + $second_quar + $third_quar + $fourth_quar;


        $check_tuition = mysqli_query($acc, "SELECT * FROM tbl_tuition_fee WHERE ay_id = '$ay' AND grade_level_id = '$grade' AND tuition_fee = '$tuition_fee' AND miscell_fee = '$miscell_fee' AND lms = '$lms' AND instruct_mat = '$instruct_mat' AND ay_id = '$ay'") or die(mysqli_error($acc));

        $result = mysqli_num_rows($check_tuition);

        if ($result > 0) {
            $_SESSION['tf_existing'] = true;
            header('location: ../add.tuition.php');

        } else {
            $insert_tuition = mysqli_query($acc, "INSERT INTO tbl_tuition_fee (ay_id , grade_level_id, cash_basis, tuition_fee, miscell_fee, lms, instruct_mat, total, date_tri_1, date_tri_2, upon_enrollment_tri, first_tri, second_tri, total_tri, date_quar_1, date_quar_2, date_quar_3, date_quar_4, upon_enrollment_quar, first_quar, second_quar, third_quar, fourth_quar, total_quar, created_at, last_updated, updated_by) 
            VALUES ('$ay', '$grade', '$cash_basis','$tuition_fee', '$miscell_fee', '$lms', '$instruct_mat', '$total', '$date_tri_1', '$date_tri_2', '$upon_enrollment_tri', '$first_tri', '$second_tri', '$total_tri', '$date_quar_1', '$date_quar_2', '$date_quar_3', '$date_quar_4', '$upon_enrollment_quar', '$first_quar', '$second_quar', '$third_quar', '$fourth_quar', '$total_quar', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$updated_by')") or die(mysqli_error($acc));
            $_SESSION['success'] = true;
            header('location: ../add.tuition.php');

        }



        
}