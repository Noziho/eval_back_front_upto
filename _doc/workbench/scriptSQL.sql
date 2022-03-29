-- MySQL Script generated by MySQL Workbench
-- Sat Mar  5 18:14:16 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema eval-back-front
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema eval-back-front
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eval-back-front` DEFAULT CHARACTER SET utf8 ;
USE `eval-back-front` ;

-- -----------------------------------------------------
-- Table `eval-back-front`.`ndmp22_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eval-back-front`.`ndmp22_role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eval-back-front`.`ndmp22_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eval-back-front`.`ndmp22_user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(75) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role_fk` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_ndmp22_user_ndmp22_role1_idx` (`role_fk` ASC),
  CONSTRAINT `fk_ndmp22_user_ndmp22_role1`
    FOREIGN KEY (`role_fk`)
    REFERENCES `eval-back-front`.`ndmp22_role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eval-back-front`.`ndmp22_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eval-back-front`.`ndmp22_article` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `content` TEXT NOT NULL,
  `user_fk` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_ndmp22_article_ndmp22_user1_idx` (`user_fk` ASC),
  CONSTRAINT `fk_ndmp22_article_ndmp22_user1`
    FOREIGN KEY (`user_fk`)
    REFERENCES `eval-back-front`.`ndmp22_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eval-back-front`.`ndmp22_commentaire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eval-back-front`.`ndmp22_commentaire` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  `ndmp22_user_id` INT UNSIGNED NOT NULL,
  `ndmp22_article_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_ndmp22_commentaire_ndmp22_user1_idx` (`ndmp22_user_id` ASC),
  INDEX `fk_ndmp22_commentaire_ndmp22_article1_idx` (`ndmp22_article_id` ASC),
  CONSTRAINT `fk_ndmp22_commentaire_ndmp22_user1`
    FOREIGN KEY (`ndmp22_user_id`)
    REFERENCES `eval-back-front`.`ndmp22_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ndmp22_commentaire_ndmp22_article1`
    FOREIGN KEY (`ndmp22_article_id`)
    REFERENCES `eval-back-front`.`ndmp22_article` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;