<?php 

session_start();
require_once "db.php";

if (isset($_POST['postID']) && isset($_POST['comment'])) {
    $postId = $_POST['postID'];
    $comment = $_POST['comment'];

    if (empty($comment)) {
        echo "Comment cannot be empty.";
        exit;
    }
    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
    
    $userId = $_SESSION['accountID']; // Assuming the user's ID is stored in the session
    if(!addComment($userId,$postId,$comment))
        echo "Could not add comment.";
       $username = $_SESSION['username'];
        $response = [
            'username' => $username,
            'comment' => $comment
        ];
    echo json_encode($response);
}




?>