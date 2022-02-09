<?php
include "../includes/config.php";
$course = $_GET["course"];
$t = mysqli_query($conn, "SELECT `course_name` FROM `courses` where course_id='$course'");
$t = mysqli_fetch_array($t);
$subject =  $t["course_name"];
$flag = 0;
$role = $_SESSION['type'];
if (isset($_POST["submit"])) {
  $f = $_POST['f'];
  $h = $_POST["head"];
  $ml = $_POST["material_link"];
  $hl = $_POST["lecture_link"];
  $rl = $_POST['refrence'];
  $al = $_POST["assigment"];
  $ul = $_POST["upload"];
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
    mysqli_query($conn, "UPDATE `$course` SET `header`='$h',`link`='$hl',`notes`='$ml',`ref`='$rl',`assigment`='$al',`upload`='$ul' WHERE `no`=$no");
  } else
    mysqli_query($conn, "INSERT INTO `$course` ( `header`, `link`, `notes`, `ref`, `assigment`,`upload`) VALUES ('$h','$hl','$ml','$rl','$al','$ul')");
} else if (isset($_POST["update"])) {
  $no = $_POST['no'];
  $up = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course WHERE `no`=$no");
  $up = mysqli_fetch_array($up);
  $flag = 1;
} else if (isset($_POST["delete"])) {
  $no = $_POST['no'];
  mysqli_query($conn, "DELETE FROM $course WHERE  `no`=$no");
}
?>
<html>

<head>
  <title>
    <?php echo $course; ?>
  </title>
   <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/header.css">
  <script type="text/javascript" src="../js/header.js"></script>
</head>
<body>
<?php if ($role == "teacher"): ?>
    <div class="modal fade" id="modal1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update  Student</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="<?php echo $course ?>.php?course=<?php echo $course ?>&course_name=<?php echo $subject?> " method="POST" autocomplete="off">
              <div class="form-group">
                <label>Header</label>
                <input type="text" class="form-control"  name="head" placeholder="topic" value="<?php if ($flag) echo $up['header'];else echo "";?>" required>
              </div>
              <div class="form-group">
                <label>Lecture Link</label>
                <input type="text" class="form-control"  name="lecture_link" placeholder=" Lecture Link" value="<?php if ($flag) echo $up['link'];else echo "";?>" >
              </div>
              <div class="form-group">
                <label>Material Link</label>
                <input type="text" class="form-control"  name="material_link" placeholder="Material Link" value="<?php if ($flag) echo $up['notes'];else echo "";?>" >
              </div>
              <div class="form-group">
                <label>Refrences </label>
                <input type="text" class="form-control"  name="refrence" placeholder="Reference Link" value="<?php if ($flag) echo $up['ref'];else echo "";?>">
              </div>
              <div class="form-group">
                <label>Assigment Link</label>
                <input type="text" class="form-control"  name="assigment" placeholder=" Assigment Link" value="<?php if ($flag) echo $up['assigment'];else echo "";?>">
                <label>Upload Link</label>
                <input type="text" class="form-control"  name="upload" placeholder="Upload Link" value="<?php if ($flag) echo $up['upload'];else echo "";?>">
              </div>
              <input type="integer" name="f" value="<?php echo $flag ?>" hidden >
              <?php if ($flag): ?>
                <input type="integer" name="no" value="<?php echo $up['no'] ?>" hidden><br>
              <?php endif; ?>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-default btn-success" name="submit" value="<?php if ($flag) echo 'Update';else echo 'Submit';?>"/>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php endif;
     if($flag): ?>
      <script type='text/javascript'>
        $(document).ready(function(){
          $('#modal1').modal('show');
        });
      </script>
      <?php endif;?>

   
  <div class="container-fluid">
    <div class="row flex-nowrap">
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
          <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none ">
            <span class="fs-5 d-none d-sm-inline ">Menu</span>
          </a>
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
              <a href="#" class="nav-link align-middle px-0 text-white">
                 <span class="ms-1 d-none d-sm-inline">Home</span>
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-0 align-middle text-white">
               <span class="ms-1 d-none d-sm-inline">option2</span> </a>
            </li>
          </ul>
          <hr>
        </div>
      </div>
      <div class="col py-3 ">
        <div class="container border border-3 mt-4 ">
          <?php
          if ($flag) {
            echo "<script type='text/javascript'>
    $(document).ready(function(){
      $('#modal1').modal('show');
      });
      </script>";
          }
          ?>
          <h1 class="text-center pt-2 pb-2">
            <?php
            echo $subject . ' (' . $course . ')';
            ?>
          </h1>
        </div>
        <div class="container border border-3 d-grid gap-3 pb-4 px-4 mt-4">
        <div class="row text-center pt-4"><h2>Material</h2></div>
        <?php
        if ($role == "teacher") : ?>
          <button type="button" class="btn btn-info btn-dark" data-bs-toggle="modal" data-bs-target="#modal1"><h5>Add Material</h5></button>
        <?php endif;
        $row = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course");
        $c = 0;
        while ($res = mysqli_fetch_array($row)) :
          if ($c % 3 == 0): ?>
            <div class="row ">
            <?php endif;
            $c = $c + 1; ?>
            <div class="col-lg-4 mt-4">
              <div class="card border border-success">
                <div class="card-body">
                  <h5 class="card-title text-center"><?php echo $res['header'] ?> </h5>
                  <?php if ($res['link'] != NULL): ?>
                    <a href="<?php echo $res['link'] ?>" class="link-secondary">lecture video link</a><br>
                  <?php endif;?>
                  <?php if ($res['notes'] != NULL): ?>
                    <a href="<?php echo $res['notes'] ?>" class="link-secondary">Material link</a><br>
                  <?php endif;?>
                  <?php if($res['ref'] != NULL): ?>
                    <a href="<?php echo $res['ref'] ?>" class="link-secondary">refrences</a><br>
                  <?php endif;?>
                  <?php if($res['assigment'] != NULL): ?>
                    <a href=" <?php echo $res['assigment'] ?>" class="link-secondary">assigment link</a><br>
                    <a href="<?php echo $res['upload'] ?>" class="link-secondary">upload link</a><br>
                  <?php endif;?>
                </div>
                <?php if ($role == "teacher"): ?>
                  <form role="form" action="<?php echo $course ?>.php?course=<?php echo $course ?>&course_name=<?php echo $subject ?>" method="POST">
                    <tr>
                      <td><input type="integer" name="no" value=<?php echo $res['no']?> hidden></td>
                      <td><input type="submit" class="btn btn-default btn-outline-danger btn-sm mx-1 me-2" name="delete" value="Delete" style="float:right"/></td>
                      <td><input type="submit" class="btn btn-default btn btn-outline-dark btn-sm mx-1 me-2" name="update" value="Update" style="float:right"/></td>
                    </tr>
                  </form>
                </div>
              </div>
            <?php endif; 
            if ($c % 3 == 0): ?>
            </div>
          <?php endif; endwhile; ?>
        </div>
      </div>
      <div>
</body>

</html>