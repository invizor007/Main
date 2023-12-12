-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Мар 01 2022 г., 19:49
-- Версия сервера: 5.5.8
-- Версия PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `kgbnt`
--

-- --------------------------------------------------------

--
-- Структура таблицы `t_accounts`
--

CREATE TABLE IF NOT EXISTS `t_accounts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) NOT NULL,
  `CODE` varchar(10) NOT NULL,
  `GM_ID` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `t_accounts`
--

INSERT INTO `t_accounts` (`ID`, `NAME`, `CODE`, `GM_ID`) VALUES
(1, 'Player1', '84559955', 1),
(2, 'Player2', '10668856', 0),
(3, 'Player3', '40449227', 0),
(4, 'Player4', '12376537', 0),
(5, 'Player5', '22204434', 0),
(6, 'Player6', '80492312', 0),
(7, 'Player934', '84870160', 0),
(8, 'Player954', '46146149', 0),
(9, 'Player174', '51287880', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `t_cardfront`
--

CREATE TABLE IF NOT EXISTS `t_cardfront` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GM_ID` int(10) NOT NULL,
  `PL_ID` int(10) NOT NULL,
  `CRDTP_ID` int(10) NOT NULL,
  `X` int(10) NOT NULL,
  `Y` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=612 ;

--
-- Дамп данных таблицы `t_cardfront`
--


-- --------------------------------------------------------

--
-- Структура таблицы `t_cardlist`
--

CREATE TABLE IF NOT EXISTS `t_cardlist` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GM_ID` int(10) NOT NULL,
  `CRDTP_ID` int(10) NOT NULL,
  `USED` int(10) NOT NULL,
  `NUM` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- Дамп данных таблицы `t_cardlist`
--

INSERT INTO `t_cardlist` (`ID`, `GM_ID`, `CRDTP_ID`, `USED`, `NUM`) VALUES
(1, 1, 0, 0, 8),
(2, 1, 1, 0, 9),
(3, 1, 2, 0, 30),
(4, 1, 3, 0, 17),
(5, 1, 4, 0, 32),
(6, 1, 5, 0, 12),
(7, 1, 6, 0, 33),
(8, 1, 7, 0, 34),
(9, 1, 8, 0, 43),
(10, 1, 9, 0, 29),
(11, 1, 10, 0, 10),
(12, 1, 11, 0, 21),
(13, 1, 12, 0, 11),
(14, 1, 13, 0, 35),
(15, 1, 14, 0, 20),
(16, 1, 15, 0, 25),
(17, 1, 16, 0, 40),
(18, 1, 17, 0, 26),
(19, 1, 18, 0, 39),
(20, 1, 19, 0, 18),
(21, 1, 20, 0, 3),
(22, 1, 21, 0, 38),
(23, 1, 22, 0, 0),
(24, 1, 23, 0, 24),
(25, 1, 24, 0, 41),
(26, 1, 25, 0, 36),
(27, 1, 26, 0, 15),
(28, 1, 27, 0, 31),
(29, 1, 28, 0, 23),
(30, 1, 29, 0, 2),
(31, 1, 30, 0, 44),
(32, 1, 31, 0, 37),
(33, 1, 32, 0, 14),
(34, 1, 33, 0, 7),
(35, 1, 34, 0, 19),
(36, 1, 35, 0, 27),
(37, 1, 36, 0, 28),
(38, 1, 37, 0, 16),
(39, 1, 38, 0, 45),
(40, 1, 39, 0, 42),
(41, 1, 40, 0, 4),
(42, 1, 41, 0, 1),
(43, 1, 42, 0, 13),
(44, 1, 43, 0, 6),
(45, 1, 44, 0, 22),
(46, 1, 45, 0, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `t_cardpl`
--

CREATE TABLE IF NOT EXISTS `t_cardpl` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GM_ID` int(10) NOT NULL,
  `PL_ID` int(10) NOT NULL,
  `CRDTP_ID` int(10) NOT NULL,
  `NUM` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1583 ;

--
-- Дамп данных таблицы `t_cardpl`
--

