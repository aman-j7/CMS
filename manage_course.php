<?php
include"config.php";
$flag=0;
if(isset($_POST["submit_add_course"])){
   $f=$_GET["f"];
    $c_id=$_POST["c_id"];
    $c_name=$_POST["c_name"];
    if($f)
    {
        mysqli_query($conn,"update courses set course_name='$c_name' where course_id='$c_id'");
    }
    else
    {
      mysqli_query($conn,"insert into courses values('$c_id','$c_name')");
    }
} 
else if(isset($_POST["submit_update_course"])){
  $c_id=$_POST["c_id"];
  $res=mysqli_query($conn,"Select course_id,course_name from courses where course_id='$c_id'");
  $row=mysqli_fetch_array($res);
  $flag=1;
}
else if(isset($_POST["submit_drop_course"])){
  $c_id=$_POST["c_id"];
  mysqli_query($conn,"DELETE FROM `courses` where course_id='$c_id'");
}
?>

<html>
    <head>
    <title>
      Manage Courses
    </title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
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
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
    <img src="https://seeklogo.com/images/G/graduated-online-education-logo-2327B5F5C0-seeklogo.com.png" width="70" height="40" alt="E-learning" id="logo_nav"/>
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
  <div id="nav_user">
  <a href="#">
<svg xmlns="http://www.w3.org/2000/svg" width="70" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></a>
   </div>
</div>
</nav>

<div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if($flag) echo "Update Faculty"; else echo "Add Faculty";?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php?f=<?php echo $flag?>" method="POST">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control"  name="c_id" placeholder="Enter Course id" value="<?php if($flag) echo $row['course_id']; else echo "";?>" required>
            </div>
            <div class="form-group">
              <label>Course Name</label>
              <input type="text" class="form-control" placeholder="Enter Course name" name="c_name" value="<?php if($flag) echo $row['course_name']; else echo "";?>" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_add_course" value="<?php if($flag) echo "Update"; else echo "Add";?>"/>
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
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update  Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control"  name="c_id" placeholder="Enter Course id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_course" value="Proceed"/>
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
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control"  name="c_id" placeholder="Enter Course id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_course" value="Delete"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div> 




<section id="gallery">
  <div class="container">
    <div class="row ">
    <div class="text-center"><h1><strong>Courses</strong></h1></div>
    <div class="col-lg-4 mb-4 mt-4 ">
    <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
    <div class="card" >
      <img src="https://news.miami.edu/life/_assets/images/images-stories/2019/08/faculty-new-year-940x529.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Add Courses</h5>
       </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mb-4 mt-4">
  <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
  <div class="card">
      <img src="https://www.designmantic.com/blog/wp-content/uploads/2020/07/Graphic-Design-Courses-718x300.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Update Courses</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4 mt-4">
    <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
    <div class="card">
      <img src="https://media1.thehungryjpeg.com/thumbs2/800_121015_63396a0e1974444fdcdfc91bc487db4074c67f9b_happy-people-reading-books-in-garden.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Drop Courses</h5>
    </a>
      </div>
     </div>
    </div>
  </div>


  <div class="row">
    <div class="text-center"><h1><strong>Faculty</strong></h1></div>
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://www.easywork.asia/wp-content/uploads/2021/07/feature-attendance-report.svg" alt="" class="card-img-top" style="background-color:skyblue">
      <div class="card-body">
        <h5 class="card-title text-center">Add Faculty Course</h5>
    </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mt-4">
  <a href="" style="color:black">
  <div class="card">
      <img src="https://icon-library.com/images/result-icon/result-icon-26.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Update Faculty Course</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://trackrover.com/wp-content/uploads/2019/07/Automatic-Attendance-and-Employee-Efficiency-Monitoring-Solution.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Drop Faculty Course</h5>
    </a>
      </div>
     </div>
    </div>
  </div>


  <div class="row">
    <div class="text-center"><h1><strong>Student</strong></h1></div>
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://www.easywork.asia/wp-content/uploads/2021/07/feature-attendance-report.svg" alt="" class="card-img-top" style="background-color:skyblue">
      <div class="card-body">
        <h5 class="card-title text-center">Add Student Course</h5>
    </a>
      </div>
     </div>
    </div>
  <div class="col-lg-4 mt-4">
  <a href="" style="color:black">
  <div class="card">
      <img src="https://icon-library.com/images/result-icon/result-icon-26.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Update Student Course</h5>
  </a>
      </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
    <a href="" style="color:black">
    <div class="card">
      <img src="https://trackrover.com/wp-content/uploads/2019/07/Automatic-Attendance-and-Employee-Efficiency-Monitoring-Solution.jpg" alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title text-center">Drop Student Course</h5>
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
