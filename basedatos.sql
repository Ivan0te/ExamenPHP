CREATE DATABASE acortador_db;

USE acortador_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  -- Se almacena la contraseña cifrada
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- Enlaza con la tabla de usuarios
    url_original TEXT NOT NULL,  -- La URL original proporcionada
    url_corta VARCHAR(6) NOT NULL UNIQUE,  -- La URL acortada (código corto)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
