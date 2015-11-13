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

	if (isset($_POST["checkAssignment-submit"])) {
        
        $sql = "SELECT * FROM `Feedback` WHERE `username` = '" . $student_username . "' AND `opdracht_id` = " . $opdracht_id . ";";
        if ($conn->query($sql)->num_rows > 0) {//if exists already
            $sql = "UPDATE `Feedback` SET `layout` = " . ((isset($_POST['checkAssignment-layout'])) ? 1 : 0) . ", `werkt` = " . ((isset($_POST['checkAssignment-werkt'])) ? 1 : 0) . ", `testdata` = " . ((isset($_POST['checkAssignment-testdata'])) ? 1 : 0) . ", `overig` = " . ((isset($_POST['checkAssignment-overig'])) ? 1 : 0) . " WHERE `feedback`.`username` = '" . $student_username . "' AND `feedback`.`opdracht_id` = " . $opdracht_id . ";";
        } else {
            $sql = "INSERT INTO `Feedback` (`username`, `opdracht_id`, `layout`, `werkt`, `testdata`, `overig`) VALUES ('" . $student_username . "', " . $opdracht_id . ", " . ((isset($_POST['checkAssignment-layout'])) ? 1 : 0) . ", " . ((isset($_POST['checkAssignment-werkt'])) ? 1 : 0) . ", " . ((isset($_POST['checkAssignment-testdata'])) ? 1 : 0) . ", " . ((isset($_POST['checkAssignment-overig'])) ? 1 : 0) . ");";
        }
        $checked = $conn->query($sql);
    }
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
<form method="post" style="margin-top:5px;" name="checkAssignment">
<!--Allows the teacher to check a student's assignment by marking a box for each criteria that was sufficiently done-->
    <input type="submit" value="Sla beoordeling op" name="checkAssignment-submit">
    <input type="checkbox" style="margin-left:12px;" name="checkAssignment-layout"> Layout voldoende
    <input type="checkbox" style="margin-left:12px;" name="checkAssignment-werkt"> Werkt
    <input type="checkbox" style="margin-left:12px;" name="checkAssignment-testdata"> Testdata
    <input type="checkbox" style="margin-left:12px;" name="checkAssignment-overig"> Overig
</form>
</br>

<div>
<?php
	if(isset($_GET['opdr']) && isset($_GET['student'])){
		$rowcode = $usercode->fetch_assoc();
		?><textarea rows="25" cols="85" name="userCode" id="textarea" class="codetextarea" form="submitCode"><?php echo $rowcode["code"]; ?></textarea><?php
	}
?>
</div>