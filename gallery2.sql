-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 12 2021 г., 21:44
-- Версия сервера: 5.6.43
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gallery2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `id_basket` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_good` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `is_in_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id_good` int(11) NOT NULL,
  `good_name` varchar(128) NOT NULL,
  `good_description` text NOT NULL,
  `good_price` int(11) NOT NULL,
  `id_good_img_path` int(11) NOT NULL,
  `in_catalog` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id_good`, `good_name`, `good_description`, `good_price`, `id_good_img_path`, `in_catalog`) VALUES
(1, 'Товар #1 ', 'Краткое описание товара #1 ', 10, 1, 1),
(2, 'Товар #2 ', 'Краткое описание товара #2', 200, 1, 1),
(3, 'Товар #3', 'Краткое описание товара #3', 31, 1, 1),
(5, 'Товар #5 ', 'Краткое описание товара #5', 15, 1, 1),
(6, 'Товар #6 ', 'Краткое описание товара #6', 16, 1, 1),
(7, 'Товар #7 ', 'Краткое описание товара #7', 7000, 1, 1),
(8, 'Товар #8 ', 'Краткое описание товара #8', 80, 1, 1),
(10, 'Товар #10 ', 'Краткое описание товара #10', 100, 1, 1),
(11, 'Товар #11', 'Краткое описание товара #11', 110, 1, 1),
(12, 'Товар #12', 'Краткое описание товара #12', 29, 1, 1),
(13, 'Товар #13 ', 'Краткое описание товара #13', 1300, 1, 1),
(14, 'Товар #14', 'Краткое описание товара #14', 1400, 1, 1),
(15, 'Товар #15', 'Краткое описание товара #15', 1500, 1, 1),
(16, 'Товар #16', 'Краткое описание товара #16', 1600, 1, 1),
(17, 'Товар #17', 'Краткое описание товара #17', 1700, 1, 1),
(18, 'Товар #18 ', 'Краткое описание товара #18', 185, 1, 1),
(20, 'Товар #20', 'Краткое описание товара #20', 2000, 1, 1),
(21, 'Товар #21 ', 'Краткое описание товара #21', 210, 1, 1),
(22, 'Товар #22', 'Краткое описание товара #22', 2200, 1, 1),
(23, 'Товар #23', 'Краткое описание товара #23', 2300, 1, 1),
(24, 'Товар #24', 'Краткое описание товара #24', 2400, 1, 1),
(25, 'Товар #25', 'Краткое описание товара #25', 2500, 1, 1),
(26, 'Товар #26', 'Краткое описание товара #26', 2600, 1, 1),
(27, 'Товар #27', 'Краткое описание товара #27', 2700, 1, 1),
(28, 'Товар #28', 'Краткое описание товара #28', 2800, 1, 1),
(29, 'Товар #29', 'Краткое описание товара #29', 2900, 1, 1),
(30, 'Товар #30', 'Краткое описание товара #30', 3000, 1, 1),
(31, 'Товар #31', 'Краткое описание товара #31', 3100, 1, 1),
(32, 'Товар #32', 'Краткое описание товара #32', 3200, 1, 1),
(33, 'Товар #33', 'Краткое описание товара #33', 3300, 1, 1),
(34, 'Товар #34', 'Краткое описание товара #34', 3400, 1, 1),
(35, 'Товар #35', 'Краткое описание товара #35', 3500, 1, 1),
(36, 'Товар #36', 'Краткое описание товара #36', 3600, 1, 1),
(37, 'Товар #37', 'Краткое описание товара #37', 3700, 1, 1),
(38, 'Товар #38', 'Краткое описание товара #38', 3800, 1, 1),
(39, 'Товар #39', 'Краткое описание товара #39', 3900, 1, 1),
(40, 'Товар #40', 'Краткое описание товара #40', 4000, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `good_img_path`
--

CREATE TABLE `good_img_path` (
  `id` int(11) NOT NULL,
  `path` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `good_img_path`
--

INSERT INTO `good_img_path` (`id`, `path`) VALUES
(1, 'https://via.placeholder.com/350x200');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `amount_order` int(11) NOT NULL,
  `data_create_order` varchar(48) NOT NULL,
  `id_order_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `amount_order`, `data_create_order`, `id_order_status`) VALUES
(3, 1, 2632, '11.10.2021 22:31:49', 4),
(4, 1, 15, '12.10.2021 18:46:10', 1),
(5, 1, 186, '12.10.2021 21:12:34', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_status`
--

CREATE TABLE `order_status` (
  `id_order_status` int(11) NOT NULL,
  `order_status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order_status`
--

INSERT INTO `order_status` (`id_order_status`, `order_status`) VALUES
(1, 'Новый'),
(2, 'Принят'),
(3, 'Выполнен'),
(4, 'Отменён');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `user_login` varchar(45) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_phone` varchar(45) NOT NULL,
  `user_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `user_login`, `user_password`, `user_phone`, `user_role`) VALUES
(1, 'Админ', 'admin', '$2y$10$UViWYAbO8yDVHtwxItsr4OvNz9ws0QUTjUOWX6DwDG.kjEFHLmSpy', '000-000-000', 1),
(16, 'Пользователь', 'user', '$2y$10$sw0wacl0FJGLfSE9CvD4vuOsqFS/00ImWEsoGgpGjwHgdyX.7xFe2', '999-999-999', 0),
(17, 'Guest', '', '', '', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`id_basket`),
  ADD KEY `fk_idGood_idx` (`id_good`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id_good`),
  ADD KEY `id_good_img_path_idx` (`id_good_img_path`);

--
-- Индексы таблицы `good_img_path`
--
ALTER TABLE `good_img_path`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`);

--
-- Индексы таблицы `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id_order_status`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `id_basket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id_good` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT для таблицы `good_img_path`
--
ALTER TABLE `good_img_path`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `id_good_img_path` FOREIGN KEY (`id_good_img_path`) REFERENCES `good_img_path` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
