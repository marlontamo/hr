<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_period.date_from'][] = array(
	'field'   => 'time_period[date_from]',
	'label'   => 'Coverage from',
	'rules'   => 'required'
);
$config['field_validations']['time_period.date_to'][] = array(
	'field'   => 'time_period[date_to]',
	'label'   => 'Coverage to',
	'rules'   => 'required'
);
$config['field_validations']['time_period.company_id'][] = array(
	'field'   => 'time_period[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['time_period.apply_to_id'][] = array(
	'field'   => 'time_period[apply_to_id]',
	'label'   => 'Apply To',
	'rules'   => 'required'
);
$config['field_validations']['time_period.cutoff'][] = array(
	'field'   => 'time_period[cutoff]',
	'label'   => 'Cut-Off Date',
	'rules'   => 'required'
);
