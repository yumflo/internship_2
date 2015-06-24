<?
$stno = $_GET['A'];
require("Connections/conndb.php");
$user_Account = mysql_query("SELECT Account FROM user_data WHERE no ='$stno'");
while (list($Student_Account,)=mysql_fetch_array($user_Account)){
$_SESSION['MM_Student'] =  $Student_Account;
}
$id = $_SESSION['MM_Student'];
?>
<?php
require_once('Connections/localhost.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_localhost, $localhost);
$query_user_data = "SELECT Account,User_name FROM teacher_data WHERE Cram = (Select Cram From User_data Where Account = '$id')";
$user_data = mysql_query($query_user_data, $localhost) or die(mysql_error());
$row_user_data = mysql_fetch_assoc($user_data);
$totalRows_user_data = mysql_num_rows($user_data);
?>

<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Student'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Student']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.html";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>

<?php
/*留言板*/
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$result_name=mysql_query("SELECT User_name,Cram FROM user_data Where account ='$id'");
while (list($n,$c)=mysql_fetch_row($result_name)){
$name  = $n;
$cram  = $c;
		}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "qaform")) {
  $insertSQL = sprintf("INSERT INTO qa (Account, User_name, Cram, gcomment,Teac , time) VALUES (%s, %s, %s, %s, %s ,now())",
                       GetSQLValueString($id, "text"),
                       GetSQLValueString($name, "text"),
                       GetSQLValueString($cram, "text"),
                       GetSQLValueString($_POST['gcomment'], "text"),
					   GetSQLValueString($_POST['user_name'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($insertSQL, $localhost) or die(mysql_error());

  $insertGoTo = "student.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_gbookshow = 3;
$pageNum_gbookshow = 0;
if (isset($_GET['pageNum_gbookshow'])) {
  $pageNum_gbookshow = $_GET['pageNum_gbookshow'];
}
$startRow_gbookshow = $pageNum_gbookshow * $maxRows_gbookshow;

mysql_select_db($database_localhost, $localhost);
$query_gbookshow = "SELECT * FROM qa Where Account = '$id' ORDER BY no DESC";
$query_limit_gbookshow = sprintf("%s LIMIT %d, %d", $query_gbookshow, $startRow_gbookshow, $maxRows_gbookshow);
$gbookshow = mysql_query($query_limit_gbookshow, $localhost) or die(mysql_error());
$row_gbookshow = mysql_fetch_assoc($gbookshow);

if (isset($_GET['totalRows_gbookshow'])) {
  $totalRows_gbookshow = $_GET['totalRows_gbookshow'];
} else {
  $all_gbookshow = mysql_query($query_gbookshow);
  $totalRows_gbookshow = mysql_num_rows($all_gbookshow);
}
$totalPages_gbookshow = ceil($totalRows_gbookshow/$maxRows_gbookshow)-1;

$queryString_gbookshow = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_gbookshow") == false && 
        stristr($param, "totalRows_gbookshow") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_gbookshow = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_gbookshow = sprintf("&totalRows_gbookshow=%d%s", $totalRows_gbookshow, $queryString_gbookshow);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="zh-tw">
<head>
<meta name="Generator" content="EditPlus" />
<meta name="Author" content="FT" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>

<title>兆豐文創 Harvest Education</title>
<style>
.gtable{border:solid 3px #fbf074; font-size:12px;}
.gtable tr td{border-bottom:solid 1px #fbf074; padding:7px;}
</style>
<style type="text/css">
@import url(checkbox_style.css);
<!--
a { text-decoration: none } 
a:link {color: #333}
a:visited {color:333}
a:active {color:#333}
a:hover {
	color: #666
}

a:hover img{
 opacity: 0.55;
 filter:alpha(opacity=55); /* IE only */}
-->

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	background-image: url(photo/6.png);
	background-repeat: repeat;
	font-weight: bold;
	color: #333;
}

	#menu {
	margin: 0;
	padding: 0;
	list-style: none;
	position: relative;
	float: left;
	background: #fff;
	font-family: Helvetica,Microsoft JhengHei,Apple LiGothic, Arial, sans-serif;
	font-size:10.5pt;
	}
	
	#menu li {
		margin: 0px;
		padding: 0px;
		float: left;
		border-right: 0px solid #999;
	}
	#menu li a {
		padding: 3px 10px;
		display: block;
		color: #000;
		text-decoration: none;
	}
	#menu li ul {
		margin: 0;
		padding: 6px 20px;
		list-style: none;
		float: left;
		position: absolute;
		line-height:22px;
		left: 0;
		width: 500px;
		color: #fff;
		background: # ;
		display: none;
	}
	#menu li ul li { border: 1px solid #fff; }
	#menu li ul li a { display: inline; }
	#menu li ul li a:hover { color:#333; }
	#menu li a:hover { color:#333; }
	
.brown {
	text-align: left;
	font-size:9pt;
	font-family: Arial, Helvetica, sans-serif;
	line-height:10pt;
}

.button {	font-size:11pt; color:#332e2e; #; font-family: Helvetica, sans-serif; line-height:12pt; letter-spacing:1pt;
}

.info {
	font-size:10pt;
	color:#666;
#; 	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial, sans-serif;
	line-height:12pt;
	letter-spacing:1px;
	text-align: center; 
}

.more {	font-style:oblique ;font-size:9pt; font-family: Georgia, "Times New Roman", Times, serif; line-height:18pt; color: #999; font-weight:500; line-height:15px;
}

.info1 {font-size:10pt; color:#333; #; font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial, sans-serif; line-height:12pt; letter-spacing:1px;
}

.info2 {
	font-size:10pt;
	color:#C03;
#; 		font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial, sans-serif;
	line-height:12pt;
	letter-spacing:1px;
}

.text { font-size:10pt; color:#333; #; font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial, sans-serif; line-height:18pt; letter-spacing:1px;
}

.chtitle {
	font-size:17px;
	color:#333;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
}

.boxtitle {
	font-size:15px;
	color: #000;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
}


.menuwhite{
	font-size:15px;
	color:#353534;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:18px;
}


.entitle {
	font-size:17px;
	color:#333;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	text-align: center;
	line-height:20px;
}

.menu {
	font-size:15px;
	color:#333;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
}

.title {	font-size:25px;
	color: #CCC;
#; 	font-family:Georgia, "Times New Roman", Times, serif;
	letter-spacing:1px;
	font-style: italic;
}
.menu {
	text-align: right;
}

.content{width:488px;position:relative;}

.shadow{position:absolute;top:30%;left:25%;width:235px;background:#ccc;}

#uboxstyle .select_box{width:100px;height:24px;}
#uboxstyle div.tag_select{display:block;color:#79A2BD;width:80px;height:24px;background:transparent url("photo/ubox-select.gif") no-repeat 0 0;padding:0 10px;line-height:24px;}
#uboxstyle div.tag_select_hover{display:block;color:#79A2BD;width:80px;height:24px;background:transparent url("photo/ubox-select.gif") no-repeat 0 -24px;padding:0 10px;line-height:24px;}
#uboxstyle div.tag_select_open{display:block;color:#79A2BD;width:80px;height:24px;background:transparent url("photo/ubox-select.gif") no-repeat 0 -48px;padding:0 10px;line-height:24px;}
#uboxstyle ul.tag_options{position:absolute;padding:0;margin:0;list-style:none;background:transparent url("photo/ubox-select.gif") no-repeat right bottom;width:100px;padding:0 0 5px;margin:0;}
#uboxstyle ul.tag_options li{background:transparent url("photo/ubox-select.gif") repeat-y -100px 0;display:block;width:80px;padding:0 10px;height:24px;text-decoration:none;line-height:24px;color:#79A2BD;}
#uboxstyle ul.tag_options li.open_hover{background:transparent url("photo/ubox-select.gif") no-repeat 0 -72px;color:#fff}
#uboxstyle ul.tag_options li.open_selected{background:transparent url("photo/ubox-select.gif") no-repeat 0 -96px;color:#fff}
/*Button Style*/
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background-color:transparent;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #79A2BD;
	display:inline-block;
	color:#79A2BD;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:1px 8px;
	text-decoration:none;
	text-shadow:1px 1px 0px #ffffff;
}.classname:active {
	position:relative;
	top:1px;
}
</style>


<script type="text/javascript">
	$(function(){
		// 幫 #menu li 加上 hover 事件
		$('#menu>li').hover(function(){
			// 先找到 li 中的子選單
			var _this = $(this),
				_subnav = _this.children('ul');
			
			// 變更目前母選項的背景顏色
			// 同時淡入子選單(如果有的話)
			_this.css('backgroundColor', '#');
			_subnav.stop(true, true).fadeIn(400);
		} , function(){
			// 變更目前母選項的背景顏色
			// 同時淡出子選單(如果有的話)
			// 也可以把整句拆成上面的寫法
			$(this).css('backgroundColor', '').children('ul').stop(true, true).fadeOut(400);
		});
		
		// 取消超連結的虛線框
		$('a').focus(function(){
			this.blur();
		});
	});
</script>
<script type="text/javascript" src="select2css.js"></script>
<SCRIPT LANGUAGE="JavaScript">
document.onclick = CheckNumber;
var intNumber = 0	 // 已選取的數量
function CheckNumber(){
var blnCheck = false;	 // 判斷有沒有選取
if (event.srcElement.type == "checkbox")
{
blnCheck = event.srcElement.checked;
intNumber = blnCheck ? (intNumber + 1) : (intNumber - 1);
if (intNumber > 2)
{
intNumber -= 1;
return false;
}
}
}
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
var intNumber = 0	 // 已選取的數量
function Check_submit(){
ChooseNumber = intNumber;
if (ChooseNumber <1)
{
alert("Please choose more than one and less than three！");
return false;
}
}
</SCRIPT>
<link rel="shortcut icon" href="icon/favicon.ico" >
<link rel="Bookmark" href="icon/favicon.ico" type="image/x-icon" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="30" align="right" valign="middle" bgcolor="#fbf074" ><table border="0" cellspacing="0" cellpadding="0">
      <tr>
<td align="center" valign="middle"><span class="brown"><a href="student.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image13','','photo/home2.png',1)"><img src="photo/home.png" name="Image13" height="12" border="0"></a>　<a href="<?php echo $logoutAction ?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12','','photo/logout2.png',1)"><img src="photo/logout.png" name="Image12" width="64" height="12" border="0"></a></span></td>        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	    <td width="950"><table width="950" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="149" rowspan="3"><a name="top"></a><img src="photo/student.png" height="200" border="0"></td>
	        <td width="801" height="30"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
          </tr>
	      <tr>
	        <td height="15"><span class="chtitle">學生<span class="entitle">Student<br>
	        </span></span>
	          <hr>
	
            <span class="chtitle"><span class="entitle">              </span></span></td>
          </tr>
	      <tr>
	        <td height="15" align="right" valign="top" class="menu" ><a href="#A" class="menu">腦波教室</a></a>│<a href="#B" class="menu">我的目標</a>│<a href="#C" class="menu">專注力＆放鬆度</a>│<a href="#F" class="menu">綜合分析</a>│<a href="#G" class="menu">輔助音樂</a>│<a href="#H" class="menu">問問老師</a></span></span></span></td>
          </tr>
	      </table></td>
  </tr>
	  <tr>
	    <td height="30">&nbsp;</td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#fbf074" ><span class="menuwhite"><br>
                  <a name="A"></a>腦<br>
	              波<br>
	              教<br>
	              室<br>
	              <br>
                </span></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#fbf074 #fbf074 #fbf074 #fbf074;padding:20px 20px 20px 20px; background-color:#FFF" >
	         <table border="0" cellspacing="0" cellpadding="0">
	           <tr>
	             <td width="620" valign="top">歡迎你使用放鬆訓練程式，這訓練程式主要幫助你學習更有效的放鬆方法，使你能在緊張的生活中，掌握放鬆的技巧，提升工作效率，最重要的是能夠調和身心，使自己生活得更快樂和健康。<br>
	               <br>
	               這訓練程式，是配合腦波放鬆燈一起使用，腦波放鬆燈能即時反映出你的放鬆狀態，使用者透過腦波放鬆燈的顏色，得知自己的狀態的同時，大腦更能夠自動調整身心的狀態和記憶平靜放鬆的內在感覺。當放鬆的感覺能有效地被認知後，這個放鬆的感覺，便自自然然地內化到我們的身心內，成為我們能力的一部份。當我們需要提取放鬆的能力時，就好像一個熟練的打字員一樣，能夠不經思考，就能把文字打出來。從此我們便能自由地掌控和提取放鬆和平靜的能力。<br>
  <br>
	               人是習慣的動物。研究表明，每天都參與訓練的人，比那些一星期只參與訓練六天的人，效果高三倍，同時一星期只參與訓練三或四或五天的人，效果更高達五倍之多。因此，如果你想有最好的效果，只要認真地跟著放鬆訓練程式去練習，你的放鬆能力必定會大大提升。如果你錯過了一天，只需要在第二天重新開始就可以了。簡單而言，每天大約用十五至三十分鐘，給自己一個機會，訓練自己成為放鬆的大師。
	</td>
	             <td width="30" align="center" valign="middle"><img src="photo/line.png" width="1" height="220"></td>
	             <td width="230" align="center" valign="top">
                 <? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
/*總平均專心 and 放鬆*/	
	$days_array_pie = array();
	/*抓取日期資料筆數*/
	$date_data_pie = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_pie = mysql_num_rows($date_data_pie);
	/*抓出來的日期丟到陣列內*/
	for($i_pie = 0 ;$i_pie<$num_date_rows_pie;$i_pie++){
	while (list($day_pie)=mysql_fetch_array($date_data_pie)){
	$days_pie[] = $day_pie;
	}
	/*日期陣列*/
	array_push($days_array_pie,$days_pie[$i_pie]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal_pie = 0 ;$k_atotal_pie<$num_date_rows_pie;$k_atotal_pie++){
	$asum_pie = 0;
	$acount_pie = 0;
	$atsum_pie = 0;
	$day_atotal_pie = $days_array_pie[$k_atotal_pie];
	$result_pie=mysql_query("SELECT attention FROM total_data WHERE (stage = 2 or stage = 3 or stage = 5 or stage = 6 or stage = 8 or stage = 9 or stage = 11 or stage = 12 or stage = 14 or stage = 15 or stage = 17 or stage = 18 or stage = 20 or stage = 21) and account = '$id'");
	$num_data_atotal_pie = mysql_num_rows($result_pie);
	/*某日未測驗值*/
	if($num_data_atotal_pie == "0"){
		$asum_pie = 0;
		$acount_pie = 0;
		$last_asum_pie +=$asum_pie;
		$last_acount_pie+=$acount_pie;
		}
	else{
	while (list($a_pie)=mysql_fetch_row($result_pie)){
    $atstring_pie = $a_pie;
	$output_count_atotal_pie = substr_count($atstring_pie,",");
	$atoutput_pie = explode(",", $atstring_pie);
	for($j_atotal_pie = 0 ; $j_atotal_pie<=$output_count_atotal_pie ; $j_atotal_pie++){
		$asum_pie += $atoutput_pie[$j_atotal_pie];
	}
		$acount_pie+=($output_count_atotal_pie);
	}
	$last_asum_pie +=$asum_pie;
	$last_acount_pie+=$acount_pie;
	$attdata_pie = round ($last_asum_pie / $last_acount_pie,2);
	$last_asum_pie =0;
	$last_acount_pie=0;
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_pie = 0 ;$k_mtotal_pie<$num_date_rows_pie;$k_mtotal_pie++){
	$msum_pie = 0;
	$mcount_pie = 0;
	$mtsum_pie = 0;
	$day_mtotal_mtotal = $days_array_pie[$k_mtotal_pie];
	$result_pie_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6 or stage = 7 or stage = 9 or stage = 10 or stage = 12 or stage = 13 or stage = 15 or stage = 16 or stage = 18 or stage = 19 or stage = 21) and account = '$id'");
	$num_data_mtotal_pie = mysql_num_rows($result_pie_2);
	if($num_data_mtotal_pie == "0"){
		$msum_pie = 0;
		$mcount_pie = 0;
		$last_sum_pie +=$msum_pie;
		$last_count_pie+=$mcount_pie;
		}
	else{
	while (list($m_pie)=mysql_fetch_row($result_pie_2)){
    $mtstring_pie = $m_pie;
	$output_count_mtotal_pie = substr_count($mtstring_pie,",");
	$mtoutput_pie = explode(",", $mtstring_pie);
	for($j_mtotal_pie = 0 ; $j_mtotal_pie<=$output_count_mtotal_pie ; $j_mtotal_pie++){
		$msum_pie += $mtoutput_pie[$j_mtotal_pie];
	}
		$mcount_pie+=($output_count_mtotal_pie);
	}
	$last_msum_pie +=$msum_pie;
	$last_mcount_pie+=$mcount_pie;
	$mttdata_pie = round ($last_msum_pie / $last_mcount_pie,2);
	$last_msum_pie =0;
	$last_mcount_pie=0;
	}
}
/*---------------------------------------------------------------------------------------------------------------------*/
/*判斷數值切換球體顏色*/
$amttdata = abs($attdata_pie-$mttdata_pie);
if($amttdata <=25){
	if(($attdata_pie >= 0 and $attdata_pie < 25) and ($mttdata_pie >= 0 and $mttdata_pie < 25)){
		$output = "<img src=\"../index/photo/lampcolor-01.png\" width=\"150\" align=\"middle\"/>";
		print($output);
	}
	else if(($attdata_pie >= 25 and $attdata_pie < 50) and ($mttdata_pie >= 25 and $mttdata_pie < 50)){
		$output = "<img src=\"../index/photo/lampcolor-02.png\" width=\"150\" align=\"middle\"/>";
		print($output);
	}
		else if(($attdata_pie >= 50 and $attdata_pie < 75) and ($mttdata_pie >= 50 and $mttdata_pie < 75)){
		$output = "<img src=\"../index/photo/lampcolor-03.png\" width=\"150\" align=\"middle\"/>";
		print($output);
	}
	else if(($attdata_pie >= 75 and $attdata_pie <= 100) and ($mttdata_pie >= 75 and $mttdata_pie < 100)){
		$output = "<img src=\"../index/photo/lampcolor-04.png\" width=\"150\" align=\"middle\"/>";
		print($output);
	}
	else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 25){
			$output = "<img src=\"../index/photo/lampcolor-01.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 25 and $mttdata_pie < 50){
			$output = "<img src=\"../index/photo/lampcolor-02.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 50 and $mttdata_pie < 75){
			$output = "<img src=\"../index/photo/lampcolor-03.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 75 and $mttdata_pie <= 100){
			$output = "<img src=\"../index/photo/lampcolor-04.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
		}
		else if($mttdata_pie>$attdata_pie){
			if($attdata_pie >= 0 and $attdata_pie < 25){
			$output = "<img src=\"../index/photo/lampcolor-01.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 25 and $attdata_pie < 50){
			$output = "<img src=\"../index/photo/lampcolor-02.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 50 and $attdata_pie < 75){
			$output = "<img src=\"../index/photo/lampcolor-03.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 75 and $attdata_pie <= 100){
			$output = "<img src=\"../index/photo/lampcolor-04.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
		}
	}
}
else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 25){
			$output = "<img src=\"../index/photo/lampcolor-01.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 25 and $mttdata_pie < 50){
			$output = "<img src=\"../index/photo/lampcolor-02.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 50 and $mttdata_pie < 75){
			$output = "<img src=\"../index/photo/lampcolor-03.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 75 and $mttdata_pie <= 100){
			$output = "<img src=\"../index/photo/lampcolor-04.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
		}
		else if($mttdata_pie>$attdata_pie){
			if($attdata_pie >= 0 and $attdata_pie < 25){
			$output = "<img src=\"../index/photo/lampcolor-01.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 25 and $attdata_pie < 50){
			$output = "<img src=\"../index/photo/lampcolor-02.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 50 and $attdata_pie < 75){
			$output = "<img src=\"../index/photo/lampcolor-03.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 75 and $attdata_pie <= 100){
			$output = "<img src=\"../index/photo/lampcolor-04.png\" width=\"150\" align=\"middle\"/>";
			print($output);
			}
		}

}
?>                
<p><img src="photo/color.png" alt="" width="230"></td>
                </tr>
              </table>
	 
</div></td>
          </tr>
	      </table></td>
  </tr>
	  <tr>
	    <td height="50" align="right" valign="middle"><a href="#top"><img src="photo/top-05.png" width="33" height="15" border="0"></a></td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table width="35" border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="26" align="center" valign="middle" bgcolor="#fbf074"><span class="menuwhite"><span class="boxtitle"><a name="B"></a></span><br>
	              我<br>
	              的<br>
	              目<br>
	              標<br>
	              <br>
                </span></td>
              </tr>
            </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#fbf074 #fbf074 #fbf074 #fbf074;padding:20px 20px 20px 20px; background-color:#FFF" >
<span class="chtitle"><span class="boxtitle">確定目標<br>
	          </span></span><span class="text">有明確的目標，是成功的關鍵。所以，請你用一分鐘的時間，想想在開始這訓練程式時，你想達到什麼目標，並把它寫下來</span></p>
	          <p>在完成這訓練程式後，我要達成的<br>
	            <label for="textfield2"></label>
	            <input name="textfield11" type="text" id="textfield2" size="160">
	            <br>
              </p>
<p><span class="chtitle"><span class="boxtitle">激發你對目標的熱情<br>
</span></span><span class="text">為甚麼你想實現你的目標？你的內在推動力是甚麼呢？背後又有甚麼原因？ 了解推動著你的背後力量，把它一一找出來。</span></p>
<p>你想達成目標的十個最主要原因是：</p>
<table border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" valign="middle"><p>1.
      <label for="textfield"></label>
      <br>
      </p>
  <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield" type="text" id="textfield2" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>2.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield10" type="text" id="textfield3" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>3.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield9" type="text" id="textfield4" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>4.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield8" type="text" id="textfield5" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>5.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield7" type="text" id="textfield6" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>6.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield6" type="text" id="textfield7" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>7.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield5" type="text" id="textfield8" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>8.
        <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield4" type="text" id="textfield9" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>9.
      <label for="textfield"></label>
      <br>
      </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield3" type="text" id="textfield10" size="150"></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><p>10.
      <label for="textfield"></label>
      <br>
    </p>
      <p></p></td>
    <td align="right" valign="middle">&nbsp;</td>
    <td align="right" valign="middle"><input name="textfield2" type="text" id="textfield" size="150"></td>
  </tr>
  <tr valign="top">
    <td colspan="3" align="right" valign="middle"><p>
      <input type="Submit" name="Send2" id="Send2" value="送出">
</td>
    </tr>
</table></div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td></td>
  </tr>
	  <tr>
	    <td height="50" align="right" valign="middle"><p><a href="#top"><img src="photo/top-05.png" alt="" width="33" height="15" border="0"></a></p></td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#fbf074"><p class="menuwhite"><br>
                    <a name="C"></a>專<br>
	            注<br>
	            力<br>
	            &amp;<br>
	            放<br>
	            鬆<br>
	            度<br>
	                <br>
                </p></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#fbf074 #fbf074 #fbf074 #fbf074;padding:20px 20px 20px 20px; background-color:#FFF" >
	          <table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
	            <tr>
	              <td width="885" align="left">我的專注祕訣</td>
                </tr>
	            <tr>
	              <td align="center"><form name="form5" method="post" action="">
	                <span id="sprytextfield3">
	                  <label for="text2"></label>
	                  <span class="textfieldRequiredMsg"></span></span>
                  </form><label for="textfield11"></label></td>
                </tr>
	            <tr>
	              <td align="center"><textarea name="textarea2" id="textarea2" cols="102" rows="3"></textarea></td>
                </tr>
	            <tr>
	              <td align="right"><input type="Submit" name="Send3" id="Send3" value="送出"></td>
                </tr>
	            <tr>
	              <td height="30" align="center">&nbsp;</td>
                </tr>
	            <tr>
	              <td align="left">我的放鬆祕訣</td>
                </tr>
	            <tr>
	              <td align="center"><form name="form5" method="post" action="">
	                <span id="sprytextfield5">
	                  <label for="text4"></label>
	                  <span class="textfieldRequiredMsg"></span></span>
	                </form>
	                <label for="textfield4"></label></td>
                </tr>
	            <tr>
	              <td align="center"><textarea name="textarea5" id="textarea5" cols="102" rows="3"></textarea></td>
                </tr>
	            <tr>
	              <td align="right"><input type="Submit" name="Send6" id="Send6" value="送出"></td>
                </tr>
	            <tr>
	              <td height="60" align="center">&nbsp;</td>
                </tr>
	            <tr>
	              <td align="center"><a name="part_one"></a>
<form id="form1" name="form1" method="post" onsubmit="return Check_submit();" action="student_window.php#part_one">
        <input type="checkbox" id="ck1" name="CheckboxGroup[]" value="1" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck1"> Stage 1</label>

        <input type="checkbox" id="ck2" name="CheckboxGroup[]" value="2" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck2"> Stage 2</label>

        <input type="checkbox" id="ck3" name="CheckboxGroup[]" value="3" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck3">Stage 3</label>

        <input type="checkbox" id="ck4" name="CheckboxGroup[]" value="4" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck4">Stage 4</label>

        <input type="checkbox" id="ck5" name="CheckboxGroup[]" value="5" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck5"> Stage 5</label>

        <input type="checkbox" id="ck6" name="CheckboxGroup[]" value="6" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck6">Stage 6</label>
<input name="submit" type="submit" value="Submit" />
        
</form>

<form>
<?
function paint($get_num,$get_num2){
session_start();
$_SESSION['part_one'] = $get_num;
$_SESSION['part_one2'] = $get_num2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(700, 300, 'part_one_line_data.php?type='));	
}
function paint2($get_num,$get_num2){
session_start();
$_SESSION['part_one'] = $get_num;
$_SESSION['part_one2'] = $get_num2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(650, 300, 'part_one_line_data_other.php?type='));	
}
function paint3($get_num,$get_num2){
session_start();
$_SESSION['part_one'] = $get_num;
$_SESSION['part_one2'] = $get_num2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(700, 300, 'part_one_line_data_total.php?type='));	
}
?>
</form>
<?
if( $_POST['CheckboxGroup'] == null ){
	$num = null;
	$num2 = null; 
	echo paint3($num,$num2);	
}
else{
foreach($_POST['CheckboxGroup'] as $stage[]);
if ($stage[0] == 1 && $stage[1]==null){
	$num = "1";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 2 && $stage[1]==null){
	$num = "2";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 3 && $stage[1]==null){
	$num = "3";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 4 && $stage[1]==null){
	$num = "4";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 5 && $stage[1]==null){
	$num = "5";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 6 && $stage[1]==null){
	$num = "6";
	$num2 ="null"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 1 && $stage[1]==2){
	$num = "1";
	$num2 ="2"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 1 && $stage[1]==3){
	$num = "1";
	$num2 ="3"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 1 && $stage[1]==4){
	$num = "1";
	$num2 ="4"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 1 && $stage[1]==5){
	$num = "1";
	$num2 ="5"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 1 && $stage[1]==6){
	$num = "1";
	$num2 ="6"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 2 && $stage[1]==3){
	$num = "2";
	$num2 ="3"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 2 && $stage[1]==4){
	$num = "2";
	$num2 ="4"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 2 && $stage[1]==5){
	$num = "2";
	$num2 ="5"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 2 && $stage[1]==6){
	$num = "2";
	$num2 ="6"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 3 && $stage[1]==4){
	$num = "3";
	$num2 ="4"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 3 && $stage[1]==5){
	$num = "3";
	$num2 ="5"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 3 && $stage[1]==6){
	$num = "3";
	$num2 ="6"; 
	echo paint2($num,$num2);	
	}
if ($stage[0] == 4 && $stage[1]==5){
	$num = "4";
	$num2 ="5"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 4 && $stage[1]==6){
	$num = "4";
	$num2 ="6"; 
	echo paint($num,$num2);	
	}
if ($stage[0] == 5 && $stage[1]==6){
	$num = "5";
	$num2 ="6"; 
	echo paint($num,$num2);	
	}	
}
?>
                  </td>
                </tr>
	            <tr>
	              <td align="center" bgcolor="#FFCC99"><table border="0" cellspacing="0" cellpadding="0">
	               <? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_one=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_one Where account ='$id'");
		while (list($a_part_one,$m_part_one)=mysql_fetch_row($result_time_part_one)){
			$attime_part_one  = $a_part_one;
			$mttime_part_one  = $m_part_one;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
/*第一部分專心 and 放鬆*/
$days_array_part_one = array();
	/*抓取日期資料筆數*/
	$date_data_part_one = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_part_one = mysql_num_rows($date_data_part_one);
	/*抓出來的日期丟到陣列內*/
	for($i_part_one = 0 ;$i_part_one<$num_date_rows_part_one;$i_part_one++){
	while (list($day_part_one)=mysql_fetch_array($date_data_part_one)){
	$days_part_one[] = $day_part_one;
	}
	/*日期陣列*/
	array_push($days_array_part_one,$days_part_one[$i_part_one]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal_part_one = 0 ;$k_atotal_part_one<$num_date_rows_part_one;$k_atotal_part_one++){
	$asum_part_one = 0;
	$acount_part_one = 0;
	$atsum_part_one = 0;
	$day_atotal_part_one = $days_array_part_one[$k_atotal_part_one];
	$result_part_one=mysql_query("SELECT attention FROM total_data WHERE (stage = 2 or stage = 3 or stage = 5 or stage = 6) and account = '$id'");
	$num_data_atotal_part_one = mysql_num_rows($result_part_one);
	$result_id_part_one=mysql_query("SELECT account FROM part_one WHERE account = '$id'");
	$num_id__part_one = mysql_num_rows($result_id_part_one);
if($num_id__part_one == 0){
$attdata_part_one = 0;
echo $attdata_part_one;
}
else{
	if($num_data_atotal_part_one == "0"){
		$asum_part_one = 0;
		$acount_part_one = 0;
		$last_asum_part_one +=$asum_part_one;
		$last_acount_part_one+=$acount_part_one;
		}
	else{
	while (list($a_part_one)=mysql_fetch_row($result_part_one)){
    $atstring_part_one = $a_part_one;
	$output_count_atotal_part_one = substr_count($atstring_part_one,",");
	$atoutput_part_one = explode(",", $atstring_part_one);
	for($j_atotal_part_one = 0 ; $j_atotal_part_one<=$output_count_atotal_part_one ; $j_atotal_part_one++){
		$asum_part_one += $atoutput_part_one[$j_atotal_part_one];
	}
		$acount_part_one+=($output_count_atotal_part_one);
	}
	$last_asum_part_one +=$asum_part_one;
	$last_acount_part_one+=$acount_part_one;
	$attdata_part_one = round ($last_asum_part_one / $last_acount_part_one,2);
	$last_asum_part_one =0;
	$last_acount_part_one=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_one = 0 ;$k_mtotal_part_one<$num_date_rows_part_one;$k_mtotal_part_one++){
	$msum_part_one = 0;
	$mcount_part_one = 0;
	$mtsum_part_one = 0;
	$day_mtotal_mtotal = $days_array_part_one[$k_mtotal_part_one];
	$result_part_one_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6) and account = '$id'");
	$num_data_mtotal_part_one = mysql_num_rows($result_part_one_2);
	$result_id_part_one2=mysql_query("SELECT account FROM part_one WHERE account = '$id'");
	$num_id__part_one2 = mysql_num_rows($result_id_part_one2);
if($num_id__part_one2 == 0){
$mttdata_part_one = 0;
echo $mttdata_part_one;
}
else{
	if($num_data_mtotal_part_one == "0"){
		$msum_part_one = 0;
		$mcount_part_one = 0;
		$last_sum_part_one +=$msum_part_one;
		$last_count_part_one+=$mcount_part_one;
		}
	else{
	while (list($m_part_one)=mysql_fetch_row($result_part_one_2)){
    $mtstring_part_one = $m_part_one;
	$output_count_mtotal_part_one = substr_count($mtstring_part_one,",");
	$mtoutput_part_one = explode(",", $mtstring_part_one);
	for($j_mtotal_part_one = 0 ; $j_mtotal_part_one<=$output_count_mtotal_part_one ; $j_mtotal_part_one++){
		$msum_part_one += $mtoutput_part_one[$j_mtotal_part_one];
	}
		$mcount_part_one+=($output_count_mtotal_part_one);
	}
	$last_msum_part_one +=$msum_part_one;
	$last_mcount_part_one+=$mcount_part_one;
	$mttdata_part_one = round ($last_msum_part_one / $last_mcount_part_one,2);
	$last_msum_part_one =0;
	$last_mcount_part_one=0;
	}
	}
}
/*---------------------------------------------------------------------------------------------------------------------*/
?>  

                    <tr>
	                  <td align="center" valign="middle" class="info2" >第一部份</td>
	                  <td width="20" align="center">&nbsp;</td>
	                  <td width="80" align="left">平均專心值</td>
	                  <td><? echo $attdata_part_one; ?></td>
	                  <td width="20" align="center" valign="middle">│</td>
	                  <td width="80">平均放鬆值</td>
	                  <td><? echo $mttdata_part_one; ?></td>
	                  <td width="20" align="center">│</td>
	                  <td width="90">最長專注時間</td>
	                  <td><? echo $attime_part_one; ?></td>
	                  <td width="20" align="center">│</td>
	                  <td width="90" height="30">最長放鬆時間</td>
	                  <td><? echo $mttime_part_one; ?></td>
	                  </tr>
	                </table></td>
                </tr>
	            <tr>
	              <td height="30" align="center">&nbsp;</td>
                </tr>
	            <tr>
	              <td align="center"><a name="part_two"></a>
<form id="form1" name="form1" method="post" onsubmit="return Check_submit();" action="student_window.php#part_two">
        <input type="checkbox" id="ck7" name="CheckboxGroup_two[]" value="7" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck7"> Stage 7</label>

        <input type="checkbox" id="ck8" name="CheckboxGroup_two[]" value="8" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck8"> Stage 8</label>

        <input type="checkbox" id="ck9" name="CheckboxGroup_two[]" value="9" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck9">Stage 9</label>

        <input type="checkbox" id="ck10" name="CheckboxGroup_two[]" value="10" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck10">Stage 10</label>

        <input type="checkbox" id="ck11" name="CheckboxGroup_two[]" value="11" class="field checkbox" onchange="handleInput(this);"/>
       <label  class="choice" for="ck11"> Stage 11</label>

        <input type="checkbox" id="ck12" name="CheckboxGroup_two[]" value="12" class="field checkbox" onchange="handleInput(this);"/>
        <label  class="choice" for="ck12">Stage 12</label>
<input name="submit" type="submit" value="Submit" />
        
</form>

<form>
<?
function paint_two($get_num_two,$get_num_two2){
session_start();
$_SESSION['part_two'] = $get_num_two;
$_SESSION['part_two2'] = $get_num_two2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(700, 300, 'part_two_line_data.php?type='));	
}
function paint_two2($get_num_two,$get_num_two2){
session_start();
$_SESSION['part_two'] = $get_num_two;
$_SESSION['part_two2'] = $get_num_two2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(650, 300, 'part_two_line_data_other.php?type='));	
}
function paint_two3($get_num_two,$get_num_two2){
session_start();
$_SESSION['part_two'] = $get_num_two;
$_SESSION['part_two2'] = $get_num_two2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(700, 300, 'part_two_line_data_total.php?type='));	
}
?>
</form>
<?
if( $_POST['CheckboxGroup_two'] == null ){
	$num_two = null;
	$num_two2 = null; 
	echo paint_two3($num_two,$num_two2);	
}
else{
foreach($_POST['CheckboxGroup_two'] as $stage2[]);
if ($stage2[0] == 7 && $stage2[1]==null){
	$num_two = "7";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 8 && $stage2[1]==null){
	$num_two = "8";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 9 && $stage2[1]==null){
	$num_two = "9";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 10 && $stage2[1]==null){
	$num_two = "10";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 11 && $stage2[1]==null){
	$num_two = "11";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 12 && $stage2[1]==null){
	$num_two = "12";
	$num_two2 ="null"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 7 && $stage2[1]==8){
	$num_two = "7";
	$num_two2 ="8"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 7 && $stage2[1]==9){
	$num_two = "7";
	$num_two2 ="9"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 7 && $stage2[1]==10){
	$num_two = "7";
	$num_two2 ="10"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 7 && $stage2[1]==11){
	$num_two = "7";
	$num_two2 ="11"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 7 && $stage2[1]==12){
	$num_two = "7";
	$num_two2 ="12"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 8 && $stage2[1]==9){
	$num_two = "8";
	$num_two2 ="9"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 8 && $stage2[1]==10){
	$num_two = "8";
	$num_two2 ="10"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 8 && $stage2[1]==11){
	$num_two = "8";
	$num_two2 ="11"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 8 && $stage2[1]==12){
	$num_two = "8";
	$num_two2 ="12"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 9 && $stage2[1]==10){
	$num_two = "9";
	$num_two2 ="10"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 9 && $stage2[1]==11){
	$num_two = "9";
	$num_two2 ="11"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 9 && $stage2[1]==12){
	$num_two = "9";
	$num_two2 ="12"; 
	echo paint_two2($num_two,$num_two2);	
	}
else if ($stage2[0] == 10 && $stage2[1]==11){
	$num_two = "10";
	$num_two2 ="11"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 10 && $stage2[1]==12){
	$num_two = "10";
	$num_two2 ="12"; 
	echo paint_two($num_two,$num_two2);	
	}
else if ($stage2[0] == 11 && $stage2[1]==12){
	$num_two = "11";
	$num_two2 ="12"; 
	echo paint_two($num_two,$num_two2);	
	}
}
?>
                  </td>
                </tr>
	            <tr>
	              <td align="center" bgcolor="#FFCC99"><table border="0" cellspacing="0" cellpadding="0">
	                <?
