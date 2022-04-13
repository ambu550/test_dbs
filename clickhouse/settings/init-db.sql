DROP database IF EXISTS test;
create database IF NOT EXISTS test;


CREATE  TABLE IF NOT EXISTS test.logs
(id Int64, log String, full_name String, email String, created_at Date)
    ENGINE = Log;

INSERT INTO test.logs
(id,log,created_at)
VALUES
    (1,'error', '2021-01-01');
INSERT INTO test.logs
(id,log,created_at)
VALUES
    (2,'test', '2021-01-02');


CREATE  TABLE IF NOT EXISTS test.ch_managers
(id Int64, name String, full_name String, email String, created_at Date)
    ENGINE = MergeTree()
    PARTITION BY toYYYYMM(created_at)
    ORDER BY
    id SETTINGS index_granularity = 8192;

TRUNCATE TABLE test.ch_managers;

INSERT INTO test.ch_managers
(id,name,full_name,email,created_at)
VALUES
    (1,'test_man','Test test','test@test.com.ua', '2020-09-05');
ALTER TABLE test.ch_managers COMMENT COLUMN name 'имя менеджера';


CREATE TABLE IF NOT EXISTS test.category
( `id` UInt64 comment 'some id',
`category_id` UInt64,
`category_name` Nullable(String),
    `category_status` Nullable(UInt16),
    `category_parent` Nullable(UInt32),
    `category_path` Nullable(String),
    `category_path_array` Array(Nullable(UInt32)),
    `category_level` Nullable(UInt32),
    `category_sorting` Nullable(UInt32),
    `category_children` Nullable(UInt32),
    `category_created` DateTime,
    `category_updated` Nullable(DateTime),
    `category_hidden_for_uploader` Nullable(UInt16),
    `category_name_ua` Nullable(String),
    `category_access_download` Nullable(UInt8),
    `partition` UInt8,
    `ver` DateTime )
    ENGINE = MergeTree()
    PARTITION BY toYYYYMM(category_created)
ORDER BY
id SETTINGS index_granularity = 8192;

INSERT INTO test.category
(id, category_id, category_name, category_status, category_parent, category_path, category_path_array, category_level, category_sorting, category_children, category_created, category_updated, category_hidden_for_uploader, category_name_ua, category_access_download, `partition`, ver)
VALUES
    (1, 11, 'test_1', 1, 0, '/1', [1], 0, 0, 0, '2020-01-01 10:00:00', '2020-01-01 10:00:00', 0, '', 0, 0, '2020-01-01 10:00:01');
INSERT INTO test.category
(id, category_id, category_name, category_status, category_parent, category_path, category_path_array, category_level, category_sorting, category_children, category_created, category_updated, category_hidden_for_uploader, category_name_ua, category_access_download, `partition`, ver)
VALUES
    (2, 12, 'test_2', 2, 0, '/2', [2,3], 0, 0, 0, '2020-01-02 20:00:00', '2020-01-02 20:00:00', 0, '', 255, 255, '2020-01-02 20:00:02');


DROP database IF EXISTS test2;
CREATE database IF NOT EXISTS test2;


CREATE  TABLE IF NOT EXISTS  test2.drivers
(id Int64,
name String comment 'имя водителя',
created_at Date)
    ENGINE = MergeTree()
    PARTITION BY toYYYYMM(created_at)
    ORDER BY
    id SETTINGS index_granularity = 8192;

INSERT INTO test2.drivers
(id,name,created_at)
VALUES
    (1,'Vasiliy', '2021-01-01');



CREATE TABLE test.string_table
(
    `string_column` Nullable(String)
)
    ENGINE = Log;

CREATE TABLE test.boundary
(
    `id` UInt8
)
    ENGINE = Log;

TRUNCATE TABLE test.boundary;
INSERT INTO test.boundary
(id)
VALUES
    (225);
INSERT INTO test.boundary
(id)
VALUES
    (225);