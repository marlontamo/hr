function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "habitual_tardiness_configuration";
	var route = "admin/time/habitual_tardiness_configuration";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();