<?php
include('functions.php');
if(isset($_POST["submit"])) {
insert_image($_FILES['fileimage'],"15BCE0322");
}
?>
<!DOCTYPE html>
<html>
<body>

<form action="initialize_hkedia32.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileimage" id="fileimage">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>