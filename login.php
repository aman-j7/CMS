<?php
$f = 0;
include "includes/config.php";
$flag = 0;
if (isset($_POST["submit"])) {
  $e = $_POST["id"];
  $p = $_POST["password"];
  $res = mysqli_query($conn, "select role from login where reg_id=$e and password='$p'");
  $row = mysqli_fetch_array($res);
  if ($row) {
    $_SESSION['user_id'] = $e;
    $_SESSION['type'] = $row['role'];
    if ($p == "CMS@123") {
      $flag = 1;
    } elseif ($row['role'] == "teacher")
      header("Location:Teacher/teacher_dashboard.php");
    elseif ($row['role'] == "admin")
      header("Location:Admin/admin_dashboard.php");
    elseif ($row['role'] == "student")
      header("Location:Student/student_dashboard.php");
  } else {

    $f = 1;
  }
}
?>


<html>

<head>
  <link rel="stylesheet" href="CSS/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="js/login.js"></script>
  <title>E-Learning</title>
</head>

<body>
  <?php
  if ($flag)
    echo "<script>
    Swal.fire({
      icon: 'warning',
      title: 'Login Successfull!',
      text: 'Update your default password',
      timer: 10000
    }).then(function() {
    window.location = 'Password/change_password.php';
});
  </script>"; ?>
  <section class="h-100 gradient-form">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                  <div class="text-center">
                    <img src="images/logo.png" id="logo" style="width: 180px;" alt="logo">
                  </div>
                  <p id="error"></p>
                  <form method="POST" action="login.php" autocomplete="off">
                    <p><strong>Please login to your account</strong></p>

                    <div class="form-outline mb-4">
                      <input type="integer" name="id" required class="form-control" placeholder="Registration Number" />
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" name="password" required class="form-control pass_toggle" placeholder="Password" />
                      <p id="error_pass"></p>
                    </div>
                    <div class="form-outline mb-4 form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault " onclick="pass_toggle()">
                      <h6>Show password</h6>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                      <input class="btn btn-primary btn-sm gradient-custom-2 mb-3" type="submit" name="submit" value="Log In" />
                      <br>
                      <a class="text-muted" href="Password/forget.php">Forgot password?</a>
                    </div>

                  </form>

                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center">
                <div class="mySlides fade">
                  <img src="images/quote1.jpg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/quote2.png" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/quote3.jpg" alt="logo" style="width: 100%;">
                </div>
                <div class="mySlides fade">
                  <img src="images/quote4.jpg" alt="logo" style="width: 100%;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    var slideIndex = 0;
    showSlides();
  </script>
  
  <?php
  if ($f == 1) {
    echo '<script>myfunc();</script>';
  }
  ?>
</body>

</html>