<?php
include "../includes/config.php";
$id = $_SESSION['user_id'];
?>
<html>

<head>
  <title>
    Admin Dashboard
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../css/header.css">
  <script type="text/javascript" src="../js/header.js"></script>

</head>

<body>

  <?php include '../includes/navbar.php'; ?>
  
  <section id="header" class="jumbotron text-center">
    <h1 class="display-3">Welcome</h1>
  </section>

  <section id="gallery">
    <div class="container">
      <div class="row ">
        <div class="col-lg-4 mb-4 mt-4 ">
          <a href="manage_faculty.php" style="color:black">
            <div class="card">
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