// Credit Card Detection
const cardNumberInput = document.getElementById('card_number');
const cardTypeImage = document.getElementById('card_type_image');
const cardTypeDisplay = document.getElementById('card_type');
const userType = document.getElementById('user_type');
const creditCardSection = document.getElementById('creditCardSection');

// Update card image and text based on input
if (cardNumberInput) {
    cardNumberInput.addEventListener('input', () => {
        const cardNumber = cardNumberInput.value;
        let cardType = null;

        // Determine card type based on the card number
        if (/^4/.test(cardNumber)) {
            cardType = "visa";
        } else if (/^5[1-5]/.test(cardNumber)) {
            cardType = "mastercard";
        } else if (/^3[47]/.test(cardNumber)) {
            cardType = "american-express";
        } else if (/^6/.test(cardNumber)) {
            cardType = "discover";
        }

        if (cardType) {
            // Update the text display
            cardTypeDisplay.innerHTML = `<span style="font-weight: bold;">${cardType.charAt(0).toUpperCase() + cardType.slice(1)}</span>`;
            // Update the image
            console.log(cardType);
            cardTypeImage.src = `./media/${cardType}.png`; // Set image source
            cardTypeImage.style.display = "block"; // Show the image
        } else {
            // If no card type is detected, reset the text and hide the image
            cardTypeDisplay.textContent = "Card Type: Not Detected";
            cardTypeImage.style.display = "none";
        }
    });
}

// Hide credit card section for admin users
userType.addEventListener('change', () => {
    if (userType.value === 'admin') {
        creditCardSection.style.display = 'none';
    } else {
        creditCardSection.style.display = 'block';
    }
});
