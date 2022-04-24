<?php
include "../includes/config.php";
$course=$_POST['course'];
$no=$_POST['no'];
$checked=$_POST['checked'];
mysqli_query($conn,"UPDATE `$course` SET `checked`='$checked' WHERE `no`='$no'");
?>