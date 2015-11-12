<?php
//$loggedInStudent = 0;
//$loggedInDocent = 0;
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
<!--
<script src="<?php echo $RELPATH . 'script.js'; ?>"></script>
<div class="badge-shell">
    <div class="badgeBar" id="badgeBar"></div>
</div>
<script>
    fillBadgeBar();
</script>
-->


<div id='cssmenu'>
    <ul>
    <?php
    if($loggedInStudent){
        ?>
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='index.php'>Opdrachten</a></li>
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
        echo " Ingelogd als Student.";
    }else if($loggedInTeacher){
        ?>
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='docent_opdr.php'>Opdrachten</a></li>
		<li><a href='checkassignments.php'>Nakijken</a></li>
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
        echo " Ingelogd als Docent.";
    }else{
        ?>
        <li class='active'><a href='#'>Home</a></li>
        <li><a href='login.php'>Registreren / Aanmelden</a></li>
        <li><a href='#'>About C Sharper</a></li>
        <?php
    }
    ?>
    </ul>
</div>

<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
<script src="script.js" type="text/javascript"></script>