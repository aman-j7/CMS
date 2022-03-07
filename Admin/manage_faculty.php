<?php
include "../includes/config.php";
include "../includes/random_color.php";
$flag = 0;
$exception_occur=0;
$exception_cause=new Exception();
try
{
  if (isset($_POST["submit_add_faculty"])) {
    $f = $_GET["f"];
    $f_id = $_POST["f_id"];
    $f_name = $_POST["f_name"];
    $d_id = $_POST["d_id"];
    if ($f) {
      mysqli_query($conn, "update faculty set faculty_name='$f_name',dept_id='$d_id' where faculty_id='$f_id'");
    } else {
      mysqli_query($conn, "insert into faculty values('$f_id','$f_name','$d_id')");
      mysqli_query($conn, "insert into login values('$f_id','CMS@123','teacher','teacher@gmail.com')");
    }
  } else if (isset($_POST["submit_update_faculty"])) {
    $f_id = $_POST["f_id"];
    $res = mysqli_query($conn, "Select faculty_id,faculty_name,dept_id from faculty where faculty_id='$f_id'");
    $row = mysqli_fetch_array($res);
    $flag = 1;
  } else if (isset($_POST["submit_drop_faculty"])) {
    $f_id = $_POST["f_id"];
    mysqli_query($conn, "DELETE FROM `faculty` where faculty_id='$f_id'");
  }
  else if (isset($_POST["csv"])){
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    fgetcsv($handle, 1000, ",");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
    {
      mysqli_query($conn, "insert into faculty values('$data[0]','$data[1]','$data[2]')");
      mysqli_query($conn, "insert into login values('$data[0]','CMS@123','teacher','abc@gamil.com')");
    }
    fclose($handle);
}
}

catch(Exception $except){
  $exception_occur=1;
  $exception_cause=$except;

}

?>
<html>

<head>


  <title>
    Manage Faculty
  </title>

  <?php include '../includes/cdn.php'; ?>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">

</head>

<body>
<?php if($exception_occur):?>
    <script>
    alert("<?php echo $exception_cause->getMessage()?>");
  </script>
  <?php endif;
  if ($flag):?> 
    <script type='text/javascript'>
			$(document).ready(function(){
				$('#modal1').modal('show');
			});
		</script>
  <?php endif;
  include '../includes/admin_sidebar.php'; ?>
 <section class="home">

  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Faculty";
                                                                                else echo "Add Faculty"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_faculty.php?f=<?php echo $flag ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control input1" name="f_id" placeholder="Enter Faculty id" value="<?php if ($flag) echo $row['faculty_id'];
                                                                                                        else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label> Faculty Name</label>
              <input type="text" class="form-control input1" placeholder="Enter Faculty name" name="f_name" value="<?php if ($flag) echo $row['faculty_name'];
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
          <input type="submit" class="btn btn-default btn-success input1" name="submit_add_faculty" value="<?php if ($flag) echo "Update";
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
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Faculty</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_faculty.php" method="POST" autocomplete="off">
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



  <div class="modal fade" id="modal3" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Faculty</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_faculty.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Faculty Id</label>
              <input type="text" class="form-control" name="f_id" placeholder="Enter Faculty id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_faculty" value="Delete" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <section id="gallery">
    <div class="container">


      <div class="row">
        <div class="text-center  text">
          <h1><strong>Faculty</strong></h1>
        </div>
        <div class="col-lg-4 mt-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
            <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add Faculty </h5>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
        <div class="card">
          <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Faculty</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
        <div class="card">
          <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Drop Faculty</h5>
      </a>
    </div>
    </div>
    </div>
    </div>
    </div>
  </section>
  </div>
  </div>
    </section>
    <script type="text/javascript" src="../js/sidebar.js"></script>
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
        tmp[4].setAttribute("name","submit_add_faculty");
    }
  }
    
</script>
</body>

</html>
