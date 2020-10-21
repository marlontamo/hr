function Module(){
	var theme_path = base_url + "assets/";
	var mod_code = "sub_accounts_chart";
	var route = "payroll/sub_accounts_chart";
	this.get = function( to_get ){
		if( eval( to_get ) == undefined )
			return false;
		else
			return eval( to_get );
	};
}			
var module = new Module();