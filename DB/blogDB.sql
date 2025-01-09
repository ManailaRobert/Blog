-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 09, 2025 la 05:44 PM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `blog`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `accounts`
--

CREATE TABLE `accounts` (
  `accountID` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `profileImage` blob NOT NULL,
  `imageType` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `accounts`
--

INSERT INTO `accounts` (`accountID`, `username`, `password`, `role`, `profileImage`, `imageType`) VALUES
(1, 'account1', '1234', 'user', '', ''),
(2, 'account2', '1234', 'user', '', ''),
(3, 'admin', 'admin', 'admin', '', ''),
(5, 'account3', '1234', 'user', '', ''),
(6, 'user', 'user', 'user', '', '');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `category_Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `categories`
--

INSERT INTO `categories` (`categoryID`, `category_Name`) VALUES
(1, 'Sport'),
(2, 'IT'),
(3, 'Economy');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `postcomments`
--

CREATE TABLE `postcomments` (
  `postCommentID` int(11) NOT NULL,
  `accountID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `postcomments`
--

INSERT INTO `postcomments` (`postCommentID`, `accountID`, `postID`, `comment`, `date`) VALUES
(1, 1, 4, 'Random coment', '2024-12-29 12:31:40'),
(2, 2, 4, 'Random coment2', '2024-12-29 12:32:33'),
(3, 5, 3, 'test', '2024-12-29 20:28:47'),
(4, 5, 3, 'test', '2024-12-29 20:29:30'),
(5, 5, 3, 'test', '2024-12-29 20:32:37'),
(6, 3, 5, 'test', '2024-12-29 20:41:16'),
(7, 3, 5, 'test2', '2024-12-29 20:41:19'),
(8, 1, 12, 'Test comment', '2024-12-30 16:24:39'),
(9, 6, 13, 'Cool Post', '2025-01-08 15:14:25'),
(10, 3, 13, 'smth', '2025-01-09 13:48:24');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `posts`
--

CREATE TABLE `posts` (
  `postID` int(11) NOT NULL,
  `title` varchar(75) NOT NULL,
  `content` text NOT NULL,
  `accountID` int(11) NOT NULL,
  `datePosted` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categoryID` int(11) NOT NULL,
  `postStatus` varchar(10) NOT NULL DEFAULT 'activ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `posts`
--

INSERT INTO `posts` (`postID`, `title`, `content`, `accountID`, `datePosted`, `categoryID`, `postStatus`) VALUES
(1, 'Sport Category', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2024-12-16 15:55:15', 1, 'activ'),
(2, 'Sport Category 2 ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2024-12-17 15:55:15', 1, 'activ'),
(3, 'Sport Category 3 ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2024-12-29 15:55:15', 1, 'sters'),
(4, 'IT Title 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2024-12-13 15:55:15', 2, 'activ'),
(5, 'IT Title 2 Updated', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, '2024-12-30 14:29:49', 2, 'activ'),
(8, 'Test add SPORT post', 'dadwadda', 3, '2024-12-30 14:52:08', 1, 'activ'),
(9, 'Test add SPORT post', 'dwadadwadwada', 3, '2024-12-30 15:31:49', 1, 'sters'),
(10, 'IT Title 2 test adding updated', 'dasdsaasdadadsa', 3, '2024-12-30 15:31:08', 2, 'sters'),
(11, 'IT smth', 'Test', 3, '2024-12-30 15:33:53', 2, 'activ'),
(12, 'TEst 2 IT', 'dadwada', 3, '2024-12-30 15:34:10', 2, 'activ'),
(13, 'Economy TEST', 'TEST ECONOMY', 3, '2025-01-08 15:13:13', 3, 'activ'),
(14, 'Test Economy', 'dajbdjaigdahciaipcuaiwcbaica', 6, '2025-01-09 12:33:53', 3, 'activ'),
(15, 'IT smth', 'dadihapidhaoicap\r\nauocauuchaowica', 3, '2025-01-09 13:49:02', 2, 'activ');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexuri pentru tabele `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexuri pentru tabele `postcomments`
--
ALTER TABLE `postcomments`
  ADD PRIMARY KEY (`postCommentID`),
  ADD KEY `postRelationship` (`postID`),
  ADD KEY `accountRelationship` (`accountID`);

--
-- Indexuri pentru tabele `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `accountsRelationship` (`accountID`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pentru tabele `postcomments`
--
ALTER TABLE `postcomments`
  MODIFY `postCommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pentru tabele `posts`
--
ALTER TABLE `posts`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `postcomments`
--
ALTER TABLE `postcomments`
  ADD CONSTRAINT `accountRelationship` FOREIGN KEY (`accountID`) REFERENCES `accounts` (`accountID`),
  ADD CONSTRAINT `postRelationship` FOREIGN KEY (`postID`) REFERENCES `posts` (`postID`);

--
-- Constrângeri pentru tabele `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `accountsRelationship` FOREIGN KEY (`accountID`) REFERENCES `accounts` (`accountID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
