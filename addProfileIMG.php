<?php
session_start();
require "logInChecker.php";
require_once "db.php";

if(isset($_FILES['file']['tmp_name']))
{
    $binary = file_get_contents($_FILES['file']['tmp_name']);
    echo $binary;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Profile</title>
    <link rel="stylesheet" href="/styles/background.css">
    <link rel="stylesheet" href="/styles/layout.css">
    <link rel="stylesheet" href="/styles/addProfileImage.css">   
</head>
<body>
<div class="container">
    <nav>
        <div class="leftButtons">
            <form method="GET" action = "index.php">
                <button type="submit">Posts</button>
            </form>
        </div>
        <div class="rightButtons"></div>
    </nav>
    <div class="main">
        <form enctype="multipart/form-data" action="addProfileIMG.php" method = "POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000">
            <input type="file" name = "file">
            <button type="submit">Add Image</button>
        </form>
    </div>
</div>  

</body>
</html>