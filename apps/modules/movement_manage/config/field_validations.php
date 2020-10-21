<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['partners_movement_action_moving.reason_id'][] = array(
	'field'   => 'partners_movement_action_moving[reason_id]',
	'label'   => 'Reason',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_moving.end_date'][] = array(
	'field'   => 'partners_movement_action_moving[end_date]',
	'label'   => 'End Date',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_extension.end_date'][] = array(
	'field'   => 'partners_movement_action_extension[end_date]',
	'label'   => 'End Date',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_extension.no_of_months'][] = array(
	'field'   => 'partners_movement_action_extension[no_of_months]',
	'label'   => 'Months',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action.effectivity_date'][] = array(
	'field'   => 'partners_movement_action[effectivity_date]',
	'label'   => 'Effective',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_transfer.to_id'][] = array(
	'field'   => 'partners_movement_action_transfer[to_id]',
	'label'   => 'To id',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_transfer.from_id'][] = array(
	'field'   => 'partners_movement_action_transfer[from_id]',
	'label'   => 'From id',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_transfer.field_id'][] = array(
	'field'   => 'partners_movement_action_transfer[field_id]',
	'label'   => 'Field id',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action.type_id'][] = array(
	'field'   => 'partners_movement_action[type_id]',
	'label'   => 'Type',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement.due_to_id'][] = array(
	'field'   => 'partners_movement[due_to_id]',
	'label'   => 'Due To',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement.remarks_print_report_id'][] = array(
	'field'   => 'partners_movement[remarks_print_report_id]',
	'label'   => 'Remarks',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action.user_id'][] = array(
	'field'   => 'partners_movement_action[user_id]',
	'label'   => 'Partner',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_compensation.to_salary'][] = array(
	'field'   => 'partners_movement_action_compensation[to_salary]',
	'label'   => 'New Salary',
	'rules'   => 'required'
);
$config['field_validations']['partners_movement_action_compensation.current_salary'][] = array(
	'field'   => 'partners_movement_action_compensation[current_salary]',
	'label'   => 'Current Salary',
	'rules'   => 'required'
);
