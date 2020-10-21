<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_employment_status.employment_status'][] = array(
	'field'   => 'partners_employment_status[employment_status]',
	'label'   => 'Employment Status',
	'rules'   => 'required'
);
$config['field_validations']['partners_employment_status.active'][] = array(
	'field'   => 'partners_employment_status[active]',
	'label'   => 'Active',
	'rules'   => 'V'
);
