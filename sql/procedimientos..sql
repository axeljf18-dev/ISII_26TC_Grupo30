-- ====================================================
-- SCRIPT DE PROCEDIMIENTOS ALMACENADOS
-- Base de datos: bd_fernandez_facundo
-- ====================================================

-- ----------------------------------------------------
-- 1. Alta de producto
-- ----------------------------------------------------
DROP PROCEDURE IF EXISTS sp_alta_producto;

DELIMITER //
CREATE PROCEDURE sp_alta_producto(
    IN p_nombre VARCHAR(100),
    IN p_imagen VARCHAR(200),
    IN p_id_categoria INT,
    IN p_precio FLOAT(10,2),
    IN p_precio_vta FLOAT(10,2),
    IN p_stock INT,
    IN p_stock_min INT,
    IN p_descripcion VARCHAR(500),
    IN p_id_marca INT,
    IN p_id_proveedor INT
)
BEGIN
    INSERT INTO producto (
        nombre, imagen, id_categoria, precio, precio_vta, 
        stock, stock_min, descripcion, id_marca, id_proveedor
    ) 
    VALUES (
        p_nombre, p_imagen, p_id_categoria, p_precio, p_precio_vta, 
        p_stock, p_stock_min, p_descripcion, p_id_marca, p_id_proveedor
    );
END //
DELIMITER ;

-- ----------------------------------------------------
-- 2. Select de detalles de venta por usuario
-- ----------------------------------------------------
DROP PROCEDURE IF EXISTS sp_detalles_venta_usuario;

DELIMITER //
CREATE PROCEDURE sp_detalles_venta_usuario(
    IN p_id_usuario INT
)
BEGIN
    SELECT 
        u.usuario AS alias_usuario,
        vc.id_venta_cabecera AS nro_venta,
        vc.fecha,
        p.nombre AS producto,
        vd.cantidad,
        vd.precio AS precio_unitario,
        (vd.cantidad * vd.precio) AS subtotal_linea
    FROM usuario u
    INNER JOIN venta_cabecera vc ON u.id_usuario = vc.id_usuario
    INNER JOIN venta_detalle vd ON vc.id_venta_cabecera = vd.id_venta_cabecera
    INNER JOIN producto p ON vd.id_producto = p.id_producto
    WHERE u.id_usuario = p_id_usuario
    ORDER BY vc.fecha DESC;
END //
DELIMITER ;

-- ----------------------------------------------------
-- 3. Update de usuario
-- ----------------------------------------------------
DROP PROCEDURE IF EXISTS sp_update_usuario;

DELIMITER //
CREATE PROCEDURE sp_update_usuario(
    IN p_id_usuario INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido VARCHAR(50),
    IN p_usuario VARCHAR(20),
    IN p_email VARCHAR(100),
    IN p_id_perfil INT,
    IN p_baja VARCHAR(2)
)
BEGIN
    UPDATE usuario
    SET 
        nombre = p_nombre,
        apellido = p_apellido,
        usuario = p_usuario,
        email = p_email,
        id_perfil = p_id_perfil,
        baja = p_baja
    WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

-- ====================================================
-- EJEMPLOS DE LLAMADAS (CALL)
-- Descomentarlas (quitar el --) para probarlas:

-- Llamada a Alta de Producto (Insertando un producto de prueba)
-- CALL sp_alta_producto('Laptop Ultra Pro', 'laptop_ultra_pro.png', 4, 45000.00, 38000.00, 15, 5, 'Una laptop ideal para ediciones de video', 2, 1);

-- Llamada a Select de detalles de venta (Consultando al usuario con ID 5)
-- CALL sp_detalles_venta_usuario(5);

-- Llamada a Update de Usuario (Modificando los datos del usuario con ID 4)
-- CALL sp_update_usuario(4, 'Jose', 'Fernandez', 'Jose123', 'jose-nuevo@gmail.com', 2, 'NO');