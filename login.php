<?php
include"config.php";
if(isset($_POST["submit"])){
    $e=$_POST["id"];
    $p=$_POST["password"];
    $res=mysqli_query($conn,"select role from login where reg_id=$e and password='$p'");
    $row=mysqli_fetch_array($res);
    if( $row   ){
        if($row['role']=="teacher")
           header("Location:teacher_dashboard.php");
        elseif($row['role']=="admin")
            header("Location:admin_dashboard.php?reg=".strval($e));
        elseif($row['role']=="student")
            header("Location:student_dashboard.php");
    }
    else {
        echo "login failed";
    }
} 
    
?>
<html>
<head>
    <title>FORM</title>
</head>
<body>
<h2>Please Enter Your Details</h2>
<form method="POST" action="login.php">
<table  align="center"  cellspacing=" 25">
    <tr>
        <th>Registration No</th>
        <td><input type="integer" name="id" required></td>
    </tr>
    <tr>
        <th>Password</th>
        <td><input type="Password" name="password" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input id="submit" type="submit"  value="Login" name="submit"></td>
        <td><a href="forget.php">Forget Password ? </a></td>
    </tr>
</table>
</form>
</body>
</html>
