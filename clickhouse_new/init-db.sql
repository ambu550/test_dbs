
create database IF NOT EXISTS test;

CREATE TABLE test.ch_managers
(id Int64, name String, full_name String, email String, created_at Date)
    ENGINE = Log;


CREATE TABLE IF NOT EXISTS test.category ( `id` UInt64, `category_id` UInt64, `category_name` Nullable(String), `category_status` Nullable(UInt16), `category_parent` Nullable(UInt32), `category_path` Nullable(String), `category_path_array` Array(Nullable(UInt32)), `category_level` Nullable(UInt32), `category_sorting` Nullable(UInt32), `category_children` Nullable(UInt32), `category_created` DateTime, `category_updated` Nullable(DateTime), `category_hidden_for_uploader` Nullable(UInt16), `category_name_ua` Nullable(String), `category_access_download` Nullable(UInt8), `partition` UInt8, `ver` DateTime ) ENGINE = MergeTree() PARTITION BY toYYYYMM(category_created)
ORDER BY
id SETTINGS index_granularity = 8192;


--Test data
INSERT INTO test.ch_managers
(id,name,full_name,email,created_at)
VALUES
(1,'test_man','Test test','test@test.com.ua', '2020-09-05');
