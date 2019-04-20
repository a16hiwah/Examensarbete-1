# Add CodeIgniter example data
USE codeigniter;

# Add users
INSERT INTO users (username, password, image, biography) VALUES ("user1", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 1");
INSERT INTO users (username, password, image, biography) VALUES ("user2", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 2");
INSERT INTO users (username, password, image, biography) VALUES ("user3", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 3");
INSERT INTO users (username, password, image, biography) VALUES ("user4", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 2, "This is a biography 4");
INSERT INTO users (username, password, image, biography) VALUES ("user5", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 2, NULL);

#Add resources
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (1, "A resource from user 1", CONCAT("a-resource-from-user-1-", UNIX_TIMESTAMP(), "-1"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (1, "Another resource from user 1", CONCAT("another-resource-from-user-1-", UNIX_TIMESTAMP(), "-1"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (2, "A resource from user 2", CONCAT("a-resource-from-user-2-", UNIX_TIMESTAMP(), "-2"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (2, "Another resource from user 2", CONCAT("another-resource-from-user-2-", UNIX_TIMESTAMP(), "-2"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (3, "A resource from user 3", CONCAT("a-resource-from-user-3-", UNIX_TIMESTAMP(), "-3"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (3, "Another resource from user 3", CONCAT("another-resource-from-user-3-", UNIX_TIMESTAMP(), "-3"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (4, "A resource from user 4", CONCAT("a-resource-from-user-4-", UNIX_TIMESTAMP(), "-4"), "This is the description", "This is the body of the resource", 0);
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments) VALUES (4, "Another resource from user 4", CONCAT("another-resource-from-user-4-", UNIX_TIMESTAMP(), "-4"), "This is the description", "This is the body of the resource", 0);

#Add comments
INSERT INTO comments (user_id, resource_id, body) VALUES (1, 1, "A comment from user 1");
INSERT INTO comments (user_id, resource_id, body) VALUES (2, 1, "A comment from user 2");
INSERT INTO comments (user_id, resource_id, body) VALUES (3, 1, "A comment from user 3");
INSERT INTO comments (user_id, resource_id, body) VALUES (4, 1, "A comment from user 4");
INSERT INTO comments (user_id, resource_id, body) VALUES (5, 1, "A comment from user 5");
UPDATE resources SET num_of_comments = 5 WHERE id = 1;
INSERT INTO comments (user_id, resource_id, body) VALUES (1, 2, "A comment from user 1");
INSERT INTO comments (user_id, resource_id, body) VALUES (2, 2, "A comment from user 2");
INSERT INTO comments (user_id, resource_id, body) VALUES (3, 2, "A comment from user 3");
INSERT INTO comments (user_id, resource_id, body) VALUES (4, 2, "A comment from user 4");
INSERT INTO comments (user_id, resource_id, body) VALUES (5, 2, "A comment from user 5");
UPDATE resources SET num_of_comments = 5 WHERE id = 2;

# Add CakePHP example data
USE cakephp;

# Add users
INSERT INTO users (username, password, profile_image_id, biography, created) VALUES ("user1", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 1", NOW());
INSERT INTO users (username, password, profile_image_id, biography, created) VALUES ("user2", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 2", NOW());
INSERT INTO users (username, password, profile_image_id, biography, created) VALUES ("user3", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 1, "This is a biography 3", NOW());
INSERT INTO users (username, password, profile_image_id, biography, created) VALUES ("user4", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 2, "This is a biography 4", NOW());
INSERT INTO users (username, password, profile_image_id, biography, created) VALUES ("user5", "$2y$10$Q8Hq6JZyP0uneUnnT1WWg.YTeSIFGyLS8xezNPn9/g6OwuP6lV6QW", 2, NULL, NOW());

#Add resources
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (1, "A resource from user 1", CONCAT("a-resource-from-user-1-", UNIX_TIMESTAMP(), "-1"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (1, "Another resource from user 1", CONCAT("another-resource-from-user-1-", UNIX_TIMESTAMP(), "-1"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (2, "A resource from user 2", CONCAT("a-resource-from-user-2-", UNIX_TIMESTAMP(), "-2"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (2, "Another resource from user 2", CONCAT("another-resource-from-user-2-", UNIX_TIMESTAMP(), "-2"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (3, "A resource from user 3", CONCAT("a-resource-from-user-3-", UNIX_TIMESTAMP(), "-3"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (3, "Another resource from user 3", CONCAT("another-resource-from-user-3-", UNIX_TIMESTAMP(), "-3"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (4, "A resource from user 4", CONCAT("a-resource-from-user-4-", UNIX_TIMESTAMP(), "-4"), "This is the description", "This is the body of the resource", 0, NOW());
INSERT INTO resources (user_id, title, slug, description, body, num_of_comments, created) VALUES (4, "Another resource from user 4", CONCAT("another-resource-from-user-4-", UNIX_TIMESTAMP(), "-4"), "This is the description", "This is the body of the resource", 0, NOW());

#Add comments
INSERT INTO comments (user_id, resource_id, body, created) VALUES (1, 1, "A comment from user 1", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (2, 1, "A comment from user 2", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (3, 1, "A comment from user 3", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (4, 1, "A comment from user 4", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (5, 1, "A comment from user 5", NOW());
UPDATE resources SET num_of_comments = 5 WHERE id = 1;
INSERT INTO comments (user_id, resource_id, body, created) VALUES (1, 2, "A comment from user 1", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (2, 2, "A comment from user 2", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (3, 2, "A comment from user 3", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (4, 2, "A comment from user 4", NOW());
INSERT INTO comments (user_id, resource_id, body, created) VALUES (5, 2, "A comment from user 5", NOW());
UPDATE resources SET num_of_comments = 5 WHERE id = 2;
