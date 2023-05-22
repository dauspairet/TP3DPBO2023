-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 12:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_wikianime`
--

-- --------------------------------------------------------

--
-- Table structure for table `anime`
--

CREATE TABLE `anime` (
  `anime_id` int(11) NOT NULL,
  `anime_foto` varchar(255) NOT NULL,
  `anime_title` varchar(255) NOT NULL,
  `anime_episode` int(15) NOT NULL,
  `anime_link` varchar(255) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `studio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anime`
--

INSERT INTO `anime` (`anime_id`, `anime_foto`, `anime_title`, `anime_episode`, `anime_link`, `genre_id`, `studio_id`) VALUES
(50, 'kubo1.jpg', 'Kubo Wont Let Me Be Invisible', 7, 'https://en.wikipedia.org/wiki/Kubo_Won%27t_Let_Me_Be_Invisible', 4, 12),
(51, 'jigokuraku.jpg', 'Hells Paradise Jigokuraku', 8, 'https://en.wikipedia.org/wiki/Hell%27s_Paradise:_Jigokuraku', 17, 3),
(52, 'IMG_20210114_062316.jpg', 'Chainsaw Man', 12, 'https://en.wikipedia.org/wiki/Chainsaw_Man', 21, 3),
(53, 'oshi.jpg', 'Oshi no Ko', 6, 'https://en.wikipedia.org/wiki/Oshi_no_Ko', 7, 13),
(54, 'saga.jpg', 'Vinland Saga', 43, 'https://en.wikipedia.org/wiki/Vinland_Saga_(manga)', 17, 3),
(55, 'kubo.jpg', 'Sasuke Arc', 321, 'https://en.wikipedia.org/wiki/Vinland_Saga_(manga)', 17, 12);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `jenis_genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre_id`, `jenis_genre`) VALUES
(4, 'Romance'),
(7, 'Drama'),
(8, 'Slice of life'),
(17, 'Action'),
(19, 'Fantasy'),
(20, 'Psychological'),
(21, 'Gore'),
(22, 'Thriller'),
(23, 'Comedy');

-- --------------------------------------------------------

--
-- Table structure for table `studio`
--

CREATE TABLE `studio` (
  `studio_id` int(11) NOT NULL,
  `nama_studio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studio`
--

INSERT INTO `studio` (`studio_id`, `nama_studio`) VALUES
(3, 'Mappa'),
(12, 'Pine Jam'),
(13, 'Doga Kobo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`anime_id`),
  ADD KEY `genre_id` (`genre_id`,`studio_id`),
  ADD KEY `studio_id` (`studio_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`studio_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anime`
--
ALTER TABLE `anime`
  MODIFY `anime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `studio`
--
ALTER TABLE `studio`
  MODIFY `studio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anime`
--
ALTER TABLE `anime`
  ADD CONSTRAINT `anime_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `anime_ibfk_2` FOREIGN KEY (`studio_id`) REFERENCES `studio` (`studio_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
