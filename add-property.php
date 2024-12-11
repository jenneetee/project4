<?php
session_start();
include('db.php');  // Include the database connection

// Temporary: Set a default user ID for testing
$_SESSION['user_id'] = 1; // Replace 1 with an appropriate user ID from your database

// Handle form submission to add a property
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values and sanitize inputs
    $user_id = $_SESSION['user_id'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $age = $_POST['age'];
    $square_footage = $_POST['square_footage'];
    $bedrooms = $_POST['bedrooms'];
    $bathrooms = $_POST['bathrooms'];
    $garden = isset($_POST['garden']) ? 1 : 0;
    $parking = isset($_POST['parking']) ? 1 : 0;
    $proximity_facilities = $_POST['proximity_facilities'];
    $proximity_roads = $_POST['proximity_roads'];

    // Get image URL from input
    $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : null;

    // Calculate the property tax (7% of price)
    $property_tax = $price * 0.07;

    // Insert property into the database
    $query = "INSERT INTO properties (user_id, location, price, age, square_footage, bedrooms, bathrooms, garden, parking, proximity_facilities, proximity_roads, image_url, property_tax) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isiiiiiissssd', $user_id, $location, $price, $age, $square_footage, $bedrooms, $bathrooms, $garden, $parking, $proximity_facilities, $proximity_roads, $image_url, $property_tax);
    $stmt->execute();
    
    // Redirect to dashboard after adding property
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Property</title>
    <link rel="stylesheet" href="addProperty.css">
</head>
<body>
    <div class="container">
        <h1>Add New Property</h1>
        <form action="add-property.php" method="POST">
            <div>
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div>
                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" required>
            </div>
            <div>
                <label for="age">Age (in years):</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div>
                <label for="square_footage">Square Footage:</label>
                <input type="number" id="square_footage" name="square_footage" required>
            </div>
            <div>
                <label for="bedrooms">Bedrooms:</label>
                <input type="number" id="bedrooms" name="bedrooms" required>
            </div>
            <div>
                <label for="bathrooms">Bathrooms:</label>
                <input type="number" id="bathrooms" name="bathrooms" required>
            </div>
            <div>
                <label for="garden">Garden:</label>
                <input type="checkbox" id="garden" name="garden">
            </div>
            <div>
                <label for="parking">Parking:</label>
                <input type="checkbox" id="parking" name="parking">
            </div>
            <div>
                <label for="proximity_facilities">Proximity to Facilities:</label>
                <textarea id="proximity_facilities" name="proximity_facilities" required></textarea>
            </div>
            <div>
                <label for="proximity_roads">Proximity to Roads:</label>
                <textarea id="proximity_roads" name="proximity_roads" required></textarea>
            </div>
            <div>
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" placeholder="Enter the image URL">
                <img id="image-preview" style="display:none; max-width: 100px; margin-top: 10px;" alt="Image Preview">
            </div>
            <button type="submit">Add Property</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageUrlInput = document.getElementById('image_url');
            const imagePreview = document.getElementById('image-preview');

            // Show image preview when the user enters an image URL
            imageUrlInput.addEventListener('input', function () {
                const url = imageUrlInput.value;
                if (url) {
                    imagePreview.src = url;
                    imagePreview.style.display = 'block'; // Show the image preview
                } else {
                    imagePreview.style.display = 'none'; // Hide the image preview if no URL
                }
            });
        });
    </script>
</body>
</html>
