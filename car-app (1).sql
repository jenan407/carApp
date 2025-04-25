-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 05:36 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ad-url` varchar(255) NOT NULL,
  `hit` int(11) NOT NULL DEFAULT 0,
  `start-date` date NOT NULL,
  `end-date` date NOT NULL,
  `location` enum('top','middle','bottom') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `full_name`, `image`, `ad-url`, `hit`, `start-date`, `end-date`, `location`) VALUES
(3, 'Overheating Car? Get Help!', 'images/overheating_car_ad.jpg', 'https://www.autorepairlocal.com/overheating', 1201, '2025-04-07', '2025-06-14', 'top'),
(4, 'Flat Tire? Call Us Now!', 'images/flat_tire_service.png', 'https://www.roadsideassistbrisbane.com/tire', 953, '2025-04-07', '2025-06-21', 'middle'),
(5, 'Car Battery Problems?', 'images/dead_battery_help.gif', 'https://www.mobilebatterybrisbane.com', 1800, '2025-04-07', '2025-06-10', 'bottom'),
(6, 'Brake Issues? Get a Free Check', 'images/brake_check_ad.jpeg', 'https://www.brakespecialists.com.au', 2500, '2025-04-06', '2025-06-13', 'top'),
(7, 'Engine Light On? Diagnostics', 'images/check_engine_light.jpg', 'https://www.cardiagnosticsbrisbane.net', 1151, '2025-04-06', '2025-06-20', 'middle'),
(8, 'Car Won\'t Start? Mobile Service', 'images/car_wont_start_ad.png', 'https://www.mobilemechanicbrisbane.com', 1020, '2025-04-05', '2025-06-12', 'bottom'),
(9, 'Need a Car Service? Book Now!', 'images/car_service_booking.gif', 'https://www.autoservicebrisbane.com.au', 1603, '2025-04-05', '2025-06-19', 'top'),
(10, 'Transmission Problems? Expert', 'images/transmission_repair.jpg', 'https://www.transmissionexperts.com.au', 880, '2025-04-04', '2025-06-11', 'middle'),
(11, 'Air Conditioning Not Working?', 'images/car_ac_repair.jpeg', 'https://www.acspecialistsbrisbane.com.au', 1451, '2025-04-04', '2025-06-18', 'bottom'),
(13, 'Steering Issues? Get it Checked', 'images/steering_repair_ad.gif', 'https://www.powersteeringbrisbane.com', 721, '2025-04-03', '2025-06-17', 'middle'),
(15, 'Car Paint Faded? Get a Quote!', 'images/car_paint_restoration.jpeg', 'https://www.carpaintbrisbane.com.au', 1181, '2025-04-02', '2025-06-16', 'top'),
(21, 'Car Alarm Problems? Get Help!', 'images/car_alarm_repair.gif', 'https://www.autoelectricbrisbane.com.au', 1081, '2025-03-30', '2025-06-13', 'top'),
(47, 'Brake Issues? Get a Free Check', 'images/brake_check_ad.jpeg', 'https://www.brakespecialists.com.au', 2500, '2025-04-06', '2025-06-13', 'top'),
(58, 'Windscreen Cracked? We Replace', 'images/windscreen_repair.gif', 'https://www.windscreensbrisbane.com.au', 1521, '2025-04-01', '2025-06-15', 'bottom');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` smallint(6) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `images` text NOT NULL,
  `description` text NOT NULL,
  `sold` tinyint(1) NOT NULL,
  `color` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `user_id`, `brand`, `model`, `year`, `price`, `images`, `description`, `sold`, `color`, `country`, `city`) VALUES
