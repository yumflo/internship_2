<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_three'];
 $stage2 = $_SESSION['part_three2'];
 echo  $id."<TAG>"; 
 echo  $stage."<TAG>";
 echo  $stage2."<TAG>";
 ?>
<?
//include
include_once('php-ofc-library/line_for_chart.php');
require("Connections/conndb.php");
/*資料庫數據*/
//------------------------------------------------------------------------------------------------------\\
if($stage == 13 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array, date('m/d', strtotime($days[$i])));
		}
		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '13'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$mtsum = 0;
		$following = 0;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day' AND account ='$id' and stage = '13' and count = '$counts_data'");
		while (list($m)=mysql_fetch_row($result)){
			$mtstring  = $m;
		$output_count = substr_count($mtstring,",");
		$mtoutput = explode(",", $mtstring);
		for($j = 0 ; $j<=$output_count-1 ; $j++){
			if($mtoutput[$j]<40)
			{
				$following++;
			}
			$mtsum += $mtoutput[$j];
			}
		$mtresum =  $following / ($output_count) ;
		}
		$rsum += $mtresum;
	}
	$rsums = round (100-($rsum / $num_count_rows*100),2);
	array_push($relax_array,$rsums);
	}	
$title ='關卡十三(放鬆度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 14 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array,date('m/d', strtotime($days_array[$i])));
		}

		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '14'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$atsum = 0;
		$mtsum = 0;
		$following = 0 ;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day' AND account ='$id' and stage = '14' and count = '$counts_data'");
		while (list($a)=mysql_fetch_row($result)){
			$atstring  = $a;
	$output_count = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($atoutput[$j]<40)
		{
			$following++;
		}
		$atsum += $atoutput[$j];
		}
		$atresum =  $following / ($output_count) ;
	}
		$asum += $atresum;	
}
$asums = round (100-($asum / $num_count_rows*100),2);
array_push($attention_array,$asums);
		}
$title ='關卡十四(專心度) 腦波折線圖';
$key_array = array('關卡十四(專心度)');	
$data_array = array($attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 15 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array,date('m/d', strtotime($days_array[$i])));
		}

		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '15'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$atsum = 0;
		$mtsum = 0;
		$following_a = 0;
		$following_r = 0;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day' AND account ='$id' and stage = '15' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day' AND account ='$id' and stage = '15' and count = '$counts_data'");
	while (list($a)=mysql_fetch_row($result)){
			$atstring  = $a;
	$output_count = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($atoutput[$j]<40)
		{
			$following_a++;
		}
		$atsum += $atoutput[$j];
		}
		$atresum =  $following_a / ($output_count) ;
	}
		$asum += $atresum;
	while (list($m)=mysql_fetch_row($result2)){
			$mtstring  = $m;
	$output_count = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($mtoutput[$j]<40)
		{
			$following_r++;
		}
		$mtsum += $mtoutput[$j];
		}
		$mtresum =  $following_r / ($output_count) ;
	}
		$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows*100),2);
$asums = round (100-($asum / $num_count_rows*100),2);

array_push($attention_array,$asums);
array_push($relax_array,$rsums);
		}
$title ='關卡十五(專心度) 與 關卡十五(放鬆度) 腦波折線圖';
$key_array = array('關卡十五(專心度)', '關卡十五(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}

//------------------------------------------------------------------------------------------------------\\
if($stage == 16 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array,date('m/d', strtotime($days_array[$i])));
		}

		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '16'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$mtsum = 0;
		$following = 0 ;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day' AND account ='$id' and stage = '16' and count = '$counts_data'");
		while (list($m)=mysql_fetch_row($result)){
			$mtstring  = $m;
		$output_count = substr_count($mtstring,",");
		$mtoutput = explode(",", $mtstring);
		for($j = 0 ; $j<=$output_count-1 ; $j++){
			if($mtoutput[$j]<40)
			{
				$following++;
			}
			$mtsum += $mtoutput[$j];
			}
		$mtresum =  $following / ($output_count) ;
		}
		$rsum += $mtresum;
	}
	$rsums = round (100-($rsum / $num_count_rows*100),2);
	array_push($relax_array,$rsums);
	}
$title ='關卡十六(放鬆度) 腦波折線圖';
$key_array = array('關卡十六(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 17 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array,date('m/d', strtotime($days_array[$i])));
		}

		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '17'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$atsum = 0;
		$mtsum = 0;
		$following = 0;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day' AND account ='$id' and stage = '17' and count = '$counts_data'");
		while (list($a)=mysql_fetch_row($result)){
			$atstring  = $a;
	$output_count = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($atoutput[$j]<40)
		{
			$following++;
		}
		$atsum += $atoutput[$j];
		}
		$atresum =  $following / ($output_count) ;
	}
		$asum += $atresum;	
}
$asums = round (100-($asum / $num_count_rows*100),2);
array_push($attention_array,$asums);
		}
$title ='關卡十七(專心度) 腦波折線圖';
$key_array = array('關卡十七(專心度)');
$data_array = array($attention_array);	
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 18 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows = mysql_num_rows($date_data);
	/*高值線與低值線*/	
		for($j=0;$j<$num_date_rows;$j++){
		array_push($high_level_line_data,60);
		array_push($low_level_line_data,40);
		}
	/*抓出來的日期丟到陣列內*/
		for($i = 0 ;$i<$num_date_rows;$i++){
		while (list($day)=mysql_fetch_array($date_data)){
		$days[] = $day;
		}
		/*日期陣列*/	
		array_push($days_array,$days[$i]);
		/*X軸的陣列資料*/
		array_push($x_array,date('m/d', strtotime($days_array[$i])));
		}

		/*測驗數據資料*/
		$attention_array = array();
		$relax_array = array();
		/*For迴圈 Run日期筆數*/
		for($k = 0 ;$k<$num_date_rows;$k++){
		$asum = 0;
		$rsum = 0;
		
		$day = $days_array[$k];
		/*抓取有幾次測驗*/
		$count_data = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day' and stage = '18'");
		$num_count_rows = mysql_num_rows($count_data);
		/*For迴圈 Run測驗筆數*/
		for($ii = 0 ;$ii<$num_count_rows;$ii++){
		list($count)=mysql_fetch_array($count_data);
			/*測驗資料丟到陣列*/
			$counts[$ii] = $count;
			}
			
		for($i = 0 ;$i<$num_count_rows;$i++){
		$atsum = 0;
		$mtsum = 0;
		$following_a = 0;
		$following_r = 0;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day' AND account ='$id' and stage = '18' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day' AND account ='$id' and stage = '18' and count = '$counts_data'");
	while (list($a)=mysql_fetch_row($result)){
			$atstring  = $a;
	$output_count = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($atoutput[$j]<40)
		{
			$following_a++;
		}
		$atsum += $atoutput[$j];
		}
		$atresum =  $following_a / ($output_count) ;
	}
		$asum += $atresum;
	while (list($m)=mysql_fetch_row($result2)){
			$mtstring  = $m;
	$output_count = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j = 0 ; $j<=$output_count-1 ; $j++){
		if($mtoutput[$j]<40)
		{
			$following_r++;
		}
		$mtsum += $mtoutput[$j];
		}
		$mtresum =  $following_r / ($output_count) ;
	}
		$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows*100),2);
