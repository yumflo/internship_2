<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_four'];
 $stage2 = $_SESSION['part_four2'];
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
if($stage == 19 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '19'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day' and stage = '19'");
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
		$result=mysql_query("SELECT relax FROM part_four WHERE date = '$day' AND account ='$id' and stage = '19' and count = '$counts_data'");
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
$title ='關卡十九(放鬆度) 腦波折線圖';
$key_array = array('關卡十九(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 20 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '20'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day' and stage = '20'");
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
		$result=mysql_query("SELECT attention FROM part_four WHERE date = '$day' AND account ='$id' and stage = '20' and count = '$counts_data'");
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
$title ='關卡二十(專心度) 腦波折線圖';
$key_array = array('關卡二十(專心度)');	
$data_array = array($attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 21 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '21'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day' and stage = '21'");
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
		$result=mysql_query("SELECT attention FROM part_four WHERE date = '$day' AND account ='$id' and stage = '21' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_four WHERE date = '$day' AND account ='$id' and stage = '21' and count = '$counts_data'");
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
$title ='關卡二十一(專心度) 與 關卡二十一(放鬆度) 腦波折線圖';
$key_array = array('關卡二十一(專心度)', '關卡二十一(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}
//------------------------------------------------------------------------------------------------------\\


else if($stage == 19 and $stage2 == 20){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_19 = array();
$days_array_20 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_19 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '19'");
	/*日期有幾筆*/
	$num_date_rows_19 = mysql_num_rows($date_data_19);
	/*抓取日期資料筆數*/
	$date_data_20 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '20'");
	/*日期有幾筆*/
	$num_date_rows_20 = mysql_num_rows($date_data_20);
	if($num_date_rows_19>$num_date_rows_20)
	{
	/*高值線與低值線*/	
	for($jj_19=0;$jj_19<$num_date_rows_19;$jj_19++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_20=0;$jj_20<$num_date_rows_20;$jj_20++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_19 = 0 ;$i_19<$num_date_rows_19;$i_19++){
	while (list($day_19)=mysql_fetch_array($date_data_19)){
	$days_19[] = $day_19;
	}
	/*第一關日期陣列*/	
	array_push($days_array_19,$days_19[$i_19]);
	/*X軸的陣列資料*/
	if($num_date_rows_19>=$num_date_rows_20)
	array_push($x_array,date('m/d', strtotime($days_19[$i_19])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_20 = 0 ;$i_20<$num_date_rows_20;$i_20++){
	while (list($day_20)=mysql_fetch_array($date_data_20)){
	$days_20[] = $day_20;
	}
	/*第二關日期陣列*/	
	array_push($days_array_20,$days_20[$i_20]);
	/*X軸的陣列資料*/
	if($num_date_rows_19<$num_date_rows_20)
	array_push($x_array,date('m/d', strtotime($days_20[$i_20])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_19 = 0 ;$k_19<$num_date_rows_19;$k_19++){
	$rsum = 0;
	
	$day_19_19 = $days_array_19[$k_19];
	/*抓取有幾次測驗*/
	$count_data_19 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_19_19' and stage = '19'");
	$num_count_rows_19 = mysql_num_rows($count_data_19);
	/*For迴圈 Run測驗筆數*/
	for($ii_19 = 0 ;$ii_19<$num_count_rows_19;$ii_19++){
	list($count_19)=mysql_fetch_array($count_data_19);
		/*測驗資料丟到陣列*/
		$counts_19[$ii_19] = $count_19;
		}
			
	for($i_19_19 = 0 ;$i_19_19<$num_count_rows_19;$i_19_19++){
	$mtsum = 0;
	$following = 0;
	$counts_data_19 = $counts_19[$i_19_19];
	$result=mysql_query("SELECT relax FROM part_four WHERE date = '$day_19_19' AND account ='$id' and stage = '19' and count = '$counts_data_19'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_19 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_19 = 0 ; $j_19<=$output_count_19-1 ; $j_19++){
		if($mtoutput[$j_19]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_19];
		}
	$mtresum =  $following / ($output_count_19);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_19*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_20 = 0 ;$k_20<$num_date_rows_20;$k_20++){
	$asum = 0;
	
	$day_20_20 = $days_array_20[$k_20];
	/*抓取有幾次測驗*/
	$count_data_20 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_20_20' and stage = '20'");
	$num_count_rows_20 = mysql_num_rows($count_data_20);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_20 = 0 ;$ii_20<$num_count_rows_20;$ii_20++){
	list($count_20)=mysql_fetch_array($count_data_20);
		/*測驗資料丟到陣列*/
		$counts_20[$ii_20] = $count_20;
		}
			
	for($i_20_20 = 0 ;$i_20_20<$num_count_rows_20;$i_20_20++){
	$atsum = 0;
	$following = 0;
	$counts_data_20 = $counts_20[$i_20_20];
	$result2=mysql_query("SELECT attention FROM part_four WHERE date = '$day_20_20' AND account ='$id' and stage = '20' and count = '$counts_data_20'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_20 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_20 = 0 ; $j_20<=$output_count_20-1 ; $j_20++){
		if($atoutput[$j_20]<40)
		{
			$following++;
		}
		echo $atoutput[$j_20];
		$atsum += $atoutput[$j_20];
		}
	$atresum =  $following / ($output_count_20);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_20*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十九(放鬆度) 與 關卡二十(專心度) 腦波折線圖';
$key_array = array('關卡十九(放鬆度)', ' 關卡二十(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 19 and $stage2 == 21){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_19 = array();
$days_array_21 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_19 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '19'");
	/*日期有幾筆*/
	$num_date_rows_19 = mysql_num_rows($date_data_19);
	/*抓取日期資料筆數*/
	$date_data_21 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '21'");
	/*日期有幾筆*/
	$num_date_rows_21 = mysql_num_rows($date_data_21);
	if($num_date_rows_19>$num_date_rows_21)
	{
	/*高值線與低值線*/	
	for($jj_19=0;$jj_19<$num_date_rows_19;$jj_19++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_21=0;$jj_21<$num_date_rows_21;$jj_21++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_19 = 0 ;$i_19<$num_date_rows_19;$i_19++){
	while (list($day_19)=mysql_fetch_array($date_data_19)){
	$days_19[] = $day_19;
	}
	/*第一關日期陣列*/	
	array_push($days_array_19,$days_19[$i_19]);
	/*X軸的陣列資料*/
	if($num_date_rows_19>=$num_date_rows_21)
	array_push($x_array,date('m/d', strtotime($days_19[$i_19])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_21 = 0 ;$i_21<$num_date_rows_21;$i_21++){
	while (list($day_21)=mysql_fetch_array($date_data_21)){
	$days_21[] = $day_21;
	}
	/*第二關日期陣列*/	
	array_push($days_array_21,$days_21[$i_21]);
	/*X軸的陣列資料*/
	if($num_date_rows_19<$num_date_rows_21)
	array_push($x_array,date('m/d', strtotime($days_21[$i_21])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_19 = 0 ;$k_19<$num_date_rows_19;$k_19++){
	$rsum = 0;
	
	$day_19_19 = $days_array_19[$k_19];
	/*抓取有幾次測驗*/
	$count_data_19 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_19_19' and stage = '19'");
	$num_count_rows_19 = mysql_num_rows($count_data_19);
	/*For迴圈 Run測驗筆數*/
	for($ii_19 = 0 ;$ii_19<$num_count_rows_19;$ii_19++){
	list($count_19)=mysql_fetch_array($count_data_19);
		/*測驗資料丟到陣列*/
		$counts_19[$ii_19] = $count_19;
		}
			
	for($i_19_19 = 0 ;$i_19_19<$num_count_rows_19;$i_19_19++){
	$mtsum = 0;
	$following = 0;
	$counts_data_19 = $counts_19[$i_19_19];
	$result=mysql_query("SELECT relax FROM part_four WHERE date = '$day_19_19' AND account ='$id' and stage = '19' and count = '$counts_data_19'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_19 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_19 = 0 ; $j_19<=$output_count_19-1 ; $j_19++){
		if($mtoutput[$j_19]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_19];
		}
	$mtresum =  $following / ($output_count_19);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_19*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_21 = 0 ;$k_21<$num_date_rows_21;$k_21++){
	$asum = 0;
	
	$day_21_21 = $days_array_21[$k_21];
	/*抓取有幾次測驗*/
	$count_data_21 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_21_21' and stage = '21'");
	$num_count_rows_21 = mysql_num_rows($count_data_21);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_21 = 0 ;$ii_21<$num_count_rows_21;$ii_21++){
	list($count_21)=mysql_fetch_array($count_data_21);
		/*測驗資料丟到陣列*/
		$counts_21[$ii_21] = $count_21;
		}
			
	for($i_21_21 = 0 ;$i_21_21<$num_count_rows_21;$i_21_21++){
	$atsum = 0;
	$following = 0;
	$counts_data_21 = $counts_21[$i_21_21];
	$result2=mysql_query("SELECT relax FROM part_four WHERE date = '$day_21_21' AND account ='$id' and stage = '21' and count = '$counts_data_21'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_21 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_21 = 0 ; $j_21<=$output_count_21-1 ; $j_21++){
		if($atoutput[$j_21]<40)
		{
			$following++;
		}
		echo $atoutput[$j_21];
		$atsum += $atoutput[$j_21];
		}
	$atresum =  $following / ($output_count_21);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_21*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十九(放鬆度) 與 關卡二十一(放鬆度) 腦波折線圖';
$key_array = array('關卡十九(放鬆度)', ' 關卡二十一(放鬆度)');
$data_array = array($relax_array,$attention_array);
}

//------------------------------------------------------------------------------------------------------\\
else if($stage == 20 and $stage2 == 21){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_19 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_19 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '20'");
	/*日期有幾筆*/
	$num_date_rows_19 = mysql_num_rows($date_data_19);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_four WHERE  account ='$id' and stage = '21'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_19>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_19=0;$jj_19<$num_date_rows_19;$jj_19++){
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
	for($i_19 = 0 ;$i_19<$num_date_rows_19;$i_19++){
	while (list($day_19)=mysql_fetch_array($date_data_19)){
	$days_19[] = $day_19;
	}
	/*第一關日期陣列*/	
	array_push($days_array_19,$days_19[$i_19]);
	/*X軸的陣列資料*/
	if($num_date_rows_19>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_19[$i_19])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_19<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_19 = 0 ;$k_19<$num_date_rows_19;$k_19++){
	$rsum = 0;
	
	$day_19_19 = $days_array_19[$k_19];
	/*抓取有幾次測驗*/
	$count_data_19 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_19_19' and stage = '20'");
	$num_count_rows_19 = mysql_num_rows($count_data_19);
	/*For迴圈 Run測驗筆數*/
	for($ii_19 = 0 ;$ii_19<$num_count_rows_19;$ii_19++){
	list($count_19)=mysql_fetch_array($count_data_19);
		/*測驗資料丟到陣列*/
		$counts_19[$ii_19] = $count_19;
		}
			
	for($i_19_19 = 0 ;$i_19_19<$num_count_rows_19;$i_19_19++){
	$mtsum = 0;
	$following = 0;
	$counts_data_19 = $counts_19[$i_19_19];
	$result=mysql_query("SELECT attention FROM part_four WHERE date = '$day_19_19' AND account ='$id' and stage = '20' and count = '$counts_data_19'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_19 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_19 = 0 ; $j_19<=$output_count_19-1 ; $j_19++){
		if($mtoutput[$j_19]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_19];
		}
	$mtresum =  $following / ($output_count_19);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_19*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$asum = 0;
	
	$day_12_12 = $days_array_12[$k_12];
	/*抓取有幾次測驗*/
	$count_data_12 = mysql_query("SELECT distinct (count)  FROM part_four WHERE  account ='$id' and date = '$day_12_12' and stage = '21'");
	$num_count_rows_12 = mysql_num_rows($count_data_12);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_12 = 0 ;$ii_12<$num_count_rows_12;$ii_12++){
	list($count_12)=mysql_fetch_array($count_data_12);
		/*測驗資料丟到陣列*/
		$counts_12[$ii_12] = $count_12;
		}
			
	for($i_12_12 = 0 ;$i_12_12<$num_count_rows_12;$i_12_12++){
	$atsum = 0;
	$following = 0;
	$counts_data_12 = $counts_12[$i_12_12];
	$result2=mysql_query("SELECT attention FROM part_four WHERE date = '$day_12_12' AND account ='$id' and stage = '21' and count = '$counts_data_12'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_12 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_12 = 0 ; $j_12<=$output_count_12-1 ; $j_12++){
		if($atoutput[$j_12]<40)
		{
			$following++;
		}
		echo $atoutput[$j_12];
		$atsum += $atoutput[$j_12];
		}
	$atresum =  $following / ($output_count_12);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_12*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡二十(專心度) 與 關卡二十一(專心度) 腦波折線圖';
$key_array = array('關卡二十(專心度)', ' 關卡二十一(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\

$level_array = array();
$level_array2 = array();
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2,$stage,$stage2);
?>