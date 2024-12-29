<?php 
session_start();
require "logInChecker.php";
require "db.php";


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
    <link rel="stylesheet" href="./styles/layout.css">  
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
    </div>
    
    <div class="rightButtons">
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

</div>



<div class = "rightSideMain">
    <?php foreach($posts as $post):?>
        <div class="post">
            <label><?php echo $post["title"]; ?></label>
            <hr>
            <Label><?php echo $post["content"]; ?></Label>
            <hr>
            <div class="postSubsection">
                <form method="POST" action = "">
                    <input type="text" name="CommentsTriggerer" value='<?= $post["postID"] ?>' hidden>
                    <button type="button" class="showCommentsBTN" postID="<?= $post["postID"] ?>" >Comments</button>
                </form>
                <div class="commentsSection" id="commentsSection<?= $post["postID"] ?>">
                    <div class = "comment">
                        <Label>Name : Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores vel quos tempora hic minus. Dolore blanditiis optio odit dolores numquam?</Label>
                    </div>
                </div>

                <?php if($_SESSION["role"]== "admin"):?>
                    <form method="POST" action = "editPost.php">
                    <input type="text" name="selectedPostforEdit" value='<?= $post["postID"] ?>' hidden>
                        <button type="button" id="editPost">Edit</button>
                    </form>
                    <form method="POST" action = "deletePost.php">
                        <input type="text" name="selectedPostforDelete" value='<?= $post["postID"] ?>' hidden>
                        <button type="button" id="deletePost">Delete</button>
                    </form>
                <?php endif;?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>

</div>

<script>
    var btnComments = document.getElementsByClassName("showCommentsBTN");
    Array.from(btnComments).forEach(function(button){

            button.addEventListener('click', function() {
             var postId = button.getAttribute('postID');
            var commentsSection = document.getElementById('commentsSection' + postId);

            // Toggle the visibility of the comments section
            if (commentsSection.style.display === 'none' || commentsSection.style.display === '') {
            commentsSection.style.display = 'block'; // Show the comments
        } else {
                commentsSection.style.display = 'none'; // Hide the comments
            }   
            });
    });
    document.getElementById('showCommentsBTN')
</script>

</body>
</html>