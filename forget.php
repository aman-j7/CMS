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
        $mail = new PHPMailer;
        $mail->setFrom('rojectcms05@gmail.com');
        $mail->addAddress($email);
        $mail->Subject = 'Otp for new password';
        $mail->Body = $msg;
        $mail->isSMTP();
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'projectcms05@gmail.com';

        //Set the password of your gmail address here
        $mail->Password = 'teaching@123';
        if($mail->send()) {
            echo '<script>alert("Otp has been sent to the registered email id")</script>';
        }
        else
        {
            echo '<script>alert("Error Occured!");
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

<head>

<link rel="stylesheet" href="CSS/cms.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>E-Learning</title>

</head>

<body>

<?php if($flag): ?>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center mb-4">
                  <img src="https://seeklogo.com/images/G/graduated-online-education-logo-2327B5F5C0-seeklogo.com.png" style="width: 185px;" alt="logo">
                </div>

                <form method="POST" action="forget.php">
                  <p><strong>Enter Your Registration Number</strong></p>

                  <div class="form-outline mb-4">
                    <input type="integer" name="reg" required id="login1" class="form-control" placeholder="Registration Number"/>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <input class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" name="submit" value="Submit"/>
                  </div>

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4 text-center">Next Gen Learning</h4>
                <p class="small mb-0"> </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
    <tr>
        <td></td>
        <td>Time left = <span id="timer"></span></td>
    </tr>
</table>
</form>

<script>
        document.getElementById('timer').innerHTML =
        00 + ":" + 10;
        Timer();


        function Timer() {
        var presentTime = document.getElementById('timer').innerHTML;
        var timeArray = presentTime.split(/[:]+/);
        var m = timeArray[0];
        var s = second((timeArray[1] - 1));
        if(s==59){m=m-1}
        if(m<0){
            alert("Otp has been exipiried");
            window.location.href="forget.php";
        }
        
        document.getElementById('timer').innerHTML =
            m + ":" + s;
        console.log(m)
        setTimeout(Timer, 1000);
      
        
        }
      
        function second(sec) {
        if (sec < 10 && sec >= 0) {sec = "0" + sec};
        if (sec < 0) {sec = "59"};
        return sec;
        }
</script>
<?php endif; ?>
</body>
</html>