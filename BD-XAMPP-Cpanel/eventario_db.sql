-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2023 a las 18:57:24
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
  `hora_fin` time DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`IDeventos`, `evento`, `fecha`, `lugar`, `imagen`, `descripcion`, `hora`, `limite_inscritos`, `hora_fin`, `activo`) VALUES
(47, 'Semana TIC 2023 cba', '2023-11-30', 'Universidad Blas Sede Cordoba', 'images/semanatic.jpg', 'Disfruta del evento tecnologico del año de la mano de grandes oradores!', '09:00:00', 500, '21:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventosorganizador`
--

CREATE TABLE `eventosorganizador` (
  `IDorganizador` int(11) NOT NULL,
  `IDeventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventosorganizador`
--

INSERT INTO `eventosorganizador` (`IDorganizador`, `IDeventos`) VALUES
(1, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `IDinscripcion` int(11) NOT NULL,
  `IDeventos` int(11) NOT NULL,
  `IDusuario` int(11) NOT NULL,
  `asistio` tinyint(1) DEFAULT 0,
  `pago` tinyint(1) DEFAULT 0,
  `activo` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `organizador`
--

CREATE TABLE `organizador` (
  `IDorganizador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `celular` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `organizador`
--

INSERT INTO `organizador` (`IDorganizador`, `nombre`, `correo`, `contrasena`, `celular`) VALUES
(1, 'UBP', 'ubp@gmail.com', 'ubp', '3571603501');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IDusuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `esAdmin` varchar(1) DEFAULT NULL,
  `apellido` varchar(255) NOT NULL,
  `celular` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IDusuario`, `nombre`, `email`, `contrasena`, `esAdmin`, `apellido`, `celular`) VALUES
(18, 'Juan', 'vazquez800juan@gmail.com', '12345678', 's', 'Vazquez', '3571603501'),
(19, 'fede', 'fededella@gmail.com', '12345678', NULL, 'dellavalle', '448988'),
(20, 'Pedro', 'pvaldez@gmail.com', 'pedro123', NULL, 'Valdez', '3571603501');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`IDeventos`);

--
-- Indices de la tabla `eventosorganizador`
--
ALTER TABLE `eventosorganizador`
  ADD PRIMARY KEY (`IDorganizador`,`IDeventos`),
  ADD KEY `IDeventos` (`IDeventos`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`IDinscripcion`),
  ADD KEY `FK__inscripciones__eventos` (`IDeventos`),
  ADD KEY `FK__inscripciones__usuarios` (`IDusuario`);

--
-- Indices de la tabla `organizador`
--
ALTER TABLE `organizador`
  ADD PRIMARY KEY (`IDorganizador`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDusuario`),
  ADD UNIQUE KEY `UC_nombre_completo` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `IDeventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `IDinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `organizador`
--
ALTER TABLE `organizador`
  MODIFY `IDorganizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventosorganizador`
--
ALTER TABLE `eventosorganizador`
  ADD CONSTRAINT `eventosorganizador_ibfk_1` FOREIGN KEY (`IDorganizador`) REFERENCES `organizador` (`IDorganizador`),
  ADD CONSTRAINT `eventosorganizador_ibfk_2` FOREIGN KEY (`IDeventos`) REFERENCES `eventos` (`IDeventos`);

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `FK__inscripciones__eventos` FOREIGN KEY (`IDeventos`) REFERENCES `eventos` (`IDeventos`),
  ADD CONSTRAINT `FK__inscripciones__usuarios` FOREIGN KEY (`IDusuario`) REFERENCES `usuarios` (`IDusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
