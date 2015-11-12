<?php
require_once('config.php');

include $BASEDIR . 'header/header.php';

if(!$loggedInTeacher){
	//als geen docent weergeef error
	header('Location: 404.php');
}

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$mysqli->connect_error);
}

//Check if parameters are set and get usercode for selected assignment
if(isset($_GET['opdr']) && isset($_GET['student'])){
	$opdracht_id = $conn->real_escape_string($_GET['opdr']);
	$student_username = $conn->real_escape_string($_GET['student']);
	
	$sql = "SELECT code FROM `student_opdracht` WHERE `opdracht_id` = '$opdracht_id' AND `username` = '$student_username'";
	$usercode = $conn->query($sql);
}


$sql = "SELECT * FROM `student_opdracht`, `opdrachten` WHERE `readytocheck` = 1 AND `student_opdracht`.`opdracht_id` = `opdrachten`.`id` ORDER BY `handintimestamp` ASC";
$assignmentsList = $conn->query($sql);

mysqli_close($conn);
?>

<div class="extrainfoheader_docent">
	<!-- <div style='margin-top: 40px;'>&nbsp</div> -->

	<div class="extrainfosub_docent">
		<h5>Na te kijken opdrachten:</h5>
    </div>

    <?php
    if($assignmentsList->num_rows > 0){
		while($row = $assignmentsList->fetch_assoc()){
			?>
			<tr>
				<li><a href=<?php echo "checkassignments.php?opdr=".$row["id"]."&student=" . $row ["username"]; ?>><?php echo $row["naam"].' van '.$row["username"]; ?></a></li>
			</tr>
			<?php
		}
	}else{
		echo "<tr><td>Geen opdrachten om na te kijken!</td></tr>";
	}
	?>
	
</div>

<div>
<?php
	if(isset($_GET['opdr']) && isset($_GET['student'])){
		$rowcode = $usercode->fetch_assoc();
		echo $rowcode["code"];
	}
?>
</div>