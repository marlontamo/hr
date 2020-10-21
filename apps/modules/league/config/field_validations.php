<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['play_league.league'][] = array(
	'field'   => 'play_league[league]',
	'label'   => 'Name',
	'rules'   => 'required'
);
