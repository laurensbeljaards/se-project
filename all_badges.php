<?php
require_once('config.php');
$page = $_SESSION['page'] = 'badges';

if(!$loggedInStudent){
	//error if student is not logged in
	header('Location: login.php');
}

include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}

$sql = "SELECT * FROM badges";
$get_badges = $conn->query($sql);

?>

<div class="extrainfoheader_docent">
	<div class="extrainfosub_docent">
		<h5>Badges:  </h5>
    </div>

    <tr>
		<li><a href="my_badges.php">Mijn Badges</a></li>
		<li><a href="all_badges.php">Alle Badges</a></li>
	</tr>
    
</div>

<br />
<h1>Alle Badges: </h1>
<hr class="hr"/>
<br />


<div class="maininfo">

<?php
if($get_badges->num_rows > 0){
	while($row = $get_badges->fetch_assoc()){
?>

	<div class="badge_display">
		<div class="badge_pic">
			<img src="<?php echo $RELPATH;?>Badges/<?php echo $row["badgeid"]; ?>.jpg" />
		</div>
		<div class="badge_description">
			<h2><?php echo $row["name"]; ?></h2>
			<?php echo $row["description"]; ?>
		</div>
	</div>


<?php
	}
}
?>

</div>