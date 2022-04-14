<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$time=time();
$row=mysqli_query($conn,"Select islogin,reg_id from login");
?>
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
    <script>function updateUserStatus(){
  jQuery.ajax({
    url:'temp.php',
    success:function(){
      console.log("oohhhh");
    }
  });

}
 setInterval(function(){
   updateUserStatus();
  
 },5000);
 function updateUserStatus1(){
  jQuery.ajax({
    url:'../includes/update_user_status.php',
    success:function(){
        console.log("ok");
    }
  });

}
 setInterval(function(){
   updateUserStatus1();
  
 },3000);</script>
 
  </body>
</html>