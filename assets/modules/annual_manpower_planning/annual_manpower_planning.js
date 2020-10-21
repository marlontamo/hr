function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "annual_manpower_planning";
	var route = "recruitment/annual_manpower_planning";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();