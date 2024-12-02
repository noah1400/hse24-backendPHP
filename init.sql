-- Create shopping_items table
CREATE TABLE shopping_items (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    amount INT NOT NULL
);

-- Optional: Add some sample data
INSERT INTO shopping_items (name, amount) VALUES 
('Apple', 5),
('Banana', 3),
('Milk', 2);