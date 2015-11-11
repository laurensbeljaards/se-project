<?php
$loggedInStudent = 0;
$loggedInTeacher = 0;
require_once('config.php');
include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}

//$loggedInTeacher = 0;
if (!empty($_POST['submit'])){
	if($_POST['studentOrTeacher'] == 'student'){ //trying to log in as student
		if (isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		$sql = "SELECT * from students WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
		$result = $conn->query($sql);
		if (!$result->num_rows == 1) { //the user didnt enter an username with password that exists in our databse
			echo "<p>Invalid username/password combination</p>"; 
		}
		else { //in this case the user did enter a right couple of password+username
			echo "<p>Logged in successfully.<br>You are being redirected to the index page....</p>";
			$loggedInStudent = '1'; 
			$loggedInTeacher = '0';//and is now loggedin as student
			$_SESSION['loggedInStudent'] = $loggedInStudent; 
			$_SESSION['loggedInTeacher'] = $loggedInTeacher;//load the username and password and the 'loggedin' variable for the rest of the session
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:3;url=index.php");
			
		}
	}
	if($_POST['studentOrTeacher'] == 'teacher'){
		if (isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		$sql = "SELECT * from teachers WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
		$result = $conn->query($sql);
		if (!$result->num_rows == 1) { //the user didnt enter an username with password that exists in our databse
			echo "<p>Invalid username/password combination</p>"; 
		}
		else { //in this case the user did enter a right couple of password+username
			echo "<p>Logged in successfully.<br>You are being redirected to the index page....</p>";
			$loggedInStudent = '0'; 
			$loggedInTeacher = '1';//and is now loggedin as student
			$_SESSION['loggedInStudent'] = $loggedInStudent; 
			$_SESSION['loggedInTeacher'] = $loggedInTeacher;//load the username and password and the 'loggedin' variable for the rest of the session
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:3;url=index.php");
			
		}
	}
}
if($loggedInStudent == 0 && $loggedInTeacher == 0){ ?>
<form action="login.php" method="post">
	<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<input type="radio" name="studentOrTeacher" value="student" checked >Student
			<br>
			<input type="radio" name="studentOrTeacher" value="teacher">Docent
			<td><input type="submit" name="submit" value="Login" /></td>
		</tr>
	</table>
</form>
<?php } ?>
