-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 16 2019 г., 19:39
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tw_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `restories`
--

CREATE TABLE `restories` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(64) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `restories`
--

INSERT INTO `restories` (`id`, `code`, `email`, `updated_at`, `created_at`) VALUES
(1, 'http://slim-skeleton/public/restore?code=fbd6d2f97fdbab0d56b1571849dbf7e3', 'torezracer@gmail.com', '2019-04-15 16:50:06', '2019-04-15 16:50:06'),
(2, 'http://slim-skeleton/public/restore?code=b4f050e2a8387b9fcc59ab3f106d729b', 'torezracer@gmail.com', '2019-04-15 16:53:18', '2019-04-15 16:53:18'),
(3, 'http://slim-skeleton/public/restore?code=7ba185bb2c0c498031bb65522e731b9e', 'torezracer@gmail.com', '2019-04-15 16:55:30', '2019-04-15 16:55:30'),
(4, '1c14c8bf57b50a4648419ffe2602c815', 'torezracer@gmail.com', '2019-04-15 16:58:43', '2019-04-15 16:58:43'),
(5, '9ef2b13bac7e06ff7cbb327ca7b93ed5', 'torezracer@gmail.com', '2019-04-15 17:00:53', '2019-04-15 17:00:53'),
(6, 'd8b708da99d638c75e9e559a9a028800', 'torezracer@gmail.com', '2019-04-15 17:03:48', '2019-04-15 17:03:48'),
(7, 'c45e5093485df16657ac7ab7f05fc3d3', 'torezracer@gmail.com', '2019-04-16 19:36:43', '2019-04-16 19:36:43'),
(8, 'de8110dc00b1c465895241b7241cd616', 'torezracer@gmail.com', '2019-04-16 19:37:12', '2019-04-16 19:37:12');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `user` varchar(255) NOT NULL,
  `ip_addr` varchar(11) DEFAULT NULL,
  `isLogin` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `session_id`, `user`, `ip_addr`, `isLogin`, `updated_at`, `created_at`) VALUES
