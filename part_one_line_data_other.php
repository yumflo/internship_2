<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_one'];
 $stage2 = $_SESSION['part_one2'];
 ?>
<?php
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*資料庫數據*/
/*日期資料*/
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_3 = array();
$days_array_6 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_3 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
	/*日期有幾筆*/
	$num_date_rows_3 = mysql_num_rows($date_data_3);
	/*抓取日期資料筆數*/
	$date_data_6 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
	/*日期有幾筆*/
	$num_date_rows_6 = mysql_num_rows($date_data_6);
	if($num_date_rows_3>$num_date_rows_6)
	{
	/*高值線與低值線*/	
	for($jj_3=0;$jj_3<$num_date_rows_3;$jj_3++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_6=0;$jj_6<$num_date_rows_6;$jj_6++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_3 = 0 ;$i_3<$num_date_rows_3;$i_3++){
	while (list($day_3)=mysql_fetch_array($date_data_3)){
	$days_3[] = $day_3;
	}
	/*第一關日期陣列*/	
	array_push($days_array_3,$days_3[$i_3]);
	/*X軸的陣列資料*/
	if($num_date_rows_3>=$num_date_rows_6)
	array_push($x_array, date('m/d', strtotime($days_3[$i_3])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_6 = 0 ;$i_6<$num_date_rows_6;$i_6++){
	while (list($day_6)=mysql_fetch_array($date_data_6)){
	$days_6[] = $day_6;
	}
	/*第二關日期陣列*/	
	array_push($days_array_6,$days_6[$i_6]);
	/*X軸的陣列資料*/
	if($num_date_rows_3<$num_date_rows_6)
	array_push($x_array, date('m/d', strtotime($days_6[$i_6])));
	}	
	/*測驗數據資料*/
$attention_array_3 = array();
$relax_array_3 = array();
$attention_array_6 = array();
$relax_array_6 = array();
	/*For迴圈 Run日期筆數*/
	for($k_3 = 0 ;$k_3<$num_date_rows_3;$k_3++){
	$rsum_3 = 0;
	$asum_3 = 0;
	
	$day_3_3 = $days_array_3[$k_3];
	/*抓取有幾次測驗*/
	$count_data_3 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_3_3' and stage = '3'");
	$num_count_rows_3 = mysql_num_rows($count_data_3);
	/*For迴圈 Run測驗筆數*/
	for($ii_3 = 0 ;$ii_3<$num_count_rows_3;$ii_3++){
	list($count_3)=mysql_fetch_array($count_data_3);
		/*測驗資料丟到陣列*/
		$counts_3[$ii_3] = $count_3;
		}
			
	for($i_3_3 = 0 ;$i_3_3<$num_count_rows_3;$i_3_3++){
	$mtsum_3 = 0;
	$atsum_3 =0;
	$following_a = 0;
	$following_r = 0;
	$counts_data_3 = $counts_3[$i_3_3];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_3 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($atoutput[$j_3]<40)
		{
			$following_a++;
		}
		$atsum_3 += $atoutput[$j_3];
		}
	$atresum =  $following_a / ($output_count_3);
	}
	$asum_3 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
		$mtstring  = $m;
	$output_count_3 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($mtoutput[$j_3]<40)
		{
			$following_r++;
		}
		$mtsum_3 += $mtoutput[$j_3];
		}
	$mtresum =  $following_r / ($output_count_3);
	}
	$rsum_3 += $mtresum;
}
$asums = round (100-($atresum / $num_count_rows_3*100),2);
array_push($attention_array_3,$asums);
$rsums = round (100-($mtresum / $num_count_rows_3*100),2);
array_push($relax_array_3,$rsums);
}
/*For迴圈 Run日期筆數*/
	for($k_6 = 0 ;$k_6<$num_date_rows_6;$k_6++){
	$rsum_6 = 0;
	$asum_6 = 0;
	
	$day_6_6 = $days_array_6[$k_6];
	/*抓取有幾次測驗*/
	$count_data_6 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_6_6' and stage = '6'");
	$num_count_rows_6 = mysql_num_rows($count_data_6);
	/*For迴圈 Run測驗筆數*/
	for($ii_6 = 0 ;$ii_6<$num_count_rows_6;$ii_6++){
	list($count_6)=mysql_fetch_array($count_data_6);
		/*測驗資料丟到陣列*/
		$counts_6[$ii_6] = $count_6;
		}
			
	for($i_6_6 = 0 ;$i_6_6<$num_count_rows_6;$i_6_6++){
	$mtsum_6 = 0;
	$atsum_6 =0;
	$following_r = 0;
	$following_a = 0;
	$counts_data_6 = $counts_6[$i_6_6];

	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_6 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($atoutput[$j_6]<40)
		{
			$following_a++;
		}
		$atsum_6 += $atoutput[$j_6];
		}
	$atresum =  $following_a / ($output_count_6);
	}
	$asum_6 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
	$mtstring  = $m;
	$output_count_6 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($mtoutput[$j_6]<40)
		{
			$following_r++;
		}
		$mtsum_6 += $mtoutput[$j_6];
		}
	$mtresum =  $following_r / ($output_count_6);
	}
	$rsum_6 += $mtresum;
}
$asums = round (100-($asum_6 / $num_count_rows_6*100),2);
array_push($attention_array_6,$asums);
$rsums = round (100-($rsum_6 / $num_count_rows_6*100),2);
array_push($relax_array_6,$rsums);
}
$title ='關卡三 與 關卡六 腦波折線圖';
$key_array = array('關卡三(專心度)', '關卡三(放鬆度)');			
//資料陣列
$data_array = array($attention_array_3,$relax_array_3);
$data_array2 = array($attention_array_6);
$data_array3 = array($relax_array_6);
$level_array = array();
$level_array2 = array();
//將設定參數傳入繪製統計圖
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2 ,$data_array2,$data_array3,$stage,$stage2);
?>