(1, 54, 'Toyota', 'Camry', 2022, '26500.00', '[\"images/camry_2022_silver.jpg\"]', 'Reliable sedan, excellent fuel economy, well-maintained.', 0, 'Silver', 'Syria', 'Damascus'),
(3, 57, 'BMW', '3 Series', 2019, '38000.00', '[\"images/bmw_3series_2019_red.jpg\"]', 'Luxury sedan, powerful engine, premium features.', 0, 'Red', 'Syria', 'Homs'),
(4, 54, 'Mercedes-Benz', 'C-Class', 2020, '42000.00', '[\"images/cclass_2020_white.jpg\"]', 'Elegant sedan, comfortable ride, advanced technology.', 0, 'White', 'Syria', 'Latakia'),
(5, 53, 'Ford', 'F-150', 2023, '55000.00', '[\"images/f150_2023_grey.jpg\"]', 'Popular pickup truck, spacious cabin, powerful towing capacity.', 0, 'Grey', 'Syria', 'Tartus'),
(6, 56, 'Chevrolet', 'Silverado 1500', 2022, '52000.00', '[\"images/silverado_2022_black.jpg\"]', 'Rugged and capable pickup, good for work and recreation.', 0, 'Black', 'Syria', 'Raqqa'),
(7, 64, 'Nissan', 'Rogue', 2020, '21000.00', '[\"images/rogue_2020_white.jpg\"]', 'Compact SUV, comfortable seating, good cargo space.', 1, 'White', 'Syria', 'Hama'),
(8, 67, 'Hyundai', 'Tucson', 2021, '20500.00', '[\"images/tucson_2021_grey.jpg\"]', 'Stylish SUV, modern features, excellent warranty.', 0, 'Grey', 'Syria', 'Deir ez-Zor'),
(9, 65, 'Kia', 'Sportage', 2022, '22000.00', '[\"images/sportage_2022_blue.jpg\"]', 'Well-equipped SUV, user-friendly infotainment system.', 0, 'Blue', 'Syria', 'Idlib'),
(10, 64, 'Audi', 'A4', 2021, '40000.00', '[\"images/audi_a4_2021_black.jpg\"]', 'Sporty luxury sedan, quattro all-wheel drive.', 0, 'Black', 'Syria', 'Al-Hasakah'),
(11, 55, 'Subaru', 'Outback', 2023, '34000.00', '[\"images/outback_2023_green.jpg\"]', 'Versatile wagon/SUV, standard all-wheel drive, safety features.', 0, 'Green', 'Syria', 'Daraa'),
(12, 56, 'Mazda', 'CX-5', 2020, '24000.00', '[\"images/cx5_2020_red.jpg\"]', 'Fun-to-drive compact SUV, stylish design.', 1, 'Red', 'Syria', 'As-Suwayda'),
(13, 59, 'Volkswagen', 'Golf GTI', 2022, '30000.00', '[\"images/golfgti_2022_grey.jpg\"]', 'Iconic hot hatchback, sporty performance, practical.', 0, 'Grey', 'Syria', 'Qamishli'),
(14, 58, 'Tesla', 'Model 3', 2021, '45000.00', '[\"images/model3_2021_white.jpg\"]', 'Electric sedan, fast acceleration, advanced technology.', 0, 'White', 'Syria', 'Kobani'),
(15, 61, 'Lexus', 'RX 350', 2020, '48000.00', '[\"images/rx350_2020_silver.jpg\"]', 'Comfortable luxury SUV, smooth ride, reliable.', 0, 'Silver', 'Syria', 'Al-Bab'),
(16, 60, 'Jeep', 'Wrangler', 2023, '40000.00', '[\"images/wrangler_2023_black.jpg\"]', 'Iconic off-road SUV, removable top and doors.', 0, 'Black', 'Syria', 'Manbij'),
(17, 63, 'Ram', '1500', 2021, '50000.00', '[\"images/ram1500_2021_grey.jpg\"]', 'Comfortable and capable full-size pickup truck.', 0, 'Grey', 'Syria', 'Jisr al-Shughur'),
(18, 70, 'Acura', 'MDX', 2022, '46000.00', '[\"images/mdx_2022_blue.jpg\"]', 'Premium SUV, spacious third row, sporty handling.', 0, 'Blue', 'Syria', 'Al-Qusayr'),
(19, 72, 'Volvo', 'XC60', 2021, '43000.00', '[\"images/xc60_2021_white.jpg\"]', 'Safe and stylish SUV, comfortable interior, advanced safety features.', 0, 'White', 'Syria', 'Safita'),
(20, 13, 'Land Rover', 'Range Rover Evoque', 2020, '35000.00', '[\"images/evoque_2020_red.jpg\"]', 'Compact luxury SUV, stylish design, capable off-road.', 1, 'Red', 'Syria', 'Al-Mayadin'),
(32, 13, 'Hyundai', 'Avanti', 2008, '650.00', '[\"images\\/67fc30f9b679b_IMG-20250323-WA0014.jpg\",\"images\\/67fc30f9b70d1_IMG-20250323-WA0015.jpg\",\"images\\/67fc30f9b9d7d_IMG-20250323-WA0016.jpg\",\"images\\/67fc30f9ba991_IMG-20250323-WA0017.jpg\",\"images\\/67fc30f9bb2c1_IMG-20250323-WA0018.jpg\",\"images\\/67fc30f9bcb38_IMG-20250323-WA0019.jpg\"]', 'engine1600,MileAge : 165000 km , Original engine and gearbox ,Fully equipped with a sunroof ,Second owner from the dealership  ,Completely repainted from the outside, just for cleanliness , Interior is completely clean ', 0, 'purple', 'syria', 'damascus'),
(33, 13, 'Mercedes', 'E300', 2011, '13000.00', '[\"images\\/67fc329154a3d_IMG-20250323-WA0020.jpg\",\"images\\/67fc32915551a_IMG-20250323-WA0021.jpg\",\"images\\/67fc329155e35_IMG-20250323-WA0022.jpg\",\"images\\/67fc329158fc5_IMG-20250323-WA0023.jpg\"]', 'full,the prise is negotiable', 0, 'white', 'syria', 'damascus'),
(40, 74, 'Abarth', '500', 2002, '23232.00', '[\"..\\/.\\/images\\/680ab9005e0a0_67fc329155e35_IMG-20250323-WA0022.jpg\",\"..\\/.\\/images\\/680ab90065265_67fc329158fc5_IMG-20250323-WA0023.jpg\"]', '', 0, 'Aqua', 'Palestine', 'Jerusalem');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `is_public` tinyint(1) NOT NULL,
  `status` enum('Pending','Approved','Rejected') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` enum('seller','site') NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `name`, `phone`, `content`, `is_public`, `status`, `created_at`, `type`, `username`, `car_id`) VALUES
(2, 'Ahmad Khalil', '+963933123456', 'Great listing! Is the price negotiable?', 1, 'Approved', '2025-04-07 14:00:00', 'seller', 'ahmadk123', 101),
(3, 'Fatima Zahra', '+963944789012', 'I\'m interested in this car. Can you provide more details about its history?', 1, 'Approved', '2025-04-07 14:15:30', 'seller', 'fatimaz88', 102),
(5, 'Layla Ali', '+963966901234', 'Is this car still available?', 1, 'Approved', '2025-04-07 14:45:15', 'seller', 'layla_a', 101),
(6, 'Youssef Ibrahim', '+963977567890', 'I had a similar model before, very reliable!', 1, 'Approved', '2025-04-07 15:00:00', 'seller', 'youssefi', 104),
(8, 'Ali Hussein', '+963999445566', 'The website is very easy to navigate.', 1, 'Approved', '2025-04-07 00:00:00', 'site', 'ali_h', NULL),
(9, 'Samar Abbas', '+963935778899', 'Love the color! Is it the original paint?', 1, 'Approved', '2025-04-07 00:30:10', 'seller', 'samar_a', 106),
(10, 'Khaled Zein', '+963946001122', 'When would be a good time to inspect the car?', 1, 'Approved', '2025-04-07 01:00:55', 'seller', 'khaledz', 107),
(11, 'Rania Saleh', '+963957334455', 'Just browsing, nice car though!', 1, 'Approved', '2025-04-07 01:30:20', 'seller', 'ranias', 108),
(12, 'Hassan Fadel', '+963968667788', 'Is there a warranty included?', 0, 'Pending', '2025-04-05 19:00:30', 'seller', 'hassanf', 109),
(13, 'Zeinab Kamal', '+963979990011', 'I found the search filters very helpful.', 1, 'Approved', '2025-04-05 19:30:40', 'site', 'zeinabk', NULL),
(14, 'Ibrahim Nasr', '+963989223344', 'Any service history available?', 1, 'Approved', '2025-04-05 20:00:15', 'seller', 'ibrahimn', 111),
(15, 'Mona Jaber', '+963991556677', 'This looks exactly what I\'ve been searching for!', 1, 'Approved', '2025-04-05 20:30:50', 'seller', 'monaj', 112),
(16, 'Fadi Nader', '+963936889900', 'Are the tires in good condition?', 0, 'Pending', '2025-04-04 15:00:05', 'seller', 'fadin', 113),
(17, 'Sara Khalil', '+963947112233', 'The loading speed of the pages is quite good.', 1, 'Approved', '2025-04-04 15:30:25', 'site', 'sarak', NULL),
(18, 'Mahmoud Sami', '+963958445566', 'What\'s the registration expiry date?', 0, 'Rejected', '2025-04-04 16:00:40', 'seller', 'mahmouds', 115),
(19, 'Rana Adel', '+963969778899', 'Beautiful car! Wish I had the budget for it.', 1, 'Approved', '2025-04-03 22:00:10', 'seller', 'ranaa', 116),
(20, 'Wissam Ghazi', '+963971001122', 'Is there any rust on the body?', 0, 'Pending', '2025-04-03 22:30:55', 'seller', 'wissamg', 117),
(21, 'Hala Rida', '+963981334455', 'The contact form is easy to use.', 1, 'Approved', '2025-04-03 23:00:20', 'site', 'halar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `siteName` varchar(255) DEFAULT NULL,
  `iconePhoto` varchar(255) DEFAULT NULL,
  `logoPhoto` varchar(255) DEFAULT NULL,
  `facebookLink` varchar(255) DEFAULT NULL,
  `instaLink` varchar(255) DEFAULT NULL,
  `carsualLines` text DEFAULT NULL,
  `carouselImage1` text DEFAULT NULL,
  `carouselImage2` text DEFAULT NULL,
  `carouselImage3` text DEFAULT NULL,
  `watesapp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`siteName`, `iconePhoto`, `logoPhoto`, `facebookLink`, `instaLink`, `carsualLines`, `carouselImage1`, `carouselImage2`, `carouselImage3`, `watesapp`) VALUES
