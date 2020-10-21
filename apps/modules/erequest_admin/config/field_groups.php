<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
	'label' => 'Online Request',
	'description' => 'Online Request',
	'display_id' => 3,
	'sequence' => 1,
	'active' => 1,
	'fields' => array(
		'resources_request.request',
		'resources_request.date_needed',
		'resources_request.reason',
		'resources_request_upload.upload_id',
		'resources_request.user_id',
		'resources_request.request_status_id',
		'resources_request.status',
		'resources_request.remarks',
		'resources_request_upload_hr.upload_id',
		'resources_request.notify_immediate',
		'resources_request.notify_others'
	)
);
