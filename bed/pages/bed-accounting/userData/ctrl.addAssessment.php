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

    if (isset($_POST['payment'])) {
        $payment_array = $_POST['payment'];
        $payment_array_count = count($payment_array);
    }

    if (isset($_POST['discounts_checkbox'])) {
        $discount_array = $_POST['discounts_checkbox'];
    }

    $discount_value = implode(",",$discount_array);

    if ($payment_array_count <= 1 ) {

        $final_payment = $payment_array[0];

        if (!empty($discount_array) && !empty($payment_array)) {
        
            $insert_tuition = mysqli_query($acc, "INSERT INTO tbl_assessed_tf (ay_id, sem_id, disc_id, stud_no, payment, tf_id, created_at, last_updated, updated_by) VALUES ('$ay', '$sem', '$discount_value', '$stud_no', '$final_payment', '$tf_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$updated_by')") or die(mysqli_error($acc));

            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$final_payment.'.php?stud_no='.$stud_no);
    
        } elseif (empty($discount_array) && !empty($payment_array)) {

            $insert_tuition = mysqli_query($acc, "INSERT INTO tbl_assessed_tf (ay_id, sem_id, stud_no, payment, tf_id,  created_at, last_updated, updated_by) VALUES ('$ay', '$sem', '$stud_no', '$final_payment', '$tf_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$updated_by')") or die(mysqli_error($acc));
            $_SESSION['success'] = true;
            header('location: ../assessment.fee.'.$final_payment.'.php?stud_no='.$stud_no);
            
        } elseif (empty($payment_array)) {
            
            $_SESSION['no_payment_type'] = true;
            header('location: ../add.assessment.php?stud_no='.$stud_no);

        }

    } else {
        $_SESSION['multiple_payment'] = true;
        header('location: ../add.assessment.php?stud_no='.$stud_no);

    }
  
}


?>