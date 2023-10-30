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

INSERT INTO user (email, password, username) VALUES('user1@gmail.com', '', 'username1');

CREATE TABLE form (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT, 
    name VARCHAR(100),
    state BOOL,
    FOREIGN KEY (user_id) REFERENCES user(id),
    PRIMARY KEY (id)
) ;

INSERT INTO form (user_id, name, state) VALUES ('1', 'formtestmusique', '1');

CREATE TABLE tool_input (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    PRIMARY KEY (id)
) ;

INSERT INTO tool_input (name) VALUES ('text'), ('checkbox'), ('list'), ('range'), ('date');


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
    (1, 2, 4, 'les styles de musique que vous écoutez');

CREATE TABLE choice (
   id INT NOT NULL AUTO_INCREMENT,
   tool_form_id INT,
   tool_option VARCHAR(255),
   FOREIGN KEY (tool_form_id) REFERENCES tool_form(id),
   PRIMARY KEY (id)
) ;

INSERT INTO choice (tool_form_id, tool_option)
    VALUES 
        (3, 'classique'),
        (3, 'hard'),
        (3, 'pop'),
        (3, 'rock'),
        (3, 'rap'),
        (4, 'classique'),
        (4, 'hard'),
        (4, 'pop'),
        (4, 'rock'),
        (4, 'rap');

CREATE TABLE response_session (
    id INT NOT NULL AUTO_INCREMENT,
    tool_form_id INT,
    user_id INT,
    FOREIGN KEY (tool_form_id) REFERENCES tool_form(id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    PRIMARY KEY (id)
) ;

INSERT INTO response_session
    (tool_form_id) VALUES (1), (2), (3), (4), (1), (2), (3), (4);

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
        (1, 'Chavez'),
        (2, 'Hugo'),
        (3, 'classique'),
        (4, 'classique'),
        (4, 'hard'),
        (4, 'pop'),
        (4, 'rock'),
        (4, 'rap');


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

SELECT completed_form.value, tool_form.label
FROM completed_form
JOIN response_session ON response_session.id = completed_form.response_session_id
JOIN tool_form ON response_session.tool_form_id = tool_form.id
GROUP BY tool_form.label;

SELECT label from tool_form where form_id = 1;