<?php
session_start();

if(!file_exists("installed")){
	header("Location: install.php");
	die("You are not install system!");
}

if(!isset($_SESSION["login"]) or $_SESSION["login"]==false){
if(isset($_POST["act"]) and $_POST["act"]=="login"){
	$connect = @mysql_connect(htmlspecialchars($_POST["host"]),htmlspecialchars($_POST["user"]),htmlspecialchars($_POST["pass"]));

	if($_SESSION["tks"]==$_POST["tks"]){
	if($connect){
		$error = array("msg"=>"เข้าสู่ระบบสำเร็จ","color"=>"green","class"=>"alert alert-success","icon"=>"glyphicon glyphicon-ok-sign");
		header("Location: index.php");
		$_SESSION["login"]=true;
		$_SESSION["host"]=htmlspecialchars($_POST["host"]);
		$_SESSION["user"]=htmlspecialchars($_POST["user"]);
		$_SESSION["pass"]=htmlspecialchars($_POST["pass"]);
	} else{
		$error = array("msg"=>"ไม่สามารถเชื่อมต่อได้","color"=>"red","class"=>"alert alert-danger","icon"=>"glyphicon glyphicon-exclamation-sign");
	}
	} else{
		$error = array("msg"=>"Access Token ผิดพลาด","color"=>"red","class"=>"alert alert-danger","icon"=>"glyphicon glyphicon-exclamation-sign");
	}

}
}

