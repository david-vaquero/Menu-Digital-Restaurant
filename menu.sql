CREATE DATABASE restaurante;
USE restaurante;

CREATE TABLE platos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(5,2),
    categoria VARCHAR(50)
);

INSERT INTO platos (nombre, descripcion, precio, categoria) VALUES
('Paella Valenciana', 'Arroz con mariscos y pollo', 12.50, 'Principal'),
('Tarta de Queso', 'Postre casero', 4.00, 'Postre'),
('Agua Mineral', 'Botella de 50cl', 1.20, 'Bebida'),
('Ensalada César', 'Con lechuga, pollo y croutons', 6.50, 'Entrante');

CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente VARCHAR(100) NOT NULL,
  plato_id INT,
  FOREIGN KEY (plato_id) REFERENCES platos(id)
);

