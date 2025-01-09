<?php 
session_start();
require_once 'db.php';
require_once 'logInChecker.php';

if(isset($_GET['accountID']))
    $accountId =$_GET['accountID'];
else $accountId = $_SESSION['accountID'];

$profileImageData = getProfileImage($accountId);
header('Content-Type: '.$profileImageData['imageType']);
echo $profileImageData['profileImage'];

?>