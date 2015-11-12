<?php
require_once('config.php');

if($loggedInTeacher){
    $url = "docent_opdr.php";
}else if($loggedInStudent){
    $url = "index.php";
}else{
    $url = "#";
}
?>
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/404.css">
    <title>C sharper - 404</title>
</head>

<body>
<div class="wrap">
    <div class="logo">
        <img src="images/404.png" alt=""  />
        <p><a href='login.php' >Go back to Home</a></p>
    </div>
</div>
<div class="footer">
	Design by - <a href="http://w3layouts.com">W3Layouts</a>
</div>

</body>