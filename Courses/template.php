<?php
include "../includes/config.php";
$pageName = basename($_SERVER['PHP_SELF']);
$courseDiscussion=$_GET["course"];
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
  $progress=$course.'p';
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
    $oldHead=$_POST['oldHead'];
    mysqli_query($conn, "UPDATE `$course` SET `header`='$h',`link`='$hl',`notes`='$ml',`ref`='$rl',`assigment`='$al',`upload`='$ul' WHERE `no`=$no ");
    mysqli_query($conn, "UPDATE `$progress` SET `header`='$h' WHERE `header`='$oldHead'");
  } else{
    mysqli_query($conn, "INSERT INTO `$course` ( `header`, `link`, `notes`, `ref`, `assigment`,`upload`) VALUES ('$h','$hl','$ml','$rl','$al','$ul')");
    mysqli_query($conn, "INSERT INTO `$progress` ( `header`) VALUES ('$h')");
  }
} else if (isset($_POST["update"])) {
  $no = $_POST['no'];
  $up = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course WHERE `no`=$no");
  $up = mysqli_fetch_array($up);
  $flag = 1;
} else if (isset($_POST["delete"])) {
  $no = $_POST['no'];
  $progress=$course.'p';
  $header=mysqli_query($conn, "SELECT `header` FROM $course WHERE  `no`=$no");
  $header=mysqli_fetch_array($header);
  $header=$header['header'];
  mysqli_query($conn, "DELETE FROM $course WHERE  `no`=$no");
  mysqli_query($conn, "DELETE FROM $progress WHERE `header`='$header'");
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
</head>
<body>
  <?php if ($role == "teacher") : ?>
    <div class="modal fade" id="modal1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Student</h5>
          </div>
          <div class="modal-body">
            <form role="form" action="template.php?course=<?php echo $course ?>& course_name=<?php echo $subject ?> " method="POST" autocomplete="off">
              <div class="form-group">
                <label>Header</label>
                <input type="text" class="form-control" name="head" placeholder="topic" value="<?php if ($flag) echo $up['header'];
                                                                                                else echo ""; ?>" required>
                <?php if($flag):?>
                <input type="text" class="form-control" name="oldHead" value="<?php echo $up['header'];?>" hidden>
                <?php endif;?>                                                                            
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
  <?php endif;
  if ($flag) : ?>
    <script type='text/javascript'>
      $(document).ready(function() {
        $('#modal1').modal('show');
      });
    </script>
  <?php endif;
   if($role=='student'):?>
  <div class="modal fade" id="assignments" role="dialog">
      <div class="modal-dialog modal_user">
         <div class="modal-content modal_user_content">
           <div class="modal-header">
             <h5  class="modal-title" style="margin:0 auto; text-align: left;" id="exampleModalLabel"><b>Assignments</b></h5>
          </div>
          <div class="modal-body" id="assignmentData" >
            
         </div>
       </div>
     </div>
   </div>
   <?php endif;?>
  <?php include '../includes/sidebar.php'; ?>
  <section class="home">
    <div class="container border border-3 mt-4 ">

      <h1 class="text-center pt-3 pb-2 text ">
        <?php
        echo $subject . ' (' . strtoupper($course) . ')';
        ?>
      </h1>
    </div>
    <div class="container border border-3 d-grid gap-3 pb-4 px-4 mt-4">
      <?php
      $id=$_SESSION['user_id'].'S';
      $progress_name=$course.'p';
      $row = mysqli_query($conn, "SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course");
      $c = 0;
      while ($row &&  $res = mysqli_fetch_array($row)) :
        if ($c % 3 == 0) : ?>
          <div class="row ">
          <?php endif;
        $c = $c + 1; ?>
          <div class="col-lg-4 mt-4 ">
            <div style="background-color:aqua" class="pb-1 pt-2 mb-1 border border-dark">
              <h5 class="card-title text-center"><?php echo $res['header'] ?> 
              <?php if($role=="student") : ?>
          <input style="float:right; margin-right:10px; margin-top:3px;" class="form-check-input"type="checkbox" no="<?php echo $id;?>" hd="<?php echo $res['header'];?>" 
          course="<?php echo $course;?>" onclick="progressCheck(this)"
          <?php
            $head=$res['header'];
            $prog = mysqli_query($conn, "SELECT `$id` FROM $progress_name where `header`='$head'");
            $prog=mysqli_fetch_array($prog);
            if($prog[$id]) echo "checked"?>>
        <?php endif; ?></h5>
            </div>
            <div class="card border border-dark">
              <div class="card-body" style="min-height:110px">
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
              <?php if ($c % 3 == 0) : ?>
          </div>
      <?php endif;
            endwhile; ?>
    </div>
    </div>
  </section>
  <script type="text/javascript" src="../js/sidebar.js"></script>
  <script>
      function progressCheck(check){
      let course=check.getAttribute('course'); 
      let no=check.getAttribute('no'); 
      let head=check.getAttribute('hd'); 
      let checked=0;
      if(check.checked){
        checked=1;
      }       
      jQuery.ajax({
        url:'../includes/progressCheck.php',
        type:"POST",
        data:{"course":course,"no":no,"checked":checked,"hd":head},
        success:function(){
          console.log("ok");
          console.log(course);
          console.log(no);
          console.log(head);
        }
      });
    }
    function getAssignment(courseId){
      let course=courseId.getAttribute('course');
      jQuery.ajax({
        url:'../includes/assignments.php',
        type:"POST",
        data:{"course":course},
        success:function(result){
          jQuery("#assignmentData").html(result);
        }
      });
    }
  </script>
</body>

</html>