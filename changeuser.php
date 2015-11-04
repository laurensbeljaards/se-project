<?php
if (isset($_POST["studentid"])) {
	setcookie("studentid", $_POST["studentid"]);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Change user</title>
</head>
<body>
	<form id="submitCode" method="post">
		Enter correct studentid: <input type="text" name="studentid"><br>
		<input type="submit" value="Submit">
	</form>
</body>
</html>
