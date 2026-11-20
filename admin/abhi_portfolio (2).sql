-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2026 at 11:54 AM
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
(1, 'admin1234@gmail.com', '$2y$10$Uz.h7fUEVY7qR2dl.WTWAe1nlcR.rEDlGlLWjQ2TUFxTq9Iu8WdnS');

-- --------------------------------------------------------

--
-- Table structure for table `auth_ip_limits`
--

CREATE TABLE `auth_ip_limits` (
  `ip` varchar(45) NOT NULL,
  `failed_attempts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `first_failed_at` datetime DEFAULT NULL,
  `blocked_until` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_ip_limits`
--

INSERT INTO `auth_ip_limits` (`ip`, `failed_attempts`, `first_failed_at`, `blocked_until`, `updated_at`) VALUES
('::1', 0, NULL, NULL, '2026-11-20 05:20:56');

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
('bc0dc5614a79e96cf9b3c5b7c733a11db2b7e6d009e77076cf72b54fa186cdbc', 1795156156);

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
(1, 'Web Developer', 'Bhaum Technologies', '9 Months', 'Details:\r\n\r\nWeb Developer at Bhaum Technologies, worked for 8 months.\r\n\r\n- Developed and maintained responsive websites using HTML, CSS, JavaScript, PHP, and MySQL.\r\n- Worked on website design, UI improvements, and mobile responsiveness.\r\n- Fixed bugs, optimized website performance, and improved user experience.\r\n- Integrated frontend designs with backend functionality.\r\n- Worked on existing websites and implemented new features as per project requirements.', 1),
(2, 'Web Developer & Web Designer', 'King Digital', '4', 'I build and maintain their website.', 2);

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
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `category`, `description`, `tech`, `live_url`, `screenshot`, `sort_order`, `status`) VALUES
(1, 'Vedayur Healthcare', 'Healthcare Website', 'Healthcare website development, enquiry forms, PHP integration, hosting and email configuration.', 'Html , Css , Js , Api , Php , Tailwind Css', 'https://vedayurhealthcare.com/', 'assets/images/project_screenshots/53a494d0557b54f92db281311d992eaf.jpg', 2, 'Active'),
(2, 'Eagletfly', 'Education / Institute Website', 'Institute website development, admin panel, course management, banner management, video management and database integration.', '', 'https://eagletflysolutions.com/', 'assets/images/project_screenshots/fc4fbb1cd3c9424c0fb85b5e9454d36c.jpg', 2, 'Active'),
(3, 'Prudentia Learning', 'Learning Platform', 'Landing page development, deck page development and UI improvements.', 'Php ,  Bootstrap 5 ,  Swiper , Tailwind Css', 'https://prudentialearning.com/', 'assets/images/project_screenshots/a7577464b7e74ce8db8e46c0c9f36b24.png', 3, 'Active'),
(4, 'King Digital', 'Business Website , Marketing Website', 'Website development, UI improvements, URL rewriting, maintenance and technical troubleshooting. Digital Marketing, website development, enquiry forms, PHP integration, hosting and email configuration, Bulk SMS Service Provider', 'Php ,  Bootstrap 5 ,  Swiper , Tallwind Css , JS, Html , Css', 'https://www.kingdigital.in/', 'assets/images/project_screenshots/ee5be3c3d2048af5e4befee0ee5afec0.jpg', 4, 'Active'),
(5, 'Shivam Uniform', 'E-commerce Website', 'E-commerce website development, product management, category management, image uploads and MySQL database operations.', 'MySQL', 'https://shivamuniform.com/', 'assets/images/project_screenshots/0017e5147c6565ab0cfd4a9448cce852.png', 5, 'Active'),
(6, 'Groom Car', 'Car Rental Website', 'Website project. Wading Cars , Luxuries Cars, Classic Cars , Tours Cars.', 'Html , Css , Js , Api.', 'https://www.groomcar.co.in/', '', 6, 'Inactive'),
(7, 'Daur Productions', 'Creative Production Website', 'Daur Productions is an Indian production and localization company specializing in media production, voiceovers, script adaptation, and AI-driven video content \r\n\r\nCinematic Localization & Dubbing,\r\nAI Video Production,\r\nContact & Reach', 'Html , Css , Js , Api.', 'https://daurproductions.com/', '', 7, 'Active'),
(8, 'Hantriva', 'E-commerce.', 'Web application hosted on PythonAnywhere. Framework and features to be confirmed, Python , Jinja 2 , Html , Rest Api , Django , Css , Tailwind Css , Whatapps Api', 'Python', 'https://abhicuckoo404.pythonanywhere.com/', 'assets/images/project_screenshots/53a8247f7af33715fc97b9187a1afeb1.jpg', 8, 'Active'),
(11, 'Kalora', 'Jewellery , E-commerce', 'An online jewellery store under Kalora Fashion Pvt Ltd featuring demifine, gold, and fine silver pieces such as rings, bracelets, kadas, pendants, earrings, and mangalsutras.', 'Php ,  Bootstrap 5 ,  Swiper , Tallwind Css , JS, Html , Css', 'https://kalorashop.com/', 'assets/images/project_screenshots/11d3a17d4a4988d41e06085dd210b38f.png', 0, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `security_unblock_audit`
--

CREATE TABLE `security_unblock_audit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(45) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action` varchar(30) NOT NULL DEFAULT 'unblock',
  `note` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_unblock_audit`
--

INSERT INTO `security_unblock_audit` (`id`, `ip`, `admin_id`, `action`, `note`, `created_at`) VALUES
(1, '::1', 1, 'unblock', 'Manually unblocked from admin security page', '2026-11-19 12:52:39'),
(2, '::1', 1, 'unblock', 'Manually unblocked from admin security page', '2026-11-20 04:53:55');

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
('github', 'https://github.com/WHITEDEVILCUCKKOO'),
('hero_heading', 'Building modern websites and powerful web applications'),
('hero_stack', 'HTML 5 , Css , Java Script ,PHP,Python,Flask,Django,MySQL,REST APIs'),
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
(21, 'Tools & Hosting', 'XAMPP'),
(22, 'Tools & Hosting', 'Mpanel'),
(23, 'Backend', 'Python'),
(24, 'Backend', 'Php'),
(25, 'Backend', 'Php');

-- --------------------------------------------------------

--
-- Table structure for table `terminal_command_audit`
--

CREATE TABLE `terminal_command_audit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `ip` varchar(45) NOT NULL DEFAULT '',
  `command_text` varchar(500) NOT NULL DEFAULT '',
  `outcome` enum('success','failed','denied') NOT NULL DEFAULT 'failed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_command_audit`
--

INSERT INTO `terminal_command_audit` (`id`, `admin_id`, `username`, `ip`, `command_text`, `outcome`, `created_at`) VALUES
(1, 1, 'admin1234@gmail.com', '::1', 'users', 'success', '2026-11-19 12:24:21'),
(2, NULL, '', '::1', 'browser: help', 'success', '2026-11-19 12:52:33'),
(3, NULL, '', '::1', 'browser: ls', 'success', '2026-11-19 12:53:01'),
(4, NULL, '', '::1', 'browser: pwd', 'success', '2026-11-19 12:53:09'),
(5, NULL, '', '::1', 'browser: cd projects', 'failed', '2026-11-19 12:53:14'),
(6, NULL, '', '::1', 'browser: cd wrongfolder', 'failed', '2026-11-19 12:53:19'),
(7, NULL, '', '::1', 'browser: randomcommand', 'failed', '2026-11-19 12:53:23'),
(8, NULL, '', '::1', 'browser: sdoj', 'failed', '2026-11-20 04:53:18'),
(9, NULL, '', '::1', 'browser: sds', 'failed', '2026-11-20 04:53:21'),
(10, NULL, '', '::1', 'browser: ipconfig', 'failed', '2026-11-20 08:47:24'),
(11, NULL, '', '::1', 'browser: iwconfig', 'failed', '2026-11-20 08:47:30'),
(12, NULL, '', '::1', 'browser: ifconfig', 'failed', '2026-11-20 08:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `terminal_log`
--

CREATE TABLE `terminal_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event` varchar(30) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `detail` varchar(255) NOT NULL DEFAULT '',
  `ip_hash` char(64) NOT NULL,
  `ip` varchar(45) NOT NULL DEFAULT '',
  `user_agent` varchar(255) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_log`
--

INSERT INTO `terminal_log` (`id`, `event`, `admin_id`, `detail`, `ip_hash`, `ip`, `user_agent`, `created_at`) VALUES
(1, 'reset', 1, 'user=admin1234@gmail.com', '683e73188342c0596d06a95f2a7a72500df6ebddd2fc51ab0757d95ee7b1693c', '', '', '2026-11-19 07:12:53'),
(2, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 07:14:00'),
(3, 'logout', 1, 'admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 07:14:55'),
(4, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:160.0) Gecko/20100101 Firefox/160.0', '2026-11-19 07:18:17'),
(5, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 07:31:07'),
(6, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 08:58:06'),
(7, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:45:54'),
(8, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:45:58'),
(9, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:46:04'),
(10, 'logout', 1, 'admin panel logout', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:51:42'),
(11, 'login_fail', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:51:45'),
(12, 'login_ok', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:51:46'),
(13, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 09:53:16'),
(14, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 11:55:41'),
(15, 'logout', 1, 'admin panel logout', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:33'),
(16, 'login_fail', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:38'),
(17, 'login_fail', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:40'),
(18, 'login_fail', NULL, 'admin login user=admin1234@gmail.comasdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:42'),
(19, 'login_fail', NULL, 'admin login user=admin1234@gmail.comdasdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:45'),
(20, 'login_block', NULL, 'admin login IP blocked', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:19:45'),
(21, 'login_ok', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:20:43'),
(22, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:24:18'),
(23, 'login_fail', NULL, 'admin login user=asdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:47:01'),
(24, 'login_fail', NULL, 'admin login user=asdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:47:04'),
(25, 'login_fail', NULL, 'admin login user=asdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:47:06'),
(26, 'login_fail', NULL, 'admin login user=asdasd', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:47:08'),
(27, 'login_block', NULL, 'admin login IP blocked', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-19 12:47:08'),
(28, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:51:13'),
(29, 'login_fail', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:51:19'),
(30, 'login_ok', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:51:25'),
(31, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:12'),
(32, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:15'),
(33, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:17'),
(34, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:27'),
(35, 'ip_blocked', NULL, 'terminal login', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:28'),
(36, 'login_blocked', NULL, 'terminal login', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 04:53:34'),
(37, 'login_fail', NULL, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 05:20:49'),
(38, 'login_ok', 1, 'root', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 05:20:56'),
(39, 'login_ok', 1, 'admin login user=admin1234@gmail.com', '5d20a462ea211c84c88c2e22cb863631f5b020d4f0d58fcf2fc39983310de328', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', '2026-11-20 05:21:05');

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
-- Indexes for table `auth_ip_limits`
--
ALTER TABLE `auth_ip_limits`
  ADD PRIMARY KEY (`ip`);

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
-- Indexes for table `security_unblock_audit`
--
ALTER TABLE `security_unblock_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_time` (`ip`,`created_at`);

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
-- Indexes for table `terminal_command_audit`
--
ALTER TABLE `terminal_command_audit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_time` (`ip`,`created_at`),
  ADD KEY `idx_admin_time` (`admin_id`,`created_at`);

--
-- Indexes for table `terminal_log`
--
ALTER TABLE `terminal_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_event_time` (`ip_hash`,`event`,`created_at`),
  ADD KEY `admin_event` (`admin_id`,`event`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `security_unblock_audit`
--
ALTER TABLE `security_unblock_audit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `terminal_command_audit`
--
ALTER TABLE `terminal_command_audit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `terminal_log`
--
ALTER TABLE `terminal_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
