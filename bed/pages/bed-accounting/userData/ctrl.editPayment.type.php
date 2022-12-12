<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$get_ay_id = mysqli_query($conn,"SELECT * FROM tbl_acadyears WHERE academic_year = '$_SESSION[active_acadyears]'");
$row_ay = mysqli_fetch_array($get_ay_id);
$ay_id = $row_ay['ay_id'];

$action = $_GET['action'];

if ($action == 'trimestral_unsettled') {

    $total_paid = 0;
    $total_unpaid = 0;

    $select_user = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE payment = 'trimestral' AND tbl_assessed_tf.ay_id = '$ay_id'"); //nag pass na sa due

    $date_array = [];

    while ($row = mysqli_fetch_array($select_user)) {

        $date_array[] = ($row['date_tri_1']);
        $date_array[] = ($row['date_tri_2']);

        $current_date = new DateTime(date('d-m-Y'));

        foreach  ($date_array as $date_value) {
            $date = new DateTime($date_value);
            $date_z = date_format($date,'z');
            $current_z = date_format($current_date,'z');
                                                        
            if ($current_z <= $date) {

                $select_unpaid = mysqli_query($acc, "SELECT * FROM tbl_payments_status WHERE stud_no ='$row[stud_no]' AND payment_date = '$date_value'");
                if (mysqli_num_rows($select_unpaid) != 0) {
                    } else {
                        $select_unpaid = mysqli_query($acc, "UPDATE tbl_assessed_tf SET status = 'Unpaid' WHERE stud_no ='$row[stud_no]'");
                }
                break;
            } else {
            }
        }
    }

} elseif ($action == 'change_type') {

    $total_paid = 0;
    $total_unpaid = 0;

    $select_user = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE payment = 'trimestral' AND tbl_assessed_tf.ay_id = '$ay_id'"); //nag pass na sa due

    $date_array = [];

    while ($row = mysqli_fetch_array($select_user)) {

        $date_array[] = ($row['date_tri_1']);
        $date_array[] = ($row['date_tri_2']);

        $current_date = new DateTime(date('d-m-Y'));

        foreach  ($date_array as $date_value) {
            $date = new DateTime($date_value);
            $date_z = date_format($date,'z');
            $current_z = date_format($current_date,'z');
                                                        
            if ($current_z <= $date) {

                $select_unpaid = mysqli_query($acc, "SELECT * FROM tbl_payments_status WHERE stud_no ='$row[stud_no]' AND payment_date = '$date_value'");
                if (mysqli_num_rows($select_unpaid) != 0) {
                    } else {
                        $select_unpaid = mysqli_query($acc, "UPDATE tbl_assessed_tf SET payment = 'quarterly' WHERE stud_no ='$row[stud_no]'");
                }
                break;
            } else {
            }
        }
    }

} else {

    $select_user = mysqli_query($acc, "SELECT * FROM tbl_assessed_tf LEFT JOIN tbl_tuition_fee ON tbl_tuition_fee.tf_id = tbl_assessed_tf.tf_id WHERE payment = 'quarterly' AND tbl_assessed_tf.ay_id = '$ay_id'"); //nag pass na sa due

    $date_array = [];

    while ($row = mysqli_fetch_array($select_user)) {

        $date_array[] = ($row['date_quar_1']);
        $date_array[] = ($row['date_quar_2']);
        $date_array[] = ($row['date_quar_3']);
        $date_array[] = ($row['date_quar_4']);

        $current_date = new DateTime(date('d-m-Y'));

        foreach  ($date_array as $date_value) {
            $date = new DateTime($date_value);
            $date_z = date_format($date,'z');
            $current_z = date_format($current_date,'z');
                                                        
            if ($current_z <= $date) {

                $select_unpaid = mysqli_query($acc, "SELECT * FROM tbl_payments_status WHERE stud_no ='$row[stud_no]' AND payment_date = '$date_value'");
                if (mysqli_num_rows($select_unpaid) != 0) {
                
                    } else {
                        $select_unpaid = mysqli_query($acc, "UPDATE tbl_assessed_tf SET status = 'Unpaid' WHERE stud_no ='$row[stud_no]'");
                }
                break;
            } else {
            }
        }
    }
}