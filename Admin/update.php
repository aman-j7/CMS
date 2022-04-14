<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$row=mysqli_query($conn,"Select islogin,reg_id from login");
<html>
  <head> <?php include '../includes/cdn.php'; ?></head>
  <body>
    <?php
     while($res = mysqli_fetch_array($row)){
       if($res['islogin']>$time)
       {
         echo $res['reg_id'].'</br>';
       }
      }?>
      <script type="text/javascript" src="../js/sidebar.js"></script>

?>
