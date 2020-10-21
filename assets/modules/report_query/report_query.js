function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "report_query";
	var route = "admin/report_query";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();