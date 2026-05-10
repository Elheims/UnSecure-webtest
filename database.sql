CREATE DATABASE IF NOT EXISTS secureweb;
USE secureweb;

CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS komentar (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nama       VARCHAR(64)  NOT NULL,
    komentar   VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun admin default untuk versi vulnerable (password plain text)
INSERT INTO users (username, password) VALUES
('admin', 'admin123');
