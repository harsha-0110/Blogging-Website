<?php
session_start();

include_once("dbconnect.php");
include_once("header.php");

$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
?>
    <h2 style="margin-left: 10px; font-weight: bold">Recent Posts:</h2>
    <?php while($row = mysqli_fetch_assoc($result)){
        $auth_id = $row["author"];
        $sql = "SELECT * FROM users WHERE id = $auth_id";
        $res = mysqli_query($conn, $sql);
        if ($result === false) {
            echo "Error: Query execution failed";
        } elseif (mysqli_num_rows($result) === 0) {
            echo "Error: No username found for ID " . $id;
        } else {
            $res1 = mysqli_fetch_assoc($res);
            $username = $res1["username"];
        }
        echo "<div class='w3-panel w3-sand w3-card-4' style='padding: 20px'>";
            echo "<h2 style='margin-top:0; font-weight: bold'>" . $row["title"] . "</h2>";
            echo "<p>" . $row["description"] . "</p>";
            echo "<br>";
            echo "Likes: " . $row["likes"];
            echo "<br>";
            echo "Created At: " . $row["created_at"];
            echo "<br>";
            echo "Author: " . $username;
            echo "<br>";
            if(!isset($_SESSION["username"])){
                echo "<p>Login to view full post</p>";
            }
            else{
                echo '<a class="w3-text-blue" href="view_post.php?id=' . $row["id"] . '">Read More...</a>';
            }
        echo "</div>";
    } ?>
<?php include_once("footer.php");?>