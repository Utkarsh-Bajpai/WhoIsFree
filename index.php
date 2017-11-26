<?php
require('functions.php');
make_connection();
session_start();
$errors=[];
if(isset($_POST['submit'])){
	$username=$_POST['username'];
	$password=$_POST['password'];
	if($username=='acm'){
		if(check_acm_admin($password))
		{
			$_SESSION['user']='user';
			$_SESSION['database']='acm';
			$_SESSION['admin']=1;
			header("Location: user.php");
		}
		elseif(check_acm_user($password))
		{
			$_SESSION['user']='user';
			$_SESSION['database']='acm';
			$_SESSION['admin']=0;
			header("Location: user.php");
		}
		else
		{
			$errors["login"]="wrong password";
		}
	}
	else{
		$errors["login"]="wrong username";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Who is free? | ACM Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="author" content="Harshit Kedia">
	<meta http-equiv="Content-Type" content="text/html">
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://whoisfree.16mb.com/">
	<meta property="og:site_name" content="Who is free?" />
	<meta property="og:title" content="Who is free? Now find free slots of others easily" />
	<meta property="og:author" content="Harshit Kedia">
	<meta property="article:author" content="Harshit Kedia">
	<meta property="og:description" content="Who is free is an easy way to find free slots of others for announcements and other purposes." />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<style>
		form{
			margin-top: 10vh;
		}
		input{
			margin-bottom: 10px;
		}
		h1,h4{
			text-align: center;
		}
		label{
			margin-top: 5px;
		}
		.error, .red{
			color: red;
		}
	</style>
</head>
<body>
	<div class="container">

		<div class="contentmain">
			<h1>Who is free?</h1>
			<h4>Now find free slots of others easily!<br>Just log in with your username provided by your organisation.</h4>
			<div class="col-sm-6 col-sm-offset-4">
				<form action="#" method="post">
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="username">Username</label>
							<div class="col-sm-7">
								<input type="text" required id="username" name="username" value="acm" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="password">Password</label>
							<div class="col-sm-7">
								<input type="password" required id="password" name="password" class="form-control">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary col-sm-9 col-xs-12" id="submit" name="submit">
						Log in
					</button>
					<div class="row">
						<span class="error col-md-12"><?php if(isset($errors["login"])) echo $errors["login"];?></span>
					</div>
					<div class="row">
						<span class="error col-md-12">
							<?php
							if(isset($_SESSION['admin']) && $_SESSION['admin']==0 && isset($_GET['dispadmin']) && $_GET['dispadmin'])
								echo "Please log in as an admin to avail admin rights";
							?>
						</span>
					</div>
					<div class="row">
						<span class="error col-md-12">
							<?php
							if(isset($_SESSION['errors']))
							{
								echo $_SESSION['errors'];
							}
							?>
						</span>
					</div>
				</form>
			</div>
		</div>

		<footer>
			<div class="row">
				<div class="col-sm-4 contentdiv">
					<div class="content">

						<br>
						<a href="#myModal" data-toggle="modal">Report a bug</a>
					</div>
				</div>
				<div class="col-sm-4 contentdiv">
					<div class="content">
						<a href="http://acmvit.com" target="_blank"><img src="images/vit.png" class="img-responsive img"></a>
					</div>
				</div>
				<div class="col-sm-4 contentdiv">
					<br>
					<div class="content">
						<a href="http://acmvit.com" target="_blank"><p class="developed">developed by ACM VIT</p></a>
					</div>
				</div>
			</div>
		</footer>
		<!--trigger modal-->

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="modal-title text-center">Report a bug</h3>
					</div>
					<div class="modal-body">
						<form action="reportbug.php" method="post">
							<div class="form-group">
								<label for="email" class="col-sm-2 control-label">Email<span class="red">*</span></label>
								<div class="col-sm-10">
									<input type="email" required placeholder="Your Email Id (required)" class="form-control" id="email" name="email">
								</div>
							</div>
							<div class="form-group">
								<label for="message" class="col-sm-2 control-label">Message<span class="red">*</span></label>
								<div class="col-sm-10">
									<textarea rows="5" class="form-control" id="message" placeholder="things to want to say (required)" required name="message"></textarea>
								</div>
							</div>
							<button type="submit" name="bugsubmit" class="btn btn-primary">Submit</button>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-81239297-2', 'auto');
		ga('send', 'pageview');

	</script>
</body>
</html>
