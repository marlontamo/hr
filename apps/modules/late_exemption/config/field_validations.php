<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_late_exemption.lates_exemption'][] = array(
	'field'   => 'payroll_late_exemption[lates_exemption]',
	'label'   => 'Late Exemption',
	'rules'   => 'required'
);
$config['field_validations']['payroll_late_exemption.employment_type_id'][] = array(
	'field'   => 'payroll_late_exemption[employment_type_id]',
	'label'   => 'Employment Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_late_exemption.company_id'][] = array(
	'field'   => 'payroll_late_exemption[company_id]',
	'label'   => 'Company',
	'rules'   => 'V'
);
