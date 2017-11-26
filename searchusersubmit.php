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
$timetable_db_name='timetable';
if($_SESSION['database']=='pravega'){
	$timetable_db_name="pravega_timetable";
}
elseif($_SESSION['database']=='acm'){
	$timetable_db_name="timetable";
}
global $connection;
if(isset($_POST['searchusersubmit']))
{
	$regno=$_POST['regnoform'];
	$query="SELECT name,regno from ".$timetable_db_name." WHERE regno='{$regno}';";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$name=$row['name'];
	$_SESSION['found_user']['name']=$name;
	$_SESSION['found_user']['regno']=$regno;
	$_SESSION['found_user']['usertobedeleted']=$regno;
}
if(isset($_POST['deleteusersubmit']))
{
	$regno_orig=$_SESSION['found_user']['usertobedeleted'];
	$query="delete from ".$timetable_db_name." WHERE regno='{$regno_orig}';";
	$result=mysqli_query($connection,$query);
	if($result)
		$_SESSION['deleted_user']='yes';
	else
		$_SESSION['deleted_user']='no';
	$_SESSION['found_user']['usertobedeleted']=null;
}
header("Location:deleteuser.php");
?>
