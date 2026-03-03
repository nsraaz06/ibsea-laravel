-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2026 at 06:41 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u957624728_ibsea`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$oEpbMHgzjT84VdhIjbehJOlHbieYUSYONT9xLTwWwU/52yfLh8Gbq', 'admin@ibsea.org', '2026-02-11 10:34:22', '2026-02-11 10:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` enum('National','International') NOT NULL,
  `state_code` varchar(10) DEFAULT NULL,
  `total_members_count` int(11) DEFAULT 0,
  `status` enum('Healthy','At-Risk','Inactive') DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `name`, `type`, `state_code`, `total_members_count`, `status`) VALUES
(1, 'Andhra Pradesh', 'National', NULL, 0, 'Inactive'),
(2, 'Arunachal Pradesh', 'National', NULL, 0, 'Inactive'),
(3, 'Assam', 'National', NULL, 0, 'Inactive'),
(4, 'Bihar', 'National', NULL, 0, 'Inactive'),
(5, 'Chhattisgarh', 'National', NULL, 0, 'Inactive'),
(6, 'Goa', 'National', NULL, 0, 'Inactive'),
(7, 'Gujarat', 'National', NULL, 0, 'Inactive'),
(8, 'Haryana', 'National', NULL, 0, 'Inactive'),
(9, 'Himachal Pradesh', 'National', NULL, 0, 'Inactive'),
(10, 'Jharkhand', 'National', NULL, 0, 'Inactive'),
(11, 'Karnataka', 'National', NULL, 0, 'Inactive'),
(12, 'Kerala', 'National', NULL, 0, 'Inactive'),
(13, 'Madhya Pradesh', 'National', NULL, 0, 'Inactive'),
(14, 'Maharashtra', 'National', NULL, 0, 'Inactive'),
(15, 'Manipur', 'National', NULL, 0, 'Inactive'),
(16, 'Meghalaya', 'National', NULL, 0, 'Inactive'),
(17, 'Mizoram', 'National', NULL, 0, 'Inactive'),
(18, 'Nagaland', 'National', NULL, 0, 'Inactive'),
(19, 'Odisha', 'National', NULL, 0, 'Inactive'),
(20, 'Punjab', 'National', NULL, 0, 'Inactive'),
(21, 'Rajasthan', 'National', NULL, 0, 'Inactive'),
(22, 'Sikkim', 'National', NULL, 0, 'Inactive'),
(23, 'Tamil Nadu', 'National', NULL, 0, 'Inactive'),
(24, 'Telangana', 'National', NULL, 0, 'Inactive'),
(25, 'Tripura', 'National', NULL, 0, 'Inactive'),
(26, 'Uttar Pradesh', 'National', NULL, 0, 'Inactive'),
(27, 'Uttarakhand', 'National', NULL, 0, 'Inactive'),
(28, 'West Bengal', 'National', NULL, 0, 'Inactive'),
(29, 'Delhi', 'National', NULL, 0, 'Inactive'),
(30, 'Chandigarh', 'National', NULL, 0, 'Inactive'),
(31, 'Puducherry', 'National', NULL, 0, 'Inactive'),
(32, 'Ladakh', 'National', NULL, 0, 'Inactive'),
(33, 'Jammu & Kashmir', 'National', NULL, 0, 'Inactive'),
(34, 'USA', 'International', NULL, 0, 'Inactive'),
(35, 'UK', 'International', NULL, 0, 'Inactive'),
(36, 'Canada', 'International', NULL, 0, 'Inactive'),
(37, 'Australia', 'International', NULL, 0, 'Inactive'),
(38, 'Germany', 'International', NULL, 0, 'Inactive'),
(39, 'UAE', 'International', NULL, 0, 'Inactive'),
(40, 'Singapore', 'International', NULL, 0, 'Inactive'),
(41, 'Japan', 'International', NULL, 0, 'Inactive'),
(42, 'France', 'International', NULL, 0, 'Inactive'),
(43, 'Mauritius', 'International', NULL, 0, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `councils`
--

CREATE TABLE `councils` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `sector` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `councils`
--

INSERT INTO `councils` (`id`, `name`, `sector`) VALUES
(1, 'Technology & IT Council', NULL),
(2, 'Manufacturing & Industry 4.0', NULL),
(3, 'Healthcare & Life Sciences', NULL),
(4, 'Finance & Fintech Council', NULL),
(5, 'Education & EdTech', NULL),
(6, 'Agriculture & AgriTech', NULL),
(7, 'Energy & Sustainability', NULL),
(8, 'Logistics & Supply Chain', NULL),
(9, 'Tourism & Hospitality', NULL),
(10, 'Textiles & Fashion', NULL),
(11, 'Real Estate & Infrastructure', NULL),
(12, 'Media & Entertainment', NULL),
(13, 'Aerospace & Defense', NULL),
(14, 'Automobile & EV Council', NULL),
(15, 'Food Processing', NULL),
(16, 'Skilling & HR Council', NULL),
(17, 'Startups & Incubation', NULL),
(18, 'Social Impact', NULL),
(19, 'Global Trade & Export', NULL),
(20, 'Women Entrepreneurship', NULL),
(21, 'Legal & Compliance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `organizer` varchar(150) DEFAULT 'IBSEA',
  `description` text DEFAULT NULL,
  `pdf_link` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` enum('Upcoming','Past') DEFAULT 'Upcoming',
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `event_date`, `start_time`, `end_time`, `venue`, `city`, `state`, `organizer`, `description`, `pdf_link`, `featured_image`, `status`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Bharat Ke Maharathi', '2026-10-25', '04:49:00', '17:20:00', 'NDMC Center New Delhi', 'New Delhi', 'Delhi', 'IBSEA', 'The “India @ 2047″ conference is an initiative by the International Business Startup and Entrepreneurs Association (IBSEA) that contributes to Prime Minister Narendra Modi’s Vision of Developed India 2047. This event gathers government officials, ministers, entrepreneurs, and social workers to share their roadmaps for achieving this ambitious mission. Through panel discussions, expert talks, and strategic conversations, the conference will', '', 'uploads/events/698d9358e79f8.jpg', 'Upcoming', 1, '2026-02-11 10:39:43', '2026-02-13 18:59:57'),
(4, 'Global Summit 2026', '2026-06-15', '10:31:00', '12:00:00', 'Patna, Bihar', 'Patna ', 'Bihar', 'IBSEA', 'A mega summit for entrepreneurs.', '', 'uploads/events/698d9363b626e.png', 'Upcoming', 1, '2026-02-11 15:05:47', '2026-02-14 00:49:35'),
(5, 'International Women’s Day', '2026-03-08', '09:30:00', '16:00:00', 'University, Delhi NCR', 'New Delhi', 'Delhi ', 'IBSEA', 'On this International Women’s Day, we celebrate the strength, leadership, and achievements of women who are shaping businesses, communities, and the future of our nation. Let us continue to support equal opportunities, leadership, and entrepreneurship for women everywhere.', '', 'uploads/events/699010ce56b75.png', 'Upcoming', 1, '2026-02-14 06:06:06', '2026-02-14 06:11:39'),
(6, 'GCC Innovation Summit', '2026-02-26', '09:00:00', '18:00:00', 'Novotel Hyderabad International Convention Centre, Hyderabad', 'Hyderabad', 'Telangana', 'IBSEA', 'The GCC Innovation Summit is a regional platform uniting startups, investors, policymakers, and industry leaders to accelerate technology, entrepreneurship, and sustainable growth across the Gulf. It fosters collaboration, showcases breakthrough innovations, and drives cross-border partnerships shaping the future economy.', '', 'uploads/events/699014b748284.png', 'Upcoming', 1, '2026-02-14 06:22:47', '2026-02-14 06:22:47'),
(7, 'World Health Day', '2026-04-07', '09:00:00', '18:00:00', 'CSJM University, Kanpur', 'Kanpur', 'Uttar Pradesh', 'IBSEA', 'World Health Day – Directors & Mentors Conclave, celebrated by IBSEA, is a distinguished gathering of leaders, educators, and health advocates committed to advancing global wellness. The conclave fosters insightful discussions, strategic collaboration, and innovative ideas to promote health awareness, preventive care, and sustainable well-being initiatives, empowering institutions and communities to build a healthier future together.', '', 'uploads/events/69901d41a457f.png', 'Upcoming', 1, '2026-02-14 06:59:13', '2026-02-14 06:59:13');

-- --------------------------------------------------------

--
-- Table structure for table `event_bookings`
--

CREATE TABLE `event_bookings` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `status` enum('Confirmed','Cancelled','Pending') DEFAULT 'Confirmed',
  `secret_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_bookings`
--

INSERT INTO `event_bookings` (`id`, `member_id`, `event_id`, `ticket_id`, `payment_id`, `status`, `secret_token`, `created_at`) VALUES
(4, 13, 1, 8, 10, 'Confirmed', NULL, '2026-02-12 09:58:08'),
(5, 14, 1, 8, 12, 'Confirmed', NULL, '2026-02-13 12:22:51'),
(6, 13, 1, 8, 11, 'Confirmed', NULL, '2026-02-13 12:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `event_registrations`
--

CREATE TABLE `event_registrations` (
  `registration_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) NOT NULL,
  `registrant_name` varchar(100) NOT NULL,
  `registrant_email` varchar(100) NOT NULL,
  `registrant_mobile` varchar(15) NOT NULL,
  `payment_status` enum('Pending','Completed','Failed') DEFAULT 'Pending',
  `transaction_id` varchar(100) DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_tickets`
--

CREATE TABLE `event_tickets` (
  `id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_name` varchar(100) DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `last_date_to_buy` datetime DEFAULT NULL,
  `ticket_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_tickets`
--

INSERT INTO `event_tickets` (`id`, `event_id`, `ticket_name`, `benefits`, `original_price`, `offer_price`, `last_date_to_buy`, `ticket_quantity`, `created_at`, `updated_at`) VALUES
(8, 1, 'Early Bird', 'Networking, Dinner, ', 4999.00, 1999.00, '2026-03-20 11:20:00', 10, '2026-02-12 09:57:21', '2026-02-12 09:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `leadership_assignments`
--

CREATE TABLE `leadership_assignments` (
  `id` int(11) NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `role_type` enum('President','Vice President','Secretary','Treasurer') NOT NULL,
  `assigned_on` date DEFAULT curdate(),
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `whatsapp_no` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `setup_token` varchar(64) DEFAULT NULL,
  `membership_id` varchar(50) DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `business_category` varchar(100) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `chapter_type` enum('National','International') DEFAULT 'National',
  `role` varchar(100) DEFAULT 'Member',
  `membership_plan_id` varchar(50) DEFAULT NULL,
  `membership_start` date DEFAULT NULL,
  `membership_end` date DEFAULT NULL,
  `address_line` text DEFAULT NULL,
  `strategic_rank` int(11) DEFAULT 0,
  `alliance_name` varchar(150) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `achievements` text DEFAULT NULL,
  `profile_completed` tinyint(1) DEFAULT 0,
  `id_card_status` tinyint(1) DEFAULT 0,
  `certificate_status` tinyint(1) DEFAULT 0,
  `ticket_status` tinyint(1) DEFAULT 1,
  `council_id` int(11) DEFAULT NULL,
  `address_line_1` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state_country` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `location_detail` varchar(100) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Pending','Active','Vetted','Expired') DEFAULT 'Pending',
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chapter_change_count` int(11) DEFAULT 0,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `mobile`, `whatsapp_no`, `dob`, `profile_image`, `email`, `password`, `setup_token`, `membership_id`, `business_name`, `industry`, `profession`, `business_category`, `image_path`, `chapter_id`, `chapter_type`, `role`, `membership_plan_id`, `membership_start`, `membership_end`, `address_line`, `strategic_rank`, `alliance_name`, `bio`, `linkedin_url`, `short_description`, `full_description`, `achievements`, `profile_completed`, `id_card_status`, `certificate_status`, `ticket_status`, `council_id`, `address_line_1`, `city`, `state_country`, `pincode`, `location_detail`, `website_url`, `address`, `status`, `reset_token`, `reset_expiry`, `join_date`, `expiry_date`, `created_at`, `updated_at`, `chapter_change_count`, `role_id`) VALUES
(13, 'Raju Kumar', '918448440229', '', NULL, 'uploads/members/member_13_pico_1770881332.png', 'contact@360digitalmarketing.in', '$2y$10$5o2Ffqb8r5UQyZblULOkQ.0EK8vKmFJgJs5VnCxwwnDMzXumbZ.q6', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Member', 'corporate-booster', '2026-02-12', '2027-02-12', '', 0, '', NULL, '', '', '', '', 0, 1, 1, 1, NULL, NULL, '', '', '', NULL, '', NULL, 'Active', '8adcb2c56c1616a14b9191d9cd84982171e51ac0e3862f2f4de461f8f98f063d', '2026-02-14 17:29:03', NULL, NULL, '2026-02-12 06:44:36', '2026-02-14 16:47:45', 0, 1),
(14, 'anshumaan', '8756952378', '', NULL, 'uploads/members/698f5a1b12836.png', 'contact@ibsea.in', '$2y$10$JWncUcmea4NCWV4FHzWomuoxDUHu6A7ZTz5yxQvyGLTR6YRx.wXfy', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'strategic', NULL, '2026-02-13', NULL, '', 0, '', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 12:21:25', '2026-02-14 18:41:32', 0, 12),
(15, 'Dr. Anshumaan Singh', '8756952378', '8756952378', '1980-01-01', 'uploads/members/698f90b40b785.jpg', 'anshumaan.singh@ibsea.in', '$2y$10$vSKe7g4hp85PiDq/FyVx0.3Yhn8AH.Q6qa7aGDvzapsrz6wVjtOrq', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Chairman', NULL, '2026-02-13', '2027-02-13', 'Lucknow', 0, '', NULL, 'https://www.linkedin.com/in/anshumaansinghofficial/', 'Chairman : IBSEA', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:50:19', 0, 2),
(16, 'PVR Murthy', '8860090085', '8860090085', '1975-01-01', 'uploads/members/698f8ff2da69a.jpg', 'pvr.murthy@ibsea.in', '$2y$10$dmn124ijmvqXuZ2wJFtKvOOrose8KLBSZeSx/nQ/hbWpWbppA8FZW', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Board Members', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, '', NULL, 'https://www.linkedin.com/in/p-v-r-murty-266983288/', 'Ex-Vice President Adani Group', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 3),
(17, 'Major (R.) Dr. Himanshu', '9997383676', '9997383676', '1982-01-01', 'uploads/members/698f85e59ae83.jpg', 'himanshu@ibsea.in', '$2y$10$z6L9ev7bGoDv9KnspANxQuTadVu35V45m8x0bva/8EsYD34Jh53YO', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Board Members', NULL, '2026-02-13', '2027-02-13', 'Meerut', 0, '', NULL, '', 'Author/Social Worker', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 3),
(18, 'Dr. Heera Lal Patel', '9277107700', '9277107700', '1970-01-01', 'uploads/members/698f85f3db999.jpg', 'heeralal.patel@ibsea.in', '$2y$10$3Bbp9CMvKJflFuu1z1dr6.w83ijaxRtoy6XuRdX0KXqDnyshocMK.', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Board Members', NULL, '2026-02-13', '2027-02-13', 'Lucknow', 0, '', NULL, 'https://www.linkedin.com/in/iasheeralal/', 'IAS , Climate Action Leader Secretary , National Integration', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 3),
(19, 'Jai Shankar Sharma', '9880225474', '9880225474', '1978-01-01', 'uploads/members/698f86062f066.jpg', 'jaishankar.sharma@ibsea.in', '$2y$10$32yKdAcEGwUCuuemJdlltuH9Ux6Hv3rHe.YRZ7S/4wVUK0zx6/ETy', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Board Members', NULL, '2026-02-13', '2027-02-13', 'Kanpur', 0, '', NULL, '', 'Chairperson - Startup Master Class (SMC) IITK', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 3),
(20, 'Dr. Radhe Shyam Mishra', '9026740742', '9026740742', '1960-01-01', 'uploads/members/698f86248682f.jpg', 'radheshyam.mishra@ibsea.in', '$2y$10$IJH1gwl/6/sndurl8AtE3ez/325p4JkxWAGMY.bLyOwD5SrOHXoUq', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Board Members', NULL, '2026-02-13', '2027-02-13', 'Lucknow', 0, '', NULL, 'https://www.linkedin.com/in/drradheyshyammishraias/', 'IAS (R) EX REVENUE SECRETARY Gov(UP)', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 3),
(21, 'Dr. Ruhi Banerjee', '7000391445', '7000391445', '1988-06-19', 'uploads/members/698f8a0025160.jpg', 'ruhi.banergee@ibsea.in', '$2y$10$cGKX42Tj8m3yS3KxgECmTuZ24ZHrGjSVxSQ44g.a3Qi1E3JX2hMyW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Kolkata', 0, 'Partnership Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'West Bengal', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 5),
(22, 'Brig. Arun Gupta', '9560088442', '9560088442', '1965-08-20', 'uploads/members/698f89e4b5741.jpg', 'arun.gupta@ibsea.in', '$2y$10$BQu8vbrNszdL7nu9McOX3OHGr8Dom5L/KNhDGoUdsdxJozAn7mBEC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Gurgaon', 0, 'Mentors/Trainers Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Haryana', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 5),
(23, 'Prabhat Sinha', '9798748999', '9798748999', '1985-08-06', 'uploads/members/698f8a230d5b1.jpg', 'prabhat.sinha@ibsea.in', '$2y$10$oru4le4sYmNYSnmKIwuc7.b7JmlHLuedNp/of9zyWY9D4EW8vR4YC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Patna', 0, 'Corporate Training Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Bihar', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:40', '2026-02-14 16:47:45', 0, 5),
(24, 'Adv. Mrs. Parveen Arya', '7011481744', '7011481744', '1989-08-28', 'uploads/members/698f8a47d3d24.jpg', 'parveen.arya@ibsea.in', '$2y$10$lRcRqIdy7WQhtYjrnFcjf.IEinN5Ko.VHQHqG.x6W1q6n9cn0RsSO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, ' Campus To CORPORATE (COE) Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(25, 'Md. Shahzad Alam', '9576762377', '9576762377', '1990-08-01', 'uploads/members/698f8a6355093.jpg', 'shahzad.alam@ibsea.in', '$2y$10$M2rcjf/RymW5zBaa9YgXXeOghOUSDyUj7eBCaqw630yXmtwiGIB/i', NULL, NULL, NULL, 'All', 'Allience head  ', 'Branding and Marketing', NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Ranchi', 0, ' Vyapar  Badhao Alliances', NULL, 'https://www.linkedin.com/in/mdshahzad06/', 'Branding Expert & AI Trainer for Startups in India', 'Md Shahzad – Branding Expert & AI Trainer for Startups in India\r\nHelping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands & Careers with AI Tools\r\nWith 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients, Muhammad Shahzad empowers businesses and individuals through branding, AI training, digital marketing, and startup mentorship', '10+ years of expertise in branding, marketing, and digital strategy\r\nWorked with 1000+ clients across industries\r\nConducted AI training in India for startups & professionals\r\nCo-founder of multiple initiatives supporting business growth and youth empowerment', 1, 0, 0, 1, NULL, NULL, 'Jharkhand', 'bihar', '843117', NULL, 'https://mdshahzad.com/', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(26, 'Prof. Roopinder Oberoi', '8447887200', '8447887200', '1978-08-14', 'uploads/members/698f8a8dc2881.jpg', 'roopinder.oberoi@ibsea.in', '$2y$10$jxakVx5jX6EIaoNiFPV32.AoU9L6rQZ45Z0LNNKaEqZG8El9PtVWG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, 'Rural Development & Policy Stakeholders Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(27, 'Dr. Raja Seevan', '9739047849', '9739047849', '1983-08-15', 'uploads/members/698f8ac96717b.jpg', 'raja.seevan@ibsea.in', '$2y$10$d/3eICaAXgiFyWdukDDG9uytkvyNph9On0L8x4O6KOk8Nz7925pn6', NULL, NULL, NULL, '', '', '', NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Bangalore', 0, ' TECHNOLOGY TRANSFORMATION Alliances', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, 'Karnataka', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(28, 'Vikas Deep', '9810338362', '9810338362', '1986-08-08', 'uploads/members/698f8b356a65c.jpg', 'vikas.deep@ibsea.in', '$2y$10$QUj6uMubyhcGQR4VupwdWe5ahRG/l0ftsatb6ilE/LEJrRxJhNCNC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, 'Print &  Digital Media Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(29, 'Raghav Gupta', '9981168418', '9981168418', '1992-08-07', 'uploads/members/698f87afc37f7.jpg', 'raghav.gupta@ibsea.in', '$2y$10$v.PhIVdyKuNQ4VYl1eM0F.1mJi1VPzhMemFIp/XxFRxtS9qmSPV2u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Indore', 0, 'Event & INFLUENCERS Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Madhya Pradesh', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(30, 'Aloor Chinmaya', '9121524803', '9121524803', '1985-08-15', 'uploads/members/698f909758b54.jpg', 'aloor.chinmaya@ibsea.in', '$2y$10$GyFvqv326DeRFenh/gKFGues8fP3VOhU05vjUoajrri6LacrmhILi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Hyderabad', 0, 'Investors Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Telangana', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(31, 'Dr. Raghav Nath Jha', '9835882652', '9835882652', '1980-08-15', 'uploads/members/698f8b5709227.jpg', 'raghavnath.jha@ibsea.in', '$2y$10$W5phOBMHzJU2/5wfLDdO5OnlsDZviXbYDnppD3ivcP1.bqr1UV3F6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Patna', 0, ' Heritage & Culture Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Bihar', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(32, 'Dr. Smriti Singh', '8172914062', '8172914062', '1988-08-15', 'uploads/members/698f8b9fcfe88.jpg', 'smriti.singh@ibsea.in', '$2y$10$OzmhqB1Ybqx/zFgW/AotCO47L5ToBigQ0Da7xcIDME1Qc9XWClHJi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Varanasi', 0, 'Holistic  MEDITATION & SPIRITUAL Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(33, 'Rahul Jha', '9811383903', '9811383903', '1990-10-01', 'uploads/members/698f8b943cc29.jpg', 'rahul.jha@ibsea.in', '$2y$10$63dopySbf.amLoSnm/dE6eAvaKY/EvjC5U6KVmx4h6S53m2MAv/7u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, ' Feedbacks / Review Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(34, 'Vivek Kumar', '9430367904', '9430367904', '1987-08-17', 'uploads/members/698f8be50e064.jpg', 'vivek.kumar@ibsea.in', '$2y$10$DpZlfC4VHt5CUVjqKsY4YOHlG9HdtiWpT3CBUeSgJqVNhOE.LPhfG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Ranchi', 0, ' International Cooperation & Investment Promotion (ICIP) Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Jharkhand', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(35, 'Bijendra Saini', '9355522544', '9355522544', '1984-08-08', 'uploads/members/698f8c0a45126.jpg', 'bijendra.saini@ibsea.in', '$2y$10$SwBOvzNJp.Tv57U/QlkFjOovowvOntQIa7bbqhWCaK4WF7mLqqDZe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Alliance Head', NULL, '2026-02-13', '2027-02-13', 'Gurgaon', 0, 'Business  Automation Alliances', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Haryana', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 5),
(36, 'Janmejay Singh Rajput', '9818715747', '9818715747', '1984-10-03', 'uploads/members/698f86e249975.jpg', 'janmejay.rajput@ibsea.in', '$2y$10$RpPv8jK93IiD5v.IuPEi/uwdoL/J7M7RfU73DCAbqfXKDeIuRhGs2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(37, 'Bhoopesh Bhondle', '9730736555', '9730736555', '1982-11-22', 'uploads/members/698f86fec0248.jpg', 'bhoopesh.bhondle@ibsea.in', '$2y$10$Jqo.9uLOI8HTeUwaYavpku0uoeY.rqYwE7zMXytk0PbXn8mnpZEgG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Mumbai', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Maharashtra', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(38, 'Deepesh Dhariwal', '9099965507', '9099965507', '1987-04-14', 'uploads/members/698f87190f990.jpg', 'deepesh.dhariwal@ibsea.in', '$2y$10$85Bqfjb2.Wv41ppdyt9BxeoCAHZE3vgC5zCKKMAswoAdZXt1R9.3u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Jaipur', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Rajasthan', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(39, 'Krishna B G', '9916802147', '9916802147', '1985-08-25', 'uploads/members/698f8ce12f5fc.jpg', 'krishna.bg@ibsea.in', '$2y$10$KrQkNEWlD592vJGBIpJKlORTmKF8Sjx580XISkSl7nC6IFktfCyny', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Bangalore', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Karnataka', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(40, 'Jitender Grover', '9912000082', '9912000082', '1980-09-14', 'uploads/members/698f8d9c8c5d7.jpg', 'jitender.grover@ibsea.in', '$2y$10$HuGycQ9.BkKFCniYmjsNRuirYSgJtD7rpf0Qf4vtpB0RDtJkAI096', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Gurgaon', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Haryana', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(41, 'Chirag Agarwal', '9760899169', '9760899169', '1989-04-11', 'uploads/members/698f8dd8e2f7f.jpg', 'chirag.agarwal@ibsea.in', '$2y$10$rwVJDIACdWwGI/bdis9bmesTA0NLYalqyGm2Ca6wKwc5UKmL8Kqfy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 27, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Dehradun', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttarakhand', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 6),
(42, 'Kalyan Singh', '6353453115', '6353453115', '1983-09-12', 'uploads/members/698f9e3c4e35e.jpg', 'kalyan.singh@ibsea.in', '$2y$10$W/P.yiDK/LX2jjIj5t/1OOb92kC.GCxSeyIutJhQmssqW5y5aJK66', NULL, NULL, NULL, '', '', '', NULL, 7, 'National', 'State Secretary', NULL, '2026-02-13', '2027-02-13', 'Ahmedabad', 0, '', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, 'Gujarat', 'Gujrat', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:41', '2026-02-14 16:47:45', 0, 11),
(43, 'Avinash Sharma', '8827849864', '8827849864', '1988-11-25', 'uploads/members/698f8fa60f531.jpg', 'avinash.sharma@ibsea.in', '$2y$10$HQNh8ctjpXq5PbbDW7pvO.rQQ8gR2fArfV0oNeDY167J.8e93iMqi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 'National', 'State President', NULL, '2026-02-13', '2027-02-13', 'Bhopal', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Madhya Pradesh', '', '110022', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 6),
(44, 'Ravi Jaiswal', '9555374767', '9555374767', '1991-03-08', 'uploads/members/698f8f884926e.jpg', 'ravi.jaiswal@ibsea.in', '$2y$10$ZH4tcHEzDaHvLefNp1xIb.maEDsFeWNbWTb6IOQXWwcwzfj.G2zjK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Vice President', NULL, '2026-02-13', '2027-02-13', 'Lucknow', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 7),
(45, 'Abhishek Katiyar', '8738017295', '8738017295', '1990-03-08', 'uploads/members/698f8698af5eb.jpg', 'abhishek.katiyar@ibsea.in', '$2y$10$JXLMtxbJSkoQD18/1jcxYeZPI78.l5Z05jnWlM28u7GZZJAm62tlW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'National', 'Vice President', NULL, '2026-02-13', '2027-02-13', 'Gurgaon', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Haryana', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 7),
(46, 'Dinesh Kherodia', '9782859975', '9782859975', '1982-10-24', 'uploads/members/698f8f778e542.jpg', 'dinesh.kherodia@ibsea.in', '$2y$10$SvdkcCl7Wss7Popbxu9jI.KbPWRV5dyfcT/81X8VhAg2A6xO72zqe', NULL, NULL, NULL, '', '', '', NULL, 21, 'National', 'State Secretary', NULL, '2026-02-13', '2027-02-13', 'Jaipur', 0, '', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, 'Rajasthan', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 11),
(47, 'Anand Tiwari', '8112345901', '8112345901', '1986-09-12', 'uploads/members/698f8ec20cf6b.jpg', 'anand.tiwari@ibsea.in', '$2y$10$cNBTC0qISvAY7MWMMFmpFufW6VjBDGqhhyY3qmAsT79Cr7d.28Tpq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Vice President', NULL, '2026-02-13', '2027-02-13', 'Lucknow', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Uttar Pradesh', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 7),
(48, 'Suyash Kamal Soni', '7000750603', '7000750603', '1993-11-29', 'uploads/members/698f8eb488b71.jpg', 'suyash.soni@ibsea.in', '$2y$10$5ee0//Q9NOaxWmDNJBaaTePuW3dHEwHmwMCoRN45a1mAh8Fpvd2em', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Vice President', NULL, '2026-02-13', '2027-02-13', 'Delhi', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Delhi', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 7),
(49, 'CE Shreekant Patil', '9823018722', '9823018722', '1978-08-15', 'uploads/members/698f8775d56e5.jpg', 'shreekant.patil@ibsea.in', '$2y$10$xqgxFsCOsag.PLeGQE765OuMzFrKxOClqp93KVAJC0B57b8FoPc96', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 'National', 'Vice President', NULL, '2026-02-13', '2027-02-13', 'Nashik', 0, '', NULL, NULL, '', '', '', 0, 0, 0, 1, NULL, NULL, 'Maharashtra', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-13 19:54:42', '2026-02-14 16:47:45', 0, 7),
(50, 'Shamstabrej', '919560354066', NULL, NULL, NULL, 'shamstabrej@mail.com', '$2y$10$E/pwc8pd1fyx5jIsznD.8./6GjP4jhqMUdsswsYsdcVEJM1er0Nk2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Member', 'booster', '2026-02-14', '2027-02-14', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', '7a55c4ad573cf6f2473268d723c4b0f298d7763202a59766d8e7e3d503924305', '2026-02-14 17:38:14', NULL, NULL, '2026-02-14 14:10:31', '2026-02-14 16:47:45', 0, 1),
(51, 'nsraaz', '6200989012', NULL, NULL, NULL, 'nsraaz06@gmail.com', '$2y$10$fh7.zlzu8wBZ6VP2yWekoeLigMQrmeJiGPTXSZ0Ut7NRyJCq.aVV6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'National', 'Member', NULL, '2026-02-14', '2027-02-14', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pending', '7ec6a05600c952aea001a629442fb637cb520526c1dfc331c78913b1f4424b2a', '2026-02-14 17:30:39', NULL, NULL, '2026-02-14 14:42:25', '2026-02-14 16:47:45', 0, 1),
(53, 'Lt. Gen. AB Shivane', '8191903001', 'Advisor', '0000-00-00', NULL, 'ab.shivane@ibsea.in', '$2y$10$yFeuMsuBaMz5bppWj0udt.DlYcotiMRpiolSsk5f5sJBux.8LlH.u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(54, 'Lt. Gen. (Dr.) SK Gadeock', '9488665000', 'Advisor', '0000-00-00', NULL, 'sk.gadeock@ibsea.in', '$2y$10$GHT8kbuxQ/FS2m7tiaLijeJLqhdHvVSgM/6y7duaFDuLM9Y7uD8bS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Noida', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(55, 'Dr. R. Padmanabhan', '9361387850', 'Advisor', '0000-00-00', NULL, 'r.padmanabhan@ibsea.in', '$2y$10$9eY.Fx3ONjYKOJTrF3OB..8tsTYDyadntL8aBAP1MluklnLA60Bbe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 'National', 'Chennai', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(56, 'Surya Kant', '9968404543', 'Advisor', '0000-00-00', NULL, 'surya.kant@ibsea.in', '$2y$10$Y59rfc4liXdQal8rnv5ftevtMR.OLaJrHDxYBPEGzGT6JLTk9MIBi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Greater Noida', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(57, 'Dr. Rakesh Chandra Agarwal', '8851252184', 'Advisor', '0000-00-00', NULL, 'rakesh.agarwal@ibsea.in', '$2y$10$1BsBEeMnckBjcctQ2Ts2Mu3CceMR2sglPhj..xs31NiufcM4ikaFq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(58, 'Col. Arvind Kumar (Retd.)', '9958452984', 'Advisor', '0000-00-00', NULL, 'arvind.kumar@ibsea.in', '$2y$10$Gn4W1RvPDeowelWjdF80neBLLGCMy61TEUjBaIFgl7epPkgo4VESS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(59, 'Dr. K. Madan Gopal', '9999189794', 'Advisor', '0000-00-00', NULL, 'madan.gopal@ibsea.in', '$2y$10$InvA43tet5RRy5m6jjfhlOrK/73l0.wafb8SflzTWPalcZVnU5h2C', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:21', '2026-02-14 18:47:21', 0, 1),
(60, 'Vinamra Mishra', '9311848770', 'Advisor', NULL, '', 'vinamra.mishra@ibsea.in', '$2y$10$mWnIwBHjeVqQOYUbh5a1hOkdhkF.iijGf02SUbCwfgyz4nZl0gmHC', NULL, NULL, NULL, '', '', '', NULL, 29, 'National', 'Advisor', NULL, '2026-02-14', NULL, '', 0, '', NULL, '', '', '', '', 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, '', NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:48', 0, 4),
(61, 'Dr. Dilawar Singh', '61421344770', 'Advisor', '0000-00-00', NULL, 'dilawar.singh@ibsea.in', '$2y$10$jTXXomGLxR5e6aW1jrG6JuIX9vTFxauOIGOhKDuJJHCb7DS6iDOai', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 37, 'National', 'Sydney', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(62, 'Bharat Thakkar', '9376922853', 'Advisor', '0000-00-00', NULL, 'bharat.thakkar@ibsea.in', '$2y$10$jVfNAFuLswLrvTOs3dpmGebdgI5bbJs5Y4BPcnwR/vwci25fDz81S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 'National', 'Ahmedabad', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(63, 'Chandra Shekhar Singh', '9453379332', 'Advisor', '0000-00-00', NULL, 'chandrashekhar.singh@ibsea.in', '$2y$10$OeSchJ9QnmmG29LCb.OFNee/fCF4idegxxQezsZI14TAcxAn/OZ0K', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Varanasi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(64, 'Kanwal Singh Chauhan', '9416320765', 'Advisor', '0000-00-00', NULL, 'kanwal.chauhan@ibsea.in', '$2y$10$m3Me6CUXLaL337S4RzbhUu.vf5Gq7i2MMDehAUbu7Y.rT67Z4V6gO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 'National', 'Sonipat', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(65, 'Kavita Soni', '9977048100', 'Advisor', '0000-00-00', NULL, 'kavita.soni@ibsea.in', '$2y$10$aN6VxIFyUrAnpAjSfxT4K.CE7Wj//2OU/2svekm6Iy43/1SrOD/c2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 'National', 'Indore', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(66, 'Dr. Sandesh Yadav', '9540440088', 'Advisor', '0000-00-00', NULL, 'sandesh.yadav@ibsea.in', '$2y$10$iW1v6PyUiQTSJkikyyxHq.HGGaFSI.IbPVwSLr4Fy4QiUobwLKal2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(67, 'Shashank Bajpai', '9891060955', 'Advisor', '0000-00-00', NULL, 'shashank.bajpai@ibsea.in', '$2y$10$XYUP.71UaL1BSB01w9quLOs6E2QZ3pnmjNsH/.p4qexUuitdwSxUW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(68, 'Kapil Khandelwal', '9811113058', 'Advisor', '0000-00-00', NULL, 'kapil.khandelwal@ibsea.in', '$2y$10$f5A1V8DcnfeJYasjslKIPORHnS.kT5ooudASqCmxphHtSll8OSYaG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(69, 'Pramod Kumar Rajput', '9212501424', 'Advisor', '0000-00-00', NULL, 'pramod.rajput@ibsea.in', '$2y$10$9ewF/TXjNrxVTn27crqbfOLenGt3RtANY1xAJKZLWUeR8jWdF3JPa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(70, 'Gouri Shankar Patnaik', '8895959585', 'Advisor', '0000-00-00', NULL, 'gourishankar.patnaik@ibsea.in', '$2y$10$dl2blvlqlqVpayfeZJYA7eYl5ax1r9/yp4Z.C/pPz5IPQxF0B0TK6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 'National', 'Bhubaneswar', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(71, 'Suresh M. Khade', '9834842567', 'Advisor', '0000-00-00', NULL, 'suresh.khade@ibsea.in', '$2y$10$khF3g9YKboKb.biNSV/0o.C3GoAqxL2UYog.IUg0suOmU24E7zeH.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 'National', 'Mumbai', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(72, 'Aditya Vidyasagar', '9838026777', 'Advisor', '0000-00-00', NULL, 'aditya.vidyasagar@ibsea.in', '$2y$10$Q3dDMoGLLJKy0eAdcbdU.uaN9v3W2epfr2W3u5QG2Oo7FLXeFnc82', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 'National', 'Lucknow', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(73, 'TS Madaan', '8295500333', 'Advisor', '0000-00-00', NULL, 'ts.madaan@ibsea.in', '$2y$10$sVbNgTjpnox48iTExHW/fuSF5eUtmEAQ42vtB6fL5Uy1YfX5nYdNy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(74, 'Dr. Shoolpani Singh', '7004939966', 'Advisor', '0000-00-00', NULL, 'shoolpani.singh@ibsea.in', '$2y$10$uYaa2fM37QHsYtHMDpzpMOz6FGPqkg4f4ebyf9xTu9g5J5sogRFn2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(75, 'Anand Kumar Kapoor', '7011719227', 'Advisor', '0000-00-00', NULL, 'anand.kapoor@ibsea.in', '$2y$10$GECtCBfyZURgmCHLnSB3w.HPK62pzHe8mzuF.Y8mYuRdj2XxMstXK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 'National', 'Delhi', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1),
(76, 'Jaswant Sharma', '9429438664', 'Advisor', '0000-00-00', NULL, 'jaswant.sharma@ibsea.in', '$2y$10$1wHirHpAYfZS0v6AdOnWY.KlKKu4sqdPIwWwUnB5wrMOcyah5oCBi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 'National', 'Ahmedabad', NULL, '2026-02-14', NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 1, NULL, NULL, '', '', '', NULL, NULL, NULL, 'Active', NULL, NULL, NULL, NULL, '2026-02-14 18:47:22', '2026-02-14 18:47:22', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `fee_numeric` decimal(10,2) DEFAULT NULL,
  `validity_days` int(11) DEFAULT NULL,
  `fullName` varchar(150) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `fee` varchar(50) DEFAULT NULL,
  `validity` varchar(100) DEFAULT NULL,
  `overview` text DEFAULT NULL,
  `eligibility` text DEFAULT NULL,
  `popular` tinyint(1) DEFAULT 0,
  `theme` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `highlights_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`highlights_json`)),
  `benefits_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`benefits_json`)),
  `detailed_benefits_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detailed_benefits_json`)),
  `premium_features_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`premium_features_json`)),
  `stats_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stats_json`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `membership_plans`
