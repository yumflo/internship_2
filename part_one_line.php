<?
$id="qwe";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
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
<body>
<form id="form1" name="form1" method="post" onsubmit="return Check_submit();">
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="1"/>
        Stage 1</label>
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="2"/>
        Stage 2</label>
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="3"/>
        Stage 3</label>
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="4"/>
        Stage 4</label>
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="5"/>
        Stage 5</label>
<label>
        <input type="checkbox" name="CheckboxGroup[]" value="6"/>
        Stage 6</label>
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
<? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_one=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_one Where account ='$id'");
		while (list($a_part_one,$m_part_one)=mysql_fetch_row($result_time_part_one)){
			$attime_part_one  = $a_part_one;
			$mttime_part_one  = $m_part_one;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
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
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_one = 0 ;$k_mtotal_part_one<$num_date_rows_part_one;$k_mtotal_part_one++){
	$msum_part_one = 0;
	$mcount_part_one = 0;
	$mtsum_part_one = 0;
	$day_mtotal_mtotal = $days_array_part_one[$k_mtotal_part_one];
	$result_part_one_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6) and account = '$id'");
	$num_data_mtotal_part_one = mysql_num_rows($result_part_one_2);
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
/*---------------------------------------------------------------------------------------------------------------------*/
?>  
<table width="200" border="0" cellpadding="0">
  <tr>
    <td width="139">總平均專心數值</td>
    <td width="55"><? echo $attdata_part_one; ?></td>
  </tr>
  <tr>
    <td>總平均放鬆數值</td>
    <td><? echo $mttdata_part_one; ?></td>
  </tr>
  <tr>
    <td>最長專注時間</td>
    <td><? echo $attime_part_one; ?></td>
  </tr>
  <tr>
    <td>最長放鬆時間</td>
    <td><? echo $mttime_part_one; ?></td>
  </tr>
</table>

</body>
</html>