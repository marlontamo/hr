<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Late Exemption Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(	
		'payroll_late_exemption.company_id',
		'payroll_late_exemption.employment_type_id',
		'payroll_late_exemption.lates_exemption'
	)
);
