<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_location.ecola_amt_month'][] = array(
	'field'   => 'users_location[ecola_amt_month]',
	'label'   => 'Ecola Per Month',
	'rules'   => 'V'
);
$config['field_validations']['users_location.ecola_amt'][] = array(
	'field'   => 'users_location[ecola_amt]',
	'label'   => 'Ecola Per Day',
	'rules'   => 'V'
);
$config['field_validations']['users_location.min_wage_amt'][] = array(
	'field'   => 'users_location[min_wage_amt]',
	'label'   => 'Minimum Wage',
	'rules'   => 'V'
);
$config['field_validations']['users_location.status_id'][] = array(
	'field'   => 'users_location[status_id]',
	'label'   => 'Active',
	'rules'   => 'V'
);
$config['field_validations']['users_location.location_code'][] = array(
	'field'   => 'users_location[location_code]',
	'label'   => 'Location Code',
	'rules'   => 'required'
);
$config['field_validations']['users_location.location'][] = array(
	'field'   => 'users_location[location]',
	'label'   => 'Location',
	'rules'   => 'required'
);