if(!$_POST){
$_SESSION["tks"]=rand(1111111111,9999999999);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MiNi Database | Powered by Aom Siriwat</title>

<link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="public/css/bootstrap.css" type="text/css" media="screen">
<link href="public/css/fonts.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="public/css/style.css" type="text/css">
<link rel="stylesheet" href="public/css/normalize.css" type="text/css">
<link rel="stylesheet" href="public/css/docs.css" type="text/css">
<link rel="stylesheet" href="public/css/docs.min.css" type="text/css">

<script type="text/javascript" src="public/js/jquery.min.js"></script>

<style>
body{
	background-color: #CCCCCC;
	margin-top: 50px;
}
.content{
	max-width: 950px;
	margin:0px;
	border-radius: 5px;
	-webkit-border-radius:5px;
	-moz-border-radius:   5px;
	background-color: #FFF;
	border:  1px #000;
	padding-left: 15px;
	padding-top:  20px;
	padding-bottom: 20px;
	padding-right: 15px;
	border-style: solid;
	box-shadow: 5px 5px 10px #888888;
}
td {
overflow-x: hidden;
overflow-y: hidden;
white-space: nowrap;
max-width: 180px;
}
</style>

</head>

<body>

<div align="center" class="container-fluid">
<div class="content" align="left">

<?php
if(!isset($_SESSION["login"]) or $_SESSION["login"]==false){
?>
<form method="post" class="form-horizontal" action>
<h3>LOGIN with DATABASE Account</h3><hr />
<?php
if(isset($error) and is_array($error)){
echo "<div align='center' class='".$error['class']."' style='color:".$error["color"]."'><b class='".$error["icon"]."'></b> ".$error["msg"]."</div><br />";
}
?>
<input type="hidden" name="act" value="login" />
<input type="hidden" name="tks" value="<?php echo $_SESSION['tks']; ?>" />

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">HOST : </label>
    <div class="col-sm-10">
      <input type="text" name="host" class="form-control" placeholder="Database Host" autocomplete="off" value="localhost" />
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Username : </label>
    <div class="col-sm-10">
      <input type="text" name="user" class="form-control" placeholder="Database Username" autocomplete="off" />
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Password : </label>
    <div class="col-sm-10">
      <input type="password" name="pass" class="form-control" placeholder="Database Password" autocomplete="off" />
    </div>
  </div>

<hr />

<div align="center">
<input class="btn btn-success" type="submit" value="เชื่อมต่อฐานข้อมูล : Connect" />
</div>

</form>
<?php
} else{

if(isset($_GET["logout"]) and $_GET['logout']==$_SESSION['user']){
session_destroy();
echo '<script>window.location="index.php";</script>';
}

if(!isset($_SESSION["db"])){
if(isset($_POST["act"]) and $_POST["act"]=="db_select"){
$con = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
$sel = mysql_select_db(htmlspecialchars($_POST["db"]));

if($con && $sel){
echo '<script>window.location="index.php";</script>';
$_SESSION["db"]=$_POST["db"];
} else{
	$error = array("msg"=>"ไม่พบฐานข้อมูล","class"=>"alert alert-danger","icon"=>"glyphicon glyphicon-exclamation-sign");
}

}


?>
<form method="post" class="form-horizontal" action>
<h3>เลือกฐานข้อมูล : Select Database</h3><hr />
<?php
if(isset($error)){
echo '<div align="center" class="'.$error['class'].'" style="color:red"><b class="'.$error["icon"].'"></b> '.$error["msg"].'</div>';
}
?>
<input type="hidden" name="act" value="db_select" />

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Database : </label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="db" autocomplete="off" placeholder="Database Name" />
    </div>
  </div>

<div align="center">
<input type="submit" class="btn btn-success" value="เลือกฐานข้อมูล : Select Database" />
</div>

</form>
<?php
} else{
	//MANAGER
	echo '<div align="center">[ HOST : <strong>'.$_SESSION["host"].'</strong> | USER : <strong>'.$_SESSION["user"].'</strong> | PASS : <strong>'.$_SESSION["pass"].'</strong> | DATABASE NAME : <strong>'.$_SESSION["db"].'</strong> ]</div><hr />';
	?>

<style>
table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
</style>

<?php

if(!$_GET){

/* connect to the db */
$connection = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connection);
mysql_query("SET NAMES UTF8");

/* show tables */
$result = mysql_query('SHOW TABLES',$connection) or die('cannot show tables');
while($tableName = mysql_fetch_row($result)) {

	$table = $tableName[0];
	$num_rst = mysql_query("SELECT * FROM ".$table);
	$num = mysql_num_rows($num_rst);
	
	echo '<div><a href="?view='.$table.'" style="color:#6666FF;"><span class="glyphicon glyphicon-eye-open"></span></a> <a href="?truncate='.$table.'" style="color:#666666;"><span class="glyphicon glyphicon-trash"></span></a> <a href="?drop='.$table.'" style="color:#CC0000;"><span class="glyphicon glyphicon-remove"></span></a> ตาราง : <strong>',$table,'</strong> ('.$num.')</div>';
}

} else if(isset($_GET['view']) && !isset($_GET['edit'])){

echo '<div class="table-responsive"><table class="table table-hover">';

/* connect to the db */
$connection = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connection);
mysql_query("SET NAMES UTF8");

/* show tables */
$result = mysql_query('SHOW FIELDS FROM '.htmlspecialchars($_GET["view"]),$connection) or die('cannot show column');
$numrow = mysql_num_rows($result);
echo '<thead><tr>';
while($tableName = mysql_fetch_row($result)) {

	$table = $tableName[0];
	
	echo '<th style="width:auto;">',$table,'</th>';
}
echo '<th></th></tr></thead>';
$data_qry = mysql_query("SELECT * FROM `".htmlspecialchars($_GET["view"])."`",$connection);
$data_num = mysql_num_rows($data_qry);
if($data_num){

//=========================
$query = 'select * from '.htmlspecialchars($_GET["view"]);

$result = mysql_query($query);

if (!$result) 
{
	$message = 'ERROR:' . mysql_error();
	return $message;
}
else
{
	
	$i = 0;
	while ($row = mysql_fetch_row($result)) 
	{
		echo '<tr>';
		$count = count($row);
		$y = 0;
		while ($y < $count)
		{
			$c_row = current($row);
			echo '<td>' . substr($c_row,0,20) . '</td>';
			next($row);
			$y = $y + 1;
		}
		echo '<td><a href="?edit='.$_GET["view"].'&id='.$row[0].'"><b class="glyphicon glyphicon-edit text-success"></b></a></td></tr>';
		$i = $i + 1;
	}
	echo '</table>';
	mysql_free_result($result);
}
//=========================

} else{
	$total_numpage = $numrow+1;
echo '<tr><td colspan="'.$total_numpage.'"><div align="center">ไม่พบข้อมูล</div></td></tr> </table>';
}
echo '</div>';
} else if(isset($_GET["truncate"])){

$connect = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connect);
mysql_query("SET NAMES UTF8");

$query = mysql_query("SELECT * FROM ".htmlspecialchars($_GET["truncate"]),$connect);

if(!$query){

?>
<div class="alert alert-danger" align="center">
	<b class="glyphicon glyphicon-exclamation-sign"></b> ไม่พบตารางนี้
</div>
<div align="center"><a class="btn btn-danger" href="./"><b class="glyphicon glyphicon-remove"></b> ยกเลิก</a></div>
<?php

} else{

if(!isset($_GET["act"]) or $_GET["act"]!="confirm"){
?>
<div class="alert alert-warning" align="center">
	<b class="glyphicon glyphicon-warning-sign"></b> คุณแน่ใจหรือว่าต้องการใช้คำสั่งดังต่อไปนี้<br/>
	TRUNCATE `<?=$_GET["truncate"]?>`
</div>

<div align="center"><a class="btn btn-success" href="?truncate=<?=$_GET["truncate"]?>&act=confirm"><b class="glyphicon glyphicon-trash"></b> ยืนยันการใช้คำสั่ง</a> <a class="btn btn-danger" href="./"><b class="glyphicon glyphicon-remove"></b> ยกเลิก</a></div>

<?php
} else{
	$qry = mysql_query("TRUNCATE `".htmlspecialchars($_GET["truncate"])."`");
	if(!$qry){
?>
<div class="alert alert-danger" align="center">
	<b class="glyphicon glyphicon-exclamation-sign"></b> ไม่สามารถทำรายการได้
</div>

<div align="center"><a href="./" class="btn btn-danger"><b class="glyphicon glyphicon-remove"></b> ย้อนกลับ</a></div>
<?php
	} else{
?>
<div class="alert alert-success" align="center">
	<b class="glyphicon glyphicon-ok-sign"></b> ทำรายการสำเร็จ
</div>

<div align="center"><a href="./" class="btn btn-success"><b class="glyphicon glyphicon-ok"></b> เสร็จสิ้น</a></div>
<?php
	}
}

}

} else if(isset($_GET["drop"])){

$connect = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connect);
mysql_query("SET NAMES UTF8");

