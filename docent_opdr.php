<?php
require_once('config.php');

if(!$loggedInTeacher){
	//als geen docent weergeef error
	header('Location: 404.php');
}

include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$mysqli->connect_error);
}

$sql = "SELECT * FROM opdrachten";
$allAssignments = $conn->query($sql);

if (isset($_GET["opdr"])) {
	$opdrid = $_GET["opdr"];
} else {
	$opdrid = 0;
}

//$assignmentDetails contains all details of the assignment
$opdrid = $conn->real_escape_string($opdrid);
$sql = "SELECT * FROM opdrachten WHERE id = '$opdrid'";
$sqlresult = $conn->query($sql);
$assignmentDetails = $sqlresult->fetch_assoc();
$name = $assignmentDetails["naam"];
$description = $assignmentDetails["description"];
$level = $assignmentDetails["moeilijkheidsgraad"];
$category = $assignmentDetails["categorie"];
$requirements = $assignmentDetails["requirements"];
$template = $assignmentDetails["templatecode"];
$youtubeId = $assignmentDetails["youtubeid"];

$sql_delete = "DELETE FROM opdrachten WHERE id = '$opdrid'"; 

//Check if delete button is pressed
if(isset($_POST['deleteAccepted'])){
	$conn->query($sql_delete);
	echo $conn->error;
	$name = "";
	$description = "";
	$level = "";
	$category = "";
	$requirements = "";
	$template = "";
	$youtubeId = "";
	header("refresh:0;url=docent_opdr.php");
}

//Check if Save button is pressed
if(isset($_POST['submitAll'])) {
	if(isset($_POST['name'])){
		$name = $_POST['name'];
		$sql = "UPDATE opdrachten SET naam = '{$name}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['description'])) {
		$description = $_POST['description'];
		$sql = "UPDATE opdrachten SET description = '{$description}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['level'])) {
		$level = $_POST['level'];
		$sql = "UPDATE opdrachten SET moeilijkheidsgraad = '{$level}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['category'])) {
		$category = $_POST['category'];
		$sql = "UPDATE opdrachten SET categorie = '{$category}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['requirements'])) {
		$requirements = $_POST['requirements'];
		$sql = "UPDATE opdrachten SET requirements = '{$requirements}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['template'])) {
		$template = $_POST['template'];
		$sql = "UPDATE opdrachten SET templatecode = '{$template}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
	if(isset($_POST['youtubeId'])) {
		$youtubeId = $_POST['youtubeId'];
		$sql = "UPDATE opdrachten SET youtubeid = '{$youtubeId}' WHERE id = '{$opdrid}'";
		$conn->query($sql); //update the database
	}
}

mysqli_close($conn);
?>

<div class="extrainfoheader_docent">
	<div class="extrainfosub_docent">
		<h5>Opdrachten: <small><a href="newassignment.php" style="color: #B30000; float: right; margin-top: 3px;">Opdracht toevoegen</a></small> </h5>
    </div>

    <?php
    if($allAssignments->num_rows > 0){
		while($row = $allAssignments->fetch_assoc()){
			?>
			<tr>
				<li><a href=<?php echo "docent_opdr.php?opdr="; echo $row["id"]; ?>><?php echo $row["naam"]; ?></a></li>
			</tr>
			<?php
		}
	}else{
		echo "<tr><td>Nog geen opdrachten ingevoerd</td></tr>";
	}
	?>
</div>

<br />
<h1>Opdracht Wijzigen: </h1>
<hr class="hr"/>
<br />
<?php
if($opdrid != 0){
	
	?>
	<form action="" name="formvalues" method="post">

	<label>Naam</label>:	<input type="text" name="name" value="<?php echo $name; ?>"/>
	<br />
	<label>Ondertitel</label>:	<input type="text" name="description" value="<?php echo $description; ?>"/>	
	<br />
	<label>Moeilijkheidsgraad</label>:	<input type="text" name="level" value="<?php echo $level; ?>"/>
	<br />
	<label>Categorie</label>:	<input type="text" name="category" value="<?php echo $category; ?>"/>
	<br />
	<label>Requirements</label>:	<textarea rows="5" cols="10" name="requirements" id="textarea" class="codetextarea_docent"><?php echo $requirements; ?></textarea>
	<br />
	<label>Youtube-ID</label>:	<input type="text" name="youtubeId" value="<?php echo $youtubeId; ?>"/>
	<br />

	<label>Template code</label>:
	<textarea rows="5" cols="10" name="template" id="textarea" class="codetextarea_docent"><?php echo $template; ?></textarea>
	<br />
	<br />

	<input type="submit" name="submitAll" value="Save" />
	<br />
	</form>
	<br />
	
	<form action="" method="POST" style="float: left;">
		<input type="submit" name="deleteAccepted" value="DELETE">
	</form>
<?php
}else{
	echo "Selecteer een opdracht!";
}
?>
