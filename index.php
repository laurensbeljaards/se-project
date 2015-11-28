<?php
require_once('config.php');
$page = $_SESSION['page'] = 'opdrachten';

if(!$loggedInStudent){
	//error if student is not logged in
	header('Location: login.php');
}

include $BASEDIR . 'header/header.php';

$conn = new mysqli($server, $usernamedb, $passworddb, $database);
if($conn->connect_errno) {
    die('Could not connect: ' .$conn->connect_error);
}

$sql = "SELECT * FROM opdrachten";
$allAssignments = $conn->query($sql);

if (isset($_GET["opdr"])) {
	$opdrid = $_GET["opdr"];
} else {
	$opdrid = 0;
}

//$assignmentDetails contains all details of the assignment
$opdrid = $conn->real_escape_string($opdrid);
$sql = "SELECT * FROM opdrachten WHERE id = '$opdrid'";
$sqlresult = $conn->query($sql);
$assignmentDetails = $sqlresult->fetch_assoc();

$youtubeId = $assignmentDetails["youtubeid"];
$templateCode = $assignmentDetails["templatecode"];
	
//check if user already saved this assignment
$username = $conn->real_escape_string($username);
$opdrid = $conn->real_escape_string($opdrid);
$sql = "SELECT * FROM `student_opdracht` WHERE `username` = '$username' AND `opdracht_id` = '$opdrid'";
$alreadySaved = $conn->query($sql);

$sql = "SELECT layout, werkt, testdata, overig FROM Feedback WHERE username='$username' AND opdracht_id='$opdrid'";		
$feedbackResult = $conn->query($sql);

if (!$alreadySaved) {
	echo $conn->error;
}
	if (isset($_POST["userCode"])) {
		//Save button pressed -> Save the file
		$userCode = htmlspecialchars($_POST["userCode"]);
		
        //award 'Cheater' badge if the submitted assignment contains the word 'cheat' (upercases also allowed due to strtolower).
        if (strpos(strtolower($userCode),'cheat') !== false) {
            $sql = "INSERT INTO `student_badge` (`badgeid`, `username`, `timestamp`) VALUES ('13', '$username', CURRENT_TIMESTAMP);";
            $conn->query($sql);
        }
        
		if ($alreadySaved->num_rows > 0) {
			//if assignment is already saved -> edit table
			$sql = "UPDATE `student_opdracht` SET `code` = '" . $userCode . "' WHERE `username` = '" . $username . "' AND `opdracht_id` = " . $opdrid;
			if (!$alreadySaved = $conn->query($sql)) {
				echo $conn->error;
			}
		} else {
			//if assignment is never saved -> create new
			$sql = "INSERT INTO `student_opdracht` (`username`, `opdracht_id`, `code`) VALUES ('" . $username . "', '" . $opdrid . "', '" . $userCode . "')";
			if (!$alreadySaved = $conn->query($sql)) {
				echo $conn->error;
			}
		}
	} else {
		//Save button not pressed -> Try load code
		if ($alreadySaved->num_rows > 0) {
			//Code already exists -> Load code
			$row = $alreadySaved->fetch_assoc();
			$userCode = $row["code"];
		} else {
			//Code does not exist, load dummy code
			$userCode = $templateCode;
		}
		
		if (isset($_POST["mayBeChecked"])) {
			if ($alreadySaved->num_rows > 0) {
				//mark the assignment to be checked.
				$sql = "UPDATE `student_opdracht` SET `readytocheck` = '1' WHERE `username` = '" . $username . "' AND `opdracht_id` = " . $opdrid . ";";
				$checked = $conn->query($sql);
				echo "<script type='text/javascript'>alert('De opdracht staat gemarkeerd om te worden nagekeken.');</script>";
			} else {
				//the assignment has not been saved yet.
				echo "<script type='text/javascript'>alert('Sla code op voordat deze kan worden nagekeken...');</script>";
			}
		}
	}	
	
	$sql = "SELECT * FROM Feedback WHERE username = '$username' AND layout = '1' AND werkt = '1' AND testdata = '1' AND overig = '1'";
	$result = $conn->query($sql);
	$count = $result->num_rows;
	if($count >= 1)
	{
		$sql = "SELECT * from student_badge WHERE badgeid = '1' AND username = '$username'";
		$result = $conn->query($sql);
		$row = $result->num_rows;
		if($row == 0)
		{
			$sql = sprintf("INSERT INTO `student_badge` (`badgeid`, `username`) VALUES ('%s','%s');", mysql_escape_string('1'), mysql_escape_string($username));
			$conn->query($sql);
		}
		if($count >= 5)
		{		
			$sql = "SELECT * from student_badge WHERE badgeid = '2' AND username = '$username'";
			$result = $conn->query($sql);
			$row = $result->num_rows;
			if($row == 0)
			{
				$sql = sprintf("INSERT INTO `student_badge` (`badgeid`, `username`) VALUES ('%s','%s');", mysql_escape_string('2'), mysql_escape_string($username));
					$conn->query($sql);
			}
			if($count >= 10)
			{		
				$sql = "SELECT * from student_badge WHERE badgeid = '3' AND username = '$username'";
				$result = $conn->query($sql);
				$row = $result->num_rows;
				if($row == 0)
				{
					$sql = sprintf("INSERT INTO `student_badge` (`badgeid`, `username`) VALUES ('%s','%s');", mysql_escape_string('3'), mysql_escape_string($username));
					$conn->query($sql);
				}
				if($count >= 20)
				{		
					$sql = "SELECT * from student_badge WHERE badgeid = '4' AND username = '$username'";
					$result = $conn->query($sql);
					$row = $result->num_rows;
					if($row == 0)
					{
						$sql = sprintf("INSERT INTO `student_badge` (`badgeid`, `username`) VALUES ('%s','%s');", mysql_escape_string('4'), mysql_escape_string($username));
						$conn->query($sql);
					}
					if($count >= 30)
					{
						$sql = "SELECT * from student_badge WHERE badgeid = '5' AND username = '$username'";
						$result = $conn->query($sql);
						$row = $result->num_rows;
						if($row == 0)
						{
							$sql = sprintf("INSERT INTO `student_badge` (`badgeid`, `username`) VALUES ('%s','%s');", mysql_escape_string('5'), mysql_escape_string($username));
							$conn->query($sql);
						}
					}
				}
			}
		}
	}
	
