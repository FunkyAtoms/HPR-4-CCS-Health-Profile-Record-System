-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 10:44 AM
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
-- Database: `employeemanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `basicinformation`
--

CREATE TABLE `basicinformation` (
  `EmployeeID` int(11) NOT NULL,
  `LastName` varchar(100) DEFAULT NULL,
  `FirstName` varchar(100) DEFAULT NULL,
  `MiddleInitial` char(1) DEFAULT NULL,
  `Position` varchar(100) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `CivilStatus` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Height` float DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `FoodAllergies` varchar(255) DEFAULT NULL,
  `ContactNumber` varchar(15) DEFAULT NULL,
  `EmergencyContactPerson` varchar(100) DEFAULT NULL,
  `EmergencyContactRelationship` varchar(50) DEFAULT NULL,
  `EmergencyContactNumber` varchar(15) DEFAULT NULL,
  `ProfileImagePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basicinformation`
--

INSERT INTO `basicinformation` (`EmployeeID`, `LastName`, `FirstName`, `MiddleInitial`, `Position`, `Birthdate`, `Age`, `Gender`, `CivilStatus`, `Address`, `Height`, `Weight`, `FoodAllergies`, `ContactNumber`, `EmergencyContactPerson`, `EmergencyContactRelationship`, `EmergencyContactNumber`, `ProfileImagePath`) VALUES
(2, 'Kaino', 'Lillianne', 'B', 'Teacher', '1986-10-17', 38, 'Female', 'Married', 'Sesamee Street', 4.78, 66, 'None', '88274772661', 'Mike', 'Husband', '454286656123', 'uploads/1672484175911.jpg'),
(5, 'Hermes', 'Danny', 'G', 'Teacher', '1991-09-13', 33, 'Male', 'Married', 'Sesame Street', 5.74, 78, 'Peanuts', '244514545', 'Maine', 'Wife', '45435354', 'uploads/Snapinst.app_476488991_17943110864949661_4900735139345981478_n_1080.jpg'),
(7, 'Qi', 'Wu', 'L', 'Teacher', '2004-02-11', 21, 'Male', 'Single', 'Chicken Island', 5.63, 64, 'None', '77777', 'Mei Hua', 'Partner', '133244426567', 'uploads/sangermain.png'),
(13, 'Mei', 'Hua', 'C', 'Teacher', '2000-10-18', 24, 'Female', 'Single', 'Island', 4.86, 62, 'None', '7778352351', 'Wu Liu Qi', 'Partner', '77777', 'uploads/jep.png'),
(23, 'McQueen', 'Lucy', 'M', 'Teacher', '1997-10-21', 27, 'Female', 'Married', '1231231', 5.3, 56, 'None', '9279765691', 'Light', 'Husband', '123456789', 'uploads/287c069a0eeaf41c8f3c250e43c30bba.jpg'),
(45, 'McQueen', 'Light', 'N', 'Teacher', '1997-02-18', 28, 'Male', 'Single', '66 Street', 5.33, 74, 'None', '123456789', 'Lucy', 'Wife', '9279765691', 'uploads/hiper.png'),
(2147483647, 'Po', 'Ram Jay', 'B', 'Teacher', '2004-09-04', 20, 'Male', 'Single', '123Street', 5.82, 63, 'None', '0995567282', 'Jack', 'Brother', '0923465712', 'uploads/idea.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comorbidities`
--

CREATE TABLE `comorbidities` (
  `ComorbidityID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `ComorbiditiesDetails` varchar(255) DEFAULT NULL,
  `MaintenanceMedication` enum('Yes','No') DEFAULT NULL,
  `MedicationAndDosage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comorbidities`
--

INSERT INTO `comorbidities` (`ComorbidityID`, `EmployeeID`, `ComorbiditiesDetails`, `MaintenanceMedication`, `MedicationAndDosage`) VALUES
(5, 2147483647, 'Tonsilitis', 'Yes', 'Paracetamol, 1 dose'),
(6, 2147483647, 'Dead', 'Yes', 'uh'),
(7, 13, 'Deafness', 'Yes', 'Hearing aids');

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE `operations` (
  `OperationID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `OperationName` varchar(255) DEFAULT NULL,
  `DatePerformed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operations`
--

INSERT INTO `operations` (`OperationID`, `EmployeeID`, `OperationName`, `DatePerformed`) VALUES
(6, 2147483647, 'Shoulder Surgery', '2023-06-14'),
(7, 2147483647, 'Knee Surgery', '2019-07-27'),
(8, 2147483647, 'Knee Surgery', '2017-03-09'),
(9, 2147483647, 'Eye surgery', '2023-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `schoolclinicrecord`
--

CREATE TABLE `schoolclinicrecord` (
  `RecordID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `VisitDate` date DEFAULT NULL,
  `Complaints` varchar(255) DEFAULT NULL,
  `Intervention` varchar(255) DEFAULT NULL,
  `NurseOnDuty` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `underwentsurgery`
--

CREATE TABLE `underwentsurgery` (
  `EmployeeID` int(11) NOT NULL,
  `HasUndergoneSurgery` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `underwentsurgery`
--

INSERT INTO `underwentsurgery` (`EmployeeID`, `HasUndergoneSurgery`) VALUES
(2, 'No'),
(5, 'Yes'),
(7, 'No'),
(13, 'No'),
(23, 'No'),
(45, 'No'),
(2147483647, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `withcomorbidities`
--

CREATE TABLE `withcomorbidities` (
  `EmployeeID` int(11) DEFAULT NULL,
  `HasComorbidities` enum('Yes','No') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withcomorbidities`
--

INSERT INTO `withcomorbidities` (`EmployeeID`, `HasComorbidities`) VALUES
(5, 'Yes'),
(2147483647, 'Yes'),
(2, 'No'),
(7, 'No'),
(13, 'Yes'),
(45, 'No'),
(23, 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basicinformation`
--
ALTER TABLE `basicinformation`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `comorbidities`
--
ALTER TABLE `comorbidities`
  ADD PRIMARY KEY (`ComorbidityID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`OperationID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `schoolclinicrecord`
--
ALTER TABLE `schoolclinicrecord`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- Indexes for table `underwentsurgery`
--
ALTER TABLE `underwentsurgery`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `withcomorbidities`
--
ALTER TABLE `withcomorbidities`
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basicinformation`
--
ALTER TABLE `basicinformation`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `comorbidities`
--
ALTER TABLE `comorbidities`
  MODIFY `ComorbidityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `OperationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schoolclinicrecord`
--
ALTER TABLE `schoolclinicrecord`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comorbidities`
--
ALTER TABLE `comorbidities`
  ADD CONSTRAINT `comorbidities_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `basicinformation` (`EmployeeID`) ON DELETE CASCADE;

--
-- Constraints for table `operations`
--
ALTER TABLE `operations`
  ADD CONSTRAINT `operations_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `basicinformation` (`EmployeeID`) ON DELETE CASCADE;

--
-- Constraints for table `schoolclinicrecord`
--
ALTER TABLE `schoolclinicrecord`
  ADD CONSTRAINT `schoolclinicrecord_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `basicinformation` (`EmployeeID`) ON DELETE CASCADE;

--
-- Constraints for table `underwentsurgery`
--
ALTER TABLE `underwentsurgery`
  ADD CONSTRAINT `underwentsurgery_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `basicinformation` (`EmployeeID`);

--
-- Constraints for table `withcomorbidities`
--
ALTER TABLE `withcomorbidities`
  ADD CONSTRAINT `withcomorbidities_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `basicinformation` (`EmployeeID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
