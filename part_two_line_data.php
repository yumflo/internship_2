<?php
session_start();
 $id = $_SESSION['MM_Student'];
 $stage = $_SESSION['part_two'];
 $stage2 = $_SESSION['part_two2'];
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
if($stage == 7 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '7'");
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
		$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day' AND account ='$id' and stage = '7' and count = '$counts_data'");
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
$title ='關卡七(放鬆度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 8 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '8'");
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
		$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day' AND account ='$id' and stage = '8' and count = '$counts_data'");
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
$title ='關卡八(專心度) 腦波折線圖';
$key_array = array('關卡八(專心度)');	
$data_array = array($attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 9 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '9'");
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
		$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day' AND account ='$id' and stage = '9' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day' AND account ='$id' and stage = '9' and count = '$counts_data'");
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
$title ='關卡九(專心度) 與 關卡九(放鬆度) 腦波折線圖';
$key_array = array('關卡九(專心度)', '關卡九(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}

//------------------------------------------------------------------------------------------------------\\
if($stage == 10 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '10'");
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
		$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day' AND account ='$id' and stage = '10' and count = '$counts_data'");
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
$title ='關卡十(放鬆度) 腦波折線圖';
$key_array = array('關卡十(放鬆度)');	
$data_array = array($relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 11 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '11'");
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
		$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day' AND account ='$id' and stage = '11' and count = '$counts_data'");
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
$title ='關卡十一(專心度) 腦波折線圖';
$key_array = array('關卡十一(專心度)');
$data_array = array($attention_array);	
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 12 and $stage2 == "null"){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
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
		$count_data = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day' and stage = '12'");
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
		$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day' AND account ='$id' and stage = '12' and count = '$counts_data'");
		$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day' AND account ='$id' and stage = '12' and count = '$counts_data'");
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
$title ='關卡十二(專心度) 與 關卡十二(放鬆度) 腦波折線圖';
$key_array = array('關卡十二(專心度)', '關卡十二(放鬆度)');	
$data_array = array($attention_array,$relax_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 7 and $stage2 == 8){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_7 = array();
$days_array_8 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_7 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
	/*日期有幾筆*/
	$num_date_rows_7 = mysql_num_rows($date_data_7);
	/*抓取日期資料筆數*/
	$date_data_8 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
	/*日期有幾筆*/
	$num_date_rows_8 = mysql_num_rows($date_data_8);
	if($num_date_rows_7>$num_date_rows_8)
	{
	/*高值線與低值線*/	
	for($jj_7=0;$jj_7<$num_date_rows_7;$jj_7++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_8=0;$jj_8<$num_date_rows_8;$jj_8++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_7 = 0 ;$i_7<$num_date_rows_7;$i_7++){
	while (list($day_7)=mysql_fetch_array($date_data_7)){
	$days_7[] = $day_7;
	}
	/*第一關日期陣列*/	
	array_push($days_array_7,$days_7[$i_7]);
	/*X軸的陣列資料*/
	if($num_date_rows_7>=$num_date_rows_8)
	array_push($x_array,date('m/d', strtotime($days_7[$i_7])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_8 = 0 ;$i_8<$num_date_rows_8;$i_8++){
	while (list($day_8)=mysql_fetch_array($date_data_8)){
	$days_8[] = $day_8;
	}
	/*第二關日期陣列*/	
	array_push($days_array_8,$days_8[$i_8]);
	/*X軸的陣列資料*/
	if($num_date_rows_7<$num_date_rows_8)
	array_push($x_array,date('m/d', strtotime($days_8[$i_8])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_7 = 0 ;$k_7<$num_date_rows_7;$k_7++){
	$rsum = 0;
	
	$day_7_7 = $days_array_7[$k_7];
	/*抓取有幾次測驗*/
	$count_data_7 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_7_7' and stage = '7'");
	$num_count_rows_7 = mysql_num_rows($count_data_7);
	/*For迴圈 Run測驗筆數*/
	for($ii_7 = 0 ;$ii_7<$num_count_rows_7;$ii_7++){
	list($count_7)=mysql_fetch_array($count_data_7);
		/*測驗資料丟到陣列*/
		$counts_7[$ii_7] = $count_7;
		}
			
	for($i_7_7 = 0 ;$i_7_7<$num_count_rows_7;$i_7_7++){
	$mtsum = 0;
	$following = 0;
	$counts_data_7 = $counts_7[$i_7_7];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_7_7' AND account ='$id' and stage = '7' and count = '$counts_data_7'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_7 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_7 = 0 ; $j_7<=$output_count_7-1 ; $j_7++){
		if($mtoutput[$j_7]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_7];
		}
	$mtresum =  $following / ($output_count_7);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_7*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_8 = 0 ;$k_8<$num_date_rows_8;$k_8++){
	$asum = 0;
	
	$day_8_8 = $days_array_8[$k_8];
	/*抓取有幾次測驗*/
	$count_data_8 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_8_8' and stage = '8'");
	$num_count_rows_8 = mysql_num_rows($count_data_8);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_8 = 0 ;$ii_8<$num_count_rows_8;$ii_8++){
	list($count_8)=mysql_fetch_array($count_data_8);
		/*測驗資料丟到陣列*/
		$counts_8[$ii_8] = $count_8;
		}
			
	for($i_8_8 = 0 ;$i_8_8<$num_count_rows_8;$i_8_8++){
	$atsum = 0;
	$following = 0;
	$counts_data_8 = $counts_8[$i_8_8];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_8_8' AND account ='$id' and stage = '8' and count = '$counts_data_8'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_8 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_8 = 0 ; $j_8<=$output_count_8-1 ; $j_8++){
		if($atoutput[$j_8]<40)
		{
			$following++;
		}
		echo $atoutput[$j_8];
		$atsum += $atoutput[$j_8];
		}
	$atresum =  $following / ($output_count_8);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_8*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡七(放鬆度) 與 關卡八(專心度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)', ' 關卡八(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 7 and $stage2 == 9){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_7 = array();
$days_array_9 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_7 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
	/*日期有幾筆*/
	$num_date_rows_7 = mysql_num_rows($date_data_7);
	/*抓取日期資料筆數*/
	$date_data_9 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
	/*日期有幾筆*/
	$num_date_rows_9 = mysql_num_rows($date_data_9);
	if($num_date_rows_7>$num_date_rows_9)
	{
	/*高值線與低值線*/	
	for($jj_7=0;$jj_7<$num_date_rows_7;$jj_7++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_9=0;$jj_9<$num_date_rows_9;$jj_9++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_7 = 0 ;$i_7<$num_date_rows_7;$i_7++){
	while (list($day_7)=mysql_fetch_array($date_data_7)){
	$days_7[] = $day_7;
	}
	/*第一關日期陣列*/	
	array_push($days_array_7,$days_7[$i_7]);
	/*X軸的陣列資料*/
	if($num_date_rows_7>=$num_date_rows_9)
	array_push($x_array,date('m/d', strtotime($days_7[$i_7])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_9 = 0 ;$i_9<$num_date_rows_9;$i_9++){
	while (list($day_9)=mysql_fetch_array($date_data_9)){
	$days_9[] = $day_9;
	}
	/*第二關日期陣列*/	
	array_push($days_array_9,$days_9[$i_9]);
	/*X軸的陣列資料*/
	if($num_date_rows_7<$num_date_rows_9)
	array_push($x_array,date('m/d', strtotime($days_9[$i_9])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_7 = 0 ;$k_7<$num_date_rows_7;$k_7++){
	$rsum = 0;
	
	$day_7_7 = $days_array_7[$k_7];
	/*抓取有幾次測驗*/
	$count_data_7 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_7_7' and stage = '7'");
	$num_count_rows_7 = mysql_num_rows($count_data_7);
	/*For迴圈 Run測驗筆數*/
	for($ii_7 = 0 ;$ii_7<$num_count_rows_7;$ii_7++){
	list($count_7)=mysql_fetch_array($count_data_7);
		/*測驗資料丟到陣列*/
		$counts_7[$ii_7] = $count_7;
		}
			
	for($i_7_7 = 0 ;$i_7_7<$num_count_rows_7;$i_7_7++){
	$mtsum = 0;
	$following = 0;
	$counts_data_7 = $counts_7[$i_7_7];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_7_7' AND account ='$id' and stage = '7' and count = '$counts_data_7'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_7 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_7 = 0 ; $j_7<=$output_count_7-1 ; $j_7++){
		if($mtoutput[$j_7]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_7];
		}
	$mtresum =  $following / ($output_count_7);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_7*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_9 = 0 ;$k_9<$num_date_rows_9;$k_9++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_9 = $counts_9[$i_9_9];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_9 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($atoutput[$j_9]<40)
		{
			$following++;
		}
		echo $atoutput[$j_9];
		$atsum += $atoutput[$j_9];
		}
	$atresum =  $following / ($output_count_9);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_9*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡七(放鬆度) 與 關卡九(放鬆度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)', ' 關卡九(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 7 and $stage2 == 10){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_7 = array();
$days_array_10 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_7 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
	/*日期有幾筆*/
	$num_date_rows_7 = mysql_num_rows($date_data_7);
	/*抓取日期資料筆數*/
	$date_data_10 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
	/*日期有幾筆*/
	$num_date_rows_10 = mysql_num_rows($date_data_10);
	if($num_date_rows_7>$num_date_rows_10)
	{
	/*高值線與低值線*/	
	for($jj_7=0;$jj_7<$num_date_rows_7;$jj_7++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_10=0;$jj_10<$num_date_rows_10;$jj_10++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_7 = 0 ;$i_7<$num_date_rows_7;$i_7++){
	while (list($day_7)=mysql_fetch_array($date_data_7)){
	$days_7[] = $day_7;
	}
	/*第一關日期陣列*/	
	array_push($days_array_7,$days_7[$i_7]);
	/*X軸的陣列資料*/
	if($num_date_rows_7>=$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_7[$i_7])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_10 = 0 ;$i_10<$num_date_rows_10;$i_10++){
	while (list($day_10)=mysql_fetch_array($date_data_10)){
	$days_10[] = $day_10;
	}
	/*第二關日期陣列*/	
	array_push($days_array_10,$days_10[$i_10]);
	/*X軸的陣列資料*/
	if($num_date_rows_7<$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_10[$i_10])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_7 = 0 ;$k_7<$num_date_rows_7;$k_7++){
	$rsum = 0;
	
	$day_7_7 = $days_array_7[$k_7];
	/*抓取有幾次測驗*/
	$count_data_7 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_7_7' and stage = '7'");
	$num_count_rows_7 = mysql_num_rows($count_data_7);
	/*For迴圈 Run測驗筆數*/
	for($ii_7 = 0 ;$ii_7<$num_count_rows_7;$ii_7++){
	list($count_7)=mysql_fetch_array($count_data_7);
		/*測驗資料丟到陣列*/
		$counts_7[$ii_7] = $count_7;
		}
			
	for($i_7_7 = 0 ;$i_7_7<$num_count_rows_7;$i_7_7++){
	$mtsum = 0;
	$following = 0 ;
	$counts_data_7 = $counts_7[$i_7_7];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_7_7' AND account ='$id' and stage = '7' and count = '$counts_data_7'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_7 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_7 = 0 ; $j_7<=$output_count_7-1 ; $j_7++){
		if($mtoutput[$j_7]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_7];
		}
	$mtresum =  $following / ($output_count_7);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_7*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_10 = 0 ;$k_10<$num_date_rows_10;$k_10++){
	$asum = 0;
	
	$day_10_10 = $days_array_10[$k_10];
	/*抓取有幾次測驗*/
	$count_data_10 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_10_10' and stage = '10'");
	$num_count_rows_10 = mysql_num_rows($count_data_10);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_10 = 0 ;$ii_10<$num_count_rows_10;$ii_10++){
	list($count_10)=mysql_fetch_array($count_data_10);
		/*測驗資料丟到陣列*/
		$counts_10[$ii_10] = $count_10;
		}
			
	for($i_10_10 = 0 ;$i_10_10<$num_count_rows_10;$i_10_10++){
	$atsum = 0;
	$following = 0;
	$counts_data_10 = $counts_10[$i_10_10];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_10_10' AND account ='$id' and stage = '10' and count = '$counts_data_10'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_10 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_10 = 0 ; $j_10<=$output_count_10-1 ; $j_10++){
		if($atoutput[$j_10]<40)
		{
			$following++;
		}
		echo $atoutput[$j_10];
		$atsum += $atoutput[$j_10];
		}
	$atresum =  $following / ($output_count_10);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_10*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡七(放鬆度) 與 關卡十(放鬆度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)', ' 關卡十(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 7 and $stage2 == 11){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_7 = array();
$days_array_11 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_7 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
	/*日期有幾筆*/
	$num_date_rows_7 = mysql_num_rows($date_data_7);
	/*抓取日期資料筆數*/
	$date_data_11 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
	/*日期有幾筆*/
	$num_date_rows_11 = mysql_num_rows($date_data_11);
	if($num_date_rows_7>$num_date_rows_11)
	{
	/*高值線與低值線*/	
	for($jj_7=0;$jj_7<$num_date_rows_7;$jj_7++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_11=0;$jj_11<$num_date_rows_11;$jj_11++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_7 = 0 ;$i_7<$num_date_rows_7;$i_7++){
	while (list($day_7)=mysql_fetch_array($date_data_7)){
	$days_7[] = $day_7;
	}
	/*第一關日期陣列*/	
	array_push($days_array_7,$days_7[$i_7]);
	/*X軸的陣列資料*/
	if($num_date_rows_7>=$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_7[$i_7])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_11 = 0 ;$i_11<$num_date_rows_11;$i_11++){
	while (list($day_11)=mysql_fetch_array($date_data_11)){
	$days_11[] = $day_11;
	}
	/*第二關日期陣列*/	
	array_push($days_array_11,$days_11[$i_11]);
	/*X軸的陣列資料*/
	if($num_date_rows_7<$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_11[$i_11])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_7 = 0 ;$k_7<$num_date_rows_7;$k_7++){
	$rsum = 0;
	
	$day_7_7 = $days_array_7[$k_7];
	/*抓取有幾次測驗*/
	$count_data_7 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_7_7' and stage = '7'");
	$num_count_rows_7 = mysql_num_rows($count_data_7);
	/*For迴圈 Run測驗筆數*/
	for($ii_7 = 0 ;$ii_7<$num_count_rows_7;$ii_7++){
	list($count_7)=mysql_fetch_array($count_data_7);
		/*測驗資料丟到陣列*/
		$counts_7[$ii_7] = $count_7;
		}
			
	for($i_7_7 = 0 ;$i_7_7<$num_count_rows_7;$i_7_7++){
	$mtsum = 0;
	$following = 0 ;
	$counts_data_7 = $counts_7[$i_7_7];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_7_7' AND account ='$id' and stage = '7' and count = '$counts_data_7'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_7 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_7 = 0 ; $j_7<=$output_count_7-1 ; $j_7++){
		if($mtoutput[$j_7]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_7];
		}
	$mtresum =  $following / ($output_count_7);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_7*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_11 = 0 ;$k_11<$num_date_rows_11;$k_11++){
	$asum = 0;
	$day_11_11 = $days_array_11[$k_11];
	/*抓取有幾次測驗*/
	$count_data_11 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_11_11' and stage = '11'");
	$num_count_rows_11 = mysql_num_rows($count_data_11);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_11 = 0 ;$ii_11<$num_count_rows_11;$ii_11++){
	list($count_11)=mysql_fetch_array($count_data_11);
		/*測驗資料丟到陣列*/
		$counts_11[$ii_11] = $count_11;
		}
			
	for($i_11_11 = 0 ;$i_11_11<$num_count_rows_11;$i_11_11++){
	$atsum = 0;
	$following = 0;
	$counts_data_11 = $counts_11[$i_11_11];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_11_11' AND account ='$id' and stage = '11' and count = '$counts_data_11'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_11 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_11 = 0 ; $j_11<=$output_count_11-1 ; $j_11++){
		if($atoutput[$j_11]<40)
		{
			$following++;
		}
		echo $atoutput[$j_11];
		$atsum += $atoutput[$j_11];
		}
	$atresum =  $following / ($output_count_11);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_11*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡七(放鬆度) 與 關卡十一(專心度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)', ' 關卡十一(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 7 and $stage2 == 12){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_7 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_7 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '7'");
	/*日期有幾筆*/
	$num_date_rows_7 = mysql_num_rows($date_data_7);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_7>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_7=0;$jj_7<$num_date_rows_7;$jj_7++){
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
	for($i_7 = 0 ;$i_7<$num_date_rows_7;$i_7++){
	while (list($day_7)=mysql_fetch_array($date_data_7)){
	$days_7[] = $day_7;
	}
	/*第一關日期陣列*/	
	array_push($days_array_7,$days_7[$i_7]);
	/*X軸的陣列資料*/
	if($num_date_rows_7>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_7[$i_7])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_7<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_7 = 0 ;$k_7<$num_date_rows_7;$k_7++){
	$rsum = 0;
	
	$day_7_7 = $days_array_7[$k_7];
	/*抓取有幾次測驗*/
	$count_data_7 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_7_7' and stage = '7'");
	$num_count_rows_7 = mysql_num_rows($count_data_7);
	/*For迴圈 Run測驗筆數*/
	for($ii_7 = 0 ;$ii_7<$num_count_rows_7;$ii_7++){
	list($count_7)=mysql_fetch_array($count_data_7);
		/*測驗資料丟到陣列*/
		$counts_7[$ii_7] = $count_7;
		}
			
	for($i_7_7 = 0 ;$i_7_7<$num_count_rows_7;$i_7_7++){
	$mtsum = 0;
	$following = 0;
	$counts_data_7 = $counts_7[$i_7_7];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_7_7' AND account ='$id' and stage = '7' and count = '$counts_data_7'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_7 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_7 = 0 ; $j_7<=$output_count_7-1 ; $j_7++){
		if($mtoutput[$j_7]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_7];
		}
	$mtresum =  $following / ($output_count_7);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_7*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_12 = $counts_12[$i_12_12];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
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
$title ='關卡七(放鬆度) 與 關卡十二(放鬆度) 腦波折線圖';
$key_array = array('關卡七(放鬆度)', ' 關卡十二(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 8 and $stage2 == 9){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_8 = array();
$days_array_9 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_8 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
	/*日期有幾筆*/
	$num_date_rows_8 = mysql_num_rows($date_data_8);
	/*抓取日期資料筆數*/
	$date_data_9 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
	/*日期有幾筆*/
	$num_date_rows_9 = mysql_num_rows($date_data_9);
	if($num_date_rows_8>$num_date_rows_9)
	{
	/*高值線與低值線*/	
	for($jj_8=0;$jj_8<$num_date_rows_8;$jj_8++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_9=0;$jj_9<$num_date_rows_9;$jj_9++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_8 = 0 ;$i_8<$num_date_rows_8;$i_8++){
	while (list($day_8)=mysql_fetch_array($date_data_8)){
	$days_8[] = $day_8;
	}
	/*第一關日期陣列*/	
	array_push($days_array_8,$days_8[$i_8]);
	/*X軸的陣列資料*/
	if($num_date_rows_8>=$num_date_rows_9)
	array_push($x_array,date('m/d', strtotime($days_8[$i_8])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_9 = 0 ;$i_9<$num_date_rows_9;$i_9++){
	while (list($day_9)=mysql_fetch_array($date_data_9)){
	$days_9[] = $day_9;
	}
	/*第二關日期陣列*/	
	array_push($days_array_9,$days_9[$i_9]);
	/*X軸的陣列資料*/
	if($num_date_rows_8>$num_date_rows_9)
	array_push($x_array,date('m/d', strtotime($days_9[$i_9])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_8 = 0 ;$k_8<$num_date_rows_8;$k_8++){
	$rsum = 0;
	$day_8_8 = $days_array_8[$k_8];
	/*抓取有幾次測驗*/
	$count_data_8 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_8_8' and stage = '8'");
	$num_count_rows_8 = mysql_num_rows($count_data_8);
	/*For迴圈 Run測驗筆數*/
	for($ii_8 = 0 ;$ii_8<$num_count_rows_8;$ii_8++){
	list($count_8)=mysql_fetch_array($count_data_8);
		/*測驗資料丟到陣列*/
		$counts_8[$ii_8] = $count_8;
		}
			
	for($i_8_8 = 0 ;$i_8_8<$num_count_rows_8;$i_8_8++){
	$mtsum = 0;
	$following = 0;
	$counts_data_8 = $counts_8[$i_8_8];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_8_8' AND account ='$id' and stage = '8' and count = '$counts_data_8'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_8 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_8 = 0 ; $j_8<=$output_count_8-1 ; $j_8++){
		if($mtoutput[$j_8]<40)
		{
		$following++;
		}
		$mtsum += $mtoutput[$j_8];
		}
	$mtresum =  $following / ($output_count_8);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_8*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_9 = 0 ;$k_9<$num_date_rows_9;$k_9++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_9 = $counts_9[$i_9_9];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_9 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($atoutput[$j_9]<40)
		{
			$following++;
		}
		echo $atoutput[$j_9];
		$atsum += $atoutput[$j_9];
		}
	$atresum =  $following / ($output_count_9);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_9*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡八(專心度) 與 關卡九(專心度) 腦波折線圖';
$key_array = array('關卡八(專心度)', ' 關卡九(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 8 and $stage2 == 10){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_8 = array();
$days_array_10 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_8 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
	/*日期有幾筆*/
	$num_date_rows_8 = mysql_num_rows($date_data_8);
	/*抓取日期資料筆數*/
	$date_data_10 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
	/*日期有幾筆*/
	$num_date_rows_10 = mysql_num_rows($date_data_10);
	if($num_date_rows_8>$num_date_rows_10)
	{
	/*高值線與低值線*/	
	for($jj_8=0;$jj_8<$num_date_rows_8;$jj_8++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_10=0;$jj_10<$num_date_rows_10;$jj_10++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_8 = 0 ;$i_8<$num_date_rows_8;$i_8++){
	while (list($day_8)=mysql_fetch_array($date_data_8)){
	$days_8[] = $day_8;
	}
	/*第一關日期陣列*/	
	array_push($days_array_8,$days_8[$i_8]);
	/*X軸的陣列資料*/
	if($num_date_rows_8>=$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_8[$i_8])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_10 = 0 ;$i_10<$num_date_rows_10;$i_10++){
	while (list($day_10)=mysql_fetch_array($date_data_10)){
	$days_10[] = $day_10;
	}
	/*第二關日期陣列*/	
	array_push($days_array_10,$days_10[$i_10]);
	/*X軸的陣列資料*/
	if($num_date_rows_8<$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_10[$i_10])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_8 = 0 ;$k_8<$num_date_rows_8;$k_8++){
	$rsum = 0;
	
	$day_8_8 = $days_array_8[$k_8];
	/*抓取有幾次測驗*/
	$count_data_8 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_8_8' and stage = '8'");
	$num_count_rows_8 = mysql_num_rows($count_data_8);
	/*For迴圈 Run測驗筆數*/
	for($ii_8 = 0 ;$ii_8<$num_count_rows_8;$ii_8++){
	list($count_8)=mysql_fetch_array($count_data_8);
		/*測驗資料丟到陣列*/
		$counts_8[$ii_8] = $count_8;
		}
			
	for($i_8_8 = 0 ;$i_8_8<$num_count_rows_8;$i_8_8++){
	$mtsum = 0;
	$following = 0;
	$counts_data_8 = $counts_8[$i_8_8];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_8_8' AND account ='$id' and stage = '8' and count = '$counts_data_8'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_8 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_8 = 0 ; $j_8<=$output_count_8-1 ; $j_8++){
		if($mtoutput[$j_8]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_8];
		}
	$mtresum =  $following / ($output_count_8);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_8*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_10 = 0 ;$k_10<$num_date_rows_10;$k_10++){
	$asum = 0;
	$day_10_10 = $days_array_10[$k_10];
	/*抓取有幾次測驗*/
	$count_data_10 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_10_10' and stage = '10'");
	$num_count_rows_10 = mysql_num_rows($count_data_10);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_10 = 0 ;$ii_10<$num_count_rows_10;$ii_10++){
	list($count_10)=mysql_fetch_array($count_data_10);
		/*測驗資料丟到陣列*/
		$counts_10[$ii_10] = $count_10;
		}
			
	for($i_10_10 = 0 ;$i_10_10<$num_count_rows_10;$i_10_10++){
	$atsum = 0;
	$following = 0;
	$counts_data_10 = $counts_10[$i_10_10];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_10_10' AND account ='$id' and stage = '10' and count = '$counts_data_10'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_10 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_10 = 0 ; $j_10<=$output_count_10-1 ; $j_10++){
		if($atoutput[$j_10]<40)
		{
			$following++;
		}
		echo $atoutput[$j_10];
		$atsum += $atoutput[$j_10];
		}
	$atresum =  $following / ($output_count_10);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_10*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡八(專心度) 與 關卡十(放鬆度) 腦波折線圖';
$key_array = array('關卡八(專心度)', ' 關卡十(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 8 and $stage2 == 11){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_8 = array();
$days_array_11 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_8 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
	/*日期有幾筆*/
	$num_date_rows_8 = mysql_num_rows($date_data_8);
	/*抓取日期資料筆數*/
	$date_data_11 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
	/*日期有幾筆*/
	$num_date_rows_11 = mysql_num_rows($date_data_11);
	if($num_date_rows_8>$num_date_rows_11)
	{
	/*高值線與低值線*/	
	for($jj_8=0;$jj_8<$num_date_rows_8;$jj_8++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_11=0;$jj_11<$num_date_rows_11;$jj_11++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_8 = 0 ;$i_8<$num_date_rows_8;$i_8++){
	while (list($day_8)=mysql_fetch_array($date_data_8)){
	$days_8[] = $day_8;
	}
	/*第一關日期陣列*/	
	array_push($days_array_8,$days_8[$i_8]);
	/*X軸的陣列資料*/
	if($num_date_rows_8>=$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_8[$i_8])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_11 = 0 ;$i_11<$num_date_rows_11;$i_11++){
	while (list($day_11)=mysql_fetch_array($date_data_11)){
	$days_11[] = $day_11;
	}
	/*第二關日期陣列*/	
	array_push($days_array_11,$days_11[$i_11]);
	/*X軸的陣列資料*/
	if($num_date_rows_8<$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_11[$i_11])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_8 = 0 ;$k_8<$num_date_rows_8;$k_8++){
	$rsum = 0;
	
	$day_8_8 = $days_array_8[$k_8];
	/*抓取有幾次測驗*/
	$count_data_8 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_8_8' and stage = '8'");
	$num_count_rows_8 = mysql_num_rows($count_data_8);
	/*For迴圈 Run測驗筆數*/
	for($ii_8 = 0 ;$ii_8<$num_count_rows_8;$ii_8++){
	list($count_8)=mysql_fetch_array($count_data_8);
		/*測驗資料丟到陣列*/
		$counts_8[$ii_8] = $count_8;
		}
			
	for($i_8_8 = 0 ;$i_8_8<$num_count_rows_8;$i_8_8++){
	$mtsum = 0;
	$following = 0;
	$counts_data_8 = $counts_8[$i_8_8];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_8_8' AND account ='$id' and stage = '8' and count = '$counts_data_8'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_8 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_8 = 0 ; $j_8<=$output_count_8-1 ; $j_8++){
		if($mtoutput[$j_8]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_8];
		}
	$mtresum =  $following / ($output_count_8);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_8*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_11 = 0 ;$k_11<$num_date_rows_11;$k_11++){
	$asum = 0;
	$day_11_11 = $days_array_11[$k_11];
	/*抓取有幾次測驗*/
	$count_data_11 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_11_11' and stage = '11'");
	$num_count_rows_11 = mysql_num_rows($count_data_11);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_11 = 0 ;$ii_11<$num_count_rows_11;$ii_11++){
	list($count_11)=mysql_fetch_array($count_data_11);
		/*測驗資料丟到陣列*/
		$counts_11[$ii_11] = $count_11;
		}
			
	for($i_11_11 = 0 ;$i_11_11<$num_count_rows_11;$i_11_11++){
	$atsum = 0;
	$following = 0;
	$counts_data_11 = $counts_11[$i_11_11];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_11_11' AND account ='$id' and stage = '11' and count = '$counts_data_11'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_11 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_11 = 0 ; $j_11<=$output_count_11-1 ; $j_11++){
		if($atoutput[$j_11]<40)
		{
			$following++;
		}
		echo $atoutput[$j_11];
		$atsum += $atoutput[$j_11];
		}
	$atresum =  $following / ($output_count_11);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_11*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡八(專心度) 與 關卡十一(專心度) 腦波折線圖';
$key_array = array('關卡八(專心度)', ' 關卡十一(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 8 and $stage2 == 12){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_8 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_8 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '8'");
	/*日期有幾筆*/
	$num_date_rows_8 = mysql_num_rows($date_data_8);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_8>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_8=0;$jj_8<$num_date_rows_8;$jj_8++){
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
	for($i_8 = 0 ;$i_8<$num_date_rows_8;$i_8++){
	while (list($day_8)=mysql_fetch_array($date_data_8)){
	$days_8[] = $day_8;
	}
	/*第一關日期陣列*/	
	array_push($days_array_8,$days_8[$i_8]);
	/*X軸的陣列資料*/
	if($num_date_rows_8>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_8[$i_8])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_8<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_8 = 0 ;$k_8<$num_date_rows_8;$k_8++){
	$rsum = 0;
	
	$day_8_8 = $days_array_8[$k_8];
	/*抓取有幾次測驗*/
	$count_data_8 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_8_8' and stage = '8'");
	$num_count_rows_8 = mysql_num_rows($count_data_8);
	/*For迴圈 Run測驗筆數*/
	for($ii_8 = 0 ;$ii_8<$num_count_rows_8;$ii_8++){
	list($count_8)=mysql_fetch_array($count_data_8);
		/*測驗資料丟到陣列*/
		$counts_8[$ii_8] = $count_8;
		}
			
	for($i_8_8 = 0 ;$i_8_8<$num_count_rows_8;$i_8_8++){
	$mtsum = 0;
	$following = 0;
	$counts_data_8 = $counts_8[$i_8_8];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_8_8' AND account ='$id' and stage = '8' and count = '$counts_data_8'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_8 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_8 = 0 ; $j_8<=$output_count_8-1 ; $j_8++){
		if($mtoutput[$j_8]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_8];
		}
	$mtresum =  $following / ($output_count_8);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_8*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$asum = 0;
	
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
	$atsum = 0;
	$following = 0;
	$counts_data_12 = $counts_12[$i_12_12];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
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
$title ='關卡八(專心度) 與 關卡十二(專心度) 腦波折線圖';
$key_array = array('關卡八(專心度)', ' 關卡十二(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 9 and $stage2 == 10){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_9 = array();
$days_array_10 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_9 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
	/*日期有幾筆*/
	$num_date_rows_9 = mysql_num_rows($date_data_9);
	/*抓取日期資料筆數*/
	$date_data_10 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
	/*日期有幾筆*/
	$num_date_rows_10 = mysql_num_rows($date_data_10);
	if($num_date_rows_9>$num_date_rows_10)
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
	for($jj_10=0;$jj_10<$num_date_rows_10;$jj_10++){
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
	if($num_date_rows_9>=$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_9[$i_9])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_10 = 0 ;$i_10<$num_date_rows_10;$i_10++){
	while (list($day_10)=mysql_fetch_array($date_data_10)){
	$days_10[] = $day_10;
	}
	/*第二關日期陣列*/	
	array_push($days_array_10,$days_10[$i_10]);
	/*X軸的陣列資料*/
	if($num_date_rows_9<$num_date_rows_10)
	array_push($x_array,date('m/d', strtotime($days_10[$i_10])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_9 = 0 ;$k_9<$num_date_rows_9;$k_9++){
	$rsum = 0;
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
	$mtsum = 0;
	$following = 0;
	$counts_data_9 = $counts_9[$i_9_9];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_9 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($mtoutput[$j_9]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_9];
		}
	$mtresum =  $following / ($output_count_9);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_9*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_10 = 0 ;$k_10<$num_date_rows_10;$k_10++){
	$asum = 0;
	$day_10_10 = $days_array_10[$k_10];
	/*抓取有幾次測驗*/
	$count_data_10 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_10_10' and stage = '10'");
	$num_count_rows_10 = mysql_num_rows($count_data_10);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_10 = 0 ;$ii_10<$num_count_rows_10;$ii_10++){
	list($count_10)=mysql_fetch_array($count_data_10);
		/*測驗資料丟到陣列*/
		$counts_10[$ii_10] = $count_10;
		}
			
	for($i_10_10 = 0 ;$i_10_10<$num_count_rows_10;$i_10_10++){
	$atsum = 0;
	$following = 0;
	$counts_data_10 = $counts_10[$i_10_10];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_10_10' AND account ='$id' and stage = '10' and count = '$counts_data_10'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_10 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_10 = 0 ; $j_10<=$output_count_10-1 ; $j_10++){
		if($atoutput[$j_10]<40)
		{
			$following++;
		}
		echo $atoutput[$j_10];
		$atsum += $atoutput[$j_10];
		}
	$atresum =  $following / ($output_count_10);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_10*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡九(放鬆度) 與 關卡十(放鬆度) 腦波折線圖';
$key_array = array('關卡九(放鬆度)', ' 關卡十(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 9 and $stage2 == 11){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_9 = array();
$days_array_11 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_9 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '9'");
	/*日期有幾筆*/
	$num_date_rows_9 = mysql_num_rows($date_data_9);
	/*抓取日期資料筆數*/
	$date_data_11 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
	/*日期有幾筆*/
	$num_date_rows_11 = mysql_num_rows($date_data_11);
	if($num_date_rows_9>$num_date_rows_11)
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
	for($jj_11=0;$jj_11<$num_date_rows_11;$jj_11++){
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
	if($num_date_rows_9>=$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_9[$i_9])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_11 = 0 ;$i_11<$num_date_rows_11;$i_11++){
	while (list($day_11)=mysql_fetch_array($date_data_11)){
	$days_11[] = $day_11;
	}
	/*第二關日期陣列*/	
	array_push($days_array_11,$days_11[$i_11]);
	/*X軸的陣列資料*/
	if($num_date_rows_9<$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_11[$i_11])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_9 = 0 ;$k_9<$num_date_rows_9;$k_9++){
	$rsum = 0;
	
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
	$mtsum = 0;
	$following = 0;
	$counts_data_9 = $counts_9[$i_9_9];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_9_9' AND account ='$id' and stage = '9' and count = '$counts_data_9'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_9 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_9 = 0 ; $j_9<=$output_count_9-1 ; $j_9++){
		if($mtoutput[$j_9]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_9];
		}
	$mtresum =  $following / ($output_count_9);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_9*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_11 = 0 ;$k_11<$num_date_rows_11;$k_11++){
	$asum = 0;
	
	$day_11_11 = $days_array_11[$k_11];
	/*抓取有幾次測驗*/
	$count_data_11 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_11_11' and stage = '11'");
	$num_count_rows_11 = mysql_num_rows($count_data_11);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_11 = 0 ;$ii_11<$num_count_rows_11;$ii_11++){
	list($count_11)=mysql_fetch_array($count_data_11);
		/*測驗資料丟到陣列*/
		$counts_11[$ii_11] = $count_11;
		}
			
	for($i_11_11 = 0 ;$i_11_11<$num_count_rows_11;$i_11_11++){
	$atsum = 0;
	$following = 0;
	$counts_data_11 = $counts_11[$i_11_11];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_11_11' AND account ='$id' and stage = '11' and count = '$counts_data_11'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_11 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_11 = 0 ; $j_11<=$output_count_11-1 ; $j_11++){
		if($atoutput[$j_11]<40)
		{
			$following++;
		}
		echo $atoutput[$j_11];
		$atsum += $atoutput[$j_11];
		}
	$atresum =  $following / ($output_count_11);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_11*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡九(專心度) 與 關卡十一(專心度) 腦波折線圖';
$key_array = array('關卡九(專心度)', ' 關卡十一(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 10 and $stage2 == 11){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_10 = array();
$days_array_11 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_10 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
	/*日期有幾筆*/
	$num_date_rows_10 = mysql_num_rows($date_data_10);
	/*抓取日期資料筆數*/
	$date_data_11 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
	/*日期有幾筆*/
	$num_date_rows_11 = mysql_num_rows($date_data_11);
	if($num_date_rows_10>$num_date_rows_11)
	{
	/*高值線與低值線*/	
	for($jj_10=0;$jj_10<$num_date_rows_10;$jj_10++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	else
	{
	/*高值線與低值線*/	
	for($jj_11=0;$jj_11<$num_date_rows_11;$jj_11++){
	array_push($high_level_line_data,60);
	array_push($low_level_line_data,40);
	}
		}
	/*抓出來的日期丟到陣列內*/
	for($i_10 = 0 ;$i_10<$num_date_rows_10;$i_10++){
	while (list($day_10)=mysql_fetch_array($date_data_10)){
	$days_10[] = $day_10;
	}
	/*第一關日期陣列*/	
	array_push($days_array_10,$days_10[$i_10]);
	/*X軸的陣列資料*/
	if($num_date_rows_10>=$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_10[$i_10])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_11 = 0 ;$i_11<$num_date_rows_11;$i_11++){
	while (list($day_11)=mysql_fetch_array($date_data_11)){
	$days_11[] = $day_11;
	}
	/*第二關日期陣列*/	
	array_push($days_array_11,$days_11[$i_11]);
	/*X軸的陣列資料*/
	if($num_date_rows_10<$num_date_rows_11)
	array_push($x_array,date('m/d', strtotime($days_11[$i_11])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_10 = 0 ;$k_10<$num_date_rows_10;$k_10++){
	$rsum = 0;
	
	$day_10_10 = $days_array_10[$k_10];
	/*抓取有幾次測驗*/
	$count_data_10 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_10_10' and stage = '10'");
	$num_count_rows_10 = mysql_num_rows($count_data_10);
	/*For迴圈 Run測驗筆數*/
	for($ii_10 = 0 ;$ii_10<$num_count_rows_10;$ii_10++){
	list($count_10)=mysql_fetch_array($count_data_10);
		/*測驗資料丟到陣列*/
		$counts_10[$ii_10] = $count_10;
		}
			
	for($i_10_10 = 0 ;$i_10_10<$num_count_rows_10;$i_10_10++){
	$mtsum = 0;
	$following = 0;
	$counts_data_10 = $counts_10[$i_10_10];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_10_10' AND account ='$id' and stage = '10' and count = '$counts_data_10'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_10 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_10 = 0 ; $j_10<=$output_count_10-1 ; $j_10++){
		if($mtoutput[$j_10]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_10];
		}
	$mtresum =  $following / ($output_count_10);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_10*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_11 = 0 ;$k_11<$num_date_rows_11;$k_11++){
	$asum = 0;
	$day_11_11 = $days_array_11[$k_11];
	/*抓取有幾次測驗*/
	$count_data_11 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_11_11' and stage = '11'");
	$num_count_rows_11 = mysql_num_rows($count_data_11);		
	
	/*For迴圈 Run測驗筆數*/
	for($ii_11 = 0 ;$ii_11<$num_count_rows_11;$ii_11++){
	list($count_11)=mysql_fetch_array($count_data_11);
		/*測驗資料丟到陣列*/
		$counts_11[$ii_11] = $count_11;
		}
			
	for($i_11_11 = 0 ;$i_11_11<$num_count_rows_11;$i_11_11++){
	$atsum = 0;
	$following = 0;
	$counts_data_11 = $counts_11[$i_11_11];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_11_11' AND account ='$id' and stage = '11' and count = '$counts_data_11'");
	while (list($a)=mysql_fetch_row($result2)){
		$atstring  = $a;
	$output_count_11 = substr_count($atstring,",");
	$atoutput = explode(",", $atstring);
	for($j_11 = 0 ; $j_11<=$output_count_11-1 ; $j_11++){
		if($atoutput[$j_11]<40)
		{
			$following++;
		}
		echo $atoutput[$j_11];
		$atsum += $atoutput[$j_11];
		}
	$atresum =  $following / ($output_count_11);
	}
	$asum += $atresum;
}
$asums = round (100-($asum / $num_count_rows_11*100),2);
array_push($attention_array,$asums);
}	
$title ='關卡十(放鬆度) 與 關卡十一(專心度) 腦波折線圖';
$key_array = array('關卡十(放鬆度)', ' 關卡十一(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 10 and $stage2 == 12){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_10 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_10 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '10'");
	/*日期有幾筆*/
	$num_date_rows_10 = mysql_num_rows($date_data_10);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_10>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_10=0;$jj_10<$num_date_rows_10;$jj_10++){
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
	for($i_10 = 0 ;$i_10<$num_date_rows_10;$i_10++){
	while (list($day_10)=mysql_fetch_array($date_data_10)){
	$days_10[] = $day_10;
	}
	/*第一關日期陣列*/	
	array_push($days_array_10,$days_10[$i_10]);
	/*X軸的陣列資料*/
	if($num_date_rows_10>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_10[$i_10])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_10<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_10 = 0 ;$k_10<$num_date_rows_10;$k_10++){
	$rsum = 0;
	
	$day_10_10 = $days_array_10[$k_10];
	/*抓取有幾次測驗*/
	$count_data_10 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_10_10' and stage = '10'");
	$num_count_rows_10 = mysql_num_rows($count_data_10);
	/*For迴圈 Run測驗筆數*/
	for($ii_10 = 0 ;$ii_10<$num_count_rows_10;$ii_10++){
	list($count_10)=mysql_fetch_array($count_data_10);
		/*測驗資料丟到陣列*/
		$counts_10[$ii_10] = $count_10;
		}
			
	for($i_10_10 = 0 ;$i_10_10<$num_count_rows_10;$i_10_10++){
	$mtsum = 0;
	$following = 0;
	$counts_data_10 = $counts_10[$i_10_10];
	$result=mysql_query("SELECT relax FROM part_two WHERE date = '$day_10_10' AND account ='$id' and stage = '10' and count = '$counts_data_10'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_10 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_10 = 0 ; $j_10<=$output_count_10-1 ; $j_10++){
		if($mtoutput[$j_10]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_10];
		}
	$mtresum =  $following / ($output_count_10);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_10*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_12 = $counts_12[$i_12_12];
	$result2=mysql_query("SELECT relax FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
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
$title ='關卡十(放鬆度) 與 關卡十二(放鬆度) 腦波折線圖';
$key_array = array('關卡十(放鬆度)', ' 關卡十二(放鬆度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\
else if($stage == 11 and $stage2 == 12){
$high_level_line_data = array();
$low_level_line_data = array();
$days_array_11 = array();
$days_array_12 = array();
$x_array = array();
	/*抓取日期資料筆數*/
	$date_data_11 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '11'");
	/*日期有幾筆*/
	$num_date_rows_11 = mysql_num_rows($date_data_11);
	/*抓取日期資料筆數*/
	$date_data_12 = mysql_query("SELECT distinct (date) FROM part_two WHERE  account ='$id' and stage = '12'");
	/*日期有幾筆*/
	$num_date_rows_12 = mysql_num_rows($date_data_12);
	if($num_date_rows_11>$num_date_rows_12)
	{
	/*高值線與低值線*/	
	for($jj_11=0;$jj_11<$num_date_rows_11;$jj_11++){
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
	for($i_11 = 0 ;$i_11<$num_date_rows_11;$i_11++){
	while (list($day_11)=mysql_fetch_array($date_data_11)){
	$days_11[] = $day_11;
	}
	/*第一關日期陣列*/	
	array_push($days_array_11,$days_11[$i_11]);
	/*X軸的陣列資料*/
	if($num_date_rows_11>=$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_11[$i_11])));
	}
	/*抓出來的日期丟到陣列內*/	
	for($i_12 = 0 ;$i_12<$num_date_rows_12;$i_12++){
	while (list($day_12)=mysql_fetch_array($date_data_12)){
	$days_12[] = $day_12;
	}
	/*第二關日期陣列*/	
	array_push($days_array_12,$days_12[$i_12]);
	/*X軸的陣列資料*/
	if($num_date_rows_11<$num_date_rows_12)
	array_push($x_array,date('m/d', strtotime($days_12[$i_12])));
	}	
	/*測驗數據資料*/
	$attention_array = array();
	$relax_array = array();

	/*For迴圈 Run日期筆數*/
	for($k_11 = 0 ;$k_11<$num_date_rows_11;$k_11++){
	$rsum = 0;
	
	$day_11_11 = $days_array_11[$k_11];
	/*抓取有幾次測驗*/
	$count_data_11 = mysql_query("SELECT distinct (count)  FROM part_two WHERE  account ='$id' and date = '$day_11_11' and stage = '11'");
	$num_count_rows_11 = mysql_num_rows($count_data_11);
	/*For迴圈 Run測驗筆數*/
	for($ii_11 = 0 ;$ii_11<$num_count_rows_11;$ii_11++){
	list($count_11)=mysql_fetch_array($count_data_11);
		/*測驗資料丟到陣列*/
		$counts_11[$ii_11] = $count_11;
		}
			
	for($i_11_11 = 0 ;$i_11_11<$num_count_rows_11;$i_11_11++){
	$mtsum = 0;
	$following = 0;
	$counts_data_11 = $counts_11[$i_11_11];
	$result=mysql_query("SELECT attention FROM part_two WHERE date = '$day_11_11' AND account ='$id' and stage = '11' and count = '$counts_data_11'");
	while (list($m)=mysql_fetch_row($result)){
		$mtstring  = $m;
	$output_count_11 = substr_count($mtstring,",");
	$mtoutput = explode(",", $mtstring);
	for($j_11 = 0 ; $j_11<=$output_count_11-1 ; $j_11++){
		if($mtoutput[$j_11]<40)
		{
			$following++;
		}
		$mtsum += $mtoutput[$j_11];
		}
	$mtresum =  $following / ($output_count_11);
	}
	$rsum += $mtresum;
}
$rsums = round (100-($rsum / $num_count_rows_11*100),2);
array_push($relax_array,$rsums);
}		
	/*For迴圈 Run日期筆數*/
	for($k_12 = 0 ;$k_12<$num_date_rows_12;$k_12++){
	$asum = 0;
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
	$atsum = 0;
	$following = 0;
	$counts_data_12 = $counts_12[$i_12_12];
	$result2=mysql_query("SELECT attention FROM part_two WHERE date = '$day_12_12' AND account ='$id' and stage = '12' and count = '$counts_data_12'");
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
$title ='關卡十一(專心度) 與 關卡十二(專心度) 腦波折線圖';
$key_array = array('關卡十一(專心度)', ' 關卡十二(專心度)');
$data_array = array($relax_array,$attention_array);
}
//------------------------------------------------------------------------------------------------------\\


$level_array = array();
$level_array2 = array();
echo part_chart($stage,$stage2);
echo chart('line', $title, $x_array, $key_array, $data_array, $level_array,$level_array2,$stage,$stage2);
?>