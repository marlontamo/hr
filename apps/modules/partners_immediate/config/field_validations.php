<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['users_profile.department_id'][] = array(
	'field'   => 'users_profile[department_id]',
	'label'   => 'Department',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.group_id'][] = array(
	'field'   => 'users_profile[group_id]',
	'label'   => 'Group',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.division_id'][] = array(
	'field'   => 'users_profile[division_id]',
	'label'   => 'Division',
	'rules'   => 'V'
);
$config['field_validations']['users_department.immediate_id'][] = array(
	'field'   => 'users_department[immediate_id]',
	'label'   => 'Reports To',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.birth_date'][] = array(
	'field'   => 'users_profile[birth_date]',
	'label'   => 'Birthday',
	'rules'   => 'V'
);
$config['field_validations']['partners.effectivity_date'][] = array(
	'field'   => 'partners[effectivity_date]',
	'label'   => 'Date Hired',
	'rules'   => 'V'
);
$config['field_validations']['partners.status_id'][] = array(
	'field'   => 'partners[status_id]',
	'label'   => 'Employee Status',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.location_id'][] = array(
	'field'   => 'users_profile[location_id]',
	'label'   => 'Location',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.company'][] = array(
	'field'   => 'users_profile[company]',
	'label'   => 'Company',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.position_id'][] = array(
	'field'   => 'users_profile[position_id]',
	'label'   => 'Position Title',
	'rules'   => 'V'
);
$config['field_validations']['partners.shift_id'][] = array(
	'field'   => 'partners[shift_id]',
	'label'   => 'Work Schedule',
	'rules'   => 'V'
);
$config['field_validations']['users.role_id'][] = array(
	'field'   => 'users[role_id]',
	'label'   => 'Role',
	'rules'   => 'required'
);
$config['field_validations']['partners.biometric'][] = array(
	'field'   => 'partners[biometric]',
	'label'   => 'Biometric Number',
	'rules'   => 'V'
);
$config['field_validations']['partners.id_number'][] = array(
	'field'   => 'partners[id_number]',
	'label'   => 'ID Number',
	'rules'   => 'V'
);
$config['field_validations']['users.email'][] = array(
	'field'   => 'users[email]',
	'label'   => 'Email Address',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.nickname'][] = array(
	'field'   => 'users_profile[nickname]',
	'label'   => 'Nick Name',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.maidenname'][] = array(
	'field'   => 'users_profile[maidenname]',
	'label'   => 'Maiden Name',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.middlename'][] = array(
	'field'   => 'users_profile[middlename]',
	'label'   => 'Middle Name',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.firstname'][] = array(
	'field'   => 'users_profile[firstname]',
	'label'   => 'First Name',
	'rules'   => 'V'
);
$config['field_validations']['users_profile.lastname'][] = array(
	'field'   => 'users_profile[lastname]',
	'label'   => 'Last Name',
	'rules'   => 'V'
);
