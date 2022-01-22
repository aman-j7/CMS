<?php
include"config.php";
$course=$_GET["course"];
$flag=0;
if(isset($_POST["submit"])){
    $f=$_POST['f'];
    $h=$_POST["head"];
    $ml=$_POST["material_link"];
    $hl=$_POST["lecture_link"];
    $rl=$_POST['refrence'];
    $al=$_POST["assigment"];
    if($hl=="")
      $hl=NULL;
    if($ml=="")
      $ml=NULL;
    if($rl=="")
      $rl=NULL;
    if($al=="")
      $al=NULL;
     if($f){
       $no=$_POST['no'];
       mysqli_query($conn,"UPDATE `$course` SET `header`='$h',`link`='$hl',`notes`='$ml',`ref`='$rl',`assigment`='$al' WHERE `no`=$no");
     }
     else
      mysqli_query($conn,"INSERT INTO `$course` ( `header`, `link`, `notes`, `ref`, `assigment`) VALUES ('$h','$hl','$ml','$rl','$al')");
} 
else if(isset($_POST["update"])){
  $no=$_POST['no'];
  $up=mysqli_query($conn,"SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment` FROM $course WHERE `no`=$no");
  $up=mysqli_fetch_array($up);
  $flag=1;
} 
else if(isset($_POST["delete"])){
  $no=$_POST['no'];
  mysqli_query($conn,"DELETE FROM $course WHERE  `no`=$no");
} 
?>
<html>
    <head>
    <title>
      Manage Department
    </title>
    <link rel="stylesheet" href="CSS/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<style>
    .navbar-nav > li{
  padding-left:13px;
 
}
 #logo_nav{
     margin-left:13px;
     margin-right:13px;
 }
 #nav_user{
     margin-right:10px;
     float:right;
 }
</style>
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
  <a href="#" onclick="myfunction()">
<svg xmlns="http://www.w3.org/2000/svg" width="70" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" >
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
</svg></a>
</div>
</div>
</nav>
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
<div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update  Student</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="<?php echo $course.'.php?course='.$course;?>" method="POST">
            <div class="form-group">
              <label>Header</label>
              <input type="text" class="form-control"  name="head" placeholder="header" value="<?php if($flag) echo $up['header']; else echo "";?>" required>
            </div>
            <div class="form-group">
              <label>Lecuture Link</label>
              <input type="text" class="form-control"  name="lecture_link" placeholder="Link" value="<?php if($flag) echo $up['link']; else echo "";?>" >
            </div>
            <div class="form-group">
              <label>Material Link</label>
              <input type="text" class="form-control"  name="material_link" placeholder="Link" value="<?php if($flag) echo $up['notes']; else echo "";?>" >
            </div>
            <div class="form-group">
              <label>Refrences </label>
              <input type="text" class="form-control"  name="refrence" placeholder="Link" value="<?php if($flag) echo $up['ref']; else echo "";?>">
            </div>
            <div class="form-group">
              <label>Assigment </label>
              <input type="text" class="form-control"  name="assigment" placeholder="Link" value="<?php if($flag) echo $up['assigment']; else echo "";?>">
            </div>
            <input type="integer" name="f" value=<?php echo $flag;?> hidden>
            <?php 
            if($flag){
              echo '<input type="integer" name="no" value='.$up['no'].' hidden><br>';
            }
            ?>
        </div>
        <div class="modal-footer">
        <input type="submit" class="btn btn-default btn-success" name="submit" value="<?php if($flag) echo 'Update'; else echo "Submit";?>"/>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
</form>
      </div>
    </div>
  </div>
<button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#modal1">Open Modal</button>
<div class="container">
 <?php 
    $row=mysqli_query($conn,"SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment` FROM $course");
    while($res=mysqli_fetch_array($row)){
        echo '<div class="col-lg-4 mt-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-center">'.$res['header'].'</h5>';
            if($res['link']!=NULL)
              echo'<a href="'.$res['link'].'">lecture video link</a><br>';
            if($res['notes']!=NULL)
              echo'<a href="'.$res['notes'].'">Material link</a><br>';
            if($res['ref']!=NULL)
              echo'<a href="'.$res['ref'].'">refrences</a><br>';
            if($res['assigment']!=NULL)
              echo'<a href="'.$res['assigment'].'">assigment</a><br>';
         echo'</div>
         <form role="form" action="'.$course.'.php?course='.$course.'" method="POST">
         <tr>
         <td><input type="integer" name="no" value='.$res['no'].' hidden></td>
         <td><input type="submit" class="btn btn-default btn-success" name="update" value="Update"/></td>
         <td><input type="submit" class="btn btn-default btn-success" name="delete" value="Delete"/></td>
         </tr>
         </form>
         </div>
        </div>';
    }
?>


</div>
</body>
</html>