-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-10-2025 a las 05:51:17
-- Versión del servidor: 11.8.3-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u185421649_kanban`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `activity_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `activity_log`
--

INSERT INTO `activity_log` (`id`, `task_id`, `user_id`, `activity`, `activity_date`) VALUES
(1, 1, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-01 02:32:27'),
(2, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 02:33:04'),
(3, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 02:33:06'),
(4, 2, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-01 02:33:09'),
(5, 1, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-01 02:33:10'),
(6, 3, NULL, 'adjuntó el archivo: amortizacionrx24.pdf', '2025-10-01 02:40:05'),
(7, 3, NULL, 'eliminó el archivo: amortizacionrx24.pdf', '2025-10-01 02:49:54'),
(8, 3, NULL, 'adjuntó el archivo: 02 INE 1.pdf', '2025-10-01 02:50:03'),
(9, 3, 3, 'actualizó los detalles de la tarea.', '2025-10-01 02:50:10'),
(10, 3, 4, 'actualizó los detalles de la tarea.', '2025-10-01 05:25:09'),
(11, 1, 4, 'actualizó los detalles de la tarea.', '2025-10-01 05:25:15'),
(12, 3, NULL, 'actualizó las etiquetas.', '2025-10-01 06:08:58'),
(13, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-01 06:09:02'),
(14, 1, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-01 06:18:09'),
(15, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 06:18:12'),
(16, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 06:18:13'),
(17, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 06:18:15'),
(18, 1, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-01 06:18:19'),
(19, 1, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-01 06:18:21'),
(20, 2, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-01 06:18:23'),
(21, 1, NULL, 'movió la tarea de \'En Progreso\' a \'Por Hacer\'.', '2025-10-01 06:18:24'),
(22, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 06:18:58'),
(23, 4, NULL, 'movió la tarea de \'Hecho\' a \'Hecho\'.', '2025-10-01 06:19:22'),
(24, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:23:39'),
(25, 1, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:24:11'),
(26, 1, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:24:30'),
(27, 1, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:24:45'),
(28, 1, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:25:01'),
(29, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:26:13'),
(30, 5, NULL, 'creó la tarea.', '2025-10-02 17:26:52'),
(31, 5, NULL, 'actualizó las etiquetas.', '2025-10-02 17:27:01'),
(32, 5, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:27:03'),
(33, 3, NULL, 'añadió la subtarea: Brochas y demas implementos', '2025-10-02 17:27:23'),
(34, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:27:25'),
(35, 6, NULL, 'creó la tarea.', '2025-10-02 17:28:07'),
(36, 2, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:28:39'),
(37, 2, NULL, 'actualizó las etiquetas.', '2025-10-02 17:28:47'),
(38, 2, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:28:59'),
(39, 4, NULL, 'movió la tarea de \'Hecho\' a \'En Progreso\'.', '2025-10-02 17:29:05'),
(40, 4, NULL, 'actualizó las etiquetas.', '2025-10-02 17:30:25'),
(41, 4, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:30:26'),
(42, 4, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 17:31:05'),
(43, 2, NULL, 'movió la tarea de \'En Progreso\' a \'Por Hacer\'.', '2025-10-02 17:31:12'),
(44, 4, NULL, 'movió la tarea de \'En Progreso\' a \'Por Hacer\'.', '2025-10-02 17:31:16'),
(45, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 17:31:20'),
(46, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 18:02:36'),
(47, 7, NULL, 'creó la tarea.', '2025-10-02 18:03:41'),
(48, 8, NULL, 'creó la tarea.', '2025-10-02 18:04:06'),
(49, 3, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 18:04:22'),
(50, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:04:39'),
(51, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:04:41'),
(52, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:04:44'),
(53, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:04:55'),
(54, 3, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:05:10'),
(55, 1, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:08:39'),
(56, 4, NULL, 'movió la tarea de \'Por Hacer\' a \'Por Hacer\'.', '2025-10-02 18:08:44'),
(57, 4, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 18:08:56'),
(58, 4, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:08:59'),
(59, 3, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:09:05'),
(60, 7, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:09:13'),
(61, 5, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:09:16'),
(62, 5, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 18:09:19'),
(63, 2, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:09:29'),
(64, 8, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:09:37'),
(65, 1, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 18:09:41'),
(66, 9, NULL, 'creó la tarea.', '2025-10-02 18:11:07'),
(67, 9, NULL, 'movió la tarea de \'Por Hacer\' a \'En Progreso\'.', '2025-10-02 18:11:17'),
(68, 1, NULL, 'actualizó los detalles de la tarea.', '2025-10-02 18:11:29'),
(69, 5, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 20:52:11'),
(70, 1, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 20:52:12'),
(71, 2, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 20:52:14'),
(72, 2, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 20:52:19'),
(73, 4, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-02 20:52:22'),
(74, 4, NULL, 'movió la tarea de \'En Progreso\' a \'Pendientes\'.', '2025-10-02 20:52:25'),
(75, 7, NULL, 'movió la tarea de \'En Progreso\' a \'Pendientes\'.', '2025-10-02 20:52:28'),
(76, 6, NULL, 'movió la tarea de \'Por Hacer\' a \'Pendientes\'.', '2025-10-02 20:52:40'),
(77, 10, NULL, 'creó la tarea.', '2025-10-03 19:21:48'),
(78, 10, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-03 19:22:00'),
(79, 10, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-03 19:22:07'),
(80, 10, NULL, 'actualizó las etiquetas.', '2025-10-03 19:22:12'),
(81, 10, NULL, 'actualizó los detalles de la tarea.', '2025-10-03 19:22:14'),
(82, 11, NULL, 'creó la tarea.', '2025-10-03 19:23:18'),
(83, 9, NULL, 'movió la tarea de \'En Progreso\' a \'Pendientes\'.', '2025-10-03 19:23:25'),
(84, 10, NULL, 'movió la tarea de \'En Progreso\' a \'Hecho\'.', '2025-10-03 19:48:28'),
(85, 11, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-03 21:23:04'),
(86, 11, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-03 21:23:09'),
(87, 11, NULL, 'movió la tarea de \'En Progreso\' a \'En Progreso\'.', '2025-10-03 21:23:13'),
(88, 11, NULL, 'actualizó las etiquetas.', '2025-10-03 21:23:21'),
(89, 11, NULL, 'actualizó los detalles de la tarea.', '2025-10-03 21:23:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `attachments`
--

INSERT INTO `attachments` (`id`, `task_id`, `file_name`, `file_path`, `uploaded_at`) VALUES
(2, 3, '02 INE 1.pdf', 'uploads/2835051f407fdcec6d7c4a459370942e.pdf', '2025-10-01 02:50:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boards`
--

CREATE TABLE `boards` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner_user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boards`
--

INSERT INTO `boards` (`id`, `name`, `owner_user_id`, `created_at`) VALUES
(1, 'ERR Automotriz Gestión Diaria', 5, '2025-10-01 15:30:44'),
(2, 'Seguimiento tareas CB', 5, '2025-10-01 15:56:43'),
(3, 'ERR Automotriz', 6, '2025-10-02 17:53:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `board_users`
--

CREATE TABLE `board_users` (
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `columns`
--

CREATE TABLE `columns` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(7) DEFAULT '#E0E0E0',
  `position` int(11) NOT NULL,
  `wip_limit` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `columns`
--

INSERT INTO `columns` (`id`, `board_id`, `title`, `color`, `position`, `wip_limit`) VALUES
(1, 1, 'Por Hacer', '#FFCDD2', 0, 0),
(2, 1, 'En Progreso', '#C5CAE9', 1, 0),
(3, 1, 'Hecho', '#C8E6C9', 3, 0),
(4, 1, 'Pendientes', '#e41b1b', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subtasks`
--

CREATE TABLE `subtasks` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `subtasks`
--

INSERT INTO `subtasks` (`id`, `task_id`, `title`, `is_completed`) VALUES
(6, 3, 'Brochas y demas implementos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `name`, `color`) VALUES
(1, 'Urgente', '#ef4444'),
(2, 'Marketing', '#3b82f6'),
(3, 'Bug', '#f97316'),
(4, 'Revisión Cliente', '#8b5cf6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `column_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `priority` enum('Baja','Media','Alta') NOT NULL DEFAULT 'Media',
  `color` varchar(7) DEFAULT '#FFFFFF',
  `position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tasks`
--

INSERT INTO `tasks` (`id`, `column_id`, `user_id`, `title`, `description`, `due_date`, `priority`, `color`, `position`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'Contratar internet', '', '2025-10-11', 'Alta', '#ec0909', 2, '2025-10-01 02:22:19', '2025-10-03 21:23:13'),
(2, 2, 5, 'Revisar contactos de luz', 'Escribir un artículo sobre las mejores prácticas en desarrollo web.', '2025-10-04', 'Media', '#ffffff', 3, '2025-10-01 02:22:19', '2025-10-03 21:23:13'),
(3, 2, NULL, 'Comprar pintura negra, roja, blanca y azul', 'Negra una cubeta \nDe las otras un galon\n', '2025-10-04', 'Alta', '#e1bee7', 4, '2025-10-01 02:22:19', '2025-10-03 21:23:13'),
(4, 4, 5, 'Instalar cámaras', '', '2025-10-11', 'Baja', '#ffffff', 3, '2025-10-01 02:22:19', '2025-10-03 19:23:25'),
(5, 2, NULL, 'Comprar cámaras', '', NULL, 'Baja', '#ffffff', 1, '2025-10-02 17:26:52', '2025-10-03 21:23:13'),
(6, 4, NULL, 'Trasladar las rampas', '', NULL, 'Media', '#ffffff', 1, '2025-10-02 17:28:07', '2025-10-03 19:23:25'),
(7, 4, NULL, 'Recoger computadora  AIO descompuesta', '', NULL, 'Media', '#ffffff', 2, '2025-10-02 18:03:41', '2025-10-03 19:23:25'),
(8, 2, NULL, 'Comprar piezas de actualización de la computadora de abajo', '', NULL, 'Baja', '#ffffff', 5, '2025-10-02 18:04:06', '2025-10-03 21:23:13'),
(9, 4, NULL, 'Reparar moto', '', '2025-10-11', 'Alta', '#ffffff', 0, '2025-10-02 18:11:07', '2025-10-03 19:23:25'),
(10, 3, NULL, 'Pagar Renta MMC', '', NULL, 'Alta', '#ffffff', 0, '2025-10-03 19:21:48', '2025-10-03 19:48:28'),
(11, 2, NULL, 'Pagar Inicio Zoquipa', '', NULL, 'Alta', '#ffffff', 0, '2025-10-03 19:23:18', '2025-10-03 21:23:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `task_tags`
--

CREATE TABLE `task_tags` (
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `task_tags`
--

INSERT INTO `task_tags` (`task_id`, `tag_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(10, 1),
(11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `avatar_url`) VALUES
(1, 'Ana López', NULL, NULL),
(2, 'Juan Pérez', NULL, NULL),
(3, 'María García', NULL, NULL),
(4, 'Carlos B', NULL, NULL),
(5, 'cbarbap@gmail.com', '$2y$10$/oG51LamkMx4o5qtWrztm.gIKgINVjceUA897/DuR.akTlpJE5xkS', NULL),
(6, 'admin@errautomotriz.online', '$2y$10$09d2jFV36CHXCXBVHi0gde0/oxWbrlvvAyW3CUKtxmfJVSqNTKP3m', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indices de la tabla `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_user_id` (`owner_user_id`);

--
-- Indices de la tabla `board_users`
--
ALTER TABLE `board_users`
  ADD PRIMARY KEY (`board_id`,`user_id`);

--
-- Indices de la tabla `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `subtasks`
--
ALTER TABLE `subtasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `column_id` (`column_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `task_tags`
--
ALTER TABLE `task_tags`
  ADD PRIMARY KEY (`task_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `columns`
--
ALTER TABLE `columns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `subtasks`
--
ALTER TABLE `subtasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `subtasks`
--
ALTER TABLE `subtasks`
  ADD CONSTRAINT `subtasks_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `task_tags`
--
ALTER TABLE `task_tags`
  ADD CONSTRAINT `task_tags_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
