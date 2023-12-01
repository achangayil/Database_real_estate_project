
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `User` varchar(100) NOT NULL,
  `property_id` varchar(100) NOT NULL,
  `seller_id` varchar(100) NOT NULL,
  `street_name` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `school_rating` varchar(100) NOT NULL,
  `property_price` varchar(100) NOT NULL,
  `environmental_rating` varchar(100) NOT NULL,
  `energy_efficiency_rating` varchar(100) NOT NULL,
  `usersaved` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- data for table `properties`
--

INSERT INTO `properties` (`User`, `property_id`, `seller_id`, `street_name`, `City`, `zip_code`, `school_rating`, `property_price`, `environmental_rating`, `energy_efficiency_rating`, `usersaved`) VALUES
('shakib', '1234', '1234', 'Collins Hill Rd', 'Lawrenceville', '30053', '9', '450000', '70', '90', ''),
('nafisanawal', '1243', '1243', '90 Chamblee Tucker Rd', 'Chamblee', '30341', '8', '600000', '80', '90', ''),
('shakib', '1243', '1243', '90 Chamblee Tucker Rd', 'Chamblee', '30341', '8', '600000', '80', '90', ''),
('nafisanawal', '1223', '1234', '41 Peachtree Ave', 'Buckhead', '30305', '8', '700500', '60', '50', 'Yes'),
('nafisanawal', '1223', '1234', '500 Peachtree Ave', 'Atlanta', '30305', '8', '700500', '60', '50', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- data for table `signup`
--

INSERT INTO `signup` (`fname`, `lname`, `email`, `username`, `password`, `user_role`) VALUES
('[shakib]', '[uddin]', '[shakib@gmail.com]', '[shakib]', '[shakib]', '[Buyer]'),
('Moslaaaa', 'Uddin', 'nafisa_nawal99@yahoo.com', 'shakib', '$2y$10$Um3SjCeIfv1a4oR2ZKmwmOHjgylxueiYBkO5wey6KtsHRxMcWN.em', 'Seller'),
('Nafisa', 'Nawal', 'nafisanawal@email.com', 'nafisanawal', '$2y$10$P/smiHmYmolS2E28gMbm8.A40iYCq.P9zpNDNQHg6BlD34rBKgoem', 'Buyer');
