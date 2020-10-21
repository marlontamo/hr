<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Performance',
	'description' => '',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'performance_setup_performance.performance',
		'performance_setup_performance.performance_group',
		'performance_setup_performance.description',
		'performance_setup_performance.status_id',
		'performance_setup_performance.send_feeds',
		'performance_setup_performance.send_email',
		'performance_setup_performance.send_sms'
	)
);
