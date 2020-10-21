<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['menu.label'][] = array(
	'field'   => 'menu[label]',
	'label'   => 'Label',
	'rules'   => 'required'
);
$config['field_validations']['menu.menu_item_type_id'][] = array(
	'field'   => 'menu[menu_item_type_id]',
	'label'   => 'Menu Type',
	'rules'   => 'required'
);
