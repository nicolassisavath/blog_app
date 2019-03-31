-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2019 at 01:10 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `art_id` int(11) NOT NULL,
  `art_title` varchar(255) NOT NULL,
  `art_content` text NOT NULL,
  `art_image` varchar(255) DEFAULT NULL,
  `art_created` datetime NOT NULL,
  `art_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `use_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`art_id`, `art_title`, `art_content`, `art_image`, `art_created`, `art_enabled`, `use_id`) VALUES
(1, 'Titre article 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, '2018-04-10 01:00:00', 1, 1),
(3, 'Titre article 31', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', NULL, '2018-04-10 03:00:00', 1, 23),
(4, 'Petit essai d\'article', 'Ben voila je sais pas trop quoi ecrire encore', NULL, '2018-04-18 18:13:56', 1, 23),
(6, 'Petit essai encore', 'Mais cette fois avec les tests de verification\r\n&lt;sccript&gt;Alert(hkjhkj)&lt;/sccript&gt;', NULL, '2018-04-18 18:26:49', 1, 23);

-- --------------------------------------------------------

--
-- Table structure for table `article_tag`
--

CREATE TABLE `article_tag` (
  `art_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article_tag`
--

INSERT INTO `article_tag` (`art_id`, `tag_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(3, 1),
(3, 2),
(3, 3),
(6, 1),
(6, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `com_id` int(11) NOT NULL,
  `com_content` text NOT NULL,
  `com_created` datetime DEFAULT NULL,
  `com_alert` tinyint(4) NOT NULL DEFAULT '0',
  `com_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `art_id` int(11) NOT NULL,
  `use_id` int(11) NOT NULL,
  `com_id_1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_content`, `com_created`, `com_alert`, `com_enabled`, `art_id`, `use_id`, `com_id_1`) VALUES
(1, 'Bravo, j\'aime bcp cet article!!', '2018-04-10 04:00:00', 0, 1, 1, 3, NULL),
(2, 'Moi j\'aime pas cet article !!', '2018-04-10 04:05:00', 0, 1, 1, 4, NULL),
(3, 'Moi ausi j\'aime bien cet article !!', '2018-04-10 04:15:00', 0, 1, 1, 5, 1),
(4, 'slut 2e essai', '2018-04-18 11:34:43', 0, 1, 1, 15, NULL),
(5, 'slt les e3e', '2018-04-18 11:37:30', 0, 1, 1, 15, NULL),
(6, 'eeeee', '2018-04-18 11:46:34', 0, 1, 1, 15, NULL),
(7, 'poulopot', '2018-04-18 12:10:40', 0, 1, 1, 15, NULL),
(8, 'Bonjour tout le monnde', '2018-04-18 14:05:55', 0, 1, 1, 15, NULL),
(9, 'Salut Alex', '2018-04-18 14:08:08', 0, 1, 1, 15, NULL),
(10, 'Salut , j\'aime ce que tis', '2018-04-18 14:09:59', 0, 1, 1, 15, 9),
(11, 'Grave, trop la verite', '2018-04-18 14:10:16', 0, 1, 1, 15, 4),
(12, 'ouais super grave, vous avez trop raiosn', '2018-04-18 14:10:42', 0, 1, 1, 15, 4),
(13, 'Bon jj\'aofesfdsfds', '2018-04-18 14:35:02', 0, 1, 1, 15, NULL),
(14, 'gfdsgrnb  bnan', '2018-04-18 14:35:11', 0, 1, 1, 15, 13),
(17, 'Article tres interessant!!', '2018-04-18 18:27:17', 0, 1, 6, 23, NULL),
(18, 'J\'approuve!! Je supplue!!', '2018-04-18 18:27:28', 0, 1, 6, 23, NULL),
(19, 'Et je parle seule car la flemme de me connecter ac un autre compte', '2018-04-18 18:27:45', 0, 1, 6, 23, 17),
(26, 'coucou', '2018-04-19 21:43:01', 0, 1, 3, 23, NULL),
(27, 'ohbjklb', '2018-04-19 22:36:02', 0, 1, 3, 23, NULL),
(28, 'Oui je suis d\'accord', '2018-04-19 22:36:17', 0, 1, 3, 23, 26),
(31, 'coucou ouais d\'accord', '2018-04-22 15:01:04', 0, 1, 6, 15, NULL),
(32, 'j\'approuve', '2018-04-22 15:01:15', 0, 1, 6, 15, 17),
(33, 'fsdfdsf\r\n', '2018-04-22 15:02:34', 0, 1, 6, 15, NULL),
(34, 'fsdfdsf\r\n', '2018-04-22 15:03:43', 0, 1, 6, 15, NULL),
(35, 'fsdfdsf\r\n', '2018-04-22 15:05:45', 0, 1, 6, 15, NULL),
(36, 'Je suis content', '2018-04-22 17:49:41', 0, 1, 3, 15, NULL),
(37, 'Coucou lisa!!', '2018-04-22 17:50:00', 0, 1, 3, 15, 26);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `pos_id` int(11) NOT NULL,
  `pos_content` text NOT NULL,
  `pos_created` datetime NOT NULL,
  `pos_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `use_id` int(11) NOT NULL,
  `top_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`pos_id`, `pos_content`, `pos_created`, `pos_enabled`, `use_id`, `top_id`) VALUES
(1, 'Oui j\'ai rencontré les hommes verts, je veux avoir votre avis!!', '2018-04-10 13:44:00', 1, 3, 1),
(2, 'Moi aussi je les ai rencontré, mais par contre ils sont gris!! \r\nBon après c\'etait de nuit et je suis daltonien, j\'etais bourré aussi et j\'etais de dos, ouais enfin c\'etait peut etre un chat en fait', '2018-04-10 14:26:00', 1, 4, 1),
(3, 'Bonnjour, je veux parler ac vous', '2018-04-24 17:06:54', 1, 15, 1),
(4, 'Allez petit reessai\r\n', '2018-04-24 17:09:31', 1, 15, 1),
(5, 'Cette fois c\'est la bonne', '2018-04-24 17:11:06', 1, 15, 1),
(6, 'bonjour les gens', '2018-04-26 11:50:49', 1, 15, 1),
(7, 'Je suis nouveau,\r\nje viens de Jupiton!!', '2018-04-26 11:51:04', 1, 15, 1),
(8, 'Je suis nouveau,\r\nje viens de Jupiton!!', '2018-04-26 11:51:52', 1, 15, 1),
(9, 'Je suis nouveau,\r\nje viens de Jupiton!!', '2018-04-26 11:53:40', 1, 15, 1),
(10, 'Vous allez bien?', '2018-04-26 11:56:51', 1, 15, 1),
(11, 'Moi je vais bien', '2018-04-26 11:57:48', 1, 15, 1),
(12, 'Voila encore un essai\r\nAvec un retour a la ligne', '2018-04-26 11:58:04', 1, 15, 1),
(13, 'dsnfsifuvndi vn difnv dsfdv', '2018-04-26 18:32:45', 1, 23, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(1, 'actualites'),
(4, 'insolite'),
(3, 'sport'),
(2, 'technologie');

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `the_id` int(11) NOT NULL,
  `the_name` varchar(255) NOT NULL,
  `the_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `theme`
--

INSERT INTO `theme` (`the_id`, `the_name`, `the_created`) VALUES
(1, 'salon discussion', '2018-04-10 08:00:00'),
(2, 'paranormal', '2018-04-10 11:00:00'),
(3, 'psychologie', '2018-04-10 12:00:00'),
(4, 'spiritualité', '2018-04-10 13:00:00'),
(5, 'loisirs', '2018-04-25 11:47:44'),
(6, 'sports', '2018-04-25 16:47:18');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `top_id` int(11) NOT NULL,
  `top_title` varchar(255) NOT NULL,
  `top_created` datetime NOT NULL,
  `top_last_comment` datetime DEFAULT NULL,
  `top_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `use_id` int(11) NOT NULL,
  `the_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`top_id`, `top_title`, `top_created`, `top_last_comment`, `top_enabled`, `use_id`, `the_id`) VALUES
(1, 'J\'ai rencontré les aliens', '2018-04-10 13:40:00', NULL, 1, 3, 2),
(2, 'le pere noel existe, et c\'est ma mere!!', '2018-04-10 14:14:00', NULL, 1, 4, 2),
(4, 'wakanda', '2018-04-26 18:32:45', NULL, 1, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `use_id` int(11) NOT NULL,
  `use_login` varchar(255) NOT NULL,
  `use_password` varchar(255) NOT NULL,
  `use_role` varchar(255) DEFAULT 'ROLE_USER',
  `use_last_login` datetime NOT NULL,
  `use_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`use_id`, `use_login`, `use_password`, `use_role`, `use_last_login`, `use_created`) VALUES
(1, 'admin', 'admin', 'ROLE_USER, ROLE_MANAGER, ROLE_ADMIN', '2018-04-10 00:00:00', '2018-04-10 00:00:00'),
(2, 'manager', 'manager', 'ROLE_USER, ROLE_MANAGER', '2018-04-10 00:00:00', '2018-04-10 00:00:00'),
(3, 'user1', 'user1', 'ROLE_USER', '2018-04-10 00:00:00', '2018-04-10 00:00:00'),
(4, 'user2', 'user2', 'ROLE_USER', '2018-04-10 00:00:00', '2018-04-10 00:00:00'),
(5, 'user3', 'user3', 'ROLE_USER', '2018-04-10 00:00:00', '2018-04-10 00:00:00'),
(14, 'lilian', '$2y$10$4z9aDZk0JBuwH6zRvo', 'ROLE_USER', '0000-00-00 00:00:00', '2018-04-17 17:01:01'),
(15, 'alex', '$2y$10$Om343Qh9t8H1a9WDZdmI7.NUqPhYMK3kzKbPMqUDkQn7Jw13/KVjO', 'ROLE_USER', '2019-03-31 13:04:03', '2018-04-17 17:13:34'),
(17, 'chloé', '$2y$10$tJhd/ztPb7hfiWtxUCLFNOFHJ2lyKKDuansrYY96w7SYZET2c1USq', 'ROLE_USER', '2018-04-18 16:33:48', '2018-04-17 17:15:44'),
(19, 'admine', '$2y$10$TbMLu6WQzs2siSCMPetuKuczNfXgHM20Y7g86//cvHHl2r02k6kjy', 'ROLE_USER, ROLE_MANAGER, ROLE_ADMIN', '2018-04-18 16:36:18', '2018-04-18 15:43:03'),
(21, 'louis', '$2y$10$1tlapEPepXTFzutPkpX3ReWJ5DbzqlEwxoEAJJbH8E6pa8BbgAJY.', 'ROLE_USER', '0000-00-00 00:00:00', '2018-04-18 16:02:21'),
(22, 'jean', '$2y$10$IEN5waXpfn1o5XKy9le8Ve1bvTg2xv8eDaji8U6BqFdvIcr0de83G', 'ROLE_USER', '0000-00-00 00:00:00', '2018-04-18 16:48:16'),
(23, 'lisa', '$2y$10$PjrnpdmZePUGNtWJbj5RqOK4.km/aDA8txqvj22bPfCd/hjPZtffy', 'ROLE_USER, ROLE_MANAGER', '2018-10-21 16:28:50', '2018-04-18 16:49:07'),
(24, 'admine2', '$2y$10$2a3djKkANUxcK7cu0yzQoeGs4sGq0NesaIX.a80ATjFWmHxYfSp/.', 'ROLE_USER, ROLE_MANAGER, ROLE_ADMIN', '0000-00-00 00:00:00', '2018-04-18 16:49:38'),
(26, 'maurice', '$2y$10$TD.Ae4cDJA5PxV3UuW7.IeGunqkqZV3k8249FOida81eTMLqknTQ2', 'ROLE_USER', '2019-03-31 13:06:40', '2019-03-31 13:06:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`art_id`),
  ADD KEY `FK_article_use_id` (`use_id`);

--
-- Indexes for table `article_tag`
--
ALTER TABLE `article_tag`
  ADD PRIMARY KEY (`art_id`,`tag_id`),
  ADD KEY `FK_article_tag_id` (`tag_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `FK_comment_art_id` (`art_id`),
  ADD KEY `FK_comment_use_id` (`use_id`),
  ADD KEY `FK_comment_com_id_1` (`com_id_1`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`pos_id`),
  ADD KEY `FK_post_use_id` (`use_id`),
  ADD KEY `FK_post_top_id` (`top_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`the_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`top_id`),
  ADD KEY `FK_topic_use_id` (`use_id`),
  ADD KEY `FK_topic_the_id` (`the_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`use_id`),
  ADD UNIQUE KEY `use_login` (`use_login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `the_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `top_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `use_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_article_use_id` FOREIGN KEY (`use_id`) REFERENCES `user` (`use_id`);

--
-- Constraints for table `article_tag`
--
ALTER TABLE `article_tag`
  ADD CONSTRAINT `FK_article_tag_art_id` FOREIGN KEY (`art_id`) REFERENCES `article` (`art_id`),
  ADD CONSTRAINT `FK_article_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_comment_art_id` FOREIGN KEY (`art_id`) REFERENCES `article` (`art_id`),
  ADD CONSTRAINT `FK_comment_com_id_1` FOREIGN KEY (`com_id_1`) REFERENCES `comment` (`com_id`),
  ADD CONSTRAINT `FK_comment_use_id` FOREIGN KEY (`use_id`) REFERENCES `user` (`use_id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_post_top_id` FOREIGN KEY (`top_id`) REFERENCES `topic` (`top_id`),
  ADD CONSTRAINT `FK_post_use_id` FOREIGN KEY (`use_id`) REFERENCES `user` (`use_id`);

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_topic_the_id` FOREIGN KEY (`the_id`) REFERENCES `theme` (`the_id`),
  ADD CONSTRAINT `FK_topic_use_id` FOREIGN KEY (`use_id`) REFERENCES `user` (`use_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
