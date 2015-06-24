<?php
session_start();
 $id = $_SESSION['MM_Student'];
 ?>
<?php
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*---------------------------------------------------------------------------------------------------------------------*/
/*資料庫數據*/
$days_array_total = array();
$num1 = 0;
$num2 = 0;
$num3 = 0;
$num4 = 0;
$num5 = 0;
	/*抓取日期資料筆數*/
	$date_data_total = mysql_query("SELECT distinct (date) FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6 or stage = 7 or stage = 9 or stage = 10 or stage = 12) and account ='$id'");
	/*日期有幾筆*/
	$num_date_rows_total = mysql_num_rows($date_data_total);
	/*高值線與低值線*/	
	for($jj_total=0;$jj_total<$num_date_rows_total;$jj_total++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	/*X軸的陣列資料*/
	array_push($x_array,$jj_total+1);
	}
	/*抓出來的日期丟到陣列內*/
	for($i_total = 0 ;$i_total<$num_date_rows_total;$i_total++){
	while (list($day_total)=mysql_fetch_array($date_data_total)){
	$days_total[] = $day_total;
	}
	/*日期陣列*/
	array_push($days_array_total,$days_total[$i_total]);
	}

/*For迴圈 Run日期筆數*/
	for($k_atotal = 0 ;$k_atotal<$num_date_rows_total;$k_atotal++){
	$asum = 0;
	$acount = 0;
	$atsum = 0;
	$day_atotal_atotal = $days_array_total[$k_atotal];
	echo $day_atotal_atotal."<BR>";
	$result=mysql_query("SELECT relax FROM total_data WHERE (stage = 1 or stage = 3 or stage = 4 or stage = 6 or stage = 7 or stage = 9 or stage = 10 or stage = 12) and date = '$day_atotal_atotal' and account = '$id'");
	$num_data_atotal = mysql_num_rows($result);
	if($num_data_atotal == "0"){
		$asum = 0;
		$acount = 0;
		$last_asum +=$asum;
		$last_acount+=$acount;
		}
	else{
	while (list($a)=mysql_fetch_row($result)){
    $atstring = $a;
	$output_count_atotal = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_atotal = 0 ; $j_atotal<=$output_count_atotal ; $j_atotal++){
		if($atoutput[$j_atotal]>0 && $atoutput[$j_atotal]<=20){
			$num1++;
			}
		else if($atoutput[$j_atotal]>20 && $atoutput[$j_atotal]<=40){
			$num2++;
			
			}
		else if($atoutput[$j_atotal]>40 && $atoutput[$j_atotal]<=60){
			$num3++;
			
			}
		else if($atoutput[$j_atotal]>60 && $atoutput[$j_atotal]<=80){
			$num4++;
			
			}
		else if($atoutput[$j_atotal]>80 && $atoutput[$j_atotal]<=100){
			$num5++;
			
			}
	}
		$acount+=($output_count_atotal);
	}
	$last_acount+=$acount;
	echo $last_acount."<BR>";
	}
	if($num1==0){
		$asum1 = 0;
		$label_1 = 'null';
		}
	else{
		$asum1 = round ($num1 / $last_acount,4);	
		$label_1 = '0~20';
		}
	if($num2==0){
		$asum2 = 0;
		$label_2 = 'null';
		}
	else{
		$asum2 = round ($num2 / $last_acount,4);	
		$label_2 = '20~40';
		}	
	if($num3==0){
		$asum3 = 0;
		$label_3 = 'null';
		}
	else{
		$asum3 = round ($num3 / $last_acount,4);	
		$label_3 = '40~60';
		}
	if($num4==0){
		$asum4 = 0;
		$label_4 = 'null';
		}
	else{
		$asum4 = round ($num4 / $last_acount,4);	
		$label_4 = '60~80';
		}
	if($num5==0){
		$asum5 = 0;
		$label_5 = 'null';
		}
	else{
		$asum5 = round ($num5 / $last_acount,4);	
		$label_5 = '80~100';
		}	
}	
/*---------------------------------------------------------------------------------------------------------------------*/
//圖表標題
$title = '放鬆值';
//資料列名稱
$label_array = array($label_1,$label_2,$label_3,$label_4,$label_5);
//資料陣列
$data_array = array(
	array($asum1,$asum2,$asum3,$asum4,$asum5),
);
$key_array = array('0', '0');
//將設定參數傳入繪製統計圖
echo part_chart('null','null');
echo chart('pie', $title, $label_array, $key_array, $data_array);


?>
