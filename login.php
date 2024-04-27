<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  // Start the session at the very beginning
include 'connection.php';  // Include your DB connection
include("api/api.inc.php");  // Include your Website API

$error_message = "";  // Initialize error message variable

// Handle POST request before any HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the select statement to fetch user details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");  // Redirect to the home page on success
        exit;
    } else {
        $error_message = "Invalid username or password. Click here to register new user! <a href='signup.php'>Signup</a>.";

    }
}

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    return <<<PAGE
    <!-- Include our CSS style sheets -->
    <link href="css/login.css" rel="stylesheet"> 
    <h2>This is the Login Page.</h2>
    PAGE;
}

$tpagecontent = createPage();

// Set dynamic content
$loginBoxContent = <<<HTML
<div class="login-box">
    <h2>Login</h2>
    <form class="login-form" action="" method="post"> <!-- Form submits to the same page -->
        <input type="text" name="username" placeholder="Username">
        <div class="password-wrapper" style="position:relative;">
            <input type="password" name="password" id="password" placeholder="Password" style="padding-right:30px;">
            <button type="button" onclick="togglePasswordVisibility()" style="position:absolute; right:0; top:0; border:none; background:none; cursor:pointer;">👁️</button>
        </div>
        <input type="submit" value="Login"><br><br>
        <!-- Display error message if set -->
        <div class="error">{$error_message}</div>
    </form>
    <script>
function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
}
</script>
</div>
HTML;

// ----BUILD OUR HTML PAGE----------------------------
$tindexpage = new MasterPage("Home Page");
$tindexpage->setDynamic1($tpagecontent);
$tindexpage->setDynamic2($loginBoxContent);
$tindexpage->renderPage();
?>
