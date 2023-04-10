<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit;
    }
    include_once("dbconnect.php");
    include_once("header.php");
    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

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

    // Query the database for the user's posts
    $sql = "SELECT * FROM posts WHERE author = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Display the user's posts
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="w3-panel w3-sand w3-card-4 w3-padding-16">';
            echo "<h3>Title: </h3>";
            echo "<h3>" . $row["title"] . "</h3>";
            echo "<h3>Description:</h3>";
            echo "<p style='text-align: justify;'>" . $row["description"] . "</p>";
            echo "<br>";
            echo "<h3>Content:</h3>";
            echo "<p>" . $row["content"] . "</p>";
            echo "<a class='w3-btn w3-teal w3-round' href='edit_post.php?id=" . $row["id"] . "'>Edit</a> ";
            echo "<a class='w3-btn w3-teal w3-round' href='delete_post.php?id=" . $row["id"] . "'>Delete</a>";
            echo '</div>';
        }
    } else {
        echo "No posts found";
    }

    // Close the database connection
    mysqli_close($conn);
?>
<?php include_once("footer.php");?>