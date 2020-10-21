<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Memo Information',
	'description' => 'Basic memorandum information',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'memo.memo_type_id',
		'memo.apply_to_id',
		'memo.memo_title',
		'memo.publish_from',
		'memo.publish_to',
		'memo.publish',
		'memo.comments',
		'memo.email'
	)
);
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
	'label' => 'Memorandum Detail',
	'description' => 'Enter memorandum details',
	'display_id' => 3,
	'sequence' => 2,
	'active' => 1,
	'fields' => array(
		'memo.memo_body',
		'memo.attachment'
	)
);
