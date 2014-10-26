-- --------------------------------------------------------
-- Host:                         198.12.158.166
-- Server version:               5.5.38 - MySQL Community Server (GPL) by Remi
-- Server OS:                    Linux
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for online_payments
CREATE DATABASE IF NOT EXISTS `online_payments` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `online_payments`;


-- Dumping structure for table online_payments.applicable_manufacturers_or_gpo_making_payments
CREATE TABLE IF NOT EXISTS `applicable_manufacturers_or_gpo_making_payments` (
  `applicable_manufacturers_or_gpo_making_payment_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `country` varchar(250) NOT NULL,
  PRIMARY KEY (`applicable_manufacturers_or_gpo_making_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.autocomplete_terms
CREATE TABLE IF NOT EXISTS `autocomplete_terms` (
  `autocomplete_term_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`autocomplete_term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='since there are so many tables with so much information.. I am just going to make one table with all of the MAIN terms that would be in autocomplete data. Each term has at least one thing correlated to it.';

-- Data exporting was unselected.


-- Dumping structure for table online_payments.covered_recipient_types
CREATE TABLE IF NOT EXISTS `covered_recipient_types` (
  `covered_recipient_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`covered_recipient_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table that contains the types of reciepints';

-- Data exporting was unselected.


-- Dumping structure for table online_payments.form_of_payment_or_transfer_of_values
CREATE TABLE IF NOT EXISTS `form_of_payment_or_transfer_of_values` (
  `form_of_payment_or_transfer_of_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`form_of_payment_or_transfer_of_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.manufacturer_or_gpo_names
CREATE TABLE IF NOT EXISTS `manufacturer_or_gpo_names` (
  `manufacturer_or_gpo_name_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`manufacturer_or_gpo_name_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.nature_of_payment_or_transfer_of_values
CREATE TABLE IF NOT EXISTS `nature_of_payment_or_transfer_of_values` (
  `nature_of_payment_or_transfer_of_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`nature_of_payment_or_transfer_of_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.physician_primary_types
CREATE TABLE IF NOT EXISTS `physician_primary_types` (
  `physician_primary_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`physician_primary_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.physician_profiles
CREATE TABLE IF NOT EXISTS `physician_profiles` (
  `physician_profile_id` int(11) NOT NULL,
  `physician_first_name` varchar(100) NOT NULL,
  `physician_middle_name` varchar(100) NOT NULL,
  `physician_last_name` varchar(100) NOT NULL,
  `physician_name_suffix` varchar(100) NOT NULL,
  `physician_specialty_id` int(11) NOT NULL,
  `physician_primary_type_id` int(11) NOT NULL,
  `state_code1` char(50) NOT NULL,
  `state_code2` char(50) NOT NULL,
  `state_code3` char(50) NOT NULL,
  `state_code4` char(50) NOT NULL,
  `state_code5` char(50) NOT NULL,
  PRIMARY KEY (`physician_profile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table for physicians, primary key id comes from CSV imported';

-- Data exporting was unselected.


-- Dumping structure for table online_payments.physician_specialities
CREATE TABLE IF NOT EXISTS `physician_specialities` (
  `physician_specialty_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  PRIMARY KEY (`physician_specialty_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of specialties for physicians';

-- Data exporting was unselected.


-- Dumping structure for table online_payments.product_indicators
CREATE TABLE IF NOT EXISTS `product_indicators` (
  `product_indicator_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`product_indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.recipients
CREATE TABLE IF NOT EXISTS `recipients` (
  `recipient_id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_business_street_address_line1` varchar(250) NOT NULL DEFAULT '0',
  `primary_business_street_address_line2` varchar(250) NOT NULL DEFAULT '0',
  `city` varchar(250) NOT NULL DEFAULT '0',
  `state` varchar(250) NOT NULL DEFAULT '0',
  `zip` varchar(50) NOT NULL DEFAULT '0',
  `country` varchar(250) NOT NULL DEFAULT '0',
  `province` varchar(250) NOT NULL DEFAULT '0',
  `postal_code` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`recipient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.teaching_hospitals
CREATE TABLE IF NOT EXISTS `teaching_hospitals` (
  `teaching_hospital_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`teaching_hospital_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Table of teaching hospitals. The id that is primary key is taken from the CSV file';

-- Data exporting was unselected.


-- Dumping structure for table online_payments.third_party_entity_receiving_payment_or_transfer_of_value
CREATE TABLE IF NOT EXISTS `third_party_entity_receiving_payment_or_transfer_of_value` (
  `third_party_entity_receiving_payment_or_transfer_of_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`third_party_entity_receiving_payment_or_transfer_of_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.third_party_payment_recipient_indicators
CREATE TABLE IF NOT EXISTS `third_party_payment_recipient_indicators` (
  `third_party_payment_recipient_indicator_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`third_party_payment_recipient_indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table online_payments.transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL,
  `program_year` int(11) NOT NULL,
  `payment_publication_date` date NOT NULL,
  `manufacturer_or_gpo_name_id` int(11) DEFAULT NULL,
  `covered_recipient_type_id` int(11) DEFAULT NULL,
  `teaching_hospital_id` int(11) DEFAULT NULL,
  `physician_profile_id` int(11) DEFAULT NULL,
  `recipient_id` int(11) DEFAULT NULL,
  `product_indicator_id` int(11) DEFAULT NULL,
  `applicable_manufacturer_or_applicable_gpo_making_payment_id` bigint(20) DEFAULT NULL,
  `dispute_status_for_publication` tinyint(1) DEFAULT NULL,
  `total_amount_of_payment_usdollars` double DEFAULT NULL,
  `date_of_payment` date DEFAULT NULL,
  `number_of_payments_included_in_total_amount` int(11) DEFAULT NULL,
  `form_of_payment_or_transfer_of_value_id` int(11) DEFAULT NULL,
  `nature_of_payment_or_transfer_of_value_id` int(11) DEFAULT NULL,
  `city_of_travel` varchar(100) DEFAULT NULL,
  `state_of_travel` varchar(100) DEFAULT NULL,
  `country_of_travel` varchar(100) DEFAULT NULL,
  `physician_ownership_indicator` tinyint(1) DEFAULT NULL,
  `third_party_payment_recipient_indicator_id` int(11) DEFAULT NULL,
  `third_party_entity_receiving_payment_or_transfer_of_value_id` int(11) DEFAULT NULL,
  `charity_indicator` tinyint(1) DEFAULT NULL,
  `third_party_equals_covered_recipient_indicator` tinyint(1) DEFAULT NULL,
  `contextual_information` text,
  `delay_in_publication_of_general_payment_indicator` tinyint(1) DEFAULT NULL,
  `bio_drug` text,
  `medical_supply` text,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table contains basic transaction infromation\r\n\r\nPrimary key is the unique transaction_id from the exported spreadsheet';

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
