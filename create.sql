--------------------------- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS forum;

--------------------------- CREATE DATABASE USER
CREATE USER 'forum_user'@'localhost' IDENTIFIED BY 'forumlab1';
GRANT ALL ON forum.* TO 'forum_user'@'localhost';

--------------------------- TABLE DEFINITIONS
-- CREATE USER TABLE
CREATE TABLE IF NOT EXISTS user (
    id INT NOT NULL, 
    username varchar(45) NOT NULL UNIQUE,
    password_hash varchar(350) NOT NULL,
    salt varchar(250) NOT NULl,
    admin BOOLEAN NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id)
);


-- CREATE POST
CREATE TABLE IF NOT EXISTS post (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title varchar(150),
    body TEXT,
    posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);


-- CREATE COMMENT
CREATE TABLE IF NOT EXISTS comment (
    id INT NOT NULL AUTO_INCREMENT,
    post_id INT NOT NULL,
    parent_id INT,
    user_id INT NOT NULL,
    body TEXT,
    
    PRIMARY KEY (id),
    
    FOREIGN KEY (post_id) REFERENCES post(id),
    FOREIGN KEY (parent_id) REFERENCES comment(id),
    FOREIGN KEY (user_id) REFERENCES user(id)
);



--------------------------- STORED PROCEDURES
---------------- USER PROCS 
-- CREATE USER
DELIMITER //
CREATE PROCEDURE `create_user` (IN user_id INT, IN user_username VARCHAR(45), IN user_password_hash VARCHAR(350), IN user_salt VARCHAR(250), IN user_admin BOOLEAN) 
BEGIN 
    INSERT INTO user (id, username, password_hash, salt, admin) VALUES (user_id, user_username, user_password_hash, user_salt, user_admin);
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `get_user_by_username` (IN user_username VARCHAR(45)) 
BEGIN 
    SELECT * FROM user WHERE username = user_username;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `get_user_by_id` (IN user_id INT) 
BEGIN 
    SELECT * FROM user WHERE id = user_id;
END//
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `get_all_users` () 
BEGIN 
    SELECT * FROM user ORDER BY created_at DESC;
END//
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `get_all_users_limit` (IN user_limit INT) 
BEGIN 
    SELECT * FROM user ORDER BY created_at DESC LIMIT user_limit;
END//
DELIMITER ;

-- DELETE USER
DELIMITER //
CREATE PROCEDURE `delete_user` (IN user_id INT) 
BEGIN 
    DELETE FROM user WHERE id = user_id;
END//
DELIMITER ;

-- SET USER PRIVILEGE 
DELIMITER //
CREATE PROCEDURE `set_privilege` (IN id INT, IN priv BIT)
BEGIN
    UPDATE user u SET u.admin = priv 
    WHERE u.id = id;
END//
DELIMITER ;


-- CHANGE USERNAMAE
DELIMITER //
CREATE PROCEDURE `update_username` (IN id INT, IN username VARCHAR(45))
BEGIN
    UPDATE user u SET u.username = username
    WHERE u.id = id;
END//
DELIMITER ;
 

-- CHANGE PASSWORD 
DELIMITER //
CREATE PROCEDURE `update_password` (IN id INT, IN password VARCHAR(350))
    BEGIN 
        UPDATE user u SET u.password_hash = password
        WHERE u.id = id;
    END//
DELIMITER ;


-- DELETE 
DELIMITER //
CREATE PROCEDURE remove_user (IN user_id INT) 
    BEGIN 
        DELETE FROM user WHERE id = user_id; 
    END//
DELIMITER ;

---------------- POST PROCS 
-- CREATE POST 
DELIMITER //
CREATE PROCEDURE `create_post` (IN user_id INT, title varchar(150), body TEXT) 
    BEGIN 
        INSERT INTO post (user_id, title, body) 
        VALUES (user_id, title, body);
    END//
DELIMITER ;


-- EDIT POST 
DELIMITER // 
CREATE PROCEDURE `edit_post` (IN id INT, IN title varchar(150), IN body TEXT)
    BEGIN
        UPDATE post p
        SET p.title = title, 
        p.body = body
        WHERE p.id = id;
    END//
DELIMITER ;


-- DELETE POST
DELIMITER //
CREATE PROCEDURE `delete_post` (IN post_id INT)
    BEGIN 
        DELETE FROM post WHERE id = post_id;
    END//
DELIMITER ;


-- GET ONE 

