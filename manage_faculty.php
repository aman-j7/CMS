<?php
include"config.php";
if(isset($_POST["submit_add_faculty"])){
    $f_id=$_POST["f_id"];
    $f_name=$_POST["f_name"];
    mysqli_query($conn,"insert into courses values('$f_id','$f_name')");
} 
?>
<html>
    <head>
    <title>
      Manage Faculty
    </title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <style>
    .modal-header, .close{
  background-color:orange;
  color: white !important;
  text-align: center;
  font-size: 50px;
}

.modal-footer{
  background-color: #f9f9f9;
}
    </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <img src="https://seeklogo.com/images/G/graduated-online-education-logo-2327B5F5C0-seeklogo.com.png" width="100" height="60" alt="E-learning"/>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="admin_dashboard.php">Home</a>
        </li>
</nav>


<div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Add Faculty</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_faculty.php" method="POST">
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control"  name="f_id" placeholder="Enter Course id" required>
            </div>
            <div class="form-group">
              <label> Faculty Name</label>
              <input type="text" class="form-control" placeholder="Enter Course name" name="f_name" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_add_faculty" value="Add"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div> 



<section id="gallery">
  <div class="container">


  <div class="row">
    <div class="text-center"><h1><strong>Faculty</strong></h1></div>
    <div class="col-lg-4 mt-4">
    <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
    <div class="card">
      <img src="https://www.easywork.asia/wp-content/uploads/2021/07/feature-attendance-report.svg" alt="" class="card-img-top" style="background-color:skyblue">
      <div class="card-body">
        <h5 class="card-title text-center">Add Faculty </h5>
    </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mt-4">
  <a href="" style="color:black">
  <div class="card">
      <img src="https://icon-library.com/images/result-icon/result-icon-26.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Update Faculty</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://trackrover.com/wp-content/uploads/2019/07/Automatic-Attendance-and-Employee-Efficiency-Monitoring-Solution.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Drop Faculty</h5>
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
