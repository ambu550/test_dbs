<?php

echo '<a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/clickhouse_check.php'.'>проверка базы Кликхауиса</a>';
echo "<p></p>";
echo '<a href='.'http://'.$_SERVER['HTTP_HOST'].'/checks/postgresql_check.php'.'>проверка базы Постгрес</a>';
echo phpinfo();