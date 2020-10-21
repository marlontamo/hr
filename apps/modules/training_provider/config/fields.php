<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['training_provider.description'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => '',
	'table' => 'training_provider',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_provider.provider_code'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Code',
	'description' => '',
	'table' => 'training_provider',
	'column' => 'provider_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['training_provider.provider'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Provider',
	'description' => '',
	'table' => 'training_provider',
	'column' => 'provider',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
