<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['performance_setup_rating_score.rating_score'][] = array(
	'field'   => 'performance_setup_rating_score[rating_score]',
	'label'   => 'Rating Score',
	'rules'   => 'required'
);
$config['field_validations']['performance_setup_rating_score.rating_group_id'][] = array(
	'field'   => 'performance_setup_rating_score[rating_group_id]',
	'label'   => 'Rating Group',
	'rules'   => 'required'
);
