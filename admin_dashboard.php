<?php
include "config.php";
$id=$_SESSION['user_id'];
$res=mysqli_query($conn,"select password from login where reg_id=$id");
$row=mysqli_fetch_array($res);
if( $row['password']=="68e445b4745a37fb5a133fa0fa728400"   ){
    header("Location:change_password.php");
}
?>
<html>
    <head>
    <title>
      Admin Dashboard
    </title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
    <img src="https://seeklogo.com/images/G/graduated-online-education-logo-2327B5F5C0-seeklogo.com.png" width="70" height="40" alt="E-learning"/>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="admin_dashboard.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
</div>
</nav>
   <section id="header" class="jumbotron text-center">
     <h1 class="display-3">Welcome</h1>
</section>
  
<section id="gallery">
  <div class="container">
    <div class="row ">
    <div class="col-lg-4 mb-4 mt-4 ">
    <a href="manage_faculty.php" style="color:black">
    <div class="card" >
      <img src="https://news.miami.edu/life/_assets/images/images-stories/2019/08/faculty-new-year-940x529.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Manage Faculty</h5>
       </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mb-4 mt-4">
  <a href="manage_student.php" style="color:black"> 
  <div class="card">
      <img src="https://www.designmantic.com/blog/wp-content/uploads/2020/07/Graphic-Design-Courses-718x300.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Manage Student</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4 mt-4">
    <a href="manage_course.php" style="color:black">
    <div class="card">
      <img src="https://media1.thehungryjpeg.com/thumbs2/800_121015_63396a0e1974444fdcdfc91bc487db4074c67f9b_happy-people-reading-books-in-garden.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Manage Courses</h5>
    </a>
      </div>
     </div>
    </div>
  </div>


  <div class="row">
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://www.easywork.asia/wp-content/uploads/2021/07/feature-attendance-report.svg" alt="" class="card-img-top" style="background-color:skyblue">
      <div class="card-body">
        <h5 class="card-title text-center">Monitor Attendance</h5>
    </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mt-4">
  <a href="" style="color:black">
  <div class="card">
      <img src="https://icon-library.com/images/result-icon/result-icon-26.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Monitor Result</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
    <a href="manage_department.php" style="color:black">
    <div class="card">
      <img src="https://trackrover.com/wp-content/uploads/2019/07/Automatic-Attendance-and-Employee-Efficiency-Monitoring-Solution.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Manage Department</h5>
    </a>
      </div>
     </div>
    </div>
  </div>
</div>
</section>
  </div>
</div>
   </body>
</html>