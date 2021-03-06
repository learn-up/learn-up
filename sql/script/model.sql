-- MySQL Script generated by MySQL Workbench
-- 02/20/16 10:49:16
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema final
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `final` ;

-- -----------------------------------------------------
-- Schema final
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `final` DEFAULT CHARACTER SET utf8 ;
USE `final` ;

-- -----------------------------------------------------
-- Table `final`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`users` ;

CREATE TABLE IF NOT EXISTS `final`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `acess_level` TINYINT(4) NOT NULL DEFAULT 0,
  `email` VARCHAR(45) NOT NULL,
  `first_name` VARCHAR(60) NOT NULL,
  `last_name` VARCHAR(40) NOT NULL,
  `phone` VARCHAR(12) NULL,
  `singin_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`subjects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`subjects` ;

CREATE TABLE IF NOT EXISTS `final`.`subjects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `tag` VARCHAR(25) NOT NULL,
  `description` VARCHAR(120) NOT NULL,
  `level` TINYINT(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`courses` ;

CREATE TABLE IF NOT EXISTS `final`.`courses` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `subject_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_courses_subjects1_idx` (`subject_id` ASC),
  CONSTRAINT `fk_courses_subjects1`
    FOREIGN KEY (`subject_id`)
    REFERENCES `final`.`subjects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`classes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`classes` ;

CREATE TABLE IF NOT EXISTS `final`.`classes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(60) NOT NULL,
  `duration` TINYINT ZEROFILL UNSIGNED NOT NULL,
  `difficulty` TINYINT ZEROFILL NOT NULL,
  `description` VARCHAR(120) NOT NULL,
  `post_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `course_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_classes_courses1_idx` (`course_id` ASC),
  CONSTRAINT `fk_classes_courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `final`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`classes_history`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`classes_history` ;

CREATE TABLE IF NOT EXISTS `final`.`classes_history` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_page` TINYINT ZEROFILL UNSIGNED NOT NULL,
  `classe_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_classes_history_classes1_idx` (`classe_id` ASC),
  INDEX `fk_classes_history_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_classes_history_classes1`
    FOREIGN KEY (`classe_id`)
    REFERENCES `final`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_classes_history_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `final`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`classes_pages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`classes_pages` ;

CREATE TABLE IF NOT EXISTS `final`.`classes_pages` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order` TINYINT ZEROFILL NOT NULL,
  `title` VARCHAR(20) NOT NULL DEFAULT 'No title',
  `content` MEDIUMTEXT NOT NULL,
  `classe_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_classes_pages_classes1_idx` (`classe_id` ASC),
  CONSTRAINT `fk_classes_pages_classes1`
    FOREIGN KEY (`classe_id`)
    REFERENCES `final`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`exercise_lists`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`exercise_lists` ;

CREATE TABLE IF NOT EXISTS `final`.`exercise_lists` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL DEFAULT 'No name',
  `description` VARCHAR(60) NOT NULL DEFAULT 'No description',
  `difficulty` TINYINT UNSIGNED ZEROFILL NOT NULL,
  `subject_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_exercise_lists_subjects_idx` (`subject_id` ASC),
  INDEX `fk_exercise_lists_courses1_idx` (`course_id` ASC),
  CONSTRAINT `fk_exercise_lists_subjects`
    FOREIGN KEY (`subject_id`)
    REFERENCES `final`.`subjects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_exercise_lists_courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `final`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`exercises`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`exercises` ;

