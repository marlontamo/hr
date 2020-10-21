<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Template ',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_template.template',
		'performance_template.template_code',
		'performance_template.applicable_to_id',
		'performance_template.applicable_to',
		'performance_template.set_crowdsource_by',
		'performance_template.description',
		'performance_template.max_crowdsource'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Section',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
