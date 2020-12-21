-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Мар 20 2019 г., 20:22
-- Версия сервера: 10.1.19-MariaDB
-- Версия PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bg2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `t_accounts`
--

CREATE TABLE `t_accounts` (
  `ID` int(10) NOT NULL,
  `LOGIN` varchar(50) COLLATE utf8_bin NOT NULL,
  `PASSWORD` varchar(50) COLLATE utf8_bin NOT NULL,
  `EXP` int(10) NOT NULL,
  `LEV` int(10) NOT NULL,
  `TIP` int(10) NOT NULL,
  `BAT` int(10) NOT NULL,
  `BATA` int(10) NOT NULL,
  `BATTIME` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_accounts`
--

INSERT INTO `t_accounts` (`ID`, `LOGIN`, `PASSWORD`, `EXP`, `LEV`, `TIP`, `BAT`, `BATA`, `BATTIME`) VALUES
(1, 'Player1', '1', 8, 1, 1, 10, 1, 30),
(2, 'Player2', '2', 0, 1, 2, 0, 0, 0),
(3, 'Player3', '3', 0, 1, 3, 0, 0, 0),
(4, 'Player4', '4', 0, 1, 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_account_stat`
--

CREATE TABLE `t_account_stat` (
  `ID` int(10) NOT NULL,
  `S_NAT` int(10) NOT NULL,
  `A_NAT` int(10) NOT NULL,
  `I_NAT` int(10) NOT NULL,
  `S_ALL` int(11) NOT NULL,
  `A_ALL` int(11) NOT NULL,
  `I_ALL` int(11) NOT NULL,
  `FREE` int(10) NOT NULL,
  `FREE_MAX` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_account_stat`
--

INSERT INTO `t_account_stat` (`ID`, `S_NAT`, `A_NAT`, `I_NAT`, `S_ALL`, `A_ALL`, `I_ALL`, `FREE`, `FREE_MAX`) VALUES
(1, 2, 4, 3, 2, 4, 3, 0, 1),
(2, 4, 4, 4, 4, 4, 4, 1, 1),
(3, 4, 4, 4, 4, 4, 4, 1, 1),
(4, 3, 3, 3, 3, 3, 3, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `t_arena`
--

CREATE TABLE `t_arena` (
  `ID` int(10) NOT NULL,
  `PL1` int(10) NOT NULL,
  `PL2` int(10) NOT NULL,
  `STAT` int(10) NOT NULL,
  `BATTLE_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_arena`
--

INSERT INTO `t_arena` (`ID`, `PL1`, `PL2`, `STAT`, `BATTLE_ID`) VALUES
(1, 2, 1, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_art_info`
--

CREATE TABLE `t_art_info` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_bin NOT NULL,
  `BONUS_S` int(10) NOT NULL,
  `BONUS_A` int(10) NOT NULL,
  `BONUS_I` int(10) NOT NULL,
  `PLACE` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_art_info`
--

INSERT INTO `t_art_info` (`ID`, `NAME`, `BONUS_S`, `BONUS_A`, `BONUS_I`, `PLACE`) VALUES
(1, 'Мифриловые сапоги', 0, 1, 2, 3),
(2, 'Железные сапоги', 2, 0, 0, 3),
(3, 'Сапоги стремительности', 0, 2, 1, 3),
(4, 'Кольчуга дракона', 2, 2, 0, 2),
(5, 'Кожаные доспехи', 2, 1, 0, 2),
(6, 'Кровавая кольчуга', 0, 3, 1, 2),
(7, 'Стальные доспехи', 3, 0, 0, 2),
(8, 'Шлем хаоса', 0, 2, 1, 1),
(9, 'Корона мага', 0, 0, 3, 1),
(10, 'Стальной шлем', 3, 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `t_bat_cards`
--

CREATE TABLE `t_bat_cards` (
  `ID` int(10) NOT NULL,
  `BATTLE_ID` int(10) NOT NULL,
  `ACTOR` int(10) NOT NULL,
  `NUM` int(10) NOT NULL,
  `PLACE` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_bat_cards`
--

INSERT INTO `t_bat_cards` (`ID`, `BATTLE_ID`, `ACTOR`, `NUM`, `PLACE`) VALUES
(1, 1, 1, 9, 0),
(2, 1, 1, 4, 1),
(3, 1, 1, 4, 2),
(4, 2, 1, 3, 0),
(5, 2, 1, 6, 1),
(6, 2, 1, 8, 2),
(7, 3, 1, 9, 0),
(8, 3, 1, 5, 1),
(9, 3, 1, 9, 2),
(10, 4, 1, 3, 0),
(11, 4, 1, 4, 1),
(12, 4, 1, 10, 2),
(13, 5, 1, 4, 0),
(14, 5, 1, 3, 1),
(15, 5, 1, 4, 2),
(16, 6, 1, 10, 0),
(17, 6, 1, 3, 1),
(18, 6, 1, 3, 2),
(19, 7, 1, 2, 0),
(20, 7, 1, 8, 1),
(21, 7, 1, 8, 2),
(22, 8, 1, 5, 0),
(23, 8, 1, 7, 1),
(24, 8, 1, 3, 2),
(25, 9, 1, 2, 0),
(26, 9, 1, 10, 1),
(27, 9, 1, 2, 2),
(28, 10, 1, 9, 0),
(29, 10, 1, 4, 1),
(30, 10, 1, 9, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `t_bat_choice`
--

CREATE TABLE `t_bat_choice` (
  `BATTLE_ID` int(10) NOT NULL,
  `ACTOR` int(10) NOT NULL,
  `T_ATT` int(11) NOT NULL,
  `T_DEF` int(11) NOT NULL,
  `SPELL1` int(11) NOT NULL,
  `SPELL2` int(11) NOT NULL,
  `SPELL3` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_bat_choice`
--

INSERT INTO `t_bat_choice` (`BATTLE_ID`, `ACTOR`, `T_ATT`, `T_DEF`, `SPELL1`, `SPELL2`, `SPELL3`) VALUES
(1, 1, 2, 2, -1, 9, 1),
(1, 2, -1, -1, -1, -1, -1),
(2, 1, -1, -1, -1, -1, -1),
(2, 2, -1, -1, -1, -1, -1),
(3, 1, 2, 2, 1, -1, -1),
(3, 2, -1, -1, -1, -1, -1),
(4, 1, -1, -1, -1, -1, -1),
(4, 2, -1, -1, -1, -1, -1),
(5, 1, -1, -1, -1, -1, -1),
(5, 2, -1, -1, -1, -1, -1),
(6, 1, -1, -1, -1, -1, -1),
(6, 2, -1, -1, -1, -1, -1),
(7, 1, 2, 2, 1, 1, 9),
(7, 2, -1, -1, -1, -1, -1),
(8, 1, 1, 1, 1, -1, -1),
(8, 2, -1, -1, -1, -1, -1),
(9, 1, -1, -1, -1, -1, -1),
(9, 2, -1, -1, -1, -1, -1),
(10, 1, 2, 2, -1, -1, -1),
(10, 2, -1, -1, -1, -1, -1);

-- --------------------------------------------------------

--
-- Структура таблицы `t_bat_stat`
--

CREATE TABLE `t_bat_stat` (
  `ID` int(10) NOT NULL,
  `BATTLE_ID` int(10) NOT NULL,
  `ACTOR` int(10) NOT NULL,
  `CHP` int(10) NOT NULL,
  `HPM` int(10) NOT NULL,
  `DMG` int(10) NOT NULL,
  `MANA` int(10) NOT NULL,
  `MNM` int(10) NOT NULL,
  `MONSTR` int(10) NOT NULL,
  `MNR` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_bat_stat`
--

INSERT INTO `t_bat_stat` (`ID`, `BATTLE_ID`, `ACTOR`, `CHP`, `HPM`, `DMG`, `MANA`, `MNM`, `MONSTR`, `MNR`) VALUES
(4, 1, 1, 32, 110, 18, 3, 3, 0, 3),
(5, 1, 2, -61, 120, 18, 0, 0, 2, 0),
(6, 2, 1, 104, 110, 18, 3, 3, 0, 3),
(7, 2, 2, -11, 7, 6, 0, 0, 5, 0),
(8, 3, 1, 105, 110, 18, 3, 3, 0, 3),
(9, 3, 2, -16, 17, 10, 0, 0, 4, 0),
(10, 4, 1, 82, 110, 18, 3, 3, 0, 3),
(11, 4, 2, -9, 27, 14, 0, 0, 5, 0),
(12, 5, 1, 86, 110, 18, 3, 3, 0, 3),
(13, 5, 2, -14, 22, 12, 0, 0, 5, 0),
(14, 6, 1, 82, 110, 18, 3, 3, 0, 3),
(15, 6, 2, -9, 27, 14, 0, 0, 2, 0),
(16, 7, 1, 75, 110, 18, 3, 3, 0, 3),
(17, 7, 2, -32, 85, 14, 0, 0, 4, 0),
(18, 8, 1, 90, 110, 18, 3, 3, 0, 0),
(19, 8, 2, 74, 125, 20, 0, 0, 2, 0),
(20, 9, 1, 30, 110, 18, 3, 3, 0, 0),
(21, 9, 2, 0, 90, 16, 0, 0, 4, 0),
(22, 10, 1, 40, 110, 18, 3, 3, 0, 0),
(23, 10, 2, 53, 125, 20, 0, 0, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_card_info`
--

CREATE TABLE `t_card_info` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_bin NOT NULL,
  `DESCR` varchar(80) COLLATE utf8_bin NOT NULL,
  `MANA` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_card_info`
--

INSERT INTO `t_card_info` (`ID`, `NAME`, `DESCR`, `MANA`) VALUES
(1, 'Ледяная стрела', 'Наносит 15 урона в туловище', 3),
(2, 'Волшебный кулак', 'Наносит 10 урона в голову', 2),
(3, 'Зыбучие пески', 'Дополнительно 10 урона при атаке по ногам', 2),
(4, 'Прыжок', 'Полная блокировка удара по ногам', 2),
(5, 'Подножка', '5 урона по ногам, полная блокировка удара в голову', 3),
(6, 'Невидимость', 'Полная блокировка урона на ход', 4),
(7, 'Каменная кожа', 'Блокировка трети урона', 3),
(8, 'Щит', 'Дополнительная блокировка места защиты', 3),
(9, 'Огненный щит', 'Половина получаемого урона возвращается врагу', 4),
(10, 'Огненный шар', '20 урона, атака в любое место', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `t_log`
--

CREATE TABLE `t_log` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_bin NOT NULL,
  `VALUE` int(10) NOT NULL,
  `DT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_log`
--

INSERT INTO `t_log` (`ID`, `NAME`, `VALUE`, `DT`) VALUES
(15, 'newhp2', -128, '2019-02-28 14:07:02'),
(16, 'newhp', 54, '2019-02-28 14:09:27'),
(17, 'newhp2', -161, '2019-02-28 14:09:27'),
(18, 'newhp', 45, '2019-02-28 14:10:51'),
(19, 'newhp2', -194, '2019-02-28 14:10:51'),
(20, '0', 0, '2019-02-28 14:10:51'),
(21, '1', 1, '2019-02-28 14:10:51'),
(22, '2', 2, '2019-02-28 14:10:51'),
(23, 'newhp', 36, '2019-02-28 14:14:49'),
(24, 'newhp2', -227, '2019-02-28 14:14:49'),
(25, '0', 0, '2019-02-28 14:14:49'),
(26, '1', 1, '2019-02-28 14:14:49'),
(27, '2', 2, '2019-02-28 14:14:49'),
(28, 'newhp', 27, '2019-03-01 12:33:02'),
(29, 'newhp2', -260, '2019-03-01 12:33:02'),
(30, '0', 0, '2019-03-01 12:33:02'),
(31, '1', 1, '2019-03-01 12:33:02'),
(32, '2', 2, '2019-03-01 12:33:02'),
(33, 'newhp', 18, '2019-03-01 12:38:14'),
(34, 'newhp2', -293, '2019-03-01 12:38:14'),
(35, '0', 0, '2019-03-01 12:38:14'),
(36, '1', 1, '2019-03-01 12:38:14'),
(37, '2', 2, '2019-03-01 12:38:14'),
(38, 'newhp', 9, '2019-03-01 12:40:10'),
(39, 'newhp2', -326, '2019-03-01 12:40:10'),
(40, '0', 0, '2019-03-01 12:40:10'),
(41, '1', 1, '2019-03-01 12:40:10'),
(42, '2', 2, '2019-03-01 12:40:10'),
(43, 'newhp', 41, '2019-03-01 12:42:41'),
(44, 'newhp2', -28, '2019-03-01 12:42:41'),
(45, '0', 0, '2019-03-01 12:42:41'),
(46, '1', 1, '2019-03-01 12:42:41'),
(47, '2', 2, '2019-03-01 12:42:41'),
(48, 'newhp', 32, '2019-03-01 12:44:45'),
(49, 'newhp2', -61, '2019-03-01 12:44:45'),
(50, '0', 0, '2019-03-01 12:44:45'),
(51, '1', 1, '2019-03-01 12:44:45'),
(52, '2', 2, '2019-03-01 12:44:45'),
(53, 'newhp', 104, '2019-03-01 12:48:43'),
(54, 'newhp2', -11, '2019-03-01 12:48:43'),
(55, '0', 0, '2019-03-01 12:48:43'),
(56, '1', 1, '2019-03-01 12:48:43'),
(57, '2', 2, '2019-03-01 12:48:43'),
(58, 'newhp', 0, '2019-03-01 13:46:30'),
(59, 'newhp2', 0, '2019-03-01 13:46:30'),
(60, 'newhp', 105, '2019-03-01 13:48:33'),
(61, 'newhp2', -16, '2019-03-01 13:48:33'),
(62, '0', 0, '2019-03-01 13:48:33'),
(63, '1', 1, '2019-03-01 13:48:33'),
(64, '2', 2, '2019-03-01 13:48:33'),
(65, 'newhp', 96, '2019-03-01 13:49:05'),
(66, 'newhp2', 9, '2019-03-01 13:49:05'),
(67, 'newhp', 82, '2019-03-01 13:50:15'),
(68, 'newhp2', -9, '2019-03-01 13:50:15'),
(69, '0', 0, '2019-03-01 13:50:15'),
(70, '1', 1, '2019-03-01 13:50:15'),
(71, '2', 2, '2019-03-01 13:50:15'),
(72, 'newhp', 98, '2019-03-01 13:50:25'),
(73, 'newhp2', 4, '2019-03-01 13:50:25'),
(74, 'newhp', 86, '2019-03-01 13:51:52'),
(75, 'newhp2', -14, '2019-03-01 13:51:52'),
(76, '0', 0, '2019-03-01 13:51:52'),
(77, '1', 1, '2019-03-01 13:51:52'),
(78, '2', 2, '2019-03-01 13:51:52'),
(79, 'newhp', 96, '2019-03-01 13:52:23'),
(80, 'newhp2', 9, '2019-03-01 13:52:23'),
(81, 'newhp', 82, '2019-03-01 13:53:47'),
(82, 'newhp2', -9, '2019-03-01 13:53:47'),
(83, '0', 0, '2019-03-01 13:53:47'),
(84, '1', 1, '2019-03-01 13:53:47'),
(85, '2', 2, '2019-03-01 13:53:47'),
(86, 'newhp', 96, '2019-03-01 13:55:38'),
(87, 'newhp2', 67, '2019-03-01 13:55:38'),
(88, 'newhp', 89, '2019-03-01 13:57:02'),
(89, 'newhp2', 34, '2019-03-01 13:57:02'),
(90, 'newhp', 82, '2019-03-01 13:58:40'),
(91, 'newhp2', 1, '2019-03-01 13:58:40'),
(92, 'newhp', 75, '2019-03-01 14:00:03'),
(93, 'newhp2', -32, '2019-03-01 14:00:03'),
(94, '0', 0, '2019-03-01 14:00:03'),
(95, '1', 1, '2019-03-01 14:00:03'),
(96, '2', 2, '2019-03-01 14:00:03'),
(97, 'newhp', 0, '2019-03-03 17:26:13'),
(98, 'newhp2', 0, '2019-03-03 17:26:14'),
(99, 'newhp', 100, '2019-03-03 19:19:05'),
(100, 'newhp2', 107, '2019-03-03 19:19:05'),
(101, 'newhp', 90, '2019-03-03 19:20:37'),
(102, 'newhp2', 74, '2019-03-03 19:20:37'),
(103, '0', 0, '2019-03-04 12:38:04'),
(104, '1', 1, '2019-03-04 12:38:04'),
(105, '2', 2, '2019-03-04 12:38:04');

-- --------------------------------------------------------

--
-- Структура таблицы `t_monstrs`
--

CREATE TABLE `t_monstrs` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_bin NOT NULL,
  `HPB` int(10) NOT NULL,
  `PRH` int(10) NOT NULL,
  `PRB` int(10) NOT NULL,
  `PRL` int(10) NOT NULL,
  `DMG` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_monstrs`
--

INSERT INTO `t_monstrs` (`ID`, `NAME`, `HPB`, `PRH`, `PRB`, `PRL`, `DMG`) VALUES
(1, 'Волк', 90, 0, 40, 60, 18),
(2, 'Тигр', 120, 10, 40, 50, 18),
(3, 'Кобра', 60, 0, 30, 70, 30),
(4, 'Ястреб', 80, 40, 30, 30, 12),
(5, 'Медведь', 150, 20, 40, 40, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `t_person_info`
--

CREATE TABLE `t_person_info` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(50) COLLATE utf8_bin NOT NULL,
  `S_S` int(10) NOT NULL,
  `S_A` int(10) NOT NULL,
  `S_I` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_person_info`
--

INSERT INTO `t_person_info` (`ID`, `NAME`, `S_S`, `S_A`, `S_I`) VALUES
(1, 'Ассасин', 2, 4, 2),
(2, 'Гладиатор', 4, 2, 2),
(3, 'Маг', 2, 2, 4),
(4, 'Рыцарь', 3, 3, 2),
(5, 'Монах', 3, 2, 3),
(6, 'Шаман', 2, 3, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `t_user_arts`
--

CREATE TABLE `t_user_arts` (
  `ID` int(10) NOT NULL,
  `LOGIN_ID` int(10) NOT NULL,
  `NUM` int(10) NOT NULL,
  `PLACE` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `t_user_arts`
--

INSERT INTO `t_user_arts` (`ID`, `LOGIN_ID`, `NUM`, `PLACE`) VALUES
(1, 1, 3, 12),
(2, 1, 4, 11);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `t_accounts`
--
ALTER TABLE `t_accounts`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_account_stat`
--
ALTER TABLE `t_account_stat`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_arena`
--
ALTER TABLE `t_arena`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_art_info`
--
ALTER TABLE `t_art_info`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_bat_cards`
--
ALTER TABLE `t_bat_cards`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_bat_stat`
--
ALTER TABLE `t_bat_stat`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_card_info`
--
ALTER TABLE `t_card_info`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_log`
--
ALTER TABLE `t_log`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_monstrs`
--
ALTER TABLE `t_monstrs`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_person_info`
--
ALTER TABLE `t_person_info`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `t_user_arts`
--
ALTER TABLE `t_user_arts`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `t_accounts`
--
ALTER TABLE `t_accounts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `t_account_stat`
--
ALTER TABLE `t_account_stat`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `t_arena`
--
ALTER TABLE `t_arena`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `t_art_info`
--
ALTER TABLE `t_art_info`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `t_bat_cards`
--
ALTER TABLE `t_bat_cards`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT для таблицы `t_bat_stat`
--
ALTER TABLE `t_bat_stat`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `t_card_info`
--
ALTER TABLE `t_card_info`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `t_log`
--
ALTER TABLE `t_log`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- AUTO_INCREMENT для таблицы `t_monstrs`
--
ALTER TABLE `t_monstrs`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `t_person_info`
--
ALTER TABLE `t_person_info`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
