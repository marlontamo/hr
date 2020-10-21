<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['time_record_summary.day_type'][] = array(
	'field'   => 'time_record_summary[day_type]',
	'label'   => 'Day Type',
	'rules'   => 'required'
);
$config['field_validations']['time_record_summary.ot'][] = array(
	'field'   => 'time_record_summary[ot]',
	'label'   => 'Overtime',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.undertime'][] = array(
	'field'   => 'time_record_summary[undertime]',
	'label'   => 'Undertime',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.late'][] = array(
	'field'   => 'time_record_summary[late]',
	'label'   => 'Lates',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.lwop'][] = array(
	'field'   => 'time_record_summary[lwop]',
	'label'   => 'Unpaid Leaves',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.lwp'][] = array(
	'field'   => 'time_record_summary[lwp]',
	'label'   => 'Paid Leaves',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.hrs_actual'][] = array(
	'field'   => 'time_record_summary[hrs_actual]',
	'label'   => 'Hours Worked',
	'rules'   => 'numeric'
);
$config['field_validations']['time_record_summary.payroll_date'][] = array(
	'field'   => 'time_record_summary[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
$config['field_validations']['time_record_summary.date'][] = array(
	'field'   => 'time_record_summary[date]',
	'label'   => 'Date',
	'rules'   => 'required'
);
$config['field_validations']['time_record_summary.user_id'][] = array(
	'field'   => 'time_record_summary[user_id]',
	'label'   => 'Employee',
	'rules'   => 'required'
);
