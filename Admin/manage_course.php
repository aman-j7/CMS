<?php
include "../includes/config.php";
include "../includes/random_color.php";
$teacher = 0;
$flag = 0;
$student = 0;
$exception_occur = 0;
$exception_cause = new Exception();
try {
  if (isset($_POST["submit_add_course"])) {
    $f = $_GET["f"];
    $c_id = $_POST["c_id"];
    $c_name = $_POST["c_name"];
    if ($f) {
      mysqli_query($conn, "update courses set course_name='$c_name' where course_id='$c_id'");
    } else {
      $disc = $c_id . "d";
      mysqli_query($conn, "insert into courses values('$c_id','$c_name')");
      mysqli_query($conn, "CREATE TABLE $c_id ( `no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `header` VARCHAR(100) NOT NULL , `link` VARCHAR(100)  , `notes` VARCHAR(100)  , `ref` VARCHAR(100)  , `assigment` VARCHAR(100), `upload` VARCHAR(100))");
      mysqli_query($conn, "CREATE TABLE $disc (
        `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
        `parent_comment` varchar(500) NOT NULL,
        `student` varchar(1000) NOT NULL,
        `post` varchar(1000) NOT NULL,
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
      )");
    }
  } else if (isset($_POST["submit_update_course"])) {
    $c_id = $_POST["c_id"];
    $res = mysqli_query($conn, "Select course_id,course_name from courses where course_id='$c_id'");
    $row = mysqli_fetch_array($res);
    $flag = 1;
  } else if (isset($_POST["submit_drop_course"])) {
    $c_id = $_POST["c_id"];
    $disc = $c_id . "d";
    mysqli_query($conn, "DELETE FROM `courses` where course_id='$c_id'");
    mysqli_query($conn, "DROP TABLE $c_id");
    mysqli_query($conn, "DROP TABLE $disc");
  } else if (isset($_POST["submit_add_teacher"])) {
    $f = $_GET["f"];
    $c_id = $_POST["c_id"];
    $f_id = $_POST["f_id"];
    if ($f) {
      $oldf_id = $_POST['of_id'];
      $oldc_id = $_POST['oc_id'];
      mysqli_query($conn, "UPDATE `teaches` SET `course_id`='$c_id',`teacher_id`='$f_id' WHERE `course_id` = '$oldc_id' AND `teacher_id`='$oldf_id'");
    } else {
      mysqli_query($conn, "INSERT INTO `teaches`(`course_id`, `teacher_id`) VALUES ('$c_id','$f_id')");
    }
  } else if (isset($_POST["submit_update_teacher"])) {
    $c_id = $_POST["c_id"];
    $f_id = $_POST['f_id'];
    $res = mysqli_query($conn, "SELECT `course_id`, `teacher_id` FROM `teaches` WHERE `course_id`='$c_id' AND `teacher_id`='$f_id'");
    $row = mysqli_fetch_array($res);
    $teacher = 1;
  } else if (isset($_POST["submit_drop_teacher"])) {
    $c_id = $_POST["c_id"];
    $f_id = $_POST['f_id'];
    mysqli_query($conn, "DELETE FROM `teaches` where course_id='$c_id' AND teacher_id='$f_id'");
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
  } else if (isset($_POST["csv_add_course"])) {
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      mysqli_query($conn, "insert into depratment values('$data[0]','$data[1]')");
    }
    fclose($handle);
  } else if (isset($_POST["csv_add_teacher"])) {
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      mysqli_query($conn, "insert into depratment values('$data[0]','$data[1]')");
    }
    fclose($handle);
  } else if (isset($_POST["csv_add_student"])) {
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      mysqli_query($conn, "insert into depratment values('$data[0]','$data[1]')");
    }
    fclose($handle);
  }
} catch (Exception $except) {
  $exception_occur = 1;
  $exception_cause = $except;
}

?>

<html>

<head>
  <title>
    Manage Courses
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">


</head>

<body>
  <?php if ($exception_occur) : ?>
    <script>
      alert("<?php echo $exception_cause->getMessage() ?>");
    </script>
  <?php endif;
  if ($flag) { ?>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#modal1').modal('show');
      });
    </script>
  <?php } else if ($teacher) { ?>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#modal4').modal('show');
      });
    </script>
  <?php } else if ($student) { ?>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#modal7').modal('show');
      });
    </script>
  <?php  }
  include '../includes/admin_sidebar.php'; ?>
  <section class="home">
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
              <?php if (!$flag) : ?>
                <div class="form-group">
                  <input type="checkbox" id="check" name="check" onclick="csvInput1(this)">
                  <label>Update Using CSV File</label>
                </div>
                <div class="form-group input1">
                </div>
              <?php endif; ?>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success input1" name="submit_add_course" value="<?php if ($flag) echo "Update";
                                                                                                            else echo "Add"; ?>" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>






    <div class="modal fade" id="modal4" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($teacher) echo "Update teacher Course";
                                                                                  else echo "Add teacher Course"; ?></h5>
          </div>
          <div class="modal-body">
            <form role="form" action="manage_course.php?f=<?php echo $teacher ?>" method="POST" autocomplete="off">
              <div class="form-group">
                <label>Course Id</label>
                <input type="text" class="form-control input2" name="c_id" placeholder="Enter Course id" value="<?php if ($teacher) echo $row['course_id'];
                                                                                                                else echo ""; ?>" required>
              </div>
              <div class="form-group">
                <label>teacher Id</label>
                <input type="text" class="form-control input2" placeholder="Enter teacher id" name="f_id" value="<?php if ($teacher) echo $row['teacher_id'];
                                                                                                                  else echo ""; ?>" required>
              </div>
              <?php if (!$teacher) : ?>
                <div class="form-group">
                  <input type="checkbox" id="check" name="check" onclick="csvInput2(this)">
                  <label>Update Using CSV File</label>
                </div>
                <div class="form-group input2">
                </div>
              <?php endif; ?>
          </div>
          <?php
          if ($teacher) {
            echo "<input type='text' name='oc_id' value=$c_id hidden> ";
            echo "<input type='text' name='of_id' value=$f_id hidden>\n";
          }
          ?>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success input2" name="submit_add_teacher" value="<?php if ($teacher) echo "Update";
                                                                                                              else echo "Add"; ?>" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>


    <div class="modal fade" id="modal5" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update teacher Course</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="manage_course.php" method="POST" autocomplete="off">
              <div class="form-group">
                <label>Course Id</label>
                <input type="text" class="form-control" name="c_id" id="t_id" placeholder="Enter Course id" required>
              </div>
              <div class="form-group">
                <label>teacher Id</label>
                <input type="text" class="form-control" name="f_id" id="t_id1" placeholder="Enter teacher id" required>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success" name="submit_update_teacher" value="Proceed" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>



    <div class="modal fade" id="modal6" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop teacher Course</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="manage_course.php" method="POST" autocomplete="off">
              <div class="form-group">
                <label>Course Id</label>
                <input type="text" class="form-control" name="c_id" id="t_id" placeholder="Enter Course id" required>
              </div>
              <div class="form-group">
                <label>teacher Id</label>
                <input type="text" class="form-control" name="f_id" id="t_id1" placeholder="Enter teacher id" required>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success" name="submit_drop_course" value="Delete" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
              <?php if (!$student) : ?>
                <div class="form-group">
                  <input type="checkbox" id="check" name="check" onclick="csvInput3(this)">
                  <label>Update Using CSV File</label>
                </div>
                <div class="form-group input3">
                </div>
              <?php endif; ?>
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
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <input type="text" class="form-control" name="c_id" id="t_id" placeholder="Enter Course id" required>
              </div>
              <div class="form-group">
                <label>Student Id</label>
                <input type="text" class="form-control" name="s_id" id="t_id1" placeholder="Enter Student id" required>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success" name="submit_update_student" value="Proceed" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                <input type="text" class="form-control" name="c_id" id="t_id" placeholder="Enter Course id" required>
              </div>
              <div class="form-group">
                <label>Student Id</label>
                <input type="text" class="form-control" name="s_id" id="t_id1" placeholder="Enter Student id" required>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success" name="submit_drop_student" value="Delete" />
            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <section id="gallery">
      <div class="container mt-4 ">
        <h1 class="text-center pt-2 pb-2 text">
          Courses
        </h1>
      </div>
      <div class="container">
        <div class="row ">
          <div class="col-lg-4 mb-4 mt-4 ">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
              <div class="card">
                <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                <div class="card-body">
                  <h5 class="card-title text-center">Add Courses</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Update Courses</h5>
        </a>
      </div>
      </div>
      </div>
      <div class="col-lg-4 mb-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Drop Courses</h5>
        </a>
      </div>
      </div>
      </div>
      </div> <div class="form-outline mb-4 mt-5 form-check form-switch">
        <label>
          <h6>View Data</h6>
        </label>
        <input class="form-check-input" type="checkbox" id="view_data" onclick="view_toggle()">
      </div>

      <?php $data = mysqli_query($conn, "Select * from courses"); ?>
      <div class="row mt-4" id="table" style="height: 400px; overflow:auto" hidden>
        <table class="text-center table table-light" style="height: 10px;">
          <thead style="position: sticky; top:0;">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th></th>
            </tr>
          </thead>
          <?php
          while ($row = mysqli_fetch_array($data)) :
          ?>
            <tr>
              <td><?php echo $row['course_id'] ?></td>
              <td><?php echo $row['course_name'] ?></td>
              <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['course_id']; ?>" onclick="update_data(this)"></i></button>
                <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['course_id']; ?>" onclick="delete_data(this)"></i></button>
              </td>


            </tr>
          <?php
          endwhile;
          ?>
        </table>
      </div>


      <div class="container mt-4 ">
        <h1 class="text-center pt-2 pb-2 text">
          Teacher
        </h1>
      </div>
      <div class="row">
        <div class="col-lg-4 mt-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal4" style="color:black">
            <div class="card">
              <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add teacher Course</h5>
          </a>
        </div>
      </div>
      </div>
      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal5" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Update teacher Course</h5>
        </a>
      </div>
      </div>
      </div>
      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal6" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Drop teacher Course</h5>
        </a>
      </div>
      </div>
        </div>
        </div> <div class="form-outline mb-4 mt-5 form-check form-switch">
        <label>
          <h6>View Data</h6>
        </label>
        <input class="form-check-input" type="checkbox" id="view_data1" onclick="view_toggle1()">
      </div>

      <?php $data = mysqli_query($conn, "Select *from teaches"); ?>
      <div class="row mt-4" id="table1" style="height: 400px; overflow:auto" hidden>
        <table class="text-center table table-light" style="height: 10px;">
          <thead style="position: sticky; top:0;">
            <tr>
              <th>Course ID</th>
              <th>Teacher ID</th>
              <th></th>
            </tr>
          </thead>
          <?php
          while ($row = mysqli_fetch_array($data)) :
          ?>
            <tr>
              <td><?php echo $row['course_id'] ?></td>
              <td><?php echo $row['teacher_id'] ?></td>
              <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['course_id']; ?>"  data-id1="<?php echo $row['teacher_id']; ?>" onclick="update_data1(this)"></i></button>
                <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['course_id']; ?>"  data-id1="<?php echo $row['teacher_id']; ?>" onclick="delete_data1(this)"></i></button>
              </td>


            </tr>
          <?php
          endwhile;
          ?>
        </table>
      </div>

      <div class="container mt-4 ">
        <h1 class="text-center pt-2 pb-2 text">
          Student
        </h1>
      </div>
      <div class="row">
        <div class="col-lg-4 mt-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal7" style="color:black">
            <div class="card">
              <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add Student Course</h5>
          </a>
        </div>
      </div>
      </div>
      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal8" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Update Student Course</h5>
        </a>
      </div>
      </div>
      </div>

      <div class="col-lg-4 mt-4">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modal9" style="color:black">
          <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
            <div class="card-body">
              <h5 class="card-title text-center">Drop Student Course</h5>
        </a>
      </div>
      </div>
      </div>
      </div>
      <div class="form-outline mb-4 mt-5 form-check form-switch">
        <label>
          <h6>View Data</h6>
        </label>
        <input class="form-check-input" type="checkbox" id="view_data2" onclick="view_toggle2()">
      </div>

      <?php $data = mysqli_query($conn, "Select * from assign"); ?>
      <div class="row mt-4" id="table2" style="height: 400px; overflow:auto" hidden>
        <table class="text-center table table-light" style="height: 10px;">
          <thead style="position: sticky; top:0;">
            <tr>
              <th>Course ID</th>
              <th>Student ID</th>
              <th></th>
            </tr>
          </thead>
          <?php
          while ($row = mysqli_fetch_array($data)) :
          ?>
            <tr>
              <td><?php echo $row['course_id'] ?></td>
              <td><?php echo $row['student_id'] ?></td>
      
              <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['course_id']; ?>"  data-id1="<?php echo $row['student_id']; ?>"  onclick="update_data2(this)"></i></button>
                <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['course_id']; ?>"  data-id1="<?php echo $row['student_id']; ?>"  onclick="delete_data2(this)"></i></button>
              </td>


            </tr>
          <?php
          endwhile;
          ?>
        </table>
      </div>
    </section>
    </div>
    </div>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <script>
    function csvInput1(checkBox) {
      let tmp = document.querySelectorAll(".input1");
      if (checkBox.checked) {
        tmp[0].disabled = true;
        tmp[1].disabled = true;
        let file = document.createElement("input");
        file.size = "50";
        file.type = "file";
        file.name = "filename";
        file.id = "file";
        file.required = true;
        file.accept = ".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name", "csv_add_course");

      } else {
        tmp[0].disabled = false;
        tmp[1].disabled = false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name", "submit_add_course");
      }
    }

    function csvInput2(checkBox) {
      let tmp = document.querySelectorAll(".input2");
      if (checkBox.checked) {
        tmp[0].disabled = true;
        tmp[1].disabled = true;
        let file = document.createElement("input");
        file.size = "50";
        file.type = "file";
        file.name = "filename";
        file.id = "file";
        file.required = true;
        file.accept = ".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name", "csv_add_teacher");

      } else {
        tmp[0].disabled = false;
        tmp[1].disabled = false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name", "submit_add_teacher");
      }
    }

    function csvInput3(checkBox) {
      let tmp = document.querySelectorAll(".input3");
      if (checkBox.checked) {
        tmp[0].disabled = true;
        tmp[1].disabled = true;
        let file = document.createElement("input");
        file.size = "50";
        file.type = "file";
        file.name = "filename";
        file.id = "file";
        file.required = true;
        file.accept = ".csv";
        tmp[2].appendChild(file);
        tmp[3].setAttribute("name", "csv_add_student");

      } else {
        tmp[0].disabled = false;
        tmp[1].disabled = false;
        let file = document.getElementById("file");
        tmp[2].removeChild(file);
        tmp[3].setAttribute("name", "submit_add_student");
      }
    }
    function view_toggle(a) {
      var a = document.getElementById("view_data");
      var x = document.getElementById("table");
      if (a.checked == true)
        x.hidden = false;
      else
        x.hidden = true;

    }

    function update_data(a) {
      var str = $(a).attr("data-id");
      $(".modal-body #t_id").val(str);
      $('#modal2').modal('show');
    }

    function delete_data(a) {
      var str = $(a).attr("data-id");
      $(".modal-body #t_id").val(str);
      $('#modal3').modal('show');
    }
    function view_toggle1(a) {
      var a = document.getElementById("view_data1");
      var x = document.getElementById("table1");
      if (a.checked == true)
        x.hidden = false;
      else
        x.hidden = true;

    }

    function update_data1(a) {
      var str = $(a).attr("data-id");
      var str1 = $(a).attr("data-id1");
      $(".modal-body #t_id").val(str);
      $(".modal-body #t_id1").val(str1);
      $('#modal5').modal('show');
    }

    function delete_data1(a) {
      var str = $(a).attr("data-id");
      var str1 = $(a).attr("data-id1");
      $(".modal-body #t_id").val(str);
      $(".modal-body #t_id1").val(str1);
      $('#modal6').modal('show');
    }
    function view_toggle2(a) {
      var a = document.getElementById("view_data2");
      var x = document.getElementById("table2");
      if (a.checked == true)
        x.hidden = false;
      else
        x.hidden = true;

    }

    function update_data2(a) {
      var str = $(a).attr("data-id");
      var str1 = $(a).attr("data-id1");
      $(".modal-body #t_id1").val(str1);
      $(".modal-body #t_id").val(str);
      $('#modal8').modal('show');
    }

    function delete_data2(a) {
      var str = $(a).attr("data-id");
      var str1 = $(a).attr("data-id1");
      $(".modal-body #t_id").val(str);
      $(".modal-body #t_id1").val(str1);
      $('#modal9').modal('show');
    }
  </script>
</body>

</html>