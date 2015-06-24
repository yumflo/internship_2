<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_two'];
 $stage2 = $_SESSION['part_two2'];
 ?>
<?php
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*資料庫數據*/
/*日期資料*/
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_9 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_9 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
	/*日期有幾筆*/
	$num_date_rows_9 = mysql_num_rows($date_data_9);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_9>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_9=0;$jj_9<$num_date_rows_9;$jj_9++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_12=0;$jj_12<$num_date_rows_12;$jj_12++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_9 = 0 ;$i_9<$num_date_rows_9;$i_9++){
	while (list($day_9)=mysql_fetch_array($date_data_9)){
	$days_9[] = $day_9;
	}
	/*第一關日期陣列*/	
	array_push($days_array_9,$days_9[$i_9]);
	/*X軸的陣列資料*/
	if($num_date_rows_9>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_9[$i_9])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_9<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
$attention_array_9 = array();
$relax_array_9 = array();
$attention_array_12 = array();
$relax_array_12 = array();
	/*For迴圈 Run日期筆數*/
	for($k_9 = 0 ;$k_9<$num_date_rows_9;$k_9++){
	$rsum_9 = 0;
	$asum_9 = 0;
	
	$day_9_9 = $days_array_9[$k_9];
	/*抓取有幾次測驗*/
	$count_data_9 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_9_9' and stage = '9'");
	$num_count_rows_9 = mysql_num_rows($count_data_9);
	/*For迴圈 Run測驗筆數*/
	for($ii_9 = 0 ;$ii_9<$num_count_rows_9;$ii_9++){
	list($count_9)=mysql_fetch_array($count_data_9);
		/*測驗資料丟到陣列*/
		$counts_9[$ii_9] = $count_9;
		}
			
	for($i_9_9 = 0 ;$i_9_9<$num_count_rows_9;$i_9_9++){
	$mtsum_9 = 0;
	$atsum_9 =0;
	$following_a = 0;
	$following_r = 0;
	$counts_data_9 = $counts_9[$i_9_9];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_9 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($atoutput[$j_9]<40)
		{
			$following_a++;
		}
		$atsum_9 += $atoutput[$j_9];
		}
	$atresum =  $following_a / ($output_count_9);
	}
	$asum_9 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
		$mtstring  = $m;
	$output_count_9 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($mtoutput[$j_9]<40)
		{
			$following_r++;
		}
		$mtsum_9 += $mtoutput[$j_9];
		}
	$mtresum =  $following_r / ($output_count_9);
	}
	$rsum_9 += $mtresum;
}
$asums = round (100-($atresum / $num_count_rows_9*100),2);
array_push($attention_array_9,$asums);
$rsums = round (100-($mtresum / $num_count_rows_9*100),2);
array_push($relax_array_9,$rsums);
}
/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$rsum_12 = 0;
	$asum_12 = 0;
	
	$day_12_12 = $days_array_12[$k_12];
	/*抓取有幾次測驗*/
	$count_data_12 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_12_12' and stage = '12'");
	$num_count_rows_12 = mysql_num_rows($count_data_12);
	/*For迴圈 Run測驗筆數*/
	for($ii_12 = 0 ;$ii_12<$num_count_rows_12;$ii_12++){
	list($count_12)=mysql_fetch_array($count_data_12);
		/*測驗資料丟到陣列*/
		$counts_12[$ii_12] = $count_12;
		}
			
	for($i_12_12 = 0 ;$i_12_12<$num_count_rows_12;$i_12_12++){
	$mtsum_12 = 0;
	$atsum_12 =0;
	$following_a = 0;
	$following_r = 0;
	$counts_data_12 = $counts_12[$i_12_12];


	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_12 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_12 = 0 ; $j_12<=$output_count_12-1 ; $j_12++){
		if($atoutput[$j_12]<40)
		{
			$following_a++;
		}
		$atsum_12 += $atoutput[$j_12];
		}
	$atresum =  $following_a / ($output_count_12);
	}
	$asum_12 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
	$mtstring  = $m;
	$output_count_12 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_12 = 0 ; $j_12<=$output_count_12-1 ; $j_12++){
		if($mtoutput[$j_12]<40)
		{
			$following_r++;
		}
		$mtsum_12 += $mtoutput[$j_12];
		}
	$mtresum =  $following_r / ($output_count_12);
	}
	$rsum_12 += $mtresum;
}
$asums = round (100-($atresum / $num_count_rows_12*100),2);
array_push($attention_array_12,$asums);
$rsums = round (100-($mtresum / $num_count_rows_12*100),2);
array_push($relax_array_12,$rsums);
}
$title ='關卡九 與 關卡十二 腦波折線圖';
$key_array = array('關卡九(專心度)', '關卡九(放鬆度)');			
//資料陣列
$data_array = array($attention_array_9,$relax_array_9);
$data_array2 = array($attention_array_12);
$data_array3 = array($relax_array_12);
$level_array = array();
$level_array2 = array();
//將設定參數傳入繪製統計圖
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2 ,$data_array2,$data_array3,$stage,$stage2);
?>

