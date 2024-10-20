-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-10-2024 a las 01:10:11
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
-- Base de datos: `portal_evento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(6) UNSIGNED NOT NULL,
  `evento_id` int(6) UNSIGNED NOT NULL,
  `usuario_id` int(6) UNSIGNED NOT NULL,
  `comentario` text NOT NULL,
  `valoracion` int(1) NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT current_timestamp(),
  `calificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `evento_id`, `usuario_id`, `comentario`, `valoracion`, `fecha_comentario`, `calificacion`) VALUES
(41, 22, 8, '', 4, '2024-10-19 22:50:04', NULL),
(42, 19, 8, '', 5, '2024-10-19 22:50:19', NULL),
(43, 18, 8, '', 4, '2024-10-19 22:50:54', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `respondido` tinyint(1) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `nombre`, `email`, `mensaje`, `respondido`, `fecha`) VALUES
(12, 'zx', 'zxzx@eded.com', 'xzx', 0, '2024-10-19 02:16:27'),
(13, 'dcd', 'dffsxx@gnail.com', 'xokemxec', 0, '2024-10-19 02:18:03'),
(15, 'x  ', 'adcdd@gmail.com', 'x x ', 0, '2024-10-19 02:20:55'),
(16, 'ss', 'Johanerer@gmail.com', 'sdsdsd', 0, '2024-10-19 02:25:50'),
(17, ' d ', 'ssdsd@gdtfg.com', 'd  dd', 1, '2024-10-19 02:26:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(6) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `valoracion_promedio` float DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descripcion`, `fecha`, `ubicacion`, `categoria`, `valoracion_promedio`, `fecha_creacion`, `hora`) VALUES
(18, 'Conferencia sobre Ciberseguridad en Empresas', 'Expertos en seguridad informática abordarán los últimos avances y desafíos en la protección de datos en las organizaciones.', '2024-10-28', 'Hotel Gran Almirante, Santiago', 'Tecnología', 0, '2024-10-19 22:41:20', '14:00:00'),
(19, 'Taller de Fotografía Creativa', 'Aprende técnicas innovadoras para mejorar tus habilidades fotográficas y captar imágenes impactantes.', '2024-11-03', 'Centro Cultural Dominicano-Americano, Santiago', 'Arte y Cultura', 0, '2024-10-19 22:42:24', '15:00:00'),
(20, 'Seminario de Finanzas  Personales', 'Aprende a gestionar tus finanzas personales, crear un presupuesto y planificar tu futuro financiero con expertos en el área.', '2024-11-10', 'Universidad PUCMM, Santiago', 'Finanzas', 0, '2024-10-19 22:43:34', '09:30:00'),
(21, 'Conferencia sobre Ciberseguridad', 'Expertos en seguridad informática abordarán los últimos avances y desafíos en la protección de datos en las organizaciones.', '2024-11-11', 'Hotel Gran Almirante, Santiago', 'Tecnología', 0, '2024-10-19 22:45:22', '15:00:00'),
(22, 'Seminario de Finanzas ', 'Aprende a gestionar tus finanzas personales, crear un presupuesto y planificar tu futuro financiero con expertos en el área.', '2024-11-25', 'Universidad PUCMM, Santiago Categoría: Finanzas', 'Finanzas', 0, '2024-10-19 22:46:24', '09:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` int(6) UNSIGNED NOT NULL,
  `evento_id` int(6) UNSIGNED NOT NULL,
  `usuario_id` int(6) UNSIGNED NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `evento_id`, `usuario_id`, `fecha_inscripcion`) VALUES
(113, 21, 8, '2024-10-19 22:50:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(6) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `rol` enum('usuario','admin') DEFAULT 'usuario',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `contrasena`, `rol`, `reg_date`) VALUES
(5, 'Adminttrt', 'admin@gmail.com', '$2y$10$G6uRDlGEj2P42xNi7FWRDOL7zN1R5qeXCBtqRfcAafPTGyH6TcExW', 'admin', '2024-10-19 20:57:08'),
(8, 'Johan Rojas1q', 'Johan@gmail.com', '$2y$10$U9FZaf0cxalf5bwZriIdPuGpMNgmBLYjEIkcLGPsvEoXK9x9Jbgte', 'usuario', '2024-10-19 23:01:08'),
(12, 'EEE', 'admiEEEn@gmail.com', '$2y$10$gPzX1OCxUpKbuMEUpD1FQe/4sgQ1IG5Pe.RcBhYACofgxMAYa4Cm6', 'usuario', '2024-10-19 19:23:56'),
(13, 'ssfs', 'admsfsfin@gmail.com', '$2y$10$mo/DKuMpHlXT7Z6NQtqwsOdylarQhMpa8Nj/5YDc7wx2UIwOklzU6', 'usuario', '2024-10-19 20:02:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evento_id` (`evento_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `evento_id` (`evento_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
