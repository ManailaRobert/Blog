<?php 
session_start();
require_once "db.php";
if(isset($_GET['selectedPostforEdit'])){
    $postID = $_GET['selectedPostforEdit'];
    $post = getPostsByID($postID);
}else $post = null;

$categories = getCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="/styles/background.css">
    <link rel="stylesheet" href="/styles/layout.css">
    <link rel="stylesheet" href="/styles/editAndAddPost.css">   
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
        <form class="post" action="savePost.php" method="POST">
            <input type="text" name="postID" value="<?= $post["postID"] ?>" hidden>
            <label for="postTitle">Post Title</label>
            <input name="postTitle" class="postTitle" value="<?php echo htmlspecialchars($post["title"]); ?>" require></input>
            <hr>
            <label for="postContent">Post Content</label>
            <textarea name="postContent" class="postContent" require><?php echo htmlspecialchars($post["content"]); ?></textarea>
            <hr>
            <label for="selectedCategory">Category</label>
            <select name="selectedCategory" >
             <?php foreach($categories as $category):?>
                <option value="<?= htmlspecialchars($category['categoryID'])?>"
                <?php if($category['categoryID'] == $post["categoryID"])
                echo "selected";
                ?>><?= htmlspecialchars($category['categoryName'])?></option>
             <?php endforeach;?>
            </select>
            <hr>
            <button type="submit">Save Post</button>
        </form>
    </div>
</div>  

</body>
</html>