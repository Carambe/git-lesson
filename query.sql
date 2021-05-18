CREATE TABLE comments
(
    id INT(11) auto_increment PRIMARY KEY,
    first_name VARCHAR (256) NOT NULL,
    last_name VARCHAR (256) NOT NULL,
    email VARCHAR(256) NOT NULL,
    phone BIGINT(12) NOT NULL,
    type CHAR (1) NOT NULL,
    comment VARCHAR (256)
);

CREATE TABLE files
(
    id INT(11) auto_increment PRIMARY KEY,
    file_path VARCHAR (256) NOT NULL
);

CREATE TABLE comments_files
(
    id INT(11) auto_increment PRIMARY KEY,
    id_comment INT(11) NOT NULL,
    id_file INT(11) NOT NULL
);
