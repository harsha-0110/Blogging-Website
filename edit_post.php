<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Connect to the database
include_once("dbconnect.php");
include_once("header.php");

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
    // The user is the author of the post, allow them to edit it
    $row = mysqli_fetch_assoc($result);
    $title = $row["title"];
    $content = $row["content"];
    $description = $row["description"];
} else {
    // The user is not the author of the post, redirect them to the manage_posts page
    header("Location: manage_posts.php");
    exit;
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $content = mysqli_real_escape_string($conn, $_POST["content"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    // Update the post in the database
    $sql = "UPDATE posts SET title = '$title', content = '$content', description = '$description' WHERE id = '$post_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error updating post: " . mysqli_error($conn);
    } else {
        header("Location: manage_posts.php");
        exit;
    }
}

// Close the database connection
mysqli_close($conn);
?>

    <form method="post" style="width: 100%; padding: 30px">
        <label>Title</label>
        <input type="text" name="title" value="<?php echo $title; ?>" required><br><br>
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="<?php echo $description; ?>" required><br><br>
        <label>Content</label>
        <textarea name="content" id="content" required><?php echo $content; ?></textarea>

        <button class="w3-btn w3-teal w3-round" type="submit">Save Changes</button>
    </form>
<?php include_once("footer.php");?>