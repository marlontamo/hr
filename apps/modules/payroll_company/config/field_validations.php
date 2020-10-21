<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_company.company_code'][] = array(
	'field'   => 'users_company[company_code]',
	'label'   => 'Company Code',
	'rules'   => 'required'
);
$config['field_validations']['users_company.company'][] = array(
	'field'   => 'users_company[company]',
	'label'   => 'Company Name',
	'rules'   => 'required'
);
$config['field_validations']['users_company.bank_id'][] = array(
	'field'   => 'users_company[bank_id]',
	'label'   => 'Bank',
	'rules'   => 'required'
);
$config['field_validations']['users_company.sss'][] = array(
	'field'   => 'users_company[sss]',
	'label'   => 'SSS No.',
	'rules'   => 'required'
);
$config['field_validations']['users_company.hdmf'][] = array(
	'field'   => 'users_company[hdmf]',
	'label'   => 'Pag-ibig No.',
	'rules'   => 'required'
);
$config['field_validations']['users_company.phic'][] = array(
	'field'   => 'users_company[phic]',
	'label'   => 'Philhealth No.',
	'rules'   => 'required'
);
$config['field_validations']['users_company.tin'][] = array(
	'field'   => 'users_company[tin]',
	'label'   => 'TIN',
	'rules'   => 'required'
);
