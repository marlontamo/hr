<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['groups.group_name'][] = array(
	'field'   => 'groups[group_name]',
	'label'   => 'Group Name',
	'rules'   => 'required'
);
