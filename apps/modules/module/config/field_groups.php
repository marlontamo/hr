<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Basic Information',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'modules.short_name',
		'modules.long_name',
		'modules.description',
		'modules.disabled'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Module Configuration',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'modules.mod_code',
		'modules.route',
		'modules.table',
		'modules.primary_key',
		'modules.enable_mass_action',
		'modules.wizard_on_new',
		'modules.list_template_header',
		'modules.list_template',
		'modules.icon'
	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Field Groups',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(
		'modules.fg_id',
		'modules.f_id'
	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Fields',
	'description' => '',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(	)
);
