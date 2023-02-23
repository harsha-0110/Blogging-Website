<?php
session_start();
$msg ='';
if(isset($_SESSION["username"])){
    header("Location: home.php");
}
include_once("dbconnect.php");

if(isset($_POST["signup"])){
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    $result = mysqli_query($conn, $sql);

    if($result){
        $msg = "User Created Sucessfully";
    } else {
        $msg = mysqli_error($conn);
    }
}

if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 1){
        $_SESSION["username"] = $username;
        $_SESSION["id"] = $row["id"];
        header("Location: home.php");
    } else {
        $msg = "Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>BloggIT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <div class="w3-container w3-teal">
        <h1>Bloggit</h1>
    </div>
    <h2>Login</h2>
    <form method="post" style="margin: auto; border: 1px solid grey; width: 75%; padding: 10px; border-radius: 5px">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input class="w3-btn w3-teal w3-round" type="submit" name="login" value="Login">
    </form>
    <div>
        <?php echo $msg; ?>
    </div>
    <h2>Signup</h2>
    <form method="post" style="margin: auto; border: 1px solid grey; width: 75%; padding: 10px; border-radius: 5px">
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input class="w3-btn w3-teal w3-round" type="submit" name="signup" value="Signup">
    </form>
</body>
</html>