$query = mysql_query("SELECT * FROM ".htmlspecialchars($_GET["drop"]),$connect);

if(!$query){

?>
<div class="alert alert-danger" align="center">
	<b class="glyphicon glyphicon-exclamation-sign"></b> ไม่พบตารางนี้
</div>
<div align="center"><a class="btn btn-danger" href="./"><b class="glyphicon glyphicon-remove"></b> ยกเลิก</a></div>
<?php

} else{

if(!isset($_GET["act"]) or $_GET["act"]!="confirm"){
?>
<div class="alert alert-warning" align="center">
	<b class="glyphicon glyphicon-warning-sign"></b> คุณแน่ใจหรือว่าต้องการใช้คำสั่งดังต่อไปนี้<br/>
	DROP TABLE `<?=$_GET["drop"]?>`
</div>

<div align="center"><a class="btn btn-success" href="?drop=<?=$_GET["drop"]?>&act=confirm"><b class="glyphicon glyphicon-remove"></b> ยืนยันการใช้คำสั่ง</a> <a class="btn btn-danger" href="./"><b class="glyphicon glyphicon-remove"></b> ยกเลิก</a></div>

<?php
} else{
	$qry = mysql_query("DROP TABLE `".htmlspecialchars($_GET["drop"])."`");
	if(!$qry){
?>
<div class="alert alert-danger" align="center">
	<b class="glyphicon glyphicon-exclamation-sign"></b> ไม่สามารถทำรายการได้
</div>

<div align="center"><a href="./" class="btn btn-danger"><b class="glyphicon glyphicon-remove"></b> ย้อนกลับ</a></div>
<?php
	} else{
?>
<div class="alert alert-success" align="center">
	<b class="glyphicon glyphicon-ok-sign"></b> ทำรายการสำเร็จ
</div>

<div align="center"><a href="./" class="btn btn-success"><b class="glyphicon glyphicon-ok"></b> เสร็จสิ้น</a></div>
<?php
	}
}

}

} else if(isset($_GET["id"]) && isset($_GET["edit"])){
	
/* connect to the db */
$connection = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connection);	
mysql_query("SET NAMES UTF8");

