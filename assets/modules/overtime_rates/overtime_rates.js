function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "overtime_rates";
	var route = "admin/payroll/overtime_rates";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();