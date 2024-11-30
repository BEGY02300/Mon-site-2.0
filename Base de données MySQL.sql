-- Création de la base de données
CREATE DATABASE IF NOT EXISTS techsaga;

-- Utilisation de la base de données
USE techsaga;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    avatar VARCHAR(255) DEFAULT 'uploads/default-avatar.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
