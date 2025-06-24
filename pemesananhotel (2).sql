-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 05:38 PM
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
-- Database: `pemesananhotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('super_admin','admin','staff') DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `full_name`, `email`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hikmatyar04', 'admin@purqon.com', 'super_admin', 1, NULL, '2025-05-27 09:48:29', '2025-06-24 14:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','checked_in','checked_out','cancelled') DEFAULT 'pending',
  `special_requests` text DEFAULT NULL,
  `adults` int(11) DEFAULT 1,
  `children` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `hotel_id`, `room_id`, `name`, `email`, `phone`, `check_in`, `check_out`, `total_price`, `created_at`, `status`, `special_requests`, `adults`, `children`, `updated_at`) VALUES
(1, 6, 1, 14, 'Diaz Azhar', 'diaz@example.com', '081234567891', '2025-05-02', '2025-05-03', 601120, '2025-06-24 15:00:48', 'confirmed', 'Mohon kamar di lantai tinggi', 2, 0, '2025-06-24 15:00:48'),
(2, 6, 2, 16, 'Shota', 'shota@example.com', '081234567892', '2025-05-03', '2025-05-04', 375572, '2025-06-24 15:00:48', 'checked_out', 'Membutuhkan tempat tidur tambahan', 2, 1, '2025-06-24 15:04:41'),
(3, 6, 4, 18, 'Masamune Date', 'masamune@example.com', '081234567893', '2025-04-30', '2025-05-01', 269339, '2025-06-24 15:00:48', 'checked_out', 'Mohon early check-in jika memungkinkan', 1, 0, '2025-06-24 15:00:48'),
(4, 6, 1, 15, 'Hinata', 'hinata@example.com', '081234567894', '2025-05-01', '2025-05-02', 466374, '2025-06-24 15:00:48', 'checked_in', 'Merayakan anniversary', 2, 0, '2025-06-24 15:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `hotel_id`, `nama`, `deskripsi`, `icon`, `is_available`) VALUES
(1, 1, 'Kolam Renang', 'Kolam renang outdoor dengan view yang indah', 'pool', 1),
(2, 1, 'Restoran', 'Restoran dengan berbagai menu lokal dan internasional', 'restaurant', 1),
(3, 1, 'Gym', 'Fasilitas gym lengkap 24 jam', 'gym', 1),
(4, 2, 'Spa', 'Layanan spa dan pijat profesional', 'spa', 1),
(5, 2, 'Parkir Gratis', 'Area parkir luas dan aman', 'parking', 1),
(6, 3, 'Meeting Room', 'Ruangan meeting untuk acara bisnis', 'meeting', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `nama`, `alamat`, `rating`, `gambar`, `deskripsi`, `website`, `latitude`, `longitude`) VALUES
(1, 'CORDELA HOTEL', 'Jl.Yudanegara Kota Tasikmalaya', 4.0, 'cordela.jpg', 'Hotel bintang 4 dengan fasilitas lengkap dan pelayanan terbaik di Tasikmalaya', NULL, NULL, NULL),
(2, 'HORISON HOTEL', 'Jl.Yudanegara Kota Tasikmalaya', 5.0, 'horison.jpg', 'Hotel mewah bintang 5 dengan kolam renang infinity dan spa kelas dunia', NULL, NULL, NULL),
(3, 'SANTIKA HOTEL', 'Jl.Yudanegara Kota Tasikmalaya', 3.0, 'santika.jpg', 'Hotel nyaman dengan harga terjangkau untuk perjalanan bisnis maupun liburan', NULL, NULL, NULL),
(4, 'CITY HOTEL', 'Jl.Sukalaya Kota Tasikmalaya', 4.0, 'city.jpg', 'Hotel modern di pusat kota dengan akses mudah ke berbagai tempat wisata', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `passwordresets`
--

CREATE TABLE `passwordresets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` enum('transfer','cash','credit_card','debit_card','e_wallet') NOT NULL,
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `payment_date` datetime DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `payment_status`, `payment_date`, `transaction_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 601120, 'transfer', 'completed', '2025-05-01 14:30:00', 'TRX001', 'Pembayaran lunas via BCA', '2025-06-24 15:00:48', '2025-06-24 15:00:48'),
(2, 2, 375572, 'credit_card', 'pending', NULL, 'TRX002', 'Menunggu konfirmasi pembayaran', '2025-06-24 15:00:48', '2025-06-24 15:00:48'),
(3, 3, 269339, 'cash', 'completed', '2025-04-30 10:15:00', 'TRX003', 'Pembayaran saat check-in', '2025-06-24 15:00:48', '2025-06-24 15:00:48'),
(4, 4, 466374, 'e_wallet', 'completed', '2025-04-30 18:45:00', 'TRX004', 'Pembayaran via OVO', '2025-06-24 15:00:48', '2025-06-24 15:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL,
  `komentar` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `hotel_id`, `booking_id`, `rating`, `komentar`, `created_at`) VALUES
