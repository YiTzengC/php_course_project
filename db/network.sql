DROP DATABASE IF EXISTS Yi200437546;
CREATE DATABASE Yi200437546; 
USE Yi200437546; 
CREATE TABLE `accounts` (
    `account_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY (account_id)
);
DROP TABLE skills;
DROP TABLE users;

CREATE TABLE `users` (
  `user_id`   BIGINT UNSIGNED NOT NULL,
  `name`      VARCHAR(100) NOT NULL,
  `email`     VARCHAR(100) NOT NULL,
  `location`  VARCHAR(100) NOT NULL,
  `image`     VARCHAR(40) NOT NULL DEFAULT 'imgs/user.png',
  `social_media` VARCHAR(60) NOT NULL DEFAULT 'view.php', 
  FOREIGN KEY (user_id) REFERENCES accounts(account_id)
); 
CREATE TABLE `skills` (
    `skill_name` VARCHAR (100) NOT NULL,
    `user` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (user, skill_name),
    FOREIGN KEY (user) REFERENCES users(user_id)
);