<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>ติดตั้ง : Install</title>

<link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="public/css/bootstrap.css" type="text/css" media="screen">
<link href="public/css/fonts.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="public/css/style.css" type="text/css">
<link rel="stylesheet" href="public/css/normalize.css" type="text/css">
<link rel="stylesheet" href="public/css/docs.css" type="text/css">
<link rel="stylesheet" href="public/css/docs.min.css" type="text/css">

<script type="text/javascript" src="public/js/jquery.min.js"></script>

</head>

<style>
.box{
	margin-top:50px;
	width:600px;
	border:1px #CCC solid;
	border-color:#CCC;
	background-color:#FFF;
	box-shadow: 2px 2px 10px #888888;
	border-radius:5px;
	padding:10px;
}
</style>

<body>

<div align="center">
<div class="box">
<h3><strong><b class="glyphicon glyphicon-download-alt"></b> Installation : ระบบช่วยติดตั้ง</strong></h3><hr/>
<p>[ จัดทำระบบโดย Aom Siriwat ]</p>
<?php
if(!isset($_GET["step"])){
	
if(file_exists("installed")){
	echo '<script>window.location="index.php";</script>';
	die("You have installed system!");
}
	
?>
<h4>ยินดีต้อนรับเข้าสู่ระบบตัวช่วยติดตั้งระบบแบบง่าย</h4>
<?php
} else if(isset($_GET["step"]) and $_GET["step"]==1){
?>
<p>ระบบนี้จัดทำขึ้นเพื่อใช้ในระบบเว็บไซต์เท่านั้นมิได้มีเจตนาเลียนแบบหรือการอื่นๆ ที่ผิดกฎหมายแต่อย่างใด.  ระบบนี้จัดทำขึ้นเพื่ออำนวยความสะดวกในการเข้าสู่ฐานข้อมูลได้ง่ายๆ โดยไม่ยุ่งยาก ออกแบบมาให้ดูกระทัดรัด ดูเรียบง่ายใช้ง่ายได้ง่ายๆ โดยผู้ใช้ที่ไม่มีความรู้ด้านฐานข้อมูลกูสามารถเข้ามาใช้งานได้อย่างง่ายดาย.</p>
<p>ผู้จัดทำระบบไม่อนุญาตให้ผู้ใช้งานหรือผู้พัฒนานำระบบนี้ไปพัฒนาเป็นของตนเองหรือดัดแปลงต่างๆแต่อย่างใด จนกว่าจะได้รับอนุญาตจากผู้จัดทำระบบนี้ (ติดต่อที่ Facebook : <a href="https://www.facebook.com/aom.siriwt">คลิ๊ก</a>)</p>
<?php
} else if(isset($_GET["step"]) and $_GET["step"]==2){
	
if(file_exists("installed")){
	echo '<script>window.location="index.php";</script>';
	die("You have installed system!");
}
	
?>
<h5>สร้างไฟล์ยืนยันการติดตั้ง</h5>

<p>กด "เข้าสู่ขั้นตอนต่อไป" เพื่อสร้างไฟล์ยืนยันการติดตั้ง</p>

<?php
} else if(isset($_GET["step"]) and $_GET["step"]==3){
	
if(file_exists("installed")){
	echo '<script>window.location="index.php";</script>';
	die("You have installed system!");
}
	
$strFileName = "installed";
$objCreate = fopen($strFileName, 'w');

if($objCreate){
?>
<p class="text-success"><b class="glyphicon glyphicon-ok-sign"></b> สร้างไฟล์ยืนยันการติดตั้งสำเร็จ (installed)</p>
<?php
} else{
?>
<p class="text-danger"><b class="glyphicon glyphicon-exclamation-sign"></b> สร้างไฟล์ยืนยันการติดตั้งไม่สำเร็จ (Failed)</p>
<?php
}

} else if(isset($_GET["step"]) and $_GET["step"]==4){

if(file_exists("installed")){
?>
<h4 style="color:green;"><b class="glyphicon glyphicon-ok"></b> การติดตั้งสำเร็จแล้ว</h4>
<?php
} else{
?>
<h4 style="color:red;"><b class="glyphicon glyphicon-remove"></b> การติดตั้งล้มเหลว</h4>
<?php
}

} else if(isset($_GET["step"]) and $_GET["step"]=="end"){
?>
<h4>ขอบคุณสำหรับการติดตั้งและใช้งานระบบ</h4>
<?php
} else{
?>
<h4 style="color:red;">ไม่พบหน้านี้</h4>
<?php
}
?>
<hr />

<div align="center"><?php if(isset($_GET["step"]) and is_numeric($_GET["step"])>1){$prev = $_GET["step"]-1;echo '<a href="install.php?step='.$prev.'" class="btn btn-primary"><b class="glyphicon glyphicon-chevron-left"></b> ขั้นตอนก่อนหน้านี้</a>';} else if(isset($_GET["step"]) and is_numeric($_GET["step"])==1){echo '<a href="install.php" class="btn btn-primary"><b class="glyphicon glyphicon-chevron-left"></b> ไปยังหน้าแรก</a>';} ?> 
<?php
if(isset($_GET["step"]) and $_GET["step"]==4){
?>
<a href="install.php?step=end" class="btn btn-success"><b class="glyphicon glyphicon-ok-sign"></b> เสร็จสิ้น</a>
<?php
} else if(isset($_GET["step"]) and $_GET["step"]=="end"){
?>
<a href="index.php" class="btn btn-success"><b class="glyphicon glyphicon-home"></b> ไปยังหน้าจัดการระบบ</a>
<?php
} else{
?>
<a href="install.php?step=<?php if(isset($_GET["step"])){echo $_GET["step"]+1;}else{echo "1";} ?>" class="btn btn-success"><b class="glyphicon glyphicon-chevron-right"></b> เข้าสู่ขั้นตอนต่อไป</a>
<?php
}
?>
</div>

</div>
</div>

</body>
</html>
