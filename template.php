<?php
include"config.php";
$course=$_GET["course"];
$subject=$_GET["course_name"];
$flag=0;
$role=$_SESSION['type'];
if(isset($_POST["submit"])){
    $f=$_POST['f'];
    $h=$_POST["head"];
    $ml=$_POST["material_link"];
    $hl=$_POST["lecture_link"];
    $rl=$_POST['refrence'];
    $al=$_POST["assigment"];
    $ul=$_POST["upload"];
    if($hl=="")
      $hl=NULL;
    if($ml=="")
      $ml=NULL;
    if($rl=="")
      $rl=NULL;
    if($al==""||$ul=="")
    {
      $al=NULL;
      $ul=NULL;
    }
     if($f){
       $no=$_POST['no'];
       mysqli_query($conn,"UPDATE `$course` SET `header`='$h',`link`='$hl',`notes`='$ml',`ref`='$rl',`assigment`='$al',`upload`='$ul' WHERE `no`=$no");
     }
     else
      mysqli_query($conn,"INSERT INTO `$course` ( `header`, `link`, `notes`, `ref`, `assigment,``upload`) VALUES ('$h','$hl','$ml','$rl','$al','$ul')");
} 
else if(isset($_POST["update"])){
  $no=$_POST['no'];
  $up=mysqli_query($conn,"SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course WHERE `no`=$no");
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
      <?php echo $course;?>
    </title>
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
    if($role=="teacher"){

         echo '<div class="modal fade" id="modal1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update  Student</h5>
            </div>
            <div class="modal-body">
              <form role="form" action="'.$course.'.php?course='.$course.'& course_name='.$subject; echo '" method="POST">
                <div class="form-group">
                  <label>Header</label>
                  <input type="text" class="form-control"  name="head" placeholder="topic" value="'; if($flag) echo $up['header']; else echo "";echo'" required>
                </div>
                <div class="form-group">
                  <label>Lecture Link</label>
                  <input type="text" class="form-control"  name="lecture_link" placeholder=" Lecture Link" value="'; if($flag) echo $up['link']; else echo "";echo '" >
                </div>
                <div class="form-group">
                  <label>Material Link</label>
                  <input type="text" class="form-control"  name="material_link" placeholder="Material Link" value="'; if($flag) echo $up['notes']; else echo "";echo '" >
                </div>
                <div class="form-group">
                  <label>Refrences </label>
                  <input type="text" class="form-control"  name="refrence" placeholder="Reference Link" value="'; if($flag) echo $up['ref']; else echo "";echo '">
                </div>
                <div class="form-group">
                  <label>Assigment Link</label>
                  <input type="text" class="form-control"  name="assigment" placeholder=" Assigment Link" value="'; if($flag) echo $up['assigment']; else echo "";echo '">
                  <label>Upload Link</label>
                  <input type="text" class="form-control"  name="upload" placeholder="Upload Link" value="'; if($flag) echo $up['upload']; else echo ""; echo'">
                </div>
                <input type="integer" name="f" value='.$flag.' hidden>';
                if($flag){
                  echo '<input type="integer" name="no" value='.$up['no'].' hidden><br>';
                }
                echo '
            </div>
            <div class="modal-footer">
            <input type="submit" class="btn btn-default btn-success" name="submit" value="'; if($flag) echo 'Update'; else echo "Submit";echo '"/>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
    </form>
          </div>
        </div>
      </div>';
    }
?>
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
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                        <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1 </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2 </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                    <li>
                        <a href="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                            <i class="fs-4 bi-bootstrap"></i> <span class="ms-1 d-none d-sm-inline">Bootstrap</span></a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Item</span> 2</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#submenu3" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Products</span> </a>
                            <ul class="collapse nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                            <li class="w-100">
                                <a href="#" class="link-secondary"> <span class="d-none d-sm-inline">Product</span> 1</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 2</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 3</a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-0"> <span class="d-none d-sm-inline">Product</span> 4</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3 ">
        <div class="container border border-3 mt-4 ">
        <?php			
  if($flag) {
    echo "<script type='text/javascript'>
    $(document).ready(function(){
      $('#modal1').modal('show');
      });
      </script>";
    } 
?>
  <h1 class="text-center pt-2 pb-2">
  <?php
    echo $subject.' ('.$course.')';
  ?>
  </h1>
</div>
<?php
if($role=="teacher")
{
echo'<div class="container border border-3 d-grid gap-3 pb-4 px-4 mt-4">
  <div class="row text-center pt-4"><h2>Material</h2></div>
  <button type="button" class="btn btn-info btn-dark" data-bs-toggle="modal" data-bs-target="#modal1"><h5>Add Material</h5></button>'; 
}
$row=mysqli_query($conn,"SELECT `no`, `header`, `link`, `notes`, `ref`, `assigment`,`upload` FROM $course");
    $c=0;
    while($res=mysqli_fetch_array($row)){
        if($c%3==0)
          echo' <div class="row ">';
        $c=$c+1;
        echo '<div class="col-lg-4 mt-4">
        <div class="card border border-success">
          <div class="card-body">
            <h5 class="card-title text-center">'.$res['header'].'</h5>';
            if($res['link']!=NULL)
              echo'<a href="'.$res['link'].'" class="link-secondary">lecture video link</a><br>';
            if($res['notes']!=NULL)
              echo'<a href="'.$res['notes'].'" class="link-secondary">Material link</a><br>';
            if($res['ref']!=NULL)
              echo'<a href="'.$res['ref'].'" class="link-secondary">refrences</a><br>';
            if($res['assigment']!=NULL)
            {
              echo'<a href="'.$res['assigment'].'" class="link-secondary">assigment link</a><br>';
              echo'<a href="'.$res['upload'].'" class="link-secondary">upload link</a><br>';
            }
         echo'</div>';
        if($role=="teacher"){
           echo '<form role="form" action="'.$course.'.php?course='.$course.'& course_name='.$subject.'" method="POST">
           <tr>
           <td><input type="integer" name="no" value='.$res['no'].' hidden></td>
           <td><input type="submit" class="btn btn-default btn-outline-danger btn-sm mx-1 me-2" name="delete" value="Delete" style="float:right"/></td>
           <td><input type="submit" class="btn btn-default btn btn-outline-dark btn-sm mx-1 me-2" name="update" value="Update" style="float:right"/></td>
           </tr>
           </form>';
        }
         echo '
         </div>
        </div>';
        if($c%3==0)
          echo'</div>';
    }
?>

</div>
        </div>
    </div>
</div>

</body>
</html>