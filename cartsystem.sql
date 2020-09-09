-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Tem 2020, 15:43:34
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cartsystem`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Samsung'),
(2, 'Nike'),
(3, 'Apple'),
(4, 'Adidas'),
(5, 'Lina'),
(6, 'Vestel'),
(7, 'Arya'),
(8, 'Armoni'),
(9, 'Berrak'),
(10, 'Kutahya'),
(11, 'Nehir'),
(12, 'Koton'),
(13, 'Waikiki');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `ip_add` varchar(191) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_title` varchar(191) NOT NULL,
  `product_image` text NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(1) NOT NULL,
  `cat_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Electronics'),
(2, 'Ladies Wear'),
(3, 'Mens Wear'),
(4, 'Kids Wear'),
(5, 'Furnitures'),
(6, 'Home Appliances');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_cat` int(11) NOT NULL,
  `product_brand` int(11) NOT NULL,
  `product_title` varchar(191) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords`) VALUES
(1, 1, 1, 'Samsung a70', 5500, 'Samsung a70 0.4 product system', 'samsung-a70.jpg', 'samsung electronic phone'),
(2, 1, 3, 'iphone', 4000, 'iphone description test control', 'apple-pro.jpg', 'apple electronic phone'),
(3, 1, 3, 'iPhone 8', 7000, 'Apple Product description deneme2', 'apple-pro.jpg', 'apple electronic phone'),
(4, 2, 3, 'İphone 6s', 6000, 'iPhone 6s is description of this', 'apple-6s.jpg', 'apple electronic phone'),
(5, 1, 3, 'iPhone 7', 4000, 'iPhone 7 is my newest description of this', 'apple-7.jpg', 'iphone electronic phone'),
(6, 1, 1, 'Samsung A71', 6000, 'Samsung a71 is descripted', 'samsung-a71.jpg', 'samsung electronic phone'),
(7, 1, 3, 'iPhone XR', 4700, 'iPhone XR is as descripted', 'apple-xr.jpg', 'iphone electronic phone'),
(8, 1, 1, 'Samsung j2', 3600, 'Samsung j2\'s description not always like this', 'samsung-j2.jpg', 'samsung electronic phone'),
(9, 1, 1, 'Samsung M11', 2700, 'Samsung M11 is my this description', 'samsung-m11.jpg', 'samsung electronic phone'),
(10, 2, 12, 'Koton Beyaz Kadın', 150, 'Koton Beyaz Elbise pamuk dikişlidir.', 'koton-kadin2.jpg', 'beyaz kadın elbise'),
(11, 2, 12, 'Koton Kırmızı Kadın', 120, 'Koton kırmızı elbise açıkalamsı', 'koton-kadin3.jpg', 'kırmızı koton elbise'),
(12, 2, 12, 'Koton Siyah Kadın', 90, 'Koton Siyah Kadın Açıklaması', 'koton-kadin1.jpg', 'koton siyah kadın'),
(13, 2, 13, 'Waikiki Siyah Kadın', 85, 'Waikiki Siyah Kadın Açıklaması', 'waikiki-kadin1.jpg', 'waikiki siyah kadın'),
(14, 3, 13, 'Waikiki Yeşil Erkek', 75, 'Waikiki Gömlek Erkek Açıklama', 'waikiki-erkek2.jpg', 'Waikiki Yeşil Erkek'),
(15, 3, 13, 'Waikiki Mavi Erkek', 95, 'Waikiki Mavi Erkek açıklama', 'waikiki-erkek1.jpg', 'Waikiki Mavi Erkek');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(191) NOT NULL,
  `last_name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address1` varchar(300) NOT NULL,
  `address2` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
