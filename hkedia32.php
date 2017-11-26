<?php
if(isset($_POST['regsubmit'])){
	if(isset($_FILES['fileToUpload']))
	{
		$target_dir = "images/";
		$target_file = $target_dir . "a123".".doc";//new name of the file
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
		
// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
// Allow certain file formats
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
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form action="hkedia32.php" method="post" enctype="multipart/form-data">
<label class="control-label col-sm-4">Upload the timetable image(optional):</label>
<div class="col-sm-8">
<input type="file" class="" name="fileToUpload" id="fileToUpload">
</div>
<button name="regsubmit" class="col-xs-12 col-sm-2 col-sm-offset-5 btn btn-success" type="submit">Register</button>
</body>
</html>