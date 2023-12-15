-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2017 at 03:39 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL DEFAULT 'check',
  `recoverpass` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `email`, `password`, `hash`, `recoverpass`) VALUES
(1, 'Sebastian', 'Sulinski', 'admin@gmail.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '34ac4acb4aa3f549c6e12fdbfd172009eef7a98e3ba2106a30450002f6b1df67f55823f218a0a953bea016df8117120f289e28d16be3d065335c28be4dfb116a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `website` varchar(200) NOT NULL,
  `vat_rate` decimal(5,2) NOT NULL,
  `logocompany` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`id`, `name`, `address`, `telephone`, `email`, `website`, `vat_rate`, `logocompany`) VALUES
(1, 'Web Solutions', '15 Future Dr \r\nAsheville, NC 28803', '(828)335-0783', 'spartakkuzminus@gmail.com', 'xxx.com', '0.00', 'web_solutions.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `parentPath` varchar(255) NOT NULL DEFAULT '0',
  `imageCategorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent`, `name`, `parentPath`, `imageCategorie`) VALUES
(1, 0, 'Biographies &amp; Autobiographies', '0', 'biographies_autobiographies.jpg'),
(2, 0, 'Computers &amp; IT', '0', 'computers_it.jpg'),
(3, 0, 'Art &amp; Architecture', '0', 'art_architecture.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `state` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(255) DEFAULT NULL,
  `recoverpass` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `address_1`, `address_2`, `city`, `zip_code`, `state`, `email`, `password`, `date`, `active`, `hash`, `recoverpass`) VALUES
