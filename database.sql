-- Database: bdu_drms
CREATE DATABASE IF NOT EXISTS bdu_drms;
USE bdu_drms;

-- 1. Users Table (Stores Graduates, Staff/Registrar, Admin)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('graduate', 'registrar', 'admin') NOT NULL DEFAULT 'graduate',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Document Requests Table
CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    document_type ENUM('transcript', 'certificate', 'letter') NOT NULL,
    purpose TEXT NOT NULL,
    delivery_method ENUM('digital', 'physical') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    rejection_reason TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 3. Documents & Verification Table
CREATE TABLE IF NOT EXISTS documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL,
    verification_id VARCHAR(50) NOT NULL UNIQUE, -- The generated unique ID for verification
    generated_file_path VARCHAR(255) NULL, -- Path to the authenticated PDF/Image
    verified_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES requests(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 4. Verification Logs (Optional, for security audit)
CREATE TABLE IF NOT EXISTS verification_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    verifier_ip VARCHAR(50) NULL,
    verified_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (document_id) REFERENCES documents(id) ON DELETE CASCADE
);

-- SEED DATA (Default Admin and Registrar for testing)
-- Password for all seed users is 'password123' (hashed using standard PHP password_hash would normally be needed, 
-- but for setup, we will manually insert a hash later or handle it in register. For now, let's insert a dummy admin)
-- NOTE: In a real scenario, you should use the register page to create valid hashes.
-- Below is a placeholder. You SHOULD register a new admin via the UI to get a proper hash or use this hash: 
-- $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi (which is 'password')

INSERT INTO users (full_name, username, email, password, role) VALUES 
('System Admin', 'admin', 'admin@bdu.edu.et', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Main Registrar', 'registrar', 'registrar@bdu.edu.et', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'registrar');
