<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_period.posting_date'][] = array(
	'field'   => 'payroll_period[posting_date]',
	'label'   => 'Posting Date',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.week'][] = array(
	'field'   => 'payroll_period[week]',
	'label'   => 'Week',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.payroll_schedule_id'][] = array(
	'field'   => 'payroll_period[payroll_schedule_id]',
	'label'   => 'Payroll Schedule',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.period_processing_type_id'][] = array(
	'field'   => 'payroll_period[period_processing_type_id]',
	'label'   => 'Processing',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.apply_to_id'][] = array(
	'field'   => 'payroll_period[apply_to_id]',
	'label'   => 'Apply To',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.period_status_id'][] = array(
	'field'   => 'payroll_period[period_status_id]',
	'label'   => 'Status',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.date_from'][] = array(
	'field'   => 'payroll_period[date_from]',
	'label'   => 'Period from',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.date_to'][] = array(
	'field'   => 'payroll_period[date_to]',
	'label'   => 'Period to',
	'rules'   => 'required'
);
$config['field_validations']['payroll_period.payroll_date'][] = array(
	'field'   => 'payroll_period[payroll_date]',
	'label'   => 'Payroll Date',
	'rules'   => 'required'
);
