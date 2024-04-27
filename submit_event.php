<?php
// submit_event.php

// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Capture form data
    $eventName = $_POST['eventName'] ?? 'No Event Name';
    $eventDetails = $_POST['eventDetails'] ?? 'No Event Details';
    $eventDate = $_POST['eventDate'] ?? 'No Event Date';
    $eventLocation = $_POST['eventLocation'] ?? 'No Event Location';
    $eventCategory = $_POST['eventCategory'] ?? 'No Event Category';
    $artistDetails = $_POST['artistDetails'] ?? 'No Artist Details';
    $artistLink = $_POST['artistLink'] ?? 'No Artist Link';

    // Start of response HTML and CSS
    $response = "<div style='margin-top: 20px; padding: 20px; background-color: #f9f9f9; border: 1px solid #d3d3d3; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 5px;'>
                    <h3 style='color: #4CAF50; margin-bottom: 15px;'>Event Submitted Successfully</h3>
                    <p><strong>Event Name:</strong> $eventName</p>
                    <p><strong>Details:</strong> $eventDetails</p>
                    <p><strong>Date:</strong> $eventDate</p>
                    <p><strong>Location:</strong> $eventLocation</p>
                    <p><strong>Category:</strong> $eventCategory</p>
                    <p><strong>Artist:</strong> $artistDetails</p>
                    <p><strong>Artist Info:</strong> $artistLink</p>
                </div>";

    echo $response;
} else {
    echo "Error: Not a valid AJAX request.";
}
?>
