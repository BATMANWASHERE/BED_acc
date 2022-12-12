<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$get_userID = $_GET['stud_no'];

mysqli_query($acc, "DELETE FROM tbl_assessed_tf WHERE stud_no = '$get_userID'");
$_SESSION['success-del'] = true;
header('location: ../list.assess.php');