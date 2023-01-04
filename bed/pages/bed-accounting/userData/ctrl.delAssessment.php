<?php
require '../../../includes/conn.php';
require '../accountConn/conn.php';
session_start();
ob_start();

$assessed_id = $_GET['assessed_id'];

mysqli_query($acc, "DELETE FROM tbl_assessed_tf WHERE assessed_id = '$assessed_id'") or die (mysqli_error($acc));
$_SESSION['success-del'] = true;
header('location: ../list.assess.php');