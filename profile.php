<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection file
include_once 'dbconnect.php';

// Get the username stored in the session
$username = $_SESSION['username'];

// Retrieve the user's information from the database based on their username stored in the session
$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returned any results
if ($result->num_rows == 0) {
    echo 'User not found';
} else {
    // Fetch the user's information as an associative array
    $user = $result->fetch_assoc();
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $bio = $_POST['bio'];

    // Update the user's information in the database
    $stmt = $conn->prepare('UPDATE users SET name = ?, email = ?, phone_number = ?, dob = ?, bio = ? WHERE username = ?');
    $stmt->bind_param('ssssss', $name, $email, $phone_number, $dob, $bio, $username);
    $stmt->execute();

    // Redirect to the profile page
    header('Location: profile.php');
    exit();
}
include_once 'header.php';
?>

    <h1>Your Profile:</h1>
    <form method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <label>Phone number:</label>
        <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <label>Date of birth:</label>
        <input type="date" name="dob" value="<?php echo $user['dob']; ?>" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><br>

        <label>Bio:</label>
        <textarea name="bio" <?php echo isset($_POST['edit']) ? '' : 'readonly'; ?>><?php echo $user['bio']; ?></textarea><br>

        <?php if (isset($_POST['edit'])): ?>
            <input class="w3-btn w3-teal w3-round" type="submit" name="submit" value="Save Changes">
        <?php else: ?>
            <button class="w3-btn w3-teal w3-round" type="submit" name="edit">Edit</button>
        <?php endif; ?>
    </form>
<?php include_once("footer.php");?>