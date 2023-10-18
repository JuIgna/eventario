-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2023 a las 22:02:43
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `eventario_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `IDeventos` int(11) NOT NULL,
  `evento` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `limite_inscritos` int(11) DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`IDeventos`, `evento`, `fecha`, `lugar`, `imagen`, `descripcion`, `hora`, `limite_inscritos`, `hora_fin`) VALUES
(24, 'Maratón Rio Tercero', '2023-09-10', 'Ciudad de Rio Tercero', 'images/diCiudadRio3.png', 'Vení a disfrutar de esta imperdible maratón en la ciudad de Rio Tercero por el 110 aniversario de la ciudad!!', '10:00:00', 150, '13:00:00'),
(37, 'Semana TIC', '2023-10-18', 'Universidad Blas Pascal', 'images/tic.png', 'Disfruta de la semana TIC en Cordoba de la mano de increibles charlas y proyectos educativos y tecnologicos!!', '17:00:00', 50, '20:00:00'),
(38, 'Torneo Clash', '2023-10-21', 'Rio Tercero', 'images/unnamed.png', 'Veni a cagarte a trompadas en este torneo de Clash Royale!!', '10:00:00', 20, '17:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`IDeventos`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `IDeventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
