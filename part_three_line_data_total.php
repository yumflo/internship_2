<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $date2 = $_SESSION['OrderDate_three'];
 
 echo $date2."<TAG>";
 ?>
<?php
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*資料庫數據*/
/*---------------------------------------------------------------------------------------------------------------------*/
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_total = array();
$x_array = array();
$attention_array = array();
$relax_array = array();
	/*抓取日期資料筆數*/
	if($date2!=null){
	$date_data_total = mysql_query("SELECT  distinct (date) FROM total_data WHERE (stage = 13 or stage = 14 or stage = 15 or stage = 16 or stage = 17 or stage = 18) and account ='$id' and date>='$date2' order by no limit 21");
	}
	else{
	$date_data_total = mysql_query("(SELECT distinct (date) FROM total_data WHERE (stage = 13 or stage = 14 or stage = 15 or stage = 16 or stage = 17 or stage = 18) and account ='$id' order by no DESC limit 21)order by date");
	}
	/*日期有幾筆*/
	$num_date_rows_total = mysql_num_rows($date_data_total);
	/*高值線與低值線*/	
	for($jj_total=0;$jj_total<$num_date_rows_total;$jj_total++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
	/*抓出來的日期丟到陣列內*/
	for($i_total = 0 ;$i_total<$num_date_rows_total;$i_total++){
	while (list($day_total)=mysql_fetch_array($date_data_total)){
	$days_total[] = $day_total;
	}
	/*日期陣列*/
	array_push($days_array_total,$days_total[$i_total]);
	/*X軸的陣列資料*/
	array_push($x_array, date('m/d', strtotime($days_array_total[$i_total])));
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal = 0 ;$k_atotal<$num_date_rows_total;$k_atotal++){
	$asum = 0;
	$acount = 0;
	$atsum = 0;
	$following = 0;
	$day_atotal_atotal = $days_array_total[$k_atotal];
	echo $day_atotal_atotal."<BR>";
	$result=mysql_query("SELECT attention FROM total_data WHERE (stage = 14 or stage = 15 or stage = 17 or stage = 18) and date = '$day_atotal_atotal' and account = '$id'");
	$num_data_atotal = mysql_num_rows($result);
	if($num_data_atotal == "0"){
		$asum = 0;
		$acount = 0;
		$following = 0;
		$last_asum +=$asum;
		$last_acount+=$acount;
		echo $last_asum."<BR>";
		echo $last_acount."<BR>";
		}
	else{
	while (list($a)=mysql_fetch_row($result)){
    $atstring = $a;
	$output_count_atotal = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_atotal = 0 ; $j_atotal<=($output_count_atotal-1) ; $j_atotal++){
		if($atoutput[$j_atotal]<40)
		{
		$following++;
		$asum += $atoutput[$j_atotal];
		}
	}
		$acount+=($output_count_atotal);
	}
	$last_asum +=$asum;
	$last_acount+=$acount;
	echo $last_asum."<BR>";
	echo $last_acount."<BR>";
	$attdata = round (100-(($following / $last_acount)*100),2);
	$last_asum =0;
	$last_acount=0;
	echo $attdata."<BR>";
	array_push($attention_array,$attdata);	
	}
}	
/*----------------------------------------------------------------------------------*/
/*For迴圈 Run日期筆數*/
	for($k_mtotal = 0 ;$k_mtotal<$num_date_rows_total;$k_mtotal++){
	$msum = 0;
	$mcount = 0;
	$mtsum = 0;
	$following= 0;
	$day_mtotal_mtotal = $days_array_total[$k_mtotal];
	echo $day_mtotal_mtotal."<BR>";
	$result=mysql_query("SELECT relax FROM total_data WHERE (stage = 13 or stage = 15 or stage = 16 or stage = 18) and date = '$day_mtotal_mtotal' and account = '$id'");
	$num_data_mtotal = mysql_num_rows($result);
	if($num_data_mtotal == "0"){
		$msum = 0;
		$mcount = 0;
		$following= 0;
		$last_sum +=$msum;
		$last_count+=$mcount;
		echo $last_msum."<BR>";
		echo $last_mcount."<BR>";
		}
	else{
	while (list($m)=mysql_fetch_row($result)){
    $mtstring = $m;
	$output_count_mtotal = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_mtotal = 0 ; $j_mtotal<=($output_count_mtotal-1) ; $j_mtotal++){
		if($mtoutput[$j_mtotal]<40)
		{
		$following++;
		$msum += $mtoutput[$j_mtotal];
		}
	}
		$mcount+=($output_count_mtotal);
	}
	$last_msum +=$msum;
	$last_mcount+=$mcount;
	echo $last_msum."<BR>";
	echo $last_mcount."<BR>";
	$mttdata = round (100-(($following / $last_mcount)*100),2);
	$last_msum =0;
	$last_mcount=0;
	echo $mttdata."<BR>";
	array_push($relax_array,$mttdata);	
	}
}
unset($_SESSION['OrderDate_three']);
/*---------------------------------------------------------------------------------------------------------------------*/
$title =$date2.'總平均 腦波折線圖';
$key_array = array('專心度', '放鬆度');
//資料陣列
$data_array = array($attention_array,$relax_array);
$level_array = array();
$level_array2 = array();

//將設定參數傳入繪製統計圖
echo part_chart('null','null');
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2);
?>

