-- Pioneer Emery Stones Database Schema
-- Run: mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS pioneer_emery_stones CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pioneer_emery_stones;

-- Admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin','editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Settings
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    image VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE category_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    meta_title VARCHAR(200),
    meta_description TEXT,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    UNIQUE KEY (category_id, lang)
);

-- Products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    stone_type VARCHAR(50) DEFAULT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    sku VARCHAR(50),
    brochure VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE product_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    name VARCHAR(200) NOT NULL,
    short_description TEXT,
    description TEXT,
    benefits TEXT,
    applications TEXT,
    meta_title VARCHAR(200),
    meta_description TEXT,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY (product_id, lang)
);

CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE product_sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    sl_no INT DEFAULT NULL,
    size_label VARCHAR(50) NOT NULL,
    diameter VARCHAR(50),
    bore VARCHAR(50),
    thickness VARCHAR(50),
    weight VARCHAR(50),
    sort_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE product_specs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    spec_key VARCHAR(100) NOT NULL,
    spec_value VARCHAR(255) NOT NULL,
    lang VARCHAR(5) DEFAULT 'en',
    sort_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Blogs
CREATE TABLE blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE blog_category_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    name VARCHAR(150) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE CASCADE,
    UNIQUE KEY (category_id, lang)
);

CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    slug VARCHAR(150) NOT NULL UNIQUE,
    featured_image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'Pioneer Team',
    is_published TINYINT(1) DEFAULT 1,
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
);

CREATE TABLE blog_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT,
    content LONGTEXT,
    meta_title VARCHAR(200),
    meta_description TEXT,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE,
    UNIQUE KEY (blog_id, lang)
);

CREATE TABLE blog_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    tag VARCHAR(50) NOT NULL,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE
);

-- FAQs
CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE faq_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faq_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    FOREIGN KEY (faq_id) REFERENCES faqs(id) ON DELETE CASCADE,
    UNIQUE KEY (faq_id, lang)
);

-- Testimonials
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('customer','dealer') DEFAULT 'customer',
    name VARCHAR(100) NOT NULL,
    company VARCHAR(150),
    location VARCHAR(100),
    rating TINYINT DEFAULT 5,
    photo VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE testimonial_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    testimonial_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    review TEXT NOT NULL,
    FOREIGN KEY (testimonial_id) REFERENCES testimonials(id) ON DELETE CASCADE,
    UNIQUE KEY (testimonial_id, lang)
);

-- Banners
CREATE TABLE banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE banner_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    banner_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    title VARCHAR(200),
    subtitle TEXT,
    button_text VARCHAR(50),
    FOREIGN KEY (banner_id) REFERENCES banners(id) ON DELETE CASCADE,
    UNIQUE KEY (banner_id, lang)
);

-- Inquiries
CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(20) NOT NULL,
    subject VARCHAR(200),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE dealer_inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(150),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    business_type VARCHAR(100),
    annual_requirement VARCHAR(100),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Page SEO
CREATE TABLE page_seo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(50) NOT NULL,
    lang VARCHAR(5) NOT NULL,
    meta_title VARCHAR(200),
    meta_description TEXT,
    meta_keywords TEXT,
    og_title VARCHAR(200),
    og_description TEXT,
    UNIQUE KEY (page_key, lang)
);

-- Manufacturing process steps (homepage)
CREATE TABLE process_steps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(50) DEFAULT 'bi-gear',
    image VARCHAR(255),
    image_position VARCHAR(50) DEFAULT 'center',
    sort_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE process_step_translations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    process_step_id INT NOT NULL,
    lang VARCHAR(5) NOT NULL,
    label VARCHAR(200) NOT NULL,
    description TEXT,
    FOREIGN KEY (process_step_id) REFERENCES process_steps(id) ON DELETE CASCADE,
    UNIQUE KEY (process_step_id, lang)
);
