<?
$id="qwe";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/19219/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-20" />
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
        <input type="checkbox" name="CheckboxGroup_four[]" value="19"/>
        Stage 19</label>
<label>
        <input type="checkbox" name="CheckboxGroup_four[]" value="20"/>
        Stage 20</label>
<label>
        <input type="checkbox" name="CheckboxGroup_four[]" value="21"/>
        Stage 21</label>
<input name="submit" type="submit" value="Submit" />
        
</form>

<form>
<?
function paint_four($get_num_four,$get_num_four2){
session_start();
$_SESSION['part_four'] = $get_num_four;
$_SESSION['part_four2'] = $get_num_four2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(1900, 300, 'part_four_line_data.php?type='));	
}
function paint_four2($get_num_four,$get_num_four2){
session_start();
$_SESSION['part_four'] = $get_num_four;
$_SESSION['part_four2'] = $get_num_four2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(650, 300, 'part_four_line_data_other.php?type='));	
}
function paint_four3($get_num_four,$get_num_four2){
session_start();
$_SESSION['part_four'] = $get_num_four;
$_SESSION['part_four2'] = $get_num_four2;
include_once('php-ofc-library/line_for_chart.php');
echo(chart_str(1900, 300, 'part_four_line_data_total.php?type='));	
}
?>
</form>
<?
if( $_POST['CheckboxGroup_four'] == null ){
	$num_four = null;
	$num_four2 = null; 
	echo paint_four3($num_four,$num_four2);	
}
else{
foreach($_POST['CheckboxGroup_four'] as $stage2[]);
if ($stage2[0] == 19 && $stage2[1]==null){
	$num_four = "19";
	$num_four2 ="null"; 
	echo paint_four($num_four,$num_four2);	
	}
else if ($stage2[0] == 20 && $stage2[1]==null){
	$num_four = "20";
	$num_four2 ="null"; 
	echo paint_four($num_four,$num_four2);	
	}
else if ($stage2[0] == 21 && $stage2[1]==null){
	$num_four = "21";
	$num_four2 ="null"; 
	echo paint_four($num_four,$num_four2);	
	}

else if ($stage2[0] == 19 && $stage2[1]==20){
	$num_four = "19";
	$num_four2 ="20"; 
	echo paint_four($num_four,$num_four2);	
	}
else if ($stage2[0] == 19 && $stage2[1]==21){
	$num_four = "19";
	$num_four2 ="21"; 
	echo paint_four($num_four,$num_four2);	
	}
else if ($stage2[0] == 20 && $stage2[1]==21){
	$num_four = "19";
	$num_four2 ="10"; 
	echo paint_four($num_four,$num_four2);	
	}
}
?>
<? 
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
$result_time_part_four=mysql_query("SELECT Max(LongATN) , Max(LongMTN) FROM part_one Where account ='$id'");
		while (list($a_part_four,$m_part_four)=mysql_fetch_row($result_time_part_four)){
			$attime_part_four  = $a_part_four;
			$mttime_part_four  = $m_part_four;
		}
/*---------------------------------------------------------------------------------------------------------------------*/
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
	$result_part_four=mysql_query("SELECT attention FROM total_data WHERE (stage = 20 or stage = 21 or stage = 11 or stage = 12) and account = '$id'");
	$num_data_atotal_part_four = mysql_num_rows($result_part_four);
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
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal_part_four = 0 ;$k_mtotal_part_four<$num_date_rows_part_four;$k_mtotal_part_four++){
	$msum_part_four = 0;
	$mcount_part_four = 0;
	$mtsum_part_four = 0;
	$day_mtotal_mtotal = $days_array_part_four[$k_mtotal_part_four];
	$result_part_four_2=mysql_query("SELECT relax FROM total_data WHERE (stage = 19 or stage = 21 or stage = 10 or stage = 12) and account = '$id'");
	$num_data_mtotal_part_four = mysql_num_rows($result_part_four_2);
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
/*---------------------------------------------------------------------------------------------------------------------*/
?>  
<table width="200" border="0" cellpadding="0">
  <tr>
    <td width="1321">總平均專心數值</td>
    <td width="55"><? echo $attdata_part_four; ?></td>
  </tr>
  <tr>
    <td>總平均放鬆數值</td>
    <td><? echo $mttdata_part_four; ?></td>
  </tr>
  <tr>
    <td>最長專注時間</td>
    <td><? echo $attime_four; ?></td>
  </tr>
  <tr>
    <td>最長放鬆時間</td>
    <td><? echo $mttime_four; ?></td>
  </tr>
</table>

</body>
</html>