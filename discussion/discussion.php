<?php
include "../includes/config.php";
if ($_SESSION['user_id'] == Null || $_SESSION['type'] == Null) {
  header("Location:../login.php");
}
$pageName = basename($_SERVER['PHP_SELF']);
$course = $_GET["course"];
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
if ($role == 'admin') {
  $isAdmin = mysqli_query($conn, "SELECT `isAdmin` FROM `admin` WHERE `id`='$id' ");
  $isAdmin = mysqli_fetch_array($isAdmin);
  $isAdmin = $isAdmin['isAdmin'];
} else {
  if ($role == 'teacher') {
    $allowed = mysqli_query($conn, "SELECT `course_id` FROM `teaches` WHERE `course_id`='$course' AND `teacher_id`='$id' ");
  } else if ($role == 'student') {
    $allowed = mysqli_query($conn, "SELECT `course_id` FROM `assign` WHERE `course_id`='$course' AND `student_id`='$id' ");
  }
  if (!mysqli_num_rows($allowed)) {
    header("Location:../login.php");
  }
}
$username = mysqli_query($conn, "SELECT name FROM $role WHERE id='$id'");
$username = mysqli_fetch_array($username);
$username = $username['name'];
$courseDiscussion = $course . "d";
if (isset($_POST["save"])) {
  $pid = $_POST['id'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if ($role == 'admin' && $isAdmin) {
    $checkedRole = 'superAdmin';
  } else {
    $checkedRole = $role;
  }
  if ($name != "" && $msg != "") {
    mysqli_query($conn, "INSERT INTO $courseDiscussion (`parent_comment`,`student`,`user_id`, `role`, `post`) VALUES ('$pid', '$name','$id','$checkedRole', '$msg')");
  }
} else if (isset($_POST["btnreply"])) {
  $pid = $_POST['pid'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if ($role == 'admin' && $isAdmin) {
    $checkedRole = 'superAdmin';
  } else {
    $checkedRole = $role;
  }
  if ($name != "" && $msg != "") {
    mysqli_query($conn, "INSERT INTO $courseDiscussion (`parent_comment`,`student`,`user_id`,`role`, post) VALUES ('$pid', '$name','$id','$checkedRole', '$msg')");
  }
} else if (isset($_POST["btnEdit"])) {
  $pid = $_POST['pid'];
  $msg = $_POST['msg'];
  mysqli_query($conn, "UPDATE `$courseDiscussion` SET `post`='$msg' WHERE `id`='$pid' ");
} else if (isset($_POST["delete"])) {
  $pid = $_POST['id'];
  mysqli_query($conn, "DELETE  FROM $courseDiscussion where `parent_comment`='$pid' OR `id`='$pid' ");
}
$result =  mysqli_query($conn, "SELECT *  FROM $courseDiscussion where parent_comment='0' ORDER BY id desc");
?>
<html>

<head>
  <title>Discussion</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../CSS/discussion.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">

</head>

<body>
  <?php include '../includes/sidebar.php'; ?>
  <section class="home">
    <div id="ReplyModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" id="header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Reply</h5>
          </div>
          <div class="modal-body">
            <form name="frm1" method="post" action="discussion.php?course=<?php echo $course; ?>">
              <input type="number" id="pid" name="pid" hidden>
              <div class="form-group">
                <input type="text" class="form-control" name="name" value="<?php echo $username; ?>" hidden>
              </div>
              <div class="form-group">
                <label for="comment">Write your reply:</label>
                <textarea class="form-control" rows="5" name="msg" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="btnreply" class="btn btn-primary" value="Reply">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div id="editModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" id="header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Edit</h5>
          </div>
          <div class="modal-body">
            <form name="frm2" method="post" action="discussion.php?course=<?php echo $course; ?>">
              <div class="form-group">
                <input type="number" id="pid" name="pid" hidden>
              </div>
              <div class="form-group">
                <label for="comment">Edit your Post:</label>
                <textarea class="form-control" rows="5" name="msg" id="post" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="btnEdit" class="btn btn-primary" value="Edit">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="panel panel-default" style="margin-top:50px">
        <div class="panel-body">
          <h3>Discussion forum</h3>
          <hr>
          <form name="frm3" method="post" action="discussion.php?course=<?php echo $course; ?>">
            <input type="hidden" id="id" name="id" value="0">
            <div class="form-group">
              <input type="text" class="form-control" name="name" value="<?php echo $username; ?>" hidden>
            </div>
            <div class="form-group">
              <label for="comment">Write your question:</label>
              <textarea class="form-control" rows="5" name="msg" required></textarea>
            </div>
            <input type="submit" name="save" class="btn btn-primary mt-2" value="Send">
          </form>
        </div>
      </div>
      <div class="panel panel-default">
        <h3>Recent Questions</h3>
        <div class="panel-body" style="height: 500px; overflow:auto">
          <table class="table" id="MyTable" style="background-color: #edfafa; border-left:1px solid black; border-right:1px solid black">
            <tbody id="record">
              <?php
              while ($res = mysqli_fetch_array($result)) :
                $pid = $res['id'];
              ?>
                <tr style="border-top:1px solid black; border-bottom:1px solid black">
                <tr>
                  <?php
                  $colour = "blue";
                  if ($res['role'] == 'teacher' || $res['role'] == 'superAdmin')
                    $colour = "red";
                  ?>
                  <td><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: <?php echo $colour; ?>"> <?php echo $res['student']; ?></span> :<i> <?php echo $res['date']; ?>:</i></b></br>
                    <p style="padding-left:80px"><span id="<?php echo $res['id'] ?>"><?php echo $res['post']; ?></span></br>
                      <button type="button" class="btn btn-link" data-toggle="modal" data-target="#ReplyModal" data-id=<?php echo $res['id']; ?> id="submit" onclick="reply(this)">
                        Reply
                      </button>
                      <?php if ($res['user_id'] == $id) : ?>
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#editModal" data-id=<?php echo $res['id']; ?> id="submit" onclick="edit(this)">
                          Edit
                        </button>
                    <form name="frm4" method="post" action="discussion.php?course=<?php echo $course; ?>">
                      <input type="hidden" id="id" name="id" value="<?php echo $res['id']; ?>">
                      <button type="submit" class="btn btn-link" name="delete" value="delete">
                        Delete
                      </button>
                    </form>
                  <?php endif; ?>
                  </p>
                  </td>
                </tr>
                <?php
                $result1 =  mysqli_query($conn, "SELECT *  FROM $courseDiscussion where parent_comment=$pid ORDER BY id desc");
                while ($res1 = mysqli_fetch_array($result1)) :
                ?>
                  <tr>
                    <?php
                    $colour = "blue";
                    if ($res1['role'] == 'teacher' || $res1['role'] == 'superAdmin')
                      $colour = "red";
                    ?>
                    <td style="padding-left:80px "><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: <?php echo $colour; ?>"> <?php echo $res1['student']; ?> </span> :<i> <?php echo $res1['date']; ?>:</i></b></br>
                      <p style="padding-left:40px"><span id="<?php echo $res1['id'] ?>"><?php echo $res1['post']; ?></span><br>
                        <?php if ($res1['user_id'] == $id) : ?>
                          <button type="button" class="btn btn-link" data-toggle="modal" data-target="#editModal" data-id=<?php echo $res1['id']; ?> id="submit" onclick="edit(this)">
                            Edit
                          </button>
                      <form name="frm5" method="post" action="discussion.php?course=<?php echo $course; ?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $res1['id']; ?>">
                        <button type="submit" class="btn btn-link" name="delete" value="delete">
                          Delete
                        </button>
                      </form>
                    <?php endif; ?>
                    </p>
                    </td>
                  </tr>
                <?php endwhile; ?>
                </tr>
              <?php endwhile; ?>
              <hr>
              </hr>
              <script type="text/javascript">
                function reply(a) {
                  var str = $(a).attr("data-id");
                  $("#ReplyModal .modal-body #pid").val(str);
                  $('#ReplyModal').modal('show');
                }

                function edit(a) {
                  var str = $(a).attr("data-id");
                  var content = document.getElementById(str).innerHTML;
                  $("#editModal .modal-body #pid").val(str);
                  $("#editModal .modal-body #post").val(content);
                  $('#editModal').modal('show');
                }
              </script>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <?php include '../includes/checkDarkTheme.php'; ?>
</body>

</html>