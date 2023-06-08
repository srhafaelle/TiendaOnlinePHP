DROP DATABASE IF EXISTS blackshop;

CREATE DATABASE IF NOT  EXISTS blackshop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

use blackshop;


CREATE TABLE usuarios(
    id INT  PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL,
    clave VARCHAR(120) NOT NULL,
    



)