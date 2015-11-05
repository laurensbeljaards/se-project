<?php
include 'header/header.php';

$server = 'mysql.liacs.leidenuniv.nl'; //load the database
$username = 's1525670'; 
$password = 'PLACEHOLDER'; 
$database = 's1525670';
$conn = new mysqli($server, $username, $password, $database);
if($mysqli->connect_errno) {
    die('Could not connect: ' .$mysqli->connect_error);
}
$sql = "SELECT * FROM opdrachten";
$result = $conn->query($sql);

$opdrid = $_GET["opdr"];

$selectreq = "SELECT * FROM opdrachten WHERE id = '{$opdrid}'";
$reqresult = $conn->query($selectreq);

//USER DATA
if (!isset($_COOKIE["studentid"])) {
	$studentid = 1234567;
} else {
	$studentid = $_COOKIE["studentid"];
}


$selectedAssignment = $opdrid;
	
//check if user already saved this assignment
$sql = "SELECT * FROM `student_opdracht` WHERE `student_id` = " . $studentid . " AND `opdracht_id` = " . $selectedAssignment . ";";
$alreadySaved = $conn->query($sql);
if (!$alreadySaved) {
	echo $conn->error;
}

	if (isset($_POST["userCode"])) {
		//Save button pressed -> Save the file
		$userCode = htmlspecialchars($_POST["userCode"]);
		
		if ($alreadySaved->num_rows > 0) {
			//if assignment is already saved -> edit table
			$sql = "UPDATE `student_opdracht` SET `code` = '" . $userCode . "' WHERE `student_id` = " . $studentid . " AND `opdracht_id` = " . $selectedAssignment;
			if (!$alreadySaved = $conn->query($sql)) {
				echo $conn->error;
			}
		} else {
			//if assignment is never saved -> create new
			$sql = "INSERT INTO `student_opdracht` (`student_id`, `opdracht_id`, `code`) VALUES ('" . $studentid . "', '" . $selectedAssignment . "', '" . $userCode . "')";
			if (!$alreadySaved = $conn->query($sql)) {
				echo $conn->error;
			}
		}
	} else {
		//Save button not pressed -> Try load code
		if ($alreadySaved->num_rows > 0) {
			//Code already exists -> Load code
			$row = $alreadySaved->fetch_row();
			$userCode = $row[2];
		} else {
			//Code does not exist, load dummy code
			$userCode = 'Plaats je code hier';
		}
	}
	
mysqli_close($conn);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<div class="extrainfoheader">
	<div style='margin-top: 40px;'>&nbsp</div>

	<div class="extrainfosub">
		<h5>Available Tasks:</h5>
    </div>
	<div>
        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '<a href ="index.php?opdr='.$row["id"].'"><li id ="' . $row["id"] . '">'. $row["naam"] . '</li></a>';
                echo '<div style="width: 260px" id ="hidden' . $row["id"]. '">' . $row["description"] . '</div>'; 
                
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

	<div class="extrainfosub">
		<h5>Current Task Requirements: </h5>
    </div>
	<div>
    	<?php
        if($reqresult->num_rows > 0){
            while($row = $reqresult->fetch_assoc()){
                ?>
                <div style="width: 260px; margin: 4px;"><?php echo $row["requirements"]; ?></div>
                <?php
            }
        }else{
            ?>
            <div style="width: 260px; margin: 4px;">Opdracht niet gevonden.</div>
            <?php
        }
        ?>
	</div>
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