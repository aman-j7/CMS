<?php
include "../includes/config.php";

$pageName = basename($_SERVER['PHP_SELF']);

$course = $_GET["course"];
$courseDiscussion = $course;
$id = $_SESSION['user_id'];
$role = $_SESSION['type'];
$username = mysqli_query($conn, "SELECT name FROM $role WHERE id='$id'");
$username = mysqli_fetch_array($username);
$username = $username['name'];

$courseDiscussion = $courseDiscussion . "d";
if (isset($_POST["save"])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if ($name != "" && $msg != "") {
    mysqli_query($conn, "INSERT INTO $courseDiscussion (parent_comment, student, `role`, post) VALUES ('$id', '$name', '$role', '$msg')");
  }
} else if (isset($_POST["btnreply"])) {
  $id = $_POST['pid'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if ($name != "" && $msg != "") {
    mysqli_query($conn, "INSERT INTO $courseDiscussion (parent_comment, student, `role`, post) VALUES ('$id', '$name', '$role', '$msg')");
  }
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
        <form name="frm1" method="post" action="index.php?course=<?php echo $course; ?>">
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
<div class="container">

  <div class="panel panel-default" style="margin-top:50px">
    <div class="panel-body">
      <h3>Discussion forum</h3>
      <hr>
      <form name="frm" method="post" action="index.php?course=<?php echo $course; ?>">
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
                if($res['role'] == 'teacher')
                  $colour = "red"; 
              ?>
              <td ><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: <?php echo $colour; ?>"> <?php echo $res['student']; ?></span> :<i> <?php echo $res['date']; ?>:</i></b></br>
                <p style="padding-left:80px"><?php echo $res['post']; ?></br>
                  <button type="button" class="btn btn-link" data-toggle="modal" data-target="#ReplyModal" data-id=<?php echo $res['id']; ?> id="submit" onclick="func(this)">
                    Reply
                  </button>
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
                if($res1['role'] == 'teacher')
                  $colour = "red"; 
              ?>
                <td style="padding-left:80px "><b><img src="../images/avatar.jpg" width="30px" height="30px" /><span style="color: <?php echo $colour; ?>"> <?php echo $res1['student']; ?> </span> :<i> <?php echo $res1['date']; ?>:</i></b></br>
                  <p style="padding-left:40px"><?php echo $res1['post']; ?></p>
                </td>
              </tr>
            <?php endwhile; ?>
            </tr>
          <?php endwhile; ?>
          <hr>
          </hr>
          <script type="text/javascript">
            function func(a) {
              var str = $(a).attr("data-id");
              $(".modal-body #pid").val(str);
              $('#ReplyModal').modal('show');
            }
          </script>


        </tbody>
      </table>
    </div>
  </div>

</div>
</section>
<script type="text/javascript" src="../js/sidebar.js"></script>
</body>

</html>