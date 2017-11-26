<?php
function make_connection()
{
	global $dbhost,$dbuser,$dbpass,$dbname,$connection;
	// $dbhost='mysql.hostinger.in';
	// $dbuser='u638108590_acm';
	// $dbpass='acmsecret';
	// $dbname='u638108590_acm';
	$dbhost='localhost';
	$dbuser='root';
	$dbpass='secret';
	$dbname='whoisfree';
	$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_connect_error());
	}
}
function check_pravega_admin($password){
	global $connection;
	$query="SELECT pravegaadmin from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['pravegaadmin'];
	if($password==$db_pass)
		return true;
	else
		return false;
}
function check_pravega_user($password){
	global $connection;
	$query="SELECT pravegauser from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['pravegauser'];
	if($password==$db_pass)
		return true;
	else
		return false;
}
function check_acm_admin($password){
	global $connection;
	$query="SELECT acmadmin from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['acmadmin'];
	if($password==$db_pass)
		return true;
	else
		return false;
}
function check_acm_user($password){
	global $connection;
	$query="SELECT acmuser from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['acmuser'];
	if($password==$db_pass)
		return true;
	else
		return false;
}
function get_current_user_password_acm(){
	global $connection;
	$query="SELECT acmuser from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['acmuser'];
	return $db_pass;
}
function get_current_admin_password_acm(){
	global $connection;
	$query="SELECT acmadmin from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['acmadmin'];
	return $db_pass;
}
function get_current_user_password_pravega(){
	global $connection;
	$query="SELECT pravegauser from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['pravegauser'];
	return $db_pass;
}
function get_current_admin_password_pravega(){
	global $connection;
	$query="SELECT pravegaadmin from passwords";
	$result=mysqli_query($connection,$query);
	$row=mysqli_fetch_assoc($result);
	$db_pass=$row['pravegaadmin'];
	return $db_pass;
}
function update_password_acm($user_password,$admin_password){
	global $connection;
	$query="Update passwords SET acmuser='{$user_password}',acmadmin='{$admin_password}';";
	$result=mysqli_query($connection,$query);
	if($result)
		return true;
	else
		return false;
}
function update_password_pravega($user_password,$admin_password){
	global $connection;
	$query="Update passwords SET pravegauser='{$user_password}',pravegaadmin='{$admin_password}';";
	$result=mysqli_query($connection,$query);
	if($result)
		return true;
	else
		return false;
}
function ids_to_text($slots_selected)
{
	$idstotext="";
	$len=count($slots_selected);
	for($i=0;$i<$len;$i++)
	{
		if($i==0)
			$idstotext="for";
		$id=(int)($slots_selected[$i]);
		$idd=$id;
		$day=(int)($id/100);
		$dayy=$day;
		$days=["Monday","Tuesday","Wednesday","Thursday","Friday"];
		$times=["8-8:50am","9-9:50am","10-10:50am","11-11:50am","12-12:50pm","12:40-1:30pm","2-2:50pm","3-3:50pm","4-4:50pm","5-5:50pm","6-6:50pm","6:40-7:30pm"];
		$day=$days[$day-1];
		$time=(int)($id%100);
		if($idd==309)
		{
			$day="";
			$time="Extramural Hour";
		}
		else if($dayy==3 && $time>=3)
			$time=$time+3;
		if($idd!=309)
			$time=$times[$time];
		if($i==$len-1)
		{
			if($len!=1)
				$idstotext.=" and ".$day." ".$time;
			else
				$idstotext.=" ".$day." ".$time;
		}
		else
		{
			if($i!=0)
				$idstotext.=", ".$day." ".$time;
			else
				$idstotext.=" ".$day." ".$time;
		}
	}
	return $idstotext;
}

function insert_image($file,$regno)
{
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}
}
?>