('Car Zone', 'images/icons/67fcf28c8657a_carouselw.jpg', 'images/logos/67fcf2a9eb3a2_carousel11.jpg', NULL, NULL, 'your car your way\r\nwelcome ready for a ride!\r\nfind your dreams car', 'images/carousel/67fcf24e9d7dd_carousel.jpg', 'images/carousel/67fcf16e331a8_carousel10.jpg', 'images/carousel/67fcf20c229fc_carousel3.jpg', '0936123930');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email verified` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobileno` varchar(50) NOT NULL,
  `profile-picture` varbinary(255) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `role` enum('user','admine') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `email verified`, `password`, `mobileno`, `profile-picture`, `city`, `country`, `role`) VALUES
(1, 'dd', 'mays@gmail.com', NULL, '$2y$10$DKBIZ/dZtTAU0bpmpgt0bOaNt1Jsu8hzRIi9AFdfVPEpM8rJDb/2e', '09876453222', NULL, 'csdc', 'cscs', 'user'),
(2, 'gv', 'mayzs@gmail.com', NULL, '$2y$10$JoMDIrvaWvwr6GAbXNKZK.1U/t9x5H/SxXhD5PPvbsTEe.SF6J8s.', '09876453222', NULL, 'csdc', 'cscs', 'user'),
(3, 'gv', 'mayas@gmail.com', NULL, '$2y$10$PId1j3bQfD1LwfjibnY7w.NeAbDDHKiK8sxqk5If13J1cH0HlxSiS', '', NULL, 'csdc', 'cscs', 'user'),
(4, 'gv', 'mqayas@gmail.com', NULL, '$2y$10$7FAKmF9OZXwyPzHe.qr2E.0oyMBaV/JLf/FLfbm/SFFTbFOPux.Ti', '', NULL, '', '', 'user'),
(5, '111111', 'maywas@gmail.com', NULL, '$2y$10$7sksnOrsAT7BgpqNLm3aku49oZC1TJjSLZIF1YZQfp2VXFQ36EbyS', '09876453222', NULL, 'csdc', 'cscs', 'user'),
(6, 'dd', 'maaayas@gmail.com', NULL, '$2y$10$I/JHV35wZqEy0.RFliuXh.BMhtaFjiWqQZUODU6TC5VbCOX8Gq.zO', '111111111111111111', NULL, '11111111111', 'qwwwwwww', 'user'),
(7, 'ahnaaf', 'mwways@gmail.com', NULL, '$2y$10$O.Lyl.gXBIJGePRbMEZsI.xz2SmV5V9jTYs/CV20dOSAfUONc9WDm', 'wwwwwwwwwwwww', 0x696d616765732f363766343131326362373263635f77696e6473637265656e5f7265706169722e676966, 'wwwwwww', 'wqdwd', 'user'),
(8, 'dd', 'mayaas@gmail.com', NULL, '$2y$10$XOkzbRxvIGBFoOOWnf69MuMTzTQBLf.nfjFQFNWiraCIOeaeWgQIi', '09876453222', NULL, 'w', 'w', 'user'),
(9, 'ema', 'ema@mail.com', '2025-04-07 20:57:08', '$2y$10$QabxOqXetIoZlNM34aufsOhz8fdXWUB.ekokqeX05oedjNgCDlvia', '09876453222', 0x696d616765732f363766343362623464653763635f6361725f7061696e745f726573746f726174696f6e2e6a706567, 'lattakia', 'syria', 'user'),
(10, 'name', 'name@gmail.com', '2025-04-06 20:59:54', '$2y$10$eTyzgyZdtrnI1MXOmOyrt.PzuocoFtMgglwDh2kQcQCq/10FtfzF6', '09876453222', '', 'damascse', 'syria', 'user'),
(12, 'jenan', 'jenan@gmail.com', '2025-04-06 21:21:09', '$2y$10$IFH7pAEVDMofhq5DTg92iud9QoaUFsFW7lcVfEeOHVth7uHcSyLrG', '09876453222', 0x696d616765732f363766343431613763653430315fd9a2d9a0d9a2d9a0d9a0d9a3d9a0d9a45fd9a2d9a2d9a2d9a6d9a5d9a12e6a7067, 'damascse', 'syria', 'user'),
(13, 'name', 'name2@gmail.com', NULL, '$2y$10$CAbK7AMuOR25sOvt8CUE4uihNuR/MFAb4o8uBwjyGEA0jfn7Vo.J6', '09888888887', 0x696d616765732f363766366430393832343134635fd9a2d9a0d9a2d9a1d9a1d9a2d9a1d9a65fd9a1d9a7d9a1d9a2d9a4d9a32e6a7067, 'damascuse', 'syria', 'user'),
(15, 'dd', 'jenanshbani974@gmail.com', NULL, '$2y$10$YiDesbmNY5sR26Gnsu958eEM3tknx8TsZ8I3E7GJjVHyZR7PISZ26', '09876453222', 0x696d616765732f363766393662333732303030375f77696e6473637265656e5f7265706169722e676966, 'z', 'z', 'user'),
(16, 'dd', 'maywwws@gmail.com', NULL, '$2y$10$Hef.E9ObfCi5Zw23W4o1k.Cv9itDStLkCFse2uD5wA8NZPjKKmapi', '09876453222', NULL, 'w', 'w', 'user'),
(17, 'w', 'emaaa@mail.com', NULL, '$2y$10$Dh2qTXYgVhR7lrHJxWBBlu0lukz702bgGRIWL4X84JpTNGvu1fvUu', '09876453222', 0x696d616765732f363766393663613563353137335f6361725f7061696e745f726573746f726174696f6e2e6a706567, 'aa', 'aa', 'user'),
(18, 'a', 'naame@gmail.com', NULL, '$2y$10$rNlET0s3vj.WU67d3Ymqz.XfL1jkzhkYaS/S8if29mkpIPuRPPiGS', '09876453222', 0x696d616765732f363766393730663761663038645f6361725f7061696e745f726573746f726174696f6e2e6a706567, 'a', 'aa', 'user'),
(19, 'dd', 'emja@mail.com', NULL, '$2y$10$dy7GaVQl6xhdWHzDBoWJSe3j2FHPmRIEQT1Bd5MiUGSut6v9fYoCe', '09876453222', NULL, 'nn', '', 'user'),
(20, 'name', 'emmjba@mail.com', NULL, '$2y$10$LMpn10Hms7daNvnzA.Ogc.cFKYqEXIyXP3/iE0PBzdFSO7SaZrKZG', '09876453222', NULL, 'csdc', 'qwwwwwww', 'user'),
(27, 'dd', 'emcgfa@mail.com', NULL, '$2y$10$j4pe3eQq25JUaOXEqj6uWeNnHg.eMnWtshriekEbBagswcVvnSILK', '09876453222', NULL, 'csdc', 'qwwwwwww', 'user'),
(28, 'dd', 'mayknls@gmail.com', NULL, '$2y$10$AQu1Bhcqd2mZ1WXz4M8GtuRnpbG5SqI9FmQ4npaEJ/ekfYJL2DYbO', '09876453222', NULL, 'csdc', 'qwwwwwww', 'user'),
(29, 'gv', 'nnnn@mail.com', NULL, '$2y$10$gqKWeV7QhIoKQir522BXkeCvBG76pG0XUIbDIMlQSJwAYkon0..cu', '09876453222', NULL, 'lattakia', 'kml', 'user'),
(30, 'dd', 'maeeys@gmail.com', NULL, '$2y$10$SB5rh6FckePOzxBCmRJGWu.VhbiTFjQvQX9LWSe7LFlCF26Xp0NvK', '09876453222', NULL, 'csdc', 'scs', 'user'),
(31, 'dd', 'maeeeeys@gmail.com', NULL, '$2y$10$eFa8nDMEbW2mLq2gncXTCOfNKAXoUQ7sk2Xput3wehTkxkX6kJ.LC', '09876453222', NULL, 'csdc', 'scs', 'user'),
(32, 'dd', 'may22s@gmail.com', NULL, '$2y$10$BitNFQbbxMZ3H9oZCObufeVnvTqNey.gX8Zv8avxckK0V8CXrSeWK', '09876453222', NULL, '2', '2', 'user'),
(53, 'Zainab Dabbagh', 'zainab.dabbagh26@example.com', NULL, '$2y$10$DzB/4B7ro8HHWZ/8iX2Gwetpm8/qWF0cyqqGfTXFiycM4Av1lrxeS', '09973315', NULL, 'Damascus', 'Syria', 'user'),
(54, 'Khaled Al-Dimashqi', 'khaled.al-dimashqi99@example.com', NULL, '$2y$10$Igm7f2QBe36LgDUHJ.XKlOj6lvTGCNuZIVxfCZvlaL6amFT8R6MGq', '09694547', NULL, 'Damascus', 'Syria', 'user'),
(55, 'Fatima Al-Quneitra', 'fatima.al-quneitra49@example.com', NULL, '$2y$10$d/yd4dVJpEQMWHUWMksO8O7U8DK1bRigAkFWFTsyIKPoSx0T0/4sm', '09676350', NULL, 'Damascus', 'Syria', 'user'),
(56, 'Youssef Al-Halabi', 'youssef.al-halabi89@example.com', NULL, '$2y$10$GDJcMQgEPmTwkZBPMOsdJOnUzJ5g2Gk5vLIhUZ3S2uKTxNimFZ/kW', '09618167', NULL, 'Damascus', 'Syria', 'user'),
(57, 'Abdullah Zenati', 'abdullah.zenati10@example.com', NULL, '$2y$10$EGa4hkaAF569MBjhyTbafet2APYH4iBErdn9pMKm.mtazu6TeH0/i', '09391204', NULL, 'Damascus', 'Syria', 'user'),
(58, 'Khaled Al-Masri', 'khaled.al-masri94@example.com', NULL, '$2y$10$FY6itrGf8KTJPO4gTcHwuOYmGwcOc6YN84dDW8U0Kb59iGDJQVZQW', '09404351', NULL, 'Damascus', 'Syria', 'user'),
(59, 'Zainab Haddad', 'zainab.haddad9@example.com', NULL, '$2y$10$SicdG1AhWfup68jyqQsKZ.VAHSfOzujZ9xEZvMvWNXj5ncRTMUfNS', '09229665', NULL, 'Damascus', 'Syria', 'user'),
(60, 'Mohammad Al-Masri', 'mohammad.al-masri96@example.com', NULL, '$2y$10$IAGNkSX67isuxsZIpX/KluW5z0KeHe5IyUmJBIgWrJx3Ib7nNBRdi', '09432184', NULL, 'Damascus', 'Syria', 'user'),
(61, 'Fatima Najjar', 'fatima.najjar78@example.com', NULL, '$2y$10$rn/3f1sw2MG3ArfaXprTjeaEdhJ3VKY1gDJF773kSgmjbvSzghzVe', '09547759', NULL, 'Damascus', 'Syria', 'user'),
(62, 'Fatima Al-Raqqawi', 'fatima.al-raqqawi76@example.com', NULL, '$2y$10$KhGLpb48PB6Rzz8RXn/h9u3mIC48vvRp.8qrPCDnWFEIQkZeoO1SS', '09571290', NULL, 'Damascus', 'Syria', 'user'),
(63, 'Salma Al-Quneitra', 'salma.al-quneitra26@example.com', NULL, '$2y$10$m1KGgBPPBC40bsni93MVW.YKdG7Gk5i3bJAUsIqxJ6mh/RTZckU.6', '09115489', NULL, 'Damascus', 'Syria', 'user'),
(64, 'Ahmad Kayali', 'ahmad.kayali14@example.com', NULL, '$2y$10$1glrb1iDLn39ViN6/iLvRebIEjh6rxC89nhV0qo/usT84U.XgEtcW', '09312646', NULL, 'Damascus', 'Syria', 'user'),
(65, 'Hassan Khabbaz', 'hassan.khabbaz72@example.com', NULL, '$2y$10$VgvIenB.neZENTdONQktzuQOUpS2twegri.pVviDF1D/mvFiOoz9e', '09262193', NULL, 'Damascus', 'Syria', 'user'),
(66, 'Youssef Najjar', 'youssef.najjar9@example.com', NULL, '$2y$10$thm4XbFEpdxXjkyIblNx2OsepulYEEnUpDDfkp221y2Dqxhs0Aeju', '09808122', NULL, 'Damascus', 'Syria', 'user'),
(67, 'Ahmad Haddad', 'ahmad.haddad88@example.com', NULL, '$2y$10$t/itwyf7Aw3.PJGLG6CG2.dN2KhdCkQ4DJGFrgCN77cdH0VqqinQq', '09887886', NULL, 'Damascus', 'Syria', 'user'),
(68, 'Ibrahim Khabbaz', 'ibrahim.khabbaz34@example.com', NULL, '$2y$10$gab/ah9GeCPbVaJWxLbgz.jJwYg2kZlLD79kdlmQwRgTd7YepUiba', '09744000', NULL, 'Damascus', 'Syria', 'user'),
(69, 'Nour Khoury', 'nour.khoury34@example.com', NULL, '$2y$10$bCWB9XFpyjRCzld0iRvGL.WuqY9QtECVWBgT4gqyKjJXU77wGGbGm', '09359753', NULL, 'Damascus', 'Syria', 'user'),
(70, 'Youssef Al-Idlibi', 'youssef.al-idlibi21@example.com', NULL, '$2y$10$At0l36ASZg/oWQtCaXLAKe53pDt4hkT7/HRRK/MI7JwX55/qOA19O', '09352030', NULL, 'Damascus', 'Syria', 'user'),
(71, 'Omar Haddad', 'omar.haddad84@example.com', NULL, '$2y$10$9lIStpGJfBQ0UWxV4d5zmesus54pxJltvzF3oD2T/6fpLoEO6B0Ky', '09314485', NULL, 'Damascus', 'Syria', 'user'),
(72, 'Sara Zenati', 'sara.zenati1@example.com', NULL, '$2y$10$x9CxV0RI2y1zdkEHUGcgq..FSR9QFyqao1oJa/vJOZNLBTMvvd7Ku', '09156584', NULL, 'Damascus', 'Syria', 'user'),
(74, 'ayha', 'ayham@gmail.com', NULL, '$2y$10$8bm3ckTPdttXbyPE44EQMuHhliqvS1KUMpoK7AMEFCf.38VCp61ni', '0945646213', NULL, 'Aleppo', 'Syria', 'user'),
(75, 'Admin', 'Admin@gmail.com', NULL, '$2y$10$BbYyrIWyTqp/prXkftsmBOjB8iO38NrbEDNAgHKjX8Zgid.PGOC6O', '0978234749', NULL, 'Lattakia', 'Syria', 'admine'),
(76, 'mayosa', 'maysshbani@gmail.com', NULL, '$2y$10$XpNo0bY23uTVHVTIq4ZUE.uYTZtO8nCQVZUhyagGthsSSjxY3JuFm', '09782347333', NULL, 'jablah', 'Syria', 'user'),
(77, 'mayosa', 'ayhamd@gmail.com', NULL, '$2y$10$2M3iqjDMZTA78CnIXyNgruOfWNGO97ghn0ife.OrsKgJYmg1hHF6G', '0978234748', NULL, 'Lattakia', 'Syria', 'user'),
(78, 'ayaa', 'ayaa@gmail.com', NULL, '$2y$10$3QVLkcMDJPKBFr8p5yzYJ.bkkvhsZKQNNjdjBOtA3w.75P6GQuLse', '0978234749', 0x696d616765732f363766643662663431373864345fd9a2d9a0d9a2d9a2d9a0d9a5d9a0d9a55fd9a1d9a6d9a1d9a4d9a4d9a32e6a7067, 'jablah', 'Syria', 'user'),
(79, 'mayosa', 'ayhasm@gmail.com', NULL, '$2y$10$x.P6RgSzv5SpeHWwP9gCrOveSFgGxGLYVslqQnlP8JzVZsbuIjdcW', 'sdw', NULL, 'Lattakia', 'Syria', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
