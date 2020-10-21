<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['resources_policies.attachments'][] = array(
	'field'   => 'resources_policies[attachments]',
	'label'   => 'Attachments',
	'rules'   => 'required'
);
$config['field_validations']['resources_policies.title'][] = array(
	'field'   => 'resources_policies[title]',
	'label'   => 'Title',
	'rules'   => 'required'
);
