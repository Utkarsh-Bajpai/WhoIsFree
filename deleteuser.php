<?php
session_start();

require('functions.php');
make_connection();
if(isset($_SESSION['user']) && isset($_SESSION['admin'])){
}
else{
	header("Location: login-pravega.php");
}
if($_SESSION['user'] && $_SESSION['admin']){
}
else{
	echo"<h3 style='color:red'>Please log in as an admin to delete user.</h3>";
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Who is free? | Delete timetable</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="author" content="Harshit Kedia">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<style>
		.red{
			color: red;
		}
		.green{
			color: green !important;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<br>
				<a href="register.php"><button class="btn pull-left">Go Back</button></a>
				<br><br>
				<h2 class="text-center">Delete a User</h2>
			</div>
			<div class="col-sm-6 col-sm-offset-3">
				<?php
				if(isset($_SESSION['deleted_user']) and $_SESSION['deleted_user']=='yes')
				{
					?>
					<div class="alert alert-success">Successfully deleted the user</div>
					<?php
				}
				if(isset($_SESSION['deleted_user']) and $_SESSION['deleted_user']=='no')
				{
					?>
					<div class="alert alert-danger">There was some problem deleting the user</div>
					<?php
				}
				if(isset($_SESSION['deleted_user']))
					$_SESSION['deleted_user']=null;
				?>
				<form id="deleteuserform" method="POST" action="searchusersubmit.php">
					<?php
					if(isset($_SESSION['found_user']['name']) and $_SESSION['found_user']['name'])
					{

					}
					else
					{

						?>
						<div class="form-group">
							<label for="regnoform" class="col-sm-4 control-label">Reg no.<span class="red">*</span></label>
							<div class="col-sm-8">
								<input type="text" required placeholder="Reg no to be deleted" class="form-control" id="regnoform" name="regnoform" value="<?php if(isset($_SESSION['found_user']['regno']) and $_SESSION['found_user']['regno']) echo $_SESSION['found_user']['regno'];?>">
							</div>
						</div>
						<?php
					}
					?>
					<br class="hidden-xs"><br class="hidden-xs">
					<?php
					if(isset($_SESSION['found_user']['regno']) and $_SESSION['found_user']['regno'])
					{
						if(isset($_SESSION['found_user']['name']) and $_SESSION['found_user']['name'])
						{

							?>
							<h5 class="text-center alert alert-danger">Found <b><?php echo $_SESSION['found_user']['name'];?></b> with reg no <?php echo $_SESSION['found_user']['regno'];?></h5>
							<button type="submit" name="deleteusersubmit" id="deleteusersubmit" class="btn btn-danger" style="width: 100%;">Delete this user</button>
							<br><br class="hidden-xs">
							<a href="deleteuser.php"><button class="btn btn-primary" style="width: 100%;">Cancel</button></a>
							<?php
							$_SESSION['found_user']['name']=null;
						}
						else
						{

							echo "<h5 class='text-center alert alert-warning'>Found no user with this reg no</h5>";
							?>
							<button type="submit" name="searchusersubmit" id="searchusersubmit" class="btn btn-primary" style="width: 100%;">Search</button>
							<?php
						}
						$_SESSION['found_user']['regno']=null;
					}
					else
					{
						?>
						<button type="submit" name="searchusersubmit" id="searchusersubmit" class="btn btn-primary" style="width: 100%;">Search</button>
						<?php
					}
					?>
				</form>
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
	<script type="text/javascript">
	</script>
</body>
</html>