<?php
session_start();
$notices_db_name="notices";
if($_SESSION['database']=='pravega'){
	$notices_db_name="pravega_notices";
}
elseif($_SESSION['database']=='acm'){
	$notices_db_name="notices";
}
if(isset($_POST['postsubmit']))
{
	require('functions.php');
	make_connection();
	
	$query="insert into ".$notices_db_name." (name,notice) values(";
	$name=$_POST['name'];
	$message=$_POST['message'];
	$query.="'$name'";
	$query.=",";
	$query.="'$message');";
	$result=mysqli_query($connection,$query);
	if(!($result)) echo "Failed to upload.";
	mysqli_close($connection);
	header("Location: user.php#notices");
}
else{
	echo"Error. data not submitted";
}
