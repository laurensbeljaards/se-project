<?php
require_once('config.php');
$page = $_SESSION['page'] = 'leaderbord';

/*if(!$loggedInStudent || !$loggedInTeacher){
	//error if student is not logged in
	header('Location: login.php');
}*/

include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}


?>

<div class="extrainfoheader_docent">
	<div class="extrainfosub_docent">
		<h5>Leaderboard:  </h5>
    </div>

    <tr>
		<li><a href="#">XX</a></li>
		<li><a href="#">XX</a></li>
	</tr>
    
</div>

<br />
<h1>Leaderboard: </h1>
<hr class="hr"/><hr class="hr"/>
<br />

<div class="maininfo" style="magin-left: 20%;">

<label class="leaderboard_label">Rank </label><label class="leaderboard_label_name">Name</label>Points
<br /><br />

</div>

<?php

$sql = "SELECT username, SUM(value) FROM `student_badge` S, `badges` B WHERE S.badgeid = B.badgeid GROUP BY `username` ORDER BY SUM(value) DESC";
$get_points = $conn->query($sql);
$rank = 1;
if($get_points->num_rows > 0){
	while($row = $get_points->fetch_assoc()){ 
		$name = $row["username"];
		$points = $row["SUM(value)"];

		$sql2 = "SELECT * FROM users WHERE username = '$name'";
		$get_names = $conn->query($sql2);
		$row2 = $get_names->fetch_assoc();
		$firstname = $row2["firstname"];
		$lastname = $row2["lastname"];

		if($rank == 1){
			?>
			<label class="leaderboard_label"><h1>1.</h1> </label><label class="leaderboard_label_name"><h3><?php echo $firstname."  ".$lastname; ?></h3></label> <?php echo $points; ?>
			<hr class="leaderboard_hr"/>
			<?php
			$rank = $rank + 1;
		}else{
			?>
			<label class="leaderboard_label"><h3><?php echo $rank; ?>.</h3> </label><label class="leaderboard_label_name"><h3><?php echo $firstname."  ".$lastname; ?></h3></label> <?php echo $points; ?>
			<hr class="leaderboard_hr"/>
			<?php
			$rank = $rank + 1;
		}


	}
}

?>

<?php
// SELECT username, SUM(value) FROM `student_badge` S, `badges` B WHERE S.badgeid = B.badgeid GROUP BY `username`
?>