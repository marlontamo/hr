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
		'report_generator.report_code',
		'report_generator.report_name',
		'report_generator.description',
		'report_generator.category_id',
		'report_generator.roles'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Tables',
	'description' => '',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
	'label' => 'Fields and Columns',
	'description' => '',
	'display_id' => 3,
	'sequence' => 3,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
	'label' => 'Fixed Filters',
	'description' => '',
	'display_id' => 3,
	'sequence' => 4,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
	'label' => 'Editable Filters',
	'description' => '',
	'display_id' => 3,
	'sequence' => 5,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][6] = array(
	'fg_id' => 6,
	'label' => 'Grouping',
	'description' => '',
	'display_id' => 3,
	'sequence' => 6,
	'active' => 1,
	'fields' => array(	)
);
$config['fieldgroups'][7] = array(
	'fg_id' => 7,
	'label' => 'Sorting',
	'description' => '',
	'display_id' => 3,
	'sequence' => 7,
	'active' => 1,
	'fields' => array(	)
);