(3, '628754b2048e24def54f6ed1a86d6fe2', 'root', '127.0.0.1', 0, '2019-04-14 19:26:56', '2019-04-14 18:45:18'),
(5, '3129f3e6ed57ee90d9eaef3f284bbcc0', 'root', '127.0.0.1', 0, '2019-04-14 19:26:56', '2019-04-14 19:26:56'),
(6, '4a41d57205468e0748a8befa5fd7cc28', 'Yapichoy', '127.0.0.1', 0, '2019-04-14 19:28:25', '2019-04-14 19:27:59'),
(7, '63de170067b705d4ae175d1181b49971', 'Yapichoy', '127.0.0.1', 0, '2019-04-14 19:29:46', '2019-04-14 19:28:25'),
(8, '752c8b56c56c217b023e25b5139bdb83', 'Yapichoy', '127.0.0.1', 0, '2019-04-14 19:29:53', '2019-04-14 19:29:46'),
(9, 'f899bd6e9fe936a092c2598fc3f84741', 'Yapichoy', '127.0.0.1', 0, '2019-04-14 19:29:53', '2019-04-14 19:29:53'),
(10, '9c89f2482f33a748ef9e689c8c1cd8ab', 'Yapichoy', '127.0.0.1', 0, '2019-04-15 13:56:44', '2019-04-15 13:56:40'),
(11, '7416c56d501027caccf04f951c34aadf', 'Yapichoy', '127.0.0.1', 0, '2019-04-15 13:57:59', '2019-04-15 13:56:44'),
(12, 'a02327439704d5eaaa46886227c54235', 'Yapichoy', '127.0.0.1', 0, '2019-04-15 14:00:46', '2019-04-15 13:59:58'),
(13, '60d34226b0c04f27aaa838b3736802a5', 'root', '127.0.0.1', 0, '2019-04-15 14:20:11', '2019-04-15 14:01:10'),
(14, '4939cd20f2285b30b8813bb6bdc44612', 'root', '127.0.0.1', 0, '2019-04-15 17:01:44', '2019-04-15 17:01:41'),
(15, 'c15ae286abcf5f37df589dffd8a80a58', 'root', '127.0.0.1', 1, '2019-04-15 17:04:06', '2019-04-15 17:04:06'),
(16, '79e2821d7bdb5da5a8c3d7312879f9dc', 'Yapichoy', '127.0.0.1', 1, '2019-04-16 14:42:21', '2019-04-16 14:42:21'),
(17, 'd9b76c00dda61fe9a7e91b64b82ff5d3', 'root', '127.0.0.1', 0, '2019-04-16 18:27:19', '2019-04-16 18:26:17'),
(18, 'c3f53aa351fc4ff7e3a80d4483ef7704', 'root', '127.0.0.1', 0, '2019-04-16 18:27:23', '2019-04-16 18:27:20'),
(19, '45b5f094a0052f58cbd946f9716258d1', 'root', '127.0.0.1', 0, '2019-04-16 18:27:59', '2019-04-16 18:27:24'),
(20, 'fea520d1ee7105909d0a045008448884', 'root', '127.0.0.1', 0, '2019-04-16 18:28:56', '2019-04-16 18:27:59'),
(21, 'd033cc30fd3fccba2541e16548d8d9c3', 'root', '127.0.0.1', 1, '2019-04-16 18:28:56', '2019-04-16 18:28:56'),
(22, '36bfd5e08e88a94692a78ecf457a355b', 'root', '127.0.0.1', 0, '2019-04-16 18:30:20', '2019-04-16 18:30:18'),
(23, 'd35cf1643b107655e05e4e78e8be4fa5', 'root', '127.0.0.1', 0, '2019-04-16 18:32:36', '2019-04-16 18:30:20'),
(24, '9a723797aa1f2b47d79793d5edae4a18', 'root', '127.0.0.1', 0, '2019-04-16 18:35:13', '2019-04-16 18:32:36'),
(25, '4d7ad2cc8578afe3e99c8b7f8bf94e8e', 'root', '127.0.0.1', 0, '2019-04-16 15:37:51', '2019-04-16 18:35:13'),
(26, 'c9dff0d8ea7672cc5c1bb059d3607397', 'root', '127.0.0.1', 0, '2019-04-16 18:37:24', '2019-04-16 18:37:11'),
(27, '149d364afbbaf95826b6ca266d7dfa23', 'root', '127.0.0.1', 1, '2019-04-16 18:37:24', '2019-04-16 18:37:24'),
(28, '6fe9389fafdd145e24e5827df23d3824', 'root', '127.0.0.1', 0, '2019-04-16 15:39:18', '2019-04-16 15:37:51'),
(29, '5062aade6bea25b2bc853971ec4db726', 'root', '127.0.0.1', 0, '2019-04-16 18:51:56', '2019-04-16 18:51:23'),
(30, '00ee5cdbe7da02a5f13eac49f27dc5fc', 'root', '127.0.0.1', 0, '2019-04-16 18:53:15', '2019-04-16 18:51:57'),
(31, 'f0ad07f203f3f999c11bb62d35828ec1', 'root', '127.0.0.1', 0, '2019-04-16 18:53:46', '2019-04-16 18:53:15'),
(32, '9ecbe4c22d0bc0626e6ac3353f9a52fe', 'root', '127.0.0.1', 0, '2019-04-16 18:55:09', '2019-04-16 18:53:46'),
(33, 'ac5422a26868b7534f35f462552b407e', 'root', '127.0.0.1', 0, '2019-04-16 18:55:39', '2019-04-16 18:55:09'),
(34, 'c9355d32fabb69cf86ee417522f1b110', 'root', '127.0.0.1', 0, '2019-04-16 19:14:06', '2019-04-16 18:55:39'),
(35, '645db43c1f9219d8efda02f186b44d96', 'root', '127.0.0.1', 0, '2019-04-16 19:17:48', '2019-04-16 19:14:06'),
(36, 'e55b4cd32724803ef7be8dc54b8fbd69', 'root', '127.0.0.1', 0, '2019-04-16 19:18:04', '2019-04-16 19:17:48'),
(37, '3c35ed9015e7b29fa7c8de2baa4b0348', 'root', '127.0.0.1', 0, '2019-04-16 19:26:28', '2019-04-16 19:18:04'),
(38, 'c2b15c17fc5e92c457b6685601e42091', 'root', '127.0.0.1', 0, '2019-04-16 19:26:51', '2019-04-16 19:26:29'),
(39, '7dcdafdce9835e538363c46cd555dfe0', 'root', '127.0.0.1', 0, '2019-04-16 19:31:04', '2019-04-16 19:26:51'),
(40, '469c170836e9daf9239f95a04bcfbe18', 'Yapichoy', '127.0.0.1', 0, '2019-04-16 19:32:06', '2019-04-16 19:31:59');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `updated_at`, `created_at`) VALUES
(4, 'Yapichoy', 'yapichoy@gmail.com', 'b61329e08ec7f10d04f8a04e532ea21f', '2019-04-14 17:06:24', '2019-04-14 17:06:24'),
(5, 'root', 'torezracer@gmail.com', 'c7e8abfa67d3dd8d48632be2a5053b2d', '2019-04-15 17:01:17', '2019-04-14 18:24:39');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `restories`
--
ALTER TABLE `restories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `restories`
--
ALTER TABLE `restories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
