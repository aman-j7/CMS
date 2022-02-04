<?php
include "../includes/config.php";
include "../includes/random_color.php";
$faculty = 0;
$flag = 0;
$student = 0;
if (isset($_POST["submit_add_course"])) {
  $f = $_GET["f"];
  $c_id = $_POST["c_id"];
  $c_name = $_POST["c_name"];
  if ($f) {
    mysqli_query($conn, "update courses set course_name='$c_name' where course_id='$c_id'");
  } else {
    mysqli_query($conn, "insert into courses values('$c_id','$c_name')");
    $myfile = fopen("../Courses/$c_id.php", "w");
    fclose($myfile);
    copy("../Courses/template.php", "../Courses/$c_id.php");
    mysqli_query($conn, "CREATE TABLE $c_id ( `no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `header` VARCHAR(100) NOT NULL , `link` VARCHAR(100)  , `notes` VARCHAR(100)  , `ref` VARCHAR(100)  , `assigment` VARCHAR(100), `upload` VARCHAR(100))");
  }
} else if (isset($_POST["submit_update_course"])) {
  $c_id = $_POST["c_id"];
  $res = mysqli_query($conn, "Select course_id,course_name from courses where course_id='$c_id'");
  $row = mysqli_fetch_array($res);
  $flag = 1;
} else if (isset($_POST["submit_drop_course"])) {
  $c_id = $_POST["c_id"];
  mysqli_query($conn, "DELETE FROM `courses` where course_id='$c_id'");
  mysqli_query($conn, "DROP TABLE $c_id");
  unlink("$c_id.php");
} else if (isset($_POST["submit_add_faculty"])) {
  $f = $_GET["f"];
  $c_id = $_POST["c_id"];
  $f_id = $_POST["f_id"];
  if ($f) {
    $oldf_id = $_POST['of_id'];
    $oldc_id = $_POST['oc_id'];
    mysqli_query($conn, "UPDATE `teaches` SET `course_id`='$c_id',`faculty_id`='$f_id' WHERE `course_id` = '$oldc_id' AND `faculty_id`='$oldf_id'");
  } else {
    mysqli_query($conn, "INSERT INTO `teaches`(`course_id`, `faculty_id`) VALUES ('$c_id','$f_id')");
  }
} else if (isset($_POST["submit_update_faculty"])) {
  $c_id = $_POST["c_id"];
  $f_id = $_POST['f_id'];
  $res = mysqli_query($conn, "SELECT `course_id`, `faculty_id` FROM `teaches` WHERE `course_id`='$c_id' AND `faculty_id`='$f_id'");
  $row = mysqli_fetch_array($res);
  $faculty = 1;
} else if (isset($_POST["submit_drop_faculty"])) {
  $c_id = $_POST["c_id"];
  $f_id = $_POST['f_id'];
  mysqli_query($conn, "DELETE FROM `teaches` where course_id='$c_id' AND faculty_id='$f_id'");
} else if (isset($_POST["submit_add_student"])) {
  $f = $_GET["f"];
  $c_id = $_POST["c_id"];
  $s_id = $_POST["s_id"];
  if ($f) {
    $olds_id = $_POST['os_id'];
    $oldc_id = $_POST['oc_id'];
    mysqli_query($conn, "UPDATE `assign` SET `course_id`='$c_id',`student_id`='$s_id' WHERE `course_id` = '$oldc_id' AND `student_id`='$olds_id'");
  } else {
    mysqli_query($conn, "INSERT INTO `assign`(`course_id`, `student_id`) VALUES ('$c_id','$s_id')");
  }
} else if (isset($_POST["submit_update_student"])) {
  $c_id = $_POST["c_id"];
  $s_id = $_POST['s_id'];
  $res = mysqli_query($conn, "SELECT `course_id`, `student_id` FROM `assign` WHERE `course_id`='$c_id' AND `student_id`='$s_id'");
  $row = mysqli_fetch_array($res);
  $student = 1;
} else if (isset($_POST["submit_drop_student"])) {
  $c_id = $_POST["c_id"];
  $s_id = $_POST['s_id'];
  mysqli_query($conn, "DELETE FROM `assign` where course_id='$c_id' AND student_id='$s_id'");
}

?>

<html>

<head>
  <title>
    Manage Courses
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../css/header.css">
  <script type="text/javascript" src="../js/header.js"></script>

</head>

