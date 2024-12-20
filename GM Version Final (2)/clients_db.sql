-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2024 a las 01:01:39
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
-- Base de datos: `clients_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `cl_password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `email`, `cl_password`) VALUES
(6586, 'franco', 'franco@uca.edu', 'fran1234'),
(6587, 'franki', 'frank@uca.edu.ar', 'frank123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `or_clientId` int(11) NOT NULL,
  `or_prId` int(11) NOT NULL,
  `or_operation` varchar(30) NOT NULL,
  `or_qty` int(15) DEFAULT NULL,
  `or_totprice` float DEFAULT NULL,
  `or_status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`orderId`, `or_clientId`, `or_prId`, `or_operation`, `or_qty`, `or_totprice`, `or_status`) VALUES
(118, 6586, 100, 'sell', 1, 0.9803, 0),
(119, 6587, 100, 'buy', 8, 7.8584, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `positions`
--

CREATE TABLE `positions` (
  `pos_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `pos_totactive` int(11) DEFAULT NULL,
  `pos_wallet` float DEFAULT NULL,
  `pos_profit` float DEFAULT NULL,
  `pos_loss` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `positions`
--

INSERT INTO `positions` (`pos_id`, `client_id`, `pos_totactive`, `pos_wallet`, `pos_profit`, `pos_loss`) VALUES
(84, 6586, 1, 5499.02, 0, 0),
(85, 6587, 1, 5492.14, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `pr_type` varchar(15) NOT NULL,
  `pr_descr` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`productId`, `pr_type`, `pr_descr`) VALUES
(100, 'divisa', 'EUR/USD'),
(101, 'divisa', 'USD/JPY'),
(103, 'divisa', 'GBP/USD'),
(104, 'divisa', 'USD/TRY'),
(105, 'divisa', 'USD/CAD'),
(106, 'divisa', 'EUR/JPY'),
(107, 'divisa', 'AUD/USD'),
(108, 'divisa', 'EUR/GBP'),
(109, 'divisa', 'GBP/NZD'),
(110, 'divisa', 'GBP/CAD'),
(111, 'divisa', 'USD/RUB'),
(112, 'acciones', 'Tecent'),
(113, 'acciones', 'Denso'),
(114, 'acciones', 'Xiaomi'),
(115, 'acciones', 'Bank_of_E_Asia'),
(116, 'acciones', 'PorscheAG'),
(117, 'acciones', 'Apple'),
(118, 'acciones', 'Tesla'),
(119, 'acciones', 'Colruyt'),
(120, 'acciones', 'NIO'),
(121, 'acciones', 'Alphabet'),
(122, 'acciones', 'Amazon'),
(123, 'materias primas', 'Petroleo'),
(124, 'materias primas', 'Plata'),
(125, 'materias primas', 'Petroleo_Brent'),
(126, 'materias primas', 'Oro'),
(127, 'materias primas', 'Azucar'),
(128, 'materias primas', 'Cobre'),
(129, 'materias primas', 'Paladio'),
(130, 'materias primas', 'Cafe'),
(131, 'materias primas', 'Gas_Natural'),
(132, 'materias primas', 'Gasolina'),
(133, 'materias primas', 'Soja');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `email_2` (`email`,`cl_password`),
  ADD KEY `email` (`email`,`cl_password`),
  ADD KEY `cl_password` (`cl_password`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `fk_clientId` (`or_clientId`),
  ADD KEY `fk_prId` (`or_prId`);

--
-- Indices de la tabla `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`pos_id`),
  ADD UNIQUE KEY `client_id_2` (`client_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6588;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `positions`
--
ALTER TABLE `positions`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_clientId` FOREIGN KEY (`or_clientId`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `fk_prId` FOREIGN KEY (`or_prId`) REFERENCES `products` (`productId`);

--
-- Filtros para la tabla `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `client_id_fk` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
