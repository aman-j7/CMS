<?php
include "../includes/config.php";	
if (isset($_POST["save"])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if($name != "" && $msg != ""){
	  mysqli_query($conn,"INSERT INTO discussion (parent_comment, student, post) VALUES ('$id', '$name', '$msg')");
  }
}
else if (isset($_POST["btnreply"])){
  $id = $_POST['pid'];
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  if($name != "" && $msg != ""){
	  mysqli_query($conn,"INSERT INTO discussion (parent_comment, student, post) VALUES ('$id', '$name', '$msg')");
  }
}
$result =  mysqli_query($conn,"SELECT *  FROM `discussion` where parent_comment='0' ORDER BY id desc");
?>
<html>
<head>
<link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
<title>forum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!-- <script src="main.js"></script> -->
</head>

<!-- Modal -->
<div id="ReplyModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply Question</h4>
      </div>
      <div class="modal-body">
        <form name="frm1" method="post" action="index.php">
            <input type="hidden" id="pid" name="pid">
        	<div class="form-group">
        	  <label for="usr">Write your name:</label>
        	  <input type="text" class="form-control" name="name" required>
        	</div>
            <div class="form-group">
              <label for="comment">Write your reply:</label>
              <textarea class="form-control" rows="5" name="msg" required></textarea>
            </div>
        	 <input type="submit" name="btnreply" class="btn btn-primary" value="Reply">
      </form>
      </div>
    </div>

  </div>
</div>

<div class="container">

<div class="panel panel-default" style="margin-top:50px">
  <div class="panel-body">
    <h3>Community forum</h3>
    <hr>
    <form name="frm" method="post" action="index.php">
        <input type="hidden" id="commentid" name="Pcommentid" value="0">
	<div class="form-group">
	  <label for="usr">Write your name:</label>
	  <input type="text" class="form-control" name="name" required>
	</div>
    <div class="form-group">
      <label for="comment">Write your question:</label>
      <textarea class="form-control" rows="5" name="msg" required></textarea>
    </div>
	 <input type="submit" name="save" class="btn btn-primary" value="Send">
  </form>
  </div>
</div>
  

<div class="panel panel-default">
  <div class="panel-body">
    <h4>Recent questions</h4>           
	<table class="table" id="MyTable" style="background-color: #edfafa; border:0px;border-radius:10px">
	  <tbody id="record">
    <?php
    while ($res = mysqli_fetch_array($result)):
      $pid=$res['id'];
    ?>

        <tr><td><b><img src="avatar.jpg" width="30px" height="30px" /> <?php echo $res['student'];?> :<i> <?php echo $res['date'];?>:</i></b></br><p style="padding-left:80px"><?php echo $res['post'];?></br>
        <button type="button" class="btn btn-primary 
            btn-sm" data-toggle="modal" 
            data-target="#ReplyModal"
            id="submit">
            Reply
        </button></p></td></tr>
        <script type="text/javascript">
        $("#submit").click(function () {
            var name = <?php echo $pid;?>
            $("#pid").html(name);
        });
        var myRoomNumber;

$('#rooms li a').click(function() {
   myRoomNumber = $(this).attr('data-id'); 
});

$('#myModal').on('show.bs.modal', function (e) {
    $(this).find('.roomNumber').text(myRoomNumber);
});
    </script>
    
        <?php
          $result1 =  mysqli_query($conn,"SELECT *  FROM `discussion` where parent_comment=$pid ORDER BY id desc");
          while ($res1 = mysqli_fetch_array($result1)):
        ?>               
        <tr><td style="padding-left:80px"><b><img src="avatar.jpg" width="30px" height="30px" /><?php echo $res1['student'];?> :<i> <?php echo $res1['date'];?>:</i></b></br><p style="padding-left:40px"><?php echo $res1['post'];?></p></td></tr>
        <?php endwhile;
        endwhile;?>
      

	  </tbody>
	</table>
  </div>
</div>

</div>

</body>
</html>