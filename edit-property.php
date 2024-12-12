<?php
include('db.php');  // Include the database connection

// Check if the ID is provided
if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    // Fetch the current property details from the database
    $query = "SELECT * FROM properties WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();

    if (!$property) {
        die('Property not found.');
    }
} else {
    die('Invalid property ID.');
}

// Handle form submission to update the property
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $image_url = $_POST['image_url'];  // Image URL instead of upload

    // Update the property in the database
    $query = "UPDATE properties SET location = ?, price = ?, age = ?, square_footage = ?, bedrooms = ?, bathrooms = ?, garden = ?, parking = ?, proximity_facilities = ?, proximity_roads = ?, image_url = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('siiiiiisssdi', $location, $price, $age, $square_footage, $bedrooms, $bathrooms, $garden, $parking, $proximity_facilities, $proximity_roads, $image_url, $property_id);
    $stmt->execute();
    header('Location: dashboard.php');  // Redirect to the dashboard after updating
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link rel="stylesheet" href="addProperty.css">
</head>
<body>
    <div class="container">
        <h1>Edit Property</h1>
        <form action="edit-property.php?id=<?php echo $property_id; ?>" method="POST">
            <div>
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required>
            </div>
            <div>
                <label for="price">Price ($):</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
            </div>
            <div>
                <label for="age">Age (in years):</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($property['age']); ?>" required>
            </div>
            <div>
                <label for="square_footage">Square Footage:</label>
                <input type="number" id="square_footage" name="square_footage" value="<?php echo htmlspecialchars($property['square_footage']); ?>" required>
            </div>
            <div>
                <label for="bedrooms">Bedrooms:</label>
                <input type="number" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>
            </div>
            <div>
                <label for="bathrooms">Bathrooms:</label>
                <input type="number" id="bathrooms" name="bathrooms" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>
            </div>
            <div>
                <label for="garden">Garden:</label>
                <input type="checkbox" id="garden" name="garden" <?php echo $property['garden'] ? 'checked' : ''; ?>>
            </div>
            <div>
                <label for="parking">Parking:</label>
                <input type="checkbox" id="parking" name="parking" <?php echo $property['parking'] ? 'checked' : ''; ?>>
            </div>
            <div>
                <label for="proximity_facilities">Proximity to Facilities:</label>
                <input type="text" id="proximity_facilities" name="proximity_facilities" value="<?php echo htmlspecialchars($property['proximity_facilities']); ?>" required>
            </div>
            <div>
                <label for="proximity_roads">Proximity to Roads:</label>
                <input type="text" id="proximity_roads" name="proximity_roads" value="<?php echo htmlspecialchars($property['proximity_roads']); ?>" required>
            </div>
            <div>
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" value="<?php echo htmlspecialchars($property['image_url']); ?>" required>
            </div>
            <div>
                <button type="submit">Update Property</button>
            </div>
        </form>
    </div>
</body>
</html>
