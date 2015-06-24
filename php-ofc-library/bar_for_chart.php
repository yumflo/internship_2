<?php
//include
include_once('php-ofc-library/open-flash-chart.php');
include_once('php-ofc-library/open_flash_chart_object.php');
//function
function chart($type = '', $title = '', $label_array = array(), $key_array = array(), $data_array = array()) {
	$color_array = array('#0066CC', '#639F45', '#9933CC', '#3334AD', '#D54C78', '#D54C78', '#5E83BF', '#C31812', '#424581', '#424581');
	$color = 0;
	$gph = new graph();
	if ($type == 'bar'){
		$max = 0;
		foreach ($key_array as $k => $v) {
			$color = $k % 10;
			$gph -> set_data($data_array[$k]);
			$gph -> bar_sketch(55,5,'#f7ad94','#666666',$key_array[0], 10);
			$gph -> bar_sketch(55,5,'#78f9f1','#666666',$key_array[1], 10);
			rsort($data_array[$k], SORT_NUMERIC);
			$max = ($data_array[$k][0] > $max) ? $data_array[$k][0] : $max;
			$gph->bg_colour = '#ffffff';
			$gph ->x_axis_colour( '#666666', '#666666' );
			$gph ->y_axis_colour( '#666666', '#666666' );
		}
		$gph -> set_x_labels( $label_array );
		$gph -> set_y_max(50);
		$gph ->	y_label_steps(5);
	}
	else{	
		$max = 0;
		$gph -> set_data($data_array[0]);
		$gph -> area_hollow(0, 0,35,'#f0774a',$key_array[0], 10);
		$gph -> set_data($data_array[1]);
		$gph -> Line_hollow(3,6,'#78f9f1',$key_array[1], 10);
		rsort($data_array[$k], SORT_NUMERIC);
		$max = ($data_array[$k][0] > $max) ? $data_array[$k][0] : $max;
		$gph->bg_colour = '#ffffff';
		$gph ->x_axis_colour( '#666666', '#666666' );
		$gph ->y_axis_colour( '#666666', '#666666' );
		$gph -> set_x_labels( $label_array );
		$gph -> set_y_max(100);
		$gph ->	y_label_steps(5);	
	}
	$gph -> title( $title, '{font-size: 14px;}' );
	echo $gph->render();
}
function chart_str( $width, $height, $url ) { return _ofc( $width, $height, $url, false, '' ); }
?>