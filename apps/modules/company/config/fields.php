<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();
$config['fields'][3]['users_company.logo'] = array(
	'f_id' => 8,
	'fg_id' => 3,
	'label' => 'Logo',
	'description' => '',
	'table' => 'users_company',
	'column' => 'logo',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][3]['users_company.print_logo'] = array(
	'f_id' => 8,
	'fg_id' => 3,
	'label' => 'Print Logo',
	'description' => '',
	'table' => 'users_company',
	'column' => 'print_logo',
	'uitype_id' => 8,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_company.zipcode'] = array(
	'f_id' => 6,
	'fg_id' => 1,
	'label' => 'Zipcode',
	'description' => '',
	'table' => 'users_company',
	'column' => 'zipcode',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 6,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_company.vat'] = array(
	'f_id' => 7,
	'fg_id' => 1,
	'label' => 'VAT Registration',
	'description' => '',
	'table' => 'users_company',
	'column' => 'vat',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 7,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_company.rdo'] = array(
	'f_id' => 8,
	'fg_id' => 1,
	'label' => 'RDO Code',
	'description' => '',
	'table' => 'users_company',
	'column' => 'rdo',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 9,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.sss'] = array(
	'f_id' => 9,
	'fg_id' => 1,
	'label' => 'SSS Number',
	'description' => '',
	'table' => 'users_company',
	'column' => 'sss',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 9,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.sss_branch_code'] = array(
	'f_id' => 9,
	'fg_id' => 1,
	'label' => 'SSS Branch Code',
	'description' => '',
	'table' => 'users_company',
	'column' => 'sss_branch_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 9,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.sss_branch_code_locator'] = array(
	'f_id' => 9,
	'fg_id' => 1,
	'label' => 'SSS Branch Code Locator',
	'description' => '',
	'table' => 'users_company',
	'column' => 'sss_branch_code_locator',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 9,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);


$config['fields'][1]['users_company.hdmf'] = array(
	'f_id' => 10,
	'fg_id' => 1,
	'label' => 'Pag-IBIG Number',
	'description' => '',
	'table' => 'users_company',
	'column' => 'hdmf',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 10,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.hdmf_branch_code'] = array(
	'f_id' => 10,
	'fg_id' => 1,
	'label' => 'Pag-IBIG Branch Code',
	'description' => '',
	'table' => 'users_company',
	'column' => 'hdmf_branch_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 10,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.phic'] = array(
	'f_id' => 11,
	'fg_id' => 1,
	'label' => 'PhilHealth Number',
	'description' => '',
	'table' => 'users_company',
	'column' => 'phic',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 11,
	'datatype' => '',
	'active' => '1',
	'encrypt' => 0
);

$config['fields'][1]['users_company.country_id'] = array(
	'f_id' => 5,
	'fg_id' => 1,
	'label' => 'Country',
	'description' => '',
	'table' => 'users_company',
	'column' => 'country_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 5,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => 1,
		'table' => 'countries',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'country',
		'value' => 'country_id',
		'textual_value_column' => 'country'
	)
);
$config['fields'][1]['users_company.city_id'] = array(
	'f_id' => 4,
	'fg_id' => 1,
	'label' => 'City',
	'description' => '',
	'table' => 'users_company',
	'column' => 'city_id',
	'uitype_id' => 4,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 4,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0,
	'searchable' => array(
		'type_id' => 1,
		'table' => 'cities',
		'multiple' => 0,
		'group_by' => '',
		'label' => 'city',
		'value' => 'city_id',
		'textual_value_column' => 'city'
	)
);
$config['fields'][1]['users_company.address'] = array(
	'f_id' => 3,
	'fg_id' => 1,
	'label' => 'Address',
	'description' => '',
	'table' => 'users_company',
	'column' => 'address',
	'uitype_id' => 2,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 3,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_company.company_code'] = array(
	'f_id' => 2,
	'fg_id' => 1,
	'label' => 'Company Code',
	'description' => '',
	'table' => 'users_company',
	'column' => 'company_code',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 2,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);
$config['fields'][1]['users_company.company'] = array(
	'f_id' => 1,
	'fg_id' => 1,
	'label' => 'Company',
	'description' => '',
	'table' => 'users_company',
	'column' => 'company',
	'uitype_id' => 1,
	'display_id' => 3,
	'quick_edit' => 1,
	'sequence' => 1,
	'datatype' => 'required',
	'active' => '1',
	'encrypt' => 0
);

