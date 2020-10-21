<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Menu Basic Info',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'menu.label',
		'menu.icon',
		'menu.parent_menu_item_id',
		'menu.menu_item_type_id',
		'menu.mod_id',
		'menu.method',
		'menu.uri',
		'menu.description'
	)
);
