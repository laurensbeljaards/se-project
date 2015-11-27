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

$sql = "SELECT * FROM student_badge WHERE username = $username";
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
<h1>Mijn Badges: </h1>
<hr class="hr"/>
<br />