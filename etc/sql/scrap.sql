select version();

-- Database: dstawebbuild1

-- DROP DATABASE IF EXISTS dstawebbuild1;

CREATE DATABASE dstawebbuild1
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'English_United Kingdom.1252'
    LC_CTYPE = 'English_United Kingdom.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;


CREATE TABLE login_user (
    id int NOT NULL,
    name varchar(60) NOT NULL,
    user_name varchar(20) NOT NULL,
    password varchar(20) NOT NULL
    );


