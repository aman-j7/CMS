<?php
include "config.php";
$id= $_GET['reg'];
$res=mysqli_query($conn,"select password from login where reg_id=$id");
$row=mysqli_fetch_array($res);
if( $row['password']=="CMS@123"   ){
    header("Location:change_password.php?reg=".strval($id));
    

}

?>
<html>
    <body>
   </body>
</html>