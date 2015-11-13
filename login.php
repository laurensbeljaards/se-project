<?php
$loggedInStudent = 0;
$loggedInTeacher = 0;
require_once('config.php');
include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}

if(isset($_POST['submitR'])) // button after registration  
{
	//check if they're all filled in
	if(isset($_POST['usernameR']) && isset($_POST['firstnameR'])&& isset($_POST['lastnameR'])&& isset($_POST['passwordR'])&& isset($_POST['passwordAgainR']))
	{
		$username = $_POST['usernameR'];
		$firstname = $_POST['firstnameR'];
		$lastname = $_POST['lastnameR'];
		$password = $_POST['passwordR'];
		$passwordAgain = $_POST['passwordAgainR'];
		$sql = "SELECT username FROM students WHERE username='$username'";
		$result = $conn->query($sql);
		//check if username already exists
		if ($result->num_rows != 0)
			{
			echo "Gebruikersnaam bestaat al.";
			}
		else
		{
			//check for only letters dashes and spaces in username
			if (preg_match("/^[a-zA-Z\s-]+$/i", $_POST['firstnameR']) == 0)
			{
				echo "Je voornaam mag alleen letters, spaties en streepjes bevatten.";
			}
			else
			{
				//check for length username
				if(strlen($firstname) > 25)
				{
					echo "Je voornaam mag niet meer dan 25 karakters bevatten.";
				}
				else
				{
					//check for only letters dashes and spaces in lastname
					if(preg_match("/^[a-zA-Z\s-]+$/i",    $_POST['lastnameR']) == 0) 
					{
						echo "Je achternaam mag alleen letters, spaties en streepjes bevatten.";
					}
					else
					{
						//check for length lastname
						if(strlen($lastname) > 50)
						{
							echo "Je achternaam mag niet meer dan 50 karakters bevatten.";
						}
						else
						{
							// check if both passwords are the same
							if ($password != $passwordAgain)
							{
								echo "Wachtwoorden komen niet overeen.";
							}
							else
							{
								//now insert data in the database
								echo "Registreren was succesvol!";
								$sql = sprintf("INSERT INTO `students` (`username`, `password`, `firstname`, `lastname`) VALUES ('%s','%s','%s','%s');", mysql_escape_string($_POST['usernameR']), mysql_escape_string($_POST['passwordR']), mysql_escape_string($_POST['firstnameR']), mysql_escape_string($_POST['lastnameR']));
								$conn->query($sql);
							}	
						}
					}
				}
			}
		}
	}
}


if (!empty($_POST['submit'])){
	//trying to log in as student
	if($_POST['studentOrTeacher'] == 'student'){ 
		$username = "notexist";
		$password = "notexisttoo";
		
		if (isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		
		$username = $conn->real_escape_string($username);
		$password = $conn->real_escape_string($password);
		$sql = "SELECT * from students WHERE username = '$username' AND password = '$password' LIMIT 1";
		$result = $conn->query($sql);
		
		//the user didnt enter an username with password that exists in our databse
		if (!$result->num_rows == 1) { 
			echo "<p>Invalid username/password combination</p>"; 
		}
		//in this case the user did enter a right pair of password+username
		else { 
			echo "<p>Logged in successfully.<br>You are being redirected to the index page....</p>";
			//and is now loggedin as student
			$loggedInStudent = '1'; 
			$loggedInTeacher = '0';
			
			//load the username and password and the 'loggedin' variable for the rest of the session
			$_SESSION['loggedInStudent'] = $loggedInStudent; 
			$_SESSION['loggedInTeacher'] = $loggedInTeacher;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:3;url=index.php");
			
		}
	}
	if($_POST['studentOrTeacher'] == 'teacher'){
		$username = "notexist";
		$password = "notexisttoo";
		
		if (isset($_POST['username']) && isset($_POST['password'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		}
		
		$username = $conn->real_escape_string($username);
		$password = $conn->real_escape_string($password);
		$sql = "SELECT * from teachers WHERE username LIKE '$username' AND password LIKE '{$password}' LIMIT 1";
		$result = $conn->query($sql);
		
		//the user didnt enter an username with password that exists in our databse
		if (!$result->num_rows == 1) { 
			echo "<p>Invalid username/password combination</p>"; 
		}
		//in this case the user did enter a right couple of password+username
		else { 
			echo "<p>Logged in successfully.<br>You are being redirected to the index page....</p>";
			$loggedInStudent = '0'; 
			//and is now loggedin as student
			$loggedInTeacher = '1';
			
			//load the username and password and the 'loggedin' variable for the rest of the session
			$_SESSION['loggedInStudent'] = $loggedInStudent; 
			$_SESSION['loggedInTeacher'] = $loggedInTeacher;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("refresh:3;url=checkassignments.php");
			
		}
	}
}
if($loggedInStudent == 0 && $loggedInTeacher == 0){ ?>

<br />
<h1> Inloggen</h1>
<br />
<form action="login.php" method="post">
	<table>
		<tr>
			<td>Gebruikersnaam:</td>
			<td><input type="text" name="username" /></td>
		</tr>
		<tr>
			<td>Wachtwoord:</td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td><input type="radio" name="studentOrTeacher" value="student" checked> Student
			<br>
			<input type="radio" name="studentOrTeacher" value="teacher"> Docent</td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Login" /></td>
		</tr>
		</tr>
	</table>
</form>

<br />
<h1> Registreren</h1>
<br />

<form action="login.php" method="post">
	<table>
		<tr>
			<td>Gebruikersnaam:</td>
			<td><input type="text" name="usernameR" /></td>
		</tr>
		<tr>
			<td>Voornaam:</td>
			<td><input type="text" name="firstnameR" /></td>
		</tr>
		<tr>
			<td>Achternaam:</td>
			<td><input type="text" name="lastnameR" /></td>
		</tr>
		<tr>
			<td>Wachtwoord:</td>
			<td><input type="password" name="passwordR" /></td>
		</tr>
		<tr>
			<td>Wachtwoord opnieuw:</td>
			<td><input type="password" name="passwordAgainR" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submitR" value="Registreer" /></td>
		</tr>
	</table>
<?php } ?>
