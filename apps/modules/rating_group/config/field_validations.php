<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_setup_rating_group.rating_group'][] = array(
	'field'   => 'performance_setup_rating_group[rating_group]',
	'label'   => 'Rating Group',
	'rules'   => 'required'
);
