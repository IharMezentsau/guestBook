DROP SCHEMA IF EXISTS guest_book;
CREATE SCHEMA guest_book;
USE guest_book;

DROP TABLE IF EXISTS t_user;
CREATE TABLE t_user(
	`id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL UNIQUE,
    `name` VARCHAR(255),
    `familyname` VARCHAR(255),
    `date` DATETIME,
    `admin` BOOLEAN NOT NULL DEFAULT FALSE,
    `avatar` VARCHAR(255),
    `sex` VARCHAR(1)
    
);

DROP TABLE IF EXISTS t_message;
CREATE TABLE t_message (
	`id` INTEGER NOT NULL PRIMARY KEY UNIQUE AUTO_INCREMENT,
    `date` DATETIME NOT NULL,
    `user_id` INTEGER NOT NULL,
    `message` TEXT NOT NULL,
    `rating` INTEGER NOT NULL DEFAULT 0,
    `image` VARCHAR(255),
    
    FOREIGN KEY (user_id) REFERENCES t_user(id) ON UPDATE CASCADE ON DELETE CASCADE
    
);
