CREATE
DATABASE if not exists test;

-- CREATE USER 'alex'@'172.18.0.1' IDENTIFIED BY password  '12345';
-- ALTER USER 'alex'@'172.18.0.1' IDENTIFIED WITH mysql_native_password BY '12345';
-- CREATE USER 'alex'@'172.18.0.1' IDENTIFIED BY password  '12345';
-- GRANT ALL PRIVILEGES ON * .* TO 'alex'@'172.18.0.1';

USE
test;
CREATE TABLE test_1
(
    id        INT(6),
    name      VARCHAR(20),
    full_name VARCHAR(100)
);

INSERT INTO test_1
VALUES (1, 'test1', 'TEST1'),
       (2, 'test2', 'TEST2'),
       (3, 'test3', 'TEST3');