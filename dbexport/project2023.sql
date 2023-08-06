-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2023 at 03:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project2023`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `flg` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `name`, `email`, `pass`, `flg`, `created_date`, `updated_date`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2y$10$Z8bAnTwVv9tTzQlYNqVTi.0XRodYtSOLaohGNT/qo71Oqebz23SOq', 1, '2023-07-04 18:11:26', '2023-08-02 23:33:32'),
(2, 'test2', 'test2@gmail.com', '$2y$10$iXG.jAjsEBXp6/DE/u7rd.utU0D8FEWNXZBlBxXJGZqKNpLZoJ7Lm', 0, '2023-07-04 23:22:20', '2023-08-03 02:36:37'),
(3, 'test3', 'test3@gmail.com', '$2y$10$pODt7UgYcZ6cuB1txxSQ0ezXdFP8EkEvM4Q7W6Pr2Ii14SbTxvHQO', 1, '2023-07-07 12:38:06', '2023-08-06 13:10:50'),
(4, 'test4', 'test4@gmail.com', '$2y$10$tNlWEaUtsMYCLSCXiSzyb.enFq52mFUPv38CCwosSgJL9Vadfcp.q', 1, '2023-07-28 15:59:47', '2023-08-02 23:33:32'),
(5, 'mark', 'm@m.com', '$2y$10$N1LOLd3.EF.jB9VfmUCLpeTf96QVkmV4zg9A7XD8xEcssVy9YNFQW', 1, '2023-07-31 13:09:04', '2023-08-02 23:33:32'),
(6, 'mark', 'mm@m.com', '$2y$10$8h6ugI591uhqCg9rwiRlPu7asdmlH91QR07wKd99L32Q4z0K1w/ze', 1, '2023-07-31 13:10:04', '2023-08-02 23:33:32'),
(7, 'wan', 'wanpin77@gmail.com', '$2y$10$mSC4TzyWURrQ.zZX/2EA1OuTtYBQvDLciymWrPq5PZM8zH8mcfxbC', 1, '2023-07-31 13:49:33', '2023-08-02 23:33:32'),
(8, 'test5', 'test5@gmail.com', '$2y$10$jolFXattLiqvaUhgopJ4auhdeqMULb/qU9Wxy2wdMjWpIkyrCb8rS', 1, '2023-08-03 03:10:41', '2023-08-03 14:54:57'),
(9, 'Test', 'test@gmail.com', '$2y$10$NiZg4dUBZ98m2uWgffAzvuQlNw5JBO3Q0cCCpcKEXeXfa6.SnOT6C', 1, '2023-08-03 14:58:34', '2023-08-03 14:58:34'),
(10, 'SystemTest', 'systemtest@gmail.com', '$2y$10$3XXBBUa1mxoH3bFnAFF/7uWMWlE7X1wtQWenlrRMippg5Wr6mVCKm', 1, '2023-08-05 16:15:04', '2023-08-05 16:15:04'),
(11, 'test6', 'test6@gmail.com', '$2y$10$mM7B1.X5B.DwXpS7cC/aFemP7kJJnxNYC8AFpyp2o1u3ol3cOdvCO', 1, '2023-08-06 11:51:38', '2023-08-06 12:46:05'),
(12, 'test7', 'test7@gmail.com', '$2y$10$Rk7vRxGzfLD.y.vEj1axJuIgEQfnM.Ta3W8CbVPqu8qwN/7oK5FOC', 1, '2023-08-06 12:25:15', '2023-08-06 12:46:52'),
(13, 'TestUser', 'testuser@gmail.com', '$2y$10$PKDBBgBKeNmlAtVvdeBXHeLjZkvaBGYTZUmNeIBPBVFBql7Xvpu3a', 1, '2023-08-06 13:02:44', '2023-08-06 13:02:44');

-- --------------------------------------------------------

--
-- Table structure for table `mymap`
--

CREATE TABLE `mymap` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mymap`
--

