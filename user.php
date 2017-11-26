<?php
session_start();
require('functions.php');
make_connection();
if($_SESSION['user']!='user'){
	$_SESSION['errors']="please log in first.";
	header("Location: login-pravega.php");
}
$timetable_db_name='timetable';
$notices_db_name="notices";
$current_user_password="";
$current_admin_password="";
if($_SESSION['database']=='pravega'){
	$timetable_db_name="pravega_timetable";
	$notices_db_name="pravega_notices";
	$current_user_password=get_current_user_password_pravega();
	$current_admin_password=get_current_admin_password_pravega();
}
elseif($_SESSION['database']=='acm'){
	$timetable_db_name="timetable";
	$notices_db_name="notices";
	$current_user_password=get_current_user_password_acm();
	$current_admin_password=get_current_admin_password_acm();
}

if(isset($_POST['searchsubmit'])){
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_connect_error());
	}
	$num=0;//no of classes user has clicked
	$i=1;//to go through all table field
	$slots_selected=array();
	$query="";
	for($i=1;$i<=5;$i++){
		$till=11;
		if($i==3)
			$till=9;
		for($j=0;$j<=$till;$j++)
		{
			$idd=$i*100 + $j;
			$idd_without_a=$idd;
			$idd='a'.$idd;
			if(isset($_POST[$idd]) && $_POST[$idd]==1)
			{
				$slots_selected[]=$idd_without_a;
				$num++;
				if($num==1)
					$query="select name,regno,contactno,role,acadload from ".$timetable_db_name." where $idd=0";
				else
					$query.=" and $idd=0";
			}
		}
	}
	if($num==0)
		$query="select name,regno,contactno,role,acadload from ".$timetable_db_name.";";
	else
		$query.=" order by name asc;";
	$result=mysqli_query($connection,$query);
}
if(isset($_POST['updatepasswordsubmit'])){
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_connect_error());
	}
	$user_password=$_POST['user_password'];
	$admin_password=$_POST['admin_password'];
	if($_SESSION['database']=='acm')
		update_password_acm($user_password,$admin_password);
	elseif($_SESSION['database']=='pravega')
		update_password_pravega($user_password,$admin_password);
	header("Location:user.php");

}
if(isset($_POST['deletenotice'])){
	if(mysqli_connect_errno()){
		die("Database connection failed:".mysqli_connect_error());
	}
	$notice_id=$_POST['id_notice'];
	$query="DELETE FROM ".$notices_db_name." WHERE id='".$notice_id."';";
	global $connection;
	$result=mysqli_query($connection,$query);
	if($result)
		echo "<script>alert('Successfully deleted the notice')</script>";
	else
		echo "<script>alert('There was some problem deleting the notice')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Who is free? | user</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8">
	<meta name="author" content="Harshit Kedia">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<style>
		label{
			display: inline;
		}
		form.search{
			margin-top: 5vh;
		}
		#register iframe{
			width: 100%;
			min-height:1000px;
			border: none;
		}
		@media(max-width:400px){
			form.search button{
				margin-top: 10px;
			}
		}
		@media(max-width: 769px){
			#register iframe{
				width: 100%;
				min-height:1400px;
			}
		}
		/*cf3*/
		.searchtable td{
			background-color: #cf3;
		}
		.searchtable td:hover{
			cursor: pointer;
			background-color: #d2cece;
		}
		.red{
			color: red;
		}
		.notice{
			background-color: #f2f2f2;
			margin-bottom: 20px;
			padding: 5px;
		}
	</style>
	<script language="javascript" type="text/javascript">
		function resizeIframe(obj) {
		//obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	}
</script>
</head>
<body>
	<div class="container">
		<div class="contentmain">
			<br>
			<div class="row">
				<ul class="nav nav-tabs nav-justified">
					<li class="active"><a data-toggle="tab" href="#search">Search</a></li>
					<li><a data-toggle="tab" href="#timetables">timetables</a></li>
					<li><a data-toggle="tab" href="#notices">Notices</a></li>
					<?php
					$linkreg="#register";
					$datatoggle="data-toggle='tab'";
					if($_SESSION['admin']!=1){
						$linkreg='index.php?dispadmin=1';
						$datatoggle="";
					}
					?>
					<?php
					if($_SESSION['admin']==1)
					{
						?>
						<li><a data-toggle="tab" href="#register">Register</a></li>
						<li><a data-toggle="tab" href="#changepassword">Change Password</a></li>
						<?php
					}
					?>

				</ul>
			</div>
			<div class="tab-content">
				<div id="search" class="tab-pane fade in active">
					<div class="row">
						<h2 class="text-center">Search</h2>
						<h5><b>Select the class(or classes) of which you want to know free students:</b></h5>
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
									<td class="tdclick" id="309" onclick="cliked(309)" colspan="3" class="extramural">Extramural hour</td>
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
						<form method="post" action="user.php">
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
								<input type="number" name="a309" id="6309" class="form-control">

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
							<button name="searchsubmit" class="col-xs-12 col-sm-2 col-sm-offset-5 btn btn-success" type="submit">Search</button>
						</form>
					</div>
					<br><br>
					<div class="row">
						<div class="table-responsive col-md-8 col-md-offset-2">
							<?php
							$disp="block;";
							if(isset($_POST['searchsubmit'])){
								$disp="none;";
							}
							?>
							<span class="result red" id="results" style="<?php echo $disp; ?>">
							</span>
							<table class="table table-striped table-bordered table-hover" id="">
								<tr class="text-center">
									<th class="text-center">Name</th>
									<th class="text-center">Reg no</th>
									<th class="text-center">contact no</th>
									<th class="text-center">View Timetable</th>
									<?php
									$role_in_chap="";
									if($_SESSION['database']=='pravega'){
										$role_in_chap="Role in pravega";
									}
									if($_SESSION['database']=='acm'){
										$role_in_chap="Role in ACM";
									}
									?>
									<th><?php echo $role_in_chap;?></th>
								</tr>
								<?php
								if(isset($_POST['searchsubmit']))
								{
									$count=0;
									while($row=mysqli_fetch_assoc($result)){
										$count++;
										if($count==1)
											echo"<tr class='dyntr'>";
										$name=$row['name'];
										$regno=$row['regno'];
										$contactno=$row['contactno'];
										if(empty($contactno))
											$contactno="NA";
										$role=$row['role'];
										if(empty($role))
											$role="NA";
										echo"<td>$name</td>";
										echo"<td>$regno</td>";
										echo"<td>$contactno</td>";
										$ttpic="images/".$regno.".png";
										if(file_exists($ttpic))
											echo "<td><a href='$ttpic' target='_blank'>view</a></td>";
										else
											echo "<td>NA</td>";
										echo"<td>$role</td></tr>";
									}
								}
								?>
								<!-- <tr>
									<td>Vibhor Gupta</td>
									<td>15BCE0329</td>
									<td>60%</td>
									<td>9585602122</td>
									<td>Junior tech</td>
								</tr> -->
							</table>
						</div>
					</div>
				</div>
				<div id="timetables" class="tab-pane fade in">
					<h2 class="text-center">TimeTables</h2>
					<?php
					$querytt="SELECT name,regno FROM ".$timetable_db_name." order by name asc;";
					$resulttt=mysqli_query($connection,$querytt);
					$img_dir="";
					if($_SESSION['database']=='pravega'){
						$img_dir="pravega_images/";
					}
					if($_SESSION['database']=='acm'){
						$img_dir="images/";
					}
					if(!$resulttt)
					{
						echo "Error reading from database.";
					}
					else
					{
						echo "<ol>";
						while($row=mysqli_fetch_assoc($resulttt))
						{
							$pathtoimg=$img_dir;
							$pathtoimg.=$row['regno'].".png";

							echo "<li><div class='timetablediv'>";
							echo "<h4 class='timetablename'>";
							echo $row['name']."(".$row['regno'].")";
							echo "</h4>";
							if(file_exists($pathtoimg))
							{
								echo "<a href='";
								echo $pathtoimg;
								echo "' target='_blank'><img src='".$pathtoimg."' class='timetableimg'></a>";
							}
							else
								echo "No image available.";
							echo "</div> </li>";
						}
						echo "</ol>";
					}

					?>
				</div>
				<div id="notices" class="tab-pane fade in">
					<h2 class="text-center">Notices</h2>
					<h4 class="text-center">
						<?php
						if($_SESSION['admin']==1)
							echo"<button class='text-center btn btn-primary' data-toggle='modal' data-target='#postpop'>Post a new message</button>";
						?>
					</h4>
					<div id="postpop" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h3 class="modal-title text-center">Post a Notice</h3>
								</div>
								<div class="modal-body">
									<form action="postnotice.php" method="post">
										<div class="form-group">
											<label for="name" class="col-sm-2 control-label">Name<span class="red">*</span></label>
											<div class="col-sm-10">
												<input type="text" required placeholder="Your Name (required)" class="form-control" id="name" name="name">
											</div>
										</div>
										<br>
										<br><br>
										<div class="form-group">
											<label for="message" class="col-sm-2 control-label">Message<span class="red">*</span></label>
											<div class="col-sm-10">
												<textarea rows="7" class="form-control" id="message" placeholder="Post (required)" name="message"></textarea>
											</div>
										</div>
										<button type="submit" name="postsubmit" class="btn btn-primary">Submit</button>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>

						</div>
					</div>

					<?php
					$conpost=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
					if(mysqli_connect_errno()){
						die("Database connection failed:".mysqli_connect_error());
					}
					$queryy="select id,name,notice from ".$notices_db_name.";";
					$resultt=mysqli_query($conpost,$queryy);
					if(!($resultt)){
						die("Failed reading");
					}
					while($rowpost=mysqli_fetch_assoc($resultt))
					{
						$namepost=$rowpost['name'];
						$messagepost=$rowpost['notice'];
						$id_notice=$rowpost['id'];
						echo"<div class='notice'>";
						echo"<h4>Posted by $namepost</h4>";
						echo"<p>$messagepost</p>";
						if($_SESSION['admin']==1)
						{
							?>
							<form action='#' method='post' class='text-right' onsubmit="return confirm('Are you sure you want to delete?')">
								<input type='hidden' value="<?php echo $id_notice;?>" name="id_notice">
								<input type='submit' name='deletenotice' class='btn btn-danger text-right' value='delete'>
							</form>
							<?php
						}
						echo "</div>";
					}
					?>
				</div>
				<?php
				if($_SESSION['admin']==1)
				{
					?>
					<div id="register" class="tab-pane fade in">
						<iframe src="register.php" onload="resizeIframe(this)"></iframe>
					</div>
					<?php
				}
				?>

				<?php
				if($_SESSION['admin']==1)
				{
					?>
					<div id="changepassword" class="tab-pane fade in container">
						<br class="hidden-xs"><br class="hidden-xs">
						<form action="#" method="post" class="col-sm-6 col-sm-offset-3">
							<div class="form-group">
								<label for="user_password" class="col-sm-4 control-label">User Password</label>
								<div class="col-sm-8">
									<input type="text" placeholder="No Password" class="form-control" id="user_password" name="user_password" value="<?php echo $current_user_password;?>">
								</div>
							</div>
							<br class="hidden-xs">
							<div class="form-group">
								<label for="admin_password" class="col-sm-4 control-label">admin Password</label>
								<div class="col-sm-8">
									<input type="text" placeholder="No Password" class="form-control" id="admin_password" name="admin_password" value="<?php echo $current_admin_password;?>">
								</div>
							</div>
							<br class="hidden-xs"><br class="hidden-xs">
							<div class="col-xs-12">
								<button type="submit" name="updatepasswordsubmit" class="btn btn-primary" style="width: 100%;">Update Passwords</button>
							</div>
						</form>
						<br><br><br>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<footer>
			<div class="row">
				<div class="col-sm-4 contentdiv">
					<div class="content">
						<a href="logout.php" onclick="oncli()"><button class="btn btn-danger">Logout</button></a>
						<br>
						<a href="#myModal" data-toggle="modal">Report a bug</a>
					</div>
				</div>
				<div class="col-sm-4 contentdiv">
					<div class="content">
						<?php
						if($_SESSION['database']=='pravega')
						{
							?>
							<a href="http://pravegaracing.com" target="_blank"><img src="images/pravega.png" class="img-responsive img"></a>
							<?php
						}
						else
						{
							?>
							<a href="http://acmvit.com" target="_blank"><img src="images/acm.png" class="img-responsive img"></a>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-sm-4 contentdiv">
					<div class="content">
						<a href="http://acmvit.com" target="_blank"><p class="developed">developed by Harshit Kedia and Utkarsh Bajpai</p></a>
					</div>
				</div>
			</div>
		</footer>
	</div>
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
						<br>
						<br><br>
						<div class="form-group">
							<label for="message" class="col-sm-2 control-label">Message<span class="red">*</span></label>
							<div class="col-sm-10">
								<textarea rows="5" class="form-control" id="message" placeholder="things to want to say (required)" name="message"></textarea>
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
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/clickuser.js"></script>
	<script>
		var norows=document.getElementsByTagName('tr').length -8;
		<?php
		if(isset($_POST['searchsubmit']))
		{
		//convert ids to text and store in $idstotext
			$idstotext=ids_to_text($slots_selected);
			?>
			if(norows!=0)
			{
				document.getElementById('results').innerHTML="Found "+norows+" results <?php echo $idstotext;?>.";
			}
			else
				document.getElementById('results').innerHTML="Found 0 results <?php echo $idstotext;?>.";
			<?php
		}
		else
		{
			?>
			document.getElementById('results').innerHTML="Please select a slot from above.";
			<?php
		}
		?>

	</script>
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