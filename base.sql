SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `adl` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `adl`;


-- -----------------------------------------------------
-- Table `adl`.`states`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adl`.`states` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content_state` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `adl`.`types`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adl`.`types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content_type` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `adl`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adl`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
`email` VARCHAR(45) NOT NULL ,
`pw` VARCHAR(45) NOT NULL ,
`register_date` DATE NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `adl`.`requests`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adl`.`requests` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content_request` VARCHAR(240) NOT NULL ,
  `email` VARCHAR(45) NULL ,
  `date` DATE NULL ,
  `state_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `requests_id1` (`state_id` ASC) ,
  INDEX `requests_id2` (`user_id` ASC) ,
  CONSTRAINT `requests_id1`
	FOREIGN KEY (`state_id` )
	REFERENCES `adl`.`states` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
  CONSTRAINT `requests_id2` 
	FOREIGN KEY (`user_id` )
	REFERENCES `adl`.`users` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `adl`.`replies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `adl`.`replies` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content_reply` VARCHAR(240) NOT NULL ,
  `type_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `replies_id1` (`type_id` ASC) ,
  CONSTRAINT `replies_id1` 
	FOREIGN KEY (`type_id` )
	REFERENCES `adl`.`types` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION)
ENGINE = InnoDB;




SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
