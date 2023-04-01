<!DOCTYPE html>
<html>
<head>
  <title>BloggIT</title>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.tiny.cloud/1/1c0d1gc0geamwj5ml8hw7f2rvbt0xhm048ats35qeai4bt3m/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: '#content',
      plugins: 'link image code',
      toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | image link',
      height: 400
    });
  </script>
</head>
<body>
  <div class="w3-container w3-center w3-teal">
    <h1>Bloggit</h1>
  </div>
    <div class="w3-bar w3-teal">
    <?php if(isset($_SESSION["username"])){
      echo "<a href='home.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Home</a>";
      echo "<a href='create_post.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Create Post</a>";
      echo "<a href='manage_posts.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Manage Posts</a>";
      echo "<a href='logout.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Logout</a>";
      $current_page = basename($_SERVER['PHP_SELF']);
      if ($current_page === 'home.php') {
        echo "<form class='w3-bar-item w3-right' action='search.php' style='margin: 0px; padding: 0px' method='GET'>";
        echo "<input type='text' name='q' class='w3-bar-item w3-input' style='margin: 0px' placeholder='Search for any post...' required>";
        echo "<input type='submit' class='w3-bar-item w3-button w3-teal' value='Search' style='margin: 0.5px'>";
        echo "</form>";
      }
    }
    else{
      echo "<a href='home.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Home</a>";
      echo "<a href='index.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Login</a>";
    }
    ?>
    </div>