<?php
require_once($BASEDIR . 'config.php');

include 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$mysqli->connect_error);
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
				<li><a href=<?php echo "#"; ?>><?php echo $row["naam"].' van '.$row["student_id"]; ?></a></li>
			</tr>
			<?php
		}
	}else{
		echo "<tr><td>Geen opdrachten om na te kijken!</td></tr>";
	}
	?>
	
</div>

<div>
Hier moet allemaal een nakijkvenster komen waar de code in komt te staan van de student met een feedback dingetje.
</div>