-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2025 a las 21:25:10
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
-- Base de datos: `red_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `created_at`) VALUES
(10, 1, 22, 'Buen video', '2025-05-01 20:25:20'),
(15, 1, 22, 'yyy', '2025-05-01 21:17:21'),
(19, 7, 22, 'video', '2025-05-05 04:19:20'),
(25, 1, 24, 'yeyeyteytr', '2025-05-13 18:54:52'),
(27, 1, 27, 'hi', '2025-06-09 02:54:02'),
(28, 1, 26, 'hi', '2025-06-09 02:54:22'),
(31, 1, 39, 'Hombre generaod por IA', '2025-06-26 18:47:43'),
(32, 1, 39, 'Imagen fondo desenfocado', '2025-06-26 18:48:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `user_follower_id` int(11) NOT NULL,
  `user_followed_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `followers`
--

INSERT INTO `followers` (`id`, `user_follower_id`, `user_followed_id`, `created_at`) VALUES
(19, 7, 4, '2025-05-07 15:32:16'),
(31, 7, 1, '2025-05-22 00:16:29'),
(42, 7, 3, '2025-05-22 01:05:54'),
(43, 7, 9, '2025-05-22 01:06:29'),
(50, 2, 1, '2025-06-18 18:26:50'),
(63, 1, 8, '2025-06-26 19:02:32'),
(64, 1, 7, '2025-06-26 19:05:56'),
(65, 1, 12, '2025-06-26 19:06:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interests`
--

CREATE TABLE `interests` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `interests`
--

INSERT INTO `interests` (`id`, `name`) VALUES
(1, 'Viajes'),
(2, 'Comida'),
(3, 'Vestuario'),
(4, 'Educación'),
(5, 'Marketing Digital'),
(6, 'Emprendimiento'),
(7, 'Deportes'),
(8, 'Bienestar'),
(9, 'Belleza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(109, 1, 25, '2025-05-10 18:10:05'),
(120, 7, 27, '2025-05-10 19:12:57'),
(121, 7, 26, '2025-05-10 19:12:58'),
(122, 7, 25, '2025-05-10 19:12:59'),
(124, 1, 27, '2025-05-10 20:20:16'),
(130, 1, 22, '2025-05-13 18:43:24'),
(131, 1, 24, '2025-05-13 18:43:25'),
(141, 1, 32, '2025-06-09 03:39:13'),
(153, 7, 33, '2025-06-26 17:32:24'),
(154, 7, 35, '2025-06-26 17:33:13'),
(155, 7, 34, '2025-06-26 17:33:14'),
(156, 7, 36, '2025-06-26 17:33:15'),
(157, 1, 38, '2025-06-26 18:46:54'),
(158, 1, 37, '2025-06-26 18:46:54'),
(159, 8, 37, '2025-06-26 18:47:00'),
(160, 8, 38, '2025-06-26 18:47:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 2, 'Hola Carlos', 1, '2025-04-16 21:44:56'),
(2, 2, 3, 'Hola Mauricio', 1, '2025-04-16 21:45:46'),
(3, 7, 1, 'Hola ', 1, '2025-05-05 01:05:23'),
(4, 7, 1, 'hola', 1, '2025-05-05 01:05:46'),
(5, 1, 7, 'hola bro', 1, '2025-05-05 01:06:03'),
(6, 9, 1, 'holi', 1, '2025-05-05 01:06:03'),
(7, 1, 7, 'a', 1, '2025-05-05 03:04:30'),
(8, 1, 7, 'a', 1, '2025-05-05 03:04:44'),
(9, 1, 7, 'Holas', 1, '2025-05-05 03:04:56'),
(10, 1, 7, 'Hola juan', 1, '2025-05-05 03:13:50'),
(11, 1, 7, 'Como estas', 1, '2025-05-05 03:14:04'),
(12, 7, 1, 'hola camlo', 1, '2025-05-05 03:23:53'),
(13, 7, 1, 'Mauricio estas ahí?', 1, '2025-05-05 03:26:45'),
(14, 1, 7, 'camilo', 1, '2025-05-05 03:41:45'),
(15, 7, 1, 'me voy a dormir', 1, '2025-05-05 04:02:25'),
(16, 7, 1, 'holis', 1, '2025-05-05 04:16:28'),
(17, 1, 7, 'holaaaa', 1, '2025-05-05 15:40:02'),
(18, 7, 1, 'camilo', 1, '2025-05-05 15:40:10'),
(19, 2, 1, 'Hola Mauricio como estas', 0, '2025-06-18 18:26:59'),
(20, 1, 9, 'Hola', 0, '2025-06-24 18:08:54'),
(21, 1, 7, 'Que tal el día?', 0, '2025-06-26 16:30:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `type` enum('like','comment','follower','message') NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `type`, `reference_id`, `content`, `is_read`, `created_at`) VALUES
(1, 1, 1, 'like', 21, 'Le dio like a tu publicación.', 1, '2025-04-29 05:31:35'),
(2, 1, 7, 'like', 22, 'Le dio like a tu publicación.', 1, '2025-04-29 05:31:53'),
(3, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-04-29 05:32:31'),
(4, 7, 1, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-05-05 03:41:45'),
(5, 1, 7, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-05-05 04:02:25'),
(6, 1, 7, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-05-05 04:16:28'),
(7, 1, 7, 'comment', 22, 'Comentó tu publicación.', 1, '2025-05-05 04:16:43'),
(8, 1, 7, 'comment', 22, 'Comentó tu publicación.', 1, '2025-05-05 04:19:20'),
(9, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:54:37'),
(10, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:54:56'),
(11, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:56:52'),
(12, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:57:12'),
(13, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:57:32'),
(14, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 04:58:32'),
(15, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:11'),
(16, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:37'),
(17, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:39'),
(18, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:40'),
(19, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:41'),
(20, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:41'),
(21, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 05:02:42'),
(22, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-05 15:39:46'),
(23, 7, 1, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-05-05 15:40:02'),
(24, 1, 7, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-05-05 15:40:10'),
(25, 7, 1, 'comment', 14, 'Comentó tu publicación.', 1, '2025-05-05 15:44:27'),
(26, 7, 1, 'comment', 15, 'Comentó tu publicación.', 1, '2025-05-05 22:50:30'),
(27, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:36:40'),
(28, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:36:41'),
(29, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:37:26'),
(30, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:37:27'),
(31, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:37:30'),
(32, 7, 1, 'comment', 15, 'Comentó tu publicación.', 1, '2025-05-06 22:50:50'),
(33, 7, 1, 'comment', 15, 'Comentó tu publicación.', 1, '2025-05-06 22:51:41'),
(34, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:52:40'),
(35, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-06 22:52:41'),
(36, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-06 22:52:43'),
(37, 1, 1, 'like', 12, 'Le dio like a tu publicación.', 1, '2025-05-07 15:17:36'),
(38, 1, 1, 'like', 12, 'Le dio like a tu publicación.', 1, '2025-05-07 15:17:37'),
(39, 1, 1, 'like', 12, 'Le dio like a tu publicación.', 1, '2025-05-07 15:17:38'),
(40, 1, 1, 'like', 12, 'Le dio like a tu publicación.', 1, '2025-05-07 15:17:42'),
(41, 1, 7, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-07 15:32:16'),
(42, 1, 1, 'comment', 22, 'Comentó tu publicación.', 1, '2025-05-07 20:57:27'),
(43, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 17:58:49'),
(44, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 17:59:39'),
(45, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 17:59:55'),
(46, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 18:00:35'),
(47, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 18:01:03'),
(48, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 18:07:51'),
(49, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 18:07:58'),
(50, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:02'),
(51, 1, 1, 'like', 27, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:04'),
(52, 1, 1, 'like', 25, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:05'),
(53, 1, 1, 'like', 24, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:06'),
(54, 1, 1, 'like', 22, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:08'),
(55, 1, 1, 'like', 21, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:08'),
(56, 1, 1, 'like', 19, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:10'),
(57, 1, 1, 'like', 17, 'Le dio like a tu publicación.', 1, '2025-05-10 18:10:11'),
(58, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 18:14:20'),
(59, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 19:11:54'),
(60, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 19:11:55'),
(61, 7, 7, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 19:12:23'),
(62, 7, 7, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 19:12:24'),
(63, 1, 7, 'like', 27, 'Le dio like a tu publicación.', 1, '2025-05-10 19:12:57'),
(64, 1, 7, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-10 19:12:58'),
(65, 1, 7, 'like', 25, 'Le dio like a tu publicación.', 1, '2025-05-10 19:12:59'),
(66, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-10 20:20:14'),
(67, 1, 1, 'like', 27, 'Le dio like a tu publicación.', 1, '2025-05-10 20:20:16'),
(68, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 1, '2025-05-10 20:20:20'),
(69, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 1, '2025-05-10 20:20:21'),
(70, 1, 1, 'like', 17, 'Le dio like a tu publicación.', 1, '2025-05-10 20:20:30'),
(71, 1, 1, 'like', 22, 'Le dio like a tu publicación.', 1, '2025-05-10 20:47:48'),
(72, 1, 1, 'like', 21, 'Le dio like a tu publicación.', 1, '2025-05-10 20:47:50'),
(73, 4, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-13 17:21:34'),
(74, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-13 18:37:33'),
(75, 7, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-13 18:37:44'),
(76, 1, 1, 'like', 22, 'Le dio like a tu publicación.', 1, '2025-05-13 18:43:24'),
(77, 1, 1, 'like', 24, 'Le dio like a tu publicación.', 1, '2025-05-13 18:43:25'),
(78, 1, 1, 'like', 21, 'Le dio like a tu publicación.', 1, '2025-05-13 18:43:26'),
(79, 1, 1, 'comment', 24, 'Comentó tu publicación.', 1, '2025-05-13 18:54:52'),
(80, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-20 01:12:27'),
(81, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-20 01:12:30'),
(82, 12, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-20 01:12:36'),
(83, 12, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-20 01:12:37'),
(84, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-21 23:39:45'),
(85, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:14:30'),
(86, 8, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:14:32'),
(87, 8, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:14:33'),
(88, 1, 7, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:16:29'),
(89, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:37:08'),
(90, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:35'),
(91, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:36'),
(92, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:36'),
(93, 8, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:38:37'),
(94, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(95, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(96, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(97, 8, 1, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:53:14'),
(98, 3, 7, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:05:55'),
(99, 9, 7, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:06:29'),
(100, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:20'),
(101, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:21'),
(102, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:23'),
(103, 1, 1, 'like', 17, 'Le dio like a tu publicación.', 1, '2025-05-28 22:29:08'),
(104, 7, 1, 'comment', 14, 'Comentó tu publicación.', 0, '2025-05-28 22:51:11'),
(105, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-05-28 22:51:17'),
(106, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-30 03:36:06'),
(107, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-30 03:36:07'),
(108, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-05-30 03:39:49'),
(109, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 0, '2025-06-04 02:44:44'),
(110, 1, 1, 'comment', 27, 'Comentó tu publicación.', 1, '2025-06-09 02:54:02'),
(111, 1, 1, 'comment', 26, 'Comentó tu publicación.', 1, '2025-06-09 02:54:22'),
(112, 1, 1, 'like', 30, 'Le dio like a tu publicación.', 1, '2025-06-09 03:39:11'),
(113, 1, 1, 'like', 31, 'Le dio like a tu publicación.', 1, '2025-06-09 03:39:12'),
(114, 1, 1, 'like', 32, 'Le dio like a tu publicación.', 1, '2025-06-09 03:39:13'),
(115, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-11 17:23:16'),
(116, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-11 18:10:09'),
(117, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-11 18:10:55'),
(118, 1, 1, 'like', 31, 'Le dio like a tu publicación.', 1, '2025-06-17 04:28:44'),
(119, 1, 2, 'follower', NULL, 'Te ha seguido.', 1, '2025-06-18 18:26:50'),
(120, 1, 2, 'message', NULL, 'Te ha enviado un mensaje.', 1, '2025-06-18 18:26:59'),
(121, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 17:34:07'),
(122, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 17:34:09'),
(123, 9, 1, 'message', NULL, 'Te ha enviado un mensaje.', 0, '2025-06-24 18:08:54'),
(124, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-24 19:12:10'),
(125, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-24 19:12:12'),
(126, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:28'),
(127, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:29'),
(128, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:31'),
(129, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:33'),
(130, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:34'),
(131, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-24 19:42:37'),
(132, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-24 20:59:08'),
(133, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-24 21:00:01'),
(134, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-24 21:00:05'),
(135, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 0, '2025-06-24 21:00:11'),
(136, 7, 1, 'like', 14, 'Le dio like a tu publicación.', 0, '2025-06-25 16:09:45'),
(137, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-25 16:10:11'),
(138, 7, 1, 'like', 15, 'Le dio like a tu publicación.', 0, '2025-06-25 17:36:41'),
(139, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-25 19:07:01'),
(140, 7, 1, 'message', NULL, 'Te ha enviado un mensaje.', 0, '2025-06-26 16:30:13'),
(141, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-06-26 17:00:49'),
(142, 1, 1, 'like', 26, 'Le dio like a tu publicación.', 1, '2025-06-26 17:00:52'),
(143, 7, 7, 'like', 33, 'Le dio like a tu publicación.', 0, '2025-06-26 17:32:24'),
(144, 7, 7, 'like', 35, 'Le dio like a tu publicación.', 0, '2025-06-26 17:33:14'),
(145, 7, 7, 'like', 34, 'Le dio like a tu publicación.', 0, '2025-06-26 17:33:14'),
(146, 7, 7, 'like', 36, 'Le dio like a tu publicación.', 0, '2025-06-26 17:33:15'),
(147, 1, 1, 'comment', 31, 'Comentó tu publicación.', 1, '2025-06-26 18:35:47'),
(148, 1, 1, 'comment', 32, 'Comentó tu publicación.', 1, '2025-06-26 18:36:08'),
(149, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-26 18:45:23'),
(150, 8, 1, 'like', 38, 'Le dio like a tu publicación.', 0, '2025-06-26 18:46:54'),
(151, 8, 1, 'like', 37, 'Le dio like a tu publicación.', 0, '2025-06-26 18:46:55'),
(152, 8, 8, 'like', 37, 'Le dio like a tu publicación.', 0, '2025-06-26 18:47:00'),
(153, 8, 8, 'like', 38, 'Le dio like a tu publicación.', 0, '2025-06-26 18:47:01'),
(154, 7, 1, 'comment', 39, 'Comentó tu publicación.', 0, '2025-06-26 18:47:43'),
(155, 7, 1, 'comment', 39, 'Comentó tu publicación.', 0, '2025-06-26 18:48:09'),
(156, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-26 19:00:33'),
(157, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-26 19:02:33'),
(158, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-26 19:05:56'),
(159, 12, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-06-26 19:06:03'),
(160, 7, 1, 'like', 39, 'Le dio like a tu publicación.', 0, '2025-06-26 19:06:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tokeen` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `tokeen`, `expires_at`, `used`, `created_at`) VALUES
(1, 2, '$2y$10$83SUseqp2R4pfPZEq5Axp.Uivrz3H2Fz1IbFanETU0Pw2hteigCJu', '2025-06-18 19:25:33', 1, '2025-06-18 11:25:33'),
(2, 2, '$2y$10$Ze8OLIYfw2AootIm3Kwt6eJukj5YhahSFo9BoDRBeyxT7nPBxWfPu', '2025-06-18 19:36:14', 1, '2025-06-18 11:36:14'),
(3, 1, '$2y$10$3SKqKyt2XrMbUlzlWyTt6.cmttR4ZcIF3QGTcddwIMKn89Y8rpg/6', '2025-06-26 20:26:54', 0, '2025-06-26 12:26:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` blob NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `caption` text DEFAULT NULL,
  `is_blurred` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Indica si el post es borroso (0=blur)',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `image`, `file_name`, `type`, `caption`, `is_blurred`, `created_at`) VALUES
(22, 1, '', '1745849855_680f8dffe3748', 'mp4', 'Mi video de vacaciones en Velero por el mar caribe tomando el sol', 0, '2025-04-28 16:17:35'),
(24, 1, '', '1746623974_681b5de67edbe', 'jpg', 'mujer', 0, '2025-05-07 15:19:34'),
(25, 1, '', '1746624008_681b5e0830f24', 'jpg', 'hombre\r\n', 0, '2025-05-07 15:20:08'),
(26, 1, '', '1746624067_681b5e43383ec', 'jpg', 'mujer cuerpo completo', 0, '2025-05-07 15:21:07'),
(27, 1, '', '1746627266_681b6ac2cdd1e', 'mp4', 'Video Corto\n', 0, '2025-05-07 16:14:26'),
(32, 1, '', '1749432823_684639f766248', 'mp4', 'Mi video de casi 10 minutos ', 0, '2025-06-09 03:33:43'),
(33, 7, '', '1750951936_685d68006ce61', 'jpg', '', 0, '2025-06-26 17:32:16'),
(34, 7, '', '1750951951_685d680fe52bf', 'jpg', '', 0, '2025-06-26 17:32:31'),
(35, 7, '', '1750951968_685d68208bd61', 'jpg', '', 0, '2025-06-26 17:32:48'),
(36, 7, '', '1750951979_685d682b5878d', 'jpg', '', 0, '2025-06-26 17:32:59'),
(37, 8, '', '1750956276_685d78f471e58', 'jpg', 'Mujer', 0, '2025-06-26 18:44:36'),
(38, 8, '', '1750956283_685d78fb6b239', 'jpg', 'Imagen de IA', 0, '2025-06-26 18:44:43'),
(39, 7, '', '1750956299_685d790bcb6f5', 'png', '', 0, '2025-06-26 18:44:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo_type` varchar(255) NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `profile_photo_type`, `bio`, `birth_date`, `created_at`, `updated_at`) VALUES
(1, 'Mauricio Muñoz', 'mauoz', 'mauriciomuozsanchez12@gmail.com', '$2y$10$pnylrutmifOawwvYycp0weFzOVKl9WAVB9XqWlsp2IC92WN/pe1QG', 'jpg', 'Hola\r\nEste es mi perfil de CityScout donde puedo compartir diferentes imagenes y reproducir videos...', '2025-04-08', '2025-04-15 20:02:01', '2025-04-15 20:02:01'),
(2, 'Carlos Sanchez', 'carlitos2', 'mauro@gmail.com', '$2y$10$FpV3JHJS.nSaaqt127mUjutT2W7bUj5dFneMXfJTzTcup.1akNLwG', '', 'hi', '2015-04-07', '2025-04-15 23:58:48', '2025-04-15 23:58:48'),
(3, 'Mauricio 24', 'Mauro24', 'Mauricio@gmail.com', '', '', NULL, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Mauricio', 'Mao520', 'Mauricio1@gmail.com', '', '', NULL, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Juan Camilo', 'camilocai', 'camilo@mail.com', '$2y$10$sGDUSO35XetkR6UoBKPoW.TVI6U1q69rBuJdLCRWGGQ7xutlv8lwy', 'jpg', 'Hola soy Camilo', '2025-04-01', '2025-04-20 18:12:27', '2025-04-20 18:12:27'),
(8, 'Andres Lopez', 'Andreslop', 'andres@gmail.com', '$2y$10$DmE9P5oXwV.iLV6tYr6B..Zbsw0rf.7wwrUfR72INuVp7QbrsY3e6', '', NULL, '1999-05-12', '2025-04-27 22:40:06', '2025-04-27 22:40:06'),
(9, 'Pepito', 'pepito1', 'pepito@mail.com', '$2y$10$k8j.h6KH/Hm1eiXwZYSPk.5oks7OQlQiRo1Ka5DVxfhIoEaNr9CX6', '', NULL, '1221-12-12', '2025-04-27 23:57:56', '2025-04-27 23:57:56'),
(10, '1', 'sinname', 'mauricio.andres.munoz@correounivalle.edu.co', '$2y$10$eK3P7Ic698K1eMW3MP5bbeYDzyo6aSPMAOBmBQWteLSbZg8JAeAi.', '', NULL, '1111-11-11', '2025-04-28 00:18:12', '2025-04-28 00:18:12'),
(12, 'Camilo Astudillo', 'camilocaii', 'camilo@gmail.com', '$2y$10$EVJ/zwoHatCKHHBvYlu4IuQGKgnvE1W4zyQgy4L/ugmQlomR/MyB6', '', NULL, '1999-05-12', '2025-05-15 03:10:17', '2025-05-15 03:10:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_interests`
--

CREATE TABLE `user_interests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interest_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_interests`
--

INSERT INTO `user_interests` (`id`, `user_id`, `interest_id`) VALUES
(56, 9, 2),
(114, 9, 6),
(187, 3, 5),
(197, 8, 2),
(370, 7, 8),
(371, 7, 9),
(376, 7, 4),
(377, 7, 6),
(378, 7, 5),
(710, 8, 7),
(723, 9, 8),
(724, 9, 3),
(737, 9, 5),
(1431, 1, 8),
(1432, 1, 7),
(1433, 1, 9),
(1434, 1, 6),
(1435, 1, 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_fk` (`user_id`),
  ADD KEY `comments_post_id_fk` (`post_id`);

--
-- Indices de la tabla `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followers_user_follower_id` (`user_follower_id`),
  ADD KEY `followed_user_followed_id` (`user_followed_id`);

--
-- Indices de la tabla `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_user_id_fk` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id` (`sender_id`),
  ADD KEY `messages_receiver_id` (`receiver_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id` (`user_id`),
  ADD KEY `notifications_sender_id` (`sender_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_reset_user_id` (`user_id`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `interest_id` (`interest_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user_interests`
--
ALTER TABLE `user_interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1436;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`user_followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_interests_ibfk_2` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
