<?php
session_start();
$teacher_id = $_SESSION['MM_Teacher'];
$qa = $_SESSION['NameQA'];
$qa2 = $_SESSION['NameQA2'];

$AA = 0;
$AB = 0;
$AC = 0;
$AD = 0;
$AE = 0;
$RA = 0;
$RB = 0;
$RC = 0;
$RD = 0;
$RE = 0;
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
$query_user_data = "SELECT Account,User_name FROM user_data WHERE Cram = (Select Cram From teacher_data Where Account = '$teacher_id')";
$student_data = mysql_query($query_user_data, $localhost) or die(mysql_error());
$row_user_data = mysql_fetch_assoc($student_data);

mysql_select_db($database_localhost, $localhost);
$query_qa_data = "SELECT Account,User_name FROM user_data WHERE Cram = (Select Cram From teacher_data Where Account = '$teacher_id')";
$qa_data = mysql_query($query_qa_data, $localhost) or die(mysql_error());
$row_qa_data = mysql_fetch_assoc($qa_data);

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
/*學生查詢*/
$studentFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['student_name'])) {
  $postdate=$_POST['student_name'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "teacher.php#C";
  $MM_redirecttoReferrer = false;
  if (true) {
	if (false) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['Name'] = $postdate;    
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
}
/*留言*/
$studentQAFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['student_name_QA'])) {
  $qadate=$_POST['student_name_QA'];
  $result_name_qa=mysql_query("SELECT User_name FROM user_data Where Account ='$qadate'");
while (list($nqa)=mysql_fetch_row($result_name_qa)){
$name_qa  = $nqa;
$_SESSION['NameQA2'] = $name_qa;
	}
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "teacher.php#E";
  $MM_redirecttoReferrer = false;
  if (true) {
	if (false) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['NameQA'] = $qadate;    
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
}
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
  $_SESSION['MM_Teacher'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['NameQA']= NULL;
  $_SESSION['NameQA2']= NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Teacher']);
  unset($_SESSION['NameQA']);
  unset($_SESSION['NameQA2']);
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


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE qa SET gre=%s ,check_qa=%s ,retime = now()WHERE no=%s",
                       GetSQLValueString($_POST['re'], "text"),
					   GetSQLValueString("1", "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "teacher.php#E";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_reGbok = "-1";
if (isset($_GET['id'])) {
  $colname_reGbok = $_GET['id'];
}
mysql_select_db($database_localhost, $localhost);
$query_reGbok = sprintf("SELECT no, gre FROM qa WHERE check_qa = 0 and Teac = '$teacher_id' and Account = '$qa' ORDER BY no DESC");
$reGbok = mysql_query($query_reGbok, $localhost) or die(mysql_error());
$row_reGbok = mysql_fetch_assoc($reGbok);
$totalRows_reGbok = mysql_num_rows($reGbok);

$maxRows_gbookshow = 5;
$pageNum_gbookshow = 0;
if (isset($_GET['pageNum_gbookshow'])) {
  $pageNum_gbookshow = $_GET['pageNum_gbookshow'];
}
$startRow_gbookshow = $pageNum_gbookshow * $maxRows_gbookshow;
$qa = $_SESSION['NameQA'];
mysql_select_db($database_localhost, $localhost);
$query_gbookshow = "SELECT * FROM qa WHERE Teac = '$teacher_id' and Account = '$qa' ORDER BY no DESC";
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
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<title>兆豐文創 Harvest Education</title>
<style type="text/css">

<!--
a { text-decoration: none } 
a:link {color: #333}
a:visited {color:333}
a:active {color:#333}
a:hover {color: #666
}

a:hover img{
 opacity: 0.55;
 filter:alpha(opacity=55); /* IE only */}
-->

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-bottom: 0px;
	background-image: url(photo/7.png);
	background-repeat: repeat;
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
	color:#FFF;
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
.more {	font-style:oblique ;font-size:10pt; font-family: Georgia, "Times New Roman", Times, serif; line-height:18pt; color:#464141; font-weight:500; letter-spacing:1pt;
}
.info1 {font-size:10pt; color:#333; #; font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial, sans-serif; line-height:12pt; letter-spacing:1px;
}
.chtitle {
	font-size:17px;
	color:#333;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
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

.menuwhite{
	font-size:15px;
	color:#FFF;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:18px;
}

.title {	font-size:25px;
	color: #CCC;
#; 	font-family:Georgia, "Times New Roman", Times, serif;
	letter-spacing:1px;
	font-style: italic;
}
.menu {
	text-align: right;
	color: #333;
}

.rd {
　position:absolute; 
    background-color:#FFFFFF;/*位置、底色*/
　width:950px;/*寬度、高度*/
　border-top:solid 5px #00aca4;/*上邊框樣式、寬度、顏色*/
　border-bottom:double 5px #00aca4;/*下邊框樣式、寬度、顏色*/
　border-left:groove 5px #00aca4;/*左邊框樣式、寬度、顏色*/
　border-right:outset 5px #00aca4;/*右邊框樣式、寬度、顏色*/
　top:500px; left:50px;
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
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<link rel="shortcut icon" href="icon/favicon.ico" >
<link rel="Bookmark" href="icon/favicon.ico" type="image/x-icon" />
<style type="text/css">
.boxtitle {	font-size:15px;
	color: #000;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
}
</style>
<link rel="shortcut icon" href="icon/favicon.ico" >
<link rel="Bookmark" href="icon/favicon.ico" type="image/x-icon" />
<style type="text/css">
.menu1 {	font-size:15px;
	color:#333;
	font-family:Helvetica, Microsoft JhengHei, Apple LiGothic, Arial,  sans-serif;
	letter-spacing:1px;
	font-style: normal;
	line-height:20px;
}
.menu1 {	text-align: right;
}
</style>

<style type="text/css">
<!--
@import url("teacher_table_style.css");
-->
.classname {
	-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
	-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
	box-shadow:inset 0px 1px 0px 0px #ffffff;
	background-color:transparent;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #00a9a1;
	display:inline-block;
	color:#00a9a1;
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

<style>
.gtable{border:solid 3px #00a9a1; font-size:12px;
margin-top:30px;
}
.gtable tr td{border-bottom:solid 1px #00a9a1; padding:7px;}
</style>
</head>
<script type="text/javascript" src="select2css.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="goto.js"></script>
<script language="javascript">function fromcheck(){
if (form1_1.student_name.value=="null"){    alert("請選擇");    
form1_1.student_name.focus();    return false;   }      
return true;    }</script>
<script language="javascript">function fromcheck2(){
if (form4.student_name_QA.value=="null"){    alert("請選擇");    
form4.student_name_QA.focus();    return false;   }      
return true;    }</script>

<script language="javascript">function fromcheck3(){
if (form1.re.value==""){    alert("請輸入你想回答的內容");    
form1.re.focus();    return false;   }      
return true;    }</script>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="32" align="right" valign="middle" bgcolor="#02aba8" ><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" valign="middle"><span class="brown"><a href="teacher.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image13','','photo/home2.png',1)"><img src="photo/home.png" name="Image13" height="12" border="0"></a>　<a href="<?php echo $logoutAction ?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image12','','photo/logout2.png',1)"><img src="photo/logout.png" name="Image12" width="64" height="12" border="0"></a></span></td>
        <td width="10">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	    <td width="950"><table width="950" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="159" rowspan="3"><br>	          <img src="photo/teacher.png" height="200" border="0"></td>
	        <td width="791" height="30"><p>&nbsp;</p>
            <p>&nbsp;</p></td>
          </tr>
	      <tr>
	        <td><span class="chtitle">老師 <span class="entitle">Teacher<br>
	          </span></span>
	          <hr>
	          <span class="chtitle"><span class="entitle"> </span></span></td>
          </tr>
	      <tr>
	        <td align="right" valign="top" class="menu" ><span class="menu1"><a href="#" class="menu1" id="toI">教育訓練</a></a>│<a href="#" id="toJ" class="menu1">全班成績單</a>│<a href="#" id="toK" class="menu1">個人專注 / 放鬆表現</a>│<a href="#" id="toL" class="menu1">輔助音樂</a>│<a href="#" id="toM" class="menu1">個別追蹤</a></span></span></span></span></td>
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
	            <td width="35" align="center" valign="middle" bgcolor="#00a9a1"><span class="menuwhite"><a name="A"><div id="I_class"></div></a><br>
	              教<br>
育<br>
訓<br>
練<br>
<br>
	            </span></td>
              </tr>
            </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#00a9a1 #00a9a1 #00a9a1 #00a9a1;padding:20px 20px 20px 20px; background-color:#FFF" > 
	          <table width="800" border="0" cellpadding="0" cellspacing="0">
	            <tr>
	              <td width="640" valign="top">歡迎你使用放鬆訓練程式，這訓練程式主要幫助你學習更有效的放鬆方法，使你能在緊張的生活中，掌握放鬆的技巧，提升工作效率，最重要的是能夠調和身心，使自己生活得更快樂和健康。<br>
	                <br>
	                這訓練程式，是配合腦波放鬆燈一起使用，腦波放鬆燈能即時反映出你的放鬆狀態，使用者透過腦波放鬆燈的顏色，得知自己的狀態的同時，大腦更能夠自動調整身心的狀態和記憶平靜放鬆的內在感覺。當放鬆的感覺能有效地被認知後，這個放鬆的感覺，便自自然然地內化到我們的身心內，成為我們能力的一部份。當我們需要提取放鬆的能力時，就好像一個熟練的打字員一樣，能夠不經思考，就能把文字打出來。從此我們便能自由地掌控和提取放鬆和平靜的能力。<br>
	                <br>
	                人是習慣的動物。研究表明，每天都參與訓練的人，比那些一星期只參與訓練六天的人，效果高三倍，同時一星期只參與訓練三或四或五天的人，效果更高達五倍之多。因此，如果你想有最好的效果，只要認真地跟著放鬆訓練程式去練習，你的放鬆能力必定會大大提升。如果你錯過了一天，只需要在第二天重新開始就可以了。簡單而言，每天大約用十五至三十分鐘，給自己一個機會，訓練自己成為放鬆的大師。</td>
	              <td width="30" align="center" valign="middle"><img src="photo/line2.png" width="1" height="220"></td>
	              <td width="230" valign="top"><span class="boxtitle">看得見的情緒</span><br>
	                <br>
	                隨著放鬆程度的增強，<br>
	                顏色由黃色轉變到紫色。<br>
	                反之，隨著專注程度的增強，<br>
	                顏色由黃色轉變到藍色。 <br>
	                <br>
	                <p><img src="photo/color.png" alt="" width="230"></p></td>
                </tr>
	            <tr>
	              <td height="30" colspan="3" valign="middle"><img src="photo/line2.png" alt="" width="850" height="1"></td>
                </tr>
	            <tr>
	              <td colspan="3" valign="top">老師教學重點<br></td>
                </tr>
              </table>
	          <p><br>
	            <br>
	          </p>
	          <p><br>
	            <br>
              </p>
	        </div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td height="50"></td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#00a9a1"><div id="J_class"></div><p class="menuwhite"><a name="B"></a><br>
	              全<br>
	              班<br>
	              成<br>
	              績<br>
	              單<br>
	              <br>
                </p></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#00a9a1 #00a9a1 #00a9a1 #00a9a1; padding:20px 20px 20px 20px; background-color:#FFF; text-align: center;" >
	          <table border="0" cellspacing="0" cellpadding="0">
	            <tr>
	              <td>
<div id="Table_Location">
<div id="Table_Title">
<p></p>
<p>腦波教室-全班成績單</p>
</div>
<table id="Transcript" align="center" width="875" border="0" cellspacing="0">   
    <tr>
		<th class="title-style_1" width="110">姓名</th>
        <th class="title-style2_1" width="65.5">第一</th>
        <th class="title-style2_2" width="65.5">部分</th>
		<th class="title-style3_1" width="65.5">第二</th>
        <th class="title-style3_2" width="65.5">部分</th>
        <th class="title-style2_1" width="65.5">第三</th>
        <th class="title-style2_2" width="65.5">部分</th>
        <th class="title-style3_1" width="65.5">第四</th>
        <th class="title-style3_2" width="65.5">部分</th>
        <th class="title-style2_1" width="65.5">綜合</th>
        <th class="title-style2_2" width="65.5">分析</th>
        <th class="title-style_2" width="110">期末成績</th>
	</tr>
    <tr>
		<th class="title-style4" width="110">專注/放鬆</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
		<th class="title-style6" width="65.5">專注</th>
        <th class="title-style6" width="65.5">放鬆</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
        <th class="title-style6" width="65.5">專注</th>
        <th class="title-style6" width="65.5">放鬆</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
        <th class="title-style6" width="110">&nbsp;</th>
	</tr>
<?
require("Connections/conndb.php");
	$account_array_pie = array();
	/*老師是哪一間補習班*/
	$teacher_cram = mysql_query("SELECT Cram FROM teacher_data WHERE Account ='$teacher_id'");
	while (list($TC)=mysql_fetch_array($teacher_cram)){
	$Cram = $TC;
	}
	/*抓取帳號資料筆數*/
	$account_data_pie = mysql_query("SELECT account FROM user_data Where  Cram = '$Cram' order by User_name");
	/*帳號有幾筆*/
	$num_account_rows_pie = mysql_num_rows($account_data_pie);
	/*抓出來的帳號丟到陣列內*/
	for($account_i_pie = 0 ;$account_i_pie<$num_account_rows_pie;$account_i_pie++){
	while (list($account_pie)=mysql_fetch_array($account_data_pie)){
	$accounts_pie[] = $account_pie;
	}
	/*帳號陣列*/
	array_push($account_array_pie,$accounts_pie[$account_i_pie]);
	}
if($num_account_rows_pie!=0){

for($account_num = 0 ;$account_num<$num_account_rows_pie;$account_num++){
	$id = $account_array_pie[$account_num];
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
/*第三部分專心 and 放鬆*/
$days_array_part_three = array();
	/*抓取日期資料筆數*/
	$date_data_part_three = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_part_three = mysql_num_rows($date_data_part_three);
	/*抓出來的日期丟到陣列內*/
	for($i_part_three = 0 ;$i_part_three<$num_date_rows_part_three;$i_part_three++){
	while (list($day_part_three)=mysql_fetch_array($date_data_part_three)){
	$days_part_three[] = $day_part_three;
	}
	/*日期陣列*/
	array_push($days_array_part_three,$days_part_three[$i_part_three]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal_part_three = 0 ;$k_atotal_part_three<$num_date_rows_part_three;$k_atotal_part_three++){
	$asum_part_three = 0;
	$acount_part_three = 0;
	$atsum_part_three = 0;
	$day_atotal_part_three = $days_array_part_three[$k_atotal_part_three];
	$result_part_three=mysql_query("SELECT attention FROM total_data WHERE (stage = 14 or stage = 15 or stage = 17 or stage = 18) and account = '$id'");
	$num_data_atotal_part_three = mysql_num_rows($result_part_three);
	$result_id_part_three=mysql_query("SELECT account FROM part_three WHERE account = '$id'");
	$num_id__part_three = mysql_num_rows($result_id_part_three);
if($num_id__part_three== 0){
$attdata_part_three = 0;
}
else{
	if($num_data_atotal_part_three == "0"){
		$asum_part_three = 0;
		$acount_part_three = 0;



		$last_asum_part_three +=$asum_part_three;
		$last_acount_part_three+=$acount_part_three;
		}
	else{
	while (list($a_part_three)=mysql_fetch_row($result_part_three)){
    $atstring_part_three = $a_part_three;
	$output_count_atotal_part_three = substr_count($atstring_part_three,",");
	$atoutput_part_three = explode(",", $atstring_part_three);
	for($j_atotal_part_three = 0 ; $j_atotal_part_three<=$output_count_atotal_part_three ; $j_atotal_part_three++){
		$asum_part_three += $atoutput_part_three[$j_atotal_part_three];
	}
		$acount_part_three+=($output_count_atotal_part_three);
	}
	$last_asum_part_three +=$asum_part_three;
	$last_acount_part_three+=$acount_part_three;
	
	$attdata_part_three = round ($last_asum_part_three / $last_acount_part_three,2);
	$last_asum_part_three =0;
	$last_acount_part_three=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_three = 0 ;$k_mtotal_part_three<$num_date_rows_part_three;$k_mtotal_part_three++){
	$msum_part_three = 0;
	$mcount_part_three = 0;
	$mtsum_part_three = 0;
	$day_mtotal_mtotal = $days_array_part_three[$k_mtotal_part_three];
	$result_part_three_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 13 or stage = 15 or stage = 16 or stage = 18) and account = '$id'");
	$num_data_mtotal_part_three = mysql_num_rows($result_part_three_2);
	$result_id_part_three2=mysql_query("SELECT account FROM part_three WHERE account = '$id'");
	$num_id__part_three2 = mysql_num_rows($result_id_part_three2);
if($num_id__part_three2 == 0){
$mttdata_part_three = 0;
}
else{
	if($num_data_mtotal_part_three == "0"){
		$msum_part_three = 0;
		$mcount_part_three = 0;
		$last_sum_part_three +=$msum_part_three;
		$last_count_part_three+=$mcount_part_three;
		}
	else{
	while (list($m_part_three)=mysql_fetch_row($result_part_three_2)){
    $mtstring_part_three = $m_part_three;
	$output_count_mtotal_part_three = substr_count($mtstring_part_three,",");
	$mtoutput_part_three = explode(",", $mtstring_part_three);
	for($j_mtotal_part_three = 0 ; $j_mtotal_part_three<=$output_count_mtotal_part_three ; $j_mtotal_part_three++){
		$msum_part_three += $mtoutput_part_three[$j_mtotal_part_three];
	}
		$mcount_part_three+=($output_count_mtotal_part_three);
	}
	$last_msum_part_three +=$msum_part_three;
	$last_mcount_part_three+=$mcount_part_three;
	$mttdata_part_three = round ($last_msum_part_three / $last_mcount_part_three,2);
	$last_msum_part_three =0;
	$last_mcount_part_three=0;
	}
}
}
/*---------------------------------------------------------------------------------------------------------------------*/
/*第四部分專心 and 放鬆*/
$days_array_part_four = array();
	/*抓取日期資料筆數*/
	$date_data_part_four = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_part_four = mysql_num_rows($date_data_part_four);
	/*抓出來的日期丟到陣列內*/
	for($i_part_four = 0 ;$i_part_four<$num_date_rows_part_four;$i_part_four++){
	while (list($day_part_four)=mysql_fetch_array($date_data_part_four)){
	$days_part_four[] = $day_part_four;
	}
	/*日期陣列*/
	array_push($days_array_part_four,$days_part_four[$i_part_four]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal_part_four = 0 ;$k_atotal_part_four<$num_date_rows_part_four;$k_atotal_part_four++){
	$asum_part_four = 0;
	$acount_part_four = 0;
	$atsum_part_four = 0;
	$day_atotal_part_four = $days_array_part_four[$k_atotal_part_four];
	$result_part_four=mysql_query("SELECT attention FROM total_data WHERE (stage = 20 or stage = 21) and account = '$id'");
	$num_data_atotal_part_four = mysql_num_rows($result_part_four);
	$result_id_part_four=mysql_query("SELECT account FROM part_four WHERE account = '$id'");
	$num_id__part_four = mysql_num_rows($result_id_part_four);
if($num_id__part_four== 0){
$attdata_part_four = 0;
}
else{
	if($num_data_atotal_part_four == "0"){
		$asum_part_four = 0;
		$acount_part_four = 0;
		$last_asum_part_four +=$asum_part_four;
		$last_acount_part_four+=$acount_part_four;
		}
	else{
	while (list($a_part_four)=mysql_fetch_row($result_part_four)){
    $atstring_part_four = $a_part_four;
	$output_count_atotal_part_four = substr_count($atstring_part_four,",");
	$atoutput_part_four = explode(",", $atstring_part_four);
	for($j_atotal_part_four = 0 ; $j_atotal_part_four<=$output_count_atotal_part_four ; $j_atotal_part_four++){
		$asum_part_four += $atoutput_part_four[$j_atotal_part_four];
	}
		$acount_part_four+=($output_count_atotal_part_four);
	}
	$last_asum_part_four +=$asum_part_four;
	$last_acount_part_four+=$acount_part_four;
	$attdata_part_four = round ($last_asum_part_four / $last_acount_part_four,2);
	$last_asum_part_four =0;
	$last_acount_part_four=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_four = 0 ;$k_mtotal_part_four<$num_date_rows_part_four;$k_mtotal_part_four++){
	$msum_part_four = 0;
	$mcount_part_four = 0;
	$mtsum_part_four = 0;
	$day_mtotal_mtotal = $days_array_part_four[$k_mtotal_part_four];
	$result_part_four_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 19 or stage = 21) and account = '$id'");
	$num_data_mtotal_part_four = mysql_num_rows($result_part_four_2);
	$result_id_part_four2=mysql_query("SELECT account FROM part_four WHERE account = '$id'");
	$num_id__part_four2 = mysql_num_rows($result_id_part_four2);
if($num_id__part_four2== 0){
$mttdata_part_four = 0;
}
else{
	if($num_data_mtotal_part_four == "0"){
		$msum_part_four = 0;
		$mcount_part_four = 0;
		$last_sum_part_four +=$msum_part_four;
		$last_count_part_four+=$mcount_part_four;
		}
	else{
	while (list($m_part_four)=mysql_fetch_row($result_part_four_2)){
    $mtstring_part_four = $m_part_four;
	$output_count_mtotal_part_four = substr_count($mtstring_part_four,",");
	$mtoutput_part_four = explode(",", $mtstring_part_four);
	for($j_mtotal_part_four = 0 ; $j_mtotal_part_four<=$output_count_mtotal_part_four ; $j_mtotal_part_four++){
		$msum_part_four += $mtoutput_part_four[$j_mtotal_part_four];
	}
		$mcount_part_four+=($output_count_mtotal_part_four);
	}
	$last_msum_part_four +=$msum_part_four;
	$last_mcount_part_four+=$mcount_part_four;
	$mttdata_part_four = round ($last_msum_part_four / $last_mcount_part_four,2);
	$last_msum_part_four =0;
	$last_mcount_part_four=0;
	}
}
}
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
$amttdata = abs($attdata_pie-$mttdata_pie);
if($amttdata <=20){
	if(($attdata_pie >= 0 and $attdata_pie < 20) and ($mttdata_pie >= 0 and $mttdata_pie < 20)){
		$final_result = "E";
	}
		else if(($attdata_pie >= 20 and $attdata_pie < 40) and ($mttdata_pie >= 20 and $mttdata_pie < 40)){
		$final_result = "D";
	}
		else if(($attdata_pie >= 40 and $attdata_pie < 60) and ($mttdata_pie >= 40 and $mttdata_pie < 60)){
		$final_result = "C";
	}
		else if(($attdata_pie >= 60 and $attdata_pie < 80) and ($mttdata_pie >= 60 and $mttdata_pie < 80)){
		$final_result = "B";
	}
		else if(($attdata_pie >= 80 and $attdata_pie <= 100) and ($mttdata_pie >= 80 and $mttdata_pie <= 100)){
		$final_result = "A";
	}
	else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 20){
			$final_result = "E";
			}
			else if($mttdata_pie >= 20 and $mttdata_pie < 40){
			$final_result = "D";;
			}
			else if($mttdata_pie >= 40 and $mttdata_pie < 60){
			$final_result = "C";
			}
			else if($mttdata_pie >= 60 and $mttdata_pie < 80){
			$final_result = "B";
			}
			else if($mttdata_pie >= 80 and $mttdata_pie <= 100){
			$final_result = "A";
			}
		}
		else if($mttdata_pie>$attdata_pie){
			if($attdata_pie >= 0 and $attdata_pie < 20){
			$final_result = "E";
			}
			else if($attdata_pie >= 20 and $attdata_pie < 40){
			$final_result = "D";
			}
			else if($attdata_pie >= 40 and $attdata_pie < 60){
			$final_result = "C";
			}
			else if($attdata_pie >= 60 and $attdata_pie < 80){
			$final_result = "B";
			}
			else if($attdata_pie >= 80 and $attdata_pie <= 100){
			$final_result = "A";
			}
		}
	}
}


else{
		if($attdata_pie>$mttdata_pie){
			if($mttdata_pie >= 0 and $mttdata_pie < 20){
			$final_result = "E";
			}
			else if($mttdata_pie >= 20 and $mttdata_pie < 40){
			$final_result = "D";
			}
			else if($mttdata_pie >= 40 and $mttdata_pie < 60){
			$final_result = "C";
			}
			else if($mttdata_pie >= 60 and $mttdata_pie < 80){
			$final_result = "B";
			}
			else if($mttdata_pie >= 80 and $mttdata_pie <= 100){
			$final_result = "A";
			}
		}
		else if($mttdata_pie>$attdata_pie){			
			if($attdata_pie >= 0 and $attdata_pie < 20){
			$final_result = "E";
			}
			else if($attdata_pie >= 20 and $attdata_pie < 40){
			$final_result = "D";
			}
			else if($attdata_pie >= 40 and $attdata_pie < 60){
			$final_result = "C";
			}
			else if($attdata_pie >= 60 and $attdata_pie < 80){
			$final_result = "B";
			}




			else if($attdata_pie >= 80 and $attdata_pie <= 100){
			$final_result = "A";
			}
		}
}
/*--------------------------------------------------------------------------------------------------------------------------------*/
	$user_name = mysql_query("SELECT User_name , no FROM user_data WHERE account ='$id'");
	$user_data = mysql_query("SELECT account FROM total_data WHERE account ='$id'");
	$num_user_data = mysql_num_rows($user_data);
	$num_user_name = mysql_num_rows($user_name);
	while (list($Student_name,$Student_no)=mysql_fetch_array($user_name)){
	$name = $Student_name;
	$no = $Student_no;
	}
/*--------------------------------------------------------------------------------------------------------------------------------*/
if($attdata_pie >= 0 and $attdata_pie < 20){
	$AE++;
	}
	else if($attdata_pie >= 20 and $attdata_pie < 40){
	$AD++;
	}
	else if($attdata_pie >= 40 and $attdata_pie < 60){
	$AC++;
	}
	else if($attdata_pie >= 60 and $attdata_pie < 80){
	$AB++;
	}
	else if($attdata_pie >= 80 and $attdata_pie <= 100){
	$AA++;
}
if($mttdata_pie >= 0 and $mttdata_pie < 20){
	$RE++;
	}
	else if($mttdata_pie >= 20 and $mttdata_pie < 40){
	$RD++;
	}
	else if($mttdata_pie >= 40 and $mttdata_pie < 60){
	$RC++;
	}
	else if($mttdata_pie >= 60 and $mttdata_pie < 80){
	$RB++;
	}
	else if($mttdata_pie >= 80 and $mttdata_pie <= 100){
	$RA++;
}
if($num_user_data == 0){
if(($account_num+1)%2 == 1){
$attdata_part_one = 0;
$mttdata_part_one = 0;
$attdata_part_two = 0;
$mttdata_part_two = 0;
$attdata_part_three = 0;
$mttdata_part_three = 0;
$attdata_part_four = 0;
$mttdata_part_four = 0;
$attdata_pie = 0;
$mttdata_pie = 0;
$final_result = "E";
$attdata_part_one_sum += $attdata_part_one;
$mttdata_part_one_sum += $mttdata_part_one;
$attdata_part_two_sum += $attdata_part_two;
$mttdata_part_two_sum += $mttdata_part_two;
$attdata_part_three_sum += $attdata_part_three;
$mttdata_part_three_sum += $mttdata_part_three;
$attdata_part_four_sum += $attdata_part_four;
$mttdata_part_four_sum += $mttdata_part_four;
$attdata_pie_sum += $attdata_pie;
$mttdata_pie_sum += $mttdata_pie;   
echo	"<tr>";
echo		"<td class=\"data_row_style\" width=\"170\"><a href=\"student_window.php?A=".$no."\"  onclick=\"window.open(this.href, '','directories = no,location=no,width=auto,height=auto'); return false;\">".$name."</a></td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_part_one."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_part_one."</td>";
echo		"<td class=\"data_row_style3\" width=\"88\">".$attdata_part_two."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$mttdata_part_two."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_part_three."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_part_three."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$attdata_part_four."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$mttdata_part_four."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_pie."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_pie."</td>";
echo        "<td class=\"data_row_style7\" width=\"146\">".$final_result."</td>";
echo	"</tr>";
	}
else{   
echo	"<tr>";
echo		"<td class=\"data_row_style4\" width=\"170\"><a href=\"student_window.php?A=".$no."\"  onclick=\"window.open(this.href, '', 'directories = no,location=no,width=auto,height=auto'); return false;\">".$name."</a></td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_part_one."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_part_one."</td>";
echo		"<td class=\"data_row_style6\" width=\"88\">".$attdata_part_two."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$mttdata_part_two."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_part_three."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_part_three."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$attdata_part_four."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$mttdata_part_four."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_pie."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_pie."</td>";

echo        "<td class=\"data_row_style8\" width=\"146\">".$final_result."</td>";
echo	"</tr>";
}
}
else{
$attdata_part_one_sum += $attdata_part_one;
$mttdata_part_one_sum += $mttdata_part_one;
$attdata_part_two_sum += $attdata_part_two;
$mttdata_part_two_sum += $mttdata_part_two;
$attdata_part_three_sum += $attdata_part_three;
$mttdata_part_three_sum += $mttdata_part_three;
$attdata_part_four_sum += $attdata_part_four;
$mttdata_part_four_sum += $mttdata_part_four;
$attdata_pie_sum += $attdata_pie;
$mttdata_pie_sum += $mttdata_pie;
if(($account_num+1)%2 == 1){   
echo	"<tr>";
echo		"<td class=\"data_row_style\" width=\"170\"><a href=\"student_window.php?A=".$no."\"  onclick=\"window.open(this.href, '', 'directories = no,location=no,width=auto,height=auto'); return false;\">".$name."</a></td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_part_one."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_part_one."</td>";
echo		"<td class=\"data_row_style3\" width=\"88\">".$attdata_part_two."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$mttdata_part_two."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_part_three."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_part_three."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$attdata_part_four."</td>";
echo        "<td class=\"data_row_style3\" width=\"88\">".$mttdata_part_four."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$attdata_pie."</td>";
echo        "<td class=\"data_row_style2\" width=\"88\">".$mttdata_pie."</td>";
echo        "<td class=\"data_row_style7\" width=\"146\">".$final_result."</td>";
echo	"</tr>";
}
else{ 
echo	"<tr>";
echo		"<td class=\"data_row_style4\" width=\"170\"><a href=\"student_window.php?A=".$no."\"  onclick=\"window.open(this.href, '', 'directories = no,location=no,width=auto,height=auto'); return false;\">".$name."</a></td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_part_one."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_part_one."</td>";
echo		"<td class=\"data_row_style6\" width=\"88\">".$attdata_part_two."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$mttdata_part_two."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_part_three."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_part_three."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$attdata_part_four."</td>";
echo        "<td class=\"data_row_style6\" width=\"88\">".$mttdata_part_four."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$attdata_pie."</td>";
echo        "<td class=\"data_row_style5\" width=\"88\">".$mttdata_pie."</td>";
echo        "<td class=\"data_row_style8\" width=\"146\">".$final_result."</td>";
echo	"</tr>";
}
$attdata_part_one = 0;
$mttdata_part_one = 0;
$attdata_part_two = 0;
$mttdata_part_two = 0;
$attdata_part_three = 0;
$mttdata_part_three = 0;
$attdata_part_four = 0;
$mttdata_part_four = 0;
$attdata_pie = 0;
$mttdata_pie = 0;
}
}
}
else{
echo	"<tr>";
echo		"<td class=\"warning\" width=\"170\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">Null</td>";
echo        "<td class=\"warning2\" width=\"88\">Data!</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"88\">&nbsp;</td>";
echo        "<td class=\"warning\" width=\"146\">&nbsp;</td>";
echo	"</tr>";
}

/*--------------------------------------------------------------------------------------------------------------------------------*/  
if($num_account_rows_pie != 0){
$attdata_part_one_sums =  round ($attdata_part_one_sum/$num_account_rows_pie,2);
$mttdata_part_one_sums =  round ($mttdata_part_one_sum/$num_account_rows_pie,2);
$attdata_part_two_sums =  round ($attdata_part_two_sum/$num_account_rows_pie,2);
$mttdata_part_two_sums =  round ($mttdata_part_two_sum/$num_account_rows_pie,2);
$attdata_part_three_sums =  round ($attdata_part_three_sum/$num_account_rows_pie,2);
$mttdata_part_three_sums =  round ($mttdata_part_three_sum/$num_account_rows_pie,2);
$attdata_part_four_sums =  round ($attdata_part_four_sum/$num_account_rows_pie,2);
$mttdata_part_four_sums =  round ($mttdata_part_four_sum/$num_account_rows_pie,2);
$attdata_pie_sums =  round ($attdata_pie_sum/$num_account_rows_pie,2);
$mttdata_pie_sums =  round ($mttdata_pie_sum/$num_account_rows_pie,2);
}
else{
$attdata_part_one_sums = 0;
$mttdata_part_one_sums = 0;
$attdata_part_two_sums =  0;
$mttdata_part_two_sums =  0;
$attdata_part_three_sums = 0;
$mttdata_part_three_sums = 0;
$attdata_part_four_sums = 0;
$mttdata_part_four_sums = 0;
$attdata_pie_sums = 0;
$mttdata_pie_sums = 0;
}
echo	"<tr>";
echo		"<td class=\"end\" width=\"170\">全班平均值</td>";
echo        "<td class=\"end2\" width=\"88\">".$attdata_part_one_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$mttdata_part_one_sums."</td>";
echo		"<td class=\"end2\" width=\"88\">".$attdata_part_two_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$mttdata_part_two_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$attdata_part_three_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$mttdata_part_three_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$attdata_part_four_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$mttdata_part_four_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$attdata_pie_sums."</td>";
echo        "<td class=\"end2\" width=\"88\">".$mttdata_pie_sums."</td>";
echo        "<td class=\"end2\" width=\"146\">&nbsp;</td>";
echo	"</tr>";
?>
</table>
</div></td>
                </tr>
              </table>
	          <table border="0" cellspacing="0" cellpadding="0">
	            <tr>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
                </tr>
	            <tr>
	              <td width="427" align="center" valign="middle"><table id="Statistic_Figures_Title" width="428" border="0" cellspacing="0" cellpadding="5">
	<tr>
    	<th class="title_style">專注力成績等級</th>
	</tr>
</table>
<table id="Statistic_Figures" width="428" height="96" border="0" cellspacing="0" cellpadding="5">
	<tr>
    	<th class="title_style"  width="80">成績範圍</th>
        <th class="title_style2" width="68">80~100</th>
        <th class="title_style3" width="68">60~80</th>
        <th class="title_style2" width="68">40~60</th>
        <th class="title_style3" width="68">20~40</th>
        <th class="title_style2_1" width="68">0~20</th>
	</tr>
	<tr>
    	<th class="title_style4" width="80">成績</th>
        <th class="title_style5" width="68">A</th>
        <th class="title_style6" width="68">B</th>
        <th class="title_style5" width="68">C</th>
        <th class="title_style6" width="68">D</th>
        <th class="title_style5_1" width="68">E</th>
	</tr>
    <tr>
		<th class="title_style7"  width="80">學生數量</th>
        <th class="title_style8" width="68"><? echo $AA; $_SESSION['AA'] = $AA; ?></th>
        <th class="title_style9" width="68"><? echo $AB; $_SESSION['AB'] = $AB; ?></th>
        <th class="title_style8" width="68"><? echo $AC; $_SESSION['AC'] = $AC; ?></th>
        <th class="title_style9" width="68"><? echo $AD; $_SESSION['AD'] = $AD; ?></th>
        <th class="title_style8_1" width="68"><? echo $AE; $_SESSION['AE'] = $AE; ?></th>
	</tr>
</table></td>
	              <td align="center" valign="middle">&nbsp;&nbsp;</td>
	              <td width="427" align="center" valign="middle">
<table id="Statistic_Figures_Title" width="428" border="0" cellspacing="0" cellpadding="5">
	<tr>
    	<th class="title_style">放鬆成績等級</th>
	</tr>
</table>
<table id="Statistic_Figures" width="428" height="96" border="0" cellspacing="0" cellpadding="5">
	<tr>
    	<th class="title_style"  width="80">成績範圍</th>
        <th class="title_style2" width="68">80~100</th>
        <th class="title_style3" width="68">60~80</th>
        <th class="title_style2" width="68">40~60</th>
        <th class="title_style3" width="68">20~40</th>
        <th class="title_style2_1" width="68">0~20</th>
	</tr>
	<tr>
    	<th class="title_style4" width="80">成績</th>
        <th class="title_style5" width="68">A</th>
        <th class="title_style6" width="68">B</th>
        <th class="title_style5" width="68">C</th>
        <th class="title_style6" width="68">D</th>
        <th class="title_style5_1" width="68">E</th>
	</tr>
    <tr>
		<th class="title_style7"  width="80">學生數量</th>
        <th class="title_style8" width="68"><? echo $RA; $_SESSION['RA'] = $RA; ?></th>
        <th class="title_style9" width="68"><? echo $RB; $_SESSION['RB'] = $RB; ?></th>
        <th class="title_style8" width="68"><? echo $RC; $_SESSION['RC'] = $RC; ?></th>
        <th class="title_style9" width="68"><? echo $RD; $_SESSION['RD'] = $RD; ?></th>
        <th class="title_style8_1" width="68"><? echo $RE; $_SESSION['RE'] = $RE; ?></th>
	</tr>
</table></td>
                </tr>
	            <tr>
	              <td align="center" valign="middle">&nbsp;</td>
	              <td align="center" valign="middle">&nbsp;</td>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
                </tr>
	            <tr>
	              <td colspan="3" align="center" valign="middle">
<?
include_once('php-ofc-library/bar_for_chart.php');
echo(chart_str( 875, 263, 'Statistic_Figures.php?type='));
?></td>
                </tr>
              </table>
	        </div></td>
          </tr>
        </table></td>
</tr>
	  <tr>
	    <td></td>
  </tr>
<tr>
	    <td height="50"><p></p></td>
      </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#00a9a1"><div id="K_class"></div><p class="menuwhite"><br>

	                <a name="C"></a>個<br>
	              人<br>
	              專<br>
	              注<br>
	              ＆<br>
	              放<br>
	              鬆<br>
	              表<br>
	              現<br>
	              <br>
                  </p></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#00a9a1 #00a9a1 #00a9a1 #00a9a1;padding:20px 20px 20px 20px; background-color:#FFF" >
	          <table border="0" cellspacing="0" cellpadding="0">
	            <tr><td>
<div id="Table_Location_Personal">
<div id="Table_Title_Personal">
<p></p>
<p>個人專注＆放鬆表現</p>
</div>
<table width="250" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="64">
    <h3 style="color:#00a9a1;font-size:14px;">學生姓名</h3>
	</td>
    <td width="166">
<div id="uboxstyle">
<form name="form1_1" method="post" action="<?php echo $studentchooseFormAction; ?>" onsubmit="return fromcheck();">
<div id="button">
<input name="submit" id="submit" class="classname" type="submit" value="Push" >
</div>
<span id="spryselect2">
<select name="student_name" id="student_name">
        <option value="null">請選擇</option>
        <?php
do {  
?>
        <option value="<?php echo $row_user_data['Account']?>"><?php echo $row_user_data['User_name']?></option>
        <?php
} while ($row_user_data = mysql_fetch_assoc($student_data));
  $rows = mysql_num_rows($student_data);
  if($rows > 0) {
      mysql_data_seek($student_data, 0);
	  $row_user_data = mysql_fetch_assoc($student_data);
  }
?>
</select>
<span class="selectRequiredMsg"></span>
</span>
</form>
</div>
</td>
  </tr>
</table>
<table id="Transcript" align="center" width="875" border="0" cellspacing="0">   
    <tr>
		<th class="title-style2_1_1" width="110">&nbsp;</th>
        <th class="title-style2_1" width="65.5">第一</th>
        <th class="title-style2_2" width="65.5">部分</th>
		<th class="title-style3_1" width="65.5">第二</th>
        <th class="title-style3_2" width="65.5">部分</th>
        <th class="title-style2_1" width="65.5">第三</th>
        <th class="title-style2_2" width="65.5">部分</th>
        <th class="title-style3_1" width="65.5">第四</th>
        <th class="title-style3_2" width="65.5">部分</th>
        <th class="title-style2_1" width="65.5">綜合</th>
        <th class="title-style2_2" width="65.5">分析</th>
	</tr>
    <tr>
		<th class="title-style5_1" width="110">&nbsp;</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
		<th class="title-style6" width="65.5">專注</th>
        <th class="title-style6" width="65.5">放鬆</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
        <th class="title-style6" width="65.5">專注</th>
        <th class="title-style6" width="65.5">放鬆</th>
        <th class="title-style5" width="65.5">專注</th>
        <th class="title-style5" width="65.5">放鬆</th>
	</tr>
<?
echo "<tbody>"; 
echo	"<tr class=\"row\">";
echo		"<td class=\"data_row_style\" width=\"170\">全班平均值</td>";
echo        "<td class=\"data_row_style2\" width=\"100\">".$attdata_part_one_sums."</td>";
echo        "<td class=\"data_row_style2\" width=\"100\">".$mttdata_part_one_sums."</td>";
echo		"<td class=\"data_row_style3\" width=\"100\">".$attdata_part_two_sums."</td>";
echo        "<td class=\"data_row_style3\" width=\"100\">".$mttdata_part_two_sums."</td>";
echo        "<td class=\"data_row_style2\" width=\"100\">".$attdata_part_three_sums."</td>";
echo        "<td class=\"data_row_style2\" width=\"100\">".$mttdata_part_three_sums."</td>";
echo        "<td class=\"data_row_style3\" width=\"100\">".$attdata_part_four_sums."</td>";
echo        "<td class=\"data_row_style3\" width=\"100\">".$mttdata_part_four_sums."</td>";
echo        "<td class=\"data_row_style7\" width=\"100\">".$attdata_pie_sums."</td>";
echo        "<td class=\"data_row_style7\" width=\"100\">".$mttdata_pie_sums."</td>";
echo	"</tr>";
$_SESSION['APO'] = $attdata_part_one_sums;
$_SESSION['APT'] = $attdata_part_two_sums;
$_SESSION['APTH'] = $attdata_part_three_sums;
$_SESSION['APF'] = $attdata_part_four_sums;
$_SESSION['APS'] = $attdata_pie_sums;
$_SESSION['MPO'] = $mttdata_part_one_sums;
$_SESSION['MPT'] = $mttdata_part_two_sums;
$_SESSION['MPTH'] = $mttdata_part_three_sums;
$_SESSION['MPF'] = $mttdata_part_four_sums;
$_SESSION['MPS'] = $mttdata_pie_sums;
if( empty($_SESSION['Name']) == true){
echo	"<tr class=\"row\">";
echo		"<td class=\"warning_1\" width=\"200\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo		"<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">Null</td>";
echo        "<td class=\"warning_2\" width=\"100\">Data!</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo        "<td class=\"warning_1\" width=\"100\">&nbsp;</td>";
echo	"</tr>";
$_SESSION['AOO'] = 0;
$_SESSION['AOT'] = 0;
$_SESSION['AOTH'] = 0;
$_SESSION['AOF'] = 0;
$_SESSION['APOY'] = 0;
$_SESSION['MOO'] = 0;
$_SESSION['MOT'] = 0;
$_SESSION['MOTH'] = 0;
$_SESSION['MOF'] = 0;
$_SESSION['MPOY'] = 0;
}
else{
$id_only = $_SESSION['Name'];
/*---------------------------------------------------------------------------------------------------------------------*/
/*第一部分專心 and 放鬆*/
$days_array_only_one = array();
	/*抓取日期資料筆數*/
	$date_data_only_one = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id_only'");
	/*日期有幾筆*/

	$num_date_rows_only_one = mysql_num_rows($date_data_only_one);
	/*抓出來的日期丟到陣列內*/
	for($i_only_one = 0 ;$i_only_one<$num_date_rows_only_one;$i_only_one++){
	while (list($day_only_one)=mysql_fetch_array($date_data_only_one)){
	$days_only_one[] = $day_only_one;
	}
	/*日期陣列*/
	array_push($days_array_only_one,$days_only_one[$i_only_one]);
	}
if($num_date_rows_only_one == 0){
$attdata_only_one = 0;
$mttdata_only_one = 0;	
	}
else{
/*For迴圈 Run日期筆數*/
	for($k_atotal_only_one = 0 ;$k_atotal_only_one<$num_date_rows_only_one;$k_atotal_only_one++){
	$asum_only_one = 0;
	$acount_only_one = 0;
	$atsum_only_one = 0;
	$day_atotal_only_one = $days_array_only_one[$k_atotal_only_one];
	$result_only_one=mysql_query("SELECT attention FROM total_data WHERE (stage = 2 or stage = 3 or stage = 5 or stage = 6) and account = '$id_only'");
	$num_data_atotal_only_one = mysql_num_rows($result_only_one);
	$result_id_only_one=mysql_query("SELECT attention FROM part_one WHERE (stage = 2 or stage = 3 or stage = 5 or stage = 6) and account = '$id_only'");
	$num_id_only_one = mysql_num_rows($result_id_only_one);
if($num_id_only_one == 0){
$attdata_only_one = 0;
}
else{
	if($num_data_atotal_only_one == "0"){
		$asum_only_one = 0;
		$acount_only_one = 0;

		$last_asum_only_one +=$asum_only_one;
		$last_acount_only_one+=$acount_only_one;
		}
	else{
	while (list($a_only_one)=mysql_fetch_row($result_only_one)){
    $atstring_only_one = $a_only_one;
	$output_count_atotal_only_one = substr_count($atstring_only_one,",");
	$atoutput_only_one = explode(",", $atstring_only_one);
	for($j_atotal_only_one = 0 ; $j_atotal_only_one<=$output_count_atotal_only_one ; $j_atotal_only_one++){
		$asum_only_one += $atoutput_only_one[$j_atotal_only_one];
	}
		$acount_only_one+=($output_count_atotal_only_one);
	}
	$last_asum_only_one +=$asum_only_one;
	$last_acount_only_one+=$acount_only_one;
	$attdata_only_one = round ($last_asum_only_one / $last_acount_only_one,2);
	$last_asum_only_one =0;
	$last_acount_only_one=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_only_one = 0 ;$k_mtotal_only_one<$num_date_rows_only_one;$k_mtotal_only_one++){
	$msum_only_one = 0;
	$mcount_only_one = 0;
	$mtsum_only_one = 0;
	$day_mtotal_mtotal = $days_array_only_one[$k_mtotal_only_one];
	$result_only_one_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6) and account = '$id_only'");
	$num_data_mtotal_only_one = mysql_num_rows($result_only_one_2);
	$result_id_only_one2=mysql_query("SELECT account FROM part_one WHERE(stage = 1 or stage = 3 or stage = 4 or stage = 6) and account = '$id_only'");
	$num_id_only_one2 = mysql_num_rows($result_id_only_one2);
if($num_id_only_one2 == 0){
$mttdata_only_one = 0;
}
else{
	if($num_data_mtotal_only_one == "0"){
		$msum_only_one = 0;
		$mcount_only_one = 0;
		$last_sum_only_one +=$msum_only_one;
		$last_count_only_one+=$mcount_only_one;
		}
	else{
	while (list($m_only_one)=mysql_fetch_row($result_only_one_2)){
    $mtstring_only_one = $m_only_one;
	$output_count_mtotal_only_one = substr_count($mtstring_only_one,",");
	$mtoutput_only_one = explode(",", $mtstring_only_one);
	for($j_mtotal_only_one = 0 ; $j_mtotal_only_one<=$output_count_mtotal_only_one ; $j_mtotal_only_one++){
		$msum_only_one += $mtoutput_only_one[$j_mtotal_only_one];
	}
		$mcount_only_one+=($output_count_mtotal_only_one);
	}
	$last_msum_only_one +=$msum_only_one;
	$last_mcount_only_one+=$mcount_only_one;
	$mttdata_only_one = round ($last_msum_only_one / $last_mcount_only_one,2);
	$last_msum_only_one =0;
	$last_mcount_only_one=0;
	}
	}
}
}
/*----------------------------------------------------------------------------------*/
/*第二部分專心 and 放鬆*/
$days_array_only_two = array();
	/*抓取日期資料筆數*/
	$date_data_only_two = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id_only'");
	/*日期有幾筆*/
	$num_date_rows_only_two = mysql_num_rows($date_data_only_two);
	/*抓出來的日期丟到陣列內*/
	for($i_only_two = 0 ;$i_only_two<$num_date_rows_only_two;$i_only_two++){
	while (list($day_only_two)=mysql_fetch_array($date_data_only_two)){
	$days_only_two[] = $day_only_two;
	}
	/*日期陣列*/
	array_push($days_array_only_two,$days_only_two[$i_only_two]);
	}
if($num_date_rows_only_two == 0){
$attdata_only_two = 0;
$mttdata_only_two = 0;	
	}
else{
/*For迴圈 Run日期筆數*/
	for($k_atotal_only_two = 0 ;$k_atotal_only_two<$num_date_rows_only_two;$k_atotal_only_two++){
	$asum_only_two = 0;
	$acount_only_two = 0;
	$atsum_only_two = 0;
	$day_atotal_only_two = $days_array_only_two[$k_atotal_only_two];
	$result_only_two=mysql_query("SELECT attention FROM total_data WHERE (stage = 8 or stage = 9 or stage = 11 or stage = 12) and account = '$id_only'");
	$num_data_atotal_only_two = mysql_num_rows($result_only_two);
	$result_id_only_two=mysql_query("SELECT account FROM part_two WHERE (stage = 8 or stage = 9 or stage = 11 or stage = 12) and account = '$id_only'");
	$num_id_only_two = mysql_num_rows($result_id_only_two);
if($num_id_only_two == 0){
$attdata_only_two = 0;
}
else{
	if($num_data_atotal_only_two == "0"){
		$asum_only_two = 0;
		$acount_only_two = 0;
		$last_asum_only_two +=$asum_only_two;
		$last_acount_only_two+=$acount_only_two;
		}
	else{
	while (list($a_only_two)=mysql_fetch_row($result_only_two)){
    $atstring_only_two = $a_only_two;
	$output_count_atotal_only_two = substr_count($atstring_only_two,",");
	$atoutput_only_two = explode(",", $atstring_only_two);
	for($j_atotal_only_two = 0 ; $j_atotal_only_two<=$output_count_atotal_only_two ; $j_atotal_only_two++){
		$asum_only_two += $atoutput_only_two[$j_atotal_only_two];
	}
		$acount_only_two+=($output_count_atotal_only_two);
	}
	$last_asum_only_two +=$asum_only_two;
	$last_acount_only_two+=$acount_only_two;
	$attdata_only_two = round ($last_asum_only_two / $last_acount_only_two,2);
	$last_asum_only_two =0;
	$last_acount_only_two=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_only_two = 0 ;$k_mtotal_only_two<$num_date_rows_only_two;$k_mtotal_only_two++){
	$msum_only_two = 0;
	$mcount_only_two = 0;
	$mtsum_only_two = 0;
	$day_mtotal_mtotal = $days_array_only_two[$k_mtotal_only_two];
	$result_only_two_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 7 or stage = 9 or stage = 10 or stage = 12) and account = '$id_only'");
	$num_data_mtotal_only_two = mysql_num_rows($result_only_two_2);
	$result_id_only_two2=mysql_query("SELECT account FROM part_two WHERE (stage = 7 or stage = 9 or stage = 10 or stage = 12) and account = '$id_only'");
	$num_id_only_two2 = mysql_num_rows($result_id_only_two2);
if($num_id_only_two2 == 0){
$mttdata_only_two = 0;
}
else{
	if($num_data_mtotal_only_two == "0"){
		$msum_only_two = 0;
		$mcount_only_two = 0;
		$last_sum_only_two +=$msum_only_two;
		$last_count_only_two+=$mcount_only_two;
		}
	else{
	while (list($m_only_two)=mysql_fetch_row($result_only_two_2)){
    $mtstring_only_two = $m_only_two;
	$output_count_mtotal_only_two = substr_count($mtstring_only_two,",");
	$mtoutput_only_two = explode(",", $mtstring_only_two);
	for($j_mtotal_only_two = 0 ; $j_mtotal_only_two<=$output_count_mtotal_only_two ; $j_mtotal_only_two++){
		$msum_only_two += $mtoutput_only_two[$j_mtotal_only_two];
	}
		$mcount_only_two+=($output_count_mtotal_only_two);
	}
	$last_msum_only_two +=$msum_only_two;
	$last_mcount_only_two+=$mcount_only_two;
	$mttdata_only_two = round ($last_msum_only_two / $last_mcount_only_two,2);
	$last_msum_only_two =0;
	$last_mcount_only_two=0;
	}
	}
}
}
/*---------------------------------------------------------------------------------------------------------------------*/
/*第三部分專心 and 放鬆*/
$days_array_only_three = array();
	/*抓取日期資料筆數*/
	$date_data_only_three = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id_only'");
	/*日期有幾筆*/
	$num_date_rows_only_three = mysql_num_rows($date_data_only_three);
	/*抓出來的日期丟到陣列內*/
	for($i_only_three = 0 ;$i_only_three<$num_date_rows_only_three;$i_only_three++){
	while (list($day_only_three)=mysql_fetch_array($date_data_only_three)){
	$days_only_three[] = $day_only_three;
	}
	/*日期陣列*/
	array_push($days_array_only_three,$days_only_three[$i_only_three]);
	}
if($num_date_rows_only_three == 0){
$attdata_only_three = 0;
$mttdata_only_three = 0;	
	}
else{
/*For迴圈 Run日期筆數*/
	for($k_atotal_only_three = 0 ;$k_atotal_only_three<$num_date_rows_only_three;$k_atotal_only_three++){
	$asum_only_three = 0;
	$acount_only_three = 0;
	$atsum_only_three = 0;
	$day_atotal_only_three = $days_array_only_three[$k_atotal_only_three];
	$result_only_three=mysql_query("SELECT attention FROM total_data WHERE (stage = 14 or stage = 15 or stage = 17 or stage = 18) and account = '$id_only'");
	$num_data_atotal_only_three = mysql_num_rows($result_only_three);
	$result_id_only_three=mysql_query("SELECT account FROM part_three WHERE (stage = 14 or stage = 15 or stage = 17 or stage = 18) and account = '$id_only'");
	$num_id_only_three = mysql_num_rows($result_id_only_three);
if($num_id_only_three== 0){
$attdata_only_three = 0;
}
else{
	if($num_data_atotal_only_three == "0"){
		$asum_only_three = 0;
		$acount_only_three = 0;
		$last_asum_only_three +=$asum_only_three;
		$last_acount_only_three+=$acount_only_three;
		}
	else{
	while (list($a_only_three)=mysql_fetch_row($result_only_three)){
    $atstring_only_three = $a_only_three;
	$output_count_atotal_only_three = substr_count($atstring_only_three,",");
	$atoutput_only_three = explode(",", $atstring_only_three);
	for($j_atotal_only_three = 0 ; $j_atotal_only_three<=$output_count_atotal_only_three ; $j_atotal_only_three++){
		$asum_only_three += $atoutput_only_three[$j_atotal_only_three];
	}
		$acount_only_three+=($output_count_atotal_only_three);
	}
	$last_asum_only_three +=$asum_only_three;
	$last_acount_only_three+=$acount_only_three;
	
	$attdata_only_three = round ($last_asum_only_three / $last_acount_only_three,2);
	$last_asum_only_three =0;
	$last_acount_only_three=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_only_three = 0 ;$k_mtotal_only_three<$num_date_rows_only_three;$k_mtotal_only_three++){
	$msum_only_three = 0;
	$mcount_only_three = 0;
	$mtsum_only_three = 0;
	$day_mtotal_mtotal = $days_array_only_three[$k_mtotal_only_three];
	$result_only_three_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 13 or stage = 15 or stage = 16 or stage = 18) and account = '$id_only'");
	$num_data_mtotal_only_three = mysql_num_rows($result_only_three_2);
	$result_id_only_three2=mysql_query("SELECT account FROM part_three WHERE (stage = 13 or stage = 15 or stage = 16 or stage = 18) and account = '$id_only'");
	$num_id_only_three2 = mysql_num_rows($result_id_only_three2);
if($num_id_only_three2 == 0){
$mttdata_only_three = 0;
}
else{
	if($num_data_mtotal_only_three == "0"){
		$msum_only_three = 0;
		$mcount_only_three = 0;
		$last_sum_only_three +=$msum_only_three;
		$last_count_only_three+=$mcount_only_three;
		}
	else{
	while (list($m_only_three)=mysql_fetch_row($result_only_three_2)){
    $mtstring_only_three = $m_only_three;
	$output_count_mtotal_only_three = substr_count($mtstring_only_three,",");
	$mtoutput_only_three = explode(",", $mtstring_only_three);
	for($j_mtotal_only_three = 0 ; $j_mtotal_only_three<=$output_count_mtotal_only_three ; $j_mtotal_only_three++){
		$msum_only_three += $mtoutput_only_three[$j_mtotal_only_three];
	}
		$mcount_only_three+=($output_count_mtotal_only_three);
	}
	$last_msum_only_three +=$msum_only_three;
	$last_mcount_only_three+=$mcount_only_three;
	$mttdata_only_three = round ($last_msum_only_three / $last_mcount_only_three,2);
	$last_msum_only_three =0;
	$last_mcount_only_three=0;
	}
}
}
}
/*---------------------------------------------------------------------------------------------------------------------*/
/*第四部分專心 and 放鬆*/
$days_array_only_four = array();
	/*抓取日期資料筆數*/
	$date_data_only_four = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id_only'");
	/*日期有幾筆*/
	$num_date_rows_only_four = mysql_num_rows($date_data_only_four);
	/*抓出來的日期丟到陣列內*/
	for($i_only_four = 0 ;$i_only_four<$num_date_rows_only_four;$i_only_four++){
	while (list($day_only_four)=mysql_fetch_array($date_data_only_four)){
	$days_only_four[] = $day_only_four;
	}
	/*日期陣列*/
	array_push($days_array_only_four,$days_only_four[$i_only_four]);
	}
if($num_date_rows_only_four == 0){
$attdata_only_four = 0;
$mttdata_only_four = 0;	
	}
else{
/*For迴圈 Run日期筆數*/
	for($k_atotal_only_four = 0 ;$k_atotal_only_four<$num_date_rows_only_four;$k_atotal_only_four++){
	$asum_only_four = 0;
	$acount_only_four = 0;
	$atsum_only_four = 0;
	$day_atotal_only_four = $days_array_only_four[$k_atotal_only_four];
	$result_only_four=mysql_query("SELECT attention FROM total_data WHERE (stage = 20 or stage = 21) and account = '$id_only'");
	$num_data_atotal_only_four = mysql_num_rows($result_only_four);
	$result_id_only_four=mysql_query("SELECT account FROM part_four WHERE (stage = 20 or stage = 21) and account = '$id_only'");
	$num_id_only_four = mysql_num_rows($result_id_only_four);
if($num_id_only_four== 0){
$attdata_only_four = 0;
}
else{
	if($num_data_atotal_only_four == "0"){
		$asum_only_four = 0;
		$acount_only_four = 0;
		$last_asum_only_four +=$asum_only_four;
		$last_acount_only_four+=$acount_only_four;
		}
	else{
	while (list($a_only_four)=mysql_fetch_row($result_only_four)){
    $atstring_only_four = $a_only_four;
	$output_count_atotal_only_four = substr_count($atstring_only_four,",");
	$atoutput_only_four = explode(",", $atstring_only_four);
	for($j_atotal_only_four = 0 ; $j_atotal_only_four<=$output_count_atotal_only_four ; $j_atotal_only_four++){
		$asum_only_four += $atoutput_only_four[$j_atotal_only_four];
	}
		$acount_only_four+=($output_count_atotal_only_four);
	}
	$last_asum_only_four +=$asum_only_four;
	$last_acount_only_four+=$acount_only_four;
	$attdata_only_four = round ($last_asum_only_four / $last_acount_only_four,2);
	$last_asum_only_four =0;
	$last_acount_only_four=0;
	}
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_only_four = 0 ;$k_mtotal_only_four<$num_date_rows_only_four;$k_mtotal_only_four++){
	$msum_only_four = 0;
	$mcount_only_four = 0;
	$mtsum_only_four = 0;
	$day_mtotal_mtotal = $days_array_only_four[$k_mtotal_only_four];
	$result_only_four_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 19 or stage = 21) and account = '$id_only'");
	$num_data_mtotal_only_four = mysql_num_rows($result_only_four_2);
	$result_id_only_four2=mysql_query("SELECT account FROM part_four WHERE (stage = 19 or stage = 21) and account = '$id_only'");
	$num_id_only_four2 = mysql_num_rows($result_id_only_four2);
if($num_id_only_four2== 0){
$mttdata_only_four = 0;
}
else{
	if($num_data_mtotal_only_four == "0"){
		$msum_only_four = 0;
		$mcount_only_four = 0;
		$last_sum_only_four +=$msum_only_four;
		$last_count_only_four+=$mcount_only_four;
		}
	else{
	while (list($m_only_four)=mysql_fetch_row($result_only_four_2)){
    $mtstring_only_four = $m_only_four;
	$output_count_mtotal_only_four = substr_count($mtstring_only_four,",");
	$mtoutput_only_four = explode(",", $mtstring_only_four);
	for($j_mtotal_only_four = 0 ; $j_mtotal_only_four<=$output_count_mtotal_only_four ; $j_mtotal_only_four++){
		$msum_only_four += $mtoutput_only_four[$j_mtotal_only_four];
	}
		$mcount_only_four+=($output_count_mtotal_only_four);
	}
	$last_msum_only_four +=$msum_only_four;
	$last_mcount_only_four+=$mcount_only_four;
	$mttdata_only_four = round ($last_msum_only_four / $last_mcount_only_four,2);
	$last_msum_only_four =0;
	$last_mcount_only_four=0;
	}
}
}
}
/*---------------------------------------------------------------------------------------------------------------------*/
/*總平均專心 and 放鬆*/	
	$days_array_pie = array();
	/*抓取日期資料筆數*/
	$date_data_pie = mysql_query("SELECT distinct (date) FROM total_data WHERE account ='$id_only'");
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
if($num_date_rows_pie == 0){
$attdata_pie_only = 0;
$mttdata_pie_only = 0;
	}
else{
/*For迴圈 Run日期筆數*/
	for($k_atotal_pie = 0 ;$k_atotal_pie<$num_date_rows_pie;$k_atotal_pie++){
	$asum_pie = 0;
	$acount_pie = 0;
	$atsum_pie = 0;
	$day_atotal_pie = $days_array_pie[$k_atotal_pie];
	$result_pie_only=mysql_query("SELECT attention FROM total_data WHERE (stage = 2 or stage = 3 or stage = 5 or stage = 6 or stage = 8 or stage = 9 or stage = 11 or stage = 12 or stage = 14 or stage = 15 or stage = 17 or stage = 18 or stage = 20 or stage = 21) and account = '$id_only'");
	$num_data_atotal_pie_only = mysql_num_rows($result_pie_only);
	if($num_data_atotal_pie_only == 0){
		$attdata_pie_only = 0;
		}
	else{
	while (list($a_pie)=mysql_fetch_row($result_pie_only)){
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
	$attdata_pie_only = round ($last_asum_pie / $last_acount_pie,2);
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
	$result_pie_only2=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6 or stage = 7 or stage = 9 or stage = 10 or stage = 12 or stage = 13 or stage = 15 or stage = 16 or stage = 18 or stage = 19 or stage = 21) and account = '$id_only'");
	$num_data_mtotal_pie_only = mysql_num_rows($result_pie_only2);
	if($num_data_mtotal_pie_only == 0){
		$mttdata_pie_only = 0;
		}
	else{
	while (list($m_pie)=mysql_fetch_row($result_pie_only2)){
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
	$mttdata_pie_only = round ($last_msum_pie / $last_mcount_pie,2);
	$last_msum_pie =0;
	$last_mcount_pie=0;
	}
}
}
/*---------------------------------------------------------------------------------------------------------------------*/
	$user_name = mysql_query("SELECT User_name FROM user_data WHERE account ='$id_only'");
	$user_data = mysql_query("SELECT account FROM total_data WHERE account ='$id_only'");
	$num_user_data = mysql_num_rows($user_data);
	$num_user_name = mysql_num_rows($user_name);
	while (list($day_only_one)=mysql_fetch_array($user_name)){
	$name_only = $day_only_one;
	}
/*---------------------------------------------------------------------------------------------------------------------*/
echo	"<tr class=\"row\">";
echo		"<td class=\"data_row_style4\" width=\"170\">".$name_only."</td>";
echo        "<td class=\"data_row_style5\" width=\"100\">".$attdata_only_one."</td>";
echo        "<td class=\"data_row_style5\" width=\"100\">".$mttdata_only_one."</td>";
echo		"<td class=\"data_row_style6\" width=\"100\">".$attdata_only_two."</td>";
echo        "<td class=\"data_row_style6\" width=\"100\">".$mttdata_only_two."</td>";
echo        "<td class=\"data_row_style5\" width=\"100\">".$attdata_only_three."</td>";
echo        "<td class=\"data_row_style5\" width=\"100\">".$mttdata_only_three."</td>";
echo        "<td class=\"data_row_style6\" width=\"100\">".$attdata_only_four."</td>";
echo        "<td class=\"data_row_style6\" width=\"100\">".$mttdata_only_four."</td>";
echo        "<td class=\"data_row_style8\" width=\"100\">".$attdata_pie_only."</td>";
echo        "<td class=\"data_row_style8\" width=\"100\">".$mttdata_pie_only."</td>";
echo	"</tr>";
$_SESSION['AOO'] = $attdata_only_one;
$_SESSION['AOT'] = $attdata_only_two;
$_SESSION['AOTH'] = $attdata_only_three;
$_SESSION['AOF'] = $attdata_only_four;
$_SESSION['APOY'] = $attdata_pie_only;
$_SESSION['MOO'] = $mttdata_only_one;
$_SESSION['MOT'] = $mttdata_only_two;
$_SESSION['MOTH'] = $mttdata_only_three;
$_SESSION['MOF'] = $mttdata_only_four;
$_SESSION['MPOY'] = $mttdata_pie_only;
}
echo "</tbody>";
?>
</table>
</div>
</td>
                </tr>
	            <tr>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
                </tr>
	            <tr>
	              <td height="30" align="center" valign="middle">
				<?
				echo(chart_str( 875, 263, 'Statistic_Figures_Line.php?type='));
				?>
				</td>
                </tr>
	            <tr>
	              <td height="20" align="center" valign="middle">&nbsp;</td>
                </tr>
	            <tr>
	              <td height="30" align="center" valign="middle">
				  <?
				echo(chart_str( 875, 263, 'Statistic_Figures_Line2.php?type='));
				?>&nbsp;</td>
                </tr>
              </table>
              </p>
</div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td height="50">&nbsp;</td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#00a9a1"><span class="menuwhite"><div id="L_class"></div><br>
                  <a name="D"></a>輔<br>
                  助<br>
                  音<br>
                  樂<br>
	              <br>
	              </span></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915"><div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#00a9a1 #00a9a1 #00a9a1 #00a9a1;padding:20px 20px 20px 20px; background-color:#FFF" >盡請期待！<br>

	          <p><br>
	            <br>
              </p>
	          </div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td height="50">&nbsp;</td>
  </tr>
	  <tr>
	    <td><table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td valign="top"><table border="0" align="right" cellpadding="0" cellspacing="0">
	          <tr>
	            <td width="35" align="center" valign="middle" bgcolor="#00a9a1"><span class="menuwhite"><div id="M_class"></div><a name="E"></a><br>
                  個<br>
                  別<br>
                  追<br>
                  蹤<br>
	              <br>
	              </span></td>
              </tr>
	          </table></td>
	        <td valign="top" width="915">
            <div class="info1" style="border-style:solid; border-width:2px 2px 2px 2px; border-color:#00a9a1 #00a9a1 #00a9a1 #00a9a1;padding:20px 20px 20px 20px; background-color:#FFF" >
    <form name="form4" method="post" action="<?php echo $studentQAFormAction; ?>" onsubmit="return fromcheck2();"> 
     <table width="242" border="0" cellpadding="0" cellspacing="0">
                <tr>
	                <td width="100"><h3 style="color:#00a9a1;font-size:14px;">學生姓名:</h3></td>
	                <td width="103"><label for="name"></label>
                      <div id="uboxstyle">
<span id="spryselect2">
<select name="student_name_QA" id="student_name_QA">
        <option value="null">請選擇</option>
        <?php
do {  
?>
        <option value="<?php echo $row_qa_data['Account']?>"><?php echo $row_qa_data['User_name']?></option>
        <?php
} while ($row_qa_data = mysql_fetch_assoc($qa_data));
  $rows_qa = mysql_num_rows($qa_data);
  if($rows_qa > 0) {
      mysql_data_seek($qa_data, 0);
	  $row_qa_data = mysql_fetch_assoc($qa_data);
  }
?>
</select>
<span class="selectRequiredMsg"></span>
</span>                      </div></td>
	                <td width="39"><input class="classname" type="submit" name="button2" id="button2" value="Submit"></td>
</tr>
               
              </table>
             </form>
<?php if ($_SESSION['NameQA']!=null) {?> 
<?php if ($totalRows_gbookshow > 0) { // Show if recordset not empty ?>
<?php do { ?>
        <table width="440"  border="0" cellpadding="7" cellspacing="0" class="gtable">
        <tr>
        <td colspan="2"style="color:#00a9a1;font-size:14px;" align="center"><b> <? echo $qa2; ?> </b></td>
        </tr>
        <tr>
          <td colspan="2"style="color:#00a9a1;font-size:14px;"><b>留言內容：</b> <b style="color:#00a9a1;font-size:12px;"> 時間:<?php echo $row_gbookshow['time']; ?></b></td>
        </tr>
        <tr>
          <td colspan="2"><?php echo $row_gbookshow['gcomment']; ?>
            </td>
         </tr>
         <tr>
         <td>
         <?php if($row_gbookshow['gre'] != null){?>
            <div class="re"> <b style="color:#00a9a1;font-size:14px;">回應：</b> <b style="color:#00a9a1;font-size:12px;"> 時間:<?php echo $row_gbookshow['time']; ?></b><br />
         </div>
         </td>
         </tr>
         <tr>
         <td>
          <?php echo $row_gbookshow['gre']; ?>
         </td>
         </tr>
         <tr>
         <td>
         <?php }?>
            <?php if ($_SESSION['MM_Teacher']!=null) {?>
            <h3 style="color:#00a9a1;font-size:14px;">回答問題:</h3>
			<form id="form1" name="form1" method="POST" onsubmit="return fromcheck3();">
				<textarea name="re" id="re" cols="60" rows="2"><?php echo $row_gbookshow['gre']; ?></textarea>
				<input name="id" type="hidden" id="id" value="<?php echo $row_gbookshow['no']; ?>" />
				<input class="classname" type="submit" name="button" id="button" value="送出" />
				<input type="hidden" name="MM_update"  value="form1" />
			</form>
            <?php }?>
            </td>
        </tr>
        
        <tr>
          <td colspan="2" align="right"></td>
        </tr>
        </table>
      <br>
      <?php } while ($row_gbookshow = mysql_fetch_assoc($gbookshow)); ?>
      <table width="440" border="0">
        <tr>
          <td align="center">
          目前顯示第<?php echo ($startRow_gbookshow + 1) ?>筆 (共<?php echo $totalRows_gbookshow ?>筆)&nbsp;
          </td>
        </tr>
        <tr>
          <td align="center">
            <?php if ($pageNum_gbookshow > 0) { // Show if not first page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, 0, $queryString_gbookshow); ?>#E">第一頁</a>
              <?php } // Show if not first page ?>      <?php if ($pageNum_gbookshow > 0) { // Show if not first page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, max(0, $pageNum_gbookshow - 1), $queryString_gbookshow); ?>#E">上一頁</a>　
              <?php } // Show if not first page ?>      <?php if ($pageNum_gbookshow < $totalPages_gbookshow) { // Show if not last page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, min($totalPages_gbookshow, $pageNum_gbookshow + 1), $queryString_gbookshow); ?>#E">下一頁</a>　
              <?php } // Show if not last page ?>      <?php if ($pageNum_gbookshow < $totalPages_gbookshow) { // Show if not last page ?>
              <a style="color:#00a9a1;font-size:10px;" href="<?php printf("%s?pageNum_gbookshow=%d%s", $currentPage, $totalPages_gbookshow, $queryString_gbookshow); ?>#E">最後頁</a>　
              <?php } // Show if not last page ?>      </td>
        </tr>
      </table>  
<?php } // Show if recordset not empty ?>
      <br />
       <?php if ($totalRows_gbookshow == 0) { // Show if recordset empty ?>
        <div align="center">無任何留言</div>
      <?php } // Show if recordset empty ?>
      <?php }?>
	        </div></td>
          </tr>
        </table></td>
  </tr>
	  <tr>
	    <td>&nbsp;</td>
  </tr>
	  <tr>
	    <td height="80">&nbsp;</td>
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