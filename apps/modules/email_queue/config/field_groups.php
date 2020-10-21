<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Email',
	'description' => 'Outgoing Email',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'system_email_queue.timein',
		'system_email_queue.to',
		'system_email_queue.cc',
		'system_email_queue.bcc',
		'system_email_queue.subject',
		'system_email_queue.body',
		'system_email_queue.status',
		'system_email_queue.sent_on'
	)
);
