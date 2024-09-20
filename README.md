this is a webApplication for the gallery cafe restaurant using HTML,CSS,JAVA SCRIPT and PHP.

Database Name: 114_a

SQL to Create tables:

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    userType ENUM('customer', 'admin', 'staff') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(50) NOT NULL,
    r_date DATE NOT NULL,
    duration INT NOT NULL,
    slot INT NOT NULL,
    reserve_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cuisine ENUM('Sri Lankan','Chinese','Italian','Arabian','Indian','none') NOT NULL,
    food_type ENUM('meal', 'dessert', 'beverage') NULL,
    price DECIMAL(10,2) NOT NULL,
    image LONGBLOB NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE pre_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    meal_id INT NOT NULL,
    quantities TEXT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    ordered_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (meal_id) REFERENCES menu_items(id)
);

CREATE TABLE contact_us (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
