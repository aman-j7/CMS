<?php
include 'phpmailer.php';
include 'smtp.php';
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
    	mysqli_query($conn,"update `login` set password=123 where reg_id=$reg");
    	header("Location:login.php");
    }
    else {
        echo "Invalid OTP";
    }
}

if(isset($_POST["submit1"])){
	$reg=$_POST["reg"];
    $res=mysqli_query($conn,"select email from login where reg_id=$reg");
    $row=mysqli_fetch_array($res);
    if($row){
    	$email=$row['email'];
        $otp=rand(100000,999999);
        $mail = new PHPMailer(true);
  
        try {
            $mail->SMTPDebug = 2;                                       
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com;';                    
            $mail->SMTPAuth   = true;                             
            $mail->Username   = 'projectcms05@gmail.com';                 
            $mail->Password   = 'teaching@123';                        
            $mail->SMTPSecure = 'tls';                              
            $mail->Port       = 587;  
          
            $mail->setFrom('projectcms05@gmail.com', 'Name');           
            $mail->addAddress('harshkandpal22@gmail.com');
            //$mail->addAddress('receiver2@gfg.com', 'Name');
               
            $mail->isHTML(true);                                  
            $mail->Subject = 'Subject';
            $mail->Body    = 'HTML message body in <b>bold</b> ';
            $mail->AltBody = 'Body in plain text for non-HTML mail clients';
            $mail->send();
            echo "Mail has been sent successfully!";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        echo $email;
        echo $otp;
        $flag=0;
    }
	else {
        echo "login failed";
        header("Location:login.php");
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