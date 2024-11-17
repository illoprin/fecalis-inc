-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 17, 2024 at 11:29 PM
-- Server version: 5.7.39
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fecalis`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(4) UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Органические'),
(2, 'Минеральные');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(4) UNSIGNED NOT NULL,
  `user_id` int(4) UNSIGNED NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `card_date` varchar(4) NOT NULL,
  `card_cvv` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `user_id`, `card_number`, `card_date`, `card_cvv`) VALUES
(1, 1, '5647475665749584', '0129', '985'),
(2, 2, '5674864687533629', '0131', '780'),
(3, 3, '2873283728738237', '0434', '567');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(4) UNSIGNED NOT NULL,
  `category_id` int(4) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL DEFAULT '❌❌❌',
  `description` varchar(8192) NOT NULL DEFAULT '???',
  `vendor` varchar(128) NOT NULL DEFAULT '???',
  `price` int(9) UNSIGNED NOT NULL,
  `img_src` varchar(256) NOT NULL DEFAULT '/user_data/organic_1.jpg'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `title`, `description`, `vendor`, `price`, `img_src`) VALUES
(1, 1, 'Гумус кошачий', 'Уникальное органическое удобрение, созданное на основе переработанного кошачьего кала.\n\nЭто эффективное и натуральное средство, богатое азотом, фосфором и калийными элементами, способствующее улучшению структуры почвы и повышению её плодородия. Идеально подходит для подкормки домашних и садовых растений, укрепляя их иммунитет и способствуя урожайности.\n\nБезопасно для окружающей среды и легко использовать!', 'ООО \"Мульча Главная\"', 1270, '/user_data/organic_4.png'),
(2, 1, 'БиоУдобрение \"Зеленая Сила\"', 'Это высококачественное органическое удобрение на основе компоста из растительных остатков и животного навоза.\r\n\r\nОбогащает почву питательными веществами, улучшает структуру и способствует развитию полезных микроорганизмов.\r\n\r\nИдеально для огородов и цветов.', 'ПАО \"БиоГумус\"', 3420, '/user_data/organic_2.jpg'),
(3, 1, 'Кизяк зубра \"ЗубрКиз\"', 'Высококачественное органическое удобрение, изготовленное из компостированного лошадиного кала. Этот натуральный продукт обогащает почву необходимыми микроэлементами, улучшает её структуру и способствует развитию полезной микрофлоры.\r\n\r\nВосстанавливает питание растений, повышает их устойчивость к болезням и обеспечивает стабильный рост.\r\n\r\nИдеально подходит для огородов, садов и цветочных композиций!', 'ИП \"Кунцевич\"', 3530, '/user_data/organic_3.jpg'),
(4, 1, 'Органическая подкормка \"Лунный Цвет\"', 'Удобрение на основе высушенных и измельченных цветов и трав, обогащенное натуральными витаминами и минералами.\r\n\r\nСпособствует яркому цветению и крепкому росту цветочных композиций. Подходит для домашних и садовых растений', 'ИП \"Маратова Светлана Олеговна\"', 6349, '/user_data/mineral_4.png'),
(5, 2, 'Агро-Мастер \"Кальций-Магний\"', 'Специально сбалансированная формула, содержащая кальций и магний, необходимые для правильного роста растений.\r\n\r\nУстойчивость к заболеваниям, улучшение фотосинтеза и крепкая корневая система - вот что вы получаете с \"Кальций-Магний\".', 'ПАО \"Сельскохозяйственные технологии\"', 8965, '/user_data/mineral_1.jpg'),
(6, 2, 'Азотное удобрение \"НитроМакс\"', 'Высококонцентрированное азотное удобрение, стимулирующее vegetative рост и обеспечивающее насыщение растительности необходимыми элементами. Подходит для подкормки овощей, ягод и зеленых культур в период активного роста.', 'ПАО \"Сельскохозяйственные технологии\"', 10387, '/user_data/mineral_1.jpg'),
(7, 2, 'Калийные удобрения \"ФосКал\"', 'Идеальное решение для подготовки растений к цветению и плодоношению. Содержит фосфор и калий в оптимальных пропорциях, что помогает улучшить качество и количество урожая. Подходит для всех видов фруктовых деревьев и овощей.', 'ООО \"Мульча Главная\"', 4832, '/user_data/mineral_1.jpg'),
(8, 1, 'Перегной \"Фикал\"', 'Полностью разложившийся навоз крупного рогатого скота. Богат органическими веществами, азотом, фосфором и калием. Идеален для улучшения структуры почвы и повышения плодородия.', 'Ферма ООО \"КалЭкспресс\"', 2300, '/user_data/organic_1.jpg'),
(9, 1, 'Куриный помёт \"Филис\"', 'Высокоэффективное органическое удобрение с высоким содержанием азота. Используется для обогащения почвы перед посадкой и в качестве подкормки в течение вегетационного периода.', 'Птицефабрика \"Птичий двор\"', 2100, '/user_data/organic_3.jpg'),
(10, 1, 'Компостированный навоз \"Силос\"', 'Смесь различных видов навоза, прошедшая процесс компостирования. Обогащает почву питательными веществами и улучшает её структуру. Подходит для большинства садово-огородных культур.\r\n', 'Агрокомплекс «Сила земли»', 2500, '/user_data/organic_3.jpg'),
(11, 1, 'Кулаков Иван \"Гумосович\"', 'Свежий навоз от крупного рогатого скота. Содержит большое количество азота, фосфора и калия. Применяется для улучшения плодородия почвы и стимулирования роста растений.', 'ООО \"Маслачусетс\"', 1488, '/user_data/organic_2.jpg'),
(12, 2, 'Нитроаммофоска', 'Комплексное минеральное удобрение, содержащее азот, фосфор и калий. Подходит для всех типов почв и культур. Способствует активному росту растений и повышению урожайности.', 'ООО «Агротрейд»', 4572, '/user_data/mineral_2.png'),
(13, 2, 'Активатор \"Суперфосфат\"', 'Удобрение на основе фосфора, которое улучшает корневую систему растений и способствует лучшему усвоению питательных веществ. Особенно полезно для овощных и плодовых культур.\r\n', 'ООО \"ХимАгро\"', 7341, '/user_data/mineral_2.png'),
(14, 2, 'Калийная селитра \"СилКал\"', 'Содержит азот и калий, используется для подкормки растений в период роста и цветения. Улучшает качество плодов и устойчивость растений к болезням.', 'ЗАО \"Агрохимия\"', 5422, '/user_data/mineral_6.png'),
(15, 2, 'Активное вещество \"АмСил\"', 'Азотное удобрение быстрого действия, подходит для всех видов сельскохозяйственных культур. Стимулирует рост зеленой массы и повышает урожайность.', 'ОАО \"Минудобрения\"', 6230, '/user_data/mineral_3.png'),
(16, 2, 'Вещество \"СульКал\"', 'Калиевое удобрение без хлора, идеально подходит для чувствительных к хлору культур. Повышает устойчивость растений к стрессам и улучшает вкусовые качества плодов.', 'ООО \"Агромир\"', 5200, '/user_data/mineral_2.png');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(4) UNSIGNED NOT NULL,
  `client_id` int(4) UNSIGNED NOT NULL,
  `entries` varchar(8916) DEFAULT NULL,
  `time_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` date DEFAULT NULL,
  `total_cost` int(9) UNSIGNED DEFAULT NULL,
  `delivery_status` tinyint(1) DEFAULT NULL COMMENT '0 - доставлен\r\n1 - в пути\r\n2 - отменён'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `client_id`, `entries`, `time_created`, `delivery_date`, `total_cost`, `delivery_status`) VALUES
(1, 1, '[{\"title\":\"\\u0413\\u0443\\u043c\\u0443\\u0441 \\u043a\\u043e\\u0448\\u0430\\u0447\\u0438\\u0439\",\"qty\":3,\"cost\":3810}]', '2024-11-05 21:04:58', '2024-11-06', 3810, 2),
(2, 1, '[{\"title\":\"\\u0413\\u0443\\u043c\\u0443\\u0441 \\u043a\\u043e\\u0448\\u0430\\u0447\\u0438\\u0439\",\"qty\":11,\"cost\":13970}]', '2024-11-05 22:30:25', '2024-11-08', 13970, 0),
(3, 2, '[{\"title\":\"\\u0411\\u0438\\u043e\\u0423\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u0417\\u0435\\u043b\\u0435\\u043d\\u0430\\u044f \\u0421\\u0438\\u043b\\u0430\\\"\",\"qty\":7,\"cost\":23940},{\"title\":\"\\u0410\\u0433\\u0440\\u043e-\\u041c\\u0430\\u0441\\u0442\\u0435\\u0440 \\\"\\u041a\\u0430\\u043b\\u044c\\u0446\\u0438\\u0439-\\u041c\\u0430\\u0433\\u043d\\u0438\\u0439\\\"\",\"qty\":4,\"cost\":35860}]', '2024-11-05 22:39:36', '2024-11-06', 59800, 2),
(4, 2, '[{\"title\":\"\\u041a\\u0430\\u043b\\u0438\\u0439\\u043d\\u044b\\u0435 \\u0443\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u044f \\\"\\u0424\\u043e\\u0441\\u041a\\u0430\\u043b\\\"\",\"qty\":1,\"cost\":4832}]', '2024-11-05 22:41:05', '2024-11-10', 4832, 0),
(5, 2, '[{\"title\":\"\\u0411\\u0438\\u043e\\u0423\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u0417\\u0435\\u043b\\u0435\\u043d\\u0430\\u044f \\u0421\\u0438\\u043b\\u0430\\\"\",\"qty\":2,\"cost\":6840}]', '2024-11-05 22:48:20', '2024-11-06', 6840, 2),
(6, 2, '[{\"title\":\"\\u0410\\u0437\\u043e\\u0442\\u043d\\u043e\\u0435 \\u0443\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u041d\\u0438\\u0442\\u0440\\u043e\\u041c\\u0430\\u043a\\u0441\\\"\",\"qty\":8,\"cost\":83096},{\"title\":\"\\u041e\\u0440\\u0433\\u0430\\u043d\\u0438\\u0447\\u0435\\u0441\\u043a\\u0430\\u044f \\u043f\\u043e\\u0434\\u043a\\u043e\\u0440\\u043c\\u043a\\u0430 \\\"\\u041b\\u0443\\u043d\\u043d\\u044b\\u0439 \\u0426\\u0432\\u0435\\u0442\\\"\",\"qty\":31,\"cost\":196819},{\"title\":\"\\u0411\\u0438\\u043e\\u0423\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u0417\\u0435\\u043b\\u0435\\u043d\\u0430\\u044f \\u0421\\u0438\\u043b\\u0430\\\"\",\"qty\":6,\"cost\":20520}]', '2024-11-06 01:41:19', '2024-11-11', 300435, 0),
(7, 2, '[{\"title\":\"\\u041e\\u0440\\u0433\\u0430\\u043d\\u0438\\u0447\\u0435\\u0441\\u043a\\u0430\\u044f \\u043f\\u043e\\u0434\\u043a\\u043e\\u0440\\u043c\\u043a\\u0430 \\\"\\u041b\\u0443\\u043d\\u043d\\u044b\\u0439 \\u0426\\u0432\\u0435\\u0442\\\"\",\"qty\":4,\"cost\":25396}]', '2024-11-06 01:48:11', '2024-11-10', 25396, 0),
(8, 1, '[{\"title\":\"\\u0410\\u0433\\u0440\\u043e-\\u041c\\u0430\\u0441\\u0442\\u0435\\u0440 \\\"\\u041a\\u0430\\u043b\\u044c\\u0446\\u0438\\u0439-\\u041c\\u0430\\u0433\\u043d\\u0438\\u0439\\\"\",\"qty\":8,\"cost\":71720}]', '2024-11-06 12:11:14', '2024-11-10', 71720, 0),
(9, 3, '[{\"title\":\"\\u0410\\u0433\\u0440\\u043e-\\u041c\\u0430\\u0441\\u0442\\u0435\\u0440 \\\"\\u041a\\u0430\\u043b\\u044c\\u0446\\u0438\\u0439-\\u041c\\u0430\\u0433\\u043d\\u0438\\u0439\\\"\",\"qty\":1,\"cost\":8965}]', '2024-11-07 12:09:14', '2024-11-11', 8965, 0),
(10, 1, '[{\"title\":\"\\u0411\\u0438\\u043e\\u0423\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u0417\\u0435\\u043b\\u0435\\u043d\\u0430\\u044f \\u0421\\u0438\\u043b\\u0430\\\"\",\"qty\":5,\"cost\":17100},{\"title\":\"\\u0413\\u0443\\u043c\\u0443\\u0441 \\u043a\\u043e\\u0448\\u0430\\u0447\\u0438\\u0439\",\"qty\":2,\"cost\":2540}]', '1915-12-07 12:30:07', '2024-11-06', 19640, 0),
(11, 1, '[{\"title\":\"\\u0410\\u0437\\u043e\\u0442\\u043d\\u043e\\u0435 \\u0443\\u0434\\u043e\\u0431\\u0440\\u0435\\u043d\\u0438\\u0435 \\\"\\u041d\\u0438\\u0442\\u0440\\u043e\\u041c\\u0430\\u043a\\u0441\\\"\",\"qty\":3,\"cost\":31161}]', '2024-11-11 15:33:18', '2024-11-14', 31161, 0),
(12, 1, '[{\"title\":\"\\u0410\\u043a\\u0442\\u0438\\u0432\\u0430\\u0442\\u043e\\u0440 \\\"\\u0421\\u0443\\u043f\\u0435\\u0440\\u0444\\u043e\\u0441\\u0444\\u0430\\u0442\\\"\",\"qty\":2,\"cost\":14682}]', '2024-11-15 22:27:38', '2024-11-15', 14682, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(4) UNSIGNED NOT NULL,
  `order_id` int(4) UNSIGNED NOT NULL,
  `client_id` int(4) UNSIGNED NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '5'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(4) UNSIGNED NOT NULL,
  `login` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `secondname` varchar(32) NOT NULL,
  `payment_id` int(4) NOT NULL DEFAULT '-1',
  `avatar_src` varchar(256) NOT NULL DEFAULT '/user_data/avatar_default.jpg',
  `phone` varchar(10) NOT NULL,
  `delivery_address` varchar(128) DEFAULT NULL,
  `role` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0 - user, 1 - admin'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `firstname`, `secondname`, `payment_id`, `avatar_src`, `phone`, `delivery_address`, `role`) VALUES
(1, 'loprin05', '822cd713a79bae46473d6893d0f4b046', 'Iljya.Kunsevich@yandex.ru', 'Илья', 'Кунцевич', 1, '/user_data/672c978a4883a.jpeg', '9198092998', 'ул. Магницкого, д. 43', 0),
(2, 'ikulakov05', '22ec81cbaac2d3b66abce7d5b8437228', 'ikulakov@example.ru', 'Иван', 'Кулаков', 2, '/user_data/6738f184e2d4b.jpg', '9395684433', 'г. Кинель, ул. Элеваторная, д. 2', 0),
(3, 'jude_1378', '22ec81cbaac2d3b66abce7d5b8437228', 'jude@example.ru', 'Жид', 'Махновски', 3, '/user_data/672c87fd439ab.jpg', '9367867987', 'ул.Пушкина,д.3,кв.25', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
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
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
