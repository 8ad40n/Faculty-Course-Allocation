-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 04:38 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` varchar(10) NOT NULL,
  `AdminName` varchar(15) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `Email`) VALUES
('21-45390-3', 'Badhon Nath Joy', 'bnathjoy@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` varchar(10) NOT NULL,
  `CourseName` varchar(40) NOT NULL,
  `DepartmentName` varchar(10) NOT NULL,
  `Credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `DepartmentName`, `Credit`) VALUES
('BAE2101', 'COMPUTER AIDED DESIGN & DRAFTING', 'CSE', 1),
('CSC1101', 'INTRODUCTION TO COMPUTER STUDIES', 'CSE', 1),
('CSC1103', 'INTRODUCTION TO PROGRAMMING', 'CSE', 3),
('CSC1204', 'DISCRETE MATHEMATICS', 'CSE', 3),
('CSC1205', 'OBJECT ORIENTED PROGRAMMING 1', 'CSE', 3),
('CSC2106', 'DATA STRUCTURE', 'CSE', 3),
('CSC2210', 'OBJECT ORIENTED PROGRAMMING 2', 'CSE', 3),
('CSC2211', 'ALGORITHMS', 'CSE', 3),
('CSC3112', 'SOFTWARE ENGINEERING', 'CSE', 3),
('CSC3215', 'WEB TECHNOLOGIES', 'CSE', 3),
('CSC4118', 'COMPUTER GRAPHICS', 'CSE', 3),
('ENG1202', 'ENGLISH WRITING SKILLS & COMMUNICATIONS', 'CSE', 3),
('PHY1203', 'PHYSICS 2', 'CSE', 3);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepartmentName` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepartmentName`) VALUES
('CSE');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `FacultyID` varchar(10) NOT NULL,
  `FacultyName` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `FacultyName`, `Email`) VALUES
('Akib1234', 'Akib Shahriar ', 'mls@gmail.com'),
('logno1234', 'Hasin Anjum Logno', 'hal@gmail.com'),
('Maria123', 'Maria Nawar', 'mn@gmail.com'),
('subrina123', 'Subrina Islam Prity', 'sip@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `prioritycourses`
--

CREATE TABLE `prioritycourses` (
  `FacultyID` varchar(10) NOT NULL,
  `CourseID` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prioritycourses`
--

INSERT INTO `prioritycourses` (`FacultyID`, `CourseID`) VALUES
('Akib1234', 'CSC2106'),
('logno1234', 'CSC3112'),
('Maria123', 'CSC2211');

-- --------------------------------------------------------

--
-- Table structure for table `prioritytime`
--

CREATE TABLE `prioritytime` (
  `FacultyID` varchar(10) NOT NULL,
  `Day` varchar(15) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prioritytime`
--

INSERT INTO `prioritytime` (`FacultyID`, `Day`, `startTime`, `endTime`) VALUES
('Maria123', 'Sunday', '08:00:00', '14:00:00'),
('logno1234', 'Wednesday', '09:30:00', '17:00:00'),
('Akib1234', 'Thursday', '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `SectionID` varchar(10) NOT NULL,
  `CourseID` varchar(15) NOT NULL,
  `Sec` varchar(5) NOT NULL,
  `Day` varchar(10) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time DEFAULT NULL,
  `FacultyID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`SectionID`, `CourseID`, `Sec`, `Day`, `startTime`, `endTime`, `FacultyID`) VALUES
