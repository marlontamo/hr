<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_setup_notification.notification'][] = array(
	'field'   => 'performance_setup_notification[notification]',
	'label'   => 'Notification',
	'rules'   => 'required'
);
