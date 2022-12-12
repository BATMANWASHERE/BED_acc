<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

require '../../../includes/bed-session.php';

$stud_no = $_GET['stud_no'];

if (isset($_POST['submit'])) {
    $get_acc_name = mysqli_query($conn,"SELECT *, CONCAT(tbl_accountings.accounting_lname, ', ', tbl_accountings.accounting_fname, ' ', tbl_accountings.accounting_mname) AS fullname FROM tbl_accountings WHERE acc_id = '$_SESSION[acc_id]'");
    $row = mysqli_fetch_array($get_acc_name);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);

    if ($grade == 14 || $grade == 15) {
        $sem = mysqli_real_escape_string($conn, $_POST['sem']);
    } else {
        $sem = '';
    }
    $ay = mysqli_real_escape_string($conn, $_POST['ay']);
    $tf_id = mysqli_real_escape_string($conn, $_POST['tf_id']);
    $updated_by = $row['fullname'] .' - '. $_SESSION['role'];
    $created_at = mysqli_real_escape_string($conn, $_POST['created_at']);

    if (isset($_POST['payment'])) {
        $payment_array = $_POST['payment'];
        $payment_array_count = count($payment_array);
    }

    if (isset($_POST['discounts_checkbox'])) {
        $discount_array = $_POST['discounts_checkbox'];
    }

    $discount_value = implode(",",$discount_array);

    if ($payment_array_count >= 2) {

        $_SESSION['multiple_payment'] = true;
        header('location: ../edit.assessment.php?stud_no='.$stud_no);

    } else {
        $final_payment = $payment_array[0];

        if (!empty($discount_array) && !empty($payment_array)) {
       
            $insert_tuition = mysqli_query($acc, "UPDATE tbl_assessed_tf SET ay_id = '$ay', sem_id = '$sem', disc_id = '$discount_value', stud_no = '$stud_no', payment = '$final_payment', tf_id = '$tf_id', last_updated = CURRENT_TIMESTAMP, updated_by = '$updated_by' WHERE stud_no = '$stud_no'") or die(mysqli_error($acc));
    
            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$final_payment.'.php?stud_no='.$stud_no);
    
        } elseif (empty($discount_array) && !empty($payment_array)) {

            $insert_tuition = mysqli_query($acc, "UPDATE tbl_assessed_tf SET ay_id = '$ay', sem_id = '$sem', disc_id = '', stud_no = '$stud_no', payment = '$final_payment', tf_id = '$tf_id', last_updated = CURRENT_TIMESTAMP, updated_by = '$updated_by' WHERE stud_no = '$stud_no'") or die(mysqli_error($acc));

            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$final_payment.'.php?stud_no='.$stud_no);
        
        } elseif (empty($payment_array)){

            $_SESSION['no_payment_type'] = true;
            header('location: ../edit.assessment.php?stud_no='.$stud_no);


        }

    }
  
}


?>