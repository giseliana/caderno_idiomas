CREATE DATABASE IF NOT EXISTS caderno_idiomas;
USE caderno_idiomas;

-- Apaga tabelas antigas se existirem
DROP TABLE IF EXISTS palavras;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE palavras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    termo VARCHAR(150) NOT NULL,
    traducao VARCHAR(150) NOT NULL,
    exemplo TEXT,
    idioma VARCHAR(50) NOT NULL,
    status ENUM('preciso_revisar', 'aprendido') DEFAULT 'preciso_revisar',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);