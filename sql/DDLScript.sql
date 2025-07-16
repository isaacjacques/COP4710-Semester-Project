DROP TABLE IF EXISTS jacques_InventoryHistory;
DROP TABLE IF EXISTS jacques_Inventory;
DROP TABLE IF EXISTS jacques_EcomOrderDetail;
DROP TABLE IF EXISTS jacques_EcomOrder;
DROP TABLE IF EXISTS jacques_CustomerCart;
DROP TABLE IF EXISTS jacques_Product;
DROP TABLE IF EXISTS jacques_Customer;

CREATE TABLE jacques_Customer (
    CustomerID   BIGINT      PRIMARY KEY,
    FirstName    VARCHAR(255),
    LastName     VARCHAR(255),
    Email        VARCHAR(255),
    PasswordSalt VARCHAR(64),
    PasswordHash VARCHAR(64),
    CreationTime DATETIME
);

CREATE TABLE jacques_Product (
    ProductID    BIGINT      PRIMARY KEY,
    SKU          VARCHAR(32),
    UPC          VARCHAR(32),
    Color        VARCHAR(32),
    Size         VARCHAR(32),
    Brand        VARCHAR(32),
    PackSize     INT,
    Description  VARCHAR(255),
    CreationTime DATETIME
);

CREATE TABLE jacques_CustomerCart (
    CartItemID   BIGINT      PRIMARY KEY,
    CustomerID   BIGINT      NOT NULL,
    ProductID    BIGINT      NOT NULL,
    ProductQty   INT         NOT NULL,
    CreationTime DATETIME,
    FOREIGN KEY (CustomerID) REFERENCES jacques_Customer(CustomerID) ON DELETE CASCADE,
    FOREIGN KEY (ProductID)  REFERENCES jacques_Product(ProductID)   ON DELETE CASCADE
);

CREATE TABLE jacques_EcomOrder (
    OrderID      BIGINT      PRIMARY KEY,
    OrderStatus  VARCHAR(16),
    CustomerID   BIGINT      NOT NULL,
    CreationTime DATETIME,
    FOREIGN KEY (CustomerID) REFERENCES jacques_Customer(CustomerID) ON DELETE CASCADE
);

CREATE TABLE jacques_EcomOrderDetail (
    OrderDetailID BIGINT      PRIMARY KEY,
    OrderID       BIGINT      NOT NULL,
    ProductID     BIGINT      NOT NULL,
    ProductQty    INT         NOT NULL,
    CreationTime  DATETIME,
    FOREIGN KEY (OrderID)   REFERENCES jacques_EcomOrder(OrderID)       ON DELETE CASCADE,
    FOREIGN KEY (ProductID) REFERENCES jacques_Product(ProductID)         ON DELETE CASCADE
);

CREATE TABLE jacques_Inventory (
    InventoryID    BIGINT      PRIMARY KEY,
    InventoryStatus VARCHAR(16),
    ProductID      BIGINT      NOT NULL,
    ProductQty     INT         NOT NULL,
    LPN            VARCHAR(32),
    CreationTime   DATETIME,
    FOREIGN KEY (ProductID) REFERENCES jacques_Product(ProductID) ON DELETE CASCADE
);

CREATE TABLE jacques_InventoryHistory (
    InventoryHistoryID BIGINT      PRIMARY KEY,
    InventoryID        BIGINT      NOT NULL,
    OrderDetailID      BIGINT      NOT NULL,
    ChangeQty          INT         NOT NULL,
    CreationTime       DATETIME,
    FOREIGN KEY (InventoryID)   REFERENCES jacques_Inventory(InventoryID)     ON DELETE CASCADE,
    FOREIGN KEY (OrderDetailID) REFERENCES jacques_EcomOrderDetail(OrderDetailID) ON DELETE CASCADE
);