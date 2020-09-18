-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-09-2020 a las 02:39:02
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `petfinder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal_type`
--

CREATE TABLE `animal_type` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lost_pets`
--

CREATE TABLE `lost_pets` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `animal_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `lost_type_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `photo` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animal_type`
--
ALTER TABLE `animal_type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lost_pets`
--
ALTER TABLE `lost_pets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lost_type_id` (`lost_type_id`),
  ADD KEY `gender_id` (`gender_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animal_type`
--
ALTER TABLE `animal_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lost_pets`
--
ALTER TABLE `lost_pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `lost_pets`
--
ALTER TABLE `lost_pets`
  ADD CONSTRAINT `lost_pets_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animal_type` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `lost_pets_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `lost_pets_ibfk_3` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `lost_pets_ibfk_4` FOREIGN KEY (`lost_type_id`) REFERENCES `lost_type` (`id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
