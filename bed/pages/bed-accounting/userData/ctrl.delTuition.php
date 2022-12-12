<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$get_userID = $_GET['tf_id'];

mysqli_query($acc, "DELETE FROM tbl_tuition_fee WHERE tf_id = '$get_userID'");
$_SESSION['success-del'] = true;
header('location: ../list.tuition.php');