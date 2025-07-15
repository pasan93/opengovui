-- OpenGovUI WordPress Database Setup
-- Run this with: mariadb -u root < setup_database.sql

-- Create database
CREATE DATABASE IF NOT EXISTS opengovui_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user with limited privileges (optional, for security)
-- CREATE USER IF NOT EXISTS 'opengovui_user'@'localhost' IDENTIFIED BY 'secure_password_123';
-- GRANT ALL PRIVILEGES ON opengovui_wp.* TO 'opengovui_user'@'localhost';

-- Use the database
USE opengovui_wp;

-- Note: WordPress will create all tables automatically during installation
-- This script just ensures the database exists and is properly configured

FLUSH PRIVILEGES; 