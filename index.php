<?php
session_start();
if(isset($_SESSION["session_id"]) && $_SESSION["session_id"] ==session_id() ){
	if($_SESSION['permission']==0){
			header('Location:booking.php?round=1');
	}else {
		header('Location:booking.php?round='.$_SESSION['permission']);
	}
}

?>
<!DOCTYPE >
<html>
	<head>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Nourneer Booking :: BEWILDER</title>
			<!-- Bootstrap -->
			<link href="css/bootstrap.min.css" rel="stylesheet">
			<link href="css/style.css" rel="stylesheet">

		</head>
		<body style="background-color:#000000;">
			<div class="container" >
				<div class="row">
						<div class="col-md-12">
								<p style="text-align:center"><img  id="imglogoindex" align="center" src="img/logo.jpg" width="300" ></p>
						</div>
				</div>
				<div class="row">
						<div class="col-md-4 col-md-offset-4">
								<div class="panel panel-default">
					  			<div class="panel-heading">Nourneer #27</div>
					    		<div class="panel-body">
					      			<form class="form-horizontal" id="loginForm">
											  <div class="form-group">
											    <label for="inputUsername" class="col-sm-4 control-label">Username</label>
											    <div class="col-sm-8">
											      <input type="text" class="form-control" id="inputUsername" placeholder="Username">
											    </div>
											  </div>
											  <div class="form-group">
											    <label for="inputPassword" class="col-sm-4 control-label">Password</label>
											    <div class="col-sm-8">
											      <input type="password" class="form-control" id="inputPassword" placeholder="Password">

											    </div>
											  </div>
											  <div class="form-group">
											    <div class="col-sm-offset-4 col-sm-4">
											      <button type="submit" class="btn btn-success">Sign in</button>

											    </div>
											  </div>
											</form>
											<div class="alert alert-danger hidden" role="alert" id="errorMessage"></div>
											<div class="panel-footer"><p class="text-right">EN Student's Union,KKU © 2015</p></div>
					    		</div>

					  		</div>
					</div>
			</div>
		</div>

	</body>
<script src="js/jquery-2.1.3.min.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
				$('#loginForm').on('submit',function(){
						$.ajax({
							type: "POST",
							url: 'checkLogin.php',
							data: {"username":$('#inputUsername').val(),"password":$('#inputPassword').val()},
							success: function(data){

								if(Boolean(data.login)){
									if(data.permission==0){
										window.location.href = "booking.php?round=1";
									}
									else {
										var url="booking.php?round="+data.permission;
										window.location.href = url;
									}

								}else {
									$('#errorMessage').removeClass('hidden');
									$('#errorMessage').html(data.error);
								}
							}
						});

					return false;
				});

		});
</script>
</html>
