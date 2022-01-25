-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 26, 2021 at 08:22 AM
-- Server version: 5.6.49-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edenjsailadventures`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `email`, `password`, `created_at`) VALUES
(1, 'edenjsailadventures1@gmail.com', '$2y$10$OtPhw.ztxux1jXwdIbxxkuGFTFpOYfDuyZf6ZJqsvAiR2k8t/LWZC', '2021-02-18 18:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `CabinNo` int(1) NOT NULL,
  `AdultNo` int(1) NOT NULL,
  `ChildNo` int(1) NOT NULL,
  `trip_message` varchar(255) DEFAULT NULL,
  `total_price` varchar(100) NOT NULL,
  `TripID` int(11) NOT NULL,
  `CustomerID` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `CabinNo`, `AdultNo`, `ChildNo`, `trip_message`, `total_price`, `TripID`, `CustomerID`, `created_at`) VALUES
(5, 1, 1, 0, '', '2500', 1, 'cn9vc2jr8v8ospn329euoabu74', '2021-02-17 15:13:11');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `DOB` date NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `firstname`, `lastname`, `DOB`, `nationality`, `email`, `phone`, `password`, `created_at`) VALUES
(3, 'Tyra', 'Shields', '1989-10-02', 'Italian', 'tyra-shields@gmail.com', '+39 215 255 1641', '$2y$10$u6ZbeJ7OAmnuFfwIYFRE9OjZBGOoWJ4HnRUA5QavjxAMjYU6kbSPi', '2020-10-02 09:24:25'),
(5, 'Cory', 'Gibes', '1996-10-17', 'Spanish', 'corygibes@outlook.com', '+34 333 936 1432', '$2y$10$YLD2Py8UPuZSzs.5qbXr8OUljscVhj2F.co4W4LJCG0YG7Q8Bvivu', '2020-10-12 21:03:38'),
(6, 'Natalie', 'Fern', '1978-03-08', 'French', 'natalie-fern@hotmail.com', '+33 456 543 4521', '$2y$10$FZCQxlSm1EVcyxRq99mD6eguvyJg7zngyDPShgkwr8AcDYyM8eLf2', '2020-10-13 08:36:07'),
(7, 'Edna', 'Miceli', '1987-07-26', 'British', 'edna.miceli@gmail.com', '+44 339 317 6569', '$2y$10$LEx2H6FWnjQNHOYXEc5Iy.xNCiB6He6mGo8WEkfxCLdRXZhH2J93i', '2020-10-13 09:05:08'),
(8, 'Giovanni', 'Del Bronte', '2020-10-01', 'Italian', 'giovannidelbronte@hotmail.it', '+39 333 935 3451', '$2y$10$uDnP.jRpYeUlhR6LJIivBeAA/Kl/RBd9K0uOVuG9XWbsQg5TUD5xS', '2020-10-18 19:45:16'),
(9, 'Liang', 'Ning', '1993-09-15', 'Chinese', 'liang-ning@gmail.com', '+86 213 935 1498', '$2y$10$uDnP.jRpYeUlhR6LJIivBeAA/Kl/RBd9K0uOVuG9XWbsQg5TUD5xS', '2020-10-18 19:45:16'),
(12, 'Alessandro', 'Cenerini', '1965-12-21', 'Italian', 'alessandro.cenerini@outlook.com', '+39 331 456 2178', '$2y$10$uDnP.jRpYeUlhR6LJIivBeAA/Kl/RBd9K0uOVuG9XWbsQg5TUD5xS', '2021-02-24 19:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `enquire`
--

CREATE TABLE `enquire` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `details` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enquire`
--

INSERT INTO `enquire` (`id`, `name`, `email`, `phone`, `details`) VALUES
(3, 'John', 'johngibes@gmail.com', '+33 348 280 3465', 'I would like to rent the ITA 14.99 for 7 days on the 14th of August 2021. There will be 4 people on board. Regarding the location, we would like to go to Mykonos since I saw from the itinerary that you are in Greece in August. Let me know if you are available. Thank you.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `amount_payed` varchar(100) DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resetpasswords`
--

CREATE TABLE `resetpasswords` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(11) NOT NULL,
  `ratedIndex` tinyint(4) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `ratedIndex`, `comment`, `CustomerID`, `created_at`) VALUES
