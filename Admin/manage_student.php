<?php
include "../includes/config.php";
include "../includes/random_color.php";
$flag = 0;
if (isset($_POST["submit_add_student"])) {
  $f = $_GET["f"];
  $s_id = $_POST["s_id"];
  $s_name = $_POST["s_name"];
  $d_id = $_POST["d_id"];
  if ($f) {
    mysqli_query($conn, "update student set student_name='$s_name',dept_id='$d_id' where student_id='$s_id'");
  } else {
    mysqli_query($conn, "insert into student values('$s_id','$s_name','$d_id')");
    mysqli_query($conn, "insert into login values('$s_id','CMS@123','student','abcd@gmail.com')");
  }
} else if (isset($_POST["submit_update_student"])) {
  $s_id = $_POST["s_id"];
  $res = mysqli_query($conn, "Select student_id,student_name,dept_id from student where student_id='$s_id'");
  $row = mysqli_fetch_array($res);
  $flag = 1;
} else if (isset($_POST["submit_drop_student"])) {
  $s_id = $_POST["s_id"];
  mysqli_query($conn, "DELETE FROM `student` where student_id='$s_id'");
}
?>
<html>

<head>
  <title>
    Manage Student
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../css/header.css">
  <script type="text/javascript" src="../js/header.js"></script>

</head>

<body>

  <?php include '../includes/navbar.php'; 
  if ($flag):?> 
    <script type='text/javascript'>
			$(document).ready(function(){
				$('#modal1').modal('show');
			});
		</script>
  <?php endif;?>


  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Student";
                                                                                else echo "Add Student"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_student.php?f=<?php echo $flag ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control input1" name="s_id" placeholder="Enter Student id" value="<?php if ($flag) echo $row['student_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label>Student Name</label>
              <input type="text" class="form-control input1" placeholder="Enter Student name" name="s_name" value="<?php if ($flag) echo $row['student_name'];
                                                                                                            else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label>Department Id</label>
              <input type="text" class="form-control input1" name="d_id" placeholder="Enter Department id" value="<?php if ($flag) echo $row['dept_id'];
                                                                                                            else echo ""; ?>" required>
            </div>
            <?php if(!$flag):?>
            <div class="form-group">
              <input type="checkbox" id="check" name="check" onclick="csvInput(this)">
              <label>Update Using CSV File</label>
            </div>
            <div class="form-group input1">
            </div>
            <?php endif;?>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success input1" name="submit_add_student" value="<?php if ($flag) echo "Update";
                                                                                                    else echo "Add"; ?>" />
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
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Student</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_student.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control" name="s_id" placeholder="Enter Student id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_student" value="Proceed" />
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
          <form role="form" action="manage_student.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control" name="s_id" placeholder="Enter Student id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_student" value="Delete" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <section id="gallery">
    <div class="container">


      <div class="row">
        <div class="text-center">
          <h1><strong>Student</strong></h1>
        </div>
        <div class="col-lg-4 mt-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
            <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add Student </h5>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Student</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
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
  <script>
    function csvInput(checkBox){
      let tmp=document.querySelectorAll(".input1");
      if(checkBox.checked){
        tmp[0].disabled=true;
        tmp[1].disabled=true;
        tmp[2].disabled=true;
        let file=document.createElement("input");
        file.size="50";
        file.type="file";
        file.name="filename";
        file.id="file";
        file.required=true;
        file.accept=".csv";
        tmp[3].appendChild(file);
        tmp[4].setAttribute("name","csv");
        
      }
      else{
        tmp[0].disabled=false;
        tmp[1].disabled=false;
        tmp[2].disabled=false;
        let file = document.getElementById("file");
        tmp[3].removeChild(file);
        tmp[4].setAttribute("name","submit_add_student");
    }
  }
    
</script>
</body>

</html>