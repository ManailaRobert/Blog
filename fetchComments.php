<?php 

session_start();
require_once "db.php";

if (isset($_POST['postID'])) {
    $postID = intval($_POST['postID']);
    $comments = getCommentsForPost($postID); // Use your existing function

    foreach ($comments as $comment) {
        echo '<div class="comment">';
        echo '<label>' . htmlspecialchars($comment['username']) . ': ' . htmlspecialchars($comment['comment']) . '</label>';
        echo '</div>';
    }
}



?>