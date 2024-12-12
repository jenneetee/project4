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

    // Handle image upload
    $image_url = null;
    if (isset($_FILES['property_image']) && $_FILES['property_image']['error'] === UPLOAD_ERR_OK) {
        // Ensure the file is an image
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = pathinfo($_FILES['property_image']['name'], PATHINFO_EXTENSION);
        
        if (in_array(strtolower($image_extension), $allowed_extensions)) {
            // Generate a unique name for the image to avoid overwriting
            $image_name = uniqid() . '.' . $image_extension;
            $image_path = 'uploads/' . $image_name;

            // Move the uploaded image to the uploads directory
            if (move_uploaded_file($_FILES['property_image']['tmp_name'], $image_path)) {
                $image_url = $image_path;  // Save the path to the database
            }
        } else {
            echo "Invalid image type. Allowed types are: jpg, jpeg, png, gif.";
        }
    }

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
        <form action="add-property.php" method="POST" enctype="multipart/form-data">
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
                <label for="proximity_facilities">Features:</label>
                <textarea id="proximity_facilities" name="proximity_facilities" required></textarea>
            </div>
            <div>
                <label for="proximity_roads">Description:</label>
                <textarea id="proximity_roads" name="proximity_roads" required></textarea>
            </div>
            <div>
                <label for="property_image">Image:</label>
                <input type="file" id="property_image" name="property_image" accept="image/*">
            </div>
            <button type="submit">Add Property</button>
        </form>
    </div>
</body>
</html>
