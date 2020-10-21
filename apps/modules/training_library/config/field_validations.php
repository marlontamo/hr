<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['training_library.published_date'][] = array(
	'field'   => 'training_library[published_date]',
	'label'   => 'Published Date',
	'rules'   => 'required'
);
$config['field_validations']['training_library.author'][] = array(
	'field'   => 'training_library[author]',
	'label'   => 'Author',
	'rules'   => 'required'
);
$config['field_validations']['training_library.library'][] = array(
	'field'   => 'training_library[library]',
	'label'   => 'Training Course',
	'rules'   => 'required'
);
