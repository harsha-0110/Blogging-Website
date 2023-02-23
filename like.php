<?php
// Get the post ID from the query string
$post_id = $_GET['id'];
$user_id = $_SESSION['id'];

// Retrieve the post details from the database
$query = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo "Error in preparing query: " . $conn->error;
    exit();
}

$stmt->bind_param("i", $post_id);
$stmt->execute();

$result = $stmt->get_result();

// Check if the post exists
if ($result->num_rows == 0) {
    echo "Post not found.";
    exit();
}

$row = $result->fetch_assoc();
$title = $row['title'];
$content = $row['content'];
$likes = $row['likes'];
// Check if the user has liked this post
$query = "SELECT * FROM post_likes WHERE post_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
 
if (!$stmt) {
    echo "Error in preparing query: " . $conn->error;
    exit();
}

$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();

$liked_result = $stmt->get_result();

// Check for any errors in the query execution
if (!$liked_result) {
    echo "Error in executing query: " . $conn->error;
    exit();
}

$liked = ($liked_result->num_rows > 0);

// If the like button is clicked, toggle the like status
if (isset($_POST['like'])) {
    if ($liked) {
        $query = "DELETE FROM post_likes WHERE post_id = $post_id AND user_id = $user_id";
        $sql = "UPDATE posts SET likes = likes - 1 WHERE id = $post_id";
        $likes = strval(intval($likes) - 1);
    } else {
        $query = "INSERT INTO post_likes (post_id, user_id, created_at) VALUES ($post_id, $user_id, NOW())";
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = $post_id";
        $likes = strval(intval($likes) + 1);
    }

    $stmt = mysqli_query($conn, $query);
    $stmt = mysqli_query($conn, $sql);
    

    // Check for any errors in the query execution
    if (!$result) {
        echo "Error in executing query: " . mysqli_error($conn);
        exit();
    }

    // Toggle the liked status
    $liked = !$liked;
}
?>