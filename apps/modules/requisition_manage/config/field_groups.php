<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Purchase Request',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'requisition.project_name',
		'requisition.priority_id',
		'requisition.approver'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Item Request',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
