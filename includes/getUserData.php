<?php
include "../includes/config.php";
$uid=$_SESSION['user_id'];
$time=time();

$row1=mysqli_query($conn,"select reg_id, islogin from login");

// $row1=mysqli_query($conn,"select student.name from student inner JOIN login on login.reg_id=student.id  where login.islogin > $time");
// $row2=mysqli_query($conn,"select teacher.name from teacher inner JOIN login on login.reg_id=teacher.id  where login.islogin > $time");

$html ="";

while($res = mysqli_fetch_array($row1)){
    if($res['islogin'] > $time)
    $html.= $res['reg_id'].'</br>';
  }
//   while($res = mysqli_fetch_array($row2)){
//     $html.= $res['name'].'</br>';
// }

echo $html;

?>