mysqli_close($conn);

?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<!--
<div class="requirements">
    <h2><?php echo $assignmentDetails["naam"]; ?></h2>
    <p><?php echo $assignmentDetails["requirements"]; ?></p>
</div>
-->

<div class="extrainfoheader_student">
	<div class="extrainfosub_student">
		<h5>Feedback:</h5>
	</div>
	<?php
        $layout = 0;
        $werking = 0;
        $testdata = 0;
        $overig = 0;
        // checkt eerst of er feedback is voor de opdracht, als dit het geval is dan print het de feedback op het scherm.
        if ($feedbackResult->num_rows > 0) {
            $row = $feedbackResult->fetch_assoc();
            if($row["layout"]){
                $layout = 1;
            }
            if($row["werkt"]){
                $werking = 1;

            }
            if($row["testdata"]){
                $testdata = 1;
            }
            if($row["overig"]){
                $overig = 1;
            }
            ?>
                <table>
                <tr>
                    <td>Layout</td><td></td>
                    <td>Werking</td><td></td>
                    <td>Testdata</td><td></td>
                    <td>Overig</td><td></td>
                </tr>
                <tr>
                    <td> <?php if($layout == 0){ ?> <img class="small" src="images/wrong.png" /> <?php } else if($layout == 1) { ?> <img class="small" src="images/correct.png" /> <?php } ?> </td><td></td>
                    <td> <?php if($werking == 0){ ?> <img class="small" src="images/wrong.png" /> <?php } else if($werking == 1) { ?> <img class="small" src="images/correct.png" /> <?php } ?> </td><td></td>
                    <td> <?php if($testdata == 0){ ?> <img class="small" src="images/wrong.png" /> <?php } else if($testdata == 1) { ?> <img class="small" src="images/correct.png" /> <?php } ?> </td><td></td>
                    <td> <?php if($overig == 0){ ?> <img class="small" src="images/wrong.png" /> <?php } else if($overig == 1) { ?> <img class="small" src="images/correct.png" /> <?php } ?>  </td><td></td>
                </tr>
                </table>
        <?php
        }
        else{
            echo "Je hebt voor deze opdracht nog geen feedback ontvangen.";
        }