/*文字數值*/ 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_two=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_two Where account ='$id'");
		while (list($a_part_two,$m_part_two)=mysql_fetch_row($result_time_part_two)){
			$attime_part_two  = $a_part_two;
			$mttime_part_two  = $m_part_two;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
/*第二部分專心 and 放鬆*/
$days_array_part_two = array();
	/*抓取日期資料筆數*/
	$date_data_part_two = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_part_two = mysql_num_rows($date_data_part_two);
	/*抓出來的日期丟到陣列內*/
	for($i_part_two = 0 ;$i_part_two<$num_date_rows_part_two;$i_part_two++){
	while (list($day_part_two)=mysql_fetch_array($date_data_part_two)){
	$days_part_two[] = $day_part_two;
	}
	/*日期陣列*/
	array_push($days_array_part_two,$days_part_two[$i_part_two]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal_part_two = 0 ;$k_atotal_part_two<$num_date_rows_part_two;$k_atotal_part_two++){
	$asum_part_two = 0;
	$acount_part_two = 0;
	$atsum_part_two = 0;
	$day_atotal_part_two = $days_array_part_two[$k_atotal_part_two];
	$result_part_two=mysql_query("SELECT attention FROM total_data WHERE (stage = 8 or stage = 9 or stage = 11 or stage = 12) and account = '$id'");
	$num_data_atotal_part_two = mysql_num_rows($result_part_two);
	$result_id_part_two=mysql_query("SELECT account FROM part_two WHERE account = '$id'");
	$num_id__part_two = mysql_num_rows($result_id_part_two);
if($num_id__part_two == 0){
$attdata_part_two = 0;
echo $attdata_part_two;
}
else{
	if($num_data_atotal_part_two == "0"){
		$asum_part_two = 0;
		$acount_part_two = 0;
		$last_asum_part_two +=$asum_part_two;
		$last_acount_part_two+=$acount_part_two;
		}
	else{
	while (list($a_part_two)=mysql_fetch_row($result_part_two)){
    $atstring_part_two = $a_part_two;
	$output_count_atotal_part_two = substr_count($atstring_part_two,",");
	$atoutput_part_two = explode(",", $atstring_part_two);
	for($j_atotal_part_two = 0 ; $j_atotal_part_two<=$output_count_atotal_part_two ; $j_atotal_part_two++){
		$asum_part_two += $atoutput_part_two[$j_atotal_part_two];
	}
		$acount_part_two+=($output_count_atotal_part_two);
	}
	$last_asum_part_two +=$asum_part_two;
	$last_acount_part_two+=$acount_part_two;
	$attdata_part_two = round ($last_asum_part_two / $last_acount_part_two,2);
	$last_asum_part_two =0;
	$last_acount_part_two=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_two = 0 ;$k_mtotal_part_two<$num_date_rows_part_two;$k_mtotal_part_two++){
	$msum_part_two = 0;
	$mcount_part_two = 0;
	$mtsum_part_two = 0;
	$day_mtotal_mtotal = $days_array_part_two[$k_mtotal_part_two];
	$result_part_two_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 7 or stage = 9 or stage = 10 or stage = 12) and account = '$id'");
	$num_data_mtotal_part_two = mysql_num_rows($result_part_two_2);
	$result_id_part_two2=mysql_query("SELECT account FROM part_two WHERE account = '$id'");
	$num_id__part_two2 = mysql_num_rows($result_id_part_two2);
if($num_id__part_two2== 0){
$mttdata_part_two = 0;
echo $mttdata_part_two;
}
else{
	if($num_data_mtotal_part_two == "0"){
		$msum_part_two = 0;
		$mcount_part_two = 0;
		$last_sum_part_two +=$msum_part_two;
		$last_count_part_two+=$mcount_part_two;
		}
	else{
	while (list($m_part_two)=mysql_fetch_row($result_part_two_2)){
    $mtstring_part_two = $m_part_two;
	$output_count_mtotal_part_two = substr_count($mtstring_part_two,",");
	$mtoutput_part_two = explode(",", $mtstring_part_two);
	for($j_mtotal_part_two = 0 ; $j_mtotal_part_two<=$output_count_mtotal_part_two ; $j_mtotal_part_two++){
		$msum_part_two += $mtoutput_part_two[$j_mtotal_part_two];
	}
		$mcount_part_two+=($output_count_mtotal_part_two);
	}
	$last_msum_part_two +=$msum_part_two;
	$last_mcount_part_two+=$mcount_part_two;
	$mttdata_part_two = round ($last_msum_part_two / $last_mcount_part_two,2);
	$last_msum_part_two =0;
	$last_mcount_part_two=0;
	}
	}
}
/*---------------------------------------------------------------------------------------------------------------------*/
?>  
                    <tr>
	                  <td align="center" valign="middle" class="info2" >第二部份</td>
	                  <td width="20" align="center">&nbsp;</td>
	                  <td width="80" align="left">平均專心值</td>
	                  <td><? echo $attdata_part_two; ?></td>
	                  <td width="20" align="center" valign="middle">│</td>
	                  <td width="80">平均放鬆值</td>
	                  <td><? echo $mttdata_part_two; ?></td>
	                  <td width="20" align="center">│</td>
	                  <td width="90">最長專注時間</td>
	                  <td><? echo $attime_part_two; ?></td>
	                  <td width="20" align="center">│</td>
	                  <td width="90" height="30">最長放鬆時間</td>
	                  <td><? echo $mttime_part_two; ?></td>
	                  </tr>
	                </table></td>
                </tr>
	            <tr>
	              <td height="30" align="center">&nbsp;</td>
                </tr>
	            <tr>
	              <td align="center"><img src="img/login/infographic/infographic-03.jpg" alt="" width="737" height="369"><br></td>
                </tr>
	            <tr>
	              <td align="center" bgcolor="#FFCC99"><table border="0" cellspacing="0" cellpadding="0">
	                <tr>
	                  <td align="center" valign="middle" class="info2" >第三部份</td>
	                  <td width="20" align="center">&nbsp;</td>
	                  <td width="80" align="left">平均專心值</td>
	                  <td>51.22</td>
	                  <td width="20" align="center" valign="middle">│</td>
	                  <td width="80">平均放鬆值</td>
	                  <td>51.22</td>
	                  <td width="20" align="center">│</td>
	                  <td width="90">最長專注時間</td>
	                  <td>51.22</td>
	                  <td width="20" align="center">│</td>
	                  <td width="90" height="30">最長放鬆時間</td>
	                  <td>51.22</td>
	                  </tr>
	                </table></td>
                </tr>
	            <tr>
	              <td height="30" align="center">&nbsp;</td>
                </tr>
	            <tr>
	              <td align="center"><img src="img/login/infographic/infographic-06.jpg" alt="" width="737" height="370"><br></td>
                </tr>
	            <tr>
	              <td align="center" bgcolor="#FFCC99"><table border="0" cellspacing="0" cellpadding="0">
	                <tr>
	                  <td align="center" valign="middle" class="info2" >第四部份</td>
	                  <td width="20" align="center">&nbsp;</td>
	                  <td width="80" align="left">平均專心值</td>
	                  <td>51.22</td>
	                  <td width="20" align="center" valign="middle">│</td>
	                  <td width="80">平均放鬆值</td>
	                  <td>51.22</td>
	                  <td width="20" align="center">│</td>
	                  <td width="90">最長專注時間</td>
	                  <td>51.22</td>
	                  <td width="20" align="center">│</td>
	                  <td width="90" height="30">最長放鬆時間</td>
	                  <td>51.22</td>
	                  </tr>
	                </table></td>
                </tr>
              </table>
	        </div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td height="50" align="right" valign="middle"><a href="#top"><img src="photo/top-05.png" alt="" width="33" height="15" border="0"></a></td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#fbf074"><span class="menuwhite"><br>
	              <a name="F"></a>綜<br>
	              合<br>
	              分<br>
	              析<br>
	              <br>
                </span></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#fbf074 #fbf074 #fbf074 #fbf074;padding:20px 20px 20px 20px; background-color:#FFF" >
	          <table border="0" align="center" cellpadding="0" cellspacing="0">
	            <tr>
	              <td valign="top">
				  <? 
				  echo(chart_str(400, 500, 'part_one_pie_att_data.php?type='));
				  ?>
                  </td>
	              <td>&nbsp;</td>
	              <td width="30">
                  <?
                  echo(chart_str(400, 500, 'part_one_pie_rex_data.php?type='));
				  ?>
                  </td>
                </tr>
	            <tr>
	              <td colspan="3" valign="top">&nbsp;</td>
                </tr>
	            <tr>
	              <td colspan="3" valign="top"><span class="text">總評</span>
                  <?
$amttdata = abs($attdata_pie-$mttdata_pie);
if($amttdata <=20){
	if(($attdata_pie >= 0 and $attdata_pie < 20) and ($mttdata_pie >= 0 and $mttdata_pie < 20)){
		$output = "<img src=\"../index/photo/star-01.png\" width=\"20\" high=\"20\" align=\"middle\"/>";
		print($output);
	}
		else if(($attdata_pie >= 20 and $attdata_pie < 40) and ($mttdata_pie >= 20 and $mttdata_pie < 40)){
		$output = "<img src=\"../index/photo/star-02.png\" width=\"45\"  high=\"21\" align=\"middle\"/>";
		print($output);
	}
		else if(($attdata_pie >= 40 and $attdata_pie < 60) and ($mttdata_pie >= 40 and $mttdata_pie < 60)){
		$output = "<img src=\"../index/photo/star-03.png\" width=\"69\"  high=\"21\" align=\"middle\"/>";
		print($output);
	}
		else if(($attdata_pie >= 60 and $attdata_pie < 80) and ($mttdata_pie >= 60 and $mttdata_pie < 80)){
		$output = "<img src=\"../index/photo/star-04.png\" width=\"94\"  high=\"21\" align=\"middle\"/>";
		print($output);
	}
		else if(($attdata_pie >= 80 and $attdata_pie <= 100) and ($mttdata_pie >= 80 and $mttdata_pie <= 100)){
		$output = "<img src=\"../index/photo/star-05.png\" width=\"118\"  high=\"21\" align=\"middle\"/>";
		print($output);
	}
	else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 20){
			$output = "<img src=\"../index/photo/star-01.png\" width=\"20\"  high=\"20\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 20 and $mttdata_pie < 40){
			$output = "<img src=\"../index/photo/star-02.png\" width=\"45\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 40 and $mttdata_pie < 60){
			$output = "<img src=\"../index/photo/star-03.png\" width=\"69\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 60 and $mttdata_pie < 80){
			$output = "<img src=\"../index/photo/star-04.png\" width=\"94\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 80 and $mttdata_pie <= 100){
			$output = "<img src=\"../index/photo/star-05.png\" width=\"118\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
		}
		else if($mttdata_pie>$attdata_pie){
			if($attdata_pie >= 0 and $attdata_pie < 20){
			$output = "<img src=\"../index/photo/star-01.png\" width=\"20\"  high=\"20\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 20 and $attdata_pie < 40){
			$output = "<img src=\"../index/photo/star-02.png\" width=\"45\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 40 and $attdata_pie < 60){
			$output = "<img src=\"../index/photo/star-03.png\" width=\"69\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 60 and $attdata_pie < 80){
			$output = "<img src=\"../index/photo/star-04.png\" width=\"94\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 80 and $attdata_pie <= 100){
			$output = "<img src=\"../index/photo/star-05.png\" width=\"118\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
		}
	}
}


else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 20){
			$output = "<img src=\"../index/photo/star-01.png\" width=\"20\"  high=\"20\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 20 and $mttdata_pie < 40){
			$output = "<img src=\"../index/photo/star-02.png\" width=\"45\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 40 and $mttdata_pie < 60){
			$output = "<img src=\"../index/photo/star-03.png\" width=\"69\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 60 and $mttdata_pie < 80){
			$output = "<img src=\"../index/photo/star-04.png\" width=\"94\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($mttdata_pie >= 80 and $mttdata_pie <= 100){
			$output = "<img src=\"../index/photo/star-05.png\" width=\"118\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
		}
		else if($mttdata_pie>$attdata_pie){
			if($attdata_pie >= 0 and $attdata_pie < 20){
			$output = "<img src=\"../index/photo/star-01.png\" width=\"20\"  high=\"20\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 20 and $attdata_pie < 40){
			$output = "<img src=\"../index/photo/star-02.png\" width=\"45\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 40 and $attdata_pie < 60){
			$output = "<img src=\"../index/photo/star-03.png\" width=\"69\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 60 and $attdata_pie < 80){
			$output = "<img src=\"../index/photo/star-04.png\" width=\"94\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
			else if($attdata_pie >= 80 and $attdata_pie <= 100){
			$output = "<img src=\"../index/photo/star-05.png\" width=\"118\"  high=\"21\" align=\"middle\"/>";
			print($output);
			}
		}
}
				  ?>
                  </td>
                </tr>
	            <tr>
	              <td colspan="3" valign="top">&nbsp;</td>
                </tr>
	            <tr>
	              <td colspan="3" valign="top">老師的建議<a name="qa"></a></td>
                </tr>
                 <tr>
	              <td>&nbsp;</td>
                </tr>
	            <tr>
	              <td height="50" colspan="3" valign="top">
                      <?php if ($totalRows_gbookshow > 0) { // Show if recordset not empty ?>
    <?php do { ?>
        <table width="440"  border="0" cellpadding="7" cellspacing="0" class="gtable">
        <tr>
          <td colspan="2"style="color:#00a9a1;font-size:14px;"><b>留言內容：</b>
          <b style="color:#00a9a1;font-size:12px;">時間:<?php echo $row_gbookshow['time']; ?></b></td>
        </tr>
        <tr>
          <td colspan="2"><?php echo $row_gbookshow['gcomment']; ?>
            </td>
         </tr>
         <tr>
         <td>
         <?php if($row_gbookshow['check_qa']==1){?>
         <div class="re">
         <b style="color:#00a9a1;font-size:14px;">回應：</b>
         <b style="color:#00a9a1;font-size:12px;">時間:<?php echo $row_gbookshow['time']; ?></b><br />
         </div>
         </td>
         </tr>
         <tr>
         <td>
          <?php echo $row_gbookshow['gre'];?>
         </td>
         </tr>
         <?php } else{?>
         <tr>
         <td>
         <div class="re">
         <b style="color:#00a9a1;font-size:14px;">回應：</b>
         <br />
         </div>
         </td>
         </tr>
         <tr>
         <td>
          老師尚未回應
         </td>
         </tr>
         <?php }?>
        </table>
      <br>
      <?php } while ($row_gbookshow = mysql_fetch_assoc($gbookshow)); ?>
      <table width="440" border="0">
        <tr>
          <td align="center">
          目前顯示筆數為 <?php echo ($startRow_gbookshow + 1) ?> ～ <?php echo min($startRow_gbookshow + $maxRows_gbookshow, $totalRows_gbookshow) ?> (共 <?php echo $totalRows_gbookshow ?>筆)&nbsp;
          </td>
        </tr>
        <tr>
          <td align="center">
            <?php if ($pageNum_gbookshow > 0) { // Show if not first page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, 0, $queryString_gbookshow); ?>#qa">第一頁</a>
              <?php } // Show if not first page ?>      <?php if ($pageNum_gbookshow > 0) { // Show if not first page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, max(0, $pageNum_gbookshow - 1), $queryString_gbookshow); ?>#qa">上一頁</a>　
              <?php } // Show if not first page ?>      <?php if ($pageNum_gbookshow < $totalPages_gbookshow) { // Show if not last page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, min($totalPages_gbookshow, $pageNum_gbookshow + 1), $queryString_gbookshow); ?>#qa">下一頁</a>　
              <?php } // Show if not last page ?>      <?php if ($pageNum_gbookshow < $totalPages_gbookshow) { // Show if not last page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, $totalPages_gbookshow, $queryString_gbookshow); ?>#qa">最後頁</a>　
              <?php } // Show if not last page ?>      </td>
        </tr>
      </table>  
<?php } // Show if recordset not empty ?>
      <br />
       <?php if ($totalRows_gbookshow == 0) { // Show if recordset empty ?>
        <div align="center">無任何留言</div>
      <?php } // Show if recordset empty ?></td>
	    </tr>
	          </table>
</div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td height="50" align="right" valign="middle"><a href="#top"><img src="photo/top-05.png" alt="" width="33" height="15" border="0"></a></td>
  </tr>
</table>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" align="center" valign="middle"><span class="info">兆豐文創有限公司               / 404   北區 博館路89號6樓之2                     / tel. 04-23292926                   / fax. 04-23922875 </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($gbookshow);
?>