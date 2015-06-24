<?
$id="qwe";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1751515/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-14" />
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
        <input type="checkbox" name="CheckboxGroup_three[]" value="13"/>
        Stage 13</label>
<label>
        <input type="checkbox" name="CheckboxGroup_three[]" value="14"/>
        Stage 14</label>
<label>
        <input type="checkbox" name="CheckboxGroup_three[]" value="15"/>
        Stage 15</label>
<label>
        <input type="checkbox" name="CheckboxGroup_three[]" value="16"/>
        Stage 16</label>
<label>
        <input type="checkbox" name="CheckboxGroup_three[]" value="17"/>
        Stage 17</label>
<label>
        <input type="checkbox" name="CheckboxGroup_three[]" value="18"/>
        Stage 18</label>
<input name="submit" type="submit" value="Submit" />
        
</form>

<form>
<?
function paint_three($get_num_three,$get_num_three2){
session_start();
$_SESSION['part_three'] = $get_num_three;
$_SESSION['part_three2'] = $get_num_three2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(1300, 300, 'part_three_line_data.php?type='));	
}
function paint_three2($get_num_three,$get_num_three2){
session_start();
$_SESSION['part_three'] = $get_num_three;
$_SESSION['part_three2'] = $get_num_three2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(650, 300, 'part_three_line_data_other.php?type='));	
}
function paint_three3($get_num_three,$get_num_three2){
session_start();
$_SESSION['part_three'] = $get_num_three;
$_SESSION['part_three2'] = $get_num_three2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(1300, 300, 'part_three_line_data_total.php?type='));	
}
?>
</form>
<?
if( $_POST['CheckboxGroup_three'] == null ){
	$num_three = null;
	$num_three2 = null; 
	echo paint_three3($num_three,$num_three2);	
}
else{
foreach($_POST['CheckboxGroup_three'] as $stage2[]);
if ($stage2[0] == 13 && $stage2[1]==null){
	$num_three = "13";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 14 && $stage2[1]==null){
	$num_three = "14";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 15 && $stage2[1]==null){
	$num_three = "15";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 16 && $stage2[1]==null){
	$num_three = "16";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 17 && $stage2[1]==null){
	$num_three = "17";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 18 && $stage2[1]==null){
	$num_three = "18";
	$num_three2 ="null"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 13 && $stage2[1]==14){
	$num_three = "13";
	$num_three2 ="14"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 13 && $stage2[1]==15){
	$num_three = "13";
	$num_three2 ="15"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 13 && $stage2[1]==16){
	$num_three = "13";
	$num_three2 ="16"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 13 && $stage2[1]==17){
	$num_three = "13";
	$num_three2 ="17"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 13 && $stage2[1]==18){
	$num_three = "13";
	$num_three2 ="18"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 14 && $stage2[1]==15){
	$num_three = "14";
	$num_three2 ="15"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 14 && $stage2[1]==16){
	$num_three = "14";
	$num_three2 ="16"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 14 && $stage2[1]==17){
	$num_three = "14";
	$num_three2 ="17"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 14 && $stage2[1]==18){
	$num_three = "14";
	$num_three2 ="18"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 15 && $stage2[1]==16){
	$num_three = "15";
	$num_three2 ="16"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 15 && $stage2[1]==17){
	$num_three = "15";
	$num_three2 ="17"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 15 && $stage2[1]==18){
	$num_three = "15";
	$num_three2 ="18"; 
	echo paint_three2($num_three,$num_three2);	
	}
else if ($stage2[0] == 16 && $stage2[1]==17){
	$num_three = "16";
	$num_three2 ="17"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 16 && $stage2[1]==18){
	$num_three = "16";
	$num_three2 ="18"; 
	echo paint_three($num_three,$num_three2);	
	}
else if ($stage2[0] == 17 && $stage2[1]==18){
	$num_three = "17";
	$num_three2 ="18"; 
	echo paint_three($num_three,$num_three2);	
	}
}
?>
<? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_three=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_one Where account ='$id'");
		while (list($a_part_three,$m_part_three)=mysql_fetch_row($result_time_part_three)){
			$attime_part_three  = $a_part_three;
			$mttime_part_three  = $m_part_three;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
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
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_three = 0 ;$k_mtotal_part_three<$num_date_rows_part_three;$k_mtotal_part_three++){
	$msum_part_three = 0;
	$mcount_part_three = 0;
	$mtsum_part_three = 0;
	$day_mtotal_mtotal = $days_array_part_three[$k_mtotal_part_three];
	$result_part_three_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 13 or stage = 15 or stage = 16 or stage = 18) and account = '$id'");
	$num_data_mtotal_part_three = mysql_num_rows($result_part_three_2);
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
/*---------------------------------------------------------------------------------------------------------------------*/
?>  
<table width="200" border="0" cellpadding="0">
  <tr>
    <td width="1315">總平均專心數值</td>
    <td width="55"><? echo $attdata_part_three; ?></td>
  </tr>
  <tr>
    <td>總平均放鬆數值</td>
    <td><? echo $mttdata_part_three; ?></td>
  </tr>
  <tr>
    <td>最長專注時間</td>
    <td><? echo $attime_three; ?></td>
  </tr>
  <tr>
    <td>最長放鬆時間</td>
    <td><? echo $mttime_three; ?></td>
  </tr>
</table>

</body>
</html>