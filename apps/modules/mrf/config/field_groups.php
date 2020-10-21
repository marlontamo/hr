<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => ' Personnel Requisition Form',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'recruitment_request.company_id',
        'recruitment_request.document_no',
		'recruitment_request.department_id',
		'recruitment_request.position_id',
		'recruitment_request.replacement_of',
		'recruitment_request.user_id',
		'recruitment_request.created_on',
		'recruitment_request.date_needed',
		'recruitment_request.hiring_type',
		'recruitment_request.description',
		'recruitment_request.quantity',
		'recruitment_request.nature_id',
		'recruitment_request.budgeted',
		'recruitment_request.job_class_id',
		'recruitment_request.employment_status_id',
		'recruitment_request.contract_duration',
		'recruitment_request.attachment',
		'recruitment_request.delivery_date',
		'recruitment_request.hr_remarks',
        /*'recruitment_request.hr_assigned',*/
		'recruitment_request.salary_from',
		'recruitment_request.salary_to',
		'recruitment_request.budget_from',
		'recruitment_request.budget_to'
	)
);
