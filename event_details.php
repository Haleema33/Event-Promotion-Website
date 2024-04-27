<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ----INCLUDE APIS------------------------------------
// Include our Website API
include("api/api.inc.php");
include("connection.php");  // Assume this file correctly sets up $mysqli

// ----PAGE GENERATION LOGIC---------------------------
function createPage($mysqli) {
    if ($mysqli->connect_error) {
        die('Connection failed: ' . $mysqli->connect_error);
    }

    if (!isset($_GET['id'])) {
        return "<p>Event ID is required.</p>";
    }

    $event_id = $_GET['id'];
    $query = "SELECT id, name, details, date_time, location, category, artist_details, artist_link FROM events WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        return "<p>Prepare failed: " . htmlspecialchars($mysqli->error) . "</p>";
    }
    
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $details, $date_time, $location, $category, $artist_details, $artist_link);

    $tcontent = "";
    if ($stmt->fetch()) {
        $tcontent = <<<HTML
        <div style="font-family: Arial, sans-serif; margin: 20px; padding: 20px; border-radius: 8px; background: #f9f9f9; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h1 style="color: #333;">Event Details</h1>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Details:</strong> {$details}</p>
            <p><strong>Date and Time:</strong> {$date_time}</p>
            <p><strong>Location:</strong> {$location}</p>
            <p><strong>Category:</strong> {$category}</p>
            <p><strong>Artist Details:</strong> {$artist_details}</p>
            <p><strong>Artist Link:</strong> <a href="{$artist_link}" target="_blank">Visit Artist</a></p>
        </div>
HTML;
    } else {
        $tcontent = "<p>No event found with ID {$event_id}.</p>";
    }
    
    $stmt->close();
    return $tcontent;
}

// ----BUSINESS LOGIC---------------------------------
$tpagecontent = createPage($mysqli); // Pass $mysqli to the function

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of your page class
$tindexpage = new MasterPage("Home Page");
$tindexpage->setDynamic1($tpagecontent);
$tindexpage->renderPage();

$mysqli->close();

?>
