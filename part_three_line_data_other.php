<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_three'];
 $stage2 = $_SESSION['part_three2'];
 ?>
<?php
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*資料庫數據*/
/*日期資料*/
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_15 = array();
$days_array_18 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_15 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows_15 = mysql_num_rows($date_data_15);
	/*抓取日期資料筆數*/
	$date_data_18 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows_18 = mysql_num_rows($date_data_18);
	if($num_date_rows_15>$num_date_rows_18)
	{
	/*高值線與低值線*/	
	for($jj_15=0;$jj_15<$num_date_rows_15;$jj_15++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_18=0;$jj_18<$num_date_rows_18;$jj_18++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	/*X軸的陣列資料*/
	array_push($x_array,$jj_18+1);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_15 = 0 ;$i_15<$num_date_rows_15;$i_15++){
	while (list($day_15)=mysql_fetch_array($date_data_15)){
	$days_15[] = $day_15;
	}
	/*第一關日期陣列*/	
	array_push($days_array_15,$days_15[$i_15]);
	/*X軸的陣列資料*/
	if($num_date_rows_15>=$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_15[$i_15])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_18 = 0 ;$i_18<$num_date_rows_18;$i_18++){
	while (list($day_18)=mysql_fetch_array($date_data_18)){
	$days_18[] = $day_18;
	}
	/*第二關日期陣列*/	
	array_push($days_array_18,$days_18[$i_18]);
	/*X軸的陣列資料*/
	if($num_date_rows_15<$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_18[$i_18])));
	}	
	/*測驗數據資料*/
$attention_array_15 = array();
$relax_array_15 = array();
$attention_array_18 = array();
$relax_array_18 = array();
	/*For迴圈 Run日期筆數*/
	for($k_15 = 0 ;$k_15<$num_date_rows_15;$k_15++){
	$rsum_15 = 0;
	$asum_15 = 0;
	
	$day_15_15 = $days_array_15[$k_15];
	/*抓取有幾次測驗*/
	$count_data_15 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_15_15' and stage = '15'");
	$num_count_rows_15 = mysql_num_rows($count_data_15);
	/*For迴圈 Run測驗筆數*/
	for($ii_15 = 0 ;$ii_15<$num_count_rows_15;$ii_15++){
	list($count_15)=mysql_fetch_array($count_data_15);
		/*測驗資料丟到陣列*/
		$counts_15[$ii_15] = $count_15;
		}
			
	for($i_15_15 = 0 ;$i_15_15<$num_count_rows_15;$i_15_15++){
	$mtsum_15 = 0;
	$atsum_15 =0;
	$following_a = 0;
	$following_r = 0;
	$counts_data_15 = $counts_15[$i_15_15];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_15 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($atoutput[$j_15]<40)
		{
			$following_a++;
		}
		$atsum_15 += $atoutput[$j_15];
		}
	$atresum =  $following_a / ($output_count_15);
	}
	$asum_15 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
		$mtstring  = $m;
	$output_count_15 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($mtoutput[$j_15]<40)
		{
			$following_r++;
		}
		$mtsum_15 += $mtoutput[$j_15];
		}
	$mtresum =  $following_r / ($output_count_15);
	}
	$rsum_15 += $mtresum;
}
$asums = round (100-($atresum / $num_count_rows_15*100),2);
array_push($attention_array_15,$asums);
$rsums = round (100-($mtresum / $num_count_rows_15*100),2);
array_push($relax_array_15,$rsums);
}
/*For迴圈 Run日期筆數*/
	for($k_18 = 0 ;$k_18<$num_date_rows_18;$k_18++){
	$rsum_18 = 0;
	$asum_18 = 0;
	
	$day_18_18 = $days_array_18[$k_18];
	/*抓取有幾次測驗*/
	$count_data_18 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_18_18' and stage = '18'");
	$num_count_rows_18 = mysql_num_rows($count_data_18);
	/*For迴圈 Run測驗筆數*/
	for($ii_18 = 0 ;$ii_18<$num_count_rows_18;$ii_18++){
	list($count_18)=mysql_fetch_array($count_data_18);
		/*測驗資料丟到陣列*/
		$counts_18[$ii_18] = $count_18;
		}
			
	for($i_18_18 = 0 ;$i_18_18<$num_count_rows_18;$i_18_18++){
	$mtsum_18 = 0;
	$atsum_18 =0;
	$following_a = 0;
	$following_r = 0;
	$counts_data_18 = $counts_18[$i_18_18];


	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	while (list($a)=mysql_fetch_row($result)){
	$atstring  = $a;
	$output_count_18 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($atoutput[$j_18]<40)
		{
			$following_a++;
		}
		$atsum_18 += $atoutput[$j_18];
		}
	$atresum =  $following_a / ($output_count_18);
	}
	$asum_18 += $atresum;
		
	while (list($m)=mysql_fetch_row($result2)){
	$mtstring  = $m;
	$output_count_18 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($mtoutput[$j_18]<40)
		{
			$following_r++;
		}
		$mtsum_18 += $mtoutput[$j_18];
		}
	$mtresum =  $following_r / ($output_count_18);
	}
	$rsum_18 += $mtresum;
}
$asums = round (100-($atresum / $num_count_rows_18*100),2);
array_push($attention_array_18,$asums);
$rsums = round (100-($mtresum / $num_count_rows_18*100),2);
array_push($relax_array_18,$rsums);
}
$title ='關卡十五 與 關卡十八 腦波折線圖';
$key_array = array('關卡十五(專心度)', '關卡十八(放鬆度)');			
//資料陣列
$data_array = array($attention_array_15,$relax_array_15);
$data_array2 = array($attention_array_18);
$data_array3 = array($relax_array_18);
$level_array = array();
$level_array2 = array();
//將設定參數傳入繪製統計圖
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2 ,$data_array2,$data_array3,$stage,$stage2);
?>

