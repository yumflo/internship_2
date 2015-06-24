<?php
session_start();
$APO = $_SESSION['APO'];
$APT = $_SESSION['APT'];
$APTH = $_SESSION['APTH'];
$APF = $_SESSION['APF'];
$APS = $_SESSION['APS'];
/*--------------------------*/
$AOO = $_SESSION['AOO'];
$AOT = $_SESSION['AOT'];
$AOTH = $_SESSION['AOTH'];
$AOF = $_SESSION['AOF'];
$APOY = $_SESSION['APOY'];
//include
include_once('php-ofc-library/bar_for_chart.php');
//圖表標題
$title = '平均專注';
//類別X軸的類別
$label_array = array('第一部分', '第二部分', '第三部分', '第四部分' , '綜合分析');
//資料列名稱
$key_array = array('班級平均專注', '個人平均專注');
//資料陣列
$data_array = array(
	array($APO,$APT,$APTH,$APF,$APS),
	array($AOO,$AOT,$AOTH,$AOF,$APOY),
);

//將設定參數傳入繪製統計圖
chart('line', $title, $label_array, $key_array, $data_array);
unset($_SESSION['APO']);
unset($_SESSION['APT']);
unset($_SESSION['APTH']);
unset($_SESSION['APF']);
unset($_SESSION['APS']);
unset($_SESSION['AOO']);
unset($_SESSION['AOT']);
unset($_SESSION['AOTH']);
unset($_SESSION['AOF']);
unset($_SESSION['APOY']);
?>