<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Employee Movement',
	'description' => 'Employee Movement',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'partners_movement_action.user_id',
		'partners_movement.due_to_id',
		'partners_movement_action.type_id',
		'partners_movement_action.type_category_id',
		'partners_movement.remarks'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Nature of Movement',
	'description' => 'Nature of Movement',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'partners_movement_action.effectivity_date',
		'partners_movement_action.remarks',
		'partners_movement_action.grade'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Extension Movement',
	'description' => 'Movement Details',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'partners_movement_action_extension.no_of_months',
		'partners_movement_action_extension.end_date'
	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Compensation Adjustment',
	'description' => 'Compensation Adjustment',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(
		'partners_movement_action_compensation.current_salary',
		'partners_movement_action_compensation.to_salary'
	)
);
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
	'label' => 'End Service Movement',
	'description' => 'End Service Movement',
	'display_id' => 3,
	'sequence' => 5,
	'active' => 1,
	'fields' => array(
		'partners_movement_action_moving.end_date',
		'partners_movement_action_moving.blacklisted',
		'partners_movement_action_moving.reason_id',
		'partners_movement_action_moving.further_reason'
	)
);
$config['fieldgroups'][6] = array(
	'fg_id' => 6,
	'label' => 'Transfer Movement',
	'description' => 'Transfer Movement',
	'display_id' => 3,
	'sequence' => 6,
	'active' => 1,
	'fields' => array(
		'partners_movement_action_transfer.field_id',
		'partners_movement_action_transfer.from_id',
		'partners_movement_action_transfer.to_id'
	)
);
