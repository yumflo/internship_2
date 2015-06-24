<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_one'];
 $stage2 = $_SESSION['part_one2'];
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
if($stage == 1 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '1'");
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
		$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day' AND account ='$id' and stage = '1' and count = '$counts_data'");
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
$title ='關卡一(放鬆度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 2 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '2'");
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
		$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day' AND account ='$id' and stage = '2' and count = '$counts_data'");
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
$title ='關卡二(專心度) 腦波折線圖';
$key_array = array('關卡二(專心度)');	
$data_array = array($attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 3 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '3'");
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
		$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day' AND account ='$id' and stage = '3' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day' AND account ='$id' and stage = '3' and count = '$counts_data'");
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
$title ='關卡三(專心度) 與 關卡三(放鬆度) 腦波折線圖';
$key_array = array('關卡三(專心度)', '關卡三(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}
//------------------------------------------------------------------------------------------------------\\
if($stage == 4 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '4'");
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
		$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day' AND account ='$id' and stage = '4' and count = '$counts_data'");
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
$title ='關卡四(放鬆度) 腦波折線圖';
$key_array = array('關卡四(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 5 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '5'");
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
		$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day' AND account ='$id' and stage = '5' and count = '$counts_data'");
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
$title ='關卡五(專心度) 腦波折線圖';
$key_array = array('關卡五(專心度)');
$data_array = array($attention_array);	
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 6 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day' and stage = '6'");
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
		$following_r = 0;
		$following_a = 0;
		$counts_data = $counts[$i];
		$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day' AND account ='$id' and stage = '6' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day' AND account ='$id' and stage = '6' and count = '$counts_data'");
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
$title ='關卡六(專心度) 與 關卡六(放鬆度) 腦波折線圖';
$key_array = array('關卡六(專心度)', '關卡六(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 1 and $stage2 == 2){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_1 = array();
$days_array_2 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_1 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
	/*日期有幾筆*/
	$num_date_rows_1 = mysql_num_rows($date_data_1);
	/*抓取日期資料筆數*/
	$date_data_2 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
	/*日期有幾筆*/
	$num_date_rows_2 = mysql_num_rows($date_data_2);
	if($num_date_rows_1>$num_date_rows_2)
	{
	/*高值線與低值線*/	
	for($jj_1=0;$jj_1<$num_date_rows_1;$jj_1++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_2=0;$jj_2<$num_date_rows_2;$jj_2++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
		
	/*抓出來的日期丟到陣列內*/
	for($i_1 = 0 ;$i_1<$num_date_rows_1;$i_1++){
	while (list($day_1)=mysql_fetch_array($date_data_1)){
	$days_1[] = $day_1;
	}
	/*第一關日期陣列*/	
	array_push($days_array_1,$days_1[$i_1]);
	/*X軸的陣列資料*/
	if($num_date_rows_1>=$num_date_rows_2)
	array_push($x_array,date('m/d', strtotime($days_1[$i_1])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_2 = 0 ;$i_2<$num_date_rows_2;$i_2++){
	while (list($day_2)=mysql_fetch_array($date_data_2)){
	$days_2[] = $day_2;
	}
	/*第二關日期陣列*/	
	array_push($days_array_2,$days_2[$i_2]);
	if($num_date_rows_1<$num_date_rows_2)
	array_push($x_array,date('m/d', strtotime($days_2[$i_2])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_1 = 0 ;$k_1<$num_date_rows_1;$k_1++){
	$rsum = 0;
	
	$day_1_1 = $days_array_1[$k_1];
	/*抓取有幾次測驗*/
	$count_data_1 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_1_1' and stage = '1'");
	$num_count_rows_1 = mysql_num_rows($count_data_1);
	/*For迴圈 Run測驗筆數*/
	for($ii_1 = 0 ;$ii_1<$num_count_rows_1;$ii_1++){
	list($count_1)=mysql_fetch_array($count_data_1);
		/*測驗資料丟到陣列*/
		$counts_1[$ii_1] = $count_1;
		}
			
	for($i_1_1 = 0 ;$i_1_1<$num_count_rows_1;$i_1_1++){
	$mtsum = 0;
	$following = 0;
	$counts_data_1 = $counts_1[$i_1_1];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_1_1' AND account ='$id' and stage = '1' and count = '$counts_data_1'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_1 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_1 = 0 ; $j_1<=$output_count_1-1 ; $j_1++){
		if($mtoutput[$j_1]<40)
		{
			$following++;
		}

		$mtsum += $mtoutput[$j_1];
		}
	$mtresum =  $following / ($output_count_1);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_1*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_2 = 0 ;$k_2<$num_date_rows_2;$k_2++){
	$asum = 0;
	
	$day_2_2 = $days_array_2[$k_2];
	/*抓取有幾次測驗*/
	$count_data_2 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_2_2' and stage = '2'");
	$num_count_rows_2 = mysql_num_rows($count_data_2);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_2 = 0 ;$ii_2<$num_count_rows_2;$ii_2++){
	list($count_2)=mysql_fetch_array($count_data_2);
		/*測驗資料丟到陣列*/
		$counts_2[$ii_2] = $count_2;
		}
			
	for($i_2_2 = 0 ;$i_2_2<$num_count_rows_2;$i_2_2++){
	$atsum = 0;
	$following = 0 ;
	$counts_data_2 = $counts_2[$i_2_2];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_2_2' AND account ='$id' and stage = '2' and count = '$counts_data_2'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_2 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_2 = 0 ; $j_2<=$output_count_2-1 ; $j_2++){
		if($atoutput[$j_2]<40)
		{
			$following++;
		}
		echo $atoutput[$j_2];
		$atsum += $atoutput[$j_2];
		}
	$atresum =  $following / ($output_count_2);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_2*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡一(放鬆度) 與 關卡二(專心度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)', ' 關卡二(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 1 and $stage2 == 3){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_1 = array();
$days_array_3 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_1 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
	/*日期有幾筆*/
	$num_date_rows_1 = mysql_num_rows($date_data_1);
	/*抓取日期資料筆數*/
	$date_data_3 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
	/*日期有幾筆*/
	$num_date_rows_3 = mysql_num_rows($date_data_3);
	if($num_date_rows_1>$num_date_rows_3)
	{
	/*高值線與低值線*/	
	for($jj_1=0;$jj_1<$num_date_rows_1;$jj_1++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_3=0;$jj_3<$num_date_rows_3;$jj_3++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_1 = 0 ;$i_1<$num_date_rows_1;$i_1++){
	while (list($day_1)=mysql_fetch_array($date_data_1)){
	$days_1[] = $day_1;
	}
	/*第一關日期陣列*/	
	array_push($days_array_1,$days_1[$i_1]);
	/*X軸的陣列資料*/
	if($num_date_rows_1>=$num_date_rows_3)
	array_push($x_array,date('m/d', strtotime($days_1[$i_1])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_3 = 0 ;$i_3<$num_date_rows_3;$i_3++){
	while (list($day_3)=mysql_fetch_array($date_data_3)){
	$days_3[] = $day_3;
	}
	/*第二關日期陣列*/	
	array_push($days_array_3,$days_3[$i_3]);
	/*X軸的陣列資料*/
	if($num_date_rows_1<$num_date_rows_3)
	array_push($x_array,date('m/d', strtotime($days_3[$i_3])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_1 = 0 ;$k_1<$num_date_rows_1;$k_1++){
	$rsum = 0;
	
	$day_1_1 = $days_array_1[$k_1];
	/*抓取有幾次測驗*/
	$count_data_1 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_1_1' and stage = '1'");
	$num_count_rows_1 = mysql_num_rows($count_data_1);
	/*For迴圈 Run測驗筆數*/
	for($ii_1 = 0 ;$ii_1<$num_count_rows_1;$ii_1++){
	list($count_1)=mysql_fetch_array($count_data_1);
		/*測驗資料丟到陣列*/
		$counts_1[$ii_1] = $count_1;
		}
			
	for($i_1_1 = 0 ;$i_1_1<$num_count_rows_1;$i_1_1++){
	$mtsum = 0;
	$following = 0;
	$counts_data_1 = $counts_1[$i_1_1];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_1_1' AND account ='$id' and stage = '1' and count = '$counts_data_1'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_1 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_1 = 0 ; $j_1<=$output_count_1-1 ; $j_1++){
		if($mtoutput[$j_1]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_1];
		}
	$mtresum =  $following / ($output_count_1);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_1*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_3 = 0 ;$k_3<$num_date_rows_3;$k_3++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_3 = $counts_3[$i_3_3];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_3 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($atoutput[$j_3]<40)
		{
			$following++;
		}
		echo $atoutput[$j_3];
		$atsum += $atoutput[$j_3];
		}
	$atresum = $following / ($output_count_3);
	}
	$asum += $atresum;
}
$asums = round (100-($atresum / $num_count_rows_3*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡一(放鬆度) 與 關卡三(放鬆度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)', ' 關卡三(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 1 and $stage2 == 4){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_1 = array();
$days_array_4 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_1 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
	/*日期有幾筆*/
	$num_date_rows_1 = mysql_num_rows($date_data_1);
	/*抓取日期資料筆數*/
	$date_data_4 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
	/*日期有幾筆*/
	$num_date_rows_4 = mysql_num_rows($date_data_4);
	if($num_date_rows_1>$num_date_rows_4)
	{
	/*高值線與低值線*/	
	for($jj_1=0;$jj_1<$num_date_rows_1;$jj_1++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_4=0;$jj_4<$num_date_rows_4;$jj_4++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_1 = 0 ;$i_1<$num_date_rows_1;$i_1++){
	while (list($day_1)=mysql_fetch_array($date_data_1)){
	$days_1[] = $day_1;
	}
	/*第一關日期陣列*/	
	array_push($days_array_1,$days_1[$i_1]);
	/*X軸的陣列資料*/
	if($num_date_rows_1>=$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_1[$i_1])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_4 = 0 ;$i_4<$num_date_rows_4;$i_4++){
	while (list($day_4)=mysql_fetch_array($date_data_4)){
	$days_4[] = $day_4;
	}
	/*第二關日期陣列*/	
	array_push($days_array_4,$days_4[$i_4]);
	/*X軸的陣列資料*/
	if($num_date_rows_1<$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_4[$i_4])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_1 = 0 ;$k_1<$num_date_rows_1;$k_1++){
	$rsum = 0;
	
	$day_1_1 = $days_array_1[$k_1];
	/*抓取有幾次測驗*/
	$count_data_1 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_1_1' and stage = '1'");
	$num_count_rows_1 = mysql_num_rows($count_data_1);
	/*For迴圈 Run測驗筆數*/
	for($ii_1 = 0 ;$ii_1<$num_count_rows_1;$ii_1++){
	list($count_1)=mysql_fetch_array($count_data_1);
		/*測驗資料丟到陣列*/
		$counts_1[$ii_1] = $count_1;
		}
			
	for($i_1_1 = 0 ;$i_1_1<$num_count_rows_1;$i_1_1++){
	$mtsum = 0;
	$following = 0 ;
	$counts_data_1 = $counts_1[$i_1_1];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_1_1' AND account ='$id' and stage = '1' and count = '$counts_data_1'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_1 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_1 = 0 ; $j_1<=$output_count_1-1 ; $j_1++){
		if($mtoutput[$j_1]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_1];
		}
	$mtresum =  $following / ($output_count_1);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_1*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_4 = 0 ;$k_4<$num_date_rows_4;$k_4++){
	$asum = 0;
	
	$day_4_4 = $days_array_4[$k_4];
	/*抓取有幾次測驗*/
	$count_data_4 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_4_4' and stage = '4'");
	$num_count_rows_4 = mysql_num_rows($count_data_4);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_4 = 0 ;$ii_4<$num_count_rows_4;$ii_4++){
	list($count_4)=mysql_fetch_array($count_data_4);
		/*測驗資料丟到陣列*/
		$counts_4[$ii_4] = $count_4;
		}
			
	for($i_4_4 = 0 ;$i_4_4<$num_count_rows_4;$i_4_4++){
	$atsum = 0;
	$following = 0;
	$counts_data_4 = $counts_4[$i_4_4];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_4_4' AND account ='$id' and stage = '4' and count = '$counts_data_4'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_4 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_4 = 0 ; $j_4<=$output_count_4-1 ; $j_4++){
		if($atoutput[$j_4]<40)
		{
			$following++;
		}
		echo $atoutput[$j_4];
		$atsum += $atoutput[$j_4];
		}
	$atresum =  $following / ($output_count_4);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_4*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡一(放鬆度) 與 關卡四(放鬆度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)', ' 關卡四(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 1 and $stage2 == 5){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_1 = array();
$days_array_5 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_1 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
	/*日期有幾筆*/
	$num_date_rows_1 = mysql_num_rows($date_data_1);
	/*抓取日期資料筆數*/
	$date_data_5 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
	/*日期有幾筆*/
	$num_date_rows_5 = mysql_num_rows($date_data_5);
	if($num_date_rows_1>$num_date_rows_5)
	{
	/*高值線與低值線*/	
	for($jj_1=0;$jj_1<$num_date_rows_1;$jj_1++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_5=0;$jj_5<$num_date_rows_5;$jj_5++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_1 = 0 ;$i_1<$num_date_rows_1;$i_1++){
	while (list($day_1)=mysql_fetch_array($date_data_1)){
	$days_1[] = $day_1;
	}
	/*第一關日期陣列*/	
	array_push($days_array_1,$days_1[$i_1]);
	/*X軸的陣列資料*/
	if($num_date_rows_1>=$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_1[$i_1])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_5 = 0 ;$i_5<$num_date_rows_5;$i_5++){
	while (list($day_5)=mysql_fetch_array($date_data_5)){
	$days_5[] = $day_5;
	}
	/*第二關日期陣列*/	
	array_push($days_array_5,$days_5[$i_5]);
	/*X軸的陣列資料*/
	if($num_date_rows_1<$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_5[$i_5])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_1 = 0 ;$k_1<$num_date_rows_1;$k_1++){
	$rsum = 0;
	
	$day_1_1 = $days_array_1[$k_1];
	/*抓取有幾次測驗*/
	$count_data_1 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_1_1' and stage = '1'");
	$num_count_rows_1 = mysql_num_rows($count_data_1);
	/*For迴圈 Run測驗筆數*/
	for($ii_1 = 0 ;$ii_1<$num_count_rows_1;$ii_1++){
	list($count_1)=mysql_fetch_array($count_data_1);
		/*測驗資料丟到陣列*/
		$counts_1[$ii_1] = $count_1;
		}
			
	for($i_1_1 = 0 ;$i_1_1<$num_count_rows_1;$i_1_1++){
	$mtsum = 0;
	$following = 0;
	$counts_data_1 = $counts_1[$i_1_1];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_1_1' AND account ='$id' and stage = '1' and count = '$counts_data_1'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_1 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_1 = 0 ; $j_1<=$output_count_1-1 ; $j_1++){
		if($mtoutput[$j_1]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_1];
		}
	$mtresum =  $following / ($output_count_1);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_1*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_5 = 0 ;$k_5<$num_date_rows_5;$k_5++){
	$asum = 0;
	
	$day_5_5 = $days_array_5[$k_5];
	/*抓取有幾次測驗*/
	$count_data_5 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_5_5' and stage = '5'");
	$num_count_rows_5 = mysql_num_rows($count_data_5);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_5 = 0 ;$ii_5<$num_count_rows_5;$ii_5++){
	list($count_5)=mysql_fetch_array($count_data_5);
		/*測驗資料丟到陣列*/
		$counts_5[$ii_5] = $count_5;
		}
			
	for($i_5_5 = 0 ;$i_5_5<$num_count_rows_5;$i_5_5++){
	$atsum = 0;
	$following = 0 ;
	$counts_data_5 = $counts_5[$i_5_5];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_5_5' AND account ='$id' and stage = '5' and count = '$counts_data_5'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_5 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_5 = 0 ; $j_5<=$output_count_5-1 ; $j_5++){
		if($atoutput[$j_5]<40)
		{
			$following++;
		}
		echo $atoutput[$j_5];
		$atsum += $atoutput[$j_5];
		}
	$atresum =  $following / ($output_count_5);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_5*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡一(放鬆度) 與 關卡五(專心度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)', ' 關卡五(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 1 and $stage2 == 6){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_1 = array();
$days_array_6 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_1 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '1'");
	/*日期有幾筆*/
	$num_date_rows_1 = mysql_num_rows($date_data_1);
	/*抓取日期資料筆數*/
	$date_data_6 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
	/*日期有幾筆*/
	$num_date_rows_6 = mysql_num_rows($date_data_6);
	if($num_date_rows_1>$num_date_rows_6)
	{
	/*高值線與低值線*/	
	for($jj_1=0;$jj_1<$num_date_rows_1;$jj_1++){
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
	for($i_1 = 0 ;$i_1<$num_date_rows_1;$i_1++){
	while (list($day_1)=mysql_fetch_array($date_data_1)){
	$days_1[] = $day_1;
	}
	/*第一關日期陣列*/	
	array_push($days_array_1,$days_1[$i_1]);
	/*X軸的陣列資料*/
	if($num_date_rows_1>=$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_1[$i_1])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_6 = 0 ;$i_6<$num_date_rows_6;$i_6++){
	while (list($day_6)=mysql_fetch_array($date_data_6)){
	$days_6[] = $day_6;
	}
	/*第二關日期陣列*/	
	array_push($days_array_6,$days_6[$i_6]);
	/*X軸的陣列資料*/
	if($num_date_rows_1<$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_6[$i_6])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_1 = 0 ;$k_1<$num_date_rows_1;$k_1++){
	$rsum = 0;
	
	$day_1_1 = $days_array_1[$k_1];
	/*抓取有幾次測驗*/
	$count_data_1 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_1_1' and stage = '1'");
	$num_count_rows_1 = mysql_num_rows($count_data_1);
	/*For迴圈 Run測驗筆數*/
	for($ii_1 = 0 ;$ii_1<$num_count_rows_1;$ii_1++){
	list($count_1)=mysql_fetch_array($count_data_1);
		/*測驗資料丟到陣列*/
		$counts_1[$ii_1] = $count_1;
		}
			
	for($i_1_1 = 0 ;$i_1_1<$num_count_rows_1;$i_1_1++){
	$mtsum = 0;
	$following = 0;
	$counts_data_1 = $counts_1[$i_1_1];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_1_1' AND account ='$id' and stage = '1' and count = '$counts_data_1'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_1 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_1 = 0 ; $j_1<=$output_count_1-1 ; $j_1++){
		if($mtoutput[$j_1]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_1];
		}
	$mtresum =  $following / ($output_count_1);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_1*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_6 = 0 ;$k_6<$num_date_rows_6;$k_6++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_6 = $counts_6[$i_6_6];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_6 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($atoutput[$j_6]<40)
		{
			$following++;
		}
		echo $atoutput[$j_6];
		$atsum += $atoutput[$j_6];
		}
	$atresum =  $following / ($output_count_6);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_6 * 100),2);
array_push($attention_array,$asums);
}	
$title ='關卡一(放鬆度) 與 關卡六(放鬆度) 腦波折線圖';
$key_array = array('關卡一(放鬆度)', ' 關卡六(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 2 and $stage2 == 3){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_2 = array();
$days_array_3 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_2 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
	/*日期有幾筆*/
	$num_date_rows_2 = mysql_num_rows($date_data_2);
	/*抓取日期資料筆數*/
	$date_data_3 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
	/*日期有幾筆*/
	$num_date_rows_3 = mysql_num_rows($date_data_3);
	if($num_date_rows_2>$num_date_rows_3)
	{
	/*高值線與低值線*/	
	for($jj_2=0;$jj_2<$num_date_rows_2;$jj_2++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_3=0;$jj_3<$num_date_rows_3;$jj_3++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_2 = 0 ;$i_2<$num_date_rows_2;$i_2++){
	while (list($day_2)=mysql_fetch_array($date_data_2)){
	$days_2[] = $day_2;
	}
	/*第一關日期陣列*/	
	array_push($days_array_2,$days_2[$i_2]);
	/*X軸的陣列資料*/
	if($num_date_rows_2>=$num_date_rows_3)
	array_push($x_array,date('m/d', strtotime($days_2[$i_2])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_3 = 0 ;$i_3<$num_date_rows_3;$i_3++){
	while (list($day_3)=mysql_fetch_array($date_data_3)){
	$days_3[] = $day_3;
	}
	/*第二關日期陣列*/	
	array_push($days_array_3,$days_3[$i_3]);
	/*X軸的陣列資料*/
	if($num_date_rows_2<$num_date_rows_3)
	array_push($x_array,date('m/d', strtotime($days_3[$i_3])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_2 = 0 ;$k_2<$num_date_rows_2;$k_2++){
	$rsum = 0;
	
	$day_2_2 = $days_array_2[$k_2];
	/*抓取有幾次測驗*/
	$count_data_2 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_2_2' and stage = '2'");
	$num_count_rows_2 = mysql_num_rows($count_data_2);
	/*For迴圈 Run測驗筆數*/
	for($ii_2 = 0 ;$ii_2<$num_count_rows_2;$ii_2++){
	list($count_2)=mysql_fetch_array($count_data_2);
		/*測驗資料丟到陣列*/
		$counts_2[$ii_2] = $count_2;
		}
			
	for($i_2_2 = 0 ;$i_2_2<$num_count_rows_2;$i_2_2++){
	$mtsum = 0;
	$following= 0;
	$counts_data_2 = $counts_2[$i_2_2];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_2_2' AND account ='$id' and stage = '2' and count = '$counts_data_2'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_2 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_2 = 0 ; $j_2<=$output_count_2-1 ; $j_2++){
		if($mtoutput[$j_2]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_2];
		}
	$mtresum =  $following / ($output_count_2);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_2*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_3 = 0 ;$k_3<$num_date_rows_3;$k_3++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_3 = $counts_3[$i_3_3];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_3 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($atoutput[$j_3]<40)
		{
			$following++;
		}
		echo $atoutput[$j_3];
		$atsum += $atoutput[$j_3];
		}
	$atresum =  $following / ($output_count_3);
	}
	$asum += $atresum;
}
$asums = round (100-($atresum / $num_count_rows_3*100),2);
//$asums = $num_count_rows_3;
array_push($attention_array,$asums);
}	
$title ='關卡二(專心度) 與 關卡三(專心度) 腦波折線圖';
$key_array = array('關卡二(專心度)', ' 關卡三(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 2 and $stage2 == 4){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_2 = array();
$days_array_4 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_2 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
	/*日期有幾筆*/
	$num_date_rows_2 = mysql_num_rows($date_data_2);
	/*抓取日期資料筆數*/
	$date_data_4 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
	/*日期有幾筆*/
	$num_date_rows_4 = mysql_num_rows($date_data_4);
	if($num_date_rows_2>$num_date_rows_4)
	{
	/*高值線與低值線*/	
	for($jj_2=0;$jj_2<$num_date_rows_2;$jj_2++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_4=0;$jj_4<$num_date_rows_4;$jj_4++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_2 = 0 ;$i_2<$num_date_rows_2;$i_2++){
	while (list($day_2)=mysql_fetch_array($date_data_2)){
	$days_2[] = $day_2;
	}
	/*第一關日期陣列*/	
	array_push($days_array_2,$days_2[$i_2]);
	/*X軸的陣列資料*/
	if($num_date_rows_2>=$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_2[$i_2])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_4 = 0 ;$i_4<$num_date_rows_4;$i_4++){
	while (list($day_4)=mysql_fetch_array($date_data_4)){
	$days_4[] = $day_4;
	}
	/*第二關日期陣列*/	
	array_push($days_array_4,$days_4[$i_4]);
	if($num_date_rows_2<$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_4[$i_4])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_2 = 0 ;$k_2<$num_date_rows_2;$k_2++){
	$rsum = 0;
	
	$day_2_2 = $days_array_2[$k_2];
	/*抓取有幾次測驗*/
	$count_data_2 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_2_2' and stage = '2'");
	$num_count_rows_2 = mysql_num_rows($count_data_2);
	/*For迴圈 Run測驗筆數*/
	for($ii_2 = 0 ;$ii_2<$num_count_rows_2;$ii_2++){
	list($count_2)=mysql_fetch_array($count_data_2);
		/*測驗資料丟到陣列*/
		$counts_2[$ii_2] = $count_2;
		}
			
	for($i_2_2 = 0 ;$i_2_2<$num_count_rows_2;$i_2_2++){
	$mtsum = 0;
	$following = 0;
	$counts_data_2 = $counts_2[$i_2_2];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_2_2' AND account ='$id' and stage = '2' and count = '$counts_data_2'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_2 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_2 = 0 ; $j_2<=$output_count_2-1 ; $j_2++){
		if($mtoutput[$j_2]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_2];
		}
	$mtresum =  $following / ($output_count_2);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_2*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_4 = 0 ;$k_4<$num_date_rows_4;$k_4++){
	$asum = 0;
	
	$day_4_4 = $days_array_4[$k_4];
	/*抓取有幾次測驗*/
	$count_data_4 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_4_4' and stage = '4'");
	$num_count_rows_4 = mysql_num_rows($count_data_4);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_4 = 0 ;$ii_4<$num_count_rows_4;$ii_4++){
	list($count_4)=mysql_fetch_array($count_data_4);
		/*測驗資料丟到陣列*/
		$counts_4[$ii_4] = $count_4;
		}
			
	for($i_4_4 = 0 ;$i_4_4<$num_count_rows_4;$i_4_4++){
	$atsum = 0;
	$following = 0;
	$counts_data_4 = $counts_4[$i_4_4];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_4_4' AND account ='$id' and stage = '4' and count = '$counts_data_4'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_4 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_4 = 0 ; $j_4<=$output_count_4-1 ; $j_4++){
		if($atoutput[$j_4]<40)
		{
			$following++;
		}
		echo $atoutput[$j_4];
		$atsum += $atoutput[$j_4];
		}
	$atresum =  $following / ($output_count_4);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_4*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡二(專心度) 與 關卡四(放鬆度) 腦波折線圖';
$key_array = array('關卡二(專心度)', ' 關卡四(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 2 and $stage2 == 5){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_2 = array();
$days_array_5 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_2 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
	/*日期有幾筆*/
	$num_date_rows_2 = mysql_num_rows($date_data_2);
	/*抓取日期資料筆數*/
	$date_data_5 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
	/*日期有幾筆*/
	$num_date_rows_5 = mysql_num_rows($date_data_5);
	if($num_date_rows_2>$num_date_rows_5)
	{
	/*高值線與低值線*/	
	for($jj_2=0;$jj_2<$num_date_rows_2;$jj_2++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_5=0;$jj_5<$num_date_rows_5;$jj_5++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_2 = 0 ;$i_2<$num_date_rows_2;$i_2++){
	while (list($day_2)=mysql_fetch_array($date_data_2)){
	$days_2[] = $day_2;
	}
	/*第一關日期陣列*/	
	array_push($days_array_2,$days_2[$i_2]);
	/*X軸的陣列資料*/
	if($num_date_rows_2>=$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_2[$i_2])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_5 = 0 ;$i_5<$num_date_rows_5;$i_5++){
	while (list($day_5)=mysql_fetch_array($date_data_5)){
	$days_5[] = $day_5;
	}
	/*第二關日期陣列*/	
	array_push($days_array_5,$days_5[$i_5]);
	if($num_date_rows_2<$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_5[$i_5])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_2 = 0 ;$k_2<$num_date_rows_2;$k_2++){
	$rsum = 0;
	
	$day_2_2 = $days_array_2[$k_2];
	/*抓取有幾次測驗*/
	$count_data_2 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_2_2' and stage = '2'");
	$num_count_rows_2 = mysql_num_rows($count_data_2);
	/*For迴圈 Run測驗筆數*/
	for($ii_2 = 0 ;$ii_2<$num_count_rows_2;$ii_2++){
	list($count_2)=mysql_fetch_array($count_data_2);
		/*測驗資料丟到陣列*/
		$counts_2[$ii_2] = $count_2;
		}
			
	for($i_2_2 = 0 ;$i_2_2<$num_count_rows_2;$i_2_2++){
	$mtsum = 0;
	$following = 0;
	$counts_data_2 = $counts_2[$i_2_2];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_2_2' AND account ='$id' and stage = '2' and count = '$counts_data_2'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_2 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_2 = 0 ; $j_2<=$output_count_2-1 ; $j_2++){
		if($mtoutput[$j_2]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_2];
		}
	$mtresum =  $following / ($output_count_2);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_2*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_5 = 0 ;$k_5<$num_date_rows_5;$k_5++){
	$asum = 0;
	
	$day_5_5 = $days_array_5[$k_5];
	/*抓取有幾次測驗*/
	$count_data_5 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_5_5' and stage = '5'");
	$num_count_rows_5 = mysql_num_rows($count_data_5);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_5 = 0 ;$ii_5<$num_count_rows_5;$ii_5++){
	list($count_5)=mysql_fetch_array($count_data_5);
		/*測驗資料丟到陣列*/
		$counts_5[$ii_5] = $count_5;
		}
			
	for($i_5_5 = 0 ;$i_5_5<$num_count_rows_5;$i_5_5++){
	$atsum = 0;
	$following=0;
	$counts_data_5 = $counts_5[$i_5_5];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_5_5' AND account ='$id' and stage = '5' and count = '$counts_data_5'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_5 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_5 = 0 ; $j_5<=$output_count_5-1 ; $j_5++){
		if($atoutput[$j_5]<40)
		{
			$following++;
		}
		echo $atoutput[$j_5];
		$atsum += $atoutput[$j_5];
		}
	$atresum =  $following / ($output_count_5);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_5*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡二(專心度) 與 關卡五(專心度) 腦波折線圖';
$key_array = array('關卡二(專心度)', ' 關卡五(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 2 and $stage2 == 6){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_2 = array();
$days_array_6 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_2 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '2'");
	/*日期有幾筆*/
	$num_date_rows_2 = mysql_num_rows($date_data_2);
	/*抓取日期資料筆數*/
	$date_data_6 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
	/*日期有幾筆*/
	$num_date_rows_6 = mysql_num_rows($date_data_6);
	if($num_date_rows_2>$num_date_rows_6)
	{
	/*高值線與低值線*/	
	for($jj_2=0;$jj_2<$num_date_rows_2;$jj_2++){
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
	for($i_2 = 0 ;$i_2<$num_date_rows_2;$i_2++){
	while (list($day_2)=mysql_fetch_array($date_data_2)){
	$days_2[] = $day_2;
	}
	/*第一關日期陣列*/	
	array_push($days_array_2,$days_2[$i_2]);
	/*X軸的陣列資料*/
	if($num_date_rows_2>=$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_2[$i_2])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_6 = 0 ;$i_6<$num_date_rows_6;$i_6++){
	while (list($day_6)=mysql_fetch_array($date_data_6)){
	$days_6[] = $day_6;
	}
	/*第二關日期陣列*/	
	array_push($days_array_6,$days_6[$i_6]);
	/*X軸的陣列資料*/
	if($num_date_rows_2<$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_6[$i_6])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_2 = 0 ;$k_2<$num_date_rows_2;$k_2++){
	$rsum = 0;
	
	$day_2_2 = $days_array_2[$k_2];
	/*抓取有幾次測驗*/
	$count_data_2 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_2_2' and stage = '2'");
	$num_count_rows_2 = mysql_num_rows($count_data_2);
	/*For迴圈 Run測驗筆數*/
	for($ii_2 = 0 ;$ii_2<$num_count_rows_2;$ii_2++){
	list($count_2)=mysql_fetch_array($count_data_2);
		/*測驗資料丟到陣列*/
		$counts_2[$ii_2] = $count_2;
		}
			
	for($i_2_2 = 0 ;$i_2_2<$num_count_rows_2;$i_2_2++){
	$mtsum = 0;
	$following = 0;
	$counts_data_2 = $counts_2[$i_2_2];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_2_2' AND account ='$id' and stage = '2' and count = '$counts_data_2'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_2 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_2 = 0 ; $j_2<=$output_count_2-1 ; $j_2++){
		if($mtoutput[$j_2]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_2];
		}
	$mtresum =  $following / ($output_count_2);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_2*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_6 = 0 ;$k_6<$num_date_rows_6;$k_6++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_6 = $counts_6[$i_6_6];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_6 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($atoutput[$j_6]<40)
		{
			$following++;
		}
		echo $atoutput[$j_6];
		$atsum += $atoutput[$j_6];
		}
	$atresum =  $following / ($output_count_6);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_6*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡二(專心度) 與 關卡六(專心度) 腦波折線圖';
$key_array = array('關卡二(專心度)', ' 關卡六(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 3 and $stage2 == 4){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_3 = array();
$days_array_4 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_3 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
	/*日期有幾筆*/
	$num_date_rows_3 = mysql_num_rows($date_data_3);
	/*抓取日期資料筆數*/
	$date_data_4 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
	/*日期有幾筆*/
	$num_date_rows_4 = mysql_num_rows($date_data_4);
	if($num_date_rows_3>$num_date_rows_4)
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
	for($jj_4=0;$jj_4<$num_date_rows_4;$jj_4++){
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
	if($num_date_rows_3>=$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_3[$i_3])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_4 = 0 ;$i_4<$num_date_rows_4;$i_4++){
	while (list($day_4)=mysql_fetch_array($date_data_4)){
	$days_4[] = $day_4;
	}
	/*第二關日期陣列*/	
	array_push($days_array_4,$days_4[$i_4]);
	/*X軸的陣列資料*/
	if($num_date_rows_3<$num_date_rows_4)
	array_push($x_array,date('m/d', strtotime($days_4[$i_4])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_3 = 0 ;$k_3<$num_date_rows_3;$k_3++){
	$rsum = 0;
	
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
	$mtsum = 0;
	$following = 0 ;
	$counts_data_3 = $counts_3[$i_3_3];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_3 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($mtoutput[$j_3]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_3];
		}
	$mtresum =  $following / ($output_count_3);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($mtresum / $num_count_rows_3*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_4 = 0 ;$k_4<$num_date_rows_4;$k_4++){
	$asum = 0;
	
	$day_4_4 = $days_array_4[$k_4];
	/*抓取有幾次測驗*/
	$count_data_4 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_4_4' and stage = '4'");
	$num_count_rows_4 = mysql_num_rows($count_data_4);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_4 = 0 ;$ii_4<$num_count_rows_4;$ii_4++){
	list($count_4)=mysql_fetch_array($count_data_4);
		/*測驗資料丟到陣列*/
		$counts_4[$ii_4] = $count_4;
		}
			
	for($i_4_4 = 0 ;$i_4_4<$num_count_rows_4;$i_4_4++){
	$atsum = 0;
	$following = 0 ;
	$counts_data_4 = $counts_4[$i_4_4];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_4_4' AND account ='$id' and stage = '4' and count = '$counts_data_4'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_4 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_4 = 0 ; $j_4<=$output_count_4-1 ; $j_4++){
		if($atoutput[$j_4]<40)
		{
			$following++;
		}
		echo $atoutput[$j_4];
		$atsum += $atoutput[$j_4];
		}
	$atresum =  $following / ($output_count_4);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_4*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡三(放鬆度) 與 關卡四(放鬆度) 腦波折線圖';
$key_array = array('關卡三(放鬆度)', ' 關卡四(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 3 and $stage2 == 5){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_3 = array();
$days_array_5 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_3 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '3'");
	/*日期有幾筆*/
	$num_date_rows_3 = mysql_num_rows($date_data_3);
	/*抓取日期資料筆數*/
	$date_data_5 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
	/*日期有幾筆*/
	$num_date_rows_5 = mysql_num_rows($date_data_5);
	if($num_date_rows_3>$num_date_rows_5)
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
	for($jj_5=0;$jj_5<$num_date_rows_5;$jj_5++){
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
	if($num_date_rows_3>=$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_3[$i_3])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_5 = 0 ;$i_5<$num_date_rows_5;$i_5++){
	while (list($day_5)=mysql_fetch_array($date_data_5)){
	$days_5[] = $day_5;
	}
	/*第二關日期陣列*/	
	array_push($days_array_5,$days_5[$i_5]);
	/*X軸的陣列資料*/
	if($num_date_rows_3<$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_5[$i_5])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_3 = 0 ;$k_3<$num_date_rows_3;$k_3++){
	$rsum = 0;
	
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
	$mtsum = 0;
	$following = 0;
	$counts_data_3 = $counts_3[$i_3_3];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_3_3' AND account ='$id' and stage = '3' and count = '$counts_data_3'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_3 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_3 = 0 ; $j_3<=$output_count_3-1 ; $j_3++){
		if($mtoutput[$j_3]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_3];
		}
	$mtresum =  $following / ($output_count_3);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($mtresum / $num_count_rows_3*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_5 = 0 ;$k_5<$num_date_rows_5;$k_5++){
	$asum = 0;
	
	$day_5_5 = $days_array_5[$k_5];
	/*抓取有幾次測驗*/
	$count_data_5 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_5_5' and stage = '5'");
	$num_count_rows_5 = mysql_num_rows($count_data_5);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_5 = 0 ;$ii_5<$num_count_rows_5;$ii_5++){
	list($count_5)=mysql_fetch_array($count_data_5);
		/*測驗資料丟到陣列*/
		$counts_5[$ii_5] = $count_5;
		}
			
	for($i_5_5 = 0 ;$i_5_5<$num_count_rows_5;$i_5_5++){
	$atsum = 0;
	$following = 0;
	$counts_data_5 = $counts_5[$i_5_5];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_5_5' AND account ='$id' and stage = '5' and count = '$counts_data_5'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_5 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_5 = 0 ; $j_5<=$output_count_5-1 ; $j_5++){
		if($atoutput[$j_5]<40)
		{
			$following++;
		}
		echo $atoutput[$j_5];
		$atsum += $atoutput[$j_5];
		}
	$atresum =  $following / ($output_count_5);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_5*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡三(專心度) 與 關卡五(專心度) 腦波折線圖';
$key_array = array('關卡三(專心度)', ' 關卡五(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 4 and $stage2 == 5){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_4 = array();
$days_array_5 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_4 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
	/*日期有幾筆*/
	$num_date_rows_4 = mysql_num_rows($date_data_4);
	/*抓取日期資料筆數*/
	$date_data_5 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
	/*日期有幾筆*/
	$num_date_rows_5 = mysql_num_rows($date_data_5);
	if($num_date_rows_4>$num_date_rows_5)
	{
	/*高值線與低值線*/	
	for($jj_4=0;$jj_4<$num_date_rows_4;$jj_4++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_5=0;$jj_5<$num_date_rows_5;$jj_5++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_4 = 0 ;$i_4<$num_date_rows_4;$i_4++){
	while (list($day_4)=mysql_fetch_array($date_data_4)){
	$days_4[] = $day_4;
	}
	/*第一關日期陣列*/	
	array_push($days_array_4,$days_4[$i_4]);
	/*X軸的陣列資料*/
	if($num_date_rows_4>=$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_4[$i_4])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_5 = 0 ;$i_5<$num_date_rows_5;$i_5++){
	while (list($day_5)=mysql_fetch_array($date_data_5)){
	$days_5[] = $day_5;
	}
	/*第二關日期陣列*/	
	array_push($days_array_5,$days_5[$i_5]);
	/*X軸的陣列資料*/
	if($num_date_rows_4<$num_date_rows_5)
	array_push($x_array,date('m/d', strtotime($days_5[$i_5])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_4 = 0 ;$k_4<$num_date_rows_4;$k_4++){
	$rsum = 0;
	
	$day_4_4 = $days_array_4[$k_4];
	/*抓取有幾次測驗*/
	$count_data_4 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_4_4' and stage = '4'");
	$num_count_rows_4 = mysql_num_rows($count_data_4);
	/*For迴圈 Run測驗筆數*/
	for($ii_4 = 0 ;$ii_4<$num_count_rows_4;$ii_4++){
	list($count_4)=mysql_fetch_array($count_data_4);
		/*測驗資料丟到陣列*/
		$counts_4[$ii_4] = $count_4;
		}
			
	for($i_4_4 = 0 ;$i_4_4<$num_count_rows_4;$i_4_4++){
	$mtsum = 0;
	$following = 0;
	$counts_data_4 = $counts_4[$i_4_4];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_4_4' AND account ='$id' and stage = '4' and count = '$counts_data_4'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_4 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_4 = 0 ; $j_4<=$output_count_4-1 ; $j_4++){
		if($mtoutput[$j_4]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_4];
		}
	$mtresum =  $following / ($output_count_4);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_4*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_5 = 0 ;$k_5<$num_date_rows_5;$k_5++){
	$asum = 0;
	
	$day_5_5 = $days_array_5[$k_5];
	/*抓取有幾次測驗*/
	$count_data_5 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_5_5' and stage = '5'");
	$num_count_rows_5 = mysql_num_rows($count_data_5);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_5 = 0 ;$ii_5<$num_count_rows_5;$ii_5++){
	list($count_5)=mysql_fetch_array($count_data_5);
		/*測驗資料丟到陣列*/
		$counts_5[$ii_5] = $count_5;
		}
			
	for($i_5_5 = 0 ;$i_5_5<$num_count_rows_5;$i_5_5++){
	$atsum = 0;
	$following = 0;
	$counts_data_5 = $counts_5[$i_5_5];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_5_5' AND account ='$id' and stage = '5' and count = '$counts_data_5'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_5 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_5 = 0 ; $j_5<=$output_count_5-1 ; $j_5++){
		if($atoutput[$j_5]<40)
		{
			$following++;
		}
		echo $atoutput[$j_5];
		$atsum += $atoutput[$j_5];
		}
	$atresum =  $following / ($output_count_5);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_5*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡四(放鬆度) 與 關卡五(專心度) 腦波折線圖';
$key_array = array('關卡四(放鬆度)', ' 關卡五(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 4 and $stage2 == 6){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_4 = array();
$days_array_6 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_4 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '4'");
	/*日期有幾筆*/
	$num_date_rows_4 = mysql_num_rows($date_data_4);
	/*抓取日期資料筆數*/
	$date_data_6 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
	/*日期有幾筆*/
	$num_date_rows_6 = mysql_num_rows($date_data_6);
	if($num_date_rows_4>$num_date_rows_6)
	{
	/*高值線與低值線*/	
	for($jj_4=0;$jj_4<$num_date_rows_4;$jj_4++){
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
	for($i_4 = 0 ;$i_4<$num_date_rows_4;$i_4++){
	while (list($day_4)=mysql_fetch_array($date_data_4)){
	$days_4[] = $day_4;
	}
	/*第一關日期陣列*/	
	array_push($days_array_4,$days_4[$i_4]);
	/*X軸的陣列資料*/
	if($num_date_rows_4>=$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_4[$i_4])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_6 = 0 ;$i_6<$num_date_rows_6;$i_6++){
	while (list($day_6)=mysql_fetch_array($date_data_6)){
	$days_6[] = $day_6;
	}
	/*第二關日期陣列*/	
	array_push($days_array_6,$days_6[$i_6]);
	/*X軸的陣列資料*/
	if($num_date_rows_4<$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_6[$i_6])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_4 = 0 ;$k_4<$num_date_rows_4;$k_4++){
	$rsum = 0;
	
	$day_4_4 = $days_array_4[$k_4];
	/*抓取有幾次測驗*/
	$count_data_4 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_4_4' and stage = '4'");
	$num_count_rows_4 = mysql_num_rows($count_data_4);
	/*For迴圈 Run測驗筆數*/
	for($ii_4 = 0 ;$ii_4<$num_count_rows_4;$ii_4++){
	list($count_4)=mysql_fetch_array($count_data_4);
		/*測驗資料丟到陣列*/
		$counts_4[$ii_4] = $count_4;
		}
			
	for($i_4_4 = 0 ;$i_4_4<$num_count_rows_4;$i_4_4++){
	$mtsum = 0;
	$following = 0;
	$counts_data_4 = $counts_4[$i_4_4];
	$result=mysql_query("SELECT relax FROM part_one WHERE date = '$day_4_4' AND account ='$id' and stage = '4' and count = '$counts_data_4'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_4 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_4 = 0 ; $j_4<=$output_count_4-1 ; $j_4++){
		if($mtoutput[$j_4]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_4];
		}
	$mtresum =  $following / ($output_count_4);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_4*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_6 = 0 ;$k_6<$num_date_rows_6;$k_6++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_6 = $counts_6[$i_6_6];
	$result2=mysql_query("SELECT relax FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_6 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($atoutput[$j_6]<40)
		{
			$following++;
		}
		echo $atoutput[$j_6];
		$atsum += $atoutput[$j_6];
		}
	$atresum =  $following / ($output_count_6);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_6*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡四(放鬆度) 與 關卡六(放鬆度) 腦波折線圖';
$key_array = array('關卡四(放鬆度)', ' 關卡六(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 5 and $stage2 == 6){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_5 = array();
$days_array_6 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_5 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '5'");
	/*日期有幾筆*/
	$num_date_rows_5 = mysql_num_rows($date_data_5);
	/*抓取日期資料筆數*/
	$date_data_6 = mysql_query("SELECT distinct (date) FROM part_one WHERE  account ='$id' and stage = '6'");
	/*日期有幾筆*/
	$num_date_rows_6 = mysql_num_rows($date_data_6);
	if($num_date_rows_5>$num_date_rows_6)
	{
	/*高值線與低值線*/	
	for($jj_5=0;$jj_5<$num_date_rows_5;$jj_5++){
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
	for($i_5 = 0 ;$i_5<$num_date_rows_5;$i_5++){
	while (list($day_5)=mysql_fetch_array($date_data_5)){
	$days_5[] = $day_5;
	}
	/*第一關日期陣列*/	
	array_push($days_array_5,$days_5[$i_5]);
	/*X軸的陣列資料*/
	if($num_date_rows_5>=$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_5[$i_5])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_6 = 0 ;$i_6<$num_date_rows_6;$i_6++){
	while (list($day_6)=mysql_fetch_array($date_data_6)){
	$days_6[] = $day_6;
	}
	/*第二關日期陣列*/	
	array_push($days_array_6,$days_6[$i_6]);
	/*X軸的陣列資料*/
	if($num_date_rows_5<$num_date_rows_6)
	array_push($x_array,date('m/d', strtotime($days_6[$i_6])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_5 = 0 ;$k_5<$num_date_rows_5;$k_5++){
	$rsum = 0;
	
	$day_5_5 = $days_array_5[$k_5];
	/*抓取有幾次測驗*/
	$count_data_5 = mysql_query("SELECT distinct (count)  FROM part_one WHERE  account ='$id' and date = '$day_5_5' and stage = '5'");
	$num_count_rows_5 = mysql_num_rows($count_data_5);
	/*For迴圈 Run測驗筆數*/
	for($ii_5 = 0 ;$ii_5<$num_count_rows_5;$ii_5++){
	list($count_5)=mysql_fetch_array($count_data_5);
		/*測驗資料丟到陣列*/
		$counts_5[$ii_5] = $count_5;
		}
			
	for($i_5_5 = 0 ;$i_5_5<$num_count_rows_5;$i_5_5++){
	$mtsum = 0;
	$following = 0;
	$counts_data_5 = $counts_5[$i_5_5];
	$result=mysql_query("SELECT attention FROM part_one WHERE date = '$day_5_5' AND account ='$id' and stage = '5' and count = '$counts_data_5'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_5 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_5 = 0 ; $j_5<=$output_count_5-1 ; $j_5++){
		if($mtoutput[$j_5]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_5];
		}
	$mtresum =  $following / ($output_count_5);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_5*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_6 = 0 ;$k_6<$num_date_rows_6;$k_6++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_6 = $counts_6[$i_6_6];
	$result2=mysql_query("SELECT attention FROM part_one WHERE date = '$day_6_6' AND account ='$id' and stage = '6' and count = '$counts_data_6'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_6 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_6 = 0 ; $j_6<=$output_count_6-1 ; $j_6++){
		if($atoutput[$j_6]<40)
		{
			$following++;
		}
		echo $atoutput[$j_6];
		$atsum += $atoutput[$j_6];
		}
	$atresum =  $following / ($output_count_6);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_6*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡五(專心度) 與 關卡六(專心度) 腦波折線圖';
$key_array = array('關卡五(專心度)', ' 關卡六(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\


$level_array = array();
$level_array2 = array();
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2,$stage,$stage2);
?>