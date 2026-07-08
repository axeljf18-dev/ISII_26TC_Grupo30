-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2026 a las 21:17:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_fernandez_facundo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `activo` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripcion`, `activo`) VALUES
(1, 'Hogar', 1),
(2, 'Trabajo', 1),
(3, 'Educación', 1),
(4, 'Gaming', 1),
(5, 'Diseño y Edición Multimedia', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `barrio` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL,
  `id_localidad` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `barrio`, `calle`, `numero`, `id_localidad`, `id_usuario`) VALUES
(3, 'Centro', 'Junín', 789, 3, 3),
(4, 'Villa María', 'Rivadavia', 321, 4, 4),
(5, 'Las Flores', 'Mitre', 654, 5, 5),
(6, 'San Martín', 'Belgrano', 123, 1, 8),
(7, 'Libertad', 'Av. Independencia', 456, 2, 9),
(8, 'San José', 'Corrientes', 245, 1, 22),
(10, 'La Paz', 'Urquiza', 1120, 1, 24),
(11, 'Libertad', 'Sarmiento', 560, 1, 25),
(12, 'Belgrano', 'Catamarca', 890, 4, 26),
(13, 'San Martín', 'Junín', 1345, 3, 27),
(14, 'Las Flores', 'Independencia', 300, 2, 28),
(15, 'Villa María', 'Rivadavia', 720, 1, 29),
(16, 'Centro', '9 de Julio', 1500, 5, 30),
(17, 'Santa Rosa', 'San Lorenzo', 980, 1, 31),
(20, 'Libertad', 'Sarmiento', 560, 3, 6),
(21, 'Belgrano', 'Catamarca', 890, 4, 7),
(22, 'San Martín', 'Junín', 1345, 5, 10),
(23, 'Las Flores', 'Independencia', 300, 1, 11),
(24, 'Villa María', 'Rivadavia', 720, 2, 12),
(25, 'Centro', '9 de Julio', 1500, 3, 13),
(26, 'Santa Rosa', 'San Lorenzo', 980, 4, 14),
(27, 'San Pedro', 'Lavalle', 410, 5, 15),
(28, 'San Nicolás', 'Moreno', 222, 1, 16),
(29, 'San Antonio', 'Entre Ríos', 875, 2, 17),
(30, 'San Miguel', 'España', 560, 3, 18),
(31, 'San Juan', 'Catamarca', 940, 4, 19),
(32, 'San Carlos', 'Mitre', 120, 5, 20),
(33, 'San Fernando', 'Belgrano', 660, 1, 21),
(34, 'San Isidro', 'Roca', 345, 2, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `codigo_postal` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`id_localidad`, `nombre`, `codigo_postal`, `id_provincia`) VALUES
(1, 'Corrientes Capital', 3400, 1),
(2, 'Resistencia', 3500, 2),
(3, 'Posadas', 3300, 3),
(4, 'Formosa Capital', 3600, 4),
(5, 'Paraná', 3100, 5),
(6, 'Goya', 3450, 1),
(7, 'Paso de los Libres', 3230, 1),
(8, 'Mercedes', 3470, 1),
(9, 'Sáenz Peña', 3700, 2),
(10, 'Villa Ángela', 3540, 2),
(11, 'Charata', 3730, 2),
(12, 'Oberá', 3360, 3),
(13, 'Eldorado', 3380, 3),
(14, 'Apóstoles', 3350, 3),
(15, 'Clorinda', 3610, 4),
(16, 'Pirané', 3620, 4),
(17, 'Laguna Blanca', 3630, 4),
(18, 'Concordia', 3200, 5),
(19, 'Gualeguaychú', 2820, 5),
(20, 'Concepción del Uruguay', 3260, 5),
(21, 'La Plata', 1900, 6),
(22, 'Mar del Plata', 7600, 6),
(23, 'Bahía Blanca', 8000, 6),
(24, 'Tandil', 7000, 6),
(25, 'San Fernando del Valle de Catamarca', 4700, 7),
(26, 'Andalgalá', 4740, 7),
(27, 'Belén', 4750, 7),
(28, 'Tinogasta', 5340, 7),
(33, 'San Salvador de Jujuy', 4600, 9),
(34, 'Palpalá', 4612, 9),
(35, 'Libertador General San Martín', 4512, 9),
(36, 'La Quiaca', 4650, 9),
(37, 'Santa Rosa', 6300, 10),
(38, 'General Pico', 6360, 10),
(39, 'Toay', 6303, 10),
(40, 'Eduardo Castex', 6380, 10),
(41, 'La Rioja Capital', 5300, 11),
(42, 'Chilecito', 5360, 11),
(43, 'Aimogasta', 5310, 11),
(44, 'Chamical', 5380, 11),
(45, 'Mendoza Capital', 5500, 12),
(46, 'San Rafael', 5600, 12),
(47, 'Godoy Cruz', 5501, 12),
(48, 'Luján de Cuyo', 5507, 12),
(49, 'Neuquén Capital', 8300, 13),
(50, 'San Martín de los Andes', 8370, 13),
(51, 'Cutral Có', 8322, 13),
(52, 'Zapala', 8340, 13),
(53, 'Viedma', 8500, 14),
(54, 'General Roca', 8332, 14),
(55, 'Cipolletti', 8324, 14),
(56, 'Bariloche', 8400, 14),
(57, 'Salta Capital', 4400, 15),
(58, 'Tartagal', 4560, 15),
(59, 'Orán', 4530, 15),
(60, 'Cafayate', 4427, 15),
(61, 'San Juan Capital', 5400, 16),
(62, 'Rawson', 5425, 16),
(63, 'Caucete', 5442, 16),
(64, 'Jáchal', 5460, 16),
(65, 'San Luis Capital', 5700, 17),
(66, 'Villa Mercedes', 5730, 17),
(67, 'Merlo', 5881, 17),
(68, 'La Punta', 5710, 17),
(69, 'Río Gallegos', 9400, 18),
(70, 'Caleta Olivia', 9311, 18),
(71, 'El Calafate', 9405, 18),
(72, 'Puerto Deseado', 9050, 18),
(73, 'Santa Fe Capital', 3000, 19),
(74, 'Rosario', 2000, 19),
(75, 'Rafaela', 2300, 19),
(76, 'Venado Tuerto', 2600, 19),
(77, 'Santiago del Estero Capital', 4200, 20),
(78, 'La Banda', 4300, 20),
(79, 'Termas de Río Hondo', 4220, 20),
(80, 'Añatuya', 3760, 20),
(81, 'Ushuaia', 9410, 21),
(82, 'Río Grande', 9420, 21),
(83, 'Tolhuin', 9430, 21),
(84, 'Puerto Almanza', 9411, 21),
(85, 'San Miguel de Tucumán', 4000, 22),
(86, 'Tafí Viejo', 4103, 22),
(87, 'Concepción', 4140, 22),
(88, 'Monteros', 4158, 22),
(89, 'Córdoba Capital', 5000, 23),
(90, 'Villa María', 5900, 23),
(91, 'Río Cuarto', 5800, 23),
(92, 'Alta Gracia', 5186, 23),
(93, 'Rawson', 9103, 24),
(94, 'Trelew', 9100, 24),
(95, 'Comodoro Rivadavia', 9000, 24),
(96, 'Puerto Madryn', 9120, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `activo` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `descripcion`, `activo`) VALUES
(1, 'Apple', 1),
(2, 'Lenovo', 1),
(3, 'HP', 1),
(4, 'Dell', 1),
(5, 'Samsung', 1),
(6, 'Noblex', 1),
(7, 'Exo', 1),
(8, 'ASUS', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `id_metodo_pago` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`id_metodo_pago`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Visa Débito', 'Pago con tarjeta Visa Débito', 'Activo'),
(2, 'Mastercard Débito', 'Pago con tarjeta Mastercard Débito', 'Activo'),
(3, 'Visa Crédito', 'Pago con tarjeta Visa Crédito', 'Activo'),
(4, 'Naranja X', 'Pago con tarjeta Naranja X', 'Activo'),
(5, 'Mercado Pago', 'Pago digital con billetera virtual', 'Activo'),
(6, 'Transferencia Bancaria', 'Pago mediante CBU o alias', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `baja` varchar(10) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `descripcion`, `baja`) VALUES
(1, 'Administrador', 'NO'),
(2, 'Cliente', 'NO'),
(3, 'Gerente', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio` float(10,2) NOT NULL,
  `precio_vta` float(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_min` int(11) NOT NULL,
  `eliminado` varchar(10) NOT NULL DEFAULT 'NO',
  `descripcion` varchar(500) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `imagen`, `id_categoria`, `precio`, `precio_vta`, `stock`, `stock_min`, `eliminado`, `descripcion`, `id_marca`, `id_proveedor`) VALUES
(1, 'Notebook HP 255 G10', '1750357085_488a01bf47c6378b8f25.png', 2, 453000.00, 408200.00, 6, 5, 'NO', '255 G10 Ryzen 7 16GB RAM 512GB SSD 15.6”', 3, 1),
(2, 'Notebook HP 255 G10', '1750357332_61a2a0e262115838db0d.png', 2, 290000.00, 273500.00, 7, 5, 'NO', 'Ryzen 5 7530U | 8GB RAM | 512GB SSD | Pantalla 15.6” HD', 3, 1),
(3, 'Notebook Apple MacBook Air 13 M2', '1750357515_987c9ca1ae82f177f3a1.png', 4, 1500000.00, 900000.00, 4, 5, 'NO', 'Chip M2 | 8GB RAM | 256GB SSD | Pantalla Retina 13.6”', 1, 1),
(4, 'Notebook Apple MacBook Pro 14 M3 Pro', '1750357606_a5a9d9f0f741d8f63810.png', 1, 893050.00, 700405.00, 1, 5, 'NO', 'Chip M3 Pro | 18GB RAM | 512GB SSD | Pantalla Liquid Retina XDR 14.2”', 1, 2),
(5, 'Notebook Lenovo IdeaPad 3 15ALC6', '1750357710_34e26334041e1f3b21c6.png', 3, 400000.00, 400000.00, 18, 5, 'NO', 'Ryzen 5 5500U | 8GB RAM | 512GB SSD | Pantalla 15.6” Full HD', 2, 2),
(6, 'Notebook Lenovo IdeaPad Slim 5 Gen 10', '1750357813_fb77a0bc4c58b3dc9e12.png', 5, 320000.00, 209000.00, 8, 5, 'NO', 'Ryzen 7 7735HS | 16GB RAM | 1TB SSD | Pantalla 15.3” WUXGA', 2, 3),
(7, 'Laptop Dell Inspiron 15 3520', '1750358512_899b5c1a013618d152d6.png', 1, 10000.00, 60000.00, 0, 2, 'NO', 'Intel Core i5 1235U | 8GB RAM | 512GB SSD | Pantalla 15.6” Full HD', 4, 5),
(8, 'Laptop Dell Vostro 14 3430', '1750358603_8c02a005237bd10ed989.png', 2, 300000.00, 105000.00, 7, 5, 'NO', 'Intel Core i7 1355U | 16GB RAM | 512GB SSD | Pantalla 14” Full HD', 4, 5),
(9, 'Notebook Samsung Galaxy Book3 360 13.3', '1750358732_3bb1b094be098c37f15e.png', 4, 900000.00, 900000.00, 9, 5, 'NO', 'Intel Core i5 1335U | 8GB RAM | 512GB SSD | Pantalla AMOLED 13.3” Full HD Touch', 5, 4),
(10, 'Notebook Samsung Galaxy Book3 Pro 15.6', '1750358787_bc757073f40002ee9d31.png', 1, 850000.00, 790000.00, 0, 5, 'NO', 'Intel Core i3 1260P | 6 Núcleos | 16GB RAM | 1TB SSD | Pantalla AMOLED 15.6” Full HD', 5, 4),
(11, 'Notebook Noblex N14X1010', '1750359052_d3d03ad7d578b9314b01.png', 3, 180000.00, 180000.00, 3, 5, 'NO', 'Intel Celeron N4020C | 4GB RAM | 128GB SSD | Pantalla 14.1” HD', 6, 1),
(12, 'Notebook Noblex N15W6100', '1750359095_20f2ebdb210117b2b577.png', 1, 80000.00, 80000.00, 1, 5, 'SI', 'Intel Core inside | 4GB RAM | 256GB SSD', 6, 2),
(13, 'Laptop Exo Smart XQ3T-C382', '1750359283_9b53ee20a9acfb3b5663.png', 1, 200000.00, 200000.00, 6, 5, 'NO', 'Intel Core i3 1005G1 | 8GB RAM | 128GB SSD | Pantalla 15.6” HD', 7, 3),
(14, 'Laptop Exo XR3 14', '1750359327_9ebfe375918ec9672e4e.png', 3, 305000.00, 290000.00, 9, 5, 'NO', 'Intel Celeron N4020 | 4GB RAM | 64GB SSD + 256GB SSD | Pantalla 14.1” HD', 7, 4),
(15, 'Laptop ASUS VivoBook 15 X1502ZA', '1750359715_9ae2f6a64319d2d6324d.png', 4, 700000.00, 680000.00, 6, 5, 'NO', 'Intel Core i5 1235U | 8GB RAM | 512GB SSD | Pantalla 15.6” Full HD', 8, 5),
(16, 'Laptop ASUS ZenBook 14 OLED UX3402ZA', '1750359949_b68b6db7b606c5c1fa12.png', 5, 600000.00, 560000.00, 5, 5, 'NO', 'Intel Core i7 1260P | 16GB RAM | 512GB SSD | Pantalla OLED 14” 2.8K', 8, 5),
(17, 'Laptop ASUS TUF Gaming F15 FX507ZC4', '1750359994_72c0f555e60354344472.png', 4, 400000.00, 400000.00, 8, 5, 'NO', 'Intel Core i5 12500H | 16GB RAM | 512GB SSD | NVIDIA RTX 3050 | Pantalla 15.6” FHD 144Hz', 8, 1),
(18, 'Lenovo Pro Max', '1781111405_e78273c3bfd9009b7dca.png', 1, 411990.00, 220000.00, 5, 2, 'NO', 'Equilibrio entre precio y rendimiento, buena para uso diario', 2, 2),
(19, 'Apple MacBook Air', '1781111313_01d2dc0c355de59f252e.png', 1, 2201234.00, 1514000.00, 7, 4, 'NO', 'Ultraportátil, silenciosa y con gran autonomía', 1, 1),
(20, 'HP Pavilion', '1781111234_8a4ec0e2126e1dadc2ef.png', 2, 1200033.00, 823000.00, 7, 2, 'NO', 'Pantalla Full HD, Intel Core, RAM, SSD', 3, 3),
(21, 'Dell XPS', '1781111134_0f4015ddb347d3b0470b.png', 1, 400000.00, 320000.00, 5, 2, 'NO', 'Pantalla InfinityEdge, Intel Core, SSD', 4, 2),
(22, 'Lenovo IdeaPad', '1781111039_fca7ef713dfe971b1fee.png', 1, 200090.00, 10000.00, 4, 2, 'NO', 'Pantalla 14” Full HD,SSD', 2, 5),
(23, 'Apple Macbook', '1781110945_54180e917fe5c072fd88.png', 4, 3290000.00, 2900000.00, 6, 4, 'NO', 'Ultraportátil, silenciosa y con gran autonomía', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre`, `apellido`, `email`) VALUES
(1, 'Carlos', 'Fernandez', 'cfernandez@gmail.com'),
(2, 'Maria', 'Gomez', 'mgomez@gmail.com'),
(3, 'Juan', 'Perez', 'jperez@gmail.com'),
(4, 'Lucia', 'Martinez', 'lmartinez@gmail.com'),
(5, 'Roberto', 'Lopez', 'rlopez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id_provincia`, `nombre`) VALUES
(1, 'Corrientes'),
(2, 'Chaco'),
(3, 'Misiones'),
(4, 'Formosa'),
(5, 'Entre Ríos'),
(6, 'Buenos Aires'),
(7, 'Catamarca'),
(9, 'Jujuy'),
(10, 'La Pampa'),
(11, 'La Rioja'),
(12, 'Mendoza'),
(13, 'Neuquén'),
(14, 'Río Negro'),
(15, 'Salta'),
(16, 'San Juan'),
(17, 'San Luis'),
(18, 'Santa Cruz'),
(19, 'Santa Fe'),
(20, 'Santiago del Estero'),
(21, 'Tierra del Fuego'),
(22, 'Tucumán'),
(23, 'Córdoba'),
(24, 'Chubut');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `id_perfil` int(11) NOT NULL DEFAULT 2,
  `baja` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `usuario`, `email`, `pass`, `id_perfil`, `baja`) VALUES
