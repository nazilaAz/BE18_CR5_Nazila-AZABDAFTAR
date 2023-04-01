-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 05:23 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be18_cr5_animal_adoption_nazila-azabdaftar`
--
CREATE DATABASE IF NOT EXISTS `be18_cr5_animal_adoption_nazila-azabdaftar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `be18_cr5_animal_adoption_nazila-azabdaftar`;

-- --------------------------------------------------------

--
-- Table structure for table `animal`
--

CREATE TABLE `animal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'Default-Empty',
  `picture` varchar(255) NOT NULL,
  `breed` varchar(255) DEFAULT NULL,
  `live` varchar(255) NOT NULL DEFAULT 'Default-Empty',
  `description` varchar(255) NOT NULL DEFAULT 'Default-Empty',
  `size` varchar(255) NOT NULL DEFAULT 'Default-Empty',
  `age` int(11) NOT NULL DEFAULT 0,
  `vaccinated` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animal`
--

INSERT INTO `animal` (`id`, `name`, `picture`, `breed`, `live`, `description`, `size`, `age`, `vaccinated`, `status`) VALUES
(3, 'Hund', '642839ae6cf0b.jpg', 'Haustier', '32072 Lake View Plaza', 'Unsp Escherichia coli as the cause of diseases classd elswhr', 'small', 6, 1, 1),
(4, 'cat', '64283a3349304.jpg', 'haustier', '4935 Granby Street', 'Displ commnt fx shaft of l fibula, init for opn fx type I/2', 'small', 5, 1, 1),
(5, 'Little brown bat', 'animalAvatar.jpg', '', '21 Emmet Plaza', 'Obesity, unspecified', 'Larg', 9, 1, 0),
(6, 'Suricate', 'animalAvatar.jpg', '', '26209 Bunker Hill Court', 'Occupant specl indust veh injured in transport accident', 'Larg', 9, 1, 0),
(7, 'Red squirrel', 'animalAvatar.jpg', '', '0800 Jackson Center', 'Unspecified mononeuropathy of lower limb', 'Larg', 9, 1, 1),
(8, 'Masked booby', 'animalAvatar.jpg', '', '11372 Sullivan Crossing', 'Sprain of interphalangeal joint of unsp thumb, sequela', 'Small', 5, 0, 1),
(9, 'Igel', 'animalAvatar.jpg', 'Saegetier', 'Wien 1030', 'Überall dieselbe alte Leier. Das Layout ist fertig.', 'Small', 1, 1, 1),
(10, 'Igel', 'animalAvatar.jpg', 'Saegetier', 'Wien 1030', 'Überall dieselbe alte Leier. Das Layout ist fertig.', 'Larg', 1, 0, 0),
(11, 'Katze', '6428289846794.jpg', 'Haustier', 'Wien 1090', 'Sint id esse expedit', 'Small', 3, 1, 1),
(12, 'Bulldogge', '6428476adc236.jpg', 'Bulldogge', '1150 Wien', 'Image is corected', 'Larg', 10, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `fk_userid` int(11) NOT NULL,
  `fk_animalid` int(11) NOT NULL,
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`, `phone_number`, `address`, `picture`, `status`) VALUES
(1, 'Nazila', 'Azabdaftar', 'azabdafta@outlook.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '123123', 'Roesslergasse 9', 'userAvatar.png', 'admin'),
(2, 'test', 'user', 'test@test.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '123123', 'roesslergasse', 'userAvatar.png', 'user'),
(3, 'newUser', 'newUser', 'newuser@test.com', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '123123', 'Wien', '642849065cf85.jpg', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userid` (`fk_userid`),
  ADD KEY `fk_animalid` (`fk_animalid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animal`
--
ALTER TABLE `animal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
