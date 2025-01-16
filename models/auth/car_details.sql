CREATE TABLE cars_details (
    id VARCHAR(255) PRIMARY KEY NOT NULL,
    seller_id VARCHAR(255) NOT NULL,
    car_name VARCHAR(255) NOT NULL,
    car_model VARCHAR(255) NOT NULL,
    car_price DECIMAL(10,2) NOT NULL,
    car_color VARCHAR(255) NOT NULL,
    car_image VARCHAR(255) NOT NULL,
    createdAt DATETIME,
    verifiedAt DATETIME
);
