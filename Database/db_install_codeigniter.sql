#DROP DATABASE IF EXISTS codeigniter;

CREATE DATABASE IF NOT EXISTS codeigniter;
USE codeigniter;

CREATE TABLE users (
	id INT AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    biography VARCHAR(255),
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY(id),
	UNIQUE KEY (username)
) CHARSET=utf8mb4;

CREATE TABLE resources (
    id INT AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL,
    description VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY(id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY (slug)
) CHARSET=utf8mb4;

CREATE TABLE collections (
    id INT AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL,
    description VARCHAR(255) NOT NULL,
    body TEXT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY(id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY (slug)
) CHARSET=utf8mb4;

CREATE TABLE collections_resources (
    collection_id INT,
    resource_id INT,
    PRIMARY KEY(collection_id, resource_id),
    FOREIGN KEY (collection_id) REFERENCES collections(id),
    FOREIGN KEY (resource_id) REFERENCES resources(id)
) CHARSET=utf8mb4;

CREATE TABLE comments (
    id INT AUTO_INCREMENT,
    user_id INT,
    resource_id INT,
    body VARCHAR(2000) NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY(id, user_id, resource_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (resource_id) REFERENCES resources(id)
) CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `ci_sessions` (
	`id` varchar(128) NOT NULL,
	`ip_address` varchar(45) NOT NULL,
	`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
	`data` blob NOT NULL,
	KEY `ci_sessions_timestamp` (`timestamp`)
);

#When sess_match_ip = TRUE
#ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address);

#When sess_match_ip = FALSE
ALTER TABLE ci_sessions ADD PRIMARY KEY (id);

#To drop a previously created primary key (use when changing the setting)
#ALTER TABLE ci_sessions DROP PRIMARY KEY;

