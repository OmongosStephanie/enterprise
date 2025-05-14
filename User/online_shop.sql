-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 07:38 PM
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
-- Database: `online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'luna', '', '$2y$10$v5TyzLIsyJ3CqmKRBWShduJFuKjF1F.9n7rhacA/dh.7YOOLBbbaO', '2025-05-08 15:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `beverages`
--

CREATE TABLE `beverages` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `inventory_quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beverages`
--

INSERT INTO `beverages` (`product_id`, `product_name`, `price`, `image_url`, `inventory_quantity`, `created_at`) VALUES
(1, 'Coca Cola', 40.00, 'https://imgs.search.brave.com/9Y6xC6W-UcL7pNVMiFcxScUDo_Bsawb_X4MuovU1zZs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzM4LzY2Lzc0/LzM2MF9GXzQzODY2/NzQzMF95U2hxTW1Y/QXVIZWpsaEo5OW5S/dWJwZXhBbDE4cmZR/Zy5qcGc', 100, '2025-05-10 10:27:00'),
(2, 'Pepsi', 55.00, 'https://imgs.search.brave.com/EezPVqFE2sCv38wKrOHcAV8FKASuHSKVlIKIBkLhZns/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzY0LzIwLzc2/LzM2MF9GXzQ2NDIw/NzY5Ml9MOTFGckhO/YmVYeVQ4WkQxV0lY/TU5lMDhqc0pLSjFL/cS5qcGc', 130, '2025-05-10 10:27:00'),
(3, 'Sprite', 25.00, 'https://imgs.search.brave.com/MqPh-_2J5EMnkX-Rf-n5AVcOqswBr26m8x03kvzTxok/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA1LzUwLzAyLzMw/LzM2MF9GXzU1MDAy/MzA4M19qVENGbHhx/cWt2WUNWdFVVMkli/MVN1ZUJuVHg5WE1N/aS5qcGc', 90, '2025-05-10 10:27:00'),
(4, 'Tropicana Orange Juice', 60.00, 'https://imgs.search.brave.com/-l_OSOS86WQy7XXpxEwXF5iOk7UBuQ6oUp7eFK5PwjQ/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMuY2RuLnNob3By/aXRlLmNvbS9kZXRh/aWwvMDAwNDg1MDAy/MDYwMzRfMQ.jpeg', 150, '2025-05-10 10:27:00'),
(5, '7UP', 35.00, 'https://imgs.search.brave.com/BW_e7h_D4fpPz9Qtq9bthhqxkIdctbPGr3yy-CRxNnk/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA1LzMxLzMxOC8z/NzYyXzBfQ2dyYjBk/MTAzYl9pY0Fqb0ph/Sm5LU2hzMi5qcGc', 60, '2025-05-10 10:27:00'),
(6, 'Mountain Dew', 50.00, 'https://imgs.search.brave.com/Xc34ocAv7JxyXH0tVzTRc5Xzje7A9yFZj8B9TeGTeik/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA3LzMzLzA4LzUz/LzQxMV9pWVhMZXc5eUtVbHZNX1VTV2QyST9HdVlzMy5qcGc', 110, '2025-05-10 10:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `product_name`, `price`, `image_url`, `quantity`, `category`) VALUES
(1, 'Coca-Cola', 40.00, 'https://imgs.search.brave.com/9Y6xC6W-UcL7pNVMiFcxScUDo_Bsawb_X4MuovU1zZs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzM4LzY2Lzc0/LzM2MF9GXzQzODY2/NzQzMF95U2hxTW1Y/QXVIZWpsaEo5OW5S/dWJwZXhBbDE4cmZR/Zy5qcGc', 100, 'beverages'),
(2, 'Tropicana Orange Juice', 60.00, 'https://imgs.search.brave.com/-l_OSOS86WQy7XXpxEwXF5iOk7UBuQ6oUp7eFK5PwjQ/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly9pbWFn/ZXMuY2RuLnNob3By/aXRlLmNvbS9kZXRh/aWwvMDAwNDg1MDAy/MDYwMzRfMQ.jpeg', 150, 'beverages'),
(3, 'Whole Wheat Bread', 50.00, 'https://imgs.search.brave.com/EUzV-sR7WybSKXeT7ZO2XO0APIUDy4aFXYGc0tuF6dc/rs:fit:500:0:0:0/g:ce/aHR0cHM6Ly90cm95/ZXJzbW91bnRhaW52/aWV3LmNvbS93cC1j/b250ZW50L3VwbG9h/ZHMvMjAyNC8wMy9Q/WExfMjAyNDAzMjZf/MjA0NDU5NTc3Lmpw/ZWc', 80, 'Bread and Bakery'),
(4, 'Croissant', 40.00, 'https://imgs.search.brave.com/33AGzk7j-MEg4ldfcICoHhZNYGVhYkr766i31pJ6Sjo/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzAwLzQ1Lzc4LzEy/LzM2MF9GXzQ1Nzgx/MjkwX1dha1N5VW9t/SEtURmswaVlwVHNk/c1ZLVnpaN1RrZ0I2/LmpwZw', 200, 'Bread and Bakery'),
(5, 'Baguette', 40.00, 'https://imgs.search.brave.com/oQQCK7xVXmc-JD0As1F2pPlFXbHO6eoyzy43moZ5mo8/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzEyLzg3LzM4LzMz/LzM2MF9GXzEyODcz/ODMzMTlfbnFBSG5T/WUFiYjlCV2pscHhx/WlJPM09ERWxwVXY0/Y3IuanBn', 120, 'Bread and Bakery'),
(6, 'Banana Bread', 45.00, 'https://imgs.search.brave.com/9k_cshuQGBzITeaGJvAKOoZrdArKyztPsZVing-u_hc/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzAwLzg3LzIyLzIx/LzM2MF9GXzg3MjIy/MTA5Xzh2NDVPa2ht/Rm9kWGFBaUpkN29t/dk55am1ITUN4OTd2/LmpwZw', 75, 'Bread and Bakery'),
(7, 'Pepsi', 55.00, 'https://imgs.search.brave.com/EezPVqFE2sCv38wKrOHcAV8FKASuHSKVlIKIBkLhZns/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzY0LzIwLzc2/LzM2MF9GXzQ2NDIw/NzY5Ml9MOTFGckhO/YmVYeVQ4WkQxV0lY/TU5lMDhqc0pLSjFL/cS5qcGc', 130, 'beverages'),
(8, 'Sprite', 25.00, 'https://imgs.search.brave.com/MqPh-_2J5EMnkX-Rf-n5AVcOqswBr26m8x03kvzTxok/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA1LzUwLzAyLzMw/LzM2MF9GXzU1MDAy/MzA4M19qVENGbHhx/cWt2WUNWdFVVMkli/MVN1ZUJuVHg5WE1N/aS5qcGc', 90, 'beverages'),
(9, '7UP', 35.00, 'https://imgs.search.brave.com/pzW2BEWgUyUNJH8WlbmNDr74cgtRejsugVFd5ZvMcxQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pbWcu/dGhlY2RuLmluLzMx/OTU1MS8xLTE3MTY4/MTU3ODg0MDcucG5n/P3dpZHRoPTYwMCZm/b3JtYXQ9d2VicA', 60, 'beverages'),
(10, 'Mountain Dew', 50.00, 'https://imgs.search.brave.com/_NO5kJII2K0vyW8KM6kbPFkiBhUmW31VRrSg4OLHMVE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/aGFyZG1vdW50YWlu/ZGV3LmNvbS9Db250/ZW50L19pbWcvc3dp/cGVyQ2FuX09yaWdp/bmFsLnBuZw', 110, 'beverages'),
(13, 'Whole Wheat Bread', 100.00, 'https://imgs.search.brave.com/EezPVqFE2sCv38wKrOHcAV8FKASuHSKVlIKIBkLhZns/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA0LzY0LzIwLzc2/LzM2MF9GXzQ2NDIw/NzY5Ml9MOTFGckhO/YmVYeVQ4WkQxV0lY/TU5lMDhqc0pLSjFL/cS5qcGc', 60, NULL),
(14, 'Chocolate Muffin', 40.00, 'https://imgs.search.brave.com/dgBfXcOxunXnvWKjDDuAyApTaeGtete4n_xjJfjNERs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pNS53/YWxtYXJ0aW1hZ2Vz/LmNvbS9kZncvNGZm/OWM2YzktOTczNi9r/Mi1fNGIzNjRmMmIt/ODk4My00YTRkLWI0/NGItZGUyODFmYWFm/MWNmLnYxLndlYnA', 200, 'Bread and Bakery');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `membership_plan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `benefits` text DEFAULT '',
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `name`, `email`, `password`, `membership_plan`, `created_at`, `benefits`, `price`) VALUES
(1, 'steph', 'watermelonsuga014@gmail.com', '$2y$10$T7yENc5ekvvU7AVMKs.AB.piobwpgdkcQNOVK.dkHSlVlTSYekPZu', 'basic', '2025-05-10 14:34:13', '✔ Access to weekly deals<br>✔ Monthly newsletter', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `membership_plans`
--

CREATE TABLE `membership_plans` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `benefits` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `street` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tracking_number` varchar(100) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `estimated_delivery_date` date DEFAULT NULL,
  `actual_delivery_date` date DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Pending',
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `delivered_at` datetime DEFAULT NULL,
  `delivery_person` varchar(255) DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `branch`, `location`, `street`, `total`, `created_at`, `tracking_number`, `order_status`, `estimated_delivery_date`, `actual_delivery_date`, `payment_status`, `status`, `delivered_at`, `delivery_person`, `delivered_date`) VALUES
(1, 0, 'stephanie Omongos', 'Dahilayan', 'Del Monte Pineapple Plantation', 'agusan', 50.00, '2025-05-09 01:15:47', NULL, NULL, NULL, NULL, 'Pending', 'delivered', NULL, NULL, NULL),
(2, 0, 'stephanie Omongos', 'Manolo', 'lingion', 'Zone 7 lingion', 40.00, '2025-05-09 01:18:51', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(3, 0, 'stephanie Omongos', 'Manolo', 'lingion', 'Zone 7 lingion', 40.00, '2025-05-09 03:47:42', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(4, 1, 'stephanie Omongos', 'Manolo', 'lingion', 'Zone 7 lingion', 45.00, '2025-05-09 03:52:03', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(5, 1, 'stephanie Omongos', 'Manolo', 'San Miguel', 'pch2', 140.00, '2025-05-09 03:55:04', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(6, 1, 'luna', 'Manolo', 'Dicklum', 'zone 2', 55.00, '2025-05-09 04:05:50', NULL, NULL, NULL, NULL, 'Pending', 'delivered', NULL, NULL, NULL),
(7, 1, 'stephanie Omongos', 'Manolo', 'Dicklum', 'zone 2', 60.00, '2025-05-10 08:49:16', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(8, 2, 'tephanie gurl', 'Manolo', 'San Miguel', 'zone 2 san miguel', 45.00, '2025-05-10 09:05:06', NULL, NULL, NULL, NULL, 'Pending', 'delivered', NULL, NULL, NULL),
(9, 1, 'luna', 'Manolo', 'Manolo Fortich Market', 'Manoli', 70.00, '2025-05-10 11:42:42', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(10, 1, 'sadii', 'Dahilayan', 'Kalugmanan', 'zone 2', 230.00, '2025-05-10 13:50:59', NULL, NULL, NULL, NULL, 'Pending', 'delivered', NULL, NULL, NULL),
(11, 1, 'Frich', 'Manolo', 'Northern Bukidnon State College', 'Kihare ', 220.00, '2025-05-11 14:10:03', NULL, NULL, NULL, NULL, 'Pending', 'delivered', NULL, 'Luna', '2025-05-11 00:00:00'),
(12, 1, 'stephanie Omongos', 'Manolo', 'lingion', 'Zone 7 lingion', 135.00, '2025-05-12 12:03:43', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(13, 2, 'stephanie', 'Manolo', 'Manolo Fortich Market', 'Market', 115.00, '2025-05-14 16:07:02', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(14, 2, 'ffr', 'Dahilayan', 'Dahilayan Adventure Park', 'wetw', 55.00, '2025-05-14 16:07:46', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(15, 2, 'stephanie', 'Manolo', 'lingion', 'Zone 7 lingion', 55.00, '2025-05-14 16:13:57', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL),
(16, 2, 'stephanie', 'Manolo', 'San Miguel', 'PCH2', 40.00, '2025-05-14 16:16:11', NULL, NULL, NULL, NULL, 'Pending', 'Pending', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 'Croissant', 50.00, 1, 50.00),
(2, 2, 'Baguette', 40.00, 1, 40.00),
(3, 3, 'Baguette', 40.00, 1, 40.00),
(4, 4, 'Banana Bread', 45.00, 1, 45.00),
(5, 5, 'Baguette', 40.00, 2, 80.00),
(6, 5, 'Tropicana Orange Juice', 60.00, 1, 60.00),
(7, 6, 'Pepsi', 55.00, 1, 55.00),
(8, 7, 'Tropicana Orange Juice', 60.00, 1, 60.00),
(9, 8, 'Banana Bread', 45.00, 1, 45.00),
(10, 9, 'Whole Wheat Bread', 35.00, 2, 70.00),
(11, 10, 'Pepsi', 55.00, 2, 110.00),
(12, 10, 'Tropicana Orange Juice', 60.00, 2, 120.00),
(13, 11, 'Croissant', 40.00, 2, 80.00),
(14, 11, 'Tropicana Orange Juice', 60.00, 1, 60.00),
(15, 11, 'Chocolate Muffin', 40.00, 1, 40.00),
(16, 11, 'Coca-Cola', 40.00, 1, 40.00),
(17, 12, 'Tropicana Orange Juice', 60.00, 1, 60.00),
(18, 12, '7UP', 35.00, 1, 35.00),
(19, 12, 'Baguette', 40.00, 1, 40.00),
(20, 13, 'Tropicana Orange Juice', 60.00, 1, 60.00),
(21, 13, 'Pepsi', 55.00, 1, 55.00),
(22, 14, 'Pepsi', 55.00, 1, 55.00),
(23, 15, 'Pepsi', 55.00, 1, 55.00),
(24, 16, 'Baguette', 40.00, 1, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `inventory_quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image_url`, `category`, `inventory_quantity`) VALUES
(1, 'Whole Wheat Bread', 2.99, 'https://images.unsplash.com/photo-1611920624981-bbdf2806a5d7?auto=format&fit=crop&w=800&q=80', NULL, 0),
(2, 'Croissant', 1.49, 'https://images.unsplash.com/photo-1608198093002-ad4e005484f9?auto=format&fit=crop&w=800&q=80', NULL, 0),
(3, 'Baguette', 1.99, 'https://images.unsplash.com/photo-1631771395736-c62d9aaff086?auto=format&fit=crop&w=800&q=80', NULL, 0),
(4, 'Banana Bread', 3.49, 'https://images.unsplash.com/photo-1603046891443-b69a1ec1e2d0?auto=format&fit=crop&w=800&q=80', NULL, 0),
(5, 'Chocolate Muffin', 40.00, 'https://imgs.search.brave.com/dgBfXcOxunXnvWKjDDuAyApTaeGtete4n_xjJfjNERs/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9pNS53/YWxtYXJ0aW1hZ2Vz/LmNvbS9kZncvNGZm/OWM2YzktOTczNi9r/Mi1fNGIzNjRmMmIt/ODk4My00YTRkLWI0/NGItZGUyODFmYWFm/MWNmLnYxLndlYnA', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `purchased_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Manager','Employee') NOT NULL DEFAULT 'Employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Luna', 'claire', 'claire123@gmail.com', '$2y$10$VR2UzzuhzczRPgC4EdQ2qeLxVN4RA8J.ot4WmW1Bl1gubgHRnCpyS', 'Employee', '2025-05-14 17:36:59', '2025-05-14 17:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `signup_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `contact_number`, `address`, `email`, `birthday`, `password`, `created_at`, `signup_date`, `verified`) VALUES
(1, 'stephanie', 'omongos', '09657860501', 'Zone 7 lingion', 'stephanieomongos05@gmail.com', '2004-09-07', '$2y$10$fNeIeKkQAgK7kEDxwdl3EeChsPv70dKe/OMl2j51zLUpiKyWa6Cbm', '2025-05-05 13:12:44', '2025-05-14 15:35:10', 0),
(2, 'tephanie', 'gurl', '09657860501', 'manolo fortich', 'watermelonsuga014@gmail.com', '2004-09-07', '$2y$10$G8RTvguQK9/CCG1nR4hs6OHR7xm.MMSCvyq7j8FnR5QvoI89FyhFW', '2025-05-10 09:03:58', '2025-05-14 15:35:10', 0),
(4, 'luna', 'artemis', '09657860501', 'dicklum', 'stephanieomongos23@gmail.com', '2007-06-12', '$2y$10$HEQEDzcJ7hMwr0qhXq3mHuGfxD8ZPBJJT8DSR23026oukjznAIOu.', '2025-05-10 09:24:38', '2025-05-14 15:35:10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipping_date` datetime DEFAULT NULL,
  `estimated_delivery_date` datetime DEFAULT NULL,
  `actual_delivery_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `beverages`
--
ALTER TABLE `beverages`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `membership_plans`
--
ALTER TABLE `membership_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beverages`
--
ALTER TABLE `beverages`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `membership_plans`
--
ALTER TABLE `membership_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_history_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `user_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
