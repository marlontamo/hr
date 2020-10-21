<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['memo.apply_to_id'][] = array(
	'field'   => 'memo[apply_to_id]',
	'label'   => 'Recipient',
	'rules'   => 'required'
);
$config['field_validations']['memo.publish_from'][] = array(
	'field'   => 'memo[publish_from]',
	'label'   => 'Publish From',
	'rules'   => 'required'
);
$config['field_validations']['memo.publish_to'][] = array(
	'field'   => 'memo[publish_to]',
	'label'   => 'Publish To',
	'rules'   => 'required'
);