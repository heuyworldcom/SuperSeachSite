-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 27, 2019 at 01:55 AM
-- Server version: 5.7.26-0ubuntu0.19.04.1
-- PHP Version: 7.2.19-0ubuntu0.19.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supersearchdb`
--
CREATE DATABASE IF NOT EXISTS `supersearchdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `supersearchdb`;

-- --------------------------------------------------------

--
-- Table structure for table `glyphicons`
--

CREATE TABLE `glyphicons` (
  `glyph_id` int(11) NOT NULL,
  `glyph` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glyphicons`
--

INSERT INTO `glyphicons` (`glyph_id`, `glyph`) VALUES
(1, 'glyphicon-asterisk'),
(2, 'glyphicon-plus'),
(3, 'glyphicon-minus'),
(4, 'glyphicon-euro'),
(5, 'glyphicon-cloud'),
(6, 'glyphicon-envelope'),
(7, 'glyphicon-pencil'),
(8, 'glyphicon-glass'),
(9, 'glyphicon-music'),
(10, 'glyphicon-search'),
(11, 'glyphicon-heart'),
(12, 'glyphicon-star'),
(13, 'glyphicon-star-empty'),
(14, 'glyphicon-user'),
(15, 'glyphicon-film'),
(16, 'glyphicon-th-large'),
(17, 'glyphicon-th'),
(18, 'glyphicon-th-list'),
(19, 'glyphicon-ok'),
(20, 'glyphicon-remove'),
(21, 'glyphicon-zoom-in'),
(22, 'glyphicon-zoom-out'),
(23, 'glyphicon-off'),
(24, 'glyphicon-signal'),
(25, 'glyphicon-cog'),
(26, 'glyphicon-trash'),
(27, 'glyphicon-home'),
(28, 'glyphicon-file'),
(29, 'glyphicon-time'),
(30, 'glyphicon-road'),
(31, 'glyphicon-download-alt'),
(32, 'glyphicon-download'),
(33, 'glyphicon-upload'),
(34, 'glyphicon-inbox'),
(35, 'glyphicon-play-circle'),
(36, 'glyphicon-repeat'),
(37, 'glyphicon-refresh'),
(38, 'glyphicon-list-alt'),
(39, 'glyphicon-lock'),
(40, 'glyphicon-flag'),
(41, 'glyphicon-headphones'),
(42, 'glyphicon-volume-off'),
(43, 'glyphicon-volume-down'),
(44, 'glyphicon-volume-up'),
(45, 'glyphicon-qrcode'),
(46, 'glyphicon-barcode'),
(47, 'glyphicon-tag'),
(48, 'glyphicon-tags'),
(49, 'glyphicon-book'),
(50, 'glyphicon-bookmark'),
(51, 'glyphicon-print'),
(52, 'glyphicon-camera'),
(53, 'glyphicon-font'),
(54, 'glyphicon-bold'),
(55, 'glyphicon-italic'),
(56, 'glyphicon-text-height'),
(57, 'glyphicon-text-width'),
(58, 'glyphicon-align-left'),
(59, 'glyphicon-align-center'),
(60, 'glyphicon-align-right'),
(61, 'glyphicon-align-justify'),
(62, 'glyphicon-list'),
(63, 'glyphicon-indent-left'),
(64, 'glyphicon-indent-right'),
(65, 'glyphicon-facetime-video'),
(66, 'glyphicon-picture'),
(67, 'glyphicon-map-marker'),
(68, 'glyphicon-adjust'),
(69, 'glyphicon-tint'),
(70, 'glyphicon-edit'),
(71, 'glyphicon-share'),
(72, 'glyphicon-check'),
(73, 'glyphicon-move'),
(74, 'glyphicon-step-backward'),
(75, 'glyphicon-fast-backward'),
(76, 'glyphicon-backward'),
(77, 'glyphicon-play'),
(78, 'glyphicon-pause'),
(79, 'glyphicon-stop'),
(80, 'glyphicon-forward'),
(81, 'glyphicon-fast-forward'),
(82, 'glyphicon-step-forward'),
(83, 'glyphicon-eject'),
(84, 'glyphicon-chevron-left'),
(85, 'glyphicon-chevron-right'),
(86, 'glyphicon-plus-sign'),
(87, 'glyphicon-minus-sign'),
(88, 'glyphicon-remove-sign'),
(89, 'glyphicon-ok-sign'),
(90, 'glyphicon-question-sign'),
(91, 'glyphicon-info-sign'),
(92, 'glyphicon-screenshot'),
(93, 'glyphicon-remove-circle'),
(94, 'glyphicon-ok-circle'),
(95, 'glyphicon-ban-circle'),
(96, 'glyphicon-arrow-left'),
(97, 'glyphicon-arrow-right'),
(98, 'glyphicon-arrow-up'),
(99, 'glyphicon-arrow-down'),
(100, 'glyphicon-share-alt'),
(101, 'glyphicon-resize-full'),
(102, 'glyphicon-resize-small'),
(103, 'glyphicon-exclamation-sign'),
(104, 'glyphicon-gift'),
(105, 'glyphicon-leaf'),
(106, 'glyphicon-fire'),
(107, 'glyphicon-eye-open'),
(108, 'glyphicon-eye-close'),
(109, 'glyphicon-warning-sign'),
(110, 'glyphicon-plane'),
(111, 'glyphicon-calendar'),
(112, 'glyphicon-random'),
(113, 'glyphicon-comment'),
(114, 'glyphicon-magnet'),
(115, 'glyphicon-chevron-up'),
(116, 'glyphicon-chevron-down'),
(117, 'glyphicon-retweet'),
(118, 'glyphicon-shopping-cart'),
(119, 'glyphicon-folder-close'),
(120, 'glyphicon-folder-open'),
(121, 'glyphicon-resize-vertical'),
(122, 'glyphicon-resize-horizontal'),
(123, 'glyphicon-hdd'),
(124, 'glyphicon-bullhorn'),
(125, 'glyphicon-bell'),
(126, 'glyphicon-certificate'),
(127, 'glyphicon-thumbs-up'),
(128, 'glyphicon-thumbs-down'),
(129, 'glyphicon-hand-right'),
(130, 'glyphicon-hand-left'),
(131, 'glyphicon-hand-up'),
(132, 'glyphicon-hand-down'),
(133, 'glyphicon-circle-arrow-right'),
(134, 'glyphicon-circle-arrow-left'),
(135, 'glyphicon-circle-arrow-up'),
(136, 'glyphicon-circle-arrow-down'),
(137, 'glyphicon-globe'),
(138, 'glyphicon-wrench'),
(139, 'glyphicon-tasks'),
(140, 'glyphicon-filter'),
(141, 'glyphicon-briefcase'),
(142, 'glyphicon-fullscreen'),
(143, 'glyphicon-dashboard'),
(144, 'glyphicon-paperclip'),
(145, 'glyphicon-heart-empty'),
(146, 'glyphicon-link'),
(147, 'glyphicon-phone'),
(148, 'glyphicon-pushpin'),
(149, 'glyphicon-usd'),
(150, 'glyphicon-gbp'),
(151, 'glyphicon-sort'),
(152, 'glyphicon-sort-by-alphabet'),
(153, 'glyphicon-sort-by-alphabet-alt'),
(154, 'glyphicon-sort-by-order'),
(155, 'glyphicon-sort-by-order-alt'),
(156, 'glyphicon-sort-by-attributes'),
(157, 'glyphicon-sort-by-attributes-alt'),
(158, 'glyphicon-unchecked'),
(159, 'glyphicon-expand'),
(160, 'glyphicon-collapse-down'),
(161, 'glyphicon-collapse-up'),
(162, 'glyphicon-log-in'),
(163, 'glyphicon-flash'),
(164, 'glyphicon-log-out'),
(165, 'glyphicon-new-window'),
(166, 'glyphicon-record'),
(167, 'glyphicon-save'),
(168, 'glyphicon-open'),
(169, 'glyphicon-saved'),
(170, 'glyphicon-import'),
(171, 'glyphicon-export'),
(172, 'glyphicon-send'),
(173, 'glyphicon-floppy-disk'),
(174, 'glyphicon-floppy-saved'),
(175, 'glyphicon-floppy-remove'),
(176, 'glyphicon-floppy-save'),
(177, 'glyphicon-floppy-open'),
(178, 'glyphicon-credit-card'),
(179, 'glyphicon-transfer'),
(180, 'glyphicon-cutlery'),
(181, 'glyphicon-header'),
(182, 'glyphicon-compressed'),
(183, 'glyphicon-earphone'),
(184, 'glyphicon-phone-alt'),
(185, 'glyphicon-tower'),
(186, 'glyphicon-stats'),
(187, 'glyphicon-sd-video'),
(188, 'glyphicon-hd-video'),
(189, 'glyphicon-subtitles'),
(190, 'glyphicon-sound-stereo'),
(191, 'glyphicon-sound-dolby'),
(192, 'glyphicon-sound-5-1'),
(193, 'glyphicon-sound-6-1'),
(194, 'glyphicon-sound-7-1'),
(195, 'glyphicon-copyright-mark'),
(196, 'glyphicon-registration-mark'),
(197, 'glyphicon-cloud-download'),
(198, 'glyphicon-cloud-upload'),
(199, 'glyphicon-tree-conifer'),
(200, 'glyphicon-tree-deciduous'),
(201, 'glyphicon-cd'),
(202, 'glyphicon-save-file'),
(203, 'glyphicon-open-file'),
(204, 'glyphicon-level-up'),
(205, 'glyphicon-copy'),
(206, 'glyphicon-paste'),
(207, 'glyphicon-alert'),
(208, 'glyphicon-equalizer'),
(209, 'glyphicon-king'),
(210, 'glyphicon-queen'),
(211, 'glyphicon-pawn'),
(212, 'glyphicon-bishop'),
(213, 'glyphicon-knight'),
(214, 'glyphicon-baby-formula'),
(215, 'glyphicon-tent'),
(216, 'glyphicon-blackboard'),
(217, 'glyphicon-bed'),
(218, 'glyphicon-apple'),
(219, 'glyphicon-erase'),
(220, 'glyphicon-hourglass'),
(221, 'glyphicon-lamp'),
(222, 'glyphicon-duplicate'),
(223, 'glyphicon-piggy-bank'),
(224, 'glyphicon-scissors'),
(225, 'glyphicon-bitcoin'),
(226, 'glyphicon-yen'),
(227, 'glyphicon-ruble'),
(228, 'glyphicon-scale'),
(229, 'glyphicon-ice-lolly'),
(230, 'glyphicon-ice-lolly-tasted'),
(231, 'glyphicon-education'),
(232, 'glyphicon-option-horizontal'),
(233, 'glyphicon-option-vertical'),
(234, 'glyphicon-menu-hamburger'),
(235, 'glyphicon-modal-window'),
(236, 'glyphicon-oil'),
(237, 'glyphicon-grain'),
(238, 'glyphicon-sunglasses'),
(239, 'glyphicon-text-size'),
(240, 'glyphicon-text-color'),
(241, 'glyphicon-text-background'),
(242, 'glyphicon-object-align-top'),
(243, 'glyphicon-object-align-bottom'),
(244, 'glyphicon-object-align-horizontal'),
(245, 'glyphicon-object-align-left'),
(246, 'glyphicon-object-align-vertical'),
(247, 'glyphicon-object-align-right'),
(248, 'glyphicon-triangle-right'),
(249, 'glyphicon-triangle-left'),
(250, 'glyphicon-triangle-bottom'),
(251, 'glyphicon-triangle-top'),
(252, 'glyphicon-superscript'),
(253, 'glyphicon-subscript'),
(254, 'glyphicon-menu-left'),
(255, 'glyphicon-menu-right'),
(256, 'glyphicon-menu-down'),
(257, 'glyphicon-menu-up');

-- --------------------------------------------------------

--
-- Table structure for table `supersearch`
--

CREATE TABLE `supersearch` (
  `ID` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `shortdesc` varchar(255) NOT NULL,
  `searchprefix` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supersearch`
--

INSERT INTO `supersearch` (`ID`, `user_id`, `created_date`, `active`, `name`, `url`, `shortdesc`, `searchprefix`) VALUES
(9, 1, '2019-12-26 22:12:39', 1, 'C# ASP.NET', 'https://www.google.com/search?', 'Things about C#', 'c# asp.net'),
(11, 1, '2019-12-27 00:12:53', 1, 'VB ASP.NET', 'https://www.google.com/search?', 'Things about VB ASP.NET', 'vb asp.net'),
(12, 1, '2019-12-27 00:12:25', 1, 'PHP', 'https://www.google.com/search?', 'Things about PHP', 'PHP 7'),
(13, 1, '2019-12-27 01:12:51', 1, 'MySQL', 'https://www.google.com/search?', 'Things about MySQL in Putty', 'mysql putty'),
(14, 1, '2019-12-27 01:12:38', 1, 'HTML', 'https://www.google.com/search?', 'Things about HTML5', 'html5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(255) NOT NULL DEFAULT '',
  `user_pswd` varchar(30) NOT NULL DEFAULT '',
  `user_hash` varchar(50) NOT NULL DEFAULT '',
  `last_login` datetime DEFAULT NULL,
  `user_login` varchar(50) NOT NULL,
  `num_logins` int(11) NOT NULL DEFAULT '1',
  `user_class_id` int(11) NOT NULL,
  `consent_store_email` tinyint(1) NOT NULL DEFAULT '0',
  `failed_logins` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `created_date`, `user_name`, `user_email`, `user_pswd`, `user_hash`, `last_login`, `user_login`, `num_logins`, `user_class_id`, `consent_store_email`, `failed_logins`, `active`) VALUES
(1, '2019-12-26 00:00:00', 'Kevin', 'heuyworld@hotmail.com', 'getherdown', 'abc', '2019-12-26 00:00:00', 'abc', 1, 1, 1, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `glyphicons`
--
ALTER TABLE `glyphicons`
  ADD PRIMARY KEY (`glyph_id`);

--
-- Indexes for table `supersearch`
--
ALTER TABLE `supersearch`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `glyphicons`
--
ALTER TABLE `glyphicons`
  MODIFY `glyph_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;
--
-- AUTO_INCREMENT for table `supersearch`
--
ALTER TABLE `supersearch`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
