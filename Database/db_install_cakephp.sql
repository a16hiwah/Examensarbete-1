#DROP DATABASE IF EXISTS cakephp;

CREATE DATABASE IF NOT EXISTS cakephp;
USE cakephp;

CREATE TABLE profile_images (
    id INT AUTO_INCREMENT,
    img_name VARCHAR(255) NOT NULL,
    img_src varchar(400) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO profile_images (img_name, img_src) VALUES ('Solid green', 'http://localhost/Examensarbete/App/CakePHP/webroot/img/profile_images/solid_green.png');
INSERT INTO profile_images (img_name, img_src) VALUES ('Solid blue', 'http://localhost/Examensarbete/App/CakePHP/webroot/img/profile_images/solid_blue.png');

CREATE TABLE users (
	id INT AUTO_INCREMENT,
    username VARCHAR(64) NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image_id INT NOT NULL,
    biography VARCHAR(255),
    created DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (profile_image_id) REFERENCES profile_images(id),
	UNIQUE KEY (username)
) CHARSET=utf8mb4;

CREATE TABLE resources (
    id INT AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL,
    description VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    num_of_comments INT NOT NULL,
    created DATETIME,
    PRIMARY KEY (id, user_id),
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
    created DATETIME,
    PRIMARY KEY (id, user_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    UNIQUE KEY (slug)
) CHARSET=utf8mb4;

CREATE TABLE collections_resources (
    collection_id INT,
    resource_id INT,
    PRIMARY KEY (collection_id, resource_id),
    FOREIGN KEY (collection_id) REFERENCES collections(id),
    FOREIGN KEY (resource_id) REFERENCES resources(id)
) CHARSET=utf8mb4;

CREATE TABLE comments (
    id INT AUTO_INCREMENT,
    user_id INT,
    resource_id INT,
    body VARCHAR(2000) NOT NULL,
    created DATETIME,
    PRIMARY KEY (id, user_id, resource_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (resource_id) REFERENCES resources(id)
) CHARSET=utf8mb4;