$qry_n = mysql_query("SELECT * FROM ".htmlspecialchars($_GET["edit"]));
$rst_n = mysql_fetch_row($qry_n);
$rst_n2 = mysql_fetch_array($qry_n);

$query = 'select * from '.htmlspecialchars($_GET["edit"].' WHERE '.mysql_field_name($qry_n,0).' LIKE \''.$_GET["id"].'\'');

//die($query);

$result = mysql_query($query);
$chkrow = mysql_num_rows($result);

//POST
$sql_update = "UPDATE `".$_SESSION["db"]."`.`".htmlspecialchars($_GET["edit"])."` SET ";
$sql_update3 = " WHERE  `".htmlspecialchars($_GET["edit"])."`.`".mysql_field_name($qry_n,0)."` =".htmlspecialchars($_GET["id"])." LIMIT 1 ;";
//POST

?>

<form action="?edit=<?=htmlspecialchars($_GET["edit"])?>&id=<?=$_GET["id"]?>" method="post">

<?php

if (!$result) 
{
	$message = 'ERROR:' . mysql_error();
	return $message;
}
else
{
	$i = 0;
	echo '<div class="table-responsive"><table class="table table-bordered table-hover table-striped"><thead><tr>';
	
	
	while ($i < mysql_num_fields($result))
	{
		$meta = mysql_fetch_field($result, $i);
		echo '<th>' . $meta->name . '</th>';
		$i = $i + 1;
		$_SESSION["row_colspan"] = $i;
	}
	echo '</tr></thead>';
	
	$i = 0;
	$y=0;

	if($chkrow){
	
	while ($row = mysql_fetch_row($result)) 
	{
		echo '<tr>';
		$count = count($row);
		
		while ($y < $count)
		{
			
			if(isset($_POST[mysql_field_name($qry_n,$y)])){
			$sql_update.= "`".mysql_field_name($qry_n,$y)."` = '".$_POST[mysql_field_name($qry_n,$y)]."' ,";
			}

			$c_row = current($row);
			echo '<td><input name="'.mysql_field_name($qry_n,$y).'" style="width:100%;" type="text" class="form-control" value="' . $c_row . '" /></td>';
			
			next($row);
			$y = $y + 1;

		}

		echo '</tr>';
	}
		if($_POST){
			$total = $sql_update.$sql_update3;
			$sql_update_l = str_replace(", WHERE"," WHERE",$total);
			//echo $sql_update_l;
			if(mysql_query($sql_update_l,$connection)){
				echo '<div align="center" class="alert alert-success"><b class="glyphicon glyphicon-ok-sign"></b> บันทึกข้อมูลสำเร็จ</div>';
			} else{
				echo '<div align="center" class="alert alert-danger"><b class="glyphicon glyphicon-exclamation-sign"></b> บันทึกข้อมูลไม่สำเร็จ ('.mysql_error().')</div>';
			}
		}
	
	} else{
		
		echo '<tr><td colspan="'.$_SESSION["row_colspan"].'"><div align="center">ไม่พบข้อมูล</div></td></tr>';
	}
	
	echo '</table></div>';
	mysql_free_result($result);
}
?>

<div align="center">
<button type="submit" class="btn btn-success"><b class="glyphicon glyphicon-ok"></b> บันทึก</button> <a href="./" class="btn btn-danger"><b class="glyphicon glyphicon-remove"></b> ยกเลิก</a>
</div>

</form>

