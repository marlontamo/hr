function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "safemanhour";
	var route = "partners/safe_manhour";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();