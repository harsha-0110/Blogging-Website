<?php
session_start();
include_once("dbconnect.php");
include_once("header.php");

if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string($conn, $_GET['q']);
    $sql = "SELECT * FROM posts WHERE title LIKE '%{$q}%' OR description LIKE '%{$q}%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) < 1) {
        echo "Nothing found.";
    } else {

      echo "<div class='w3-container'>Showing results for $q</div>";

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='w3-panel w3-sand w3-card-4' style='padding: 20px'>";
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
            echo '<a class="w3-text-blue" href="view_post.php?id=' . $row["id"] . '">Read More...</a>';
        echo "</div>";
      }

    }
}
include("footer.php");
?>