?>

	<div class="extrainfosub_student">
		<h5>Instructievideo:</h5>
	</div>
	<div id="player">
		<p>Voor deze opdracht is geen YouTube video beschikbaar.</p>
	</div>
	
	<?php
	if($youtubeId != NULL) {
		echo '
	<script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement(\'script\');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName(\'script\')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player(\'player\', {
          height: \'197\',
          width: \'350\',
          videoId: \'' . $youtubeId . '\',
          events: {
            \'onReady\': onPlayerReady,
            \'onStateChange\': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        //event.target.playVideo();
      }

      // 5. The API calls this function when the player\'s state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      var done = false;
      function onPlayerStateChange(event) {

      }
      function stopVideo() {
        player.stopVideo();
      }
    </script>';}
	?>
	
	<div class="extrainfosub_student">
		<h5>Beschikbare opdrachten:</h5>
	</div>
	<div>
	<?php
	if($allAssignments->num_rows > 0){
		while($row = $allAssignments->fetch_assoc()){
			echo '<a href ="index.php?opdr='.$row["id"].'"><li id ="' . $row["id"] . '">'. $row["naam"] . '</li></a>';
			echo '<div style="width: 240px" id ="hidden' . $row["id"]. '">' . $row["description"] . '</div>'; 
			
			 ?>
			 <script type="text/javascript">
					$(function() {
						$('#<?php echo "hidden".$row["id"]; ?>').hide();
						$('#<?php echo $row["id"]; ?>').hover(function() { 
							$('#<?php echo "hidden".$row["id"]; ?>').show();
							$('#<?php echo "hidden".$row["id"]; ?>').hover(function(){
								$('#<?php echo "hidden".$row["id"]; ?>').show();
							}, function(){
								$('#<?php echo "hidden".$row["id"]; ?>').hide();
							});
						}, function() { 
							$('#<?php echo "hidden".$row["id"]; ?>').hide(); 
						});
					});
				</script>

			<?php
		}
	}
	?>

	</div>
</div>

	<?php
	if (isset($_GET["opdr"])) {
	?>


	<br />
	<h1><?php echo $assignmentDetails["naam"]; ?>: </h1>
	<h2><?php echo $assignmentDetails["requirements"]; ?></h2>
	<hr class="hr"/><hr class="hr"/>
	<br />

	<div class="maininfo_student">

	<form id="submitCode" method="post" style="float:left;">
		<label><input type="submit" value="Sla de code op" class="docent_submit"></label>
	</form>
	
	<form id="mayBeChecked" method="post">
        <input type="submit" value="Mijn opgeslagen code kan worden nagekeken" name="mayBeChecked" class="docent_submit">
    </form>
	<div class="textareaWrapper"><textarea rows="25" cols="85" name="userCode" id="textarea" class="codetextarea" form="submitCode"><?php echo $userCode; ?></textarea></div>

<script>
	document.querySelector("textarea").addEventListener
	('keypress',function(keystroke) {//ignores special keys like shift and tab (eg shift + ] is }, but } will then not be recognised)
		if (keystroke.keyCode === 13) {//The keystroke was an [enter]
			var start = this.selectionStart;
			var target = keystroke.target;
			var value = target.value;
			var newline ="";
														
			var brackets = 0;
			//Goes back to the beginning of the line and checks for tabs
			for (var i = textarea.selectionStart-1; i >= 0 ; i--) {
				if (value[i] == "\t") {//Tabs for each tab at the beginning of the previous line
					newline = newline + "\t";
				} else if (value[i] == "\n") {//Beginning of the line
					break;
				} else if (value[i] == "{") {
					brackets ++;
				} else if (value[i] == "}" && brackets <= 0) {//No additional tab if as many brackets on this line were closed as opened
					brackets --;
				} else {//Only add tabs if there's no other characters before them
					newline = "";
				}
			}
			if (brackets > 0)//add one additional tab
				newline += "\t";
			
			//The textarea value becomes: text before cursor + [enter] + an amount of tabs + text after cursor
			target.value = value.substring(0, start) + "\n" + newline + value.substring(this.selectionEnd);
			//put cursor after the old position + 1 enter + all tabs.
			this.selectionStart = this.selectionEnd = start + newline.length + 1;
			keystroke.preventDefault();
			
		} else if (keystroke.keyCode === 125) {// "}"
	 
			var start = this.selectionStart;
			var target = keystroke.target;
			var value = target.value;

			//Goes back to the beginning of the line and checks for tabs
			for (var i = textarea.selectionStart-1; i >= 0 ; i--) {
				if (value[i] == "\t") {//Tabs for each tab at the beginning of the previous line
					newline = newline + "\t";
				} else if (value[i] == "\n") {//Beginning of the line
					break;
				} else {//another character found: do not jump one tab back
					target.value = value.substring(0, start) + "}" + value.substring(this.selectionEnd);//add "}"
					this.selectionStart = this.selectionEnd = start + 1;
					keystroke.preventDefault();
					return;
				}
			}
			if (start == 0) {
				target.value = "}" + value.substring(this.selectionEnd);
				this.selectionStart = this.selectionEnd = start + 1;
			} else {
				//The textarea value becomes: text before cursor + 1 tab less + } + text after cursor
				target.value = value.substring(0, start-1) + "}" + value.substring(this.selectionEnd);
				//put cursor after the old position (-1 +1 character is no displacement).
				this.selectionStart = this.selectionEnd = start;
			}
			keystroke.preventDefault();
		}
	},false);
	document.querySelector("textarea").addEventListener('keydown',function(keystroke) {//keydown can detect tabs
		 //Prevents an element outside of the textbox being selected whenever you press tab.
			if (keystroke.keyCode === 9) {//The keystroke was a tab
		 
				var start = this.selectionStart;
				var target = keystroke.target;
				var value = target.value;
		 
				//The textarea value becomes: text before cursor + tab + text after cursor
				target.value = value.substring(0, start) + "\t" + value.substring(this.selectionEnd);
				//put cursor at one after the old position (because of the added tab)
				this.selectionStart = this.selectionEnd = start + 1;
				keystroke.preventDefault();
			}
		 },false);
	</script>
	
	</div>
	<?php
	}else{
	?>

	<br />
	<h1>Opdracht Maken: </h1>
	<h2>Selecteer eerst een opdracht!</h2>
	<hr class="hr"/><hr class="hr"/>
	<br />

	<div class="maininfo_student">
	<p>Selecteer een opdracht.</p>
	<?php
	}
	?>
</body>
</html>
