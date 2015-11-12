test<?php
require_once('config.php');
qwe
if(!$loggedInStudent){
	//als geen docent weergeef error
	header('Location: 404.php');
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

$sql = "SELECT * FROM opdrachten WHERE id = '{$opdrid}'";
$allRequirements = $conn->query($sql);

$sql = "SELECT * FROM opdrachten WHERE id = '{$opdrid}'";
$templateResult = $conn->query($sql);
$templateCode = $templateResult->fetch_assoc();
$youtubeId = $templateCode["youtubeid"];
$templateCode = $templateCode["templatecode"];
	
//check if user already saved this assignment
$sql = "SELECT * FROM `student_opdracht` WHERE `username` = '" . $username . "' AND `opdracht_id` = " . $opdrid . ";";
$alreadySaved = $conn->query($sql);
$sql = "SELECT layout, werkt, testdata, overig FROM Feedback WHERE username='". $username . "' AND opdracht_id=" . $opdrid;		
$feedbackResult = $conn->query($sql);
if (!$alreadySaved) {
	echo $conn->error;
}

	if (isset($_POST["userCode"])) {
		//Save button pressed -> Save the file
		$userCode = htmlspecialchars($_POST["userCode"]);
		
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
	}	
mysqli_close($conn);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<?php
if($allRequirements->num_rows > 0){
    $row = $allRequirements->fetch_assoc();
?>
<div class="requirements">
    <h2><?php echo $row["naam"]; ?></h2>
    <p><?php echo $row["requirements"]; ?></p>
</div>
<?php
}
?>


<div class="extrainfoheader">
	<!--<div style='margin-top: 40px;'>&nbsp </div>-->
		<div class="extrainfosub">
			<h5>Feedback:</h5>
		</div>
				<?php
					// checkt eerst of er feedback is voor de opdracht, als dit het geval is dan print het de feedback op het scherm.
					if ($feedbackResult->num_rows > 0) {
						echo "<h5>Goed</h5>";
						$row = $feedbackResult->fetch_assoc();
						if($row["layout"]){
							echo "Layout<br>";
						}
						if($row["werkt"]){
							echo "Compileren<br>";

						}
						if($row["testdata"]){
							echo "Basis requirements<br>";
						}
						if($row["overig"]){
							echo "Extra requirements<br>";
						}
						echo "<h5>Niet goed</h5>";
						if(!$row["layout"]){
							echo "Layout<br>";
						}
						if(!$row["werkt"]){
							echo "Compileren<br>";

						}
						if(!$row["testdata"]){
							echo "Basis requirements<br>";
						}
						if(!$row["overig"]){
							echo "Extra requirements<br>";
						}
					}
					else{
						echo "Je hebt voor deze opdracht nog geen feedback ontvangen.";
					}
		?>
	<div class="extrainfosub">
		<h5>Available Tasks:</h5>
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
          height: \'157\',
          width: \'280\',
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
</div>

<div class="">
    <textarea rows="25" cols="85" name="userCode" id="textarea" class="codetextarea" form="submitCode"><?php echo $userCode; ?></textarea>
	<form id="submitCode" method="post">
		<input type="submit" value="Sla de code op">
	</form>
</div>

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
</body>
</html>
