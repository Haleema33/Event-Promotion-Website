<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// ----INCLUDE APIS------------------------------------
// Include our Website API
include("api/api.inc.php");
include("connection.php");  // Include the database connection
include("fetch_events.php"); 
// ----PAGE GENERATION LOGIC---------------------------
function createPage()
{
    $tcontent = <<<PAGE
<h2>This is Event Page.</h2>
PAGE;
    return $tcontent;

}
function includeJavaScript() {
    return "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'></script>

                function filterEvents(field, value) {
                    $.ajax({
                        url: 'fetch_events.php',
                        type: 'GET',
                        data: { field: field, value: value },
                        success: function(response) {
                            $('#events-container').html(response);
                        },
                        error: function() {
                            alert('Error loading data');
                        }
                    });
                }
            </script>";
}
function displayEvents($mysqli) {
 // Check if the connection is valid
if ($mysqli->connect_error) {
    return "Failed to connect to MySQL: " . $mysqli->connect_error;
}

// Fetch upcoming and past events
$currentDate = date('Y-m-d H:i:s');
$upcomingQuery = "SELECT e.id, e.name, e.date_time, e.artist_details, e.category FROM events e WHERE e.date_time >= '$currentDate' ORDER BY e.date_time ASC";
$pastQuery = "SELECT e.id, e.name, e.date_time, e.artist_details, e.category FROM events e WHERE e.date_time < '$currentDate' ORDER BY e.date_time DESC";

// Execute queries
$upcomingResult = $mysqli->query($upcomingQuery);
$pastResult = $mysqli->query($pastQuery);


// Start building the HTML for events display
$html = <<<HTML
<div style="display: flex; flex-direction: column; width: 100%; padding: 20px; background-color: #f0f0f0; border: 1px solid #ccc;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
    
        <h2>Events</h2>
        <div>
            <select onchange="filterEvents('date_time', this.value);">
                <option value="">Filter by Date</option>
HTML;

// Fetch unique dates from the database
$dateQuery = "SELECT DISTINCT date_time FROM events ORDER BY date_time";
$dateResult = $mysqli->query($dateQuery);
while ($date = $dateResult->fetch_assoc()) {
    $html .= "<option value='{$date['date_time']}'>{$date['date_time']}</option>";
}

$html .= "</select>";
$html .= "<select onchange=\"filterEvents('artist', this.value);\">
            <option value=''>Filter by Artist</option>";

// Fetch unique artists from the database
$artistQuery = "SELECT DISTINCT artist_details FROM events ORDER BY artist_details";
$artistResult = $mysqli->query($artistQuery);
while ($artist = $artistResult->fetch_assoc()) {
    $html .= "<option value='{$artist['artist_details']}'>{$artist['artist_details']}</option>";
}

$html .= "</select>";
$html .= "<select onchange=\"filterEvents('category', this.value);\">
            <option value=''>Filter by Category</option>
            <option value='music'>Music</option>
            <option value='poetry'>Poetry</option>
            <option value='comedy'>Comedy</option>";


            // Fetch unique categories from the database
$categoryQuery = "SELECT DISTINCT category FROM events ORDER BY category";
$categoryResult = $mysqli->query($categoryQuery);
while ($category = $categoryResult->fetch_assoc()) {
$html .= "<option value='{$category['category']}'>{$category['category']}</option>";
}
$html .= "</select>";


// The rest of your HTML for displaying events...
$html .= "</div></div><div style='width: 100%; padding: 20px; background-color: #e0e0e0; margin-top: 20px;'>
    <h3>Upcoming Events</h3>
    <div style='display: flex; flex-direction: column; justify-content: start;'>";

// Process upcoming events
if ($upcomingResult->num_rows > 0) {
    while($row = $upcomingResult->fetch_assoc()) {
        $html .= "<form action='event_details.php' method='GET' style='margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;'>
                    <h3>{$row['name']}</h3>
                    <p>Date and Time: {$row['date_time']}</p>
                    <p>Artist Details: {$row['artist_details']}</p>
                    <p>Category: {$row['category']}</p>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit'>More Details</button>
                  </form>";
    }
} else {
    $html .= "<p>No upcoming events.</p>";
   
    // Include JavaScript for dynamic filtering, outside of the event check
   
    return $html;
}
     

$html .= "</div></div><div style='width: 100%; padding: 20px; background-color: #e0e0e0;; margin-top: 20px;'>
    <h3>Past Events</h3>
    <div style='display: flex; flex-direction: column; justify-content: start;'>";

// Process past events
if ($pastResult->num_rows > 0) {
    while($row = $pastResult->fetch_assoc()) {
        $html .= "<form action='event_details.php' method='GET' style='margin-bottom: 20px; padding: 10px; border: 1px solid #ccc;'>
                    <h3>{$row['name']}</h3>
                    <p>Date and Time: {$row['date_time']}</p>
                    <p>Artist Details: {$row['artist_details']}</p>
                    <p>Category: {$row['category']}</p>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <button type='submit'>More Details</button>
                  </form>";
    }
} else {
    $html .= "<p>No past events.</p>";
}

$html .= "</div></div></div>";


return $html;

}

// ----BUSINESS LOGIC---------------------------------
$tpagecontent = createPage();
$tpagecontent2= includeJavaScript();
$tpageContent3 = displayEvents($mysqli); // Ensure that $mysqli is passed

// ----BUILD OUR HTML PAGE----------------------------
// Create an instance of our Page class
$tindexpage = new MasterPage("Home Page");
$tindexpage->setDynamic1($tpagecontent);
$tindexpage->setDynamic2($tpageContent2);
$tindexpage->setDynamic3($tpageContent3);
$tindexpage->renderPage();
?>
