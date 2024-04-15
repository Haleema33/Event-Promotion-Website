<?php

// Start or resume the session
session_start();

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
    
    <a href="Login_Signup/logout.php">Log out</a>  
    <br> 
    <h2>This is Login Page.</h2>
    Hello, Username. <br><br>
    PAGE;
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
$tpagecontent = createPage();




// Set dynamic content
$loginBoxContent = <<<HTML
<div class="login-box">
    <h2>Login</h2>
    <form class="login-form" action="login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login"><br><br>

        <a href="signup.php">Click here to Sigup</a>
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
