CREATE DATABASE my_store;
GO
USE my_store;
GO

CREATE TABLE category (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name NVARCHAR(100) NOT NULL,
    description NVARCHAR(MAX) NULL
);
GO

CREATE TABLE product (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name NVARCHAR(100) NOT NULL,
    description NVARCHAR(MAX) NULL,
    price DECIMAL(10, 2) NOT NULL,
    image NVARCHAR(255) NOT NULL,
    category_id INT NULL,
    CONSTRAINT FK_product_category FOREIGN KEY (category_id) REFERENCES category(id)
);
GO

CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY,
    username NVARCHAR(255) NOT NULL UNIQUE,
    password NVARCHAR(255) NOT NULL,
    role NVARCHAR(50) NOT NULL DEFAULT 'customer',
    created_at DATETIME DEFAULT GETDATE()
);
GO

CREATE TABLE orders (
    id INT IDENTITY(1,1) PRIMARY KEY,
    user_id INT NOT NULL,
    payment_method NVARCHAR(50) NOT NULL,
    customer_name NVARCHAR(255) NULL,
    phone NVARCHAR(20) NULL,
    status NVARCHAR(50) NOT NULL DEFAULT 'Đang chuẩn bị',
    created_at DATETIME DEFAULT GETDATE()
);
GO

CREATE TABLE order_details (
    id INT IDENTITY(1,1) PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    sugar_level NVARCHAR(50) NULL,
    ice_level NVARCHAR(50) NULL,
    cup_size NVARCHAR(50) NULL,
    price DECIMAL(13, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
GO
