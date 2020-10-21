$('#<?php echo $table?>-<?php echo $column?>-temp').change(function(){
	if( $(this).is(':checked') )
		$('#<?php echo $table?>-<?php echo $column?>').val('1');
	else
		$('#<?php echo $table?>-<?php echo $column?>').val('0');
});