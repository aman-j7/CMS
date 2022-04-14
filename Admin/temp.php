<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$time=time();
$row1=mysqli_query($conn,"select student.name from student inner JOIN login on login.reg_id=student.id  where login.islogin > $time");
$row2=mysqli_query($conn,"select teacher.name from teacher inner JOIN login on login.reg_id=teacher.id  where login.islogin > $time");

?>
<html>
  <head> <?php include '../includes/cdn.php'; ?></head>
  <body>
    <?php
     while($res = mysqli_fetch_array($row1)){
         echo $res['name'].'</br>';
      }
      while($res = mysqli_fetch_array($row2)){
        echo $res['name'].'</br>';}
        ?>
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