$asums = round (100-($asum / $num_count_rows*100),2);
array_push($attention_array,$asums);
array_push($relax_array,$rsums);
		}
$title ='關卡十八(專心度) 與 關卡十八(放鬆度) 腦波折線圖';
$key_array = array('關卡十八(專心度)', '關卡十八(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 13 and $stage2 == 14){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_13 = array();
$days_array_14 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_13 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows_13 = mysql_num_rows($date_data_13);
	/*抓取日期資料筆數*/
	$date_data_14 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows_14 = mysql_num_rows($date_data_14);
	if($num_date_rows_13>$num_date_rows_14)
	{
	/*高值線與低值線*/	
	for($jj_13=0;$jj_13<$num_date_rows_13;$jj_13++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_14=0;$jj_14<$num_date_rows_14;$jj_14++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_13 = 0 ;$i_13<$num_date_rows_13;$i_13++){
	while (list($day_13)=mysql_fetch_array($date_data_13)){
	$days_13[] = $day_13;
	}
	/*第一關日期陣列*/	
	array_push($days_array_13,$days_13[$i_13]);
	/*X軸的陣列資料*/
	if($num_date_rows_13>=$num_date_rows_14)
	array_push($x_array,date('m/d', strtotime($days_13[$i_13])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_14 = 0 ;$i_14<$num_date_rows_14;$i_14++){
	while (list($day_14)=mysql_fetch_array($date_data_14)){
	$days_14[] = $day_14;
	}
	/*第二關日期陣列*/	
	array_push($days_array_14,$days_14[$i_14]);
	/*X軸的陣列資料*/
	if($num_date_rows_13<$num_date_rows_14)
	array_push($x_array,date('m/d', strtotime($days_14[$i_14])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_13 = 0 ;$k_13<$num_date_rows_13;$k_13++){
	$rsum = 0;
	
	$day_13_13 = $days_array_13[$k_13];
	/*抓取有幾次測驗*/
	$count_data_13 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_13_13' and stage = '13'");
	$num_count_rows_13 = mysql_num_rows($count_data_13);
	/*For迴圈 Run測驗筆數*/
	for($ii_13 = 0 ;$ii_13<$num_count_rows_13;$ii_13++){
	list($count_13)=mysql_fetch_array($count_data_13);
		/*測驗資料丟到陣列*/
		$counts_13[$ii_13] = $count_13;
		}
			
	for($i_13_13 = 0 ;$i_13_13<$num_count_rows_13;$i_13_13++){
	$mtsum = 0;
	$following = 0;
	$counts_data_13 = $counts_13[$i_13_13];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_13_13' AND account ='$id' and stage = '13' and count = '$counts_data_13'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_13 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_13 = 0 ; $j_13<=$output_count_13-1 ; $j_13++){
		if($mtoutput[$j_13]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_13];
		}
	$mtresum =  $following / ($output_count_13);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_13*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_14 = 0 ;$k_14<$num_date_rows_14;$k_14++){
	$asum = 0;
	
	$day_14_14 = $days_array_14[$k_14];
	/*抓取有幾次測驗*/
	$count_data_14 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_14_14' and stage = '14'");
	$num_count_rows_14 = mysql_num_rows($count_data_14);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_14 = 0 ;$ii_14<$num_count_rows_14;$ii_14++){
	list($count_14)=mysql_fetch_array($count_data_14);
		/*測驗資料丟到陣列*/
		$counts_14[$ii_14] = $count_14;
		}
			
	for($i_14_14 = 0 ;$i_14_14<$num_count_rows_14;$i_14_14++){
	$atsum = 0;
	$following = 0;
	$counts_data_14 = $counts_14[$i_14_14];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_14_14' AND account ='$id' and stage = '14' and count = '$counts_data_14'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_14 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_14 = 0 ; $j_14<=$output_count_14-1 ; $j_14++){
		if($atoutput[$j_14]<40)
		{
			$following++;
		}
		echo $atoutput[$j_14];
		$atsum += $atoutput[$j_14];
		}
	$atresum =  $following / ($output_count_14);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_14*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十三(放鬆度) 與 關卡十四(專心度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)', ' 關卡十四(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 13 and $stage2 == 15){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_13 = array();
$days_array_15 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_13 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows_13 = mysql_num_rows($date_data_13);
	/*抓取日期資料筆數*/
	$date_data_15 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows_15 = mysql_num_rows($date_data_15);
	if($num_date_rows_13>$num_date_rows_15)
	{
	/*高值線與低值線*/	
	for($jj_13=0;$jj_13<$num_date_rows_13;$jj_13++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_15=0;$jj_15<$num_date_rows_15;$jj_15++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_13 = 0 ;$i_13<$num_date_rows_13;$i_13++){
	while (list($day_13)=mysql_fetch_array($date_data_13)){
	$days_13[] = $day_13;
	}
	/*第一關日期陣列*/	
	array_push($days_array_13,$days_13[$i_13]);
	/*X軸的陣列資料*/
	if($num_date_rows_13>=$num_date_rows_15)
	array_push($x_array,date('m/d', strtotime($days_13[$i_13])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_15 = 0 ;$i_15<$num_date_rows_15;$i_15++){
	while (list($day_15)=mysql_fetch_array($date_data_15)){
	$days_15[] = $day_15;
	}
	/*第二關日期陣列*/	
	array_push($days_array_15,$days_15[$i_15]);
	/*X軸的陣列資料*/
	if($num_date_rows_13<$num_date_rows_15)
	array_push($x_array,date('m/d', strtotime($days_15[$i_15])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_13 = 0 ;$k_13<$num_date_rows_13;$k_13++){
	$rsum = 0;
	
	$day_13_13 = $days_array_13[$k_13];
	/*抓取有幾次測驗*/
	$count_data_13 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_13_13' and stage = '13'");
	$num_count_rows_13 = mysql_num_rows($count_data_13);
	/*For迴圈 Run測驗筆數*/
	for($ii_13 = 0 ;$ii_13<$num_count_rows_13;$ii_13++){
	list($count_13)=mysql_fetch_array($count_data_13);
		/*測驗資料丟到陣列*/
		$counts_13[$ii_13] = $count_13;
		}
			
	for($i_13_13 = 0 ;$i_13_13<$num_count_rows_13;$i_13_13++){
	$mtsum = 0;
	$following = 0;
	$counts_data_13 = $counts_13[$i_13_13];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_13_13' AND account ='$id' and stage = '13' and count = '$counts_data_13'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_13 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_13 = 0 ; $j_13<=$output_count_13-1 ; $j_13++){
		if($mtoutput[$j_13]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_13];
		}
	$mtresum =  $following / ($output_count_13);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_13*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_15 = 0 ;$k_15<$num_date_rows_15;$k_15++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_15 = $counts_15[$i_15_15];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_15 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($atoutput[$j_15]<40)
		{
			$following++;
		}
		echo $atoutput[$j_15];
		$atsum += $atoutput[$j_15];
		}
	$atresum =  $following / ($output_count_15);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_15*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十三(放鬆度) 與 關卡十五(放鬆度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)', ' 關卡十五(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 13 and $stage2 == 16){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_13 = array();
$days_array_16 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_13 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows_13 = mysql_num_rows($date_data_13);
	/*抓取日期資料筆數*/
	$date_data_16 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows_16 = mysql_num_rows($date_data_16);
	if($num_date_rows_13>$num_date_rows_16)
	{
	/*高值線與低值線*/	
	for($jj_13=0;$jj_13<$num_date_rows_13;$jj_13++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_16=0;$jj_16<$num_date_rows_16;$jj_16++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_13 = 0 ;$i_13<$num_date_rows_13;$i_13++){
	while (list($day_13)=mysql_fetch_array($date_data_13)){
	$days_13[] = $day_13;
	}
	/*第一關日期陣列*/	
	array_push($days_array_13,$days_13[$i_13]);
	/*X軸的陣列資料*/
	if($num_date_rows_13>=$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_13[$i_13])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_16 = 0 ;$i_16<$num_date_rows_16;$i_16++){
	while (list($day_16)=mysql_fetch_array($date_data_16)){
	$days_16[] = $day_16;
	}
	/*第二關日期陣列*/	
	array_push($days_array_16,$days_16[$i_16]);
	/*X軸的陣列資料*/
	if($num_date_rows_13<$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_16[$i_16])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_13 = 0 ;$k_13<$num_date_rows_13;$k_13++){
	$rsum = 0;
	
	$day_13_13 = $days_array_13[$k_13];
	/*抓取有幾次測驗*/
	$count_data_13 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_13_13' and stage = '13'");
	$num_count_rows_13 = mysql_num_rows($count_data_13);
	/*For迴圈 Run測驗筆數*/
	for($ii_13 = 0 ;$ii_13<$num_count_rows_13;$ii_13++){
	list($count_13)=mysql_fetch_array($count_data_13);
		/*測驗資料丟到陣列*/
		$counts_13[$ii_13] = $count_13;
		}
			
	for($i_13_13 = 0 ;$i_13_13<$num_count_rows_13;$i_13_13++){
	$mtsum = 0;
	$following = 0 ;
	$counts_data_13 = $counts_13[$i_13_13];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_13_13' AND account ='$id' and stage = '13' and count = '$counts_data_13'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_13 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_13 = 0 ; $j_13<=$output_count_13-1 ; $j_13++){
		if($mtoutput[$j_13]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_13];
		}
	$mtresum =  $following / ($output_count_13);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_13*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_16 = 0 ;$k_16<$num_date_rows_16;$k_16++){
	$asum = 0;
	
	$day_16_16 = $days_array_16[$k_16];
	/*抓取有幾次測驗*/
	$count_data_16 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_16_16' and stage = '16'");
	$num_count_rows_16 = mysql_num_rows($count_data_16);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_16 = 0 ;$ii_16<$num_count_rows_16;$ii_16++){
	list($count_16)=mysql_fetch_array($count_data_16);
		/*測驗資料丟到陣列*/
		$counts_16[$ii_16] = $count_16;
		}
			
	for($i_16_16 = 0 ;$i_16_16<$num_count_rows_16;$i_16_16++){
	$atsum = 0;
	$following = 0;
	$counts_data_16 = $counts_16[$i_16_16];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_16_16' AND account ='$id' and stage = '16' and count = '$counts_data_16'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_16 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_16 = 0 ; $j_16<=$output_count_16-1 ; $j_16++){
		if($atoutput[$j_16]<40)
		{
			$following++;
		}
		echo $atoutput[$j_16];
		$atsum += $atoutput[$j_16];
		}
	$atresum =  $following / ($output_count_16);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_16*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十三(放鬆度) 與 關卡十六(放鬆度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)', ' 關卡十六(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 13 and $stage2 == 17){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_13 = array();
$days_array_17 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_13 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows_13 = mysql_num_rows($date_data_13);
	/*抓取日期資料筆數*/
	$date_data_17 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows_17 = mysql_num_rows($date_data_17);
	if($num_date_rows_13>$num_date_rows_17)
	{
	/*高值線與低值線*/	
	for($jj_13=0;$jj_13<$num_date_rows_13;$jj_13++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_17=0;$jj_17<$num_date_rows_17;$jj_17++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_13 = 0 ;$i_13<$num_date_rows_13;$i_13++){
	while (list($day_13)=mysql_fetch_array($date_data_13)){
	$days_13[] = $day_13;
	}
	/*第一關日期陣列*/	
	array_push($days_array_13,$days_13[$i_13]);
	/*X軸的陣列資料*/
	if($num_date_rows_13>=$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_13[$i_13])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_17 = 0 ;$i_17<$num_date_rows_17;$i_17++){
	while (list($day_17)=mysql_fetch_array($date_data_17)){
	$days_17[] = $day_17;
	}
	/*第二關日期陣列*/	
	array_push($days_array_17,$days_17[$i_17]);
	/*X軸的陣列資料*/
	if($num_date_rows_13<$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_17[$i_17])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_13 = 0 ;$k_13<$num_date_rows_13;$k_13++){
	$rsum = 0;
	
	$day_13_13 = $days_array_13[$k_13];
	/*抓取有幾次測驗*/
	$count_data_13 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_13_13' and stage = '13'");
	$num_count_rows_13 = mysql_num_rows($count_data_13);
	/*For迴圈 Run測驗筆數*/
	for($ii_13 = 0 ;$ii_13<$num_count_rows_13;$ii_13++){
	list($count_13)=mysql_fetch_array($count_data_13);
		/*測驗資料丟到陣列*/
		$counts_13[$ii_13] = $count_13;
		}
			
	for($i_13_13 = 0 ;$i_13_13<$num_count_rows_13;$i_13_13++){
	$mtsum = 0;
	$following = 0 ;
	$counts_data_13 = $counts_13[$i_13_13];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_13_13' AND account ='$id' and stage = '13' and count = '$counts_data_13'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_13 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_13 = 0 ; $j_13<=$output_count_13-1 ; $j_13++){
		if($mtoutput[$j_13]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_13];
		}
	$mtresum =  $following / ($output_count_13);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_13*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_17 = 0 ;$k_17<$num_date_rows_17;$k_17++){
	$asum = 0;
	$day_17_17 = $days_array_17[$k_17];
	/*抓取有幾次測驗*/
	$count_data_17 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_17_17' and stage = '17'");
	$num_count_rows_17 = mysql_num_rows($count_data_17);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_17 = 0 ;$ii_17<$num_count_rows_17;$ii_17++){
	list($count_17)=mysql_fetch_array($count_data_17);
		/*測驗資料丟到陣列*/
		$counts_17[$ii_17] = $count_17;
		}
			
	for($i_17_17 = 0 ;$i_17_17<$num_count_rows_17;$i_17_17++){
	$atsum = 0;
	$following = 0;
	$counts_data_17 = $counts_17[$i_17_17];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_17_17' AND account ='$id' and stage = '17' and count = '$counts_data_17'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_17 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_17 = 0 ; $j_17<=$output_count_17-1 ; $j_17++){
		if($atoutput[$j_17]<40)
		{
			$following++;
		}
		echo $atoutput[$j_17];
		$atsum += $atoutput[$j_17];
		}
	$atresum =  $following / ($output_count_17);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_17*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十三(放鬆度) 與 關卡十七(專心度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)', ' 關卡十七(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 13 and $stage2 == 18){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_13 = array();
$days_array_18 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_13 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '13'");
	/*日期有幾筆*/
	$num_date_rows_13 = mysql_num_rows($date_data_13);
	/*抓取日期資料筆數*/
	$date_data_18 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows_18 = mysql_num_rows($date_data_18);
	if($num_date_rows_13>$num_date_rows_18)
	{
	/*高值線與低值線*/	
	for($jj_13=0;$jj_13<$num_date_rows_13;$jj_13++){
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
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_13 = 0 ;$i_13<$num_date_rows_13;$i_13++){
	while (list($day_13)=mysql_fetch_array($date_data_13)){
	$days_13[] = $day_13;
	}
	/*第一關日期陣列*/	
	array_push($days_array_13,$days_13[$i_13]);
	/*X軸的陣列資料*/
	if($num_date_rows_13>=$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_13[$i_13])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_18 = 0 ;$i_18<$num_date_rows_18;$i_18++){
	while (list($day_18)=mysql_fetch_array($date_data_18)){
	$days_18[] = $day_18;
	}
	/*第二關日期陣列*/	
	array_push($days_array_18,$days_18[$i_18]);
	/*X軸的陣列資料*/
	if($num_date_rows_13<$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_18[$i_18])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_13 = 0 ;$k_13<$num_date_rows_13;$k_13++){
	$rsum = 0;
	
	$day_13_13 = $days_array_13[$k_13];
	/*抓取有幾次測驗*/
	$count_data_13 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_13_13' and stage = '13'");
	$num_count_rows_13 = mysql_num_rows($count_data_13);
	/*For迴圈 Run測驗筆數*/
	for($ii_13 = 0 ;$ii_13<$num_count_rows_13;$ii_13++){
	list($count_13)=mysql_fetch_array($count_data_13);
		/*測驗資料丟到陣列*/
		$counts_13[$ii_13] = $count_13;
		}
			
	for($i_13_13 = 0 ;$i_13_13<$num_count_rows_13;$i_13_13++){
	$mtsum = 0;
	$following = 0;
	$counts_data_13 = $counts_13[$i_13_13];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_13_13' AND account ='$id' and stage = '13' and count = '$counts_data_13'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_13 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_13 = 0 ; $j_13<=$output_count_13-1 ; $j_13++){
		if($mtoutput[$j_13]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_13];
		}
	$mtresum =  $following / ($output_count_13);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_13*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_18 = 0 ;$k_18<$num_date_rows_18;$k_18++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_18 = $counts_18[$i_18_18];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_18 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($atoutput[$j_18]<40)
		{
			$following++;
		}
		echo $atoutput[$j_18];
		$atsum += $atoutput[$j_18];
		}
	$atresum =  $following / ($output_count_18);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_18*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十三(放鬆度) 與 關卡十八(放鬆度) 腦波折線圖';
$key_array = array('關卡十三(放鬆度)', ' 關卡十八(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 14 and $stage2 == 15){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_14 = array();
$days_array_15 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_14 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows_14 = mysql_num_rows($date_data_14);
	/*抓取日期資料筆數*/
	$date_data_15 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows_15 = mysql_num_rows($date_data_15);
	if($num_date_rows_14>$num_date_rows_15)
	{
	/*高值線與低值線*/	
	for($jj_14=0;$jj_14<$num_date_rows_14;$jj_14++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_15=0;$jj_15<$num_date_rows_15;$jj_15++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_14 = 0 ;$i_14<$num_date_rows_14;$i_14++){
	while (list($day_14)=mysql_fetch_array($date_data_14)){
	$days_14[] = $day_14;
	}
	/*第一關日期陣列*/	
	array_push($days_array_14,$days_14[$i_14]);
	/*X軸的陣列資料*/
	if($num_date_rows_14>=$num_date_rows_15)
	array_push($x_array,date('m/d', strtotime($days_14[$i_14])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_15 = 0 ;$i_15<$num_date_rows_15;$i_15++){
	while (list($day_15)=mysql_fetch_array($date_data_15)){
	$days_15[] = $day_15;
	}
	/*第二關日期陣列*/	
	array_push($days_array_15,$days_15[$i_15]);
	/*X軸的陣列資料*/
	if($num_date_rows_14>$num_date_rows_15)
	array_push($x_array,date('m/d', strtotime($days_15[$i_15])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_14 = 0 ;$k_14<$num_date_rows_14;$k_14++){
	$rsum = 0;
	$day_14_14 = $days_array_14[$k_14];
	/*抓取有幾次測驗*/
	$count_data_14 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_14_14' and stage = '14'");
	$num_count_rows_14 = mysql_num_rows($count_data_14);
	/*For迴圈 Run測驗筆數*/
	for($ii_14 = 0 ;$ii_14<$num_count_rows_14;$ii_14++){
	list($count_14)=mysql_fetch_array($count_data_14);
		/*測驗資料丟到陣列*/
		$counts_14[$ii_14] = $count_14;
		}
			
	for($i_14_14 = 0 ;$i_14_14<$num_count_rows_14;$i_14_14++){
	$mtsum = 0;
	$following = 0;
	$counts_data_14 = $counts_14[$i_14_14];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_14_14' AND account ='$id' and stage = '14' and count = '$counts_data_14'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_14 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_14 = 0 ; $j_14<=$output_count_14-1 ; $j_14++){
		if($mtoutput[$j_14]<40)
		{
		$following++;
		}
		$mtsum += $mtoutput[$j_14];
		}
	$mtresum =  $following / ($output_count_14);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_14*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_15 = 0 ;$k_15<$num_date_rows_15;$k_15++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_15 = $counts_15[$i_15_15];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_15 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($atoutput[$j_15]<40)
		{
			$following++;
		}
		echo $atoutput[$j_15];
		$atsum += $atoutput[$j_15];
		}
	$atresum =  $following / ($output_count_15);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_15*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十四(專心度) 與 關卡十五(專心度) 腦波折線圖';
$key_array = array('關卡十四(專心度)', ' 關卡十五(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 14 and $stage2 == 16){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_14 = array();
$days_array_16 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_14 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows_14 = mysql_num_rows($date_data_14);
	/*抓取日期資料筆數*/
	$date_data_16 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows_16 = mysql_num_rows($date_data_16);
	if($num_date_rows_14>$num_date_rows_16)
	{
	/*高值線與低值線*/	
	for($jj_14=0;$jj_14<$num_date_rows_14;$jj_14++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_16=0;$jj_16<$num_date_rows_16;$jj_16++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_14 = 0 ;$i_14<$num_date_rows_14;$i_14++){
	while (list($day_14)=mysql_fetch_array($date_data_14)){
	$days_14[] = $day_14;
	}
	/*第一關日期陣列*/	
	array_push($days_array_14,$days_14[$i_14]);
	/*X軸的陣列資料*/
	if($num_date_rows_14>=$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_14[$i_14])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_16 = 0 ;$i_16<$num_date_rows_16;$i_16++){
	while (list($day_16)=mysql_fetch_array($date_data_16)){
	$days_16[] = $day_16;
	}
	/*第二關日期陣列*/	
	array_push($days_array_16,$days_16[$i_16]);
	/*X軸的陣列資料*/
	if($num_date_rows_14<$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_16[$i_16])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_14 = 0 ;$k_14<$num_date_rows_14;$k_14++){
	$rsum = 0;
	
	$day_14_14 = $days_array_14[$k_14];
	/*抓取有幾次測驗*/
	$count_data_14 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_14_14' and stage = '14'");
	$num_count_rows_14 = mysql_num_rows($count_data_14);
	/*For迴圈 Run測驗筆數*/
	for($ii_14 = 0 ;$ii_14<$num_count_rows_14;$ii_14++){
	list($count_14)=mysql_fetch_array($count_data_14);
		/*測驗資料丟到陣列*/
		$counts_14[$ii_14] = $count_14;
		}
			
	for($i_14_14 = 0 ;$i_14_14<$num_count_rows_14;$i_14_14++){
	$mtsum = 0;
	$following = 0;
	$counts_data_14 = $counts_14[$i_14_14];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_14_14' AND account ='$id' and stage = '14' and count = '$counts_data_14'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_14 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_14 = 0 ; $j_14<=$output_count_14-1 ; $j_14++){
		if($mtoutput[$j_14]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_14];
		}
	$mtresum =  $following / ($output_count_14);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_14*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_16 = 0 ;$k_16<$num_date_rows_16;$k_16++){
	$asum = 0;
	$day_16_16 = $days_array_16[$k_16];
	/*抓取有幾次測驗*/
	$count_data_16 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_16_16' and stage = '16'");
	$num_count_rows_16 = mysql_num_rows($count_data_16);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_16 = 0 ;$ii_16<$num_count_rows_16;$ii_16++){
	list($count_16)=mysql_fetch_array($count_data_16);
		/*測驗資料丟到陣列*/
		$counts_16[$ii_16] = $count_16;
		}
			
	for($i_16_16 = 0 ;$i_16_16<$num_count_rows_16;$i_16_16++){
	$atsum = 0;
	$following = 0;
	$counts_data_16 = $counts_16[$i_16_16];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_16_16' AND account ='$id' and stage = '16' and count = '$counts_data_16'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_16 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_16 = 0 ; $j_16<=$output_count_16-1 ; $j_16++){
		if($atoutput[$j_16]<40)
		{
			$following++;
		}
		echo $atoutput[$j_16];
		$atsum += $atoutput[$j_16];
		}
	$atresum =  $following / ($output_count_16);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_16*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十四(專心度) 與 關卡十六(放鬆度) 腦波折線圖';
$key_array = array('關卡十四(專心度)', ' 關卡十六(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 14 and $stage2 == 17){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_14 = array();
$days_array_17 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_14 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows_14 = mysql_num_rows($date_data_14);
	/*抓取日期資料筆數*/
	$date_data_17 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows_17 = mysql_num_rows($date_data_17);
	if($num_date_rows_14>$num_date_rows_17)
	{
	/*高值線與低值線*/	
	for($jj_14=0;$jj_14<$num_date_rows_14;$jj_14++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_17=0;$jj_17<$num_date_rows_17;$jj_17++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_14 = 0 ;$i_14<$num_date_rows_14;$i_14++){
	while (list($day_14)=mysql_fetch_array($date_data_14)){
	$days_14[] = $day_14;
	}
	/*第一關日期陣列*/	
	array_push($days_array_14,$days_14[$i_14]);
	/*X軸的陣列資料*/
	if($num_date_rows_14>=$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_14[$i_14])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_17 = 0 ;$i_17<$num_date_rows_17;$i_17++){
	while (list($day_17)=mysql_fetch_array($date_data_17)){
	$days_17[] = $day_17;
	}
	/*第二關日期陣列*/	
	array_push($days_array_17,$days_17[$i_17]);
	/*X軸的陣列資料*/
	if($num_date_rows_14<$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_17[$i_17])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_14 = 0 ;$k_14<$num_date_rows_14;$k_14++){
	$rsum = 0;
	
	$day_14_14 = $days_array_14[$k_14];
	/*抓取有幾次測驗*/
	$count_data_14 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_14_14' and stage = '14'");
	$num_count_rows_14 = mysql_num_rows($count_data_14);
	/*For迴圈 Run測驗筆數*/
	for($ii_14 = 0 ;$ii_14<$num_count_rows_14;$ii_14++){
	list($count_14)=mysql_fetch_array($count_data_14);
		/*測驗資料丟到陣列*/
		$counts_14[$ii_14] = $count_14;
		}
			
	for($i_14_14 = 0 ;$i_14_14<$num_count_rows_14;$i_14_14++){
	$mtsum = 0;
	$following = 0;
	$counts_data_14 = $counts_14[$i_14_14];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_14_14' AND account ='$id' and stage = '14' and count = '$counts_data_14'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_14 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_14 = 0 ; $j_14<=$output_count_14-1 ; $j_14++){
		if($mtoutput[$j_14]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_14];
		}
	$mtresum =  $following / ($output_count_14);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_14*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_17 = 0 ;$k_17<$num_date_rows_17;$k_17++){
	$asum = 0;
	$day_17_17 = $days_array_17[$k_17];
	/*抓取有幾次測驗*/
	$count_data_17 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_17_17' and stage = '17'");
	$num_count_rows_17 = mysql_num_rows($count_data_17);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_17 = 0 ;$ii_17<$num_count_rows_17;$ii_17++){
	list($count_17)=mysql_fetch_array($count_data_17);
		/*測驗資料丟到陣列*/
		$counts_17[$ii_17] = $count_17;
		}
			
	for($i_17_17 = 0 ;$i_17_17<$num_count_rows_17;$i_17_17++){
	$atsum = 0;
	$following = 0;
	$counts_data_17 = $counts_17[$i_17_17];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_17_17' AND account ='$id' and stage = '17' and count = '$counts_data_17'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_17 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_17 = 0 ; $j_17<=$output_count_17-1 ; $j_17++){
		if($atoutput[$j_17]<40)
		{
			$following++;
		}
		echo $atoutput[$j_17];
		$atsum += $atoutput[$j_17];
		}
	$atresum =  $following / ($output_count_17);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_17*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十四(專心度) 與 關卡十七(專心度) 腦波折線圖';
$key_array = array('關卡十四(專心度)', ' 關卡十七(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 14 and $stage2 == 18){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_14 = array();
$days_array_18 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_14 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '14'");
	/*日期有幾筆*/
	$num_date_rows_14 = mysql_num_rows($date_data_14);
	/*抓取日期資料筆數*/
	$date_data_18 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows_18 = mysql_num_rows($date_data_18);
	if($num_date_rows_14>$num_date_rows_18)
	{
	/*高值線與低值線*/	
	for($jj_14=0;$jj_14<$num_date_rows_14;$jj_14++){
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
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_14 = 0 ;$i_14<$num_date_rows_14;$i_14++){
	while (list($day_14)=mysql_fetch_array($date_data_14)){
	$days_14[] = $day_14;
	}
	/*第一關日期陣列*/	
	array_push($days_array_14,$days_14[$i_14]);
	/*X軸的陣列資料*/
	if($num_date_rows_14>=$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_14[$i_14])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_18 = 0 ;$i_18<$num_date_rows_18;$i_18++){
	while (list($day_18)=mysql_fetch_array($date_data_18)){
	$days_18[] = $day_18;
	}
	/*第二關日期陣列*/	
	array_push($days_array_18,$days_18[$i_18]);
	/*X軸的陣列資料*/
	if($num_date_rows_14<$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_18[$i_18])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_14 = 0 ;$k_14<$num_date_rows_14;$k_14++){
	$rsum = 0;
	
	$day_14_14 = $days_array_14[$k_14];
	/*抓取有幾次測驗*/
	$count_data_14 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_14_14' and stage = '14'");
	$num_count_rows_14 = mysql_num_rows($count_data_14);
	/*For迴圈 Run測驗筆數*/
	for($ii_14 = 0 ;$ii_14<$num_count_rows_14;$ii_14++){
	list($count_14)=mysql_fetch_array($count_data_14);
		/*測驗資料丟到陣列*/
		$counts_14[$ii_14] = $count_14;
		}
			
	for($i_14_14 = 0 ;$i_14_14<$num_count_rows_14;$i_14_14++){
	$mtsum = 0;
	$following = 0;
	$counts_data_14 = $counts_14[$i_14_14];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_14_14' AND account ='$id' and stage = '14' and count = '$counts_data_14'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_14 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_14 = 0 ; $j_14<=$output_count_14-1 ; $j_14++){
		if($mtoutput[$j_14]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_14];
		}
	$mtresum =  $following / ($output_count_14);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_14*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_18 = 0 ;$k_18<$num_date_rows_18;$k_18++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_18 = $counts_18[$i_18_18];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_18 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($atoutput[$j_18]<40)
		{
			$following++;
		}
		echo $atoutput[$j_18];
		$atsum += $atoutput[$j_18];
		}
	$atresum =  $following / ($output_count_18);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_18*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十四(專心度) 與 關卡十八(專心度) 腦波折線圖';
$key_array = array('關卡十四(專心度)', ' 關卡十八(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 15 and $stage2 == 16){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_15 = array();
$days_array_16 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_15 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows_15 = mysql_num_rows($date_data_15);
	/*抓取日期資料筆數*/
	$date_data_16 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows_16 = mysql_num_rows($date_data_16);
	if($num_date_rows_15>$num_date_rows_16)
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
	for($jj_16=0;$jj_16<$num_date_rows_16;$jj_16++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
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
	if($num_date_rows_15>=$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_15[$i_15])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_16 = 0 ;$i_16<$num_date_rows_16;$i_16++){
	while (list($day_16)=mysql_fetch_array($date_data_16)){
	$days_16[] = $day_16;
	}
	/*第二關日期陣列*/	
	array_push($days_array_16,$days_16[$i_16]);
	/*X軸的陣列資料*/
	if($num_date_rows_15<$num_date_rows_16)
	array_push($x_array,date('m/d', strtotime($days_16[$i_16])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_15 = 0 ;$k_15<$num_date_rows_15;$k_15++){
	$rsum = 0;
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
	$mtsum = 0;
	$following = 0;
	$counts_data_15 = $counts_15[$i_15_15];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_15 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($mtoutput[$j_15]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_15];
		}
	$mtresum =  $following / ($output_count_15);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_15*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_16 = 0 ;$k_16<$num_date_rows_16;$k_16++){
	$asum = 0;
	$day_16_16 = $days_array_16[$k_16];
	/*抓取有幾次測驗*/
	$count_data_16 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_16_16' and stage = '16'");
	$num_count_rows_16 = mysql_num_rows($count_data_16);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_16 = 0 ;$ii_16<$num_count_rows_16;$ii_16++){
	list($count_16)=mysql_fetch_array($count_data_16);
		/*測驗資料丟到陣列*/
		$counts_16[$ii_16] = $count_16;
		}
			
	for($i_16_16 = 0 ;$i_16_16<$num_count_rows_16;$i_16_16++){
	$atsum = 0;
	$following = 0;
	$counts_data_16 = $counts_16[$i_16_16];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_16_16' AND account ='$id' and stage = '16' and count = '$counts_data_16'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_16 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_16 = 0 ; $j_16<=$output_count_16-1 ; $j_16++){
		if($atoutput[$j_16]<40)
		{
			$following++;
		}
		echo $atoutput[$j_16];
		$atsum += $atoutput[$j_16];
		}
	$atresum =  $following / ($output_count_16);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_16*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十五(放鬆度) 與 關卡十六(放鬆度) 腦波折線圖';
$key_array = array('關卡十五(放鬆度)', ' 關卡十六(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 15 and $stage2 == 17){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_15 = array();
$days_array_17 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_15 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '15'");
	/*日期有幾筆*/
	$num_date_rows_15 = mysql_num_rows($date_data_15);
	/*抓取日期資料筆數*/
	$date_data_17 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows_17 = mysql_num_rows($date_data_17);
	if($num_date_rows_15>$num_date_rows_17)
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
	for($jj_17=0;$jj_17<$num_date_rows_17;$jj_17++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
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
	if($num_date_rows_15>=$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_15[$i_15])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_17 = 0 ;$i_17<$num_date_rows_17;$i_17++){
	while (list($day_17)=mysql_fetch_array($date_data_17)){
	$days_17[] = $day_17;
	}
	/*第二關日期陣列*/	
	array_push($days_array_17,$days_17[$i_17]);
	/*X軸的陣列資料*/
	if($num_date_rows_15<$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_17[$i_17])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_15 = 0 ;$k_15<$num_date_rows_15;$k_15++){
	$rsum = 0;
	
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
	$mtsum = 0;
	$following = 0;
	$counts_data_15 = $counts_15[$i_15_15];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_15_15' AND account ='$id' and stage = '15' and count = '$counts_data_15'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_15 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_15 = 0 ; $j_15<=$output_count_15-1 ; $j_15++){
		if($mtoutput[$j_15]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_15];
		}
	$mtresum =  $following / ($output_count_15);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_15*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_17 = 0 ;$k_17<$num_date_rows_17;$k_17++){
	$asum = 0;
	
	$day_17_17 = $days_array_17[$k_17];
	/*抓取有幾次測驗*/
	$count_data_17 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_17_17' and stage = '17'");
	$num_count_rows_17 = mysql_num_rows($count_data_17);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_17 = 0 ;$ii_17<$num_count_rows_17;$ii_17++){
	list($count_17)=mysql_fetch_array($count_data_17);
		/*測驗資料丟到陣列*/
		$counts_17[$ii_17] = $count_17;
		}
			
	for($i_17_17 = 0 ;$i_17_17<$num_count_rows_17;$i_17_17++){
	$atsum = 0;
	$following = 0;
	$counts_data_17 = $counts_17[$i_17_17];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_17_17' AND account ='$id' and stage = '17' and count = '$counts_data_17'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_17 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_17 = 0 ; $j_17<=$output_count_17-1 ; $j_17++){
		if($atoutput[$j_17]<40)
		{
			$following++;
		}
		echo $atoutput[$j_17];
		$atsum += $atoutput[$j_17];
		}
	$atresum =  $following / ($output_count_17);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_17*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十五(專心度) 與 關卡十七(專心度) 腦波折線圖';
$key_array = array('關卡十五(專心度)', ' 關卡十七(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 16 and $stage2 == 17){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_16 = array();
$days_array_17 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_16 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows_16 = mysql_num_rows($date_data_16);
	/*抓取日期資料筆數*/
	$date_data_17 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows_17 = mysql_num_rows($date_data_17);
	if($num_date_rows_16>$num_date_rows_17)
	{
	/*高值線與低值線*/	
	for($jj_16=0;$jj_16<$num_date_rows_16;$jj_16++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_17=0;$jj_17<$num_date_rows_17;$jj_17++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_16 = 0 ;$i_16<$num_date_rows_16;$i_16++){
	while (list($day_16)=mysql_fetch_array($date_data_16)){
	$days_16[] = $day_16;
	}
	/*第一關日期陣列*/	
	array_push($days_array_16,$days_16[$i_16]);
	/*X軸的陣列資料*/
	if($num_date_rows_16>=$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_16[$i_16])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_17 = 0 ;$i_17<$num_date_rows_17;$i_17++){
	while (list($day_17)=mysql_fetch_array($date_data_17)){
	$days_17[] = $day_17;
	}
	/*第二關日期陣列*/	
	array_push($days_array_17,$days_17[$i_17]);
	/*X軸的陣列資料*/
	if($num_date_rows_16<$num_date_rows_17)
	array_push($x_array,date('m/d', strtotime($days_17[$i_17])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_16 = 0 ;$k_16<$num_date_rows_16;$k_16++){
	$rsum = 0;
	
	$day_16_16 = $days_array_16[$k_16];
	/*抓取有幾次測驗*/
	$count_data_16 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_16_16' and stage = '16'");
	$num_count_rows_16 = mysql_num_rows($count_data_16);
	/*For迴圈 Run測驗筆數*/
	for($ii_16 = 0 ;$ii_16<$num_count_rows_16;$ii_16++){
	list($count_16)=mysql_fetch_array($count_data_16);
		/*測驗資料丟到陣列*/
		$counts_16[$ii_16] = $count_16;
		}
			
	for($i_16_16 = 0 ;$i_16_16<$num_count_rows_16;$i_16_16++){
	$mtsum = 0;
	$following = 0;
	$counts_data_16 = $counts_16[$i_16_16];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_16_16' AND account ='$id' and stage = '16' and count = '$counts_data_16'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_16 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_16 = 0 ; $j_16<=$output_count_16-1 ; $j_16++){
		if($mtoutput[$j_16]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_16];
		}
	$mtresum =  $following / ($output_count_16);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_16*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_17 = 0 ;$k_17<$num_date_rows_17;$k_17++){
	$asum = 0;
	$day_17_17 = $days_array_17[$k_17];
	/*抓取有幾次測驗*/
	$count_data_17 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_17_17' and stage = '17'");
	$num_count_rows_17 = mysql_num_rows($count_data_17);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_17 = 0 ;$ii_17<$num_count_rows_17;$ii_17++){
	list($count_17)=mysql_fetch_array($count_data_17);
		/*測驗資料丟到陣列*/
		$counts_17[$ii_17] = $count_17;
		}
			
	for($i_17_17 = 0 ;$i_17_17<$num_count_rows_17;$i_17_17++){
	$atsum = 0;
	$following = 0;
	$counts_data_17 = $counts_17[$i_17_17];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_17_17' AND account ='$id' and stage = '17' and count = '$counts_data_17'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_17 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_17 = 0 ; $j_17<=$output_count_17-1 ; $j_17++){
		if($atoutput[$j_17]<40)
		{
			$following++;
		}
		echo $atoutput[$j_17];
		$atsum += $atoutput[$j_17];
		}
	$atresum =  $following / ($output_count_17);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_17*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十六(放鬆度) 與 關卡十七(專心度) 腦波折線圖';
$key_array = array('關卡十六(放鬆度)', ' 關卡十七(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 16 and $stage2 == 18){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_16 = array();
$days_array_18 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_16 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '16'");
	/*日期有幾筆*/
	$num_date_rows_16 = mysql_num_rows($date_data_16);
	/*抓取日期資料筆數*/
	$date_data_18 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows_18 = mysql_num_rows($date_data_18);
	if($num_date_rows_16>$num_date_rows_18)
	{
	/*高值線與低值線*/	
	for($jj_16=0;$jj_16<$num_date_rows_16;$jj_16++){
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
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_16 = 0 ;$i_16<$num_date_rows_16;$i_16++){
	while (list($day_16)=mysql_fetch_array($date_data_16)){
	$days_16[] = $day_16;
	}
	/*第一關日期陣列*/	
	array_push($days_array_16,$days_16[$i_16]);
	/*X軸的陣列資料*/
	if($num_date_rows_16>=$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_16[$i_16])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_18 = 0 ;$i_18<$num_date_rows_18;$i_18++){
	while (list($day_18)=mysql_fetch_array($date_data_18)){
	$days_18[] = $day_18;
	}
	/*第二關日期陣列*/	
	array_push($days_array_18,$days_18[$i_18]);
	/*X軸的陣列資料*/
	if($num_date_rows_16<$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_18[$i_18])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_16 = 0 ;$k_16<$num_date_rows_16;$k_16++){
	$rsum = 0;
	
	$day_16_16 = $days_array_16[$k_16];
	/*抓取有幾次測驗*/
	$count_data_16 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_16_16' and stage = '16'");
	$num_count_rows_16 = mysql_num_rows($count_data_16);
	/*For迴圈 Run測驗筆數*/
	for($ii_16 = 0 ;$ii_16<$num_count_rows_16;$ii_16++){
	list($count_16)=mysql_fetch_array($count_data_16);
		/*測驗資料丟到陣列*/
		$counts_16[$ii_16] = $count_16;
		}
			
	for($i_16_16 = 0 ;$i_16_16<$num_count_rows_16;$i_16_16++){
	$mtsum = 0;
	$following = 0;
	$counts_data_16 = $counts_16[$i_16_16];
	$result=mysql_query("SELECT relax FROM part_three WHERE date = '$day_16_16' AND account ='$id' and stage = '16' and count = '$counts_data_16'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_16 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_16 = 0 ; $j_16<=$output_count_16-1 ; $j_16++){
		if($mtoutput[$j_16]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_16];
		}
	$mtresum =  $following / ($output_count_16);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_16*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_18 = 0 ;$k_18<$num_date_rows_18;$k_18++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_18 = $counts_18[$i_18_18];
	$result2=mysql_query("SELECT relax FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_18 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($atoutput[$j_18]<40)
		{
			$following++;
		}
		echo $atoutput[$j_18];
		$atsum += $atoutput[$j_18];
		}
	$atresum =  $following / ($output_count_18);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_18*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十六(放鬆度) 與 關卡十八(放鬆度) 腦波折線圖';
$key_array = array('關卡十六(放鬆度)', ' 關卡十八(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 17 and $stage2 == 18){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_17 = array();
$days_array_18 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_17 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '17'");
	/*日期有幾筆*/
	$num_date_rows_17 = mysql_num_rows($date_data_17);
	/*抓取日期資料筆數*/
	$date_data_18 = mysql_query("SELECT distinct (date) FROM part_three WHERE  account ='$id' and stage = '18'");
	/*日期有幾筆*/
	$num_date_rows_18 = mysql_num_rows($date_data_18);
	if($num_date_rows_17>$num_date_rows_18)
	{
	/*高值線與低值線*/	
	for($jj_17=0;$jj_17<$num_date_rows_17;$jj_17++){
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
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_17 = 0 ;$i_17<$num_date_rows_17;$i_17++){
	while (list($day_17)=mysql_fetch_array($date_data_17)){
	$days_17[] = $day_17;
	}
	/*第一關日期陣列*/	
	array_push($days_array_17,$days_17[$i_17]);
	/*X軸的陣列資料*/
	if($num_date_rows_17>=$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_17[$i_17])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_18 = 0 ;$i_18<$num_date_rows_18;$i_18++){
	while (list($day_18)=mysql_fetch_array($date_data_18)){
	$days_18[] = $day_18;
	}
	/*第二關日期陣列*/	
	array_push($days_array_18,$days_18[$i_18]);
	/*X軸的陣列資料*/
	if($num_date_rows_17<$num_date_rows_18)
	array_push($x_array,date('m/d', strtotime($days_18[$i_18])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_17 = 0 ;$k_17<$num_date_rows_17;$k_17++){
	$rsum = 0;
	
	$day_17_17 = $days_array_17[$k_17];
	/*抓取有幾次測驗*/
	$count_data_17 = mysql_query("SELECT distinct (count)  FROM part_three WHERE  account ='$id' and date = '$day_17_17' and stage = '17'");
	$num_count_rows_17 = mysql_num_rows($count_data_17);
	/*For迴圈 Run測驗筆數*/
	for($ii_17 = 0 ;$ii_17<$num_count_rows_17;$ii_17++){
	list($count_17)=mysql_fetch_array($count_data_17);
		/*測驗資料丟到陣列*/
		$counts_17[$ii_17] = $count_17;
		}
			
	for($i_17_17 = 0 ;$i_17_17<$num_count_rows_17;$i_17_17++){
	$mtsum = 0;
	$following = 0;
	$counts_data_17 = $counts_17[$i_17_17];
	$result=mysql_query("SELECT attention FROM part_three WHERE date = '$day_17_17' AND account ='$id' and stage = '17' and count = '$counts_data_17'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_17 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_17 = 0 ; $j_17<=$output_count_17-1 ; $j_17++){
		if($mtoutput[$j_17]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_17];
		}
	$mtresum =  $following / ($output_count_17);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_17*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_18 = 0 ;$k_18<$num_date_rows_18;$k_18++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_18 = $counts_18[$i_18_18];
	$result2=mysql_query("SELECT attention FROM part_three WHERE date = '$day_18_18' AND account ='$id' and stage = '18' and count = '$counts_data_18'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_18 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_18 = 0 ; $j_18<=$output_count_18-1 ; $j_18++){
		if($atoutput[$j_18]<40)
		{
			$following++;
		}
		echo $atoutput[$j_18];
		$atsum += $atoutput[$j_18];
		}
	$atresum =  $following / ($output_count_18);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_18*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十七(專心度) 與 關卡十八(專心度) 腦波折線圖';
$key_array = array('關卡十七(專心度)', ' 關卡十八(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\


$level_array = array();
$level_array2 = array();
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2,$stage,$stage2);
?>