--

INSERT INTO `membership_plans` (`id`, `title`, `fee_numeric`, `validity_days`, `fullName`, `tagline`, `fee`, `validity`, `overview`, `eligibility`, `popular`, `theme`, `image_url`, `highlights_json`, `benefits_json`, `detailed_benefits_json`, `premium_features_json`, `stats_json`, `created_at`) VALUES
('booster', 'Booster', 1999.00, 365, NULL, 'Start Growing Your Business with IBSEA', NULL, NULL, NULL, NULL, 0, 'Slate', NULL, '[\"Exclusive WhatsApp Access\",\"50 Hours Business Training\",\"Membership E-Certificate\"]', '[\"Networking\",\"ID Card\",\"50hr Training\"]', '[{\"icon\":\"public\",\"title\":\"Networking\",\"text\":\"Access to IBSEA conferences and selected networking meetups.\"},{\"icon\":\"psychology\",\"title\":\"Training\",\"text\":\"50 hours of business growth training annually.\"},{\"icon\":\"discount\",\"title\":\"Discounts\",\"text\":\"10% discount on Vyapar Badhao services and conclaves.\"},{\"icon\":\"badge\",\"title\":\"Credentials\",\"text\":\"Get a verified Membership E-Certificate & ID Card.\"}]', '[{\"title\":\"Community Access\",\"text\":\"Exclusive entry to our active WhatsApp business network.\"},{\"title\":\"Partner Discounts\",\"text\":\"Exclusive pricing for all IBSEA flagship events.\"}]', '[{\"title\":\"Skill Boost\",\"text\":\"Members reported 30% faster skill acquisition in first 6 months.\"},{\"title\":\"Reach\",\"text\":\"Connect with 1000+ local entrepreneurs in your first year.\"}]', '2026-02-12 09:33:16'),
('corporate-booster', 'Corporate Booster', 4999.00, 365, NULL, 'Strengthen Your Brand. Expand Your Reach.', NULL, NULL, NULL, NULL, 0, 'Primary', NULL, '[\"Priority Certification Processing\",\"Annual Strategy Workshop\",\"Logo Display on Site\"]', '[\"MSME Strategy\",\"Logo Display\"]', '[{\"icon\":\"visibility\",\"title\":\"Brand Visibility\",\"text\":\"Company logo display on IBSEA website and marketing materials.\"},{\"icon\":\"videocam\",\"title\":\"Video Promo\",\"text\":\"Get a personalized promotional video for your brand.\"},{\"icon\":\"stars\",\"title\":\"Awards\",\"text\":\"Nomination priority for Bharat Ke Maharathi Awards.\"},{\"icon\":\"corporate_fare\",\"title\":\"Corporate ID\",\"text\":\"Verified Accreditation Certificate & Company ID Card.\"}]', '[{\"title\":\"Brand Strategy\",\"text\":\"1 Brand Strategy Meeting with IBSEA Core Team.\"},{\"title\":\"Mentorship\",\"text\":\"50 Hours Virtual Strategic Mentorship access.\"},{\"title\":\"Speaking Ops\",\"text\":\"Round table speaking opportunities in selected programs.\"}]', '[{\"title\":\"Growth\",\"text\":\"MSMEs see 40% increased visibility in the first year.\"},{\"title\":\"Network\",\"text\":\"Direct access to Director & Mentors Conclave.\"}]', '2026-02-12 09:33:16'),
('corporate-prime', 'Corporate Prime', 100000.00, 365, NULL, 'Premium Visibility. Strategic Connections.', NULL, NULL, NULL, NULL, 0, 'Navy', NULL, '[\"Diplomatic Access\",\"4 Business Leads\\/Mo\",\"Magazine Feature\"]', '[\"Diplomatic Access\",\"4 Leads\\/Mo\"]', '[{\"icon\":\"handshake\",\"title\":\"B2G Access\",\"text\":\"Access to diplomatic engagements and government executive meetings.\"},{\"icon\":\"leaderboard\",\"title\":\"Lead Gen\",\"text\":\"Receive 4 high-quality business leads every month.\"},{\"icon\":\"podcasts\",\"title\":\"Podcasts\",\"text\":\"3 professional podcasts with promotional reach.\"},{\"icon\":\"map\",\"title\":\"Pan-India Network\",\"text\":\"Direct access to State Presidents and Vice Presidents.\"}]', '[{\"title\":\"Global Leads\",\"text\":\"National and Global business leads delivered quarterly.\"},{\"title\":\"Stage Sharing\",\"text\":\"Share the stage in up to 5 major IBSEA conferences.\"},{\"title\":\"Marketing Toolkit\",\"text\":\"Logo promotion across all IBSEA digital and physical platforms.\"}]', '[{\"title\":\"Leads\",\"text\":\"Prime members generate averaging 50+ B2B connections annually.\"},{\"title\":\"Influence\",\"text\":\"Participate in high-stakes policy advocacy sessions.\"}]', '2026-02-12 09:33:16'),
('lifetime', 'Lifetime', 25000.00, 7670, NULL, 'Secure Long-Term Growth until 2047', NULL, NULL, NULL, NULL, 0, 'Gold', NULL, '[\"Valid until Dec 2047\",\"10 Yearly Event Passes\",\"Strategic Consultations\"]', '[\"Valid until 2047\",\"Magazine Feature\"]', '[{\"icon\":\"history_edu\",\"title\":\"Legacy Access\",\"text\":\"Full access to all IBSEA programs and trainings until 2047.\"},{\"icon\":\"article\",\"title\":\"Editorial\",\"text\":\"Featured story in our official magazine annually.\"},{\"icon\":\"psychology\",\"title\":\"Consultations\",\"text\":\"5 strategic one-on-one consultations every year.\"},{\"icon\":\"nature_people\",\"title\":\"Impact\",\"text\":\"Participate in exclusive sustainability and tree plantation initiatives.\"}]', '[{\"title\":\"Speaking Rights\",\"text\":\"Speaking opportunity at events (up to 2 per year).\"},{\"title\":\"Business Kit\",\"text\":\"Receive the premium physical IBSEA Business Kit.\"},{\"title\":\"Priority\",\"text\":\"Priority invitations to all closed-door official meetups.\"}]', '[{\"title\":\"Endurance\",\"text\":\"Locked in benefits for 20+ years regardless of future fee hikes.\"},{\"title\":\"Network\",\"text\":\"Lifetime access to the elite mentor network.\"}]', '2026-02-12 09:33:16');

