<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Connect to the database
include_once("dbconnect.php");

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the post ID from the query string
if (!isset($_GET["id"])) {
    header("Location: manage_posts.php");
    exit;
}
$post_id = $_GET["id"];

// Get the current user's ID
$username = $_SESSION["username"];
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row["id"];
} else {
    die("Error: User not found");
}

// Check if the user is the author of the post
$sql = "SELECT * FROM posts WHERE id = '$post_id' AND author = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    // The user is the author of the post, delete the post and all associated likes and comments
    $sql = "DELETE FROM likes WHERE post_id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    
    $sql = "DELETE FROM comments WHERE post_id = '$post_id'";
    $result = mysqli_query($conn, $sql);
    
    $sql = "DELETE FROM posts WHERE id = '$post_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error deleting post: " . mysqli_error($conn);
    } else {
        header("Location: manage_posts.php");
        exit;
    }
} else {
    // The user is not the author of the post, redirect them to the manage_posts page
    header("Location: manage_posts.php");
    exit;
}

// Close the database connection
mysqli_close($conn);
?>
