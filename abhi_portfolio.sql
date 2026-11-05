-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2026 at 01:24 PM
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
-- Database: `abhi_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`) VALUES
(1, 'admin1234@gmail.com', '$2y$10$8RbuIrHHKwHroFo1N1uw4OiEycH4NaLx4hCKD2.yuvyIJLB7cJmgu');

-- --------------------------------------------------------

--
-- Table structure for table `contact_limits`
--

CREATE TABLE `contact_limits` (
  `ip_hash` char(64) NOT NULL,
  `last_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_limits`
--

INSERT INTO `contact_limits` (`ip_hash`, `last_at`) VALUES
('bc0dc5614a79e96cf9b3c5b7c733a11db2b7e6d009e77076cf72b54fa186cdbc', 1793881183);

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `role` varchar(120) NOT NULL,
  `company` varchar(120) NOT NULL DEFAULT '',
  `period` varchar(80) NOT NULL DEFAULT '',
  `details` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `role`, `company`, `period`, `details`, `sort_order`) VALUES
(1, 'Web Developer', 'Bhaum Technologies', '9 Months', 'Details:\r\n\r\nWeb Developer at Bhaum Technologies, worked for 8 months.\r\n\r\n- Developed and maintained responsive websites using HTML, CSS, JavaScript, PHP, and MySQL.\r\n- Worked on website design, UI improvements, and mobile responsiveness.\r\n- Fixed bugs, optimized website performance, and improved user experience.\r\n- Integrated frontend designs with backend functionality.\r\n- Worked on existing websites and implemented new features as per project requirements.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`) VALUES
(1, 'Abhi Web', 'abhiweb.69@gmail.com', '07701978243', 'for website', 'sasdsaasdasdas', '2026-11-05 12:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `category` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `tech` varchar(255) NOT NULL DEFAULT '',
  `live_url` varchar(255) NOT NULL DEFAULT '',
  `screenshot` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `category`, `description`, `tech`, `live_url`, `screenshot`, `sort_order`) VALUES
(1, 'Vedayur Healthcare', 'Healthcare Website', 'Healthcare website development, enquiry forms, PHP integration, hosting and email configuration.', 'PHP', 'https://vedayurhealthcare.com/', '', 1),
(2, 'Eagletfly', 'Education / Institute Website', 'Institute website development, admin panel, course management, banner management, video management and database integration.', '', 'https://eagletflysolutions.com/', '', 2),
(3, 'Prudentia Learning', 'Learning Platform', 'Landing page development, deck page development and UI improvements.', '', '', '', 3),
(4, 'King Digital', 'Business Website', 'Website development, UI improvements, URL rewriting, maintenance and technical troubleshooting.', '.htaccess', 'https://www.kingdigital.in/', '', 4),
(5, 'Shivam Uniform', 'E-commerce Website', 'E-commerce website development, product management, category management, image uploads and MySQL database operations.', 'MySQL', 'https://shivamuniform.com/', '', 5),
(6, 'Groom Car', 'Car Rental Website', 'Website project.', '', 'https://www.groomcar.co.in/', '', 6),
(7, 'Daur Productions', 'Creative Production Website', 'Website project.', '', 'https://daurproductions.com/', '', 7),
(8, 'PythonAnywhere Web Application', 'Python Web Application', 'Web application hosted on PythonAnywhere. Framework and features to be confirmed.', 'Python', 'https://abhicuckoo404.pythonanywhere.com/', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `sort_order`) VALUES
(1, 'Website Design', 1),
(2, 'Frontend Development', 2),
(3, 'PHP Development', 3),
(4, 'Python Development', 4),
(5, 'Flask & Django Development', 5),
(6, 'API & REST API Development', 6),
(7, 'Database Management', 7),
(8, 'E-commerce Development', 8),
(9, 'Admin Panel Development', 9),
(10, 'Website Maintenance', 10),
(11, 'Hosting & Deployment', 11);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `skey` varchar(50) NOT NULL,
  `svalue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`skey`, `svalue`) VALUES
('about', 'I am a Web Designer and Full-Stack Web Developer with practical experience in designing, developing, maintaining and deploying responsive, dynamic websites. My work covers the frontend, databases, APIs, admin panels, e-commerce features, hosting, server configuration and website maintenance.'),
('backend_text', 'I work with PHP and Python for backend development and build web applications with Flask and Django. I also work on REST API development, API integration, authentication, testing, management and documentation.'),
('cv_url', ''),
('email', ''),
('github', ''),
('hero_heading', 'Building modern websites and powerful web applications'),
('hero_stack', 'PHP,Python,Flask,Django,MySQL,REST APIs'),
('hero_sub', 'Full-Stack Web Developer & Web Designer specializing in PHP, Python, Flask, Django, REST APIs and responsive web development.'),
('linkedin', ''),
('name', 'Abhi'),
('phone', ''),
('site_description', 'Portfolio of Abhi, a Full-Stack Web Developer and Web Designer working with PHP, Python, Flask, Django and REST APIs.'),
('title', 'Full-Stack Web Developer & Web Designer');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `category` varchar(80) NOT NULL,
  `name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `category`, `name`) VALUES
(1, 'Languages', 'PHP'),
(2, 'Languages', 'Python'),
(3, 'Languages', 'C'),
(4, 'Languages', 'C++'),
(5, 'Languages', 'JavaScript'),
(6, 'Languages', 'SQL'),
(7, 'Frontend', 'HTML5'),
(8, 'Frontend', 'CSS3'),
(9, 'Frontend', 'Bootstrap'),
(10, 'Frontend', 'Responsive Web Design'),
(11, 'API & Backend', 'Flask'),
(12, 'API & Backend', 'Django'),
(13, 'API & Backend', 'REST API Development'),
(14, 'API & Backend', 'API Integration'),
(15, 'Database', 'MySQL'),
(16, 'Database', 'SQL'),
(17, 'Tools & Hosting', 'Git'),
(18, 'Tools & Hosting', 'GitHub'),
(19, 'Tools & Hosting', 'cPanel'),
(20, 'Tools & Hosting', 'FastPanel'),
(21, 'Tools & Hosting', 'XAMPP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_limits`
--
ALTER TABLE `contact_limits`
  ADD PRIMARY KEY (`ip_hash`);

--
-- Indexes for table `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`skey`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
