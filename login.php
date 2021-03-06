<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/main_login.css">
<title>Login</title>
</head>
<body>
<?php
$loggedInStudent = 0;
$loggedInTeacher = 0;
require_once('config.php');
//include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}

if (!empty($_POST['submit'])){
	//trying to log in as student
	$username = "notexist";
	$password = "notexisttoo";
	
	if (isset($_POST['username']) && isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
	}
	
	$username = $conn->real_escape_string($username);
	$password = $conn->real_escape_string($password);
	$sql = "SELECT * from users WHERE username = '$username' AND password = '$password' LIMIT 1";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$isTeacher = $row["isTeacher"]; //als isTeacher=1 dan is docent, als isTeacher=0 dan student

	//echo $isTeacher;

	//the user didnt enter an username with password that exists in our databse
	if (!$result->num_rows == 1) { 
		echo "<font color='white'><h3>Invalid username/password combination</h3></font>"; 
	}
	//in this case the user did enter a right pair of password+username
	else { 
		echo "<font color='white'><h3>Logged in successfully.<br>You are being redirected to the index page....</h3></font>";
		//and is now loggedin as student
		//$loggedInStudent = '1'; 
		//$loggedInTeacher = '0';

		if($isTeacher){
			//docent
			$_SESSION['loggedInStudent'] = '0'; 
			$_SESSION['loggedInTeacher'] = '1';
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:2;url=docent_opdr.php");	
		}else{
			//student
			$_SESSION['loggedInStudent'] = '1'; 
			$_SESSION['loggedInTeacher'] = '0';
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:2;url=index.php");	
		}	
	}
}
if($loggedInStudent == 0 && $loggedInTeacher == 0){ ?>

<form id="login-form" class="login-form" name="form1" method="post" action="login.php">
	    	<input type="hidden" name="is_login" value="1">
	        <div class="h1">Login</div>
	     	<div style="margin-left: 60px;">
	            <div class="group">
	                <label>Username</label>
	                <input id="email" name="username" type="text" placeholder="Username">
	            </div>
	           <div class="group">
	                <label>Password</label>
	                <input id="password" name="password"  type="password" placeholder="Password">
	            </div>
	            
	            <div class="group submit">
	                <label class="empty"></label>
	                <div><input name="submit" type="submit" value="Submit"/></div>
	            </div>

	            <div class="group"> 
					<div><a href="<?php echo $RELPATH . 'register.php'?>"><small>Nog niet geregistreerd?</small></a></div>
	            </div>

	        </div>
	        <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
	    </form>
<?php } else {?>
<div><p id="notLoggedIn">Je bent al ingelogd! Klik <a href="<?php echo $RELPATH . 'logout.php' ?>">hier</a> om uit te loggen.</p></div>
<?php } ?>
</body>
</html>