CREATE TABLE IF NOT EXISTS `final`.`exercises` (
  `id` INT UNSIGNED NOT NULL,
  `content` MEDIUMTEXT NOT NULL,
  `difficulty` FLOAT NOT NULL DEFAULT 1,
  `exercise_list_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_exercises_exercise_lists1_idx` (`exercise_list_id` ASC),
  CONSTRAINT `fk_exercises_exercise_lists1`
    FOREIGN KEY (`exercise_list_id`)
    REFERENCES `final`.`exercise_lists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`completed_exercise_lists`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`completed_exercise_lists` ;

CREATE TABLE IF NOT EXISTS `final`.`completed_exercise_lists` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `corrects` FLOAT ZEROFILL NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT UNSIGNED NOT NULL,
  `exercise_list_id` INT UNSIGNED NOT NULL,
  `result` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_completed_exercise_lists_users1_idx` (`user_id` ASC),
  INDEX `fk_completed_exercise_lists_exercise_lists1_idx` (`exercise_list_id` ASC),
  CONSTRAINT `fk_completed_exercise_lists_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `final`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_completed_exercise_lists_exercise_lists1`
    FOREIGN KEY (`exercise_list_id`)
    REFERENCES `final`.`exercise_lists` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`exercise_options`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`exercise_options` ;

CREATE TABLE IF NOT EXISTS `final`.`exercise_options` (
  `id` INT NOT NULL,
  `content` MEDIUMTEXT NOT NULL,
  `exercise_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_exercise_options_exercises1_idx` (`exercise_id` ASC),
  CONSTRAINT `fk_exercise_options_exercises1`
    FOREIGN KEY (`exercise_id`)
    REFERENCES `final`.`exercises` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`courses_completed`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`courses_completed` ;

CREATE TABLE IF NOT EXISTS `final`.`courses_completed` (
  `users_id` INT UNSIGNED NOT NULL,
  `courses_id` INT UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`users_id`, `courses_id`),
  INDEX `fk_users_has_courses_courses1_idx` (`courses_id` ASC),
  INDEX `fk_users_has_courses_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_courses_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `final`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_courses_courses1`
    FOREIGN KEY (`courses_id`)
    REFERENCES `final`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`subjects_by_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`subjects_by_user` ;

CREATE TABLE IF NOT EXISTS `final`.`subjects_by_user` (
  `subjects_id` INT UNSIGNED NOT NULL,
  `users_id` INT UNSIGNED NOT NULL,
  `progress` FLOAT ZEROFILL NOT NULL,
  PRIMARY KEY (`subjects_id`, `users_id`),
  INDEX `fk_subjects_has_users_users1_idx` (`users_id` ASC),
  INDEX `fk_subjects_has_users_subjects1_idx` (`subjects_id` ASC),
  CONSTRAINT `fk_subjects_has_users_subjects1`
    FOREIGN KEY (`subjects_id`)
    REFERENCES `final`.`subjects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_subjects_has_users_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `final`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`tests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`tests` ;

CREATE TABLE IF NOT EXISTS `final`.`tests` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `description` VARCHAR(120) NOT NULL,
  `simulated` TINYINT(1) NOT NULL DEFAULT 0,
  `subject_id` INT UNSIGNED NOT NULL,
  `course_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tests_subjects1_idx` (`subject_id` ASC),
  INDEX `fk_tests_courses1_idx` (`course_id` ASC),
  CONSTRAINT `fk_tests_subjects1`
    FOREIGN KEY (`subject_id`)
    REFERENCES `final`.`subjects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tests_courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `final`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`test_questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`test_questions` ;

CREATE TABLE IF NOT EXISTS `final`.`test_questions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` MEDIUMTEXT NOT NULL,
  `difficulty` FLOAT NOT NULL,
  `test_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_test_questions_tests1_idx` (`test_id` ASC),
  CONSTRAINT `fk_test_questions_tests1`
    FOREIGN KEY (`test_id`)
    REFERENCES `final`.`tests` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`test_question_options`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`test_question_options` ;

CREATE TABLE IF NOT EXISTS `final`.`test_question_options` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` MEDIUMTEXT NOT NULL,
  `test_question_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_test_question_options_test_questions1_idx` (`test_question_id` ASC),
  CONSTRAINT `fk_test_question_options_test_questions1`
    FOREIGN KEY (`test_question_id`)
    REFERENCES `final`.`test_questions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`completed_tests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`completed_tests` ;

CREATE TABLE IF NOT EXISTS `final`.`completed_tests` (
  `tests_id` INT UNSIGNED NOT NULL,
  `users_id` INT UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL,
  `correct_amount` TINYINT UNSIGNED ZEROFILL NOT NULL,
  `total_amount` TINYINT UNSIGNED NOT NULL,
  `result` MEDIUMTEXT NOT NULL,
  PRIMARY KEY (`tests_id`, `users_id`),
  INDEX `fk_tests_has_users_users1_idx` (`users_id` ASC),
  INDEX `fk_tests_has_users_tests1_idx` (`tests_id` ASC),
  CONSTRAINT `fk_tests_has_users_tests1`
    FOREIGN KEY (`tests_id`)
    REFERENCES `final`.`tests` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tests_has_users_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `final`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `final`.`related_classes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `final`.`related_classes` ;

CREATE TABLE IF NOT EXISTS `final`.`related_classes` (
  `classeA` INT UNSIGNED NOT NULL,
  `classeB` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`classeA`, `classeB`),
  INDEX `fk_classes_has_classes_classes2_idx` (`classeB` ASC),
  INDEX `fk_classes_has_classes_classes1_idx` (`classeA` ASC),
  CONSTRAINT `fk_classes_has_classes_classes1`
    FOREIGN KEY (`classeA`)
    REFERENCES `final`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_classes_has_classes_classes2`
    FOREIGN KEY (`classeB`)
    REFERENCES `final`.`classes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
