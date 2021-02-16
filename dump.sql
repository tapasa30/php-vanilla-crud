USE demo;

CREATE TABLE IF NOT EXISTS user
(
    id       int          NOT NULL AUTO_INCREMENT,
    name     varchar(255) NOT NULL,
    email    varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO user(name, email, password) VALUES ("demouser", "demo@user.es", "202cb962ac59075b964b07152d234b70");