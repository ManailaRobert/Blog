<?php 
session_start();
require "logInChecker.php";
require_once "db.php";


if(isset($_POST["search"])){
    $posts = getPostsByTitle($_POST["search"]);
    $_POST['search'] = null;
}else if(isset($_POST['categoryID'])){
    $posts = getPostsByCategories($_POST['categoryID']);
    
}else $posts = getPosts();


$categories = getCategories();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <link rel="stylesheet" href="/styles/background.css">
    <link rel="stylesheet" href="/styles/layout.css">  
    <link rel="stylesheet" href="/styles/index.css">
</head>
<body>
<div class="container">

<nav>
    <div class="leftButtons">
    <form method="POST" action = "">
        <label for="search">Search:</label>
        <input name="search" type="text" id= "search">
        <button type="submit">></button>
    </form>
    <form action="createPost.php">
        <Button type="submit">Add Posts</Button>
    </form>
    </div>
    
    <div class="rightButtons">
        <form action="addProfileIMG.php">
            <Button type="submit">Profile Image</Button>
        </form>
        <form action="logout.php">
        <Button type="submit">LogOut</Button>
        </form>
    </div>
</nav>

<div class="main">
<div class = "leftSideMain">
    <form method="POST" action="index.php">
        <div class="category_Box">
            <h3>Post categories</h3>
            <hr>
            <li>
                <input type="checkbox" name="categoryID[]" id="all" value="0"
                <?php if (isset($_POST['categoryID']) && in_array(0, $_POST['categoryID'])): ?>
                    checked
                <?php endif; ?>
                >
                <label for="all">All</label>
            </li>
        <?php foreach($categories as $category): ?>
            <li>
                <input type="checkbox" name="categoryID[]" id="<?= $category['categoryName']?>" value="<?= $category['categoryID']?>"
                <?php if (isset($_POST['categoryID']) && in_array($category['categoryID'], $_POST['categoryID']) && !in_array(0, $_POST['categoryID'])): ?>
                    checked
                <?php endif; ?>
                >
                <label for="<?= $category['categoryName']?>"><?= $category['categoryName']?></label>
            </li>
        <?php endforeach; ?>
        </div>
        <button type="submit">Search Category</button>
    </form>
    <?php if($_SESSION["role"]== "admin"):?>
        <form  action="addCategory.php" method="POST">
            <div class="category_Box category_BoxAlignedCenter">
                <label for="categoryName">Category Name</label>
                <input type="text" name="categoryName" required>
                <button type="submit">Create Category</button>
            </div>
        </form>    
    <?php endif;?>
</div>



<div class="rightSideMain">
    <?php foreach($posts as $post): ?>
        <div class="post">
            <label><?php echo $post["title"]; ?></label>
            <hr>
            <label><?php echo $post["content"]; ?></label>
            <hr>

            <div class="postSubsection">
                <button type="button" class="showCommentsBTN" post-id="<?= $post["postID"] ?>">Comments</button>
                <?php if($_SESSION["role"] == "admin" || $post["accountID"] == $_SESSION["accountID"]): ?>
                    <form method="GET" action="editPost.php">
                        <input type="text" name="selectedPostforEdit" value='<?= $post["postID"] ?>' hidden>
                        <button type="submit" id="editPost">Edit</button>
                    </form>
                    <form method="POST" action="deletePost.php">
                        <input type="int" name="selectedPostforDelete" value='<?= $post["postID"] ?>' hidden>
                        <button type="submit" id="deletePost">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
            
            <div class="postCommentsSection" id="postCommentsSection<?= $post["postID"] ?>" style="display: none;">
                <div class="commentsSection" id="commentsSection<?= $post["postID"] ?>"></div>
                <hr>
                <div>
                    <label for="addComentInput<?= $post["postID"] ?>">Comment:</label>
                    <input type="text" id="addComentInput<?= $post["postID"] ?>">
                    <button type="button" class="addComment" post-id="<?= $post["postID"] ?>">Add Comment</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</div>

</div>

<script>
document.querySelectorAll('.showCommentsBTN').forEach(button => {
    button.addEventListener('click', function () {
        const postId = this.getAttribute('post-id');
        const postCommentsSection = document.getElementById('postCommentsSection' + postId);
        const commentsSection = document.getElementById('commentsSection' + postId);

        // If the comments section is open, hide it
        if (postCommentsSection.style.display === 'flex') {
            postCommentsSection.style.display = 'none';
            return; // Exit the function if the section is being hidden
        }

        commentsSection.innerHTML.trim() === ''
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetchComments.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                commentsSection.innerHTML = xhr.responseText;
                // After loading comments, show the postCommentsSection
                postCommentsSection.style.display = 'flex';
            } else {
                console.error('Error loading comments');
            }
        };
        xhr.send('postID=' + postId);
        postCommentsSection.style.display = 'flex';

    });
});


document.querySelectorAll('.addComment').forEach(button => {
    button.addEventListener('click', function () {
        const postId = this.getAttribute('post-id');
        const commentInput = document.getElementById('addComentInput' + postId);
        const commentText = commentInput.value;

        if (commentText === '') {
            alert('Please enter a comment');
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'addComment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            console.log(xhr.responseText); // Log the raw response
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText.trim()); // Parse the JSON response
                    if (response.username && response.comment) {
                        // Append the new comment with the username to the comments section
                        const newComment = document.createElement('div');
                        newComment.classList.add('comment');
                        newComment.innerHTML = `
                        <img src="displayImage.php" alt="Profile Image"> 
                        ${response.username}: ${response.comment}
                        `;

                        const commentsSection = document.getElementById('commentsSection' + postId);
                        commentsSection.appendChild(newComment);

                        // Clear the input field
                        commentInput.value = '';
                    } else {
                        console.error('Error adding comment');
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            } else {
                console.error('Error adding comment');
            }
            };

        xhr.send('postID=' + postId + '&comment=' + encodeURIComponent(commentText));
    });
});




</script>


</body>
</html>