INSERT INTO `mymap` (`id`, `user_id`, `site_id`, `created_date`, `updated_date`) VALUES
(1, 1, 1, '2023-07-15 03:44:19', '2023-07-15 03:44:19'),
(2, 1, 3, '2023-07-15 23:58:40', '2023-07-15 23:58:40'),
(5, 2, 1, '2023-07-18 15:37:40', '2023-07-18 15:37:40'),
(9, 1, 6, '2023-07-28 12:50:24', '2023-07-28 12:50:24'),
(11, 3, 2, '2023-07-28 16:13:45', '2023-07-28 16:13:45'),
(12, 6, 2, '2023-07-31 13:10:37', '2023-07-31 13:10:37'),
(13, 6, 7, '2023-07-31 13:11:46', '2023-07-31 13:11:46'),
(15, 7, 2, '2023-07-31 13:50:44', '2023-07-31 13:50:44'),
(16, 7, 9, '2023-07-31 13:52:37', '2023-07-31 13:52:37'),
(17, 3, 3, '2023-07-31 22:12:11', '2023-07-31 22:12:11'),
(18, 3, 6, '2023-07-31 22:12:22', '2023-07-31 22:12:22'),
(27, 13, 15, '2023-08-06 13:07:56', '2023-08-06 13:07:56'),
(29, 13, 3, '2023-08-06 13:08:23', '2023-08-06 13:08:23');

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `flg` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `latitude`, `longitude`, `name`, `description`, `image`, `user_id`, `flg`, `created_date`, `updated_date`) VALUES
(1, 53.6947, -6.47807, 'Newgrange', 'A 5,200 year old passage tomb.', 'site1.jpg\r\n', 3, 1, '2023-07-10 14:07:45', '2023-08-06 13:10:25'),
(2, 53.665, -6.59649, 'Hill of Tara', 'Hilltop archaeological site dating from the Iron Age, known as the seat of the High King of Ireland.', NULL, 2, 1, '2023-07-10 14:14:34', '2023-08-03 18:43:41'),
(3, 51.7711, -10.5399, 'Skellig Michael', 'An island monastery towering over the sea.', 'test.jpg', 3, 1, '2023-07-11 19:53:13', '2023-08-02 23:32:14'),
(4, 53.3268, -7.99903, 'Clonmacnoise', 'St Ciarán founded his monastery on the banks of the River Shannon in the 6th Century.', 'Clonmacnoise.jpg', 3, 1, '2023-08-05 19:54:24', '2023-08-05 19:54:24'),
(5, 53.0487, -9.14262, 'Poulnabrone Dolmen', 'Stone Age tomb marking a mass grave and built with huge rocks in a table formation.', 'Poulnabrone.jpg', 3, 1, '2023-08-05 19:56:50', '2023-08-05 19:56:50'),
(6, 53.0107, -6.32733, 'Glendalough', 'In the 6th century St. Kevin founded the monastery. The remains of this ‘Monastic City’, which are dotted across the glen, include a superb round tower, numerous medieval stone churches and some decorated crosses.', 'Glendalough.JPG', 3, 1, '2023-07-27 15:37:50', '2023-08-02 23:32:14'),
(7, 53.1995, -7.52726, 'Smth', 'I saw a monster here last night', 'IMG_20210609_153024_1.jpg', 6, 1, '2023-07-31 13:11:31', '2023-08-02 23:32:14'),
(8, 53.0938, -6.48236, 'wanted ', 'oneday', 'DSC_7277.JPG', 7, 1, '2023-07-31 13:51:19', '2023-08-02 23:32:14'),
(9, 53.0079, -6.91088, 'want to go', 'trouist', NULL, 7, 1, '2023-07-31 13:51:53', '2023-08-02 23:32:14'),
(10, 52.9462, -7.78406, 'Monaincha Church', 'Elarius founded an important monastery on this site in the 8th century.', 'Monaincha.jpg', 3, 1, '2023-08-05 20:05:02', '2023-08-05 20:05:02'),
(11, 51.9583, -10.2645, 'Leacanabuaile Ring Fort', 'This stone fort or cashel was built in the 9th or 10th century.', 'Leacanabuaile.jpg', 3, 1, '2023-08-05 20:05:02', '2023-08-05 20:05:02'),
(12, 52.9906, -9.21754, 'Kilfenora Cathedral', 'Kilfenora Cathedral is dedicated to St. Fachtnan, who founded an abbey here during the sixth century.', 'Kilfenora.jpg', 3, 1, '2023-08-05 20:05:02', '2023-08-05 20:05:02'),
(13, 53.8782, -7.98759, 'test', 'test', NULL, 2, 0, '2023-08-03 02:38:59', '2023-08-03 16:33:53'),
(14, 53.6055, -8.27085, 'Test site changed', 'Test description changed', 'test image2.JPG', 9, 1, '2023-08-03 19:47:27', '2023-08-03 20:10:14'),
(15, 53.0639, -9.51659, 'Teampall Caomhán', 'Teampall Caomhán dating from the 10th century is located opposite the airstrip on Inis Oírr, in the island’s graveyard.', 'Teampall.jpg', 3, 1, '2023-08-05 20:05:02', '2023-08-05 20:05:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mymap`
--
ALTER TABLE `mymap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mymap`
--
ALTER TABLE `mymap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