-- --------------------------------------------------------

--
-- Table structure for table `member_roles`
--

CREATE TABLE `member_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `hierarchy_level` int(11) DEFAULT 10,
  `default_tenure_days` int(11) DEFAULT 365,
  `show_in_leadership` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_roles`
--

INSERT INTO `member_roles` (`id`, `role_name`, `created_at`, `hierarchy_level`, `default_tenure_days`, `show_in_leadership`) VALUES
(1, 'Member', '2026-02-14 16:06:08', 10, 365, 0),
(2, 'Chairman', '2026-02-14 16:06:08', 1, 365, 1),
(3, 'Board Members', '2026-02-14 16:06:08', 2, 365, 1),
(4, 'Advisor', '2026-02-14 16:06:08', 3, 365, 1),
(5, 'Alliance Head', '2026-02-14 16:06:08', 4, 365, 1),
(6, 'State President', '2026-02-14 16:06:08', 5, 365, 1),
(7, 'Vice President', '2026-02-14 16:06:08', 6, 365, 1),
(8, 'Country President', '2026-02-14 16:06:08', 4, 365, 1),
(9, 'Mentor', '2026-02-14 16:06:08', 8, 365, 1),
(10, 'Investor', '2026-02-14 16:06:08', 9, 365, 1),
(11, 'State Secretary', '2026-02-14 16:08:32', 10, 365, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('General','Event','Renewal','Birthday') DEFAULT 'General',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `member_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 2, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(2, 3, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(3, 1, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(4, 11, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(5, 13, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 1, '2026-02-12 11:43:03'),
(6, 10, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(7, 12, 'Bharat ke maharathi', '<p>hi this side shahzad </p>', 'General', 0, '2026-02-12 11:43:03'),
(8, 2, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(9, 3, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(10, 1, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(11, 11, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(12, 13, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 1, '2026-02-12 11:44:28'),
(13, 10, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(14, 12, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-12 11:44:28'),
(15, 2, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(16, 3, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(17, 1, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(18, 11, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(19, 13, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(20, 10, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22'),
(21, 12, 'I\'ve fixed the issue with the Admin Branding statistics:', '<p><br></p><h1><span style=\"color: rgb(97, 206, 112);\">Md Shahzad&nbsp;</span>– Branding Expert &amp; AI Trainer for Startups in India</h1><h2>Helping Startups, Entrepreneurs, and Job Seekers Build Powerful Brands &amp; Careers with AI Tools</h2><p>With 10+ years of experience, 5000+ successful projects, and 1000+ satisfied clients,&nbsp;<strong>Muhammad Shahzad</strong>&nbsp;empowers businesses and individuals through&nbsp;<strong>branding, AI training, digital marketing, and startup mentorship</strong>.</p><ul><li><span style=\"color: inherit;\">Dynamic Content Stats</span>: Replaced the hardcoded zero values in&nbsp;with actual counts from the database.</li><li><span style=\"color: inherit;\">Real-time Accuracy</span>: The \"Published\" and \"Total Drafts\" counters now automatically update whenever you create, edit, or delete a mission update.</li></ul><p><br></p>', 'General', 0, '2026-02-13 11:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_type` enum('Membership','Event') DEFAULT NULL,
  `razorpay_order_id` varchar(100) DEFAULT NULL,
  `status` enum('Success','Failed') DEFAULT 'Success',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `amount`, `payment_type`, `razorpay_order_id`, `status`, `created_at`) VALUES
