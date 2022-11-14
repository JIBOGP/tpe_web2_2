-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2022 a las 23:02:18
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpe_web2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(31) NOT NULL,
  `estructura_especificaciones` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `estructura_especificaciones`) VALUES
(1, 'Procesadores', 'a:5:{i:0;s:7:\"Nucleos\";i:1;s:5:\"Hilos\";i:2;s:10:\"Frecuencia\";i:3;s:16:\"Frecuencia turbo\";i:4;s:3:\"345\";}'),
(2, 'Placas de video', 'a:3:{i:0;s:9:\"Capacidad\";i:1;s:4:\"Hdmi\";i:2;s:12:\"Displayports\";}'),
(3, 'Almacenamiento', 'a:5:{i:0;s:4:\"Tipo\";i:1;s:9:\"Capacidad\";i:2;s:33:\"Velocidad de escritura secuencial\";i:3;s:31:\"Velocidad de lectura secuencial\";i:4;s:22:\"Velocidad de rotación\";}'),
(43, 'Monitores', 'a:4:{i:0;s:5:\"Marca\";i:1;s:8:\"Pulgadas\";i:2;s:17:\"Frecuencia maxima\";i:3;s:7:\"Calidad\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `comentario` varchar(300) NOT NULL,
  `mg` int(11) NOT NULL DEFAULT 0,
  `nmg` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_producto`, `comentario`, `mg`, `nmg`) VALUES
(7, 130, 'no es lo que esperaba pero estoy satisfecho', 2, 20),
(9, 130, 'AMD es mejor', 6, 5),
(10, 140, 'Goku le gana', 68, 25),
(11, 130, '10/10', 0, 0),
(12, 146, 'Me sirve para mi servidor', 0, 0),
(14, 146, 'asdasd', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_productos`
--

CREATE TABLE `lista_productos` (
  `id` int(11) NOT NULL,
  `categoria_fk` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(63) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `precio` double NOT NULL,
  `especificaciones` varchar(511) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lista_productos`
--

INSERT INTO `lista_productos` (`id`, `categoria_fk`, `nombre`, `imagen`, `stock`, `precio`, `especificaciones`) VALUES
(130, 1, 'Intel Core i7 12700K', 'app/views/images/634f7f25bd304.jpg', 50, 0, 'a:4:{i:0;s:2:\"12\";i:1;s:2:\"20\";i:2;s:8:\"2700 mhz\";i:3;s:8:\"5000 mhz\";}'),
(136, 3, 'WD 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:5:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";i:4;s:0:\"\";}'),
(140, 2, 'MSI GeForce RTX 3090 24GB GDDR6X GAMING X TRIO', 'app/views/images/634c6b89d18a7.jpg', 126, 295000, 'a:3:{i:0;s:5:\"24 GB\";i:1;s:1:\"1\";i:2;s:1:\"3\";}'),
(144, 43, 'GAMER SAMSUNG NEO', 'app/views/images/634dfd27aaed3.jpg', 3, 699999, 'a:4:{i:0;s:7:\"Samsung\";i:1;s:14:\"75&#039;&#039;\";i:2;s:6:\"120 hz\";i:3;s:2:\"4K\";}'),
(145, 1, 'AMD Ryzen 9 7950X', 'app/views/images/634dfddd53968.jpg', 23, 209650, 'a:3:{i:0;s:2:\"16\";i:1;s:2:\"32\";i:2;s:8:\"4500 mhz\";}'),
(146, 3, 'WD 14TB Purple', 'app/views/images/634dfecc8cfea.jpg', 5, 84390, 'a:5:{i:0;s:3:\"HDD\";i:1;s:5:\"14 TB\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:8:\"7200 rpm\";}'),
(168, 2, 'MSI GeForce RTX 3060 12GB GDDR6 GAMING X TRIO', 'app/views/images/634c6b89d18a7.jpg', 126, 295000, 'a:3:{i:0;s:5:\"24 GB\";i:1;s:1:\"1\";i:2;s:1:\"3\";}'),
(1453, 1, 'Intel Core i7 12700KF', 'app/views/images/634b831974a41.jpg', 33, 104400, 'a:5:{i:0;s:2:\"12\";i:1;s:2:\"20\";i:2;s:8:\"2700 mhz\";i:3;s:6:\"345345\";i:4;s:9:\"34534bsdf\";}'),
(1455, 3, 'AA 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:4:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";}'),
(1457, 3, '&lt;sdf&gt;WD 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 560, 73500, 'a:5:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:10:\"6600 mb/s0\";i:4;s:1:\"0\";}'),
(1458, 3, '&lt;sdf&gt;WD 2TB Black SN850X', '', 56, 73500, 'a:4:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";}'),
(1459, 3, '&lt;sdf&gt;WD 2TB Black SN850X', '', 56, 73500, 'a:4:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";}'),
(1460, 3, '&lt;sdf&gt;WD 2TB Black SN850X', NULL, 56, 73500, 'a:4:{i:0;s:2:\"M2\";i:1;s:4:\"2 TB\";i:2;s:9:\"7300 mb/s\";i:3;s:9:\"6600 mb/s\";}'),
(1461, 3, 'AA 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:3:{i:0;s:3:\"456\";i:1;s:6:\"245670\";i:2;s:8:\"7845 mhz\";}'),
(1470, 3, 'AA 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:2:{i:0;s:5:\"srtrt\";i:1;s:6:\"435 tb\";}'),
(1471, 3, 'AA 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:3:{i:0;s:2:\"45\";i:1;s:2:\"23\";i:2;s:3:\"400\";}'),
(1472, 3, 'AA 2TB Black SN850X', 'app/views/images/634b83242933a.jpg', 56, 73500, 'a:5:{i:0;s:4:\"asdf\";i:1;s:0:\"\";i:2;s:5:\"23432\";i:3;s:0:\"\";i:4;s:0:\"\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_admin`
--

CREATE TABLE `users_admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(31) NOT NULL,
  `contrasenia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users_admin`
--

INSERT INTO `users_admin` (`id`, `nombre`, `contrasenia`) VALUES
(1, 'Admin1', '$2a$12$17rQub70BZ8z8vuzqoXZh.gncQUyhx2AMjqVHrLLP8dhtvhb2y2Zi');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoria_unica` (`categoria`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coment` (`id_producto`);

--
-- Indices de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lista_productos_ibfk_1` (`categoria_fk`);

--
-- Indices de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1473;

--
-- AUTO_INCREMENT de la tabla `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `coment` FOREIGN KEY (`id_producto`) REFERENCES `lista_productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `lista_productos`
--
ALTER TABLE `lista_productos`
  ADD CONSTRAINT `lista_productos_ibfk_1` FOREIGN KEY (`categoria_fk`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
