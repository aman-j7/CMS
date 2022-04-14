<?php
include "../includes/config.php";
if(isset($_SESSION)){
    // setcookie("mode",$_SESSION["mode"],time()+86400*365);
    session_destroy();
}
header("location:../login.php");
?>