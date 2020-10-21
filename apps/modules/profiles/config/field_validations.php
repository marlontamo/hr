<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['profiles.profile'][] = array(
	'field'   => 'profiles[profile]',
	'label'   => 'Profile Name',
	'rules'   => 'required'
);
