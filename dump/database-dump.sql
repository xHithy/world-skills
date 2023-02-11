-- -------------------------------------------------------------
-- TablePlus 5.3.0(486)
--
-- https://tableplus.com/
--
-- Database: worldskills
-- Generation Time: 2023-02-11 01:40:06.8470
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `registered_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `blocked` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `games` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `author_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `game_id` bigint unsigned NOT NULL,
  `version` int NOT NULL,
  `timestamp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiring_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `registered_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `versions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint unsigned NOT NULL,
  `version` int NOT NULL,
  `timestamp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`id`, `username`, `password`, `registered_at`, `last_login`) VALUES
(1, 'admin1', 'hellouniverse1!', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z'),
(2, 'admin2', 'hellouniverse2!', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z');

INSERT INTO `games` (`id`, `title`, `description`, `thumbnail`, `slug`, `status`, `author_id`) VALUES
(1, 'Demo Game 1', 'This is demo game 1', NULL, 'demo-game-1', 'active', 3),
(2, 'Demo Game 2', 'This is demo game 2', NULL, 'demo-game-2', 'active', 4);

INSERT INTO `scores` (`id`, `user_id`, `game_id`, `version`, `timestamp`, `score`) VALUES
(1, 1, 1, 1, '2023-02-05T10:20:48.836Z', 10.00),
(2, 1, 1, 1, '2023-02-05T10:20:48.836Z', 15.00),
(3, 1, 1, 2, '2023-02-05T10:20:48.836Z', 12.00),
(4, 2, 1, 2, '2023-02-05T10:20:48.836Z', 20.00),
(5, 2, 2, 1, '2023-02-05T10:20:48.836Z', 30.00),
(6, 3, 1, 2, '2023-02-05T10:20:48.836Z', 1000.00),
(7, 3, 1, 2, '2023-02-05T10:20:48.836Z', -300.00),
(8, 4, 1, 2, '2023-02-05T10:20:48.836Z', 5.00),
(9, 4, 2, 1, '2023-02-05T10:20:48.836Z', 200.00);

INSERT INTO `users` (`id`, `username`, `password`, `status`, `registered_at`, `last_login`) VALUES
(1, 'player1', 'helloworld1!', 'active', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z'),
(2, 'player2', 'helloworld2!', 'active', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z'),
(3, 'dev1', 'hellobyte1!', 'active', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z'),
(4, 'dev2', 'hellobyte2!', 'active', '2023-02-05T10:20:48.836Z', '2023-02-05T10:20:48.836Z');

INSERT INTO `versions` (`id`, `game_id`, `version`, `timestamp`, `thumbnail`, `path`) VALUES
(1, 1, 1, '2023-02-05T10:20:48.836Z', NULL, 'games/demo-game-1/1'),
(2, 1, 2, '2023-02-05T10:20:48.836Z', NULL, 'games/demo-game-1/2'),
(3, 2, 1, '2023-02-05T10:20:48.836Z', NULL, 'games/demo-game-2/1');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;