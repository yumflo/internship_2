<?php
session_start();
$MPO = $_SESSION['MPO'];
$MPT = $_SESSION['MPT'];
$MPTH = $_SESSION['MPTH'];
$MPF = $_SESSION['MPF'];
$MPS = $_SESSION['MPS'];
/*--------------------------*/
$MOO = $_SESSION['MOO'];
$MOT = $_SESSION['MOT'];
$MOTH = $_SESSION['MOTH'];
$MOF = $_SESSION['MOF'];
$MPOY = $_SESSION['MPOY'];
//include
include_once('php-ofc-library/bar_for_chart.php');
//圖表標題
$title = '平均放鬆';
//類別X軸的類別
$label_array = array('第一部分', '第二部分', '第三部分', '第四部分' , '綜合分析');
//資料列名稱
$key_array = array('班級平均放鬆', '個人平均放鬆');
//資料陣列
$data_array = array(
	array($MPO,$MPT,$MPTH,$MPF,$MPS),
	array($MOO,$MOT,$MOTH,$MOF,$MPOY),
);

//將設定參數傳入繪製統計圖
chart('line', $title, $label_array, $key_array, $data_array);
unset($_SESSION['MPO']);
unset($_SESSION['MPT']);
unset($_SESSION['MPTH']);
unset($_SESSION['MPF']);
unset($_SESSION['MPS']);
unset($_SESSION['MOO']);
unset($_SESSION['MOT']);
unset($_SESSION['MOTH']);
unset($_SESSION['MOF']);
unset($_SESSION['MPOY']);
?>