('oop1A', 'CSC1205', 'A', 'Sunday', '08:00:00', '11:00:00', NULL),
('oop1A', 'CSC1205', 'A', 'Tuesday', '08:00:00', '10:00:00', NULL),
('oop2A', 'CSC2210', 'A', 'Monday', '11:00:00', '14:00:00', NULL),
('oop2A', 'CSC2210', 'A', 'Wednesday', '12:00:00', '14:00:00', NULL),
('wtA', 'CSC3215', 'A', 'Monday', '11:00:00', '14:00:00', NULL),
('wtA', 'CSC3215', 'A', 'Wednesday', '12:00:00', '14:00:00', NULL),
('algoC', 'CSC2211', 'C', 'Sunday', '08:00:00', '11:00:00', 'Maria123'),
('algoC', 'CSC2211', 'C', 'Tuesday', '08:00:00', '10:00:00', 'Maria123'),
('ipF', 'CSC1103', 'F', 'Monday', '14:00:00', '15:30:00', NULL),
('ipF', 'CSC1103', 'F', 'Wednesday', '14:00:00', '15:30:00', NULL),
('dsE', 'CSC2106', 'E', 'Sunday', '11:00:00', '12:30:00', 'Akib1234'),
('dsE', 'CSC2106', 'E', 'Tuesday', '11:00:00', '12:30:00', 'Akib1234'),
('dsG', 'CSC2106', 'G', 'Monday', '08:00:00', '09:30:00', 'Akib1234'),
('dsG', 'CSC2106', 'G', 'Wednesday', '08:00:00', '09:30:00', 'Akib1234'),
('cgH', 'CSC4118', 'H', 'Sunday', '14:00:00', '16:00:00', NULL),
('cgH', 'CSC4118', 'H', 'Tuesday', '14:00:00', '17:00:00', NULL),
('cgB', 'CSC4118', 'B', 'Monday', '08:00:00', '11:00:00', NULL),
('cgB', 'CSC4118', 'B', 'Wednesday', '08:00:00', '10:00:00', NULL),
('icsC', 'CSC1101', 'C', 'Monday', '08:00:00', '11:00:00', NULL),
('icsF', 'CSC1101', 'F', 'Tuesday', '14:00:00', '17:00:00', NULL),
('dmH', 'CSC1204', 'H', 'Monday', '11:00:00', '12:30:00', NULL),
('dmH', 'CSC1204', 'H', 'Wednesday', '11:00:00', '12:30:00', NULL),
('dmA', 'CSC1204', 'A', 'Monday', '08:00:00', '09:30:00', NULL),
('dmA', 'CSC1204', 'A', 'Wednesday', '08:00:00', '09:30:00', NULL),
('sweB', 'CSC3112', 'B', 'Sunday', '08:00:00', '10:00:00', 'logno1234'),
('sweB', 'CSC3112', 'B', 'Tuesday', '08:00:00', '11:00:00', 'logno1234'),
('cadC', 'BAE2101', 'C', 'Wednesday', '08:00:00', '11:00:00', NULL),
('cadD', 'BAE2101', 'D', 'Tuesday', '14:00:00', '17:00:00', NULL),
('sweD', 'CSC3112', 'D', 'Monday', '12:30:00', '14:00:00', 'logno1234'),
('sweD', 'CSC3112', 'D', 'Wednesday', '12:30:00', '14:00:00', 'logno1234'),
('phy2H', 'PHY1203', 'H', 'Sunday', '12:30:00', '14:00:00', NULL),
('phy2H', 'PHY1203', 'H', 'Tuesday', '12:30:00', '14:00:00', NULL),
('eng2A', 'ENG1202', 'A', 'Sunday', '11:00:00', '12:30:00', NULL),
('eng2A', 'ENG1202', 'A', 'Tuesday', '11:00:00', '12:30:00', NULL),
('icsA', 'CSC1101', 'A', 'Thursday', '08:00:00', '11:00:00', NULL),
('algoA', 'CSC2211', 'A', 'Sunday', '08:00:00', '10:00:00', NULL),
('algoA', 'CSC2211', 'A', 'Tuesday', '08:00:00', '11:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `ID` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`ID`, `Password`, `Type`) VALUES
('Akib1234', '1234', 'Faculty'),
('logno1234', '123', 'Faculty'),
('Maria123', '123', 'Faculty'),
('subrina123', '123', 'Faculty');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepartmentName`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FacultyID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
