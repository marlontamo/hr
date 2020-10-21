<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['system_sms_queue.sent_on'] = array(
	'f_id' => 8,
	'fg_id' => 1,
	'label' => 'Sent On',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'sent_on',
	'uitype_id' => 16,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 8,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.status'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'Status',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'status',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.body'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Body',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'body',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.subject'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Subject',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'subject',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.bcc'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Bcc',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'bcc',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.cc'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Cc',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'cc',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.to'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'To',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'to',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['system_sms_queue.timein'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Time In',
	'description' => '',
	'table' => 'system_sms_queue',
	'column' => 'timein',
	'uitype_id' => 16,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);