(1, 6, 1, 1, 4.5, 'Pelayanan sangat baik, kamar bersih dan nyaman', '2025-06-24 15:00:48'),
(2, 6, 2, 2, 5.0, 'Pengalaman menginap yang luar biasa! Fasilitas lengkap dan staff ramah', '2025-06-24 15:00:48'),
(3, 6, 4, 3, 3.5, 'Cukup baik untuk harganya, tapi sarapan bisa ditingkatkan', '2025-06-24 15:00:48');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `room_type` varchar(100) DEFAULT NULL,
  `available_rooms` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `description` text DEFAULT NULL,
  `max_guests` int(11) DEFAULT 2,
  `gambar` varchar(255) DEFAULT NULL,
  `has_ac` tinyint(1) DEFAULT 1,
  `has_tv` tinyint(1) DEFAULT 1,
  `has_wifi` tinyint(1) DEFAULT 1,
  `has_breakfast` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `hotel_id`, `room_type`, `available_rooms`, `price`, `is_available`, `description`, `max_guests`, `gambar`, `has_ac`, `has_tv`, `has_wifi`, `has_breakfast`) VALUES
(6, 1, 'Deluxe Room', 1, 450000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(7, 1, 'Superior Room', 2, 600000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(8, 2, 'Deluxe Room', 2, 800000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(9, 2, 'Superior Room', 2, 650000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(10, 3, 'Deluxe Room', 1, 550000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(11, 3, 'Superior Room', 2, 700000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(12, 4, 'Deluxe Room', 2, 500000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(13, 4, 'Superior Room', 2, 600000, 1, NULL, 2, NULL, 1, 1, 1, 0),
(14, 1, 'Standard', 10, 450000, 1, 'Kamar standar dengan AC dan TV', 2, 'standard.jpg', 1, 1, 1, 0),
(15, 1, 'Deluxe', 5, 750000, 1, 'Kamar lebih luas dengan fasilitas premium', 2, 'deluxe.jpg', 1, 1, 1, 0),
(16, 2, 'Suite', 8, 1200000, 1, 'Kamar mewah dengan ruang tamu terpisah', 4, 'suite.jpg', 1, 1, 1, 0),
(17, 3, 'Executive', 3, 2000000, 1, 'Kamar VIP dengan fasilitas lengkap', 2, 'executive.jpg', 1, 1, 1, 0),
(18, 4, 'Standard', 12, 400001, 1, 'Kamar standar nyaman', 2, 'standard2.jpg', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`id`, `room_id`, `nama`, `deskripsi`, `icon`) VALUES
(1, 14, 'AC', 'Air conditioner dengan pengatur suhu', 'ac'),
(2, 14, 'TV', 'TV layar datar 32 inch', 'tv'),
(3, 14, 'WiFi', 'Koneksi internet gratis', 'wifi'),
(4, 15, 'Mini Bar', 'Mini bar dengan minuman ringan', 'minibar'),
(5, 15, 'Bathub', 'Bathub mewah', 'bathub'),
(6, 16, 'Living Room', 'Ruang tamu terpisah', 'livingroom'),
(7, 16, 'Coffee Maker', 'Mesin pembuat kopi', 'coffee');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_ponsel` varchar(20) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji` int(11) DEFAULT NULL,
  `tanggal_bergabung` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `hotel_id`, `nama`, `email`, `nomor_ponsel`, `jabatan`, `gaji`, `tanggal_bergabung`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Budi Santoso', 'budi@cordelahotel.com', '081234567891', 'Manager', 8000000, '2024-01-15', 1, '2025-06-24 14:39:00', '2025-06-24 14:39:00'),
(2, 1, 'Ani Wijaya', 'ani@cordelahotel.com', '081234567892', 'Resepsionis', 4500000, '2024-02-20', 1, '2025-06-24 14:39:00', '2025-06-24 14:39:00'),
(3, 2, 'Cahyo Pratama', 'cahyo@horisonhotel.com', '081234567893', 'Supervisor', 6000000, '2023-11-10', 1, '2025-06-24 14:39:00', '2025-06-24 14:39:00'),
(4, 2, 'Dewi Lestari', 'dewi@horisonhotel.com', '081234567894', 'Housekeeping', 4000000, '2024-03-05', 1, '2025-06-24 14:39:00', '2025-06-24 14:39:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_ponsel` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `nomor_ponsel`, `password`, `user_type`, `created_at`, `updated_at`) VALUES
(6, 'Hikmatyar Duta Praja', 'hikmatyardutapraja@gmail.com', '081122334455', '$2y$10$ldmx9dWRr8Wi.NLaV2P/eOBYevpiKGJ8Z78q.gX4tXv7xmdhQ1feO', 'user', '2025-05-20 10:06:40', '2025-05-20 10:06:40'),
(7, 'Admin Purqon', 'admin@purqon.com', '081234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-05-20 10:21:41', '2025-05-20 10:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passwordresets`
--
ALTER TABLE `passwordresets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nomor_ponsel` (`nomor_ponsel`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `passwordresets`
--
ALTER TABLE `passwordresets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `room_facilities_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
