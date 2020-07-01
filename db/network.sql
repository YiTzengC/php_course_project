CREATE DATABASE Network_Connection; 
USE Network_Connection; 
CREATE TABLE `users` (
  `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR (100) NOT NULL,
  `location` VARCHAR (100) NOT NULL,
  PRIMARY KEY (user_id)
); 
CREATE TABLE `skills` (
    `skill_name` VARCHAR (100) NOT NULL,
    `owner` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (owner, skill_name),
    FOREIGN KEY (owner) REFERENCES users(user_id)
);