DELIMITER // 
CREATE PROCEDURE `get_post` (IN arg_post_id INT)
    BEGIN 
        SELECT p.*, u.username,
        ( SELECT COUNT(*) FROM comment WHERE post_id = p.id AND parent_id IS NULL) num_comments
        FROM post p
        INNER JOIN user u 
        ON p.user_id = u.id
        WHERE p.id = arg_post_id;
        
    END//
DELIMITER ;


-- GET ALL
DELIMITER // 
CREATE PROCEDURE `get_posts` ()
    BEGIN 
        SELECT * FROM post;
    END//
DELIMITER ;

-- GET ALL POSTS BY USER
DELIMITER // 
CREATE PROCEDURE `get_posts_user` (IN user_id INT)
    BEGIN 
        SELECT * FROM post p WHERE p.user_id = user_id;
    END//
DELIMITER ;

-- GET ALL POSTS - ORDER NEWEST TO OLDEST 
DELIMITER // 
CREATE PROCEDURE `get_posts_time` ()
    BEGIN 
        SELECT p.*, u.username,
        ( SELECT COUNT(*) FROM comment WHERE post_id = p.id AND parent_id IS NULL) num_comments
        FROM post p
        INNER JOIN user u 
        ON p.user_id = u.id
        ORDER BY p.posted_at DESC;
    END//
DELIMITER ;




-- (MAYBE) GET POST BY SEARCH
 -- TODO
--


---------------- COMMENT PROCS 
-- CREATE COMMENT 
DELIMITER //
CREATE PROCEDURE `create_comment` (IN post_id INT, IN user_id INT, IN body TEXT) 
    BEGIN 
        INSERT INTO comment (post_id, user_id, body)
        VALUES (post_id, user_id, body);
    END//
DELIMITER ;

-- EDIT COMMENT
DELIMITER // 
CREATE PROCEDURE `edit_comment` (IN id INT, IN body TEXT)
    BEGIN
        UPDATE comment c 
        SET c.body = body
        WHERE c.id = id;
    END//
DELIMITER ;

-- DELETE COMMENT 
DELIMITER //

CREATE PROCEDURE `delete_comment` (IN c_id INT)
    BEGIN 
        DELETE FROM comment WHERE id = c_id;
    END//
DELIMITER ;

-- GET ONE
DELIMITER // 
CREATE PROCEDURE `get_comment` (IN id INT)
    BEGIN 
        SELECT * FROM comment c WHERE c.id = id; 
    END//
DELIMITER ;

-- GET ALL PER POST 
DELIMITER // 
CREATE PROCEDURE `get_comments_post` (IN post_id INT)
    BEGIN 
        SELECT c.*, u.username,
        ( SELECT COUNT(*) FROM comment WHERE parent_id = c.id) num_replies
        FROM comment c 
        INNER JOIN user u 
        ON c.user_id = u.id
        WHERE c.post_id = post_id
        AND c.parent_id IS NULL;
    END//
DELIMITER ;

------- COMMENT REPLY PROCS 
-- REPLY TO COMMENT
DELIMITER //
CREATE PROCEDURE `reply_comment` (IN post_id INT, IN parent_id INT, IN user_id INT, IN body TEXT)
    BEGIN 
        INSERT INTO comment (post_id, parent_id, user_id, body)
        VALUES (post_id, parent_id, user_id, body);
    END//
DELIMITER ;


-- GET COMMENT REPLIES
DELIMITER // 
CREATE PROCEDURE `get_comment_replies` (IN comment_id INT)
    BEGIN 
        SELECT c.*, u.username
        FROM comment c 
        INNER JOIN user u
        ON u.id = c.user_id
        WHERE c.parent_id = comment_id; 
    END//
DELIMITER ;




--------------------------- DROPS
DROP table comment;
DROP table post; 
DROP TABLE user;

DROP PROCEDURE create_user;
DROP PROCEDURE get_user_by_username
DROP PROCEDURE create_user;
DROP PROCEDURE set_privilege;
DROP PROCEDURE update_username;
DROP PROCEDURE update_password;
DROP PROCEDURE remove_user;

DROP PROCEDURE create_post;
DROP PROCEDURE edit_post;
DROP PROCEDURE delete_post;
DROP PROCEDURE get_post;
DROP PROCEDURE get_posts;
DROP PROCEDURE get_posts_user;
DROP PROCEDURE get_posts_time;

DROP PROCEDURE create_comment;
DROP PROCEDURE edit_comment;
DROP PROCEDURE delete_comment;
DROP PROCEDURE get_comment;
DROP PROCEDURE get_comment_replies;
DROP PROCEDURE get_comments_post;


----------------------------- TESTING 



