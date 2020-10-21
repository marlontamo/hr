<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['recruitment_manpower_plan.department_id'][] = array(
	'field'   => 'recruitment_manpower_plan[department_id]',
	'label'   => 'Department',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_manpower_plan.company_id'][] = array(
	'field'   => 'recruitment_manpower_plan[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_manpower_plan.year'][] = array(
	'field'   => 'recruitment_manpower_plan[year]',
	'label'   => 'Year',
	'rules'   => 'required|numeric'
);
