<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_company.zipcode'][] = array(
	'field'   => 'users_company[zipcode]',
	'label'   => 'Zipcode',
	'rules'   => 'required'
);
$config['field_validations']['users_company.country_id'][] = array(
	'field'   => 'users_company[country_id]',
	'label'   => 'Country',
	'rules'   => 'required'
);
$config['field_validations']['users_company.city_id'][] = array(
	'field'   => 'users_company[city_id]',
	'label'   => 'City',
	'rules'   => 'required'
);
$config['field_validations']['users_company.address'][] = array(
	'field'   => 'users_company[address]',
	'label'   => 'Address',
	'rules'   => 'required'
);
$config['field_validations']['users_company.company_code'][] = array(
	'field'   => 'users_company[company_code]',
	'label'   => 'Company Code',
	'rules'   => 'required'
);
$config['field_validations']['users_company.company'][] = array(
	'field'   => 'users_company[company]',
	'label'   => 'Company',
	'rules'   => 'required'
);
