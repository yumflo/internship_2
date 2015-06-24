<?php
session_start();
$AA = $_SESSION['AA'];
$AB = $_SESSION['AB'];
$AC = $_SESSION['AC'];
$AD = $_SESSION['AD'];
$AE = $_SESSION['AE'];
$RA = $_SESSION['RA'];
$RB = $_SESSION['RB'];
$RC = $_SESSION['RC'];
$RD = $_SESSION['RD'];
$RE = $_SESSION['RE'];
//include
include_once('php-ofc-library/bar_for_chart.php');
//圖表標題
$title = '統計圖';
//類別X軸的類別
$label_array = array('A', 'B', 'C', 'D', 'E');
//資料列名稱
$key_array = array('專心統計圖', '放鬆統計圖');
//資料陣列
$data_array = array(
	array($AA,$AB,$AC,$AD,$AE),
	array($RA,$RB,$RC,$RD,$RE),
);
//將設定參數傳入繪製統計圖
chart('bar', $title, $label_array, $key_array, $data_array);
unset($_SESSION['AA']);
unset($_SESSION['AB']);
unset($_SESSION['AC']);
unset($_SESSION['AD']);
unset($_SESSION['AE']);
unset($_SESSION['RA']);
unset($_SESSION['RB']);
unset($_SESSION['RC']);
unset($_SESSION['RD']);
unset($_SESSION['RE']);
?>