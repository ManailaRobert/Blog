<?php
session_start();
require "logInChecker.php";
require_once "db.php";

if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $file = $_FILES['file'];
    $fileType= $file['type'];
    echo $fileType; 
    if(checkType($fileType)){
        $fileSize = $file['size'];   
        if($fileSize <= $_POST["MAX_FILE_SIZE"]){
            empty($_POST["error"]);
            $tmpName = $file['tmp_name']; 
            $accountId=$_SESSION['accountID'];
            $blob = file_get_contents($tmpName); 
        
            addProfileToDB($accountId,$blob,$fileType);
            header("Location: index.php");
        }else {
            $_POST["error"] = "Fisierul este prea mare.";
        }
    }else {
        $_POST["error"] = "Tipul fisierului este unul invalid.(Valide: PNG, JPG)";
    }
}

function checkType($fileType){
    switch($fileType){
        case 'image/png':
            return true;
        case 'image/jpg':
            return true;
    }
    return false;
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
            <form method="GET" action="index.php">
                <button type="submit">Posts</button>
            </form>
        </div>
        <div class="rightButtons">
            <form action="logout.php">
            <Button type="submit">LogOut</Button>
            </form>
        </div>
    </nav>
    <div class="main">
        <img src="displayImage.php?accountID=<?php echo $_SESSION['accountID']; ?>" alt="Profile Image">

        <form enctype="multipart/form-data" action="addProfileIMG.php" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000"> <!-- 1MB limit -->
            <input type="file" name="file" required>
            <button type="submit">Add Image</button>
            <label name="error">
            <?php if(isset($_POST['error'])):?>
            <?= $_POST['error']?>
            <?php endif;?>


            </label>
        </form>
    </div>
</div>  
</body>
</html>
