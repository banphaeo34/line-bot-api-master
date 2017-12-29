<?php
$Setup_Server = '61.90.186.213';
$Setup_User = 'root';
$Setup_Pwd = '**11305bpi';

$Setup_Database = 'test';

mysql_connect($Setup_Server,$Setup_User,$Setup_Pwd);

mysql_query("use $Setup_Database");
mysql_query("SET NAMES UTF8");

?>
