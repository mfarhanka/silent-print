-- Silent Prints Database Schema
-- Create database
CREATE DATABASE IF NOT EXISTS silent_prints;
USE silent_prints;

-- Contact inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(100),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(50),
    is_active TINYINT(1) DEFAULT 1,
    display_order INT(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Portfolio/Projects table
CREATE TABLE IF NOT EXISTS portfolio (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    category VARCHAR(50),
    is_featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert sample services
INSERT INTO services (title, description, icon, display_order) VALUES
('Print Advertising', 'Professional print advertising solutions including brochures, flyers, and posters', 'fas fa-print', 1),
('Digital Marketing', 'Comprehensive digital marketing strategies to grow your brand online', 'fas fa-bullhorn', 2),
('Brand Design', 'Creative brand identity design and logo creation services', 'fas fa-palette', 3),
('Social Media', 'Social media management and content creation for all platforms', 'fas fa-share-alt', 4);