(1, 13, 1999.00, 'Membership', 'IBSEA_MEM_1770878880', 'Failed', '2026-02-12 06:48:00'),
(2, 13, 1999.00, 'Event', 'IBSEA_EVE_1770878906', 'Failed', '2026-02-12 06:48:26'),
(3, 13, 1999.00, 'Membership', 'IBSEA_MEM_1770879249', 'Failed', '2026-02-12 06:54:09'),
(4, 13, 1999.00, 'Membership', 'IBSEA_MEM_1770879256', 'Failed', '2026-02-12 06:54:16'),
(5, 13, 1999.00, 'Event', 'IBSEA_EVE_1770879467', 'Failed', '2026-02-12 06:57:47'),
(6, 13, 1999.00, 'Event', 'IBSEA_EVE_1770879631', 'Success', '2026-02-12 07:00:31'),
(7, 13, 4999.00, 'Membership', 'IBSEA_MEM_1770881074', 'Success', '2026-02-12 07:24:34'),
(8, 13, 1999.00, 'Event', 'IBSEA_EVE_1770886036', 'Success', '2026-02-12 08:47:16'),
(9, 13, 1999.00, 'Event', 'IBSEA_EVE_1770888140', 'Success', '2026-02-12 09:22:20'),
(10, 13, 1999.00, 'Event', 'IBSEA_EVE_1770890256', 'Success', '2026-02-12 09:57:36'),
(11, 13, 1999.00, 'Event', 'IBSEA_EVE_1770985256', 'Success', '2026-02-13 12:20:56'),
(12, 14, 1999.00, 'Event', 'IBSEA_EVE_1770985285', 'Success', '2026-02-13 12:21:25'),
(13, 50, 1999.00, 'Membership', 'IBSEA_MEM_1771078734', 'Failed', '2026-02-14 14:18:54'),
(14, 50, 1999.00, 'Membership', 'IBSEA_MEM_1771079057', 'Success', '2026-02-14 14:24:17'),
(15, 13, 25000.00, 'Membership', 'IBSEA_MEM_1771079445', 'Failed', '2026-02-14 14:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` enum('News','Blog','Press Release','Vyapar Badhao') DEFAULT 'Blog',
  `status` enum('Draft','Published') DEFAULT 'Draft',
  `show_on_slider` tinyint(1) DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `slug`, `content`, `featured_image`, `category`, `status`, `show_on_slider`, `published_at`, `created_at`) VALUES
