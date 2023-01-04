<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

require '../../../includes/bed-session.php';

$stud_id = $_GET['stud_id'];

if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);

    if ($grade == 14 || $grade == 15) {
        $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    } else {
        $sem = '';
    }
    $ay_id = mysqli_real_escape_string($conn, $_POST['ay_id']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);
    $tf_id = mysqli_real_escape_string($conn, $_POST['tf_id']);
    $updated_by = $row['fullname'] .' - '. $_SESSION['role'];

    if (isset($_POST['discounts_checkbox'])) {
        $discount_array = $_POST['discounts_checkbox'];
    }

    $discount_value = implode(",",$discount_array);

        if (!empty($discount_array)) {
       
            $insert_tuition = mysqli_query($acc, "UPDATE tbl_assessed_tf SET ay_id = '$ay_id', sem_id = '$sem', disc_id = '$discount_value', stud_id = '$stud_id', payment = '$payment', tf_id = '$tf_id', last_updated = CURRENT_TIMESTAMP, updated_by = '$updated_by' WHERE stud_id = '$stud_id' AND ay_id = '$ay_id'") or die(mysqli_error($acc));
    
            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$payment.'.php?stud_id='.$stud_id);
    
        } elseif (empty($discount_array)) {

            $insert_tuition = mysqli_query($acc, "UPDATE tbl_assessed_tf SET ay_id = '$ay_id', sem_id = '$sem', disc_id = '', stud_id = '$stud_id', payment = '$payment', tf_id = '$tf_id', last_updated = CURRENT_TIMESTAMP, updated_by = '$updated_by' WHERE stud_id = '$stud_id' AND ay_id = '$ay_id'") or die(mysqli_error($acc));

            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$payment.'.php?stud_id='.$stud_id);
        
        }

    
  
}


?>