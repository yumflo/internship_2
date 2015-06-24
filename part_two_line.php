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
        <input type="checkbox" name="CheckboxGroup_two[]" value="7"/>
        Stage 7</label>
<label>
        <input type="checkbox" name="CheckboxGroup_two[]" value="8"/>
        Stage 8</label>
<label>
        <input type="checkbox" name="CheckboxGroup_two[]" value="9"/>
        Stage 9</label>
<label>
        <input type="checkbox" name="CheckboxGroup_two[]" value="10"/>
        Stage 10</label>
<label>
        <input type="checkbox" name="CheckboxGroup_two[]" value="11"/>
        Stage 11</label>
<label>
        <input type="checkbox" name="CheckboxGroup_two[]" value="12"/>
        Stage 12</label>
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
<? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_two=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_one Where account ='$id'");
		while (list($a_part_two,$m_part_two)=mysql_fetch_row($result_time_part_two)){
			$attime_part_two  = $a_part_two;
			$mttime_part_two  = $m_part_two;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
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
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_two = 0 ;$k_mtotal_part_two<$num_date_rows_part_two;$k_mtotal_part_two++){
	$msum_part_two = 0;
	$mcount_part_two = 0;
	$mtsum_part_two = 0;
	$day_mtotal_mtotal = $days_array_part_two[$k_mtotal_part_two];
	$result_part_two_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 7 or stage = 9 or stage = 10 or stage = 12) and account = '$id'");
	$num_data_mtotal_part_two = mysql_num_rows($result_part_two_2);
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
/*---------------------------------------------------------------------------------------------------------------------*/
?>  
<table width="200" border="0" cellpadding="0">
  <tr>
    <td width="139">總平均專心數值</td>
    <td width="55"><? echo $attdata_part_two; ?></td>
  </tr>
  <tr>
    <td>總平均放鬆數值</td>
    <td><? echo $mttdata_part_two; ?></td>
  </tr>
  <tr>
    <td>最長專注時間</td>
    <td><? echo $attime_two; ?></td>
  </tr>
  <tr>
    <td>最長放鬆時間</td>
    <td><? echo $mttime_two; ?></td>
  </tr>
</table>

</body>
</html>