(1, 'Sebastian', 'Sulinski', 'Some address', '', 'Bognor Regis', '26301', 23, 'kisel.1dispatch@gmail.com', '647a1370060778d57e5016ab9a6b2fd320f7eca273d2f4d656b8e8e6139bb9f3151c455753df8af9e53c3555edcf007a7253e28e2a905ee9a09c9b32807a328d', '2010-12-14 18:27:56', 1, 'adc9e89d08b11151c45ba8040bf965460fd89a693f610e16e02853d64ab8a3dfc07bff02e4428c1c2b468c69fd1dc9a94d9a2a2e65628f46a033a8f7fed51f34', 0),
(2, 'Spartak', 'Kuzmin', '15 Future Dr', '#17D', 'Asheville', '28803', 34, 'test@gmail.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2017-03-30 03:48:23', 1, '6e51395cbb7177a9ad0eade484b91a64582e6b2375067dcf0882dd7685a275f37ac33fcac4df59696411ac5ba1a2f0e834505e11bd4c9c274c25905f4e43e12a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`) VALUES
(1, 'Afghanistan', 'AF'),
(2, 'Ãland Islands', 'AX'),
(3, 'Albania', 'AL'),
(4, 'Algeria', 'DZ'),
(5, 'American Samoa', 'AS'),
(6, 'Andorra', 'AD'),
(7, 'Angola', 'AO'),
(8, 'Anguilla', 'AI'),
(9, 'Antarctica', 'AQ'),
(10, 'Antigua And Barbuda', 'AG'),
(11, 'Argentina', 'AR'),
(12, 'Armenia', 'AM'),
(13, 'Aruba', 'AW'),
(14, 'Australia', 'AU'),
(15, 'Austria', 'AT'),
(16, 'Azerbaijan', 'AZ'),
(17, 'Bahamas', 'BS'),
(18, 'Bahrain', 'BH'),
(19, 'Bangladesh', 'BD'),
(20, 'Barbados', 'BB'),
(21, 'Belarus', 'BY'),
(22, 'Belgium', 'BE'),
(23, 'Belize', 'BZ'),
(24, 'Benin', 'BJ'),
(25, 'Bermuda', 'BM'),
(26, 'Bhutan', 'BT'),
(27, 'Bolivia', 'BO'),
(28, 'Bosnia And Herzegovina', 'BA'),
(29, 'Botswana', 'BW'),
(30, 'Bouvet Island', 'BV'),
(31, 'Brazil', 'BR'),
(32, 'British Indian Ocean Territory', 'IO'),
(33, 'Brunei Darussalam', 'BN'),
(34, 'Bulgaria', 'BG'),
(35, 'Burkina Faso', 'BF'),
(36, 'Burundi', 'BI'),
(37, 'Cambodia', 'KH'),
(38, 'Cameroon', 'CM'),
(39, 'Canada', 'CA'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Congo, The Democratic Republic Of', 'CD'),
(52, 'Cook Islands', 'CK'),
(53, 'Costa Rica', 'CR'),
(54, 'Cote D\'ivoire', 'CI'),
(55, 'Croatia', 'HR'),
(56, 'Cuba', 'CU'),
(57, 'Cyprus', 'CY'),
(58, 'Czech Republic', 'CZ'),
(59, 'Denmark', 'DK'),
(60, 'Djibouti', 'DJ'),
(61, 'Dominica', 'DM'),
(62, 'Dominican Republic', 'DO'),
(63, 'Ecuador', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'French Guiana', 'GF'),
(76, 'French Polynesia', 'PF'),
(77, 'French Southern Territories', 'TF'),
(78, 'Gabon', 'GA'),
(79, 'Gambia', 'GM'),
(80, 'Georgia', 'GE'),
(81, 'Germany', 'DE'),
(82, 'Ghana', 'GH'),
(83, 'Gibraltar', 'GI'),
(84, 'Greece', 'GR'),
(85, 'Greenland', 'GL'),
(86, 'Grenada', 'GD'),
(87, 'Guadeloupe', 'GP'),
(88, 'Guam', 'GU'),
(89, 'Guatemala', 'GT'),
(90, 'Guernsey', 'GG'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard Island And Mcdonald Islands', 'HM'),
(96, 'Holy See (vatican City State)', 'VA'),
(97, 'Honduras', 'HN'),
(98, 'Hong Kong', 'HK'),
(99, 'Hungary', 'HU'),
(100, 'Iceland', 'IS'),
(101, 'India', 'IN'),
(102, 'Indonesia', 'ID'),
(103, 'Iran, Islamic Republic Of', 'IR'),
(104, 'Iraq', 'IQ'),
(105, 'Ireland', 'IE'),
(106, 'Isle Of Man', 'IM'),
(107, 'Israel', 'IL'),
(108, 'Italy', 'IT'),
(109, 'Jamaica', 'JM'),
(110, 'Japan', 'JP'),
(111, 'Jersey', 'JE'),
(112, 'Jordan', 'JO'),
(113, 'Kazakhstan', 'KZ'),
(114, 'Kenya', 'KE'),
(115, 'Kiribati', 'KI'),
(116, 'Korea, Democratic People\'s Republic Of', 'KP'),
(117, 'Korea, Republic Of', 'KR'),
(118, 'Kuwait', 'KW'),
(119, 'Kyrgyzstan', 'KG'),
(120, 'Lao People\'s Democratic Republic', 'LA'),
(121, 'Latvia', 'LV'),
(122, 'Lebanon', 'LB'),
(123, 'Lesotho', 'LS'),
(124, 'Liberia', 'LR'),
(125, 'Libyan Arab Jamahiriya', 'LY'),
(126, 'Liechtenstein', 'LI'),
(127, 'Lithuania', 'LT'),
(128, 'Luxembourg', 'LU'),
(129, 'Macao', 'MO'),
(130, 'Macedonia, The Former Yugoslav Republic Of', 'MK'),
(131, 'Madagascar', 'MG'),
(132, 'Malawi', 'MW'),
(133, 'Malaysia', 'MY'),
(134, 'Maldives', 'MV'),
(135, 'Mali', 'ML'),
(136, 'Malta', 'MT'),
(137, 'Marshall Islands', 'MH'),
(138, 'Martinique', 'MQ'),
(139, 'Mauritania', 'MR'),
(140, 'Mauritius', 'MU'),
(141, 'Mayotte', 'YT'),
(142, 'Mexico', 'MX'),
(143, 'Micronesia, Federated States Of', 'FM'),
(144, 'Moldova, Republic Of', 'MD'),
(145, 'Monaco', 'MC'),
(146, 'Mongolia', 'MN'),
(147, 'Montserrat', 'MS'),
(148, 'Morocco', 'MA'),
(149, 'Mozambique', 'MZ'),
(150, 'Myanmar', 'MM'),
(151, 'Namibia', 'NA'),
(152, 'Nauru', 'NR'),
(153, 'Nepal', 'NP'),
(154, 'Netherlands', 'NL'),
(155, 'Netherlands Antilles', 'AN'),
(156, 'New Caledonia', 'NC'),
(157, 'New Zealand', 'NZ'),
(158, 'Nicaragua', 'NI'),
(159, 'Niger', 'NE'),
(160, 'Nigeria', 'NG'),
(161, 'Niue', 'NU'),
(162, 'Norfolk Island', 'NF'),
(163, 'Northern Mariana Islands', 'MP'),
(164, 'Norway', 'NO'),
(165, 'Oman', 'OM'),
(166, 'Pakistan', 'PK'),
(167, 'Palau', 'PW'),
(168, 'Palestinian Territory, Occupied', 'PS'),
(169, 'Panama', 'PA'),
(170, 'Papua New Guinea', 'PG'),
(171, 'Paraguay', 'PY'),
(172, 'Peru', 'PE'),
(173, 'Philippines', 'PH'),
(174, 'Pitcairn', 'PN'),
(175, 'Poland', 'PL'),
(176, 'Portugal', 'PT'),
(177, 'Puerto Rico', 'PR'),
(178, 'Qatar', 'QA'),
(179, 'Reunion', 'RE'),
(180, 'Romania', 'RO'),
(181, 'Russian Federation', 'RU'),
(182, 'Rwanda', 'RW'),
(183, 'Saint Helena', 'SH'),
(184, 'Saint Kitts And Nevis', 'KN'),
(185, 'Saint Lucia', 'LC'),
(186, 'Saint Pierre And Miquelon', 'PM'),
(187, 'Saint Vincent And The Grenadines', 'VC'),
(188, 'Samoa', 'WS'),
(189, 'San Marino', 'SM'),
(190, 'Sao Tome And Principe', 'ST'),
(191, 'Saudi Arabia', 'SA'),
(192, 'Senegal', 'SN'),
(193, 'Serbia And Montenegro', 'CS'),
(194, 'Seychelles', 'SC'),
(195, 'Sierra Leone', 'SL'),
(196, 'Singapore', 'SG'),
(197, 'Slovakia', 'SK'),
(198, 'Slovenia', 'SI'),
(199, 'Solomon Islands', 'SB'),
(200, 'Somalia', 'SO'),
(201, 'South Africa', 'ZA'),
(202, 'South Georgia And The South Sandwich Islands', 'GS'),
(203, 'Spain', 'ES'),
(204, 'Sri Lanka', 'LK'),
(205, 'Sudan', 'SD'),
(206, 'Suriname', 'SR'),
(207, 'Svalbard And Jan Mayen', 'SJ'),
(208, 'Swaziland', 'SZ'),
(209, 'Sweden', 'SE'),
(210, 'Switzerland', 'CH'),
(211, 'Syrian Arab Republic', 'SY'),
(212, 'Taiwan, Province Of China', 'TW'),
(213, 'Tajikistan', 'TJ'),
(214, 'Tanzania, United Republic Of', 'TZ'),
(215, 'Thailand', 'TH'),
(216, 'Timor-leste', 'TL'),
(217, 'Togo', 'TG'),
(218, 'Tokelau', 'TK'),
(219, 'Tonga', 'TO'),
(220, 'Trinidad And Tobago', 'TT'),
(221, 'Tunisia', 'TN'),
(222, 'Turkey', 'TR'),
(223, 'Turkmenistan', 'TM'),
(224, 'Turks And Caicos Islands', 'TC'),
(225, 'Tuvalu', 'TV'),
(226, 'Uganda', 'UG'),
(227, 'Ukraine', 'UA'),
(228, 'United Arab Emirates', 'AE'),
(229, 'United Kingdom', 'GB'),
(230, 'United States', 'US'),
(231, 'United States Minor Outlying Islands', 'UM'),
(232, 'Uruguay', 'UY'),
(233, 'Uzbekistan', 'UZ'),
(234, 'Vanuatu', 'VU'),
(235, 'Venezuela', 'VE'),
(236, 'Viet Nam', 'VN'),
(237, 'Virgin Islands, British', 'VG'),
(238, 'Virgin Islands, U.S.', 'VI'),
(239, 'Wallis And Futuna', 'WF'),
(240, 'Western Sahara', 'EH'),
(241, 'Yemen', 'YE'),
(242, 'Zambia', 'ZM'),
(243, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `vat_rate` decimal(5,2) NOT NULL,
  `vat` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `pp_status` tinyint(1) NOT NULL DEFAULT '0',
  `txn_id` varchar(100) DEFAULT NULL,
  `payment_status` varchar(100) DEFAULT NULL,
  `ipn` text,
  `response` varchar(100) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client`, `vat_rate`, `vat`, `subtotal`, `total`, `date`, `status`, `pp_status`, `txn_id`, `payment_status`, `ipn`, `response`, `notes`) VALUES
(1, 1, '17.50', '16.58', '94.75', '111.33', '2010-12-14 19:20:52', 3, 1, 'asdf', 'Completed', NULL, NULL, 'Some notes about the order'),
(3, 2, '7.00', '1.14', '16.25', '17.39', '2017-05-11 15:33:48', 3, 1, NULL, 'Completed', NULL, NULL, 'The payement with a permanent credit / debit card');

-- --------------------------------------------------------

--
-- Table structure for table `orders_items`
--

CREATE TABLE `orders_items` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_items`
--

INSERT INTO `orders_items` (`id`, `order`, `product`, `price`, `qty`) VALUES
(1, 1, 19, '18.95', 5),
(3, 3, 1, '16.25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `date` datetime NOT NULL,
  `category` int(11) NOT NULL,
  `image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `date`, `category`, `image`) VALUES
(1, 'Lou Reed&#039;s New York', 'After his first book of photographs was published, Lou Reed told a journalist for The Independent on Sunday that, &quot;I live on intuition and taking pictures is intuitive.&quot; Here, we see Lou Reed&#039;s intuitive take on New York, the city that has been the fulcrum of his creative world for decades and with which he has become indelibly identified. We&#039;ve heard about the streets and characters for so long through his words and music, and now we can see it through his eyes. Over 100 of Reed&#039;s photographs comprise New York, an intimate view of what inspires him. Hardcover, 9 x 13.5 in./192 pgs / 100 color.', '16.25', '2010-07-19 22:58:30', 1, 'lou_reed_s_new_york.jpg'),
(2, 'Andy Warhol Prints: A Catalogue Raisonne 1962-1987', 'No one can doubt that Andy Warhol has influenced the American art world both as an artist and as a personality. Feldman and Schellmann&#039;s catalog provides the specialist with a multitude of color images that do much to illuminate Warhol as a printmaker. Unfortunately, the reproductions take up less space than the blank areas surrounding them. These small reproductions are preceded by two brief essays that provide a less-than-adequate introduction to the prints. Geldzahler has only praise for Warhol and dutifully acclaims his ``contribution to art history.&#039;&#039; Roberta Bernstein&#039;s essay is more substantive; she is more analytical and willing to make critical judgments. Though useful as a catalog of Warhol&#039;s 364 prints, this book is not what it could be. Douglas G. Campbell, Ctr. for Fine Arts, Warner Pacific Coll., Portland, Ore.\r\nCopyright 1985 Reed Business Information, Inc.', '17.50', '2010-07-19 23:01:23', 3, 'andy_warhol_prints_a_catalogue_raisonne_.jpg'),
(3, 'The Autobiography and Sex Life of Andy Warhol', 'Village Voice and Interview cofounder John Wilcock was first drawn into the milieu of Andy Warhol through filmmaker Jonas Mekas, assisting on some of Warhol&#039;s early films, hanging out at his parties and quickly becoming a regular at the Factory. &quot;About six months after I started hanging out at the old, silvery Factory on West 47th Street,&quot; he recalls, &quot;[Gerard] Malanga came up to me and asked, &#039;When are you going to write something about us?&#039;&quot; Already fascinated by Warhol&#039;s persona, Wilcock went to work, interviewing the artist&#039;s closest associates, supporters and superstars. Among these were Malanga, Naomi Levine, Taylor Mead and Ultra Violet, all of whom had been in the earliest films; scriptwriter Ronnie Tavel, and photographer Gretchen Berg; art dealers Sam Green, Ivan Karp, Eleanor Ward and Leo Castelli, and the Metropolitan Museum of Art&#039;s Henry Geldzahler; the poets Charles Henri Ford and Taylor Mead, and the artist Marisol; and the musicians Lou Reed and Nico. Paul Morrissey supplied the title: The Autobiography and Sex Life of Andy Warhol is the first oral biography of the artist. First published in 1971, and pitched against the colorful backdrop of the 1960s, it assembles a prismatic portrait of one of modern art&#039;s least knowable artists during the early years of his fame. The Autobiography and Sex Life is likely the most revealing portrait of Warhol, being composite instead of singular; each of its interviewees offers a piece of the puzzle that was Andy Warhol. This new edition corrects the many errors of the first, and is beautifully designed in a bright, Warholian palette with numerous illustrations.The British-born writer John Wilcock cofounded The Village Voice in 1955, and went on to edit seminal publications such as The East Village Other, Los Angeles Free Press, Other Scenes and (in 1970) Interview, with Andy Warhol. ', '28.56', '2010-07-19 23:03:29', 1, 'the_autobiography_and_sex_life_of_andy_warhol.jpg'),
(13, 'Inside The Actors Studio - Johnny Depp', 'In one of only a handful of interviews Johnny Depp has ever granted, he brings both his fascinating eccentricity and his deep, uncompromising devotion to the craft of acting to the master s degree candidates of the Actors Studio Drama School at Pace University and to the viewers of Inside the Actors Studio in 125 countries around the world. ', '18.54', '2010-07-19 23:13:48', 1, 'inside_the_actors_studio_johnny_depp.jpg'),
(14, 'Miles, the Autobiography', 'Miles Davis, with all his faults, flaws and laughable quirks, was still one of the most important musicians of the twentieth century. It takes a book like this where he leaves no stone unturned to make clear the debt we all owe him and his contemporaries, as well as the restless spirit that lead him beyond what he helped to establish as modern jazz. In many ways he shows himself to be, ironically, the archetypal and sterotypical artist simultaneously. Yet his telling of the profound friendships he had with Max Roach and Coltrane, his deep awe and respect but dispassionate eye for the genius and addictions of Charlie Parker, the loves of his life- and what he put them through, and his brutal, courageous hoonesty in general, gives us a gift of his haunting humanity.', '9.68', '2010-07-19 23:19:08', 1, 'miles_the_autobiography.jpg'),
(16, 'Dali (Taschen Basic Art Series)', 'Surveys the life and work of the Surrealist artist, and describes how his artistic vision transformed great works from earlier periods in art history. ', '18.48', '2010-07-19 23:22:48', 3, 'dali_taschen_basic_art_series_.jpg'),
(17, 'Wicked Cool PHP: Real-World Scripts That Solve Difficult Problems', 'Wicked Cool PHP capitalizes on the success of the &quot;Wicked Cool&quot; series from No Starch Press. Rather than focus on the basics of the language, Wicked Cool PHP provides (and explains) PHP scripts that can be implemented immediately to simplify webmasters&#039; lives. These include unique scripts for processing credit cards, checking for valid email addresses, templating, overriding PHP&#039;s default settings, and serving dynamic images and text. Readers will also find extensive sections on working with forms, words, and files; ways to harden PHP by closing common security holes; and instructions for keeping data and transactions secure. By exploring working code, readers learn how to customize their webserver&#039;s behavior, prevent spammers from adding annoying comments, scrape information from other web sites, and much more. This is a book that&#039;s sure to appeal to PHP programmers who have been there and done that and who want a book that delivers meaty content, not only promise.', '18.67', '2010-07-19 23:27:01', 2, 'wicked_cool_php_real_world_scripts_that_solve_difficult_problems.jpg'),
(18, 'PHP Objects, Patterns and Practice 3rd Edition', 'This book takes you beyond the PHP basics to the enterprise development practices used by professional programmers. Updated for PHP 5.3 with new sections on closures, namespaces, and continuous integration, this edition will teach you about object features such as abstract classes, reflection, interfaces, and error handling. You&#039;ll also discover object tools to help you learn more about your classes, objects, and methods.\r\n\r\nThen you&#039;ll move into design patterns and the principles that make patterns powerful. You&#039;ll learn both classic design patterns and enterprise and database patterns with easy-to-follow examples.\r\n\r\nFinally, you&#039;ll discover how to put it all into practice to help turn great code into successful projects. You&#039;ll learn how to manage multiple developers with Subversion, and how to build and install using Phing and PEAR. You&#039;ll also learn strategies for automated testing and building, including continuous integration.', '28.91', '2010-07-19 23:28:58', 2, 'php_objects_patterns_and_practice_rd_edition.jpg'),
(19, '50 Artists You Should Know: From Giotto to Warhol', 'This vibrant reference guide profiles 50 major artists alongside their representative works. The entries are presented in an eye-catching format that includes brief biographies, time lines, and critical analyses. Additional information helps readers locate the artist&#039;s work online and in museums, a glossary of important terms, and sidebars highlighting relevant movements and techniques. Arranged chronologically, the selection of artists includes every major artistic movement and development since the Gothic period, giving readers a clear understanding of the evolution of the visual arts. Perfect for casual reading or easy reference, this accessible overview is a fun and practical art history lesson that everyone can enjoy. ', '18.95', '2010-07-20 10:45:16', 3, '_artists_you_should_know_from_giotto_to_warhol.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` smallint(5) UNSIGNED NOT NULL COMMENT 'PK: State ID',
  `state_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'State name with first letter capital',
  `state_abbr` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Optional state abbreviation (US 2 cap letters)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`, `state_abbr`) VALUES
(1, 'Alabama', 'AL'),
(2, 'Alaska', 'AK'),
(3, 'Arizona', 'AZ'),
(4, 'Arkansas', 'AR'),
(5, 'California', 'CA'),
(6, 'Colorado', 'CO'),
(7, 'Connecticut', 'CT'),
(8, 'Delaware', 'DE'),
(9, 'District of Columbia', 'DC'),
(10, 'Florida', 'FL'),
(11, 'Georgia', 'GA'),
(12, 'Hawaii', 'HI'),
(13, 'Idaho', 'ID'),
(14, 'Illinois', 'IL'),
(15, 'Indiana', 'IN'),
(16, 'Iowa', 'IA'),
(17, 'Kansas', 'KS'),
(18, 'Kentucky', 'KY'),
(19, 'Louisiana', 'LA'),
(20, 'Maine', 'ME'),
(21, 'Maryland', 'MD'),
(22, 'Massachusetts', 'MA'),
(23, 'Michigan', 'MI'),
(24, 'Minnesota', 'MN'),
(25, 'Mississippi', 'MS'),
(26, 'Missouri', 'MO'),
(27, 'Montana', 'MT'),
(28, 'Nebraska', 'NE'),
(29, 'Nevada', 'NV'),
(30, 'New Hampshire', 'NH'),
(31, 'New Jersey', 'NJ'),
(32, 'New Mexico', 'NM'),
(33, 'New York', 'NY'),
(34, 'North Carolina', 'NC'),
(35, 'North Dakota', 'ND'),
(36, 'Ohio', 'OH'),
(37, 'Oklahoma', 'OK'),
(38, 'Oregon', 'OR'),
(39, 'Pennsylvania', 'PA'),
(40, 'Rhode Island', 'RI'),
(41, 'South Carolina', 'SC'),
(42, 'South Dakota', 'SD'),
(43, 'Tennessee', 'TN'),
(44, 'Texas', 'TX'),
(45, 'Utah', 'UT'),
(46, 'Vermont', 'VT'),
(47, 'Virginia', 'VA'),
(48, 'Washington', 'WA'),
(49, 'West Virginia', 'WV'),
(50, 'Wisconsin', 'WI'),
(51, 'Wyoming', 'WY');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Dispatched');

-- --------------------------------------------------------

--
-- Table structure for table `usercards`
--

CREATE TABLE `usercards` (
  `cardid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cardnetwork` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cardnumber` varchar(255) CHARACTER SET utf8 NOT NULL,
  `somevalue` varchar(255) CHARACTER SET utf8 NOT NULL,
  `csncard` int(3) NOT NULL,
  `expirationdate` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usercards`
--

INSERT INTO `usercards` (`cardid`, `userid`, `cardnetwork`, `cardnumber`, `somevalue`, `csncard`, `expirationdate`) VALUES
(1, 2, 'mastercard', 'Gl1G9471Mqz3Qm7my1ruZDZYsEf+FXk+jq5DZxPJBc4=', 'lenIxStcCNoHSks2d5Nxhla9IG2BodSt/D6lXwlFEos=', 567, '1/2019'),
(2, 2, 'visa', 'kMygzrsTgh2sbdxzLi12pgJy+Tspzx0aa5rxR9uq9S0=', 'MG/oye1nhq45/eqvRv6FFuka22vBbXyloknRKRhkmg8=', 722, '1/2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`state`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client` (`client`),
  ADD KEY `fk_stage` (`status`);

--
-- Indexes for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order`,`product`),
  ADD KEY `FK_PRODUCT` (`product`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usercards`
--
ALTER TABLE `usercards`
  ADD PRIMARY KEY (`cardid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `orders_items`
--
ALTER TABLE `orders_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `state_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK: State ID', AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `usercards`
--
ALTER TABLE `usercards`
  MODIFY `cardid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client`) REFERENCES `clients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders_items`
--
ALTER TABLE `orders_items`
  ADD CONSTRAINT `orders_items_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_items_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
