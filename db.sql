DROP DATABASE IF EXISTS form_model;

CREATE DATABASE form_model;

use form_model;

CREATE TABLE user (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(100),
    password VARCHAR(255),
    username VARCHAR(100),
    UNIQUE KEY (username),
    UNIQUE KEY (email),
    PRIMARY KEY (id)
) ;

INSERT INTO user (email, password, username) VALUES(
    'user1@gmail.com', '', 'username1'),
    ('unknownUser1', '', 'unknownUser1'),
    ('unknownUser2', '', 'unknownUser2');

CREATE TABLE form (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT, 
    name VARCHAR(100),
    state BOOL,
    background VARCHAR(10),
    police VARCHAR(30),
    police_color VARCHAR(10),
    police_size INT,
    style BOOL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    PRIMARY KEY (id)
) ;

INSERT INTO form (user_id, name, state, background, police, police_color, police_size, style) VALUES ('1', 'formtestmusique', '1', '#F0E68C', 'trebuchet', '#A52A2A', '22', '1');

CREATE TABLE tool_input (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    PRIMARY KEY (id)
) ;

INSERT INTO tool_input (name) VALUES ('text'), ('checkbox'), ('radio'), ('range'), ('date');


CREATE TABLE tool_form (
    id INT NOT NULL AUTO_INCREMENT,
    form_id INT,
    tool_input_id INT,
    order_tool INT,
    label VARCHAR(100),
    FOREIGN KEY (form_id) REFERENCES form(id),
    FOREIGN KEY (tool_input_id) REFERENCES tool_input(id),
    PRIMARY KEY (id)
) ;

INSERT INTO tool_form 
    (form_id, tool_input_id, order_tool, label)
    VALUES
    (1, 1, 1, 'votre nom'),
    (1, 1, 2, 'votre prénom'),
    (1, 3, 3, 'votre style de musique préféré'),
    (1, 2, 4, 'les styles de musique que vous écoutez'),
    (1, 4, 5, 'Notez Chopin de 1 à 100');

CREATE TABLE choice (
   id INT NOT NULL AUTO_INCREMENT,
   tool_form_id INT,
   tool_option VARCHAR(255),
   choice_order INT,
   FOREIGN KEY (tool_form_id) REFERENCES tool_form(id),
   PRIMARY KEY (id)
) ;

INSERT INTO choice (tool_form_id, tool_option, choice_order)
    VALUES 
        (3, 'classique', 1),
        (3, 'hard', 2),
        (3, 'pop', 3),
        (3, 'rock', 4),
        (3, 'rap', 5),
        (4, 'classique', 1),
        (4, 'hard', 2),
        (4, 'pop', 3),
        (4, 'rock', 4),
        (4, 'rap', 5),
        (5, '1', 1),
        (5, '100', 2),
        (5, '1', 3);

CREATE TABLE response_session (
    id INT NOT NULL AUTO_INCREMENT,
    tool_form_id INT,
    user_id INT,
    FOREIGN KEY (tool_form_id) REFERENCES tool_form(id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    PRIMARY KEY (id)
) ;

INSERT INTO response_session
    (tool_form_id, user_id) VALUES (1, 2), (2, 2), (3, 2), (4, 2), (5, 2), (1, 3), (2, 3), (3, 3), (4, 3), (5, 3);

CREATE TABLE completed_form (
    id INT NOT NULL AUTO_INCREMENT,
    response_session_id INT,
    value VARCHAR(100), 
    FOREIGN KEY (response_session_id) REFERENCES response_session(id),
    PRIMARY KEY (id)
) ;

INSERT INTO completed_form 
    (response_session_id, value)
    VALUES
        (1, 'Legrand'),
        (2, 'Louis'),
        (3, 'classique'),
        (4, 'classique'),
        (4, 'hard'),
        (5, '99'),
        (6, 'Chavez'),
        (7, 'Hugo'),
        (8, 'classique'),
        (9, 'classique'),
        (9, 'hard'),
        (9, 'pop'),
        (9, 'rock'),
        (9, 'rap'),
        (10, '50');



DELIMITER //
DROP PROCEDURE IF EXISTS create_new_user;

CREATE PROCEDURE create_new_user(OUT last_id INT)
BEGIN
    DECLARE myname CHAR(100);
    DECLARE email CHAR(100);
    SET @last_id = 0;
    SELECT id INTO @last_id FROM user ORDER BY id DESC LIMIT 1;
    SET @myname = CONCAT('unknown', CAST(@last_id as CHAR));
    SET @email = @myname;
    
    PREPARE stmt FROM 'INSERT INTO user (email, password, username) VALUES( ?, "", ?)';
    EXECUTE stmt USING @myname, @email;
    DEALLOCATE PREPARE stmt;  
    SELECT id INTO @last_id FROM user ORDER BY id DESC LIMIT 1;
    set last_id = @last_id;
END //
DELIMITER ;

SELECT * FROM tool_form 
JOIN form ON tool_form.form_id = form.id;

SELECT tool_form.label, completed_form.value
    FROM completed_form
    JOIN response_session ON completed_form.response_session_id = response_session.id
    JOIN tool_form ON tool_form.id = response_session.tool_form_id;

SELECT count(completed_form.value), completed_form.value 
    FROM completed_form
    JOIN response_session ON completed_form.response_session_id = response_session.id
    JOIN tool_form ON tool_form.id = response_session.tool_form_id
    WHERE tool_form.label = 'votre style de musique préféré'
    GROUP BY completed_form.value;
 


SELECT label from tool_form where form_id = 1;

SELECT  user_id, COUNT(user_id) FROM response_session GROUP BY user_id;

SELECT  COUNT(DISTINCT user_id) as nb_completed_forms FROM response_session; 