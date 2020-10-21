<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['resources_downloadable.attachments'][] = array(
	'field'   => 'resources_downloadable[attachments]',
	'label'   => 'Attachments',
	'rules'   => 'required'
);
$config['field_validations']['resources_downloadable.title'][] = array(
	'field'   => 'resources_downloadable[title]',
	'label'   => 'Title',
	'rules'   => 'required'
);
