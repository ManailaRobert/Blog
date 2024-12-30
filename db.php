<?php

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'blog';

// Establish the connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getPosts(){
    global $conn;

    $sql = "SELECT postID, title, content from posts where postStatus = 'activ' ORDER BY datePosted DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $post = [
            'postID'=> $row['postID'],
            'title'=> $row['title'],
            'content'=> $row['content'],
        ];
        $posts[] = $post;
    }

    return $posts;
}

function getCategories(){
    global $conn;

    $sql = "SELECT categoryID, category_Name  from categories";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        $post = [
            'categoryID'=> $row['categoryID'],
            'categoryName'=> $row['category_Name'],
        ];
        $posts[] = $post;
    }

    return $posts;
}

function addCateogry($categoryName){
    global $conn;

    $sql = "INSERT INTO categories(category_Name) values (?)";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,'s',$categoryName);
    mysqli_stmt_execute($stmt);
}

function getPostsByCategories($sentData){
    global $conn;
    $posts = [];
    foreach($sentData as $categoryID){
        if($categoryID == 0) return getPosts();

        $sql = "SELECT postID, title, content from posts where categoryID = ? AND postStatus = 'activ' ORDER BY datePosted DESC";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $categoryID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $post = [
                'postID'=> $row['postID'],
                'title'=> $row['title'],
                'content'=> $row['content']
            ];
            $posts[] = $post;
        }
    }
    
    return $posts;
}
function getPostsByTitle($title){
        global $conn;
        $posts = [];

        $sql = "SELECT postID, title, content from posts where title LIKE ? AND postStatus = 'activ'";
        $stmt = mysqli_prepare($conn, $sql);
        $title = "%".$title."%";
        mysqli_stmt_bind_param($stmt, "s", $title);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        while($row = mysqli_fetch_assoc($result)){
            $post = [
                'postID'=> $row['postID'],
                'title'=> $row['title'],
                'content'=> $row['content']
            ];
            $posts[] = $post;
        }

    if(empty($posts))return null;
    return $posts;
}

function getPostsByID($postID)    {
    global $conn;
    $posts = [];

    $sql = "SELECT posts.postID, posts.title, posts.content ,categories.categoryID, categories.category_Name from posts join categories on posts.categoryID = categories.categoryID where postID = ? AND postStatus = 'activ'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postID);
    mysqli_stmt_execute($stmt);
    $entry = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $post = [
        'postID'=> $entry['postID'],
        'title'=> $entry['title'],
        'content'=> $entry['content'],
        'categoryID'=> $entry['categoryID'],
        'categoryName'=> $entry['category_Name'],
    ];

if(empty($post)) return null;

return $post;
}
function updatePost($post){
    global $conn;
    $sql = "UPDATE posts SET title =?, content=?, categoryID=? where postID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $post['title'],$post['content'],$post['categoryID'],$post['postID']);
    mysqli_stmt_execute($stmt);
}

function addPost($post){
    global $conn;
    $sql = "INSERT INTO posts(title,content,accountID,categoryID) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssii", $post['title'],$post['content'],$post['accountID'],$post['categoryID']);
    mysqli_stmt_execute($stmt);
}

function deletePost($postIDToDelete){
    global $conn;
    $sql = "UPDATE posts SET postStatus='sters' where postID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postIDToDelete);
    mysqli_stmt_execute($stmt);
}
function getCommentsForPost($postID){
    global $conn;
        $sql = "SELECT accounts.username, postcomments.comment from postcomments JOIN accounts ON postcomments.accountID = accounts.accountID where postID = ? ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $postID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $comments = [];
        while ($row = mysqli_fetch_assoc($result)){
            $comment = [
                "username" => $row["username"],
                "comment" => $row["comment"]
            ];
            $comments[] = $comment;
        }
        return $comments;
    }
function addComment($userId,$postId,$comment){
    global $conn;
    $sql = "INSERT INTO postcomments (postID, accountID, comment) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $postId,$userId,  $comment);
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        return true; 
    } else {
        return false; 
    }
}
function performLogIn($credentials){
    global $conn;
        $sql = "SELECT accountID, password, role from accounts where username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $credentials["username"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);
    
        if($data["password"] == $credentials["password"])
        {
            $dataGiven = [
                "role" =>  $data['role'],
                "accountID" =>  $data['accountID'],
            ];
            return $dataGiven;
        }

        else
            return null;
   
        }
function performSignUp($credentials){
            global $conn;
            if($credentials["reTypePassword"] != $credentials["password"]) return null;
    
            $sql = "SELECT role from accounts where username = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $credentials["username"]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            if($data !=null)
                return 1;
            
            $sql = "INSERT INTO accounts (username,password) VALUES (?,?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $credentials["username"],$credentials["password"]);
            mysqli_stmt_execute($stmt);
    
            return 2;
        }
?>