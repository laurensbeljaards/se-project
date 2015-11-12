<?php
require_once('config.php');

include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$mysqli->connect_error);
}

if(isset($_GET['opdr']) && isset($_GET['student'])){
	$opdracht_id = $_GET['opdr'];
	$student_username = $_GET['student'];
	$sql_1opdr = "SELECT code FROM `student_opdracht` WHERE `opdracht_id` = " . $opdracht_id ." AND `username` = '". $student_username . "'";
	$result_1opdr = $conn->query($sql_1opdr);
}

$sql_opdr = "SELECT * FROM `student_opdracht`, `opdrachten` WHERE `readytocheck` = 1 AND `student_opdracht`.`opdracht_id` = `opdrachten`.`id` ORDER BY `handintimestamp` ASC";
$result_opdr = $conn->query($sql_opdr);

	mysqli_close($conn);
?>

<div class="extrainfoheader_docent">
	<!-- <div style='margin-top: 40px;'>&nbsp</div> -->

	<div class="extrainfosub_docent">
		<h5>Na te kijken opdrachten:</h5>
    </div>

    <?php
    if($result_opdr->num_rows > 0){
		while($row = $result_opdr->fetch_assoc()){
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
		$rowcode = $result_1opdr->fetch_assoc();
		echo $rowcode["code"];
	}
?>
</div>