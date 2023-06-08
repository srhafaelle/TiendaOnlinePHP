DROP DATABASE IF EXISTS tienda;
CREATE DATABASE IF NOT EXISTS tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tienda;

CREATE TABLE productos(
    id INT  UNIQUE PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    descipcion TEXT,
    precio DECIMAL(10.2),
    descuento TINYINT() DEFAULT '0',
    id_categoria INT,
    activo int(2),
    cantidad int(120); --este eliminar se maneja la cantidad de otra tabla
    

)ENGINE=innoDB;
USE tienda;
INSERT INTO productos 
	( id,  nombre, descipcion, precio, id_categoria, activo, cantidad) 
VALUES 
	( 1 ,'Iphone 8'     ,'Iphone 8  6gb ram 120gb rom "<ul>
                <li>agregar a la descripcion</li>
                <li>de la base de tienda</li>
                <li>mejor interactividad</li>
              </ul>" ', 500, 1, 1 , 100),
    (  2,'Iphone 9'     ,'Iphone 9  6gb ram 120gb rom "<ul>
                <li>agregar a la descripcion</li>
                <li>de la base de tienda</li>
                <li>mejor interactividad</li>
              </ul>"', 600, 1, 1 , 100),
    (  3,'Iphone 10'    ,'Iphone 10 8gb ram 120gb rom "<ul>
                <li>agregar a la descripcion</li>
                <li>de la base de tienda</li>
                <li>mejor interactividad</li>
              </ul>" ', 700, 1, 1, 100 ),
    (  4, 'Redmi Note 9s','redmi note 9s  6gb ram 120gb rom  "<ul>
                <li>agregar a la descripcion</li>
                <li>de la base de tienda</li>
                <li>mejor interactividad</li>
              </ul>"', 400, 1, 1 , 100);

-- estaba agregado aqui el descuento debes agregar los detalles y subir codigo php
    ALTER TABLE `productos` ADD `descuento` TINYINT(2 ) NULL DEFAULT '0' AFTER `precio`;

    UPDATE `productos` SET `descuento` = '5' WHERE `productos`.`id` = 1;

-- tabla para guardar las compras 

 CREATE TABLE compra(id INT UNIQUE PRIMARY KEY AUTO_INCREMENT,
 id_transaccion VARCHAR(20) NOT NULL, 
 fecha DATETIME NOT NULL,
 status VARCHAR(20) NOT NULL,
 email VARCHAR(50) NOT NULL,
 id_cliente VARCHAR(20) NOT NULL,
 total DECIMAL(10.2) NOT NULL )ENGINE=innoDB;

    CREATE TABLE detalle_compra(
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_compra INT,
        id_producto INT,
        nombre VARCHAR(200),
        precio DECIMAL(10.2),
        cantidad INT)ENGINE=innoDB;


-- tabla para tener las caracteristicas

CREATE TABLE caracteristicas (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
     caracateristica VARCHAR(30) NOT NULL ,
      activo INT NOT NULL) ENGINE = InnoDB;


      CREATE TABLE det_pro_carater(
        id INT PRIMARY KEY AUTO_INCREMENT,
       id_producto INT, 
       id_caracteristica INT, 
       valor VARCHAR(30),
        stock INT )ENGINE = innoDB;

        ALTER TABLE `det_pro_carater` ADD CONSTRAINT `fk_det_prod` FOREIGN KEY (`id_producto`) REFERENCES `productos`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        ALTER TABLE `det_pro_carater` ADD CONSTRAINT `fk_det_caracter` FOREIGN KEY (`id_caracteristica`) REFERENCES `caracteristicas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

        CREATE TABLE  clientes(id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
         nombre VARCHAR(80),
          apellidos VARCHAR(80),
           email VARCHAR(80),
            telefono VARCHAR(20),
             dni VARCHAR(20),
              status TINYINT,
               fecha_de_alta DATETIME,
                fecha_modifica DATETIME NULL, 
                fecha_baja DATETIME NULL)ENGINE = innoDB;

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT ,
 usuario VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(120) NOT NULL ,
  activacion INT NOT NULL DEFAULT (0) ,
   token VARCHAR(120),
    token_password VARCHAR(120) NULL , 
    password_request INT DEFAULT (0) ,
     id_cliente INT NOT NULL,
      ) ENGINE = InnoDB;



-- relaciones 
fk_det_prod con id_producto base de datos tienda tabla productos columna id
fk_det_caracter con id_caracteristica tabla base de datos tienda tabla caracateristica columna id
