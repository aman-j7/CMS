<?php
include "../includes/config.php";
if(isset($_SESSION)){
    // setcookie("mode",$_SESSION["mode"],time()+86400*365);
    $id=$_SESSION['user_id'];
    mysqli_query($conn, "UPDATE `login` SET `islogin`=0 WHERE `reg_id`='$id'");
    session_destroy();
}
header("location:../login.php");
?>