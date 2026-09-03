-- ==============================================================================
-- MCA Pizza Palace - Database Schema & Initial Seed
-- Database: pizza_demo
-- Charset: utf8mb4 (Full Unicode / Emoji support)
-- ==============================================================================

CREATE DATABASE IF NOT EXISTS `pizza_demo` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `pizza_demo`;

-- ------------------------------------------------------------------------------
-- Table structure for `users`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL COMMENT 'Bcrypt hashed password via password_hash()',
    `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
    `phone` VARCHAR(20) DEFAULT NULL,
    `address` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_users_role` (`role`),
    INDEX `idx_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `orders`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL,
    `items` TEXT NOT NULL COMMENT 'Ordered item details snapshot',
    `total` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `status` ENUM('Pending', 'In Progress', 'Delivered') NOT NULL DEFAULT 'Pending',
    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_orders_customer_id` (`customer_id`),
    INDEX `idx_orders_status` (`status`),
    INDEX `idx_orders_date` (`order_date`),
    CONSTRAINT `fk_orders_customer` 
        FOREIGN KEY (`customer_id`) 
        REFERENCES `users` (`id`) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- Table structure for `contacts`
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_contacts_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==============================================================================
-- Initial Seeding (Default Admin & Sample Records)
-- Default Admin Password: admin123 (Change immediately upon deployment!)
-- ==============================================================================
INSERT INTO `users` (`name`, `email`, `password`, `role`, `phone`, `address`)
VALUES 
('System Admin', 'admin@demo.com', '$2y$10$McNdxnIvAehEpjJo7NIv/.YvAaZhcIk.a85LeWk8pevAB.sRL/9Wq', 'admin', '1234567890', 'Headquarters, Suite 101')
ON DUPLICATE KEY UPDATE `email`=`email`;
