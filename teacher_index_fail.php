<?php require_once('Connections/localhost.php'); ?>
<?php
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user_account'])) {
  $loginUsername=$_POST['user_account'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "teacher.php";
  $MM_redirectLoginFailed = "teacher_index_fail.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT Account, Password FROM teacher_data WHERE Account=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Teacher'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>BrainwaveClass</title>
<style>
* { margin: 0; padding: 0; }
 
body {
	border-top-width: 30px;
	border-top-style: solid;
	font: 11px "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
}
 
form {
	margin-left: 8px;
	padding: 16px 16px 40px 16px;
	font-weight: normal;
	-moz-border-radius: 11px;
	-khtml-border-radius: 11px;
	-webkit-border-radius: 11px;
	border-radius: 5px;
	background: #fff;
	border: 1px solid #e5e5e5;
	-moz-box-shadow: rgba(200,200,200,1) 0 4px 18px;
	-webkit-box-shadow: rgba(200,200,200,1) 0 4px 18px;
	-khtml-box-shadow: rgba(200,200,200,1) 0 4px 18px;
	box-shadow: rgba(200,200,200,1) 0 4px 18px;
}
#login form .submit input {
	font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
	padding: 3px 10px;
	border: none;
	font-size: 12px;
	border-width: 1px;
	border-style: solid;
	-moz-border-radius: 11px;
	-khtml-border-radius: 11px;
	-webkit-border-radius: 11px;
	border-radius: 11px;
	cursor: pointer;
	text-decoration: none;
	margin-top: -3px;
	text-shadow: rgba(0,0,0,0.3) 0 -1px 0;
}
 
form .submit { float: right; }
#login { width: 320px; margin: 7em auto; } 
#logo { width: 360px; margin: 2em auto; }
#color{color:#F00;} 
#password, #user_account, #user_email {
	font-size: 24px;
	width: 97%;
	padding: 3px;
	margin-top: 2px;
	margin-right: 6px;
	margin-bottom: 16px;
	border: 1px solid #e5e5e5;
	background: #fbfbfb;
}
</style>
</head>
<script language="javascript">function datacheck(){
if (form1.user_account.value==""){    alert("Plese,Key in your Account");    
form1.user_account.focus();    return false;   }      
if (form1.password.value==""){    alert("Plese,Key in your Password");    
form1.user_password.focus();    return false;   }
return true;    }</script>
<body>
<div id="logo">
<input type="image" name="imageField" id="imageField" src="photo/Logo-large.png" />
</div>
<div id="login">
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>" onsubmit="return datacheck();">
  <p>User Account
  <input type="text" name="user_account" id="user_account" /><br />
    User Password
    <input type="password" name="password" id="password" />
  </p>
  <div id ="color">
    <p>You have wrong Account or Password  </p>
    <p>Please  check it again ! </p>
  </div>
    <input type="submit" name="button" id="button" value="Login" class="submit"/>
  </p>
</form></div>
</div>
</body>
</html>