(31, 5, 'I want to personally thank Daniele and Ellina for hosting us on board of Edenj. An amazing luxury sailing catamaran which brought us to many beautiful locations. Perfect experience!', 2, '2021-02-18 17:59:52');

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `TripID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `departure_location` varchar(255) DEFAULT NULL,
  `arrival_location` varchar(255) DEFAULT NULL,
  `state_booking` varchar(10) DEFAULT NULL,
  `event_description` varchar(999) NOT NULL,
  `trip_price` varchar(50) NOT NULL,
  `trip_image` varchar(255) NOT NULL,
  `trip_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`TripID`, `title`, `start_event`, `end_event`, `departure_location`, `arrival_location`, `state_booking`, `event_description`, `trip_price`, `trip_image`, `trip_code`) VALUES
(1, '7 days in the islands of Mamma Mia', '2021-06-01 00:00:00', '2021-06-08 00:00:00', 'Skopelos', 'Vis', 'available', 'The best way to arrive in Greece if you plan on checking out film locations for \"Mamma Mia!\"', '2500', 'img/samplelandscapes.png', 'p1000'),
(2, '7 days in the magnificent island of Corfu, Greece', '2020-08-01 00:00:00', '2020-08-07 00:00:00', 'Corfu', 'Corfu', 'available', 'The island of Curfu hosts incredible landscapes and local Greek cuisine. It is one of the most splendid islands in Greece to visit.', '2000', 'img/Sample%20landscapes%204.jpg', 'p1001'),
(3, 'Trip to La Grande-Motte', '2021-05-01 00:00:00', '2021-05-15 00:00:00', 'Loano', 'La Grande-Motte', 'available', 'Our catamaran will travel the coast of Italy, passing by Sicily and Liguria to arrive at La Gran Motte at the end of the trip.', '2500', 'img/lagrandemotte.jpg', 'p1002'),
(4, 'Unforgettable vacation around the coast of Sicily', '2021-08-01 00:00:00', '2021-08-08 00:00:00', 'Catania (Port)', 'Palermo (Port)', 'available', 'An island as beautiful and historically rich as Sicily deserves to be experienced at a leisurely pace. This 15-day itinerary features beaches and cathedrals, fishing villages and urban markets, a volcano and ancient archaeological sites. Take your time as you circumnavigate this stunning region of Italy.', '3000', 'img/samplelandscapes2.png', 'p1003');

-- --------------------------------------------------------

--
-- Table structure for table `tripsorders`
--

CREATE TABLE `tripsorders` (
  `TripOrderID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `TripID` int(11) NOT NULL,
  `CabinNo` int(11) NOT NULL,
  `AdultNo` int(11) NOT NULL,
  `ChildNo` int(11) NOT NULL,
  `trip_message` varchar(255) NOT NULL,
  `total_price` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `trips1` (`TripID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `enquire`
--
ALTER TABLE `enquire`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `customers2` (`CustomerID`);

--
-- Indexes for table `resetpasswords`
--
ALTER TABLE `resetpasswords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`TripID`);

--
-- Indexes for table `tripsorders`
--
ALTER TABLE `tripsorders`
  ADD PRIMARY KEY (`TripOrderID`),
  ADD KEY `orders` (`OrderID`),
  ADD KEY `trips2` (`TripID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `enquire`
--
ALTER TABLE `enquire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `resetpasswords`
--
ALTER TABLE `resetpasswords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `TripID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tripsorders`
--
ALTER TABLE `tripsorders`
  MODIFY `TripOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `trips1` FOREIGN KEY (`TripID`) REFERENCES `trips` (`TripID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `customers2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);

--
-- Constraints for table `tripsorders`
--
ALTER TABLE `tripsorders`
  ADD CONSTRAINT `orders` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `trips2` FOREIGN KEY (`TripID`) REFERENCES `trips` (`TripID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
