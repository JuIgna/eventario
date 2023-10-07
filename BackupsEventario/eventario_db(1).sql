-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2023 a las 16:30:29
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
  `descripcion` varchar(200) DEFAULT NULL,
  `hora` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`IDeventos`, `evento`, `fecha`, `lugar`, `imagen`, `descripcion`, `hora`) VALUES
(1, 'Evento 1', '2023-06-10', 'Ciudad X', 'evento1.jpg', NULL, NULL),
(2, 'Evento 2', '2023-07-15', 'Ciudad Y', 'evento2.jpg', NULL, NULL),
(3, 'Evento 3', '2023-08-20', 'Ciudad Z', 'evento3.jpg', NULL, NULL),
(10, 'evento 4', '2023-06-07', 'fother', 'images/messi.jpeg', NULL, NULL),
(11, 'eventerio 1', '2023-06-14', 'dsas', 'images/messi.jpeg', NULL, NULL),
(12, 'evento', '2023-07-14', 'asdassdsad', 'images/messi.jpeg', NULL, NULL),
(13, 'Parcial SBD', '2023-06-01', 'Blas Pascal', 'images/hugito.png', 'Este jueves preparate para la cojida del año con el parcial de SBD', '17:00:00'),
(14, 'Entrega Pagina Eventario', '2023-06-02', 'Universidad Blas Pascal', 'images/funes.jpg', 'Entrega del Trabajo Practio 1. CRUD con HTML, CSS, PHP y SQL', '15:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `IDinscripcion` int(11) NOT NULL,
  `IDeventos` int(11) NOT NULL,
  `IDusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`IDinscripcion`, `IDeventos`, `IDusuario`) VALUES
(14, 13, 4),
(16, 14, 3),
(17, 14, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IDusuario` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `esAdmin` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IDusuario`, `nombre_completo`, `email`, `contrasena`, `esAdmin`) VALUES
(3, 'juan', 'vazquez800juan@gmail.com', 'juan', NULL),
(4, 'Fede', 'vazquez800juan@gmail.com', 'fede', 's'),
(6, 'Sulakan', 'juignavazquez@gmail.com', 'sulakan', NULL),
(7, 'Lautaro', 'juignavazquez@gmail.com', '123', NULL),
(8, 'Pedro', 'vazquez800juan@gmail.com', '123', NULL),
(9, 'Martin', 'vazquez800juan@gmail.com', '123', NULL),
(10, 'Roberto', 'vazquez800juna@gmail.com', '123', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`IDeventos`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`IDinscripcion`),
  ADD KEY `FK__inscripciones__eventos` (`IDeventos`),
  ADD KEY `FK__inscripciones__usuarios` (`IDusuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDusuario`),
  ADD UNIQUE KEY `UC_nombre_completo` (`nombre_completo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `IDeventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `IDinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

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
