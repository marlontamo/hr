<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['requisition.approver'][] = array(
	'field'   => 'requisition[approver]',
	'label'   => 'Approval From',
	'rules'   => 'required'
);
$config['field_validations']['requisition.project_name'][] = array(
	'field'   => 'requisition[project_name]',
	'label'   => 'Project Name',
	'rules'   => 'required'
);
$config['field_validations']['requisition.priority_id'][] = array(
	'field'   => 'requisition[priority_id]',
	'label'   => 'Priority',
	'rules'   => 'required'
);