(1, 1, 'Why AI Startup Edge Is the Growth Partner for Modern Startups', 'Why AI Startup Edge Is the Growth Partner for Modern Startups', '<p>Modern startups face a new reality. Competition is intense, customer expectations are high, and resources are limited. Founders are expected to move fast, make smart decisions, reduce costs, and scale operations at the same time. Traditional growth methods such as hiring more people or increasing ad spend are no longer enough. Startups need intelligent systems that help them grow without creating chaos.</p><p>This is where AI Startup Edge becomes a true growth partner. It helps startups use artificial intelligence in a structured and practical way. Instead of adding complexity, it simplifies operations, improves decision-making, and builds scalable systems. AI Startup Edge focuses on measurable business results, not just technology implementation.</p><p>Modern startups that embrace AI early gain clarity, efficiency, and competitive advantage. This blog explains why AI Startup Edge is the right growth partner for modern startups and how it helps businesses grow smarter, faster, and more sustainably.</p><h2><strong>The Challenges Modern Startups Face</strong></h2><p>Before understanding the solution, it is important to understand the problems startups experience today.</p><p>Modern startups struggle with multiple pressures.</p><h3><strong>Limited Teams and Resources</strong></h3><p>Most startups operate with small teams. Founders often manage multiple roles at once. Hiring too quickly increases expenses, but not hiring limits growth. This creates constant tension.</p><h3><strong>Operational Overload</strong></h3><p><br></p>', 'uploads/posts/698db41772464.webp', 'News', 'Published', 0, '2026-02-12 12:06:11', '2026-02-12 11:05:59'),
(7, 1, '3rd Mega Award Function Panchkula', '3rd Mega Award Function Panchkula', '<p>1 फरवरी को पंचकुला–चंडीगढ़ स्थित पल्लवी ग्रैंड होटल में ज्योतिष ज्ञान संस्था ( अंकिता राजीव शर्मा जी ) द्वारा आईबीएसईए के सहयोग से एक भव्य मेगा अवॉर्ड फंक्शन का आयोजन किया गया। इस गरिमामय कार्यक्रम में लगभग 100 सनातनी विद्वानों और साधकों ने सहभागिता की और इस विषय पर सार्थक संवाद हुआ कि कैसे ज्योतिष एवं विविध आध्यात्मिक विद्याओं के माध्यम से भारत पुनः विश्व गुरु बनने की दिशा में अग्रसर हो सकता है।</p><p>मुख्य अतिथि के रूप में अपने संबोधन में मैंने साझा किया कि हमारी संस्कृति हमें “अहं ब्रह्मास्मि” का जो अर्थ सिखाती है, वह यह नहीं कि “मैं श्रेष्ठ हूँ”, बल्कि यह कि “मैं भी उसी परम चेतना का अंश हूँ।” याद रखिए — “मैं श्रेष्ठ हूँ” आत्मविश्वास है, लेकिन “मैं ही श्रेष्ठ हूँ” अहंकार है। भारत की परंपरा हमेशा जोड़ने वाली रही है, तोड़ने वाली नहीं। हम वसुधैव कुटुम्बकम में विश्वास करते हैं — पूरी दुनिया एक परिवार है। हम गाय को माता कहते हैं, वृक्षों की पूजा करते हैं, और मानते हैं कि कण-कण में ईश्वर है। हमारे हर पर्व का एक गहन उद्देश्य है।</p><p>अपने वक्तव्य में मैंने 2025 के प्रयागराज महाकुंभ का भी उल्लेख किया, जहाँ 45 दिनों में लगभग 66 करोड़ श्रद्धालुओं की सहभागिता हुई — यह विश्व का सबसे बड़ा मानव समागम बना। यह केवल आस्था नहीं थी, यह भारत की चेतना का उत्सव था। इस विराट उपस्थिति ने एक बार फिर सिद्ध किया कि भारत आज भी अपनी संस्कृति और मूल्यों से गहराई से जुड़ा हुआ है। हमारे शास्त्र कहते हैं — “यदा यदा हि धर्मस्य ग्लानिर्भवति भारत,” अर्थात जब-जब समाज मार्ग से भटकता है, तब-तब धर्म स्वयं मार्ग दिखाने आता है — और तब आप जैसे लोग सामने आते हैं, युवाओं का उत्थान करते हैं और संस्कृति का पुनर्जागरण करते हैं।</p><p>मैंने यह भी रेखांकित किया कि आज आध्यात्मिकता केवल मंदिरों तक सीमित नहीं है। हम एक ऐसे युग में हैं जहाँ मोबाइल ऐप्स, एआई, डिजिटल प्लेटफॉर्म और टेक्नोलॉजी के माध्यम से आध्यात्म हर युवा तक पहुँच रहा है। Gen Z की भागीदारी तेज़ी से बढ़ रही है। आज फेथ-टेक इंडस्ट्री का वैश्विक मार्केट साइज लगभग 65 बिलियन डॉलर, यानी करीब 5 लाख करोड़ रुपये है। कई स्टार्टअप्स ने उल्लेखनीय फंडिंग जुटाई है और ई-पूजा, ई-प्रसाद तथा अन्य डिजिटल संसाधनों के माध्यम से हर घर तक सेवाएँ पहुँचा रहे हैं। भारत में इस समय 900 से अधिक स्पिरिचुअल टेक स्टार्टअप्स सक्रिय हैं, और कोविड के बाद डिजिटल आध्यात्मिक सेवाओं की मांग में अभूतपूर्व वृद्धि हुई है।</p><p>हालाँकि मैंने एक महत्वपूर्ण प्रश्न भी उठाया — क्या आध्यात्म केवल बिजनेस है? मेरा उत्तर स्पष्ट था: नहीं। आध्यात्म सिर्फ बिजनेस नहीं है; आध्यात्म भारत की आत्मा है। इसी भाव को मैंने इस श्लोक के माध्यम से व्यक्त किया —</p><p>“अयं निजः परो वेति गणना लघुचेतसाम्।</p><p>उदारचरितानां तु वसुधैव कुटुम्बकम्॥”</p><p>अपने संबोधन का समापन मैंने अटल बिहारी वाजपेयी जी की प्रेरणादायी पंक्तियों</p><p>भारत जमीन का टुकड़ा नहीं, जीता जागता राष्ट्रपुरुष है.यह चन्दन की भूमि है, अभिनन्दन की भूमि है, यह तर्पण की भूमि है, यह अर्पण की भूमि है. इसका कंकर-कंकर शंकर है, इसका बिन्दु-बिन्दु गंगाजल है. हम जिएंगे तो इसके लिए और शाम से मारेंगे भी तो इसके लिए ।</p><p>से किया और यह भी साझा किया कि मेरा संगठन 21वीं सदी के विकसित भारत के निर्माण हेतु 21 अलग-अलग क्षेत्रों में सक्रिय रूप से कार्य कर रहा है, जिनमें होलिस्टिक हेल्थकेयर एक अत्यंत महत्वपूर्ण क्षेत्र है। मैंने यह भी बताया कि आईबीएससी का “व्यापार बढ़ाओ एलायंस” आध्यात्मिक हीलर्स को उनके कार्य का विस्तार करने और उन्हें टेक्नोलॉजी से जोड़ने में कैसे सहयोग कर सकता है।</p>', 'uploads/posts/698f6002040ef.jpg', 'News', 'Published', 1, '2026-02-13 13:43:36', '2026-02-13 12:43:36'),
(8, 1, 'India@2047 Conference & भारत के महारथी सम्मान के 4th Edition', 'India@2047 Conference & भारत के महारथी सम्मान के 4th Edition', '<p>30 नवंबर 2025 — नई दिल्ली के प्रतिष्ठित NDMC Convention Centre में आयोजित India@2047 Conference &amp; भारत के महारथी सम्मान के 4th Edition को सफलतापूर्वक संपन्न होते देखना मेरे लिए गर्व और सम्मान का क्षण रहा।</p><p>इस आयोजन के Organising Team का हिस्सा बनकर, देशभर से आए 700+ उद्यमी, निवेशक, इनोवेटर्स, शोधकर्ता और पॉलिसी मेकर्स को एक ही प्लेटफ़ॉर्म पर जोड़ना वाकई एक ऐतिहासिक कदम था। 13 घंटे तक चले इस भव्य कार्यक्रम में 30 से अधिक राष्ट्रीय स्तर के वक्ताओं ने Viksit Bharat @ 2047 के विज़न पर अपने विचार, अनुभव और योगदान साझा किए।</p><p>कार्यक्रम के दौरान न सिर्फ पैनल डिस्कशन और नॉलेज सेशंस हुए, बल्कि B2B और B2G कनेक्ट के ज़रिये वास्तविक बिजनेस अवसर भी बने। Exhibitions, Launches, Networking — हर सेक्शन का उद्देश्य था कौशल, उद्यमिता और तकनीक को साथ लेकर भारत के विकास को तेज करना।</p><p>IBSEA के मिशन “जिन्होंने बढ़ाया देश का मान — हर साल हम करते हैं 50 महारथियों का सम्मान” को आगे बढ़ाते हुए, इस वर्ष 50 और प्रतिष्ठित व्यक्तित्वों को “भारत के महारथी सम्मान” से सम्मानित किया गया — और अब यह संख्या 200 हो चुकी है।</p><p>बिहार से आकर, मैं हमेशा मानता हूँ — छोटे शहरों के बड़े सपने ही भारत को विकसित बनाएंगे <img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tf4/1/16/2728.png\" alt=\"✨\" height=\"16\" width=\"16\"></p><p>स्टार्टअप इकोसिस्टम, डिजिटल ग्रोथ और AI स्किल डेवलपमेंट को बढ़ावा देकर Vocal for Local से Local to Global की दिशा में अपना योगदान देने का सौभाग्य मुझे मिल रहा है <img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tb3/1/16/1f1ee_1f1f3.png\" alt=\"🇮🇳\" height=\"16\" width=\"16\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tc6/1/16/1f680.png\" alt=\"🚀\" height=\"16\" width=\"16\"></p><p>इस सफल आयोजन के लिए अपनी पूरी टीम, सहयोगी संगठनों, स्टेट लीडर्स और सभी समर्थकों का दिल से आभार <img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t80/1/16/1f64f.png\" alt=\"🙏\" height=\"16\" width=\"16\"></p>', 'uploads/posts/698f5ee75a38a.jpg', 'Blog', 'Published', 1, '2026-02-13 18:27:54', '2026-02-13 17:27:03'),
(9, 1, '2-Day Safety & Disaster Management Leadership Training Program Theme:Safe Rail, Safe India', '2-Day Safety & Disaster Management Leadership Training Program Theme:Safe Rail, Safe India', '<p>2-Day Safety &amp; Disaster Management Leadership Training Program</p><p>Theme:Safe Rail, Safe India</p><p>Organised by: All India Rail Safety Council (AIRSC)</p><p>Dates:</p><p>27th &amp; 28th December 2025</p><p>Venue:</p><p>Laghu Udyog Bharati, Pandit Deendayal Upadhyay Marg, New Delhi</p><p>Powered By</p><p>IBSEA - International Business Startup &amp; Entrepreneurs Association</p>', 'uploads/posts/698f60e7996d1.jpg', 'Blog', 'Published', 1, '2026-02-13 18:35:35', '2026-02-13 17:35:35'),
(10, 1, 'Prime Minister Narendra Modi approved the Startup India Fund of Funds (FFS) 2.0', 'Prime Minister Narendra Modi approved the Startup India Fund of Funds (FFS) 2.0', '<p>Prime Minister Narendra Modi approved the Startup India Fund of Funds (FFS) 2.0 with a corpus of ₹10,000 crore on February 13, 2026. This was among the first major decisions taken by the Prime Minister from his new office complex, Seva Teerth.&nbsp;</p><p>Key Details of Startup India Fund of Funds 2.0</p><p>The new fund is designed to build upon the success of the original 2016 initiative and focuses on the following:</p><p>Focus Areas: Support for early-stage startups, deep-tech research, advanced manufacturing, and breakthrough technologies.</p><p>Operational Model: Managed by the Small Industries Development Bank of India (SIDBI), it provides capital to SEBI-registered Alternative Investment Funds (AIFs), which then invest in startups.</p><p>Leverage Requirement: AIFs supported by the fund are required to invest at least two times the amount committed by the FFS into startups.</p><p>Inclusive Funding: 25% of the corpus is specifically focused on women-led entrepreneurship, and another 25% is mandated for climate action and sustainability.</p>', 'uploads/posts/69903e524ed33.png', 'News', 'Published', 0, '2026-02-14 09:20:18', '2026-02-14 09:20:18'),
(11, 1, 'Govt clears Rs 10,000 crore Startup India Fund of Funds 2.0', 'Govt clears Rs 10,000 crore Startup India Fund of Funds 2.0', '<p><span style=\"background-color: rgb(255, 255, 255);\">New Delhi: The Union cabinet on Friday gave its approval to the second tranche of the Startup India Fund of Funds Scheme (FFS) with a corpus of ₹ 10,000 crore. The FFS 2.0 for startups, unveiled in the budget for 2025-26, focuses on the manufacturing and high-technology sectors, which require longer-term funding.</span></p>', 'uploads/posts/6990413a7d3cc.png', 'News', 'Published', 0, '2026-02-14 09:32:42', '2026-02-14 09:32:42'),
(12, 1, 'Appreciations Letter From Ministers and Universities', 'Appreciations Letter From Ministers and Universities', '<p>Appreciations Letter From Ministers and Universities</p>', 'uploads/posts/69904215cf98a.jpeg', 'Blog', 'Published', 1, '2026-02-14 09:36:21', '2026-02-14 09:36:21'),
(13, 1, 'Anshumaan Singh’s work has been highlighted by national media countless times,', 'Anshumaan Singh’s work has been highlighted by national media countless times,', '<p>Anshumaan Singh’s work has been highlighted by national media countless times,</p>', 'uploads/posts/6990427a9c3d0.jpeg', 'Blog', 'Published', 1, '2026-02-14 09:38:02', '2026-02-14 09:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `updated_at`) VALUES
('allow_certificate_download', '0', '2026-02-12 10:35:46'),
('allow_id_card_download', '0', '2026-02-12 10:35:46'),
('allow_ticket_download', '0', '2026-02-12 10:35:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`type`);

--
-- Indexes for table `councils`
--
ALTER TABLE `councils`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_date` (`event_date`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_bookings`
--
ALTER TABLE `event_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD PRIMARY KEY (`registration_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `registrant_email` (`registrant_email`),
  ADD KEY `payment_status` (`payment_status`);

--
-- Indexes for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `leadership_assignments`
--
ALTER TABLE `leadership_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chapter_id` (`chapter_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_2` (`email`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_roles`
--
ALTER TABLE `member_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `councils`
--
ALTER TABLE `councils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_bookings`
--
ALTER TABLE `event_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event_registrations`
--
ALTER TABLE `event_registrations`
  MODIFY `registration_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_tickets`
--
ALTER TABLE `event_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leadership_assignments`
--
ALTER TABLE `leadership_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `member_roles`
--
ALTER TABLE `member_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_bookings`
--
ALTER TABLE `event_bookings`
  ADD CONSTRAINT `event_bookings_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_bookings_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_bookings_ibfk_3` FOREIGN KEY (`ticket_id`) REFERENCES `event_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_bookings_ibfk_4` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_registrations`
--
ALTER TABLE `event_registrations`
  ADD CONSTRAINT `event_registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `event_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_registrations_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_tickets`
--
ALTER TABLE `event_tickets`
  ADD CONSTRAINT `event_tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leadership_assignments`
--
ALTER TABLE `leadership_assignments`
  ADD CONSTRAINT `leadership_assignments_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leadership_assignments_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
