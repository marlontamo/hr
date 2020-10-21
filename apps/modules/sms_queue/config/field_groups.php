<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'SMS',
	'description' => 'Outgoing SMS',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'system_sms_queue.timein',
		'system_sms_queue.to',
		'system_sms_queue.cc',
		'system_sms_queue.bcc',
		'system_sms_queue.subject',
		'system_sms_queue.body',
		'system_sms_queue.status',
		'system_sms_queue.sent_on'
	)
);