<?php
	
} else if(isset($_GET["structure"]) or $_GET["structure"]=="view"){
	
/* connect to the db */
$connection = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connection);
mysql_query("SET NAMES UTF8");

/* show tables */
$result = mysql_query('SHOW TABLES',$connection) or die('cannot show tables');
echo '<div align="center">';
while($tableName = mysql_fetch_row($result)) {

	$table = $tableName[0];
	
	echo '<h3>',$table,'</h3>';
	$result2 = mysql_query('SHOW COLUMNS FROM '.$table) or die('cannot show columns from '.$table);
	if(mysql_num_rows($result2)) {
		echo '<table cellpadding="0" cellspacing="0" class="db-table">';
		echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default<th>Extra</th></tr>';
		while($row2 = mysql_fetch_row($result2)) {
			echo '<tr>';
			foreach($row2 as $key=>$value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		}
		echo '</table><br />';
	}
}
echo '</div>';
	
} else if(isset($_GET[fix]) && isset($_GET[table])){
	
/* connect to the db */
$connection = mysql_connect($_SESSION["host"],$_SESSION["user"],$_SESSION["pass"]);
mysql_select_db($_SESSION["db"],$connection);
mysql_query("SET NAMES UTF8");
	
if($_GET[fix]=="ai"){
if($_GET["act"]!="confirm"){
?>
<div align="center">
<h4>คุณต้องการที่จะซ่อม Auto Increment หรือไม่</h4><p>ระบบจะรีเซ็ต Auto Increment เพื่อให้เรียงจากหมายเลข ID ล่าสุด</p>
<a href="?fix=ai&table=<?=$_GET['table']?>&act=confirm" class="btn btn-success"><b class="glyphicon glyphicon-ok"></b> ยืนยัน</a> 
<a href="?fix=ai&table=<?=$_GET['table']?>&act=confirm" class="btn btn-danger"><b class="glyphicon glyphicon-ok"></b> ยืนยัน</a>
</div>
<?php
} else{
$sql_ai = "ALTER TABLE  `".htmlspecialchars($_GET[table])."` AUTO_INCREMENT =1";
if(mysql_query($sql_ai)or die(mysql_error())){
	echo '<div align="center" class="alert alert-success"><b class="glyphicon glyphicon-ok-sign"></b> ทำรายการสำเร็จ</div>';
} else{
	echo '<div align="center" class="alert alert-danger"><b class="glyphicon glyphicon-exclamation-sign"></b> ไม่สามารถทำรายการได้</div>';
}

echo '<div align="center"><a href="./" class="btn btn-success"><b class="glyphicon glyphicon-ok-sign"></b> เสร็จสิ้น</a></div>';

}
}

} else{
	?><div align="center" class="alert alert-danger"><b class="glyphicon glyphicon-exclamation-sign"></b> ไม่พบหน้านี้</div><?php
}// GET FUNCTION
}

}
?>

<?php
if(isset($_SESSION["login"]) and $_SESSION["login"]==true){

echo '<hr />';

if($_GET){
	echo '<a href="#" onclick="history.go(-1);return false;"><b class="glyphicon glyphicon-arrow-left"></b> ย้อนกลับ</a> | ';
}
	
echo '<a href="?logout='.$_SESSION["user"].'"><span class="glyphicon glyphicon-log-out"></span> ออกจากระบบ</a> | <a href="?structure"><b class="glyphicon glyphicon-link"></b> ดูโครงสร้างตาราง</a>';

if(isset($_GET["view"]) or isset($_GET["edit"])){
	if(isset($_GET["view"]) and !isset($_GET["edit"])){$table_ai_fix = $_GET["view"];}else{$table_ai_fix = $_GET["edit"];}
echo ' | <a href="?fix=ai&table='.htmlspecialchars($table_ai_fix).'"><b class="glyphicon glyphicon-font"></b> ซ่อมระบบ Auto Increment</a>';
}

}
?>

</div>
</div>

<div align="center" style="margin-top:20px;">
<strong>(c) MiNi Database | Powered By <a href="https://www.facebook.com/aom.siriwt">@Aom Siriwat</a></strong>
</div>

</body>
</html>
