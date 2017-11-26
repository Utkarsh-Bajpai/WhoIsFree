<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Error</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="text-center">
	<h2 class="text-center">Error </h2>
	<h3 class="text-center">
		<?php
		if(isset($_SESSION['bugerror']))
		{
			$errorbug=$_SESSION['bugerror'];
			echo $errorbug;
			$_SESSION['bugerror']=null;
		}
		else
			header("Location: thankyou.html");
		?>
	<a href="user.php"><button class="btn btn-primary">Go back</button></a>
</body>
</html>