// var myVar = setInterval(LoadData, 2000);

// http_request = new XMLHttpRequest();

// function LoadData(){
// $.ajax({
// url: 'view.php',
// type: "POST",
// dataType: 'json',
// success: function(data) {
//     $('#MyTable tbody').empty();
//     for (var i=0; i<data.length; i++) {
//         var commentId = data[i].id;
//         if(data[i].parent_comment == 0){
//         var row = $('<tr><td><b><img src="avatar.jpg" width="30px" height="30px" />' + data[i].student + ' :<i> '+ data[i].date + ':</i></b></br><p style="padding-left:80px">' + data[i].post + '</br><a data-toggle="modal" data-id="'+ commentId +'" title="Add this item" class="open-ReplyModal" href="#ReplyModal">Reply</a>'+'</p></td></tr>');
//         $('#record').append(row);
//         for (var r = 0; (r < data.length); r++)
//                 {
//                     if ( data[r].parent_comment == commentId)
//                     {
//                         var comments = $('<tr><td style="padding-left:80px"><b><img src="avatar.jpg" width="30px" height="30px" />' + data[r].student + ' :<i> ' + data[r].date + ':</i></b></br><p style="padding-left:40px">'+ data[r].post +'</p></td></tr>');
//                         $('#record').append(comments);
//                     }
//                 }
//         }
//     }
// },
// error: function(jqXHR, textStatus, errorThrown){
//     alert('Error: ' + textStatus + ' - ' + errorThrown);
// }
// });
// }



// $(document).on("click", ".open-ReplyModal", function () {
//      var commentid = $(this).data('id');
//      $(".modal-body #commentid").val( commentid );
// });


		
// //Post data to the server
// $(document).ready(function() {
// 	$('#butsave').on('click', function() {
// 		$("#butsave").attr("disabled", "disabled");
// 		var id = document.forms["frm"]["Pcommentid"].value;
// 		var name = document.forms["frm"]["name"].value;
// 		var msg = document.forms["frm"]["msg"].value;
// 		if(name!="" && msg!=""){
// 			$.ajax({
// 				url: "save.php",
// 				type: "POST",
// 				data: {
// 					id: id,
// 					name: name,
// 					msg: msg,			
// 				},
// 				cache: false,
// 				success: function(dataResult){
// 					var dataResult = JSON.parse(dataResult);
// 					if(dataResult.statusCode==200){
// 						$("#butsave").removeAttr("disabled");
// 						document.forms["frm"]["Pcommentid"].value = "";
// 						document.forms["frm"]["name"].value = "";
// 						document.forms["frm"]["msg"].value = "";
// 						LoadData(); 						
// 					}
// 					else if(dataResult.statusCode==201){
// 					   alert("Error occured !");
// 					}
					
// 				}
// 			});
// 		}
// 		else{
// 			alert('Please fill all the field !');
// 		}
// 	});
// });

// //Reply comment
// $(document).ready(function() {
// 	$('#btnreply').on('click', function() {
// 		$("#btnreply").attr("disabled", "disabled");
// 		var id = document.forms["frm1"]["Rcommentid"].value;
// 		var name = document.forms["frm1"]["Rname"].value;
// 		var msg = document.forms["frm1"]["Rmsg"].value;
// 		if(name!="" && msg!=""){
// 			$.ajax({
// 				url: "save.php",
// 				type: "POST",
// 				data: {
// 					id: id,
// 					name: name,
// 					msg: msg,			
// 				},
// 				cache: false,
// 				success: function(dataResult){
// 					var dataResult = JSON.parse(dataResult);
// 					if(dataResult.statusCode==200){
// 						$("#btnreply").removeAttr("disabled");
// 						document.forms["frm1"]["Rcommentid"].value = "";
// 						document.forms["frm1"]["Rname"].value = "";
// 						document.forms["frm1"]["Rmsg"].value = "";
// 						LoadData(); 
// 						$("#ReplyModal").modal("hide");
// 					}
// 					else if(dataResult.statusCode==201){
// 					   alert("Error occured !");
// 					}
					
// 				}
// 			});
// 		}
// 		else{
// 			alert('Please fill all the field !');
// 		}
// 	});
// });


<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="./images/favicon.png" type="image/png" sizes="16x16">
<title>forum</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="main.js"></script>
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
        <form name="frm1" method="post">
            <input type="hidden" id="commentid" name="Rcommentid">
        	<div class="form-group">
        	  <label for="usr">Write your name:</label>
        	  <input type="text" class="form-control" name="Rname" required>
        	</div>
            <div class="form-group">
              <label for="comment">Write your reply:</label>
              <textarea class="form-control" rows="5" name="Rmsg" required></textarea>
            </div>
        	 <input type="button" id="btnreply" name="btnreply" class="btn btn-primary" value="Reply">
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
    <form name="frm" method="post">
        <input type="hidden" id="commentid" name="Pcommentid" value="0">
	<div class="form-group">
	  <label for="usr">Write your name:</label>
	  <input type="text" class="form-control" name="name" required>
	</div>
    <div class="form-group">
      <label for="comment">Write your question:</label>
      <textarea class="form-control" rows="5" name="msg" required></textarea>
    </div>
	 <input type="button" id="butsave" name="save" class="btn btn-primary" value="Send">
  </form>
  </div>
</div>
  

<div class="panel panel-default">
  <div class="panel-body">
    <h4>Recent questions</h4>           
	<table class="table" id="MyTable" style="background-color: #edfafa; border:0px;border-radius:10px">
	  <tbody id="record">
		
	  </tbody>
	</table>
  </div>
</div>

</div>

</body>
</html>

	