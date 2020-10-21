<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][1]['recruitment_benefit_package.status_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'Is Active',
	'description' => 'Status',
	'table' => 'recruitment_benefit_package',
	'column' => 'status_id',
	'uitype_id' => 3,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['recruitment_benefit_package.description'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Description',
	'description' => 'Description',
	'table' => 'recruitment_benefit_package',
	'column' => 'description',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['recruitment_benefit_package.rank_id'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Rank/Type',
	'description' => 'Rank/Type',
	'table' => 'recruitment_benefit_package',
	'column' => 'rank_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => '1',
		'table' => 'partners_employment_type',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'employment_type',
		'value' => 'employment_type_id',
		'textual_value_column' => ''
	)
);
$config['fields'][1]['recruitment_benefit_package.benefit'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Benefit Package Name',
	'description' => 'Benefit Package Name',
	'table' => 'recruitment_benefit_package',
	'column' => 'benefit',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
