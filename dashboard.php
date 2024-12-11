<?php
session_start();
include('db.php');  // Include the database connection

// Assuming the user is logged in and has a user_id in the session
$user_id = $_SESSION['user_id'];

// Fetch properties from the database for the logged-in user
$query = "SELECT * FROM properties WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Luxe Listings</h1>
        <h2>My Properties</h2>
        <div id="property-cards" class="property-cards">
            <!-- Property cards will be displayed here -->
            <?php
            // Check if there are properties
            if ($result->num_rows > 0) {
                while ($property = $result->fetch_assoc()) {
                    // Start a property card for each property
                    echo '<div class="card">';
                    echo '<h3>' . htmlspecialchars($property['location']) . '</h3>';
                    echo '<p>Price: $' . number_format($property['price']) . '</p>';
                    echo '<p>Bedrooms: ' . $property['bedrooms'] . '</p>';
                    echo '<p>Bathrooms: ' . $property['bathrooms'] . '</p>';
                    
                    // Check if an image exists and display it
                    if (!empty($property['image_url'])) {
                        $image_url = $property['image_url'];  // Assuming the image URL is relative
                        echo '<img src="' . $image_url . '" alt="Property Image" style="width:100px; height:auto;">';
                    } else {
                        echo '<p>No image available.</p>';
                    }

                    // View Details, Edit, and Delete buttons
                    echo '<button onclick="viewProperty(' . $property['id'] . ')">View Details</button>';
                    echo '<button onclick="editProperty(' . $property['id'] . ')">Edit</button>';
                    echo '<button onclick="deleteProperty(' . $property['id'] . ')">Delete</button>';
                    echo '</div>';
                }
            } else {
                echo '<p>No properties found.</p>';
            }
            ?>
        </div>
        <button id="add-property" class="add-property-btn">+</button>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
