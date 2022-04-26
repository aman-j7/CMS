<?php
include "../includes/config.php";
$course=$_POST['course'].'p';
$no=$_POST['no'];
$checked=$_POST['checked'];
$head=$_POST['hd'];
mysqli_query($conn,"UPDATE `$course` SET `$no`='$checked' WHERE `header`='$head'");
?>