<?php
	foreach($columns as $column)
	{
		$col[] = $column->alias;
	}

	echo implode(',', $col) . "\r\n";

	$result = $result->result();
	foreach( $result as $row ){
		$line = array();
		foreach($columns as $column){
			$alias = $column->alias;
			if($column->format_id == 1)
				$line[] = '"' .$row->$alias . '"';
			else
				$line[] = $row->$alias;
		}
		echo implode(',', $line) . "\r\n";	
	}
?>