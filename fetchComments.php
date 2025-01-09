<?php 

session_start();
require_once "db.php";
require "logInChecker.php";


if (isset($_POST['postID'])) {
    $postID = intval($_POST['postID']);
    $comments = getCommentsForPost($postID);
    
    foreach ($comments as $comment) {
        echo '<div class="comment">';
        echo '<img src = "displayImage.php?accountID='.$comment['accountID'].'"';
        echo '<label>' . htmlspecialchars($comment['username']) . ': ' . htmlspecialchars($comment['comment']) . '</label>';
        echo '</div>';
    }
}



?>