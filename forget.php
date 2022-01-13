<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  
require 'vendor/autoload.php';
include"config.php";
$flag=1;
$otp=0;
$reg=0;

if(isset($_POST["submit2"])){
	$o1=$_POST["otp1"];
	$otp=$_POST["otp2"];
	$reg=$_POST["reg"];
	$flag=0;
    if($o1==$otp){
    	mysqli_query($conn,"update `login` set password='CMS@123' where reg_id=$reg");
        echo '<script>alert("Your default password is CMS@123");
        window.location.href="login.php"</script>';
    }
    else {
        echo '<script>alert("Invalid OTP")</script>';
    }
}

if(isset($_POST["submit1"])){
	$reg=$_POST["reg"];
    $res=mysqli_query($conn,"select email from login where reg_id=$reg");
    $row=mysqli_fetch_array($res);
    if($row){
    	$email=$row['email'];
        $otp=rand(100000,999999);
        $msg="Your otp is".strval($otp);
        echo $msg;
        $mail = new PHPMailer(true);
        $mail->setFrom('projectcms05@gmail.com');
        $mail->addAddress($email);
        $mail->Subject = 'Otp for new password';
        $mail->Body = $msg;
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'projectcms05@gmail.com';

        //Set the password of your gmail address here
        $mail->Password = 'teaching@123';
        if($mail->send()) {
            echo '<script>alert("Email has been sent")</script>';
        }
        else
        {
            echo '<script>alert("Email has not been sent");
            window.location.href="login.php"</script>';
        }
        
        $flag=0;
    }
	else {
        echo '<script>alert("Invalid registration number");
        window.location.href="login.php"</script>';
        

    }
}
?>
<html>
<body>
<?php if($flag): ?>
<h2>Please Enter Your Registration No</h2>
<form method="POST" action="forget.php">
<table  align="center"  cellspacing=" 25">
    <tr>
        <th>Registration No</th>
        <td><input type="integer" name="reg" required></td>
    </tr>
    <tr>
        <td></td>
        <td><input id="submit" type="submit"  value="Submit" name="submit1"></td>
    </tr>
</table>
</form>
<?php elseif(!$flag): ?>
<h2>Please Enter OTP</h2>
<form method="POST" action="forget.php">
<table  align="center"  cellspacing=" 25">
    <tr>
        <th> OTP </th>
        <td><input type="integer" name="otp1" required></td>
        <td><input type="integer" name="otp2" value= <?php echo $otp; ?> hidden></td>
        <td><input type="integer" name="reg" value= <?php echo $reg; ?> hidden></td>
    </tr>    
    <tr>
        <td></td>
        <td><input id="submit" type="submit"  value="Submit" name="submit2"></td>
    </tr>
</table>
</form>
<?php endif; ?>
</body>
</html>