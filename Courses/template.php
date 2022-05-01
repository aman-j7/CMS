<?php
include "../includes/config.php";
if ($_SESSION['user_id'] == Null || $_SESSION['type'] == Null ||  $_SESSION['type'] == 'admin') {
  header("Location:../login.php");
}
$user_id =$_SESSION['user_id'];
include "../video/api.php";
$pageName = basename($_SERVER['PHP_SELF']);
$courseDiscussion = $_GET["course"];
$course = strtoupper($_GET["course"]);
$t = mysqli_query($conn, "SELECT `course_name` FROM `courses` where course_id='$course'");
$t = mysqli_fetch_array($t);
$subject = strtoupper($t["course_name"]);
$flag = 0;
$role = $_SESSION['type'];
if (isset($_POST["submit"])) {
  $f = $_POST['f'];
  $h = strtoupper($_POST["head"]);
  $ml = $_POST["material_link"];
  $hl = $_POST["lecture_link"];
  $rl = $_POST['refrence'];
  $al = $_POST["assigment"];
  $ul = $_POST["upload"];
  $attendanceTime = $_POST['attendanceTime'];
  $progress = $course . 'p';
  if ($hl == "")
    $hl = NULL;
  if ($ml == "")
    $ml = NULL;
  if ($rl == "")
    $rl = NULL;
  if ($al == "" || $ul == "") {
    $al = NULL;
    $ul = NULL;
  }
  if ($f) {
    $no = $_POST['no'];
    $oldHead = $_POST['oldHead'];
    mysqli_query($conn, "UPDATE `$course` SET `header`='$h',`link`='$hl',`notes`='$ml',`ref`='$rl',`assigment`='$al',`upload`='$ul',`attendanceTime`='$attendanceTime' WHERE `no`=$no ");
    mysqli_query($conn, "UPDATE `$progress` SET `header`='$h' WHERE `header`='$oldHead'");
  } else {
    mysqli_query($conn, "INSERT INTO `$course` ( `header`, `link`, `notes`, `ref`, `assigment`,`upload`,`attendanceTime`) VALUES ('$h','$hl','$ml','$rl','$al','$ul','$attendanceTime')");
    mysqli_query($conn, "INSERT INTO `$progress` ( `header`) VALUES ('$h')");
  }
} else if (isset($_POST["update"])) {
  $no = $_POST['no'];
  $up = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload`,`attendanceTime` FROM $course WHERE `no`=$no");
  $up = mysqli_fetch_array($up);
  $flag = 1;
} else if (isset($_POST["delete"])) {
  $no = $_POST['no'];
  $progress = $course . 'p';
  $header = mysqli_query($conn, "SELECT `header` FROM $course WHERE  `no`=$no");
  $header = mysqli_fetch_array($header);
  $header = $header['header'];
  mysqli_query($conn, "DELETE FROM $course WHERE  `no`=$no");
  mysqli_query($conn, "DELETE FROM $progress WHERE `header`='$header'");
} else if (isset($_POST["meeting"])) {
  $arr['topic'] = $_POST["topic"];
  $arr['start_date'] = $_POST["date"];
  $arr['duration'] = $_POST["duration"];
  $arr['password'] = $_POST["password"];
  $arr['type'] = '2';
  $attendanceTime = $_POST['attendanceTime'];
  $result = createMeeting($arr);
  if (isset($result->id)) {
    $t = $_POST["topic"];
    $progress = $course . 'p';
    $date = $arr['start_date'];
    mysqli_query($conn, "INSERT INTO `$course` ( `header`, `link`, `notes`, `assigment`,`upload`,`isMeeting`,`attendanceTime`) VALUES ('$t','$result->join_url','$result->password','$date','$result->duration','1','$attendanceTime')");
    mysqli_query($conn, "INSERT INTO `$progress` ( `header`) VALUES ('$t')");
  }
} else if (isset($_POST["meeting_api"])) {
  $api_key = $_POST['api_key'];
  $api_secret = $_POST['api_secret'];
  $email = $_POST['email'];
  mysqli_query($conn, "update teacher set api_key='$api_key',api_secret='$api_secret', email='$email' where id='$user_id'");
  mysqli_query($conn, "UPDATE `login` SET `email`='$email' WHERE `reg_id`='$user_id'");
}
?>
<html>

<head>
  <title>
    <?php echo $course; ?>
  </title>
  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../CSS/discussion.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <link rel="stylesheet" href="../CSS/footer.css">
</head>

<body>
  <?php if ($role == "teacher") : ?>
    <div class="modal fade" id="modal1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Material";else echo "Add Material"; ?></h5>
                                                                                                
          </div>
          <div class="modal-body">
            <form role="form" action="template.php?course=<?php echo $course ?>& course_name=<?php echo $subject ?> " method="POST" autocomplete="off">
              <div class="form-group">
                <label>Header</label>
                <input type="text" class="form-control" name="head" placeholder="topic" value="<?php if ($flag) echo $up['header'];
                                                                                                else echo ""; ?>" required>
                <?php if ($flag) : ?>
                  <input type="text" class="form-control" name="oldHead" value="<?php echo $up['header']; ?>" hidden>
                <?php endif; ?>
              </div>
              <div class="form-group">
                <label>Lecture Link</label>
                <input type="text" class="form-control" name="lecture_link" placeholder=" Lecture Link" value="<?php if ($flag) echo $up['link'];
                                                                                                                else echo ""; ?>">
              </div>
              <div class="form-group">
                <label>Material Link</label>
                <input type="text" class="form-control" name="material_link" placeholder="Material Link" value="<?php if ($flag) echo $up['notes'];
                                                                                                                else echo ""; ?>">
              </div>
              <div class="form-group">
                <label>Refrences </label>
                <input type="text" class="form-control" name="refrence" placeholder="Reference Link" value="<?php if ($flag) echo $up['ref'];
                                                                                                            else echo ""; ?>">
              </div>
              <div class="form-group">
                <label>Assigment Link</label>
                <input type="text" class="form-control" name="assigment" placeholder=" Assigment Link" value="<?php if ($flag) echo $up['assigment'];
                                                                                                              else echo ""; ?>">
                <label>Upload Link</label>
                <input type="text" class="form-control" name="upload" placeholder="Upload Link" value="<?php if ($flag) echo $up['upload'];
                                                                                                        else echo ""; ?>">
              </div>
              <div class="form-group">
                <label>Attendance Time</label>
                <input type="datetime-local" class="form-control" name="attendanceTime" required>
                <input type="integer" name="f" value="<?php echo $flag ?>" hidden>
                <?php if ($flag) : ?>
                  <input type="integer" name="no" value="<?php echo $up['no'] ?>" hidden><br>
                <?php endif; ?>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-default btn-success" name="submit" value="<?php if ($flag) echo 'Update';
                                                                                              else echo "Submit"; ?>" />
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal2" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Add Meeting</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="template.php?course=<?php echo $course ?>& course_name=<?php echo $subject ?> " method="POST" autocomplete="off">
              <div class="form-group">
                <label>Topic</label>
                <input type="text" class="form-control" name="topic" placeholder="topic" required>
              </div>
              <div class="form-group">
                <label>Start Date & Time</label>
                <input type="datetime-local" class="form-control" name="date" required>
              </div>
              <div class="form-group">
                <label>Duration</label>
                <input type="integer" class="form-control" name="duration" placeholder="In Minutes" required>
              </div>
              <div class="form-group">
                <label>Password </label>
                <input type="text" class="form-control" name="password" placeholder="Enter Password" required>
              </div>
              <div class="form-group">
                <label>Attendance Time</label>
                <input type="datetime-local" class="form-control" name="attendanceTime" required>
              </div>
              <div class="form-group">
                <input type="checkbox" id="api_check" name="api_check" onclick="update_api()">
                <label>Update your api</label>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-default btn-success" name="meeting" value="Submit" />
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modal3" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Zoom API Keys</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="template.php?course=<?php echo $course ?>& course_name=<?php echo $subject ?> " method="POST" autocomplete="off">
              <?php
              $secret_key = mysqli_query($conn, "SELECT `email`,`api_key`, `api_secret` FROM `teacher` WHERE `id`='$user_id'");
              $secret_key = mysqli_fetch_array($secret_key);
              ?>
              <div class="form-group">
                <label>Api Key</label>
                <input type="text" class="form-control api" name="api_key" placeholder="Enter api key" value="<?php if ($secret_key['api_key'])  echo $secret_key['api_key'] ?>" required>
              </div>
              <div class="form-group">
                <label>Api Secret key</label>
                <input type="text" class="form-control api" name="api_secret" placeholder="Enter api secret" value="<?php if ($secret_key['api_secret']) echo $secret_key['api_secret'] ?>" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control api" name="email" placeholder="Enter email" value="<?php if ($secret_key['email']) echo $secret_key['email'] ?>" required>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-default btn-success" name="meeting_api" value="Submit" />
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif;
  if ($flag) : ?>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#modal1').modal('show');
      });
    </script>
  <?php endif;
  if ($role == 'student') : ?>
    <div class="modal fade" id="assignments" role="dialog">
      <div class="modal-dialog modal_user">
        <div class="modal-content modal_user_content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto; text-align: left;" id="exampleModalLabel"><b>Assignments</b></h5>
          </div>
          <div class="modal-body" id="assignmentData">
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php include '../includes/sidebar.php'; ?>
  <section class="home">
    <div class="container border border-3 mt-4 ">
      <h1 class="text-center pt-3 pb-2 text ">
        <?php
        echo $subject . ' (' . strtoupper($course) . ')';
        ?>
      </h1>
    </div>
    <div class="container border border-3 d-grid gap-3 pb-4 px-4 mt-4" style="min-height: calc(100vh - 253px);">
      <?php
      $id = $_SESSION['user_id'] . 'S';
      $progress_name = $course . 'p';
      $row = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload`,`isMeeting`,`attendanceTime` FROM $course");
      $c = 0;
      while ($row && $res = mysqli_fetch_array($row)) :
        if ($c % 3 == 0) : ?>
          <div class="row ">
          <?php endif;
        $c = $c + 1;
        if ($res['isMeeting']) : ?>
            <div class="col-lg-4 mt-4 ">
              <div style="background-color:lightgreen;" class="pb-1 pt-2 mb-1 border border-dark">
                <h5 class="card-title text-center">
                  <?php echo $res['header'];
                  if ($role == "student") : ?>
                    <input style="float:right; margin-right:10px; margin-top:3px;" class="form-check-input" type="checkbox" no="<?php echo $id; ?>" hd="<?php echo $res['header']; ?>" course="<?php echo $course; ?>" onclick="progressCheck(this)" <?php
                                                                                                                                                                                                                                                      $head = $res['header'];
                                                                                                                                                                                                                                                      $prog = mysqli_query($conn, "SELECT `$id` FROM $progress_name where `header`='$head'");
                                                                                                                                                                                                                                                      $prog = mysqli_fetch_array($prog);
                                                                                                                                                                                                                                                      if ($prog[$id] != date("0000-00-00 00:00:00")) echo "checked" ?>>
                  <?php endif; ?>
                </h5>
              </div>
              <div class="card border border-dark">
                <div class="card-body" style="min-height:150px">
                  <a href="<?php echo $res['link'] ?>" class="link-secondary">Meeting Link</a><br>
                  <b>Password:</b><br> <?php echo $res['notes'] ?><br>
                  <b>Start Time:</b><br><?php echo substr($res['assigment'], 0, 10) . ' ' . substr($res['assigment'], 11, strlen($res['assigment'])); ?><br>
                </div>
                <?php if ($role == "teacher") : ?>
                  <div class="mb-2">
                    <form role="form" action="template.php?course=<?php echo $course ?>&course_name=<?php echo $subject ?>" method="POST">
                      <tr>
                        <td><input type="integer" name="no" value=<?php echo $res['no'] ?> hidden></td>
                        <td><input type="submit" class="btn btn-danger  btn-sm mx-1 me-2" name="delete" value="Delete" style="float:right" /></td>
                      </tr>
                    </form>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php else : ?>
            <div class="col-lg-4 mt-4 ">
              <div style="background-color:aqua" class="pb-1 pt-2 mb-1 border border-dark">
                <h5 class="card-title text-center"><?php echo $res['header'] ?>
                  <?php if ($role == "student") : ?>
                    <input style="float:right; margin-right:10px; margin-top:3px;" class="form-check-input" type="checkbox" no="<?php echo $id; ?>" hd="<?php echo $res['header']; ?>" course="<?php echo $course; ?>" onclick="progressCheck(this)" <?php
                                                                                                                                                                                                                                                      $head = $res['header'];
                                                                                                                                                                                                                                                      $prog = mysqli_query($conn, "SELECT `$id` FROM `$progress_name` where `header`='$head'");
                                                                                                                                                                                                                                                      $prog = mysqli_fetch_array($prog);
                                                                                                                                                                                                                                                      if ($prog[$id] != date("0000-00-00 00:00:00")) echo "checked" ?>>
                  <?php endif; ?>
                </h5>
              </div>
              <div class="card border border-dark">
                <div class="card-body" style="min-height:150px">
                  <?php if ($res['link'] != NULL) : ?>
                    <a href="<?php echo $res['link'] ?>" class="link-secondary">Lecture Video Link</a><br>
                  <?php endif; ?>
                  <?php if ($res['notes'] != NULL) : ?>
                    <a href="<?php echo $res['notes'] ?>" class="link-secondary">Material link</a><br>
                  <?php endif; ?>
                  <?php if ($res['ref'] != NULL) : ?>
                    <a href="<?php echo $res['ref'] ?>" class="link-secondary">Refrences</a><br>
                  <?php endif; ?>
                  <?php if ($res['assigment'] != NULL) : ?>
                    <a href=" <?php echo $res['assigment'] ?>" class="link-secondary">Assigment Link</a><br>
                    <a href="<?php echo $res['upload'] ?>" class="link-secondary">Upload Link</a><br>
                  <?php endif; ?>
                  <?php if ($role == "teacher") : ?>
                    <b>Attendance Time:</b><br><?php echo $res['attendanceTime']; ?><br>
                  <?php endif; ?>
                </div>
                <?php if ($role == "teacher") : ?>
                  <div class="mb-2">
                    <form role="form" action="template.php?course=<?php echo $course ?>&course_name=<?php echo $subject ?>" method="POST">
                      <tr>
                        <td><input type="integer" name="no" value=<?php echo $res['no'] ?> hidden></td>
                        <td><input type="submit" class="btn btn-danger  btn-sm mx-1 me-2" name="delete" value="Delete" style="float:right" /></td>
                        <td><input type="submit" class="btn btn-info  btn-sm mx-1 me-2" name="update" value="Update" style="float:right" /></td>
                      </tr>
                    </form>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endif;
        if ($c % 3 == 0) : ?>
          </div>
      <?php endif;
      endwhile; ?>
    </div>
    </div>
    <?php include '../includes/footer.php'; ?>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <script>
    function progressCheck(check) {
      let course = check.getAttribute('course');
      let no = check.getAttribute('no');
      let head = check.getAttribute('hd');
      let checked = 0;
      if (check.checked) {
        checked = 1;
      }
      jQuery.ajax({
        url: '../includes/progressCheck.php',
        type: "POST",
        data: {
          "course": course,
          "no": no,
          "checked": checked,
          "hd": head
        },
        success: function() {}
      });
    }

    function getAssignment(courseId) {
      let course = courseId.getAttribute('course');
      jQuery.ajax({
        url: '../includes/assignments.php',
        type: "POST",
        data: {
          "course": course
        },
        success: function(result) {
          jQuery("#assignmentData").html(result);
        }
      });
    }

    function update_api() {
      $(document).ready(function() {
        $('#modal2').modal('hide');
      });
      $(document).ready(function() {
        $('#modal3').modal('show');
      });
    }
  </script>
  <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>