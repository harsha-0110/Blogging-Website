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
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://www.w3schools.com/w3css/4/w3.css">
    <script>
    function validateForm() {
        var email = document.forms["signup-box"]["email"].value;
        var username = document.forms["signup-box"]["username"].value;
        var password = document.forms["signup-box"]["password"].value;
        var confirm_password = document.forms["signup-box"]["confirm-password"].value;
        if(username.trim().length==0) {
            alert("Username should not contain spaces.");
            return false;
        }
        let upattern=/^[a-zA-Z0-9_-]{3,16}$/;
        if(!username.match(upattern)){
            alert("Invalid Username");
            return false;
        }
        if(password.length<8) {
            alert("Password should be greater the 8 characters");
            return false;
        }

        let pattern=/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{10,}/;
        if(!password.match(pattern)){
            alert("Invalid Password");
            return false;
        }
        if(password.localeCompare(confirm_password)!=0) {
            alert("Passwords dosen't match");
            return false;
        }
        return true;
    }
    </script>

</head>
<body>
    <div class="w3-container w3-teal">
        <h1>Bloggit</h1>
    </div>
    <div class="w3-bar w3-teal">
        <a href='home.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Home</a>
        <a href='index.php' class='w3-bar-item w3-button w3-mobile' style='margin-top: 1.5px'>Login</a>
    </div><br><br><br><br><br>
    <form method="post" id="login-box">
        <h3>Login: </h3>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password">
        <input class="w3-btn w3-teal w3-round" type="submit" name="login" value="Login">
        <div>
            <?php echo $msg; ?>
        </div>
    </form>
    
    
    <form method="post" id="signup-box" onsubmit="return validateForm()">
        <h3>Signup: </h3>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="password" name="confirm-password" placeholder="Confirm Password"><br>
        <input class="w3-btn w3-teal w3-round" type="submit" name="signup" value="Signup">
        <div>
            <?php echo $msg; ?>
        </div>
    </form>
    <br>
    <div id="signup-button">
        <label for="show-signup-form">Don't have account click the button to signup:</label>
        <button class="w3-btn w3-teal w3-round" id="show-signup-form">Signup</button>
    </div>
    <div id="login-button">
        <label for="show-login-form">Click the button to login:</label>
        <button class="w3-btn w3-teal w3-round" id="show-login-form">Login</button>
    </div>
    <br><br><br><br>
    <script>
        const showSignupForm = document.querySelector("#show-signup-form");
        const showLoginForm = document.querySelector("#show-login-form")
        const signupButton = document.querySelector("#signup-button");
        const loginButton = document.querySelector("#login-button");
        const signupForm = document.querySelector("#signup-box");
        const loginForm = document.querySelector("#login-box");
        showSignupForm.addEventListener("click", () => {
            signupForm.style.display = "block";
            loginForm.style.display = "none";
            loginButton.style.display = "block";
            signupButton.style.display = "none";
        });

        showLoginForm.addEventListener("click", () => {
            signupForm.style.display = "none";
            loginForm.style.display = "block";
            loginButton.style.display = "none";
            signupButton.style.display = "block";
        });
    </script>
<?php include_once("footer.php");?>
