-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2025 a las 01:57:10
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
(3, 1, 14, 'hola', '2025-05-01 20:11:32'),
(4, 1, 21, 'hola', '2025-05-01 20:11:51'),
(5, 1, 21, 'hola', '2025-05-01 20:11:51'),
(6, 1, 15, 'hola', '2025-05-01 20:12:03'),
(8, 1, 21, 'holios', '2025-05-01 20:18:29'),
(9, 1, 21, 'holios', '2025-05-01 20:18:29'),
(10, 1, 22, 'holis', '2025-05-01 20:25:20'),
(12, 1, 16, 'hol', '2025-05-01 20:29:11'),
(13, 1, 17, 'holiss', '2025-05-01 20:32:23'),
(14, 1, 22, 'holas', '2025-05-01 21:15:58'),
(15, 1, 22, 'yyy', '2025-05-01 21:17:21'),
(16, 1, 22, 'aa', '2025-05-01 21:24:10'),
(17, 7, 14, 'como vas con ese folleto con ta buena información valiosaa', '2025-05-01 22:10:44'),
(19, 7, 22, 'video', '2025-05-05 04:19:20'),
(21, 1, 15, 'asdasd', '2025-05-05 22:50:30'),
(22, 1, 15, 'Los objetivos son muy importantes', '2025-05-06 22:50:50'),
(23, 1, 15, 'si', '2025-05-06 22:51:41'),
(25, 1, 24, 'yeyeyteytr', '2025-05-13 18:54:52');

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
(26, 1, 12, '2025-05-20 01:12:37'),
(31, 7, 1, '2025-05-22 00:16:29'),
(38, 1, 7, '2025-05-22 00:53:13'),
(42, 7, 3, '2025-05-22 01:05:54'),
(43, 7, 9, '2025-05-22 01:06:29');

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
(7, 'Desportes'),
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
(118, 7, 15, '2025-05-10 19:12:23'),
(119, 7, 14, '2025-05-10 19:12:24'),
(120, 7, 27, '2025-05-10 19:12:57'),
(121, 7, 26, '2025-05-10 19:12:58'),
(122, 7, 25, '2025-05-10 19:12:59'),
(123, 1, 26, '2025-05-10 20:20:14'),
(124, 1, 27, '2025-05-10 20:20:16'),
(126, 1, 14, '2025-05-10 20:20:21'),
(130, 1, 22, '2025-05-13 18:43:24'),
(131, 1, 24, '2025-05-13 18:43:25'),
(132, 1, 21, '2025-05-13 18:43:26');

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
(18, 7, 1, 'camilo', 1, '2025-05-05 15:40:10');

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
(86, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:14:32'),
(87, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:14:33'),
(88, 1, 7, 'follower', NULL, 'Te ha seguido.', 1, '2025-05-22 00:16:29'),
(89, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:37:08'),
(90, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:35'),
(91, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:36'),
(92, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:36'),
(93, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:38:37'),
(94, 7, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(95, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(96, 3, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:13'),
(97, 8, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 00:53:14'),
(98, 3, 7, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:05:55'),
(99, 9, 7, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:06:29'),
(100, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:20'),
(101, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:21'),
(102, 9, 1, 'follower', NULL, 'Te ha seguido.', 0, '2025-05-22 01:15:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tokeen` varchar(100) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(12, 1, '', '1745631632_680c3990bbcad', 'jpg', 'drsggsd', 0, '2025-04-26 03:40:32'),
(13, 1, '', '1745631691_680c39cb52ff8', 'jpg', 'aaa', 0, '2025-04-26 03:41:31'),
(14, 7, '', '1745636274_680c4bb27529c', 'jpg', 'Folleto 2', 0, '2025-04-26 04:57:54'),
(15, 7, '', '1745636290_680c4bc2d375c', 'jpg', 'Verbos de objetivossd', 0, '2025-04-26 04:58:10'),
(16, 1, '', '1745791647_680eaa9faa510', 'jpg', 'abc', 0, '2025-04-28 00:07:27'),
(17, 1, '', '1745791686_680eaac6711bf', 'jpg', '123', 0, '2025-04-28 00:08:06'),
(19, 1, '', '1745791744_680eab0049285', 'png', '123', 0, '2025-04-28 00:09:04'),
(21, 1, '', '1745795724_680eba8c0147f', 'jpg', 'Falda', 0, '2025-04-28 01:15:24'),
(22, 1, '', '1745849855_680f8dffe3748', 'mp4', 'Mi video de vacaciones en Velero por el mar caribe tomando el sol', 0, '2025-04-28 16:17:35'),
(24, 1, '', '1746623974_681b5de67edbe', 'jpg', 'mujer', 0, '2025-05-07 15:19:34'),
(25, 1, '', '1746624008_681b5e0830f24', 'jpg', 'hombre\r\n', 0, '2025-05-07 15:20:08'),
(26, 1, '', '1746624067_681b5e43383ec', 'jpg', 'mujer cuerpo completo', 0, '2025-05-07 15:21:07'),
(27, 1, '', '1746627266_681b6ac2cdd1e', 'mp4', 'Video Reel\r\n', 0, '2025-05-07 16:14:26');

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
(1, 'Mauricio Andres Muñoz Sanchezz', 'mauoz', 'mauricio@gmail.com', '$2y$10$pnylrutmifOawwvYycp0weFzOVKl9WAVB9XqWlsp2IC92WN/pe1QG', 'jpeg', 'Hola\r\nEste es mi perfil de Focuz que utilizo para subir y reproducir videos', '2025-04-08', '2025-04-15 20:02:01', '2025-04-15 20:02:01'),
(2, 'Carlos Sanchez', 'carlitos2', 'carlitos@gmail.com', '66847374', '', 'hi', '2015-04-07', '2025-04-15 23:58:48', '2025-04-15 23:58:48'),
(3, 'Mauricio 24', '', 'Mauricio@gmail.com', '', '', NULL, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Mauricio', '', 'Mauricio@gmail.com', '', '', NULL, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Juan Camilo', 'camilocai', 'camilo@mail.com', '$2y$10$sGDUSO35XetkR6UoBKPoW.TVI6U1q69rBuJdLCRWGGQ7xutlv8lwy', 'jpg', 'Hola soy Camilo', '2025-04-01', '2025-04-20 18:12:27', '2025-04-20 18:12:27'),
(8, 'Andres Lopez', 'Andreslop', 'andres@gmail.com', '$2y$10$DmE9P5oXwV.iLV6tYr6B..Zbsw0rf.7wwrUfR72INuVp7QbrsY3e6', '', NULL, '1999-05-12', '2025-04-27 22:40:06', '2025-04-27 22:40:06'),
(9, 'Pepito', 'pepito1', 'pepito@mail.com', '$2y$10$k8j.h6KH/Hm1eiXwZYSPk.5oks7OQlQiRo1Ka5DVxfhIoEaNr9CX6', '', NULL, '1221-12-12', '2025-04-27 23:57:56', '2025-04-27 23:57:56'),
(10, '1', '1', 'mauricio.andres.munoz@correounivalle.edu.co', '$2y$10$eK3P7Ic698K1eMW3MP5bbeYDzyo6aSPMAOBmBQWteLSbZg8JAeAi.', '', NULL, '1111-11-11', '2025-04-28 00:18:12', '2025-04-28 00:18:12'),
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
(820, 1, 1),
(821, 1, 2),
(822, 1, 3),
(823, 1, 4),
(824, 1, 7),
(825, 1, 9),
(826, 1, 5);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `interests`
--
ALTER TABLE `interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `user_interests`
--
ALTER TABLE `user_interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=827;

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
