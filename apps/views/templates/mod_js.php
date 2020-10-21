function Module(){
	var theme_path = base_url + "<?php echo $theme_path?>";
	var mod_code = "<?php echo $mod_code?>";
	var route = "<?php echo $route?>";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();