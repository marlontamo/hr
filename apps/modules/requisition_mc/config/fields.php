<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['requisition.project_name'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Project Name',
	'description' => '',
	'table' => 'requisition',
	'column' => 'project_name',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['requisition.priority_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Priority',
	'description' => '',
	'table' => 'requisition',
	'column' => 'priority_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'requisition_priority',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'priority',
		'value' => 'priority_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['requisition.approver'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Approval From',
	'description' => '',
	'table' => 'requisition',
	'column' => 'approver',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'users',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'full_name',
		'value' => 'user_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['requisition.total_price'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Total Price',
	'description' => '',
	'table' => 'requisition',
	'column' => 'total_price',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'numeric',
	'active' => '1',
	'encrypt' => 0,
);
$config['fields'][1]['requisition.no_of_items'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'No. of Items',
	'description' => '',
	'table' => 'requisition',
	'column' => 'no_of_items',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'numeric',
	'active' => '1',
	'encrypt' => 0,
);