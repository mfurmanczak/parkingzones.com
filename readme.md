CREATE A TABLE IN YOUR PHPMYADMIN

CREATE TABLE `parking_zone` (
  `Zone_ID` int(11) NOT NULL,
  `Zone_Name` char(50) NOT NULL,
  `Weekday_Rate` int(11) NOT NULL,
  `Weekend_Rate` int(11) NOT NULL,
  `Discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
