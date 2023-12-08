-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-12-2023 a las 19:50:44
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
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `IDadministrador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `celular` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`IDadministrador`, `nombre`, `correo`, `contrasena`, `celular`) VALUES
(1, 'Juan Vazquez', 'juignavazquez@gmail.com', 'juigna123', '3571603501');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriaevento`
--

CREATE TABLE `categoriaevento` (
  `IDcategoria` int(11) NOT NULL,
  `nombrecategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoriaevento`
--

INSERT INTO `categoriaevento` (`IDcategoria`, `nombrecategoria`) VALUES
(1, 'Deportivo'),
(2, 'Cultural'),
(3, 'Musical'),
(4, 'Ciencia'),
(5, 'Tecnologico');

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
  `activo` tinyint(1) NOT NULL DEFAULT 0,
  `Costo` float DEFAULT NULL,
  `FechaAlta` timestamp NOT NULL DEFAULT current_timestamp(),
  `IDcategoria` int(11) DEFAULT NULL,
  `duracion` time DEFAULT NULL,
  `organizador` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`IDeventos`, `evento`, `fecha`, `lugar`, `imagen`, `descripcion`, `hora`, `limite_inscritos`, `hora_fin`, `activo`, `Costo`, `FechaAlta`, `IDcategoria`, `duracion`, `organizador`) VALUES
(51, 'Maratón Almafuerte', '2023-12-16', 'Ciudad de Almafuerte, Cordoba, Argentina', 'images/maratonAlmafuerte.jpg', 'Veni a disfrutar de esta increible maraton en la ciudad de Almafuerte!!', '10:00:00', 450, '12:30:00', 0, 7500, '2023-12-06 20:51:34', 1, '02:30:00', NULL),
(52, 'Curso Manejo Teorico ', '2023-12-20', 'Guillermo Marconi 1320, Rio Tercero, Cordoba, Argentina', 'images/cursoManejo.png', 'La municipalidad de Rio Tercero organiza cursos de manejo teoricos para que puedas conseguir tu licencia de forma mas facil. Gestion Marcos Ferrer', '20:00:00', 80, '22:00:00', 1, 0, '2023-12-06 21:14:18', 2, '02:00:00', NULL),
(55, 'Curso sobre armado de bombas', '2023-12-30', 'Municipalidad de Rio Tercero', 'images/descarga.jpg', 'Rompete unas bombitas!', '10:00:00', 500, '15:00:00', 1, 18000, '2023-12-08 14:51:08', 2, '05:00:00', 'Municipalidad de Rio Tercero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventosadministrador`
--

CREATE TABLE `eventosadministrador` (
  `IDadministrador` int(11) NOT NULL,
  `IDeventos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`IDinscripcion`, `IDeventos`, `IDusuario`, `asistio`, `pago`, `activo`) VALUES
(64, 55, 19, 0, 0, 0);

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
  `celular` varchar(25) DEFAULT NULL,
  `sexo` varchar(100) DEFAULT NULL,
  `fechaAlta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IDusuario`, `nombre`, `email`, `contrasena`, `esAdmin`, `apellido`, `celular`, `sexo`, `fechaAlta`) VALUES
(18, 'Juan', 'vazquez800juan@gmail.com', '12345678', 's', 'Vazquez', '3571603501', NULL, '2023-12-06 19:09:17'),
(19, 'fede', 'fededella@gmail.com', '12345678', NULL, 'dellavalle', '448988', NULL, '2023-12-06 19:09:17'),
(20, 'Pedro', 'pvaldez@gmail.com', 'pedro123', NULL, 'Valdez', '3571603501', NULL, '2023-12-06 19:09:17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`IDadministrador`);

--
-- Indices de la tabla `categoriaevento`
--
ALTER TABLE `categoriaevento`
  ADD PRIMARY KEY (`IDcategoria`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`IDeventos`),
  ADD KEY `IDcategoria` (`IDcategoria`);

--
-- Indices de la tabla `eventosadministrador`
--
ALTER TABLE `eventosadministrador`
  ADD PRIMARY KEY (`IDadministrador`,`IDeventos`),
  ADD KEY `IDeventos` (`IDeventos`);

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
  ADD UNIQUE KEY `UC_nombre_completo` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriaevento`
--
ALTER TABLE `categoriaevento`
  MODIFY `IDcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `IDeventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `IDinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IDusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`IDcategoria`) REFERENCES `categoriaevento` (`IDcategoria`);

--
-- Filtros para la tabla `eventosadministrador`
--
ALTER TABLE `eventosadministrador`
  ADD CONSTRAINT `eventosadministrador_ibfk_1` FOREIGN KEY (`IDadministrador`) REFERENCES `administrador` (`IDadministrador`),
  ADD CONSTRAINT `eventosadministrador_ibfk_2` FOREIGN KEY (`IDeventos`) REFERENCES `eventos` (`IDeventos`),
  ADD CONSTRAINT `eventosadministrador_ibfk_3` FOREIGN KEY (`IDadministrador`) REFERENCES `administrador` (`IDadministrador`);

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