<body>

  <?php include '../includes/navbar.php'; ?>

  <?php
  if ($flag) {
    echo "<script type='text/javascript'>
    $(document).ready(function(){
      $('#modal1').modal('show');
      });
      </script>";
  } else if ($faculty) {
    echo "<script type='text/javascript'>
      $(document).ready(function(){
        $('#modal4').modal('show');
        });
        </script>";
  } else if ($student) {
    echo "<script type='text/javascript'>
        $(document).ready(function(){
          $('#modal7').modal('show');
          });
          </script>";
  }
  ?>

  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Course";
                                                                                else echo "Add Course"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php?f=<?php echo $flag ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control input1" name="c_id" placeholder="Enter Course id" value="<?php if ($flag) echo $row['course_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label>Course Name</label>
              <input type="text" class="form-control input1" placeholder="Enter Course name" name="c_name" value="<?php if ($flag) echo $row['course_name'];
                                                                                                            else echo ""; ?>" required>
            </div>
            <?php if(!$flag):?>
            <div class="form-group">
              <input type="checkbox" id="check" name="check" onclick="csvInput1(this)">
              <label>Update Using CSV File</label>
            </div>
            <div class="form-group input1">
            </div>
            <?php endif;?>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success input1" name="submit_add_course" value="<?php if ($flag) echo "Update";
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
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_course" value="Proceed" />
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
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_course" value="Delete" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>






  <div class="modal fade" id="modal4" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($faculty) echo "Update Faculty Course";
                                                                                else echo "Add Faculty Course"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php?f=<?php echo $faculty ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control input2" name="c_id" placeholder="Enter Course id" value="<?php if ($faculty) echo $row['course_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control input2" placeholder="Enter Faculty id" name="f_id" value="<?php if ($faculty) echo $row['faculty_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <?php if(!$faculty):?>
            <div class="form-group">
              <input type="checkbox" id="check" name="check" onclick="csvInput2(this)">
              <label>Update Using CSV File</label>
            </div>
            <div class="form-group input2">
            </div>
            <?php endif;?>
        </div>
        <?php
        if ($faculty) {
          echo "<input type='text' name='oc_id' value=$c_id hidden> ";
          echo "<input type='text' name='of_id' value=$f_id hidden>\n";
        }
        ?>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success input2" name="submit_add_faculty" value="<?php if ($faculty) echo "Update";
                                                                                                    else echo "Add"; ?>" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal5" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Faculty Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control" name="f_id" placeholder="Enter Faculty id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_faculty" value="Proceed" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>



  <div class="modal fade" id="modal6" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Faculty Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control" name="f_id" placeholder="Enter Faculty id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_course" value="Delete" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>




  <div class="modal fade" id="modal7" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($student) echo "Update Student Course";
                                                                                else echo "Add Student Course"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php?f=<?php echo $student ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control input3" name="c_id" placeholder="Enter Course id" value="<?php if ($student) echo $row['course_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label>Student Id</label>
              <input type="text" class="form-control input3" placeholder="Enter Student id" name="s_id" value="<?php if ($student) echo $row['student_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <?php if(!$student):?>
            <div class="form-group">
              <input type="checkbox" id="check" name="check" onclick="csvInput3(this)">
              <label>Update Using CSV File</label>
            </div>
            <div class="form-group input3">
            </div>
            <?php endif;?>
        </div>
        <?php
        if ($student) {
          echo "<input type='text' name='oc_id' value=$c_id hidden> ";
          echo "<input type='text' name='os_id' value=$s_id hidden>\n";
        }
        ?>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success input3" name="submit_add_student" value="<?php if ($student) echo "Update";
                                                                                                    else echo "Add"; ?>" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="modal8" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Student Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
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



  <div class="modal fade" id="modal9" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Student Course</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_course.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Course Id</label>
              <input type="text" class="form-control" name="c_id" placeholder="Enter Course id" required>
            </div>
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
      <div class="row ">
        <div class="text-center">
          <h1><strong>Courses</strong></h1>
        </div>
        <div class="col-lg-4 mb-4 mt-4 ">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
            <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add Courses</h5>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Courses</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mb-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Drop Courses</h5>
      </a>
    </div>
    </div>
    </div>
    </div>


    <div class="row">
      <div class="text-center">
        <h1><strong>Faculty</strong></h1>
      </div>
      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal4" style="color:black">
          <div class="card">
          <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
            <div class="card-body">
              <h5 class="card-title text-center">Add Faculty Course</h5>
        </a>
      </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal5" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Faculty Course</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal6" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Drop Faculty Course</h5>
      </a>
    </div>
    </div>
    </div>
    </div>


    <div class="row">
      <div class="text-center">
        <h1><strong>Student</strong></h1>
      </div>
      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal7" style="color:black">
          <div class="card">
          <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
            <div class="card-body">
              <h5 class="card-title text-center">Add Student Course</h5>
        </a>
      </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal8" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Student Course</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal9" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
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
  <script>
    function csvInput1(checkBox){
      let tmp=document.querySelectorAll(".input1");
      if(checkBox.checked){
        tmp[0].disabled=true;
        tmp[1].disabled=true;
        let file=document.createElement("input");
        file.size="50";
        file.type="file";
        file.name="filename";
        file.id="file";
        file.required=true;
        file.accept=".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name","csv");
        
      }
      else{
        tmp[0].disabled=false;
        tmp[1].disabled=false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name","submit_add_course");
    }
  }
  function csvInput2(checkBox){
      let tmp=document.querySelectorAll(".input2");
      if(checkBox.checked){
        tmp[0].disabled=true;
        tmp[1].disabled=true;
        let file=document.createElement("input");
        file.size="50";
        file.type="file";
        file.name="filename";
        file.id="file";
        file.required=true;
        file.accept=".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name","csv");
        
      }
      else{
        tmp[0].disabled=false;
        tmp[1].disabled=false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name","submit_add_faculty");
    }
  }
    
  function csvInput3(checkBox){
      let tmp=document.querySelectorAll(".input3");
      if(checkBox.checked){
        tmp[0].disabled=true;
        tmp[1].disabled=true;
        let file=document.createElement("input");
        file.size="50";
        file.type="file";
        file.name="filename";
        file.id="file";
        file.required=true;
        file.accept=".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name","csv");
        
      }
      else{
        tmp[0].disabled=false;
        tmp[1].disabled=false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name","submit_add_student");
    }
  }
    
    
</script>
</body>

</html>