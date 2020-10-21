<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT * FROM `time_forms_admin`
		INNER JOIN ww_time_forms_obt_transpo obt_transpo 
		ON time_forms_admin.forms_id = obt_transpo.forms_id';