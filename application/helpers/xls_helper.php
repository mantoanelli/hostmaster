<?php
if(!function_exists('array_to_xls')) {
	
	function array_to_xls($array, $download = '') {
		
		if($download != '') {
			header('Content-type: application/x-msexcel');
			header('Content-Disposition: attachment; filename="'.$download.'"');
		}
		
		ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;
		
		fwrite($f, "<table border=1>");
		foreach($array as $line) {
			$n++;
			fwrite($f, "<tr>");
			
			foreach($line as $col) {
				fwrite($f, "<td>$col</td>");
			}
			
			fwrite($f, "</tr>");
		}
		fwrite($f, "</table>");
		
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();
		
		if ($download == "") {
			return $str;
		} else {
			echo $str;
		}
	}
	
}