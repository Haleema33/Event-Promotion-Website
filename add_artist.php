<?php
include("connection.php"); // Ensure this file correctly sets up $conn



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $bio = htmlspecialchars(strip_tags($_POST['bio']));
    $social = htmlspecialchars(strip_tags($_POST['social']));
    $picture = $_FILES['picture']['name'];

    // Check for errors in the file upload
    if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        // Attempt to move the uploaded file
        $uploadPath = "uploads/" . basename($picture);
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadPath)) {
            // Prepare SQL statement to insert data
            $sql = "INSERT INTO artist (name, biography, social_media, picture) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo "Error preparing query: " . htmlspecialchars($conn-> error);
            } else {
                $stmt->bind_param("ssss", $name, $bio, $social, $picture);
                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        echo "Artist added successfully.";
                    } else {
                        echo "No data was added.";
                    }
                } else {
                    echo "Error executing query: " . htmlspecialchars($stmt-> error);
                }
                $stmt->close();
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "File upload error: " . $_FILES['picture']['error'];
    }
    $conn->close();
}

?>
