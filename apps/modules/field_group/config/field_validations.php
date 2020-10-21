<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['fieldgroups.sequence'][] = array(
	'field'   => 'fieldgroups[sequence]',
	'label'   => 'Sequence',
	'rules'   => 'required|integer'
);
$config['field_validations']['fieldgroups.display_id'][] = array(
	'field'   => 'fieldgroups[display_id]',
	'label'   => 'Display',
	'rules'   => 'required'
);
$config['field_validations']['fieldgroups.label'][] = array(
	'field'   => 'fieldgroups[label]',
	'label'   => 'Label',
	'rules'   => 'required'
);
