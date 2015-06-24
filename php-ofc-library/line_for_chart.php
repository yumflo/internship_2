<?php
//include
include_once('php-ofc-library/open-flash-chart.php');
include_once('php-ofc-library/open_flash_chart_object.php');
//function
function part_chart($stage = '',$stage2 = ''){
	if(($stage== 3 and $stage2== 6) || ($stage== 9 and $stage2== 12) || ($stage== 15 and $stage2== 18)){
	function chart($type = '', $title = '', $label_array = array(), $key_array = array(), $data_array = array(),$level_array = array(),$level_array2 = array(),$data_array2 = array(),$data_array3 = array(),$stage = '',$stage2 = '') {
		$color_array = array('#57509a', '#a1cf87');
	$color = 0;
	$gph = new graph();
	if ($type == 'pie') {
		$gph -> pie(50,'#505050','{font-size: 12px; color: #404040;');
		$gph -> pie_values( $data_array[0], $label_array );
		$gph -> pie_slice_colours( $color_array );
	} else {
		$max = 0;
		foreach ($key_array as $k => $v) {
			$color = $k % 10;
			$gph -> set_data($data_array[$k]);
			switch ($type) {
				case 'bar':
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> bar( 50, $color_array[$color], $v, 10 );
					
				break;
				case 'area':
					$gph -> area_hollow( 2, 3, 25, $color_array[$color], $v, 10, $color_array[$color]);
				break;
				default:
					if($stage ==3 and $stage2 ==6){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($data_array2[0]);
					$gph -> line_hollow( 3, 6, '#ee81ae', '關卡六(專心度)', 10 );
					$gph -> set_data($data_array3[0]);
					$gph -> line_hollow( 3, 6, '#40b46d', '關卡六(放鬆度)', 10 );
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000');
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
					}
				}
				else if($stage ==9 and $stage2 ==12){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($data_array2[0]);
					$gph -> line_hollow( 3, 6, '#ee81ae', '關卡十二(專心度)', 10 );
					$gph -> set_data($data_array3[0]);
					$gph -> line_hollow( 3, 6, '#40b46d', '關卡十二(放鬆度)', 10 );
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000');
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
					}
				}
				else if($stage ==15 and $stage2 ==18){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($data_array2[0]);
					$gph -> line_hollow( 3, 6, '#ee81ae', '關卡十八(專心度)', 10 );
					$gph -> set_data($data_array3[0]);
					$gph -> line_hollow( 3, 6, '#40b46d', '關卡十八(放鬆度)', 10 );
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000');
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
					}
				}
				
				
				break;
			}
			rsort($data_array[$k], SORT_NUMERIC);
			$max = ($data_array[$k][0] > $max) ? $data_array[$k][0] : $max;
		}
		$gph -> set_x_labels( $label_array );
	}
	$gph -> title( $title, '{font-size: 14px; type:right}' );
	echo $gph->render();
}
}
else{
function chart($type = '', $title = '', $label_array = array(), $key_array = array(), $data_array = array(),$level_array = array(),$level_array2 = array(),$stage = '',$stage2 = ''){
		if($stage == null and $stage2 == null){
			$color_array = array('#e7224b','#1675b6');
			}
		else if($stage == 1 and $stage2 == "null"){
			$color_array = array('#1770a6');
			}
		else if($stage == 2 and $stage2 == "null"){
			$color_array = array('#f5cf60');
			}
		else if($stage == 3 and $stage2 == "null"){
			$color_array = array('#57509a','#a1cf87');
			}
		else if($stage == 4 and $stage2 == "null"){
			$color_array = array('#43c0e8');
			}
		else if($stage == 5 and $stage2 == "null"){
			$color_array = array('#d9324d');
			}
		else if($stage == 6 and $stage2 == "null"){
			$color_array = array('#ee81ae','#40b46d');
			}
		else if($stage == 1 and $stage2 == 3){
			$color_array = array('#1770a6', '#a1cf87');
			}
		else if	($stage == 3 and $stage2 == 4){
			$color_array = array('#a1cf87', '#43c0e8');
			}
		else if($stage == 1 and $stage2 == 6){
			$color_array = array('#1770a6', '#40b46d');
			}
		else if($stage == 4 and $stage2 == 6){
			$color_array = array('#43c0e8', '#40b46d');
			}
		else if($stage == 2 and $stage2 == 3){
			$color_array = array('#f5cf60', '#57509a');
			}
		else if($stage == 3 and $stage2 == 5){
			$color_array = array('#57509a', '#d9324d');
			}	
		else if($stage == 2 and $stage2 == 6){
			$color_array = array('#f5cf60', '#ee81ae');
			}
		else if($stage == 5 and $stage2 == 6){
			$color_array = array('#d9324d', '#ee81ae');
			}
		else if($stage == 1 and $stage2 == 2){
			$color_array = array('#1770a6', '#f5cf60');
			}
		else if($stage == 1 and $stage2 == 4){
			$color_array = array('#1770a6', '#43c0e8');
			}
		else if($stage == 1 and $stage2 == 5){
			$color_array = array('#1770a6', '#d9324d');
			}
		else if($stage == 2 and $stage2 == 4){
			$color_array = array('#f5cf60', '#43c0e8');
			}
		else if($stage == 2 and $stage2 == 5){
			$color_array = array('#f5cf60', '#d9324d');
			}
		else if($stage == 4 and $stage2 == 5){
			$color_array = array('#43c0e8', '#d9324d');
			}
		/*7~12*/
		else if($stage == 7 and $stage2 == "null"){
			$color_array = array('#1770a6');
			}
		else if($stage == 8 and $stage2 == "null"){
			$color_array = array('#f5cf60');
			}
		else if($stage == 9 and $stage2 == "null"){
			$color_array = array('#57509a','#a1cf87');
			}
		else if($stage == 10 and $stage2 == "null"){
			$color_array = array('#43c0e8');
			}
		else if($stage == 11 and $stage2 == "null"){
			$color_array = array('#d9324d');
			}
		else if($stage == 12 and $stage2 == "null"){
			$color_array = array('#ee81ae','#40b46d');
			}
		else if($stage == 7 and $stage2 == 9){
			$color_array = array('#1770a6', '#a1cf87');
			}
		else if	($stage == 9 and $stage2 == 10){
			$color_array = array('#a1cf87', '#43c0e8');
			}
		else if($stage == 7 and $stage2 == 12){
			$color_array = array('#1770a6', '#40b46d');
			}
		else if($stage == 10 and $stage2 == 12){
			$color_array = array('#43c0e8', '#40b46d');
			}
		else if($stage == 8 and $stage2 == 9){
			$color_array = array('#f5cf60', '#57509a');
			}
		else if($stage == 9 and $stage2 == 11){
			$color_array = array('#57509a', '#d9324d');
			}	
		else if($stage == 8 and $stage2 == 12){
			$color_array = array('#f5cf60', '#ee81ae');
			}
		else if($stage == 11 and $stage2 == 12){
			$color_array = array('#d9324d', '#ee81ae');
			}
		else if($stage == 7 and $stage2 == 8){
			$color_array = array('#1770a6', '#f5cf60');
			}
		else if($stage == 7 and $stage2 == 10){
			$color_array = array('#1770a6', '#43c0e8');
			}
		else if($stage == 7 and $stage2 == 11){
			$color_array = array('#1770a6', '#d9324d');
			}
		else if($stage == 8 and $stage2 == 10){
			$color_array = array('#f5cf60', '#43c0e8');
			}
		else if($stage == 8 and $stage2 == 11){
			$color_array = array('#f5cf60', '#d9324d');
			}
		else if($stage == 10 and $stage2 == 11){
			$color_array = array('#43c0e8', '#d9324d');
			}
			/*13~18*/
		else if($stage == 13 and $stage2 == "null"){
			$color_array = array('#1770a6');
			}
		else if($stage == 14 and $stage2 == "null"){
			$color_array = array('#f5cf60');
			}
		else if($stage == 15 and $stage2 == "null"){
			$color_array = array('#57509a','#a1cf87');
			}
		else if($stage == 16 and $stage2 == "null"){
			$color_array = array('#43c0e8');
			}
		else if($stage == 17 and $stage2 == "null"){
			$color_array = array('#d9324d');
			}
		else if($stage == 18 and $stage2 == "null"){
			$color_array = array('#ee81ae','#40b46d');
			}
		else if($stage == 13 and $stage2 == 15){
			$color_array = array('#1770a6', '#a1cf87');
			}
		else if	($stage == 15 and $stage2 == 16){
			$color_array = array('#a1cf87', '#43c0e8');
			}
		else if($stage == 13 and $stage2 == 18){
			$color_array = array('#1770a6', '#40b46d');
			}
		else if($stage == 16 and $stage2 == 18){
			$color_array = array('#43c0e8', '#40b46d');
			}
		else if($stage == 14 and $stage2 == 15){
			$color_array = array('#f5cf60', '#57509a');
			}
		else if($stage == 15 and $stage2 == 17){
			$color_array = array('#57509a', '#d9324d');
			}	
		else if($stage == 14 and $stage2 == 18){
			$color_array = array('#f5cf60', '#ee81ae');
			}
		else if($stage == 17 and $stage2 == 18){
			$color_array = array('#d9324d', '#ee81ae');
			}
		else if($stage == 13 and $stage2 == 14){
			$color_array = array('#1770a6', '#f5cf60');
			}
		else if($stage == 13 and $stage2 == 16){
			$color_array = array('#1770a6', '#43c0e8');
			}
		else if($stage == 13 and $stage2 == 17){
			$color_array = array('#1770a6', '#d9324d');
			}
		else if($stage == 14 and $stage2 == 16){
			$color_array = array('#f5cf60', '#43c0e8');
			}
		else if($stage == 14 and $stage2 == 17){
			$color_array = array('#f5cf60', '#d9324d');
			}
		else if($stage == 16 and $stage2 == 17){
			$color_array = array('#43c0e8', '#d9324d');
			}
		/*19~21*/
		else if($stage == 19 and $stage2 == "null"){
			$color_array = array('#1770a6');
			}
		else if($stage == 20 and $stage2 == "null"){
			$color_array = array('#f5cf60');
			}
		else if($stage == 21 and $stage2 == "null"){
			$color_array = array('#57509a','#a1cf87');
			}
		else if($stage == 19 and $stage2 == 20){
			$color_array = array('#1770a6', '#a1cf87');
			}
		else if	($stage == 19 and $stage2 == 21){
			$color_array = array('#a1cf87', '#43c0e8');
			}
		else if($stage == 20 and $stage2 == 21){
			$color_array = array('#1770a6', '#40b46d');
			}
		
		
	$color = 0;
	$gph = new graph();
	if ($type == 'pie') {
		$pie_color_array = array('#d9324d', '#f5cf60', '#40b46d', '#43c0e8', '#57509a');
		$gph -> pie(60,'#505050','{font-size: 12px; color: #404040;',false);
		$gph -> pie_values( $data_array[0], $label_array );
		$gph -> pie_slice_colours( $pie_color_array );
		$gph->bg_colour = '#FFFFFF';
	} else {
		$max = 0;
		foreach ($key_array as $k => $v) {
			$color = $k % 10;
			$gph -> set_data($data_array[$k]);
			switch ($type) {
				case 'bar':
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> bar( 100, $color_array[$color], $v, 10 );
					
				break;
				case 'area':
					$gph -> area_hollow( 2, 3, 25, $color_array[$color], $v, 10, $color_array[$color]);
				break;
				default:
					if($stage != "null" and $stage2 == "null"){
					if(($stage ==3 || $stage ==6) and $stage2 == "null"){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000' );
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
						}
					}
					else if(($stage ==9 || $stage ==12) and $stage2 == "null"){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000' );
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
						}
					}
					
					else if(($stage ==15 || $stage ==18) and $stage2 == "null"){
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000' );
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
						}
					}
					
					
					else{
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<1;$i++){
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 12, '#000000' );	
					$gph -> set_x_label_style(12, '#000000' );
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
							}
						}
					}
					
					else{
					
					
					$gph -> line_hollow( 3,6, $color_array[$color], $v, 10 );
					for($i=0;$i<$k;$i++){
					$gph -> set_data($level_array[0]);
					$gph -> set_tool_tip('#key#<br>#x_label#<br>數值:#val#');			
					$gph -> line_dot( 2, 0, '#147c83', 'x>95 (Very Good)', 10 );
					$gph -> set_data($level_array2[0]);
					$gph -> line_dot( 2, 0, '#e7864f', '95>x>=85 (Good)', 10 );
					$gph -> set_data($level_array3[0]);
					$gph -> line_dot( 2, 0, '#00BE02', '85>x>=75 (Ok)', 10 );
					$gph -> set_data($level_array4[0]);
					$gph -> line_dot( 2, 0, '#8000FA', '75>x>=70 (Not Good)', 10 );
					$gph -> set_data($level_array5[0]);
					$gph -> line_dot( 2, 0, '#0300FA', 'x<70 (Bad)', 10 );
					$gph ->set_x_legend( '訓練日期', 14, '#000000' );	
					$gph -> set_x_label_style(12, '#000000' );
					$gph ->x_axis_colour( '#727171', '#727171' );
					$gph ->y_axis_colour( '#727171', '#727171' );
					$gph->bg_colour = '#fffef0';
					$gph->set_x_offset='true';
					}
				}
				break;
			}
			rsort($data_array[$k], SORT_NUMERIC);
			$max = ($data_array[$k][0] > $max) ? $data_array[$k][0] : $max;
		}
		$gph -> set_x_labels( $label_array );
	}
	$gph -> title( $title, '{font-size: 14px; type:right}' );
	echo $gph->render();
}
}
}
function chart_str( $width, $height, $url ) { return _ofc( $width, $height, $url, false, '' ); }
?>
