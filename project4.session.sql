INSERT INTO properties (
    user_id, location, age, floor_plan, square_footage, bedrooms, bathrooms, 
    garden, parking, nearby_facilities, main_road_access, property_tax, image_url
) 
VALUES 
(1, 'Downtown Area', 5, '3BHK', 1200.50, 3, 2, TRUE, TRUE, 'Near school and mall', TRUE, 15000.00, 'image1.jpg'),
(1, 'Suburban Area', 10, '2BHK', 950.00, 2, 1, FALSE, TRUE, 'Near park', FALSE, 10000.00, 'image2.jpg');



SELECT * FROM users;

SELECT * FROM properties;
