<!DOCTYPE html>
<html lang="en">
<head>
  <title>Common Destinations</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="reset" href="css/reset.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css'>
  <link rel="stylesheet" href="./dist/css/animsition.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="https://use.typekit.net/uqw6uln.css">
</head>
<body>

  <div class="animsition">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="page_index.html">Common Destinations.</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="page_index.html">Home<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="locations.html">Locations</a>
          </li>
					<li class="nav-item active">
						<a class="nav-link" href="index.php">Comments</a>
					</li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
          </li>
        </ul>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <a class="btn btn-dark btn-lg" href="login.html" role="button">Login</a>
        </form>
      </div>
    </nav>

	</div>

<br>
<br>

<?php
require_once("DBController.php");
$db_handle = new DBController();
$comments = $db_handle->runQuery("SELECT * FROM comment");
?>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function showEditBox(editobj,id) {
	$('#frmAdd').hide();
	$(editobj).prop('disabled','true');
	var currentMessage = $("#message_" + id + " .message-content").html();
	var editMarkUp = '<textarea rows="5" cols="80" id="txtmessage_'+id+'">'+currentMessage+'</textarea><button name="ok" onClick="callCrudAction(\'edit\','+id+')">Save</button><button name="cancel" onClick="cancelEdit(\''+currentMessage+'\','+id+')">Cancel</button>';
	$("#message_" + id + " .message-content").html(editMarkUp);
}
function cancelEdit(message,id) {
	$("#message_" + id + " .message-content").html(message);
	$('#frmAdd').show();
}
function callCrudAction(action,id) {
	$("#loaderIcon").show();
	var queryString;
	switch(action) {
		case "add":
			queryString = 'action='+action+'&txtmessage='+ $("#txtmessage").val();
		break;
		case "edit":
			queryString = 'action='+action+'&message_id='+ id + '&txtmessage='+ $("#txtmessage_"+id).val();
		break;
		case "delete":
			queryString = 'action='+action+'&message_id='+ id;
		break;
	}
	jQuery.ajax({
	url: "crud_action.php",
	data:queryString,
	type: "POST",
	success:function(data){
		switch(action) {
			case "add":
				$("#comment-list-box").append(data);
			break;
			case "edit":
				$("#message_" + id + " .message-content").html(data);
				$('#frmAdd').show();
				$("#message_"+id+" .btnEditAction").prop('disabled','');
			break;
			case "delete":
				$('#message_'+id).fadeOut();
			break;
		}
		$("#txtmessage").val('');
		$("#loaderIcon").hide();
	},
	error:function (){}
	});
}
</script>

<div class="form_style">
<div id="comment-list-box">
<?php
if(!empty($comments)) {
foreach($comments as $k=>$v) {
?>
<div class="message-box" id="message_<?php echo $comments[$k]["id"];?>">
<div>
<button class="btnEditAction" name="edit" onClick="showEditBox(this,<?php echo $comments[$k]["id"]; ?>)">Edit</button>
<button class="btnDeleteAction" name="delete" onClick="callCrudAction('delete',<?php echo $comments[$k]["id"]; ?>)">Delete</button>
</div>
<div class="message-content"><?php echo $comments[$k]["message"]; ?></div>
</div>
<?php
}
} ?>
</div>

<div id="frmAdd"><textarea name="txtmessage" id="txtmessage" cols="80" rows="5"></textarea>
<p><button id="btnAddAction" name="submit" onClick="callCrudAction('add','')">Add Comment</button></p>
</div>

<img src="img/LoaderIcon.png" id="loaderIcon" style="display:none" />
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- animsition.js -->
<script src="./dist/js/animsition.min.js"></script>

<script>

$(document).ready(function() {
$('.animsition').animsition();
});

</script>
