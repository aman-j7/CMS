<?php
include"config.php";
$flag=0;
if(isset($_POST["submit_add_student"])){
    $f=$_GET["f"];
    $s_id=$_POST["s_id"];
    $s_name=$_POST["s_name"];
    $d_id=$_POST["d_id"];
    if($f)
    {
        mysqli_query($conn,"update student set student_name='$s_name',dept_id='$d_id' where student_id='$s_id'");
    }
    else
    {
        mysqli_query($conn,"insert into student values('$s_id','$s_name','$d_id')");
        mysqli_query($conn,"insert into login values('$s_id','68e445b4745a37fb5a133fa0fa728400','student','abcd@gmail.com')");
    }
} 
else if(isset($_POST["submit_update_student"])){
  $s_id=$_POST["s_id"];
  $res=mysqli_query($conn,"Select student_id,student_name,dept_id from student where student_id='$s_id'");
  $row=mysqli_fetch_array($res);
  $flag=1;
}
else if(isset($_POST["submit_drop_student"])){
  $s_id=$_POST["s_id"];
  mysqli_query($conn,"DELETE FROM `student` where student_id='$s_id'");
}
?>
<html>
    <head>
    <title>
      Manage Student
    </title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
  <?php			
	if($flag) {
		echo "<script type='text/javascript'>
			$(document).ready(function(){
				$('#modal1').modal('show');
			});
		</script>";
	} 
?>
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
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if($flag) echo "Update Student"; else echo "Add Student";?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_student.php?f=<?php echo $flag?>" method="POST">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control"  name="s_id" placeholder="Enter Student id" value="<?php if($flag) echo $row['student_id']; else echo "";?>" required>
            </div>
            <div class="form-group">
              <label>Student Name</label>
              <input type="text" class="form-control" placeholder="Enter Student name" name="s_name" value="<?php if($flag) echo $row['student_name']; else echo "";?>" required>
            </div>
            <div class="form-group">
              <label>Department Id</label>
              <input type="text" class="form-control"  name="d_id" placeholder="Enter Department id" value="<?php if($flag) echo $row['dept_id']; else echo "";?>" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_add_student" value="<?php if($flag) echo "Update"; else echo "Add";?>"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div> 


  <div class="modal fade" id="modal2" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update  Student</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_student.php" method="POST">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control"  name="s_id" placeholder="Enter Student id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_student" value="Proceed"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div> 



<div class="modal fade" id="modal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Student</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_student.php" method="POST">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control"  name="s_id" placeholder="Enter Student id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_student" value="Delete"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div> 

<section id="gallery">
  <div class="container">


  <div class="row">
    <div class="text-center"><h1><strong>Student</strong></h1></div>
    <div class="col-lg-4 mt-4">
    <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
    <div class="card">
      <img src="https://www.easywork.asia/wp-content/uploads/2021/07/feature-attendance-report.svg" alt="" class="card-img-top" style="background-color:skyblue">
      <div class="card-body">
        <h5 class="card-title text-center">Add Student </h5>
    </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mt-4">
  <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
  <div class="card">
      <img src="https://icon-library.com/images/result-icon/result-icon-26.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Update Student</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
    <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
    <div class="card">
      <img src="https://trackrover.com/wp-content/uploads/2019/07/Automatic-Attendance-and-Employee-Efficiency-Monitoring-Solution.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Drop Student</h5>
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
