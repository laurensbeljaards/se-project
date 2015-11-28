<link rel="stylesheet" href="css/main1.css">

<?php
$loggedInStudent = 0;
$loggedInTeacher = 0;
require_once('config.php');
//include $BASEDIR . 'header/header.php';

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
		$sql = "SELECT username FROM users WHERE username='$username'";
		$result = $conn->query($sql);
		//check if username already exists
		if ($result->num_rows != 0)
			{
			echo "<font color='white'><h3>Gebruikersnaam bestaat al.</h3></font>";
			}
		else
		{
			//check for only letters dashes and spaces in username
			if (preg_match("/^[a-zA-Z\s-]+$/i", $_POST['firstnameR']) == 0)
			{
				echo "<font color='white'><h3>Je voornaam mag alleen letters, spaties en streepjes bevatten.</h3></font>";
			}
			else
			{
				//check for length username
				if(strlen($firstname) > 25)
				{
					echo "<font color='white'><h3>Je voornaam mag niet meer dan 25 karakters bevatten.</h3></font>";
				}
				else
				{
					//check for only letters dashes and spaces in lastname
					if(preg_match("/^[a-zA-Z\s-]+$/i",    $_POST['lastnameR']) == 0) 
					{
						echo "<font color='white'><h3>Je achternaam mag alleen letters, spaties en streepjes bevatten.</h3></font>";
					}
					else
					{
						//check for length lastname
						if(strlen($lastname) > 50)
						{
							echo "<font color='white'><h3>Je achternaam mag niet meer dan 50 karakters bevatten.</h3></font>";
						}
						else
						{
							// check if both passwords are the same
							if ($password != $passwordAgain)
							{
								echo "<font color='white'><h3>Wachtwoorden komen niet overeen.</h3></font>";
							}
							else
							{
								//now insert data in the database
								echo "<font color='white'><h3>Registreren was succesvol!</h3></font>";
								$sql = sprintf("INSERT INTO `users` (`username`, `password`, `firstname`, `lastname`) VALUES ('%s','%s','%s','%s');", mysql_escape_string($_POST['usernameR']), mysql_escape_string($_POST['passwordR']), mysql_escape_string($_POST['firstnameR']), mysql_escape_string($_POST['lastnameR']));
								$conn->query($sql);
								header("refresh:3;url=login.php");
							}	
						}
					}
				}
			}
		}
	}
}
if($loggedInStudent == 0 && $loggedInTeacher == 0){ ?>

<form id="login-form" class="login-form" name="form1" method="post" action="register.php">
	    	<input type="hidden" name="is_login" value="1">
	        <div class="h1">Registreren</div>
	        <div id="form-content">
<tr>	            
	            <div class="group">
	                <label for="username">Username</label>
	                <div><input id="username" name="usernameR" class="form-control required" type="textarea" placeholder="Username"></div>
	            </div>
	            <div class="group">
	                <label for="username">First name</label>
	                <div><input id="firstname" name="firstnameR" class="form-control required" type="textarea" placeholder="First Name"></div>
	            </div>
	            <div class="group">
	                <label for="username">Lastname</label>
	                <div><input id="lastname" name="lastnameR" class="form-control required" type="textarea" placeholder="Last Name"></div>
	            </div>
	           <div class="group">
	                <label for="name">Password</label>
	                <div><input id="password" name="passwordR" class="form-control required" type="password" placeholder="Password"></div>
	            </div>
	            <div class="group">
	                <label for="name">Password again</label>
	                <div><input id="passwordAgain" name="passwordAgainR" class="form-control required" type="password" placeholder="Password Again"></div>
	            </div>
	            <div class="group submit">
	                <label class="empty"></label>
	                <div><input name="submitR" type="submit" value="Submit"/></div>
	            </div>
	            </tr>
	        </div>
	        <div id="form-loading" class="hide"><i class="fa fa-circle-o-notch fa-spin"></i></div>
	    </form>
<?php } ?>