INSERT INTO `t_cardpl` (`ID`, `GM_ID`, `PL_ID`, `CRDTP_ID`, `NUM`) VALUES
(1563, 1, 1, 41, 0),
(1564, 1, 1, 29, 1),
(1565, 1, 1, 20, 2),
(1566, 1, 1, 40, 3),
(1567, 1, 2, 45, 0),
(1568, 1, 2, 43, 1),
(1569, 1, 2, 33, 2),
(1570, 1, 2, 0, 3),
(1571, 1, 3, 1, 0),
(1572, 1, 3, 10, 1),
(1573, 1, 3, 12, 2),
(1574, 1, 3, 5, 3),
(1575, 1, 4, 42, 0),
(1576, 1, 4, 32, 1),
(1577, 1, 4, 26, 2),
(1578, 1, 4, 37, 3),
(1579, 1, 5, 3, 0),
(1580, 1, 5, 19, 1),
(1581, 1, 5, 34, 2),
(1582, 1, 5, 14, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `t_cardtypes`
--

CREATE TABLE IF NOT EXISTS `t_cardtypes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIP` int(11) NOT NULL,
  `SUBTIP` int(11) NOT NULL,
  `VAL` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Дамп данных таблицы `t_cardtypes`
--

INSERT INTO `t_cardtypes` (`ID`, `TIP`, `SUBTIP`, `VAL`) VALUES
(0, 1, 0, 2),
(1, 1, 0, 3),
(2, 1, 0, 4),
(3, 1, 0, 5),
(4, 1, 0, 6),
(5, 1, 1, 2),
(6, 1, 1, 3),
(7, 1, 1, 4),
(8, 1, 1, 5),
(9, 1, 1, 6),
(10, 1, 2, 2),
(11, 1, 2, 3),
(12, 1, 2, 4),
(13, 1, 2, 5),
(14, 1, 2, 6),
(15, 1, 3, 2),
(16, 1, 3, 3),
(17, 1, 3, 4),
(18, 1, 3, 5),
(19, 1, 3, 6),
(20, 1, 4, 2),
(21, 1, 4, 3),
(22, 1, 4, 4),
(23, 1, 4, 5),
(24, 1, 4, 6),
(25, 2, 1, 1),
(26, 2, 1, 2),
(27, 2, 1, 3),
(28, 2, 2, 1),
(29, 2, 2, 2),
(30, 2, 2, 3),
(31, 2, 3, 1),
(32, 2, 3, 2),
(33, 2, 3, 3),
(34, 2, 4, 1),
(35, 2, 4, 2),
(36, 2, 4, 3),
(37, 3, 0, 1),
(38, 3, 0, 2),
(39, 3, 0, 3),
(40, 3, 1, 1),
(41, 3, 1, 2),
(42, 3, 1, 3),
(43, 3, 2, 1),
(44, 3, 2, 2),
(45, 3, 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `t_gm_pl`
--

CREATE TABLE IF NOT EXISTS `t_gm_pl` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ACC_ID` int(10) NOT NULL,
  `GM_ID` int(10) NOT NULL,
  `PLNUM` int(10) NOT NULL,
  `HUMFLG` varchar(1) NOT NULL,
  `ACTFLG` varchar(1) NOT NULL,
  `SKIPCARD` int(10) NOT NULL,
  `SCORE` int(10) NOT NULL,
  `LASTHFLG` varchar(1) NOT NULL,
  `LASTMFLG` varchar(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Дамп данных таблицы `t_gm_pl`
--

INSERT INTO `t_gm_pl` (`ID`, `ACC_ID`, `GM_ID`, `PLNUM`, `HUMFLG`, `ACTFLG`, `SKIPCARD`, `SCORE`, `LASTHFLG`, `LASTMFLG`) VALUES
(1, 1, 1, 1, 'Y', 'Y', 0, 0, 'N', 'N'),
(2, 1, 1, 2, 'N', 'N', 1, 2, 'N', 'N'),
(3, 1, 1, 3, 'N', 'N', 1, 2, 'N', 'N'),
(4, 1, 1, 4, 'N', 'N', 1, 8, 'N', 'N'),
(5, 1, 1, 5, 'N', 'Y', 1, 0, 'N', 'N'),
(15, 1, 2, 1, 'Y', 'Y', 0, 0, 'N', 'N'),
(16, 1, 2, 2, 'N', 'N', 0, 0, 'N', 'N'),
(17, 1, 2, 3, 'N', 'N', 0, 0, 'N', 'N'),
(18, 1, 2, 4, 'N', 'N', 0, 0, 'N', 'N'),
(19, 1, 2, 3, 'Y', 'Y', 0, 0, 'N', 'N');

-- --------------------------------------------------------

--
-- Структура таблицы `t_gm_temp`
--

CREATE TABLE IF NOT EXISTS `t_gm_temp` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GM_ID` int(10) NOT NULL,
  `CODE` varchar(10) NOT NULL,
  `VAL` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `t_gm_temp`
--

INSERT INTO `t_gm_temp` (`ID`, `GM_ID`, `CODE`, `VAL`) VALUES
(1, 1, 'PLCO', 5),
(2, 1, 'STEP', 3),
(3, 1, 'PLNUM', 1),
(4, 1, 'LASTCARD', 26),
(5, 1, 'USEDCARD', 20),
(11, 2, 'PLCO', 4),
(12, 2, 'STEP', 1),
(13, 2, 'PLNUM', 1),
(14, 2, 'LASTCARD', 30),
(15, 2, 'USEDCARD', 16);

-- --------------------------------------------------------

--
-- Структура таблицы `t_gm_tit`
--

CREATE TABLE IF NOT EXISTS `t_gm_tit` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `GM_ID` int(10) NOT NULL,
  `NUM` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `t_gm_tit`
--

INSERT INTO `t_gm_tit` (`ID`, `GM_ID`, `NUM`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `t_info_bname`
--

CREATE TABLE IF NOT EXISTS `t_info_bname` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `FID` int(10) NOT NULL,
  `FVAL` int(10) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Дамп данных таблицы `t_info_bname`
--

INSERT INTO `t_info_bname` (`ID`, `FID`, `FVAL`, `NAME`) VALUES
(109, 1, 1, 'Таверна здоровый дух'),
(110, 1, 2, 'Замок Телион'),
(111, 1, 3, 'Замок Далоэр'),
(112, 2, 1, 'Колесная мастерская'),
(113, 2, 2, 'Фабрика'),
(114, 2, 3, 'Замок Монтор'),
(115, 3, 1, 'Палатка утряски'),
(116, 3, 2, 'Таверна сытый орк'),
(117, 3, 3, 'Замок Хезерхем'),
(118, 4, 1, 'Храм костей'),
(119, 4, 2, 'Замок Олум'),
(120, 4, 3, 'Замок Некроком');

-- --------------------------------------------------------

--
-- Структура таблицы `t_info_fname`
--

CREATE TABLE IF NOT EXISTS `t_info_fname` (
  `ID` int(10) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `t_info_fname`
--

INSERT INTO `t_info_fname` (`ID`, `NAME`) VALUES
(0, 'Люди'),
(1, 'Эльфы'),
(2, 'Гномы'),
(3, 'Орки'),
(4, 'Нежить');

-- --------------------------------------------------------

--
-- Структура таблицы `t_info_uname`
--

CREATE TABLE IF NOT EXISTS `t_info_uname` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `FID` int(10) NOT NULL,
  `FVAL` int(10) NOT NULL,
  `NAME` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=281 ;

--
-- Дамп данных таблицы `t_info_uname`
--

INSERT INTO `t_info_uname` (`ID`, `FID`, `FVAL`, `NAME`) VALUES
(256, 0, 2, 'Лучник'),
(257, 0, 3, 'Мечник'),
(258, 0, 4, 'Архимаг'),
(259, 0, 5, 'Красный дракон'),
(260, 0, 6, 'Томас Торкве'),
(261, 1, 2, 'Эльф'),
(262, 1, 3, 'Оборотень'),
(263, 1, 4, 'Друид'),
(264, 1, 5, 'Древний Энт'),
(265, 1, 6, 'Дриада Бюлла'),
(266, 2, 2, 'Дройд механик'),
(267, 2, 3, 'Гном'),
(268, 2, 4, 'Алхимик'),
(269, 2, 5, 'Гигант'),
(270, 2, 6, 'Безумный рудокоп'),
(271, 3, 2, 'Гоблин'),
(272, 3, 3, 'Орк'),
(273, 3, 4, 'Шаман'),
(274, 3, 5, 'Огр'),
(275, 3, 6, 'Багуд'),
(276, 4, 2, 'Скелет лучник'),
(277, 4, 3, 'Зомби'),
(278, 4, 4, 'Некромант'),
(279, 4, 5, 'Костяной Дракон'),
(280, 4, 6, 'Фон Краков');
