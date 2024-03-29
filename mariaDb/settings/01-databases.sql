-- # create databases
CREATE DATABASE IF NOT EXISTS TEST_SCHEMA;

-- # create RULE_ENGINE user and grant rights
CREATE USER 'TEST_SCHEMA'@'%' IDENTIFIED BY 'password!';
GRANT ALL PRIVILEGES ON *.* TO 'TEST_SCHEMA'@'%';
FLUSH PRIVILEGES;
USE TEST_SCHEMA;
