<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Level 2 and 3 Training Evaluation Master',
	'description' => 'Level 2 and 3 Training Evaluation Master',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
			'training_revalida_master.revalida_type',
			'training_revalida_master.course_id'
		)
);
