<?php
//$loggedInStudent = 0;
//$loggedInDocent = 0;
//$page = $_SESSION['page'] = '1';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <title>C sharper</title>
</head>

<body>
<?php 
	//if the student is logged in go into the database and load all his badges
	if($loggedInStudent == 1){
		$conn = new mysqli($server, $usernamedb, $passworddb, $database);
		if($conn->connect_errno) {
			die('Could not connect: ' .$conn->connect_error);
		}
		$sql = "SELECT badgeid FROM student_badge WHERE username = '$username'";
		$sqlBadges = $conn->query($sql);
		$numberOfBadges = $sqlBadges->num_rows;
		$badges;
		if ($sqlBadges->num_rows > 0) {
            for($i=0; $i<$numberOfBadges; $i++){
				$badgesSql = $sqlBadges->fetch_assoc();
				$badges[$i] = $badgesSql["badgeid"];
			}
		}
		mysqli_close($conn);
?>
<div class="badge-shell">
    <div class="badgeBar" id="badgeBar"></div>
</div>
<script>
function fillBadgeBar() { //fills the badgebar according to the data from the database (above php code)
    <?php for($i = 0; $i < 20; $i++) { ?>
        var li = document.createElement("li");
        li.className = "badge";
        var badgeBar = document.getElementById("badgeBar");
        <?php if ($i < $numberOfBadges) { ?>
            li.style.backgroundImage = 'url(Badges/'+<?php echo $badges[$i]; ?>+'.jpg)';
        <?php } else { ?>
            li.style.backgroundImage = 'url(Badges/Locked_Icon.jpg)';
        <?php } ?>
        badgeBar.appendChild(li);
    <?php } ?>
}
fillBadgeBar(); //call the function
</script>
<?php }//if logged in as student ?>



<div id='cssmenu'>
    <ul>
    <?php
    if($loggedInStudent){
        ?>
        <li><a href='#'>Home</a></li>
        <li <?php if($page == "opdrachten")echo"class='active'"; ?> ><a href='index.php'>Opdrachten</a></li>
        <li <?php if($page == "achievements")echo"class='active'"; ?> ><a href='#'>Achievements</a></li>


        <?php 
        if($loggedInStudent == 1){ 
        ?> <li><a href='logout.php'>
        <?php echo "Logged in as " . $username . ", Log uit"; ?> </a></li> 
        <?php }else if($loggedInTeacher == 1){ 
        ?> <li><a href='logout.php'>
        <?php echo "Logged in as " . $username . ", Log uit"; ?> </a></li> 
        <?php }
        else{ 
        ?> <li><a href='login.php'>Login</a></li> 
        <?php } ?>



        <?php

    }else if($loggedInTeacher){
        ?>
        <li><a href='#'>Home</a></li>
        <li <?php if($page == "docent_opdr")echo"class='active'"; ?> ><a href='docent_opdr.php'>Opdrachten</a></li>
		<li <?php if($page == "checkassignments")echo"class='active'"; ?> ><a href='checkassignments.php'>Nakijken</a></li>

        <?php 
        if($loggedInStudent == 1){ 
        ?> <li><a href='logout.php'>
        <?php echo "Logged in as " . $username . ", Log uit"; ?> </a></li> 
        <?php }else if($loggedInTeacher == 1){ 
        ?> <li><a href='logout.php'>
        <?php echo "Logged in as " . $username . ", Log uit"; ?> </a></li> 
        <?php }
        else{ 
        ?> <li><a href='login.php'>Login</a></li> 
        <?php } ?>
        <?php

    }else{
        ?>
        <li><a href='#'>Home</a></li>
        <li <?php if($page == "registreren")echo"class='active'"; ?> ><a href='login.php'>Registreren / Aanmelden</a></li>
        <li><a href='#'>About C Sharper</a></li>
        <?php
    }
    ?>
    </ul>
</div>

<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<script src="script.js" type="text/javascript"></script>