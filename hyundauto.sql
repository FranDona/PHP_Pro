DROP DATABASE IF EXISTS hyundauto;

CREATE DATABASE IF NOT EXISTS hyundauto
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

USE hyundauto;

/* Crear la tabla Vehiculos */
CREATE TABLE IF NOT EXISTS Vehiculos (
    matricula VARCHAR(7) PRIMARY KEY UNIQUE NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    año YEAR NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    disponible BOOLEAN NOT NULL DEFAULT TRUE,
    exposicion BOOLEAN NOT NULL DEFAULT FALSE,
    INDEX IDX_modelo (modelo)
) ENGINE InnoDB;

/* Crear la tabla Clientes */
CREATE TABLE IF NOT EXISTS Clientes (
    nif CHAR(9) PRIMARY KEY UNIQUE NOT NULL,
    nombre VARCHAR(45) NOT NULL,
    apellido VARCHAR(45) NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE InnoDB;

/* Crear la tabla Ventas */
CREATE TABLE IF NOT EXISTS Ventas (
    matricula CHAR(7) NOT NULL,
    nif_cliente CHAR(9) NOT NULL,
    fecha_venta DATE NOT NULL,
    activo BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (matricula, nif_cliente, fecha_venta),
    INDEX IDX_fecha_venta (fecha_venta),
    INDEX IDX_nif_ventas (nif_cliente),
    INDEX IDX_matricula_ventas (matricula),
    FOREIGN KEY (matricula) 
        REFERENCES Vehiculos(matricula)
        ON UPDATE CASCADE,
    FOREIGN KEY FK_Ventas_nif_clientes (nif_cliente) 
        REFERENCES Clientes(nif)
        ON UPDATE CASCADE
) ENGINE InnoDB;

/* Crear la cuarta tabla (DatosModelo) */
CREATE TABLE IF NOT EXISTS DatosModelo (
    matricula CHAR(7) PRIMARY KEY UNIQUE NOT NULL,
    motor VARCHAR(50) NOT NULL,
    transmision VARCHAR(50) NOT NULL,
    color VARCHAR(25) NOT NULL,
    INDEX IDX_matricula_datos_modelo (matricula),
    FOREIGN KEY FK_DatosModelo_matricula (matricula) 
        REFERENCES Vehiculos(matricula)
) ENGINE InnoDB;



-- Tabla Vehiculos
INSERT INTO Vehiculos (matricula, modelo, año, precio, disponible, exposicion)
VALUES
('1234ABC', 'Hyundai Kona', 2022, 26040.00, FALSE, FALSE),
('6789CDE', 'Hyundai Tucson', 2023, 30320.00, FALSE, FALSE),
('9876MNB', 'Hyundai i10', 2023, 17900.00, TRUE, FALSE),
('4356GHC', 'Hyundai i20', 2023, 17900.00, TRUE, FALSE),
('7707FRA', 'Hyundai i30', 2024, 45000.00, TRUE, FALSE),
('6606AND', 'Hyundai IONIQ 6', 2024, 49200.00, TRUE, FALSE),


-- Coches Exposicion --------------------------------
('0001AAA', 'Hyundai Kona', 2022, 26040.00, TRUE, TRUE),
('0002AAA', 'Hyundai Kona', 2023, 27120.00, TRUE, TRUE),

('0001BBB', 'Hyundai Tucson', 2022, 30320.00, TRUE, TRUE),
('0002BBB', 'Hyundai Tucson', 2023, 33320.00, TRUE, TRUE),

('0001CCC', 'Hyundai IONIQ 6', 2023, 49200.00, TRUE, TRUE),
('0002CCC', 'Hyundai IONIQ 6', 2024, 52100.00, TRUE, TRUE),

('0001DDD', 'Hyundai BAYON', 2024, 21040.00, TRUE, TRUE),
('0002DDD', 'Hyundai BAYON', 2024, 21640.00, TRUE, TRUE),

('0001EEE', 'Hyundai i30 N', 2022, 38500.00, TRUE, TRUE),
('0002EEE', 'Hyundai i30 N', 2023, 45000.00, TRUE, TRUE),

('0001FFF', 'Hyundai i20 N', 2022, 18640.00 , TRUE, TRUE),
('0002FFF', 'Hyundai i20 N', 2023, 19200.00, TRUE, TRUE),

('0001GGG', 'Hyundai i10', 2021, 15300.00, TRUE, TRUE),
('0002GGG', 'Hyundai i10', 2022, 16300.00, TRUE, TRUE);
-- -----------------------------------------------------------
-- Tabla Clientes
INSERT INTO Clientes (nif, nombre, apellido, activo)
VALUES
('12345678E', 'Juan', 'Guevara Cordero', TRUE),
('98765432R', 'María', 'Dominguez Paez', TRUE),
('45678912F', 'Carlos', 'Sala Pavon', TRUE),

('96376877T', 'Sebastian', 'Montaño Rosado', TRUE),
('63575130W', 'Paola', 'Exposito Costas', TRUE),
('11420258E', 'Rebeca', 'Carrero Medina', TRUE);

-- Tabla Ventas
INSERT INTO Ventas (matricula, nif_cliente, fecha_venta, activo)
VALUES
('1234ABC', '12345678E', '2023-01-15', TRUE),
('6789CDE', '98765432R', '2023-02-20', TRUE);

-- Tabla DatosModelo
INSERT INTO DatosModelo (matricula, motor, transmision, color)
VALUES
-- Modelos de Exposicion
('0001AAA', 'Lamba 1.9 270HP', '6v Manual', 'BLUE ONYX PEARL'),
('0002AAA', 'U-series VGT 1.6 125PS', '6v Automatico', 'BLUISH RED'),

('0001BBB', 'Kappa 1.2 100HP', '6v Manual', 'STEEL GRAY'),
('0002BBB', 'Hyundai Tucson Electric (150 kW)', '7v Automatico', 'BLUE ONYX PEARL'),

('0001CCC', 'Hyundai Ioniq Electric (225 kW)', '6v Automatico', 'STEEL GRAY'),
('0002CCC', 'Hyundai Ioniq Electric (225 kW)', '6v Automatico', 'VANILLA WHITE'),

('0001DDD', 'Kappa 1.2 100HP', '6v Manual', 'VANILLA WHIT'),
('0002DDD', 'U-series VGT 1.6 125PS', '6v Manual', 'STEEL GRAY'),

('0001EEE', 'Gamma 1.6 GDI 120HP', '6v Automatico', 'STEEL GRAY'),
('0002EEE', 'Lamba 1.9 270HP', '6v Automatico', 'EMERALD GREEN'),

('0001FFF', 'Kappa 1.2 100HP', '6v Manual', 'VANILLA WHITE'),
('0002FFF', 'Gamma 1.6 GDI 120HP', '6v Automatico', 'BLUE ONYX PEARL'),

('0001GGG', 'Kappa 1.2 100HP', '6v Manual', 'STEEL GRAY'),
('0002GGG', 'Kappa 1.2 100HP', '6v Manual', 'BLUE ONYX PEARL'),

-- Modelos vendidos
('1234ABC', 'motor', 'transmision', 'STEEL GRAY'),
('6789CDE', 'motor', 'transmision', 'EMERALD GREEN'),

-- Modelos en Venta
('9876MNB', 'motor', 'transmision', 'BLUISH RED'),
('7707FRA', 'Lamba 1.9 270HP', '6v Manual', 'BLUE ONYX PEARL'),
('6606AND', 'Hyundai Ioniq Electric (225 kW)', '6v Automatico', 'VANILLA WHITE'),
('4356GHC', 'Lamba 1.9 270HP', '6v Automatico', 'STEEL GRAY');