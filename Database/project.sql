-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2024 at 02:54 PM
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
  `Email` varchar(30) NOT NULL,
  `Picture` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `AdminName`, `Email`, `Picture`) VALUES
('21-45390-3', 'Badhon Nath Joy', 'bnathjoy@gmail.com', 'joy.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` varchar(10) NOT NULL,
  `CourseName` varchar(40) NOT NULL,
  `DepartmentName` varchar(10) NOT NULL,
  `Credit` int(11) DEFAULT NULL,
  `Type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `DepartmentName`, `Credit`, `Type`) VALUES
('CSC1103', 'Web', 'CSE', 3, 'Theory+Lab'),
('CSC2210', 'C#', 'CSE', 3, 'Theory+Lab'),
('CSC4197', 'AI', 'CSE', 3, 'Theory+Lab');

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
  `Email` varchar(30) NOT NULL,
  `Picture` varchar(100) DEFAULT NULL,
  `TotalHours` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `FacultyName`, `Email`, `Picture`, `TotalHours`) VALUES
('12-181-2', 'Alamin ', 'alamin@gmail.com', 'addSection.gif', 15),
('21-45388-3', 'hasib', 'joy184110@gmail.com', 'addCourse.jpg', 15),
('21-45555-3', 'tabin', 'tabin@gmail.com', 'AddFacutly.jpg', 10),
('23-3456-2', 'shafi', 'shafi@gmail.com', 'addCourse.jpg', 15);

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
('12-181-2', 'CSC1103'),
('21-45555-3', 'CSC4197'),
('21-45388-3', 'CSC2210');

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
('21-45555-3', 'Sunday', '08:00:00', '17:00:00'),
('12-181-2', 'Monday', '08:00:00', '17:00:00'),
('12-181-2', 'Sunday', '08:00:00', '17:00:00'),
('21-45555-3', 'Monday', '08:00:00', '17:00:00');

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
('webA', 'CSC1103', 'A', 'Sunday', '08:00:00', '11:00:00', '12-181-2'),
('webA', 'CSC1103', 'A', 'Tuesday', '08:00:00', '10:00:00', '12-181-2'),
('AIA', 'CSC4197', 'A', 'Sunday', '08:00:00', '11:00:00', '21-45555-3'),
('AIA', 'CSC4197', 'A', 'Tuesday', '08:00:00', '10:00:00', '21-45555-3'),
('AIB', 'CSC4197', 'B', 'Sunday', '08:00:00', '11:00:00', '23-3456-2'),
('AIB', 'CSC4197', 'B', 'Tuesday', '08:00:00', '10:00:00', '23-3456-2'),
('webB', 'CSC1103', 'B', 'Monday', '08:00:00', '11:00:00', '12-181-2'),
('webB', 'CSC1103', 'B', 'Wednesday', '08:00:00', '10:00:00', '12-181-2'),
('AIC', 'CSC4197', 'C', 'Monday', '14:00:00', '16:00:00', '21-45555-3'),
('AIC', 'CSC4197', 'C', 'Wednesday', '14:00:00', '17:00:00', '21-45555-3'),
('AID', 'CSC4197', 'D', 'Monday', '14:00:00', '17:00:00', '23-3456-2'),
('AID', 'CSC4197', 'D', 'Wednesday', '14:00:00', '16:00:00', '23-3456-2'),
('webC', 'CSC1103', 'C', 'Monday', '08:00:00', '10:00:00', '23-3456-2'),
('webC', 'CSC1103', 'C', 'Wednesday', '08:00:00', '11:00:00', '23-3456-2'),
('webF', 'CSC1103', 'F', 'Monday', '14:00:00', '17:00:00', '12-181-2'),
('webF', 'CSC1103', 'F', 'Wednesday', '14:00:00', '16:00:00', '12-181-2'),
('oop2A', 'CSC2210', 'A', 'Sunday', '11:00:00', '14:00:00', '21-45388-3'),
('oop2A', 'CSC2210', 'A', 'Tuesday', '12:00:00', '14:00:00', '21-45388-3'),
('oop2B', 'CSC2210', 'B', 'Monday', '08:00:00', '11:00:00', '21-45388-3'),
('oop2B', 'CSC2210', 'B', 'Wednesday', '08:00:00', '10:00:00', '21-45388-3'),
('oop2D', 'CSC2210', 'D', 'Sunday', '08:00:00', '11:00:00', '21-45388-3'),
('oop2D', 'CSC2210', 'D', 'Tuesday', '08:00:00', '10:00:00', '21-45388-3');

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
('12-181-2', '123', 'Faculty'),
('21-45388-3', '123', 'Faculty'),
('21-45390-3', '123', 'Admin'),
('21-45555-3', '123', 'Faculty'),
('23-3456-2', '123', 'Faculty');

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
