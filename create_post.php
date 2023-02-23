<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: index.php");
}
include_once("dbconnect.php");
include_once("header.php");

if(isset($_POST["create_post"])){
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $content = mysqli_real_escape_string($conn, $_POST["content"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $username = $_SESSION["id"];
    $sql = "INSERT INTO posts (title, content, author, created_at, description) VALUES ('$title', '$content', '$username', NOW(), '$description')";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: home.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
  <form method="post" style="width: 100%; padding: 30px">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br><br>
    <label for="description">Description:</label><br>
    <textarea name="description" id="description" require></textarea><br><br>
    <label for="content">Content:</label>
    <textarea name="content" id="content"></textarea><br><br>
    <button class="w3-btn w3-teal w3-round" type="submit" name="create_post">Create Post</button>
  </form>
</body>
</html>