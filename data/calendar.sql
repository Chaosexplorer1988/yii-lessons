

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`clndr_calendar`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`clndr_calendar` ;

CREATE TABLE `clndr_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET latin1 NOT NULL,
  `creator` int(11) NOT NULL,
  `date_event` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evrnt_note_1_idx` (`creator`),
  CONSTRAINT `fk_evrnt_note_1` FOREIGN KEY (`creator`) REFERENCES `table_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
