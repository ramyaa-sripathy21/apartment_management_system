-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 06:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apartmentmanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Admin_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Admin_ID`, `Name`, `Username`, `Password`) VALUES
(1, 'Admin User', 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `apartment`
--

CREATE TABLE `apartment` (
  `Apartment_No` int(11) NOT NULL,
  `Floor_No` int(11) DEFAULT NULL,
  `Rent_Amount` decimal(10,2) DEFAULT NULL,
  `Availability_Status` enum('Available','Occupied') DEFAULT 'Available',
  `Tenant_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartment`
--

INSERT INTO `apartment` (`Apartment_No`, `Floor_No`, `Rent_Amount`, `Availability_Status`, `Tenant_ID`) VALUES
(1, 2, 5000.00, 'Available', NULL),
(3, 104, 15000.00, 'Occupied', NULL),
(4, 152, 2000.00, 'Occupied', NULL),
(8, 5, 2000.00, 'Available', NULL),
(101, 1, 1200.00, 'Occupied', NULL),
(102, 1, 1500.00, 'Occupied', 1),
(103, 2, 1800.00, 'Occupied', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `Request_ID` int(11) NOT NULL,
  `Tenant_ID` int(11) DEFAULT NULL,
  `Apartment_No` int(11) DEFAULT NULL,
  `Request_Date` date DEFAULT NULL,
  `Issue_Description` text DEFAULT NULL,
  `Status` enum('Pending','Resolved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`Request_ID`, `Tenant_ID`, `Apartment_No`, `Request_Date`, `Issue_Description`, `Status`) VALUES
(3, 1, 8, '2025-01-04', 'no', ''),
(4, 1, 8, '2025-01-04', 'no', '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Tenant_ID` int(11) DEFAULT NULL,
  `Payment_Amount` decimal(10,2) DEFAULT NULL,
  `Payment_Date` date DEFAULT NULL,
  `Payment_Status` enum('Paid','Unpaid') DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`Payment_ID`, `Tenant_ID`, `Payment_Amount`, `Payment_Date`, `Payment_Status`) VALUES
(1, 1, 1200.00, '2023-01-10', 'Paid'),
(2, 2, 1500.00, '2023-03-05', 'Paid'),
(3, 1, 5555.00, '2025-01-12', ''),
(4, 1, 5555.00, '2025-01-12', ''),
(5, 1, 5555.00, '2025-01-12', '');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `Tenant_ID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Contact_Info` varchar(100) DEFAULT NULL,
  `Lease_Start_Date` date DEFAULT NULL,
  `Lease_End_Date` date DEFAULT NULL,
  `Login_Username` varchar(50) DEFAULT NULL,
  `Login_Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`Tenant_ID`, `Name`, `Contact_Info`, `Lease_Start_Date`, `Lease_End_Date`, `Login_Username`, `Login_Password`) VALUES
(1, 'John Doe', '123-456-7890', '2023-01-01', '2024-01-01', 'johndoe', 'password123'),
(2, 'Jane Smith', '234-567-8901', '2023-03-01', '2024-03-01', 'janesmith', 'password456'),
(3, 'Seena', '9632912346', '2025-01-04', '2025-01-26', 'admin@gmail.com', 'admin'),
(4, 'praveen', '9632912346', '2025-01-18', '2025-01-17', NULL, NULL),
(5, 'praveen', '9632912346', '2025-01-18', '2025-01-17', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Admin_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `apartment`
--
ALTER TABLE `apartment`
  ADD PRIMARY KEY (`Apartment_No`),
  ADD KEY `Tenant_ID` (`Tenant_ID`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `Tenant_ID` (`Tenant_ID`),
  ADD KEY `Apartment_No` (`Apartment_No`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Tenant_ID` (`Tenant_ID`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`Tenant_ID`),
  ADD UNIQUE KEY `Login_Username` (`Login_Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `Tenant_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apartment`
--
ALTER TABLE `apartment`
  ADD CONSTRAINT `apartment_ibfk_1` FOREIGN KEY (`Tenant_ID`) REFERENCES `tenant` (`Tenant_ID`);

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`Tenant_ID`) REFERENCES `tenant` (`Tenant_ID`),
  ADD CONSTRAINT `maintenance_ibfk_2` FOREIGN KEY (`Apartment_No`) REFERENCES `apartment` (`Apartment_No`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Tenant_ID`) REFERENCES `tenant` (`Tenant_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
