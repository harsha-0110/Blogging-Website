<?php
session_start();
// Establish a database connection
include_once("dbconnect.php");
include_once("header.php");

$post_id = $_GET['id'];
if(!isset($_SESSION["username"])){
    header("Location: index.php");
}
// Check for connection errors
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
include_once("like.php");
if(isset($_POST["comment"])){
    $post_id = $_POST["post_id"];
    $comment = $_POST["comment"];
    $username = $_SESSION["username"];

    $sql = "INSERT INTO comments (post_id, comment, username) VALUES ($post_id, '$comment', '$username')";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        echo "Error: " . mysqli_error($conn);
    }
}
?>

    <div class="w3-panel w3-sand w3-card-4">
        <?php
            $auth_id = $row["author"];
            $sql = "SELECT * FROM users WHERE id = $auth_id";
            $res = mysqli_query($conn, $sql);
            if ($result === false) {
                echo "Error: Query execution failed";
            } 
            else {
                $res1 = mysqli_fetch_assoc($res);
                $username = $res1["username"];
            }
            echo "<h3 style='font-weight: bold; text-align: center;'>" . $row["title"] . "</h3>";
            echo $row["content"];
            echo "<br><br>";
            echo "<p>Author: " . $username . "</p>";
            echo "Created At: " . $row["created_at"];
        ?>
        
        <?php
        if ($liked) {
            echo "<form method='post'>";
            echo "<input type='hidden' name='like' />";
            echo "<button class='w3-btn w3-teal w3-round' type='submit'>Liked($likes)</button>";
            echo "</form>";
        } else {
            echo "<form method='post'>";
            echo "<input type='hidden' name='like' />";
            echo "<button class='w3-btn w3-teal w3-round' type='submit'>Like($likes)</button>";
            echo "</form>";
        }
        ?>
        <h4>Comments</h4>
        <?php
            $post_id = $row["id"];
            $sql_comments = "SELECT * FROM comments WHERE post_id = $post_id";
            $result_comments = mysqli_query($conn, $sql_comments);
            while($row_comments = mysqli_fetch_assoc($result_comments)){
                echo "<p>".$row_comments["username"].": ".$row_comments["comment"]."</p>";
            }
        ?>
        <form method="post">
            <input type="hidden" name="post_id" value="<?php echo $row["id"]; ?>">
            <input type="text" name="comment" placeholder="Add a comment">
            <button type="submit" class="w3-btn w3-teal w3-round" name="submit_comment">Comment</button>
        </form>
    </div>
<?php include_once("footer.php");?>