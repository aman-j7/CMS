<?php
include"config.php";
$id=$_GET['reg'];
if(isset($_POST["submit"])){
    $pass1=$_POST['pass1'];
    $pass2=$_POST['pass2'];
    if($pass1 == $pass2){
        if( $pass1!= "CMS@123"   ){
        mysqli_query($conn,"update `login` set password='$pass2' where reg_id=$id");
        echo '<script>alert("Your Password Has Been Changed Successfully");
        window.location.href="admin_dashboard.php"</script>';
        }
        else {
            echo '<script>alert("Use Some Other Password")</script>';
        }
    }
    else{
        echo '<script>alert("Your Password Does Not Match")</script>';
    }
} 
?>
<html>
<body>
<h2>Enter Password</h2>
<form method="POST" action="change_password.php?reg=<?php echo $id ?>" >
<table  align="center"  cellspacing=" 25">
    <tr>
        <th>New Password</th>
        <td><input type="text"  name="pass1" required></td>
    </tr>
    <tr>
        <th>Confirm Password</th>
        <td><input type="text" name="pass2" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input id="submit" type="submit"  value="Submit" name="submit"></td>
    </tr>
</table>
</form>
</body>
</html>