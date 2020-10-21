<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['recruitment_benefit_package.description'][] = array(
	'field'   => 'recruitment_benefit_package[description]',
	'label'   => 'Description',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_benefit_package.rank_id'][] = array(
	'field'   => 'recruitment_benefit_package[rank_id]',
	'label'   => 'Rank/Type',
	'rules'   => 'required'
);
$config['field_validations']['recruitment_benefit_package.benefit'][] = array(
	'field'   => 'recruitment_benefit_package[benefit]',
	'label'   => 'Benefit Package Name',
	'rules'   => 'required'
);
