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

<script src="<?php echo $RELPATH . 'script.js'; ?>"></script>
<div class="badge-shell">
    <div class="badgeBar" id="badgeBar"></div>
</div>
<script>
    fillBadgeBar();
</script>
<div id='cssmenu'>
    <ul>
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='index.php'>leerlingen</a></li>
        <li><a href='docent_opdr.php'>Leraar</a></li>
        <li><a href='#'>Opdrachten</a></li>
        <li><a href='#'>Achievements</a></li>
        <li><a href='#'>About C Sharper</a></li>
		<?php 
		if($loggedInStudent == 1){ 
		?> <li><a href='logout.php'>
		<?php echo "Logged in as " . $username . ", click here to logout"; ?> </a></li> 
		<?php }else if($loggedInTeacher == 1){ 
		?> <li><a href='logout.php'>
		<?php echo "Logged in as " . $username . ", click here to logout"; ?> </a></li> 
		<?php }
		else{ 
		?> <li><a href='login.php'>Login</a></li> 
		<?php } ?>
		<?php
		if (isset($_COOKIE["studentid"])) {
			echo 'User: &#39;' . htmlspecialchars($_COOKIE["studentid"]) . '&#39; selected (<a href="changeuser.php">change</a>)';
		} else {
			echo 'No users selected. Go to <a href="changeuser.php">this</a> page to select a user.';
		}
		?>
    </ul>
</div>

<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<script src="script.js" type="text/javascript"></script>