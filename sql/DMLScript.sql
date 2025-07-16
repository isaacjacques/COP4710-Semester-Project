
INSERT INTO jacques_Customer
    (CustomerID, FirstName, LastName, Email, PasswordSalt, PasswordHash, CreationTime)
VALUES
(1,  'John1' , 'Doe1' , 'johndoe1@example.com', 'salt', 'hash', NOW()),
(2,  'John2' , 'Doe2' , 'johndoe2@example.com', 'salt', 'hash', NOW()),
(3,  'John3' , 'Doe3' , 'johndoe3@example.com', 'salt', 'hash', NOW()),
(4,  'John4' , 'Doe4' , 'johndoe4@example.com', 'salt', 'hash', NOW()),
(5,  'John5' , 'Doe5' , 'johndoe5@example.com', 'salt', 'hash', NOW()),
(6,  'John6' , 'Doe6' , 'johndoe6@example.com', 'salt', 'hash', NOW()),
(7,  'John7' , 'Doe7' , 'johndoe7@example.com', 'salt', 'hash', NOW()),
(8,  'John8' , 'Doe8' , 'johndoe8@example.com', 'salt', 'hash', NOW()),
(9,  'John9' , 'Doe9' , 'johndoe9@example.com', 'salt', 'hash', NOW()),
(10, 'John10', 'Doe10', 'johndoe10@example.com', 'salt', 'hash', NOW());

INSERT INTO jacques_Product (ProductID, SKU, UPC, Color, Size, Brand, PackSize, Description, CreationTime) VALUES
(1, '8IG76ME0', '837143704298', 'Blue', 'S', 'Nike', 12, 'Running shoes', NOW()),
(2, 'ZBOKY0Y6', '094952849882', 'Green', 'XS', 'Adidas', 9, 'Training shirt', NOW()),
(3, 'FKI5XNPM', '940936824969', 'Black', 'XS', 'Puma', 9, 'Baseball cap', NOW()),
(4, 'VA8Q3A29', '660203771046', 'Yellow', 'XL', 'Under Armour', 5, 'Compression shorts', NOW()),
(5, 'TYYPYGJD', '283537519105', 'Black', 'XL', 'Reebok', 6, 'Track jacket', NOW()),
(6, 'A64RSKYP', '963082073478', 'Orange', 'L', 'Columbia', 4, 'Yoga pants', NOW()),
(7, 'UMLC7A62', '397523806140', 'White', 'M', 'New Balance', 11, 'Sneakers', NOW()),
(8, '6VFD4F6S', '019820178244', 'Red', 'L', 'Asics', 3, 'Hiking boots', NOW()),
(9, 'QG2HD2AV', '928140753670', 'Gray', 'M', 'Fila', 2, 'Gym bag', NOW()),
(10, '0AWDQM6Y', '761857326490', 'Purple', 'S', 'Champion', 7, 'Sports watch', NOW());

INSERT INTO jacques_CustomerCart
    (CartItemID, CustomerID, ProductID, ProductQty, CreationTime)
VALUES
(1, 1, 1, 2, NOW()), 
(2, 2, 2, 1, NOW()), 
(3, 3, 3, 3, NOW()),
(4, 4, 4, 2, NOW()), 
(5, 5, 5, 1, NOW()), 
(6, 6, 6, 2, NOW()),
(7, 7, 7, 3, NOW()), 
(8, 8, 8, 4, NOW()), 
(9, 9, 9, 2, NOW()),
(10, 10, 10, 1, NOW());

INSERT INTO jacques_EcomOrder
    (OrderID, OrderStatus, CustomerID, CreationTime)
VALUES
    (1,  'Pending',    1,NOW()),
    (2,  'Processing', 2,NOW()),
    (3,  'Shipped',    3,NOW()),
    (4,  'Delivered',  4,NOW()),
    (5,  'Cancelled',  5,NOW()),
    (6,  'Pending',    6,NOW()),
    (7,  'Processing', 7,NOW()),
    (8,  'Shipped',    8,NOW()),
    (9,  'Delivered',  9,NOW()),
    (10, 'Pending',   10,NOW());
	
INSERT INTO jacques_EcomOrderDetail
    (OrderDetailID, OrderID, ProductID, ProductQty, CreationTime)
VALUES
(1, 1, 1, 2, NOW()), 
(2, 2, 2, 1, NOW()), 
(3, 3, 3, 3, NOW()),
(4, 4, 4, 1, NOW()), 
(5, 5, 5, 2, NOW()), 
(6, 6, 6, 2, NOW()),
(7, 7, 7, 1, NOW()), 
(8, 8, 8, 3, NOW()), 
(9, 9, 9, 2, NOW()),
(10, 10, 10, 1, NOW());

INSERT INTO jacques_Inventory
    (InventoryID, InventoryStatus, ProductID, ProductQty, LPN,   CreationTime)
VALUES
(1, 'InStock', 1, 100, 'LPN1', NOW()), 
(2, 'InStock', 2, 90, 'LPN2', NOW()),
(3, 'InStock', 3, 80, 'LPN3', NOW()), 
(4, 'InStock', 4, 70, 'LPN4', NOW()),
(5, 'InStock', 5, 60, 'LPN5', NOW()), 
(6, 'InStock', 6, 50, 'LPN6', NOW()),
(7, 'InStock', 7, 40, 'LPN7', NOW()), 
(8, 'InStock', 8, 30, 'LPN8', NOW()),
(9, 'InStock', 9, 20, 'LPN9', NOW()), 
(10, 'InStock', 10, 10, 'LPN10', NOW());

INSERT INTO jacques_InventoryHistory
    (InventoryHistoryID, InventoryID, OrderDetailID, ChangeQty, CreationTime)
VALUES
    (1,  1,  1,  -2,NOW()),
    (2,  2,  2,  -1,NOW()),
    (3,  3,  3,  -3,NOW()),
    (4,  4,  4,  -2,NOW()),
    (5,  5,  5,  -1,NOW()),
    (6,  6,  6,  -4,NOW()),
    (7,  7,  7,  -2,NOW()),
    (8,  8,  8,  -1,NOW()),
    (9,  9,  9,  -3,NOW()),
    (10,10, 10,  -5,NOW());
	
DELETE FROM jacques_InventoryHistory WHERE InventoryHistoryID = 10;

DELETE FROM jacques_Inventory WHERE InventoryID = 10;

DELETE FROM jacques_EcomOrderDetail WHERE OrderDetailID = 10;

DELETE FROM jacques_EcomOrder WHERE OrderID = 10;

DELETE FROM jacques_CustomerCart WHERE CartItemID = 10;

DELETE FROM jacques_Product WHERE ProductID = 10;

DELETE FROM jacques_Customer WHERE CustomerID = 10;

UPDATE jacques_InventoryHistory SET ChangeQty = -4 WHERE InventoryHistoryID = 1;

UPDATE jacques_Inventory SET ProductQty = 7 WHERE InventoryID = 1;

UPDATE jacques_EcomOrderDetail SET ProductQty = 77 WHERE OrderDetailID = 1;

UPDATE jacques_EcomOrder SET OrderStatus = 'Shipped' WHERE OrderID = 1;

UPDATE jacques_CustomerCart SET ProductQty = 77 WHERE CartItemID = 1;

UPDATE jacques_Product SET Description = 'ON SALE, UPDATED DESCRIPTION' WHERE ProductID = 1;

UPDATE jacques_Customer SET Email = 'updated_new@example.com' WHERE CustomerID = 1;	