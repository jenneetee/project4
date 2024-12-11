document.addEventListener('DOMContentLoaded', () => {
    // Fetch properties from the server when the page loads
    fetchProperties();

    // Add event listener to the "+" button
    document.getElementById('add-property').addEventListener('click', () => {
        window.location.href = 'add-property.php';  // Redirect to the Add Property page
    });
});

function fetchProperties() {
    fetch('fetch_properties.php')
        .then(response => response.json())
        .then(data => {
            const propertyCardsContainer = document.getElementById('property-cards');
            propertyCardsContainer.innerHTML = '';  // Clear the container before adding new cards

            if (data.length === 0) {
                propertyCardsContainer.innerHTML = '<p>No properties added. Click "+" to add a new property.</p>';
            } else {
                data.forEach(property => {
                    const card = document.createElement('div');
                    card.classList.add('card');
                    card.innerHTML = `
                        <img src="${property.image_url}" alt="Property Image">
                        <h3>${property.location}</h3>
                        <p>Price: $${property.price}</p>
                        <p>Bedrooms: ${property.bedrooms}</p>
                        <p>Bathrooms: ${property.bathrooms}</p>
                        <button onclick="viewProperty(${property.id})">View Details</button>
                    `;
                    propertyCardsContainer.appendChild(card);
                });
            }
        })
        .catch(error => console.error('Error fetching properties:', error));
}

function viewProperty(propertyId) {
    window.location.href = `property-details.php?id=${propertyId}`;  // Redirect to the property details page
}
