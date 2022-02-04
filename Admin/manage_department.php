<?php
include "../includes/config.php";
include "../includes/random_color.php";
$flag = 0;
if (isset($_POST["submit_add_department"])) {
  $f = $_GET["f"];
  $d_id = $_POST["d_id"];
  $d_name = $_POST["d_name"];
  if ($f) {
    mysqli_query($conn, "update department set dept_name='$d_name' where dept_id='$d_id'");
  } else {
    mysqli_query($conn, "insert into department values('$d_id','$d_name')");
  }
} else if (isset($_POST["submit_update_department"])) {
  $d_id = $_POST["d_id"];
  $res = mysqli_query($conn, "Select dept_id,dept_name from department where dept_id='$d_id'");
  $row = mysqli_fetch_array($res);
  $flag = 1;
} else if (isset($_POST["submit_drop_department"])) {
  $d_id = $_POST["d_id"];
  mysqli_query($conn, "DELETE FROM `department` where dept_id='$d_id'");
}
?>
<html>

<head>
  <title>
    Manage Department
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
  }
  ?>

  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Department";
                                                                                else echo "Add Department"; ?></h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_department.php?f=<?php echo $flag ?>" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Department Id</label>
              <input type="text" class="form-control input1" name="d_id" placeholder="Enter Department id" value="<?php if ($flag) echo $row['dept_id'];
                                                                                                            else echo ""; ?>" required>
            </div>
            <div class="form-group">
              <label> Department Name</label>
              <input type="text" class="form-control input1" placeholder="Enter Department name" name="d_name" value="<?php if ($flag) echo $row['dept_name'];
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
          <input type="submit" class="btn btn-default btn-success input1" name="submit_add_department" value="<?php if ($flag) echo "Update";
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
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Department</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_department.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Department Id</label>
              <input type="text" class="form-control" name="d_id" placeholder="Enter Department id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_update_department" value="Proceed" />
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
          <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Department</h5>
        </div>
        <div class="modal-body">
          <form role="form" action="manage_department.php" method="POST" autocomplete="off">
            <div class="form-group">
              <label>Department Id</label>
              <input type="text" class="form-control" name="d_id" placeholder="Enter Department id" required>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-default btn-success" name="submit_drop_department" value="Delete" />
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>



  <section id="gallery">
    <div class="container">


      <div class="row">
        <div class="text-center">
          <h1><strong>Department</strong></h1>
        </div>
        <div class="col-lg-4 mt-4">
          <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
            <div class="card">
            <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
              <div class="card-body">
                <h5 class="card-title text-center">Add Department </h5>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Update Depratment</h5>
      </a>
    </div>
    </div>
    </div>
    <div class="col-lg-4 mt-4">
      <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
        <div class="card">
        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex();?>">
          <div class="card-body">
            <h5 class="card-title text-center">Drop Depratment</h5>
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
    function csvInput(checkBox){
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
        tmp[3].setAttribute("name","submit_add_department");
    }
  }
    
</script>
</body>

</html>