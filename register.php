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
	echo"<h3 style='color:red'>Please log in as an admin to register timetables.</h3>";
	die();
}
$timetable_db_name='timetable';
$img_dir="";
if($_SESSION['database']=='pravega'){
	$timetable_db_name="pravega_timetable";
	$img_dir="pravega_images/";
}
elseif($_SESSION['database']=='acm'){
	$timetable_db_name="timetable";
	$img_dir="images/";
}
if(isset($_POST['regsubmit'])){
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_connect_error());
	}
	if(isset($_FILES['fileToUpload']))
	{
		$target_dir = $img_dir;
		$target_file = $target_dir . $_POST['regno'].".png";//new name of the file
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
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

$query="replace into ".$timetable_db_name." (regno,name,role,contactno,";
$i=1;
for($i=1;$i<=5;$i++){
	$till=11;
	if($i==3)
		$till=8;
	for($j=0;$j<=$till;$j++)
	{
		$idd=$i*100 + $j;
		$idd='a'.$idd;
		$query.=$idd;
		if($i==5 && $j==11);

		else
			$query.=",";
	}
}
$query.=',acadload) values(';
$regno=$_POST['regno'];
$query.="'$regno'";
$query.=",";
$name=$_POST['name'];
$query.="'$name'";
$query.=",";
if(isset($_POST['role']))
{
	$role=$_POST['role'];
	$query.="'$role'";
}
else
	$query.="''";
$query.=",";
if(isset($_POST['contactno']))
{
	$contactno=$_POST['contactno'];
	$query.="'$contactno'";
}
else
	$query.="''";
$query.=",";
$i=1;
$noclasses=0;
$acadload=0;
for($i=1;$i<=5;$i++){
	$till=11;
	if($i==3)
		$till=8;
	for($j=0;$j<=$till;$j++)
	{
		$idd=$i*100 + $j;
		$idd='a'.$idd;
		if(isset($_POST[$idd]) && !empty($_POST[$idd]))
		{
			$validd=$_POST[$idd];
			$query.="$validd";
			if($validd==1)
				$noclasses+=1;
		}
		else
			$query.="0";
		if($i==5 && $j==11)
		{
			$acadload=$noclasses/12 *100;
			$query.=",$acadload);";
		}
		else
			$query.=",";
	}
}
$result=mysqli_query($connection,$query);
if(!($result))
	$_SESSION['regerror']="Sorry, some problem occurred. Couldn't update. Try some other entry.";
else
	$_SESSION['regerror']="<span class='green'>successfully updated information of {$name}({$regno}). Go ahead with another entry!</span>";
header("Location:register.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Who is free? | register</title>
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
		td:hover{
			cursor: pointer;
			background-color: #d2cece;
		}
		.instructions-div{
			background-color: #eee;
			padding: 1rem;
		}

	</style>
</head>
<body>
	<h2 class="text-center">Register</h2>
	<h4 class="text-center">Enter timetable details of a student. Just click on the classes occupied.</h4>
	<div class="instructions-div">
		<h5><b>Instructions :</b></h5>
		<ul class="instructions-ul">
			<li>Enter the name, reg. no. and click on the classes which are occupied. Other fields are optional.</li>
			<li>Uploading the image of the timetable is optional, but recommended.</li>
			<li>To Change any information of a user like name, reg. no. , mobile no. , timetable image or timetable database, you have to enter the complete details once again with the correct registration number. This will update the previous record.</li>
			<li>To delete a user entirely from the database, <a href="deleteuser.php">click here</a>.
			</li>
		</ul>
	</div>

</ul>
<div class="col-sm-12">
	<form action="register.php" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="text-center">
				<h3 class="red text-center">
					<?php
					if(isset($_SESSION['regerror']))
					{
						echo $_SESSION['regerror'];
						
					}
					?>
				</h3>
			</div>
			<br>
			<div class="form-group">
				<label class="control-label col-sm-2">Name:<span class="red">*</span></label>
				<div class="col-sm-4">
					<input required type="text" placeholder="Name (required)" name="name" class="form-control">
				</div>
				<label class="control-label col-sm-2">Regno:<span class="red">*</span></label>
				<div class="col-sm-4">
					<input required type="text" placeholder="Regno (required)" name="regno" class="form-control">
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-sm-2">role in chapter:</label>
				<div class="col-sm-4">
					<input type="text" placeholder="Role (optional)" name="role" class="form-control">
				</div>
				<label class="control-label col-sm-2">Contact no:</label>
				<div class="col-sm-4">
					<input type="number" placeholder="contact no (optional)" name="contactno" class="form-control">
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<h5><b>Select the classes occupied:</b></h5>
			<div class="table-responsive">
				<table class="table table-bordered text-center searchtable">
					<tr>
						<th>Hours</th>
						<th>08:00 to 08:50 AM</th>
						<th>09:00 to 09:50 AM</th>
						<th>10:00 to 10:50 AM</th>
						<th>11:00 to 11:50 AM</th>
						<th>12:00 to 12:50 PM</th>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th rowspan="7" class="lunch"><span class="lunchtext">lunch</span></th>
						<th>02:00 to 02:50 PM</th>
						<th>03:00 to 03:50 PM</th>
						<th>04:00 to 04:50 PM</th>
						<th>05:00 to 05:50 PM</th>
						<th>06:00 to 06:50 PM</th>
						<th>&nbsp;&nbsp;</th>
					</tr>
					<tr>
						<th>Lab Hours</th>
						<th>08:00 to 08:50 AM</th>
						<th>09:00 to 09:50 AM</th>
						<th>10:00 to 10:50 AM</th>
						<th>11:00 to 11:50 AM</th>
						<th>11:50 to 12:40 PM</th>
						<th>12:40 to 01:30 PM</th>
						<th>02:00 to 02:50 PM</th>
						<th>03:00 to 03:50 PM</th>
						<th>04:00 to 04:50 PM</th>
						<th>05:00 to 05:50 PM</th>
						<th>05:50 to 06:40 PM</th>
						<th>06:40 to 07:30 PM</th>
					</tr>
					<!--Monday-->
					<tr>
						<th>Monday</th>
						<td class="tdclick" id="100" onclick="cliked(100)">A1/L1</td>
						<td class="tdclick" id="101" onclick="cliked(101)">F1/L2</td>
						<td class="tdclick" id="102" onclick="cliked(102)">D1/L3</td>
						<td class="tdclick" id="103" onclick="cliked(103)">TB1/L4</td>
						<td class="tdclick" id="104" onclick="cliked(104)">TG1/L5</td>
						<td class="tdclick" id="105" onclick="cliked(105)">L6</td>
						<td class="tdclick" id="106" onclick="cliked(106)">A2/L31</td>
						<td class="tdclick" id="107" onclick="cliked(107)">F2/L32</td>
						<td class="tdclick" id="108" onclick="cliked(108)">D2/L33</td>
						<td class="tdclick" id="109" onclick="cliked(109)">TB2/L34</td>
						<td class="tdclick" id="110" onclick="cliked(110)">TG2/L35</td>
						<td class="tdclick" id="111" onclick="cliked(111)">L36</td>
					</tr>
					<!--Tuesday-->
					<tr>
						<th>Tuesday</th>
						<td class="tdclick" id="200" onclick="cliked(200)">B1/L7</td>
						<td class="tdclick" id="201" onclick="cliked(201)">G1/L8</td>
						<td class="tdclick" id="202" onclick="cliked(202)">E1/L9</td>
						<td class="tdclick" id="203" onclick="cliked(203)">TC1/L10</td>
						<td class="tdclick" id="204" onclick="cliked(204)">TAA1/L11</td>
						<td class="tdclick" id="205" onclick="cliked(205)">L12</td>
						<td class="tdclick" id="206" onclick="cliked(206)">B2/L37</td>
						<td class="tdclick" id="207" onclick="cliked(207)">G2/L38</td>
						<td class="tdclick" id="208" onclick="cliked(208)">E2/L39</td>
						<td class="tdclick" id="209" onclick="cliked(209)">TC2/L40</td>
						<td class="tdclick" id="210" onclick="cliked(210)">TAA2/L41</td>
						<td class="tdclick" id="211" onclick="cliked(211)">L42</td>
					</tr>
					<!--Wednesday-->
					<tr>
						<th>Wednesday</th>
						<td class="tdclick" id="300" onclick="cliked(300)">C1/L13</td>
						<td class="tdclick" id="301" onclick="cliked(301)">A1/L14</td>
						<td class="tdclick" id="302" onclick="cliked(302)">F1</td>
						<td class="tdclick" colspan="3" class="extramural" style="background-color:#f2f2f2 !important;">Extramural hour</td>
						<td class="tdclick" id="303" onclick="cliked(303)">C2/L43</td>
						<td class="tdclick" id="304" onclick="cliked(304)">A2/L44</td>
						<td class="tdclick" id="305" onclick="cliked(305)">F2/L45</td>
						<td class="tdclick" id="306" onclick="cliked(306)">TD2/L46</td>
						<td class="tdclick" id="307" onclick="cliked(307)">TBB2/L47</td>
						<td class="tdclick" id="308" onclick="cliked(308)">L42</td>
					</tr>
					<!--thursday-->
					<tr>
						<th>thursday</th>
						<td class="tdclick" id="400" onclick="cliked(400)">D1/L19</td>
						<td class="tdclick" id="401" onclick="cliked(401)">B1/L20</td>
						<td class="tdclick" id="402" onclick="cliked(402)">G1/L21</td>
						<td class="tdclick" id="403" onclick="cliked(403)">TE1/L22</td>
						<td class="tdclick" id="404" onclick="cliked(404)">TCC1/L23</td>
						<td class="tdclick" id="405" onclick="cliked(405)">L24</td>
						<td class="tdclick" id="406" onclick="cliked(406)">D2/L49</td>
						<td class="tdclick" id="407" onclick="cliked(407)">B2/L50</td>
						<td class="tdclick" id="408" onclick="cliked(408)">G2/L51</td>
						<td class="tdclick" id="409" onclick="cliked(409)">TE2/L52</td>
						<td class="tdclick" id="410" onclick="cliked(410)">TCC2/L53</td>
						<td class="tdclick" id="411" onclick="cliked(411)">L54</td>
					</tr>
					<!--Friday-->
					<tr>
						<th>Friday</th>
						<td class="tdclick" id="500" onclick="cliked(500)">E1/L25</td>
						<td class="tdclick" id="501" onclick="cliked(501)">C1/L26</td>
						<td class="tdclick" id="502" onclick="cliked(502)">TA1/L27</td>
						<td class="tdclick" id="503" onclick="cliked(503)">TF1/L28</td>
						<td class="tdclick" id="504" onclick="cliked(504)">TD1/L29</td>
						<td class="tdclick" id="505" onclick="cliked(505)">L30</td>
						<td class="tdclick" id="506" onclick="cliked(506)">E2/L55</td>
						<td class="tdclick" id="507" onclick="cliked(507)">C2/L56</td>
						<td class="tdclick" id="508" onclick="cliked(508)">TA2/L57</td>
						<td class="tdclick" id="509" onclick="cliked(509)">TF2/L58</td>
						<td class="tdclick" id="510" onclick="cliked(510)">TDD2/L59</td>
						<td class="tdclick" id="511" onclick="cliked(511)">L60</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row">
			<!--Monday-->
			<div class="hidden">
				<input type="number" name="a100" id="6100" class="form-control">
				<input type="number" name="a101" id="6101" class="form-control">
				<input type="number" name="a102" id="6102" class="form-control">
				<input type="number" name="a103" id="6103" class="form-control">
				<input type="number" name="a104" id="6104" class="form-control">
				<input type="number" name="a105" id="6105" class="form-control">
				<input type="number" name="a106" id="6106" class="form-control">
				<input type="number" name="a107" id="6107" class="form-control">
				<input type="number" name="a108" id="6108" class="form-control">
				<input type="number" name="a109" id="6109" class="form-control">
				<input type="number" name="a110" id="6110" class="form-control">
				<input type="number" name="a111" id="6111" class="form-control">

				<!--Tuesday-->
				<input type="number" name="a200" id="6200" class="form-control">
				<input type="number" name="a201" id="6201" class="form-control">
				<input type="number" name="a202" id="6202" class="form-control">
				<input type="number" name="a203" id="6203" class="form-control">
				<input type="number" name="a204" id="6204" class="form-control">
				<input type="number" name="a205" id="6205" class="form-control">
				<input type="number" name="a206" id="6206" class="form-control">
				<input type="number" name="a207" id="6207" class="form-control">
				<input type="number" name="a208" id="6208" class="form-control">
				<input type="number" name="a209" id="6209" class="form-control">
				<input type="number" name="a210" id="6210" class="form-control">
				<input type="number" name="a211" id="6211" class="form-control">

				<!--Wednesday-->
				<input type="number" name="a300" id="6300" class="form-control">
				<input type="number" name="a301" id="6301" class="form-control">
				<input type="number" name="a302" id="6302" class="form-control">
				<input type="number" name="a303" id="6303" class="form-control">
				<input type="number" name="a304" id="6304" class="form-control">
				<input type="number" name="a305" id="6305" class="form-control">
				<input type="number" name="a306" id="6306" class="form-control">
				<input type="number" name="a307" id="6307" class="form-control">
				<input type="number" name="a308" id="6308" class="form-control">

				<!--Thursday-->
				<input type="number" name="a400" id="6400" class="form-control">
				<input type="number" name="a401" id="6401" class="form-control">
				<input type="number" name="a402" id="6402" class="form-control">
				<input type="number" name="a403" id="6403" class="form-control">
				<input type="number" name="a404" id="6404" class="form-control">
				<input type="number" name="a405" id="6405" class="form-control">
				<input type="number" name="a406" id="6406" class="form-control">
				<input type="number" name="a407" id="6407" class="form-control">
				<input type="number" name="a408" id="6408" class="form-control">
				<input type="number" name="a409" id="6409" class="form-control">
				<input type="number" name="a410" id="6410" class="form-control">
				<input type="number" name="a411" id="6411" class="form-control">

				<!--Friday-->
				<input type="number" name="a500" id="6500" class="form-control">
				<input type="number" name="a501" id="6501" class="form-control">
				<input type="number" name="a502" id="6502" class="form-control">
				<input type="number" name="a503" id="6503" class="form-control">
				<input type="number" name="a504" id="6504" class="form-control">
				<input type="number" name="a505" id="6505" class="form-control">
				<input type="number" name="a506" id="6506" class="form-control">
				<input type="number" name="a507" id="6507" class="form-control">
				<input type="number" name="a508" id="6508" class="form-control">
				<input type="number" name="a509" id="6509" class="form-control">
				<input type="number" name="a510" id="6510" class="form-control">
				<input type="number" name="a511	" id="6511" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label class="control-label col-sm-4">Upload the timetable image(optional):</label>
				<div class="col-sm-8">
					<input type="file" class="" name="fileToUpload" id="fileToUpload">
				</div>
			</div>
		</div>
		<h4 class="text-center">please register wisely. Data you enter will directly change the details in database. If you entered some wrong information, please enter once more with the same reg no and with the correct timetable.</h4>
		<button name="regsubmit" class="col-xs-12 col-sm-2 col-sm-offset-5 btn btn-success" type="submit">Register</button>
	</form>
</div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/clickcolor.js"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-81239297-2', 'auto');
	ga('send', 'pageview');

</script>
<script type="text/javascript">
	// function finduser(){
	// 	var regno=$("#regnoform").val();
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "searchusersubmit.php",
	// 		data: dataString,
	// 		cache: false,
	// 		success: function(result){
	// 			alert(result);
	// 		}
	// 	});
	// }
</script>
</body>
</html>