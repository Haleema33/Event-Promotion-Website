<?php


// Start or resume the session
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Set session variables
$_SESSION;

// Include our Website API
include("api/api.inc.php");

// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    $tcontent = <<<PAGE
    <!--Incluse our CSS style sheets-->>
    <link href="css/login.css" rel="stylesheet"> 
    
    
   
    <h2>This is SignUp Page.</h2>
    Hello, User. <br><br>
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
$tpagecontent = createPage();




// Set dynamic content
$loginBoxContent = <<<HTML
<div class="login-box">
    <h2>SignUp</h2>
    <form class="login-form" action="login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="SignUp"><br><br>

        <a href="signup.php">Click here to Login.</a>
    </form>
</div>
HTML;


// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tindexpage = new MasterPage("Home Page");
$tindexpage->setDynamic1($tpagecontent);
$tindexpage->setDynamic2($loginBoxContent);
$tindexpage->renderPage();
?>
