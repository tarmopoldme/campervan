<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210618120145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create initial database structure + some test data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `cv_campervan`;
CREATE TABLE `cv_campervan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cv_campervan` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(57),
(58),
(59),
(60),
(61),
(62),
(63),
(64),
(65),
(66),
(67),
(68),
(69),
(70),
(71),
(72),
(73),
(74),
(75),
(76),
(77),
(78),
(79),
(80),
(81),
(82),
(83),
(84),
(85),
(86),
(87),
(88),
(89),
(90),
(91),
(92),
(93),
(94),
(95),
(96),
(97),
(98),
(99),
(100);

DROP TABLE IF EXISTS `cv_equipment`;
CREATE TABLE `cv_equipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `cv_equipment` (`id`, `name`) VALUES
(1,	'Camping table'),
(2,	'Portable toilet'),
(3,	'Bed sheet'),
(4,	'Chair'),
(5,	'Sleeping bag');

DROP TABLE IF EXISTS `cv_order`;
CREATE TABLE `cv_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campervan_id` int(10) unsigned NOT NULL,
  `start_station_id` int(10) unsigned NOT NULL,
  `end_station_id` int(10) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `campervan_id` (`campervan_id`),
  KEY `start_station_id` (`start_station_id`),
  KEY `end_station_id` (`end_station_id`),
  CONSTRAINT `cv_order_ibfk_1` FOREIGN KEY (`campervan_id`) REFERENCES `cv_campervan` (`id`),
  CONSTRAINT `cv_order_ibfk_2` FOREIGN KEY (`start_station_id`) REFERENCES `cv_station` (`id`),
  CONSTRAINT `cv_order_ibfk_3` FOREIGN KEY (`end_station_id`) REFERENCES `cv_station` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `cv_order_equipment`;
CREATE TABLE `cv_order_equipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `equipment_id` int(10) unsigned NOT NULL,
  `booked_count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `equipment_id` (`equipment_id`),
  CONSTRAINT `cv_order_equipment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `cv_order` (`id`),
  CONSTRAINT `cv_order_equipment_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `cv_equipment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


SET NAMES utf8mb4;

DROP TABLE IF EXISTS `cv_station`;
CREATE TABLE `cv_station` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cv_station` (`id`, `name`) VALUES
(1,	'Munich'),
(2,	'Paris'),
(3,	'Porto'),
(4,	'Madrid'),
(5,	'Sindi');

DROP TABLE IF EXISTS `cv_station_equipment_demand`;
CREATE TABLE `cv_station_equipment_demand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `station_id` int(10) unsigned NOT NULL,
  `equipment_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `booked_count` int(10) unsigned NOT NULL,
  `available_count` int(10) NOT NULL COMMENT 'Value might be negative',
  PRIMARY KEY (`id`),
  KEY `station_id` (`station_id`),
  KEY `equipment_id` (`equipment_id`),
  CONSTRAINT `cv_station_equipment_demand_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `cv_station` (`id`),
  CONSTRAINT `cv_station_equipment_demand_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `cv_equipment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
SET foreign_key_checks = 1;
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
SET foreign_key_checks = 0;
DROP TABLE IF EXISTS `cv_campervan`;
DROP TABLE IF EXISTS `cv_equipment`;
DROP TABLE IF EXISTS `cv_order`;
DROP TABLE IF EXISTS `cv_order_equipment`;
DROP TABLE IF EXISTS `cv_station`;
DROP TABLE IF EXISTS `cv_station_equipment_demand`;
SET foreign_key_checks = 1;
SQL
        );

    }
}
