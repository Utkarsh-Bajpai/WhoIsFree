<?php
if(isset($_POST['bugsubmit']))
{
	require('functions.php');
	make_connection();
	$email = $_POST['email'];
	$message = $_POST['message'];
	$query="INSERT INTO bugs (email,message) values('{$email}','{$message}');";
	$result=mysqli_query($connection,$query);
	if(!($result))
	{
		$_SESSION['bugerror']="There was some problem. Please try again later.";
		header("Location: reportbugerror.php");
		die();
	}
	else
		header('Location: thankyou.html');
}

else {


	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Failed</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h3>You have not send a message</h3>
	</body>
	</html>
	<?php
}
?>