<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Downloadable Forms',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'resources_downloadable.title',
		'resources_downloadable.category',
		'resources_downloadable.description',
		'resources_downloadable.attachments'
	)
);
