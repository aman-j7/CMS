<?php
include "../includes/config.php";
include "../includes/random_color.php";
$flag = 0;
$exception_occur = 0;
$role = $_SESSION['type'];
$pageName = basename($_SERVER['PHP_SELF']);
$exception_cause = new Exception();
try {
    $department = mysqli_query($conn, "SELECT * FROM `department`");
    if (isset($_POST["submit_add_teacher"])) {
        $f = $_GET["f"];
        $f_id = $_POST["f_id"];
        $f_name = $_POST["f_name"];
        $d_id = $_POST["d_id"];
        $f_email = $_POST["f_email"];
        $isAdmin=$_POST['isAdmin'];
        echo $isAdmin.' '.$d_id;
        if ($f) {
            mysqli_query($conn, "update admin set name='$f_name',dept_id='$d_id',`isAdmin`='$isAdmin',`email`='$f_email' where id='$f_id'");
            mysqli_query($conn, "UPDATE `login` SET `email`='$f_email' WHERE `reg_id`='$f_id'");
        } else {
            mysqli_query($conn, "insert into admin (`id`, `name`, `dept_id`,`email`,`isAdmin`)values('$f_id','$f_name','$d_id','$f_email','$isAdmin')");
            mysqli_query($conn, "insert into login values('$f_id','CMS@123','admin','$f_email',0)");
        }
    } else if (isset($_POST["submit_update_teacher"])) {
        $f_id = $_POST["f_id"];
        $res = mysqli_query($conn, "Select id,name,dept_id,email,isAdmin from admin where id='$f_id'");
        $row = mysqli_fetch_array($res);
        $flag = 1;
    } else if (isset($_POST["submit_drop_teacher"])) {
        $f_id = $_POST["f_id"];
        mysqli_query($conn, "DELETE FROM `admin` where id='$f_id'");
    } else if (isset($_POST["csv"])) {
        $handle = fopen($_FILES['filename']['tmp_name'], "r");
        fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            mysqli_query($conn, "insert into admin (`id`, `name`, `dept_id`) values('$data[0]','$data[1]','$data[2]')");
            mysqli_query($conn, "insert into login values('$data[0]','CMS@123','admin','abc@gamil.com',0)");
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
        Manage Admin
    </title>

    <?php include '../includes/cdn.php'; ?>
    <link rel="stylesheet" href="../CSS/admin.css">
    <link rel="stylesheet" href="../CSS/sidebar.css">

</head>
<body>
    <?php if ($exception_occur) : ?>
        <script>
            alert("<?php echo $exception_cause->getMessage() ?>");
        </script>
    <?php endif;
    if ($flag) : ?>
        <script type='text/javascript'>
            $(document).ready(function() {
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
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel"><?php if ($flag) echo "Update Admin";
                                                                                                else echo "Add Admin"; ?></h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="manage_admin.php?f=<?php echo $flag ?>" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control input1" name="f_id" placeholder="Enter Admin id" value="<?php if ($flag) echo $row['id'];
                                                                                                                                    else echo ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label> Admin Name</label>
                                <input type="text" class="form-control input1" placeholder="Enter Admin name" name="f_name" value="<?php if ($flag) echo $row['name'];
                                                                                                                                        else echo ""; ?>" required>
                            </div>
                            <div class="form-group">
                                <label> Email</label>
                                <input type="email" class="form-control input1" placeholder="Enter Admin email" name="f_email" value="<?php if ($flag) echo $row['email']; else echo ""; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Department Id</label>
                                <input type="text" class="form-control input1" name="d_id" value="Administrative" disabled required>
                            </div>
                            <div class="form-group">
                                <label> Full Access</label>
                                <input type="checkbox" name="isAdmin" <?php if ($flag && $row['isAdmin']) echo "checked" ?>>
                            </div>
                            <?php if (!$flag) : ?>
                                <div class="form-group">
                                    <input type="checkbox" id="check" name="check" onclick="csvInput(this)">
                                    <label>Update Using CSV File</label>
                                </div>
                                <div class="form-group input1">
                                </div>
                            <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default btn-success input1" name="submit_add_teacher" value="<?php if ($flag) echo "Update";
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
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Update Admin</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="manage_admin.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control" id="t_id" name="f_id" placeholder="Enter teacher id" required>
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



        <div class="modal fade" id="modal3" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="margin:0 auto;" id="exampleModalLabel">Drop Admin</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form" action="manage_admin.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Admin Id</label>
                                <input type="text" class="form-control" id="t_id" name="f_id" placeholder="Enter teacher id" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default btn-success" name="submit_drop_teacher" value="Delete" />
                        <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <section id="gallery">
            <div class="container mt-4 ">
                <h1 class="text-center pt-2 pb-2 text">
                    Admin
                </h1>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal1" style="color:black">
                            <div class="card">
                                <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Add Admin </h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal2" style="color:black">
                    <div class="card">
                        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center">Update Admin</h5>
                </a>
            </div>
            </div>
            </div>
            <div class="col-lg-4 mt-4">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modal3" style="color:black">
                    <div class="card">
                        <img src="../images/1.png" alt="" class="card-img-top" style="background-color:<?php echo randomhex(); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center">Drop Admin</h5>
                </a>
            </div>
            </div>
            </div>
            </div>

            <div class="form-outline mb-4 mt-5 form-check form-switch">
                <label>
                    <h6>View Data</h6>
                </label>
                <input class="form-check-input" type="checkbox" id="view_data" onclick="view_toggle()">
            </div>

            <?php 
            $id=$_SESSION['user_id'];
            $data = mysqli_query($conn, "Select `id`,`name`,`dept_id`,`isAdmin` from `admin`where `id`!='$id'"); ?>
            <div class="row mt-4" id="table" style="height: 400px; overflow:auto" hidden>
                <table class="text-center table table-light" style="height: 10px;">
                    <thead style="position: sticky; top:0;">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Full Access</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_array($data)) :
                    ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['dept_id'] ?></td>
                            <td><?php if($row['isAdmin']) echo "Yes"; else echo "NO"; ?></td>
                            <td><button class="btn btn-secondary" title="Update"><i class="bx bxs-edit-alt icon " data-id="<?php echo $row['id']; ?>" onclick="update_data(this)"></i></button>
                                <button class="btn btn-danger" title="Delete"><i class="bx bx-trash-alt icon " data-id="<?php echo $row['id']; ?>" onclick="delete_data(this)"></i></button>
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
        function csvInput(checkBox) {
            let tmp = document.querySelectorAll(".input1");
            if (checkBox.checked) {
                tmp[0].disabled = true;
                tmp[1].disabled = true;
                tmp[2].disabled = true;
                let file = document.createElement("input");
                file.size = "50";
                file.type = "file";
                file.name = "filename";
                file.id = "file";
                file.required = true;
                file.accept = ".csv";
                tmp[3].appendChild(file);
                tmp[4].setAttribute("name", "csv");

            } else {
                tmp[0].disabled = false;
                tmp[1].disabled = false;
                tmp[2].disabled = false;
                let file = document.getElementById("file");
                tmp[3].removeChild(file);
                tmp[4].setAttribute("name", "submit_add_teacher");
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
            console.log(str);
            $("#modal2 .modal-body #t_id").val(str);
            $('#modal2').modal('show');
        }

        function delete_data(a) {
            var str = $(a).attr("data-id");
            console.log(str);
            $("#modal3 .modal-body #t_id").val(str);
            $('#modal3').modal('show');
        }
    </script>
</body>

</html>