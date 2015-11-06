<?php
	require_once($BASEDIR . 'config.php');

	include $BASEDIR . 'header/header.php';

	$conn = new mysqli($server, $username, $password, $database);
	if($conn->connect_errno) {
		die('Could not connect: ' .$conn->connect_error);
	}
	
	$sql_opdr = "SELECT * FROM opdrachten";
	$result_opdr = $conn->query($sql_opdr);
	
	if(isset($_POST['submitAll'])) {
		if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['level']) && isset($_POST['category']) && isset($_POST['requirements']) && isset($_POST['template']) && isset($_POST['youtubeId'])){
			$sql = sprintf("INSERT INTO `opdrachten` (`id`, `naam`, `completed`, `description`, `moeilijkheidsgraad`, `categorie`, `requirements`, `templatecode`, `youtubeid`) VALUES (NULL, '%s', '0', '%s', '%s', '%s', '%s', '%s', '%s');", mysql_escape_string($_POST['name']), mysql_escape_string($_POST['description']), mysql_escape_string($_POST['level']), mysql_escape_string($_POST['category']), mysql_escape_string($_POST['requirements']), mysql_escape_string($_POST['template']), mysql_escape_string($_POST['youtubeId']));
			$conn->query($sql);
		}
	}
	
	mysqli_close($conn);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>

<div class="extrainfoheader_docent">
	<!-- <div style='margin-top: 40px;'>&nbsp</div> -->

	<div class="extrainfosub_docent">
		<h5>Opdrachten: <small><a href="newassignment.php" style="color: #B30000; float: right; margin-top: 3px;">Opdracht toevoegen</a></small> </h5>
    </div>

    <?php
    if($result_opdr->num_rows > 0){
		while($row = $result_opdr->fetch_assoc()){
			?>
			<tr>
				<li><a href=<?php echo "docent_opdr.php?opdr="; echo $row["id"]; ?>><?php echo $row["naam"]; ?></a></li>
			</tr>
			<?php
		}
	}else{
		echo "<tr><td>Nog geen opdrachten ingevoerd</td></tr>";
	}
	?>
	
</div>

	<h1>Nieuwe opdracht</h1>
	<form action="" name="formvalues" method="post">
	Naam:
	<input type="text" name="name" value=""/>	
	<br />
	Ondertitel:
	<input type="text" name="description" value=""/>	
	<br />
	Moeilijkheidsgraad:
	<input type="number" name="level" value=""/>
	<br />
	Categorie:
	<input type="text" name="category" value=""/>
	<br />
	Requirements:
	<input type="text" name="requirements" value=""/>
	<br />
	Youtube-ID:
	<input type="text" name="youtubeId" value=""/>
	<br />
	Template code:
	<textarea rows="10" cols="40" name="template" id="textarea" class="codetextarea"></textarea>
	<br />
	<input type="submit" name="submitAll" value="Save" />
	</form>

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