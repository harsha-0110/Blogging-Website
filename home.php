<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: index.php");
}
include_once("dbconnect.php");
include_once("header.php");

$sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 10";
$result = mysqli_query($conn, $sql);
?>
    <h2 style="margin-left: 10px; font-weight: bold">Recent Posts:</h2>
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <div class="w3-panel w3-sand w3-card-4" style="padding: 20px">
            
            <?php
                echo "<h2 style='font-weight: bold'>" . $row["title"] . "</h2>";
                echo "<h3 style='font-weight: bold'>Description:</h3>";
                echo "<p>" . $row["description"] . "</p>";
                echo "<br>";
                echo "Likes: " . $row["likes"];
                echo "<br>";
                echo "Created At: " . $row["created_at"];
                echo "<br>";
                echo "Author ID: " . $row["author"];
                echo "<br>";
            ?>
            <?php echo '<a class="w3-text-blue" href="view_post.php?id=' . $row["id"] . '">Read More...</a>'; ?>
    </div>
<?php } ?>
<?php include_once("footer.php");?>