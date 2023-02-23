<!DOCTYPE html>
<html>
<head>
  <title>BloggIT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
        <a href='home.php' class='w3-bar-item w3-button w3-mobile'>Home</a>
        <a href='create_post.php' class='w3-bar-item w3-button w3-mobile'>Create Post</a>
        <a href='manage_posts.php' class='w3-bar-item w3-button w3-mobile'>Manage Posts</a>
        <a href='logout.php' class='w3-bar-item w3-button w3-mobile'>Logout</a>
    </div>
