<!-- <head>

</head>

<body>
	<div id="divCounter"></div>
	<script type="text/javascript">
		if (sessionStorage.getItem("counter")) {
			if (sessionStorage.getItem("counter") >= 10) {
				var value = 0;
			} else {
				var value = sessionStorage.getItem("counter");
			}
		} else {
			var value = 0;
		}
		document.getElementById('divCounter').innerHTML = value;

		var counter = function() {
			if (value >= 10) {
				sessionStorage.setItem("counter", 0);
				value = 0;
			} else {
				value = parseInt(value) + 1;
				sessionStorage.setItem("counter", value);
			}
			document.getElementById('divCounter').innerHTML = value;
		};

		var interval = setInterval(counter, 1000);
	</script>
</body> -->


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include "../includes/config.php";
$flag = 1;
$otp = 0;
$reg = 0;
$check = 0;
$invalid_reg = 0;
$invalid_otp = 0;
if (isset($_POST["submit2"])) {
	$o1 = $_POST["otp1"];
	$otp = $_POST["otp2"];
	$reg = $_POST["reg"];
	$flag = 0;
	if ($o1 == $otp) {
		header("Location:change_password.php");
	} else {
		$invalid_otp = 1;
	}
}

if (isset($_POST["submit1"])) {
	$reg = $_POST["reg"];
	$res = mysqli_query($conn, "select email from login where reg_id=$reg");
	$row = mysqli_fetch_array($res);
	if ($row) {
		$email = $row['email'];
		$otp = rand(100000, 999999);
		$msg = "Your otp is" . strval($otp);
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Port = 587;
		$mail->Username = 'projectcms05@gmail.com';
		$mail->Password = 'teaching@123';
		$mail->setFrom('projectcms05@gmail.com');
		$mail->addAddress($email);
		$mail->Subject = 'Otp for new password';
		$mail->Body = $msg;
		$flag = 0;
		if (!$mail->send()) {
			$check = 1;
			$flag = 1;
		}
	} else {
		$invalid_reg = 1;
	}
}
?>
<html>

<head>
	<link rel="stylesheet" href="../CSS/login.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script type="text/javascript" src="../js/login.js"></script>
	<title>ForgetPasword</title>
</head>

<body>

	<?php if ($flag) : ?>
		<section class="h-100 gradient-form">
			<div class="container h-100">
				<div class="row d-flex justify-content-center align-items-center h-100">
					<div class="col-xl-10">
						<div class="card rounded-3 text-black">
							<div class="row g-0">
								<div class="col-lg-6">
									<div class="card-body p-md-5 mx-md-4">
										<div class="text-center">
											<img src="../images/logo.png" id="logo" style="width: 180px;" alt="logo">
										</div>
										<p id="error"></p>
										<form method="POST" action="temp.php" autocomplete="off">
											<?php if ($check) echo '<div class="alert alert-danger" role="alert">OTP has not been sent!</div>';
											if ($invalid_reg) echo '<div class="alert alert-danger" role="alert">Invalid Registration No!</div>'; ?>
											<p><strong>Enter your Registration Number</strong></p>
											<div class="form-outline mb-4">
												<input type="integer" name="reg" class="form-control" placeholder="Registration Number" required />
											</div>


											<div class="text-center pt-1 mb-5 pb-1">
												<input class="btn btn-primary btn-sm gradient-custom-2 mb-3" id="submit" type="submit" name="submit1" value="Submit" onclick="setTimer()" />

											</div>

										</form>

									</div>
								</div>
								<div class="col-lg-6 d-flex align-items-center">
									<div class="mySlides fade">
										<img src="../images/quote1.jpg" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote2.png" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote3.jpg" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote4.jpg" alt="logo" style="width: 100%;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php elseif (!$flag) : ?>
		<section class="h-100 gradient-form">
			<div class="container h-100">
				<div class="row d-flex justify-content-center align-items-center h-100">
					<div class="col-xl-10">
						<div class="card rounded-3 text-black">
							<div class="row g-0">
								<div class="col-lg-6">
									<div class="card-body p-md-5 mx-md-4">
										<div class="text-center">
											<img src="../images/logo.png" id="logo" style="width: 180px;" alt="logo">
										</div>
										<form method="POST" action="temp.php" autocomplete="off">
											<?php if ($invalid_otp) echo '<div class="alert alert-danger" role="alert"> Invalid OTP!</div>';
											else echo '<div class="alert alert-success" role="alert">OTP has been successfully sent!</div>'; ?>
											<p><strong>Enter your OTP</strong></p>
											<div class="form-outline mb-4">
												<input type="integer" name="otp1" class="form-control pass_toggle" placeholder="OTP here" required />
												<input type="integer" name="otp2" value=<?php echo $otp; ?> hidden>
												<input type="integer" name="reg" value=<?php echo $reg; ?> hidden>
											</div>

											<div class="form-outline mb-4 form-check form-switch">
												<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault " onclick="pass_toggle()">
												<h6>Show OTP</h6>
											</div>

											<div class="form-outline mb-4">
												<h6>Time left : <span id="timer"></span></h6>
											</div>

											<div class="text-center pt-1 mb-5 pb-1">
												<input class="btn btn-primary btn-sm gradient-custom-2 mb-3" id="submit" type="submit" name="submit2" value="Submit" />

											</div>

										</form>

									</div>
								</div>
								<div class="col-lg-6 d-flex align-items-center">
									<div class="mySlides fade">
										<img src="../images/quote1.jpg" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote2.png" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote3.jpg" alt="logo" style="width: 100%;">
									</div>
									<div class="mySlides fade">
										<img src="../images/quote4.jpg" alt="logo" style="width: 100%;">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>



		<script>
			function setTimer() {
				sessionStorage.setItem("ini_time", 59); 
			}

			document.getElementById('timer').innerHTML =
				00 + ":" + sessionStorage.getItem("ini_time");
			Timer();


			function Timer() {
				var presentTime = document.getElementById('timer').innerHTML;
				var timeArray = presentTime.split(/[:]+/);
				var m = timeArray[0];
				var s = second((timeArray[1] - 1));
				if (s == 59) {
					m = m - 1
				}
				if (m < 0) {
					alert("Otp has been exipired");
					window.location.href = "forget.php";
				}

				document.getElementById('timer').innerHTML =
					m + ":" + s;
				console.log(m)
				setTimeout(Timer, 1000);


			}

			function second(sec) {
				if (sec < 10 && sec >= 0) {
					sec = "0" + sec
				};
				if (sec < 0) {
					sec = "59"
				};
				return sec;
			}
		</script>
	<?php endif; ?>

	<script>
		var slideIndex = 0;
		showSlides();
	</script>

</body>

</html>