(3, 'Facundo Antonio', 'Fernandez Gonzalez', 'Facundo971', 'ffacundo544.fernandez.z@gmail.com', '$2y$10$Ry01OCgwK5Hn/pasxieuR.QXtbl/BsaHRl4VYXU9OVV0xPt6N7jq.', 1, 'NO'),
(4, 'Pepe', 'Fernandez', 'Pepe123', 'pepe@gmail.com', '$2y$10$Quo0IA0DRL/1v8ifrN9EW.ZbFg/B9wuqe7nkrk.ArWgnvEI7pW4rq', 2, 'NO'),
(5, 'Facundo', 'Fernandez', 'Facundo 2', 'facundo2@gmail.com', '$2y$10$ODInQrGz.xihmKJRIm7H6.ckHqjoFeqePXqeid8pd9zjBxsNLW7S6', 2, 'SI'),
(6, 'Pepe', 'Lopez', 'El Pepe 123', 'pepe123@gmail.com', '$2y$10$l5Ubcs5mHRQ4zSff42olNuOW5RBDaMP/ZX589e0iuQ7HjXAS2DTf.', 2, 'SI'),
(7, 'Messi', 'Lionel', 'GOAT', 'messi10@gmail.com', '$2y$10$Gjv5lTpiNGKLA4EzMLLXb.adiB2ikpWoG1DVkeFjZ.RyGQMSODm3.', 2, 'NO'),
(8, 'Ronaldo', 'Cristiano', 'CR7 7777', 'cristiano7@gmail.com', '$2y$10$EL3RTTizhhur.FJm87/sk.0TO2iRYinyrcnZ9rsoJtLt8UrVX6wRu', 2, 'NO'),
(9, 'Facu Anto', 'Fernan Gonza', 'Facu971', 'ffacundo544.fernandez.z971@gmail.com', '$2y$10$C1/HB7WQDRgP7upIT.WFcOftLt541EGTq5p3pA9XlW7zq78rMkSdW', 2, 'NO'),
(10, 'Raul', 'Perez', 'Raul Perez 1', 'pepePe@gmail.com', '$2y$10$ld.0Lv2mkbfLJ7t7vmdsQe1WyelKJD4xcBEMY3PQ/YQuLMrEHNt5m', 2, 'SI'),
(11, 'Antonio', 'Fernandez', 'AntoFer1', 'elusuario12345@gmail.com', '$2y$10$31xhvRzyzojRoqhXrfc/FOGtEUN6C5uZ5x.BPOHJtd7ObhHnyRKJK', 2, 'NO'),
(12, 'Facundo', 'Fer', 'Facundo 4', 'facundo4@gmail.com', '$2y$10$P.9KDeWBsCwaW2uiBXGCh./avGvPXaXiO4Vrxnw5s.cqHemFhC7He', 2, 'NO'),
(13, 'Facundo', 'Gomez', 'Persona', 'facundoAbc@gmail.com', '$2y$10$/vT4dI4griPTVleda32JY.SF9FYlovgqbFjQA.sMh7oBsKTlWm/MO', 2, 'SI'),
(14, 'Antonio Facu', 'Fernandez', 'Nose 123', 'facundoCorreo1@gmail.com', '$2y$10$daMujxy6/jmgsihwzkj1we5jRvOsKh4xuIjhXx/pfDPat2c95YVx2', 2, 'SI'),
(15, 'Julio', 'Perez', 'Julio25', 'julioPerez@gmail.com', '$2y$10$7z.tUV5MFuYa0VI4mvnUeeRxw/XLZ24Z8KT5.QANdarK7bB2ZTDde', 1, 'NO'),
(16, 'Pedro', 'Perez', 'Pedro25', 'pedroPerez@gmail.com', '$2y$10$1o36jjQwUK.XKX62Eroj6.XkzrPnHJAaWOYYVdb6aOdSSoeSEzWxS', 2, 'NO'),
(17, 'Antonio Facu', 'Fernandez', 'FaCuNdO7', 'facundo70@gmail.com', '$2y$10$Dxi8IEiZi0efiW/pxZF8IOPq7k.YqIn9CLUVGt/TYnPav79z4KnP2', 2, 'NO'),
(18, 'Facundo', 'Fernandez', 'FacuFG91', 'facundoFGA@gmail.com', '$2y$10$Ni3PaxgzlrJhEk7AR8dX1umbuQ8scGz9hk7cpCggM3esNExrUxTTq', 2, 'NO'),
(19, 'Eme', 'Liz', 'Emelia6', 'emilia456@gmail.com', '$2y$10$TT75xWIcCPL.kNPHEvpb4uJxuSZbHEZlIB1PbP8RnQvaH/C6vCc1y', 2, 'NO'),
(20, 'Lilo', 'Lopez', 'Lilo1234', 'lilo@gmail.com', '$2y$10$E6TwK.mAbf8.s8g.mqJTtuDCNz/Kb4pjm8ejKGDNwWegHhCB3mfnu', 2, 'SI'),
(21, 'Kalel', 'John', 'Kalel123', 'kaleJohn123@gmail.com', '$2y$10$WIKyffGIik00m508RByDxumZU2eTe0GCnclHPOB5NIZQFlf87qUni', 2, 'NO'),
(22, 'Joel', 'Hernandez', 'Joe123', 'joel123@gmail.com', '$2y$10$o/JJIO9NtUHdO0ThJyxuLuwyJBQMAOzLstKeVLLh6rJ3G1D4PUeKm', 2, 'NO'),
(23, 'Ronaldo', 'Nazario', 'RonaldoZ7', 'ronaldoZ7@gmail.com', '$2y$10$NhXSCrdmXiehh/cMA8PnjOt/cTi6XyHgfgIeJ7bfPpTkpvKRL5FDe', 2, 'NO'),
(24, 'Ronaldo', 'Lopez', 'RLopez7', 'ronaldoLopez7@gmail.com', '$2y$10$X1rxbERrnyyX0JWHauXHrOdvu0xR.9SEgTdOpnXD.9Hn2fy98hinW', 2, 'NO'),
(25, 'Lara', 'Croff', 'Lara123', 'lara123@gmail.com', '$2y$10$Pz/gxLU8/rratz9Yyzi.FePKQ0l9XaDoCyro6/q2.o1NgJybLGC4y', 2, 'NO'),
(26, 'Lana', 'Rodriguez', 'Lana123', 'lanaRodriguez123@gmail.com', '$2y$10$kspEwA0azyexSyh4RKbrK.YfKfHjYOab.1R38xfQIGd1i50xbFkFG', 2, 'NO'),
(27, 'Juan', 'Lopez', 'JuanL 123', 'juanlopez@gmail.com', '$2y$10$WefgRE9i/jXQe7PE/AwtGeqQX5GHLabwyz8Rtmz35SRATOAf/NfDq', 2, 'NO'),
(28, 'Juan', 'Perez', 'JuanPerez 7', 'juanPerezzz@gmail.com', '$2y$10$SMrtbSGSoLS.bkgqjfKK6eEz8xPOIMrBhUyryhANYj3BYziaHTJii', 2, 'SI'),
(29, 'Facundo', 'Martinez', 'FacundoM 971', 'facundoM@gmail.com', '$2y$10$xDirJuQ9TdFe/y.IUXgVj.QEoH2y.969WtoOsw9g9u.E8hVrpkGUW', 2, 'NO'),
(30, 'Axel', 'Fernandez Joel', 'AxelJ971', 'axelJoel971@gmail.com', '$2y$10$sXjGgwA.Ld9XVpcjLRSL2.BNOInw/nLb4EUg3CLGMT0F5lT4f2HCO', 2, 'SI'),
(31, 'Abril', 'Lopez', 'AbrilLopez', 'abrilLopez@gmail.com', '$2y$10$nKEzBc1Jvm2ovIblsnJVFeEqNeSqKtN2qED.Z3PX.LRgOXg6.Jfoy', 2, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_cabecera`
--

CREATE TABLE `venta_cabecera` (
  `id_venta_cabecera` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `total_venta` float(10,2) NOT NULL,
  `id_metodo_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_cabecera`
--

INSERT INTO `venta_cabecera` (`id_venta_cabecera`, `fecha`, `id_usuario`, `total_venta`, `id_metodo_pago`) VALUES
(1, '2025-06-07 16:40:11', 5, 13000.00, 1),
(2, '2025-06-07 16:42:07', 5, 13000.00, 1),
(3, '2025-06-07 16:59:30', 5, 25000.00, 2),
(4, '2025-06-07 19:01:58', 5, 8500.00, 1),
(5, '2025-06-07 21:44:17', 5, 5500.00, 3),
(6, '2025-06-07 21:46:24', 6, 11500.00, 1),
(7, '2025-06-07 22:15:33', 6, 20500.00, 1),
(8, '2025-06-08 09:47:51', 5, 500.00, 4),
(9, '2025-06-08 09:49:30', 5, 5000.00, 1),
(10, '2025-06-08 09:50:20', 5, 3000.00, 2),
(11, '2025-06-08 09:52:52', 5, 14500.00, 5),
(12, '2025-06-08 10:44:33', 5, 10000.00, 1),
(13, '2025-06-08 10:55:54', 5, 23000.00, 1),
(14, '2025-06-08 11:06:32', 5, 5000.00, 2),
(15, '2025-06-11 15:22:27', 5, 15000.00, 1),
(16, '2025-06-11 16:59:33', 5, 15000.00, 2),
(17, '2025-06-13 15:32:38', 5, 15000.00, 5),
(18, '2025-06-13 15:35:05', 5, 12346.00, 5),
(19, '2025-06-15 07:24:23', 5, 100782.00, 5),
(20, '2025-06-18 18:24:19', 5, 240794.00, 2),
(21, '2025-06-18 18:26:38', 5, 155806.00, 3),
(22, '2025-06-18 18:27:39', 5, 7346.00, 1),
(23, '2025-06-18 18:36:35', 5, 350782.00, 2),
(24, '2025-06-18 19:40:49', 5, 5000.00, 5),
(25, '2025-06-19 17:36:03', 5, 2363500.00, 1),
(26, '2025-06-19 18:28:48', 5, 4927605.00, 1),
(27, '2026-04-06 19:44:19', 19, 700405.00, 5),
(28, '2026-04-09 09:25:06', 19, 1600810.00, 5),
(29, '2026-04-21 14:44:22', 4, 760405.00, 5),
(32, '2026-05-16 06:43:26', 4, 1490405.00, 1),
(33, '2026-05-16 06:45:13', 4, 62000.00, 1),
(34, '2026-05-16 06:48:00', 4, 1771600.00, 1),
(35, '2026-05-20 22:59:37', 4, 1580000.00, 2),
(36, '2026-05-21 19:54:21', 4, 1580000.00, 2),
(37, '2026-06-09 03:54:02', 4, 850000.00, 1),
(38, '2026-06-10 18:52:43', 4, 1514000.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_detalle`
--

CREATE TABLE `venta_detalle` (
  `id_venta_detalle` int(11) NOT NULL,
  `id_venta_cabecera` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_detalle`
--

INSERT INTO `venta_detalle` (`id_venta_detalle`, `id_venta_cabecera`, `id_producto`, `cantidad`, `precio`) VALUES
(1, 1, 2, 2, 10000.00),
(2, 2, 2, 2, 10000.00),
(3, 2, 3, 1, 3000.00),
(4, 3, 2, 5, 25000.00),
(5, 4, 1, 1, 500.00),
(6, 4, 2, 1, 5000.00),
(7, 4, 3, 1, 3000.00),
(8, 5, 1, 1, 500.00),
(9, 5, 2, 1, 5000.00),
(10, 6, 1, 3, 1500.00),
(11, 6, 2, 2, 10000.00),
(12, 7, 1, 1, 500.00),
(13, 7, 2, 1, 5000.00),
(14, 7, 3, 5, 15000.00),
(15, 8, 1, 1, 500.00),
(16, 9, 2, 1, 5000.00),
(17, 10, 3, 1, 3000.00),
(18, 11, 2, 2, 10000.00),
(19, 11, 1, 3, 1500.00),
(20, 11, 3, 1, 3000.00),
(21, 12, 2, 2, 10000.00),
(22, 13, 2, 4, 5000.00),
(23, 13, 3, 1, 3000.00),
(24, 14, 2, 1, 5000.00),
(25, 15, 2, 2, 5000.00),
(26, 15, 3, 1, 5000.00),
(27, 16, 3, 1, 5000.00),
(28, 16, 2, 2, 5000.00),
(29, 17, 2, 3, 5000.00),
(30, 18, 1, 3, 782.00),
(31, 18, 2, 2, 5000.00),
(32, 19, 2, 2, 5000.00),
(33, 19, 4, 1, 90000.00),
(34, 19, 1, 1, 782.00),
(35, 20, 1, 1, 782.00),
(36, 20, 6, 1, 12.00),
(37, 20, 5, 1, 150000.00),
(38, 20, 4, 1, 90000.00),
(39, 21, 2, 1, 5000.00),
(40, 21, 1, 1, 782.00),
(41, 21, 5, 1, 150000.00),
(42, 21, 6, 2, 12.00),
(43, 22, 1, 3, 782.00),
(44, 22, 2, 1, 5000.00),
(45, 23, 2, 4, 5000.00),
(46, 23, 5, 1, 150000.00),
(47, 23, 4, 2, 90000.00),
(48, 23, 1, 1, 782.00),
(49, 24, 2, 1, 5000.00),
(50, 25, 5, 1, 400000.00),
(51, 25, 10, 1, 790000.00),
(52, 25, 9, 1, 900000.00),
(53, 25, 2, 1, 273500.00),
(54, 26, 4, 1, 700405.00),
(55, 26, 3, 2, 900000.00),
(56, 26, 1, 1, 408200.00),
(57, 26, 10, 1, 790000.00),
(58, 26, 16, 1, 560000.00),
(59, 26, 6, 1, 209000.00),
(60, 26, 7, 1, 60000.00),
(61, 26, 5, 1, 400000.00),
(62, 27, 4, 1, 700405.00),
(63, 28, 4, 2, 700405.00),
(64, 28, 13, 1, 200000.00),
(65, 29, 4, 1, 700405.00),
(66, 29, 7, 1, 60000.00),
(68, 32, 10, 1, 790000.00),
(69, 32, 4, 1, 700405.00),
(70, 33, 18, 2, 1000.00),
(71, 33, 7, 1, 60000.00),
(72, 34, 1, 3, 408200.00),
(73, 34, 2, 2, 273500.00),
(74, 35, 10, 2, 790000.00),
(75, 36, 10, 2, 790000.00),
(76, 37, 7, 1, 60000.00),
(77, 37, 10, 1, 790000.00),
(78, 38, 19, 1, 1514000.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `id_localidad` (`id_localidad`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id_localidad`),
  ADD KEY `id_provincia` (`id_provincia`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`id_metodo_pago`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria_id` (`id_categoria`),
  ADD KEY `marca_id` (`id_marca`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `perfil_id` (`id_perfil`);

--
-- Indices de la tabla `venta_cabecera`
--
ALTER TABLE `venta_cabecera`
  ADD PRIMARY KEY (`id_venta_cabecera`),
  ADD KEY `usuario_id` (`id_usuario`),
  ADD KEY `id_metodo_pago` (`id_metodo_pago`);

--
-- Indices de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD PRIMARY KEY (`id_venta_detalle`),
  ADD KEY `venta_id` (`id_venta_cabecera`),
  ADD KEY `producto_id` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id_localidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `id_metodo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `venta_cabecera`
--
ALTER TABLE `venta_cabecera`
  MODIFY `id_venta_cabecera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  MODIFY `id_venta_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `direccion_ibfk_1` FOREIGN KEY (`id_localidad`) REFERENCES `localidad` (`id_localidad`),
  ADD CONSTRAINT `direccion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id_provincia`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Filtros para la tabla `venta_cabecera`
--
ALTER TABLE `venta_cabecera`
  ADD CONSTRAINT `venta_cabecera_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `venta_cabecera_ibfk_2` FOREIGN KEY (`id_metodo_pago`) REFERENCES `metodo_pago` (`id_metodo_pago`);

--
-- Filtros para la tabla `venta_detalle`
--
ALTER TABLE `venta_detalle`
  ADD CONSTRAINT `venta_detalle_ibfk_1` FOREIGN KEY (`id_venta_cabecera`) REFERENCES `venta_cabecera` (`id_venta_cabecera`),
  ADD CONSTRAINT `venta_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
