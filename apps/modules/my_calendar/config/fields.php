<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fields'] = array();

if(get_time_form_id('SL') != false){
	$config['fields'][get_time_form_id('SL')]['time_forms.date_from'] = array(
		'f_id' => 1,
		'fg_id' => get_time_form_id('SL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SL')]['time_forms.date_to'] = array(
		'f_id' => 2,
		'fg_id' => get_time_form_id('SL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SL')]['time_forms.reason'] = array(
		'f_id' => 3,
		'fg_id' => get_time_form_id('SL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 4,
		'fg_id' => get_time_form_id('SL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('VL') != false){
	$config['fields'][get_time_form_id('VL')]['time_forms.date_from'] = array(
		'f_id' => 5,
		'fg_id' => get_time_form_id('VL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VL')]['time_forms.date_to'] = array(
		'f_id' => 6,
		'fg_id' => get_time_form_id('VL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VL')]['time_forms.reason'] = array(
		'f_id' => 7,
		'fg_id' => get_time_form_id('VL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 8,
		'fg_id' => get_time_form_id('VL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('EL') != false){
	$config['fields'][get_time_form_id('EL')]['time_forms.date_from'] = array(
		'f_id' => 9,
		'fg_id' => get_time_form_id('EL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EL')]['time_forms.date_to'] = array(
		'f_id' => 10,
		'fg_id' => get_time_form_id('EL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EL')]['time_forms.reason'] = array(
		'f_id' => 11,
		'fg_id' => get_time_form_id('EL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 12,
		'fg_id' => get_time_form_id('EL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('HL') != false){
	$config['fields'][get_time_form_id('HL')]['time_forms.date_from'] = array(
		'f_id' => 9,
		'fg_id' => get_time_form_id('HL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('HL')]['time_forms.date_to'] = array(
		'f_id' => 10,
		'fg_id' => get_time_form_id('HL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('HL')]['time_forms.reason'] = array(
		'f_id' => 11,
		'fg_id' => get_time_form_id('HL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('HL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 12,
		'fg_id' => get_time_form_id('HL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('LIP') != false){
	$config['fields'][get_time_form_id('LIP')]['time_forms.date_from'] = array(
		'f_id' => 9,
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LIP')]['time_forms.date_to'] = array(
		'f_id' => 10,
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LIP')]['time_forms.reason'] = array(
		'f_id' => 11,
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LIP')]['time_forms_upload.upload_id'] = array(
		'f_id' => 12,
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('FLV') != false){
	$config['fields'][get_time_form_id('FLV')]['time_forms.date_from'] = array(
		'f_id' => 9,
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FLV')]['time_forms.date_to'] = array(
		'f_id' => 10,
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FLV')]['time_forms.reason'] = array(
		'f_id' => 11,
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FLV')]['time_forms_upload.upload_id'] = array(
		'f_id' => 12,
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('FL') != false){
	$config['fields'][get_time_form_id('FL')]['time_forms.date_from'] = array(
		'f_id' => 13,
		'fg_id' => get_time_form_id('FL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FL')]['time_forms.date_to'] = array(
		'f_id' => 14,
		'fg_id' => get_time_form_id('FL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FL')]['time_forms.reason'] = array(
		'f_id' => 15,
		'fg_id' => get_time_form_id('FL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 16,
		'fg_id' => get_time_form_id('FL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('ML') != false){
	$config['fields'][get_time_form_id('ML')]['time_forms.date_from'] = array(
		'f_id' => 17,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms.date_to'] = array(
		'f_id' => 18,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms.reason'] = array(
		'f_id' => 19,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_upload.upload_id'] = array(
		'f_id' => 20,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_maternity.delivery_id'] = array(
		'f_id' => 21,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Delivery',
		'description' => 'Delivery',
		'table' => 'time_forms_maternity',
		'column' => 'delivery_id',
		'uitype_id' => 4,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_maternity.pregnancy_no'] = array(
		'f_id' => 22,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'No. of Pregnancy',
		'description' => 'No. of Pregnancy',
		'table' => 'time_forms_maternity',
		'column' => 'pregnancy_no',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_maternity.expected_date'] = array(
		'f_id' => 23,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Expected Delivery',
		'description' => 'Expected Delivery',
		'table' => 'time_forms_maternity',
		'column' => 'expected_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_maternity.actual_date'] = array(
		'f_id' => 24,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Actual Delivery',
		'description' => 'Actual Delivery',
		'table' => 'time_forms_maternity',
		'column' => 'actual_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ML')]['time_forms_maternity.return_date'] = array(
		'f_id' => 25,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Report Date',
		'description' => 'Report Date',
		'table' => 'time_forms_maternity',
		'column' => 'return_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('PL') != false){
	$config['fields'][get_time_form_id('PL')]['time_forms.date_from'] = array(
		'f_id' => 26,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PL')]['time_forms.date_to'] = array(
		'f_id' => 27,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PL')]['time_forms.reason'] = array(
		'f_id' => 28,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 29,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PL')]['time_forms_maternity.delivery_id'] = array(
		'f_id' => 21,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'Delivery',
		'description' => 'Delivery',
		'table' => 'time_forms_maternity',
		'column' => 'delivery_id',
		'uitype_id' => 4,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);	
	$config['fields'][get_time_form_id('PL')]['time_forms_maternity.actual_date'] = array(
		'f_id' => 30,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'Actual Delivery',
		'description' => 'Actual Delivery',
		'table' => 'time_forms_maternity',
		'column' => 'actual_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('LWOP') != false){
	$config['fields'][get_time_form_id('LWOP')]['time_forms.date_from'] = array(
		'f_id' => 31,
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LWOP')]['time_forms.date_to'] = array(
		'f_id' => 32,
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LWOP')]['time_forms.reason'] = array(
		'f_id' => 33,
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('LWOP')]['time_forms_upload.upload_id'] = array(
		'f_id' => 34,
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('BL') != false){
	$config['fields'][get_time_form_id('BL')]['time_forms.date_from'] = array(
		'f_id' => 35,
		'fg_id' => get_time_form_id('BL'),
		'label' => 'Date',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('BL')]['time_forms.date_to'] = array(
		'f_id' => 36,
		'fg_id' => get_time_form_id('BL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('BL')]['time_forms.reason'] = array(
		'f_id' => 37,
		'fg_id' => get_time_form_id('BL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('BL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 38,
		'fg_id' => get_time_form_id('BL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('SLW') != false){
	$config['fields'][get_time_form_id('SLW')]['time_forms.date_from'] = array(
		'f_id' => 39,
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SLW')]['time_forms.date_to'] = array(
		'f_id' => 40,
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SLW')]['time_forms.reason'] = array(
		'f_id' => 41,
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SLW')]['time_forms_upload.upload_id'] = array(
		'f_id' => 42,
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('OBT') != false){
	$config['fields'][get_time_form_id('OBT')]['time_forms.date_from'] = array(
		'f_id' => 43,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms.date_to'] = array(
		'f_id' => 44,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms.reason'] = array(
		'f_id' => 45,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_upload.upload_id'] = array(
		'f_id' => 45,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_obt.location'] = array(
		'f_id' => 46,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Location',
		'description' => 'Location',
		'table' => 'time_forms_obt',
		'column' => 'location',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_obt.company_to_visit'] = array(
		'f_id' => 47,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Company Name',
		'description' => 'Company Name',
		'table' => 'time_forms_obt',
		'column' => 'company_to_visit',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_obt.name'] = array(
		'f_id' => 48,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Contact Person',
		'description' => 'Contact Person',
		'table' => 'time_forms_obt',
		'column' => 'name',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_obt.position'] = array(
		'f_id' => 49,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Position Title',
		'description' => 'Position Title',
		'table' => 'time_forms_obt',
		'column' => 'position',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OBT')]['time_forms_obt.contact_no'] = array(
		'f_id' => 50,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Contact Number',
		'description' => 'Contact Number',
		'table' => 'time_forms_obt',
		'column' => 'contact_no',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('OT') != false){
	$config['fields'][get_time_form_id('OT')]['time_forms.focus_date'] = array(
		'f_id' => 52,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'Focus Date',
		'description' => 'Focus Date',
		'table' => 'time_forms',
		'column' => 'focus_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);		
	$config['fields'][get_time_form_id('OT')]['time_forms.date_from'] = array(
		'f_id' => 51,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OT')]['time_forms.date_to'] = array(
		'f_id' => 52,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OT')]['time_forms.reason'] = array(
		'f_id' => 53,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('OT')]['time_forms_upload.upload_id'] = array(
		'f_id' => 54,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('UT') != false){
	$config['fields'][get_time_form_id('UT')]['time_forms.focus_date'] = array(
		'f_id' => 52,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Focus Date',
		'description' => 'Focus Date',
		'table' => 'time_forms',
		'column' => 'focus_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);		
	$config['fields'][get_time_form_id('UT')]['time_forms.date_from'] = array(
		'f_id' => 55,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Date',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('UT')]['time_forms.date_to'] = array(
		'f_id' => 56,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Date',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('UT')]['time_forms.reason'] = array(
		'f_id' => 57,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('UT')]['time_forms_upload.upload_id'] = array(
		'f_id' => 58,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('DTRP') != false){
	$config['fields'][get_time_form_id('DTRP')]['time_forms.focus_date'] = array(
		'f_id' => 52,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'Focus Date',
		'description' => 'Focus Date',
		'table' => 'time_forms',
		'column' => 'focus_date',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);		
	$config['fields'][get_time_form_id('DTRP')]['time_forms.date_from'] = array(
		'f_id' => 59,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'In',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('DTRP')]['time_forms.date_to'] = array(
		'f_id' => 60,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'Out',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('DTRP')]['time_forms.reason'] = array(
		'f_id' => 61,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('DTRP')]['time_forms_upload.upload_id'] = array(
		'f_id' => 62,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}


if(get_time_form_id('CWS') != false){
	$config['fields'][get_time_form_id('CWS')]['time_forms.date_from'] = array(
		'f_id' => 63,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Date',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('CWS')]['time_forms.date_to'] = array(
		'f_id' => 64,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Date',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('CWS')]['time_forms.reason'] = array(
		'f_id' => 65,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('CWS')]['time_forms_upload.upload_id'] = array(
		'f_id' => 66,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('CWS')]['time_forms_date.shift_id'] = array(
		'f_id' => 66,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Current Schedule',
		'description' => 'Current Schedule',
		'table' => 'time_forms_date',
		'column' => 'shift_id',
		'uitype_id' => 4,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('CWS')]['time_forms_date.shift_to'] = array(
		'f_id' => 66,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'New Schedule',
		'description' => 'New Schedule',
		'table' => 'time_forms_date',
		'column' => 'shift_to',
		'uitype_id' => 4,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('CWS') != false){
	$config['fields'][1]['time_forms.form_status_id'] = array(
		'f_id' => 67,
		'fg_id' => 1,
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('VL') != false){
	$config['fields'][get_time_form_id('VL')]['time_forms.form_status_id'] = array(
		'f_id' => 68,
		'fg_id' => get_time_form_id('VL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('EL') != false){
	$config['fields'][get_time_form_id('EL')]['time_forms.form_status_id'] = array(
		'f_id' => 69,
		'fg_id' => get_time_form_id('EL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('HL') != false){
	$config['fields'][get_time_form_id('HL')]['time_forms.form_status_id'] = array(
		'f_id' => 69,
		'fg_id' => get_time_form_id('HL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('LIP') != false){
	$config['fields'][get_time_form_id('LIP')]['time_forms.form_status_id'] = array(
		'f_id' => 69,
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('FLV') != false){
	$config['fields'][get_time_form_id('FLV')]['time_forms.form_status_id'] = array(
		'f_id' => 69,
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('FL') != false){
	$config['fields'][get_time_form_id('FL')]['time_forms.form_status_id'] = array(
		'f_id' => 70,
		'fg_id' => get_time_form_id('FL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('ML') != false){
	$config['fields'][get_time_form_id('ML')]['time_forms.form_status_id'] = array(
		'f_id' => 70,
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('PL') != false){
	$config['fields'][get_time_form_id('PL')]['time_forms.form_status_id'] = array(
		'f_id' => 71,
		'fg_id' => get_time_form_id('PL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('LWOP') != false){
	$config['fields'][get_time_form_id('LWOP')]['time_forms.form_status_id'] = array(
		'f_id' => 72,
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('OBT') != false){
	$config['fields'][get_time_form_id('OBT')]['time_forms.form_status_id'] = array(
		'f_id' => 73,
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('OT') != false){
	$config['fields'][get_time_form_id('OT')]['time_forms.form_status_id'] = array(
		'f_id' => 74,
		'fg_id' => get_time_form_id('OT'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('UT') != false){
	$config['fields'][get_time_form_id('UT')]['time_forms.form_status_id'] = array(
		'f_id' => 75,
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('DTRP') != false){
	$config['fields'][get_time_form_id('DTRP')]['time_forms.form_status_id'] = array(
		'f_id' => 76,
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('CWS') != false){
	$config['fields'][get_time_form_id('CWS')]['time_forms.form_status_id'] = array(
		'f_id' => 77,
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('BL') != false){
	$config['fields'][get_time_form_id('BL')]['time_forms.form_status_id'] = array(
		'f_id' => 78,
		'fg_id' => get_time_form_id('BL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('SLW') != false){
	$config['fields'][get_time_form_id('SLW')]['time_forms.form_status_id'] = array(
		'f_id' => 79,
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('ET') != false){
	$config['fields'][get_time_form_id('ET')]['time_forms.date_from'] = array(
		'f_id' => 80,
		'fg_id' => get_time_form_id('ET'),
		'label' => 'Date',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ET')]['time_forms.date_to'] = array(
		'f_id' => 81,
		'fg_id' => get_time_form_id('ET'),
		'label' => 'Date',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ET')]['time_forms.reason'] = array(
		'f_id' => 82,
		'fg_id' => get_time_form_id('ET'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ET')]['time_forms_upload.upload_id'] = array(
		'f_id' => 83,
		'fg_id' => get_time_form_id('ET'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);

	$config['fields'][get_time_form_id('ET')]['time_forms.form_status_id'] = array(
		'f_id' => 84,
		'fg_id' => get_time_form_id('ET'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('SPL') != false){
	$config['fields'][get_time_form_id('SPL')]['time_forms.date_from'] = array(
		'f_id' => 85,
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SPL')]['time_forms.date_to'] = array(
		'f_id' => 86,
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SPL')]['time_forms.reason'] = array(
		'f_id' => 87,
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SPL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 88,
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('SPL')]['time_forms.form_status_id'] = array(
		'f_id' => 89,
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('VVL') != false){
	$config['fields'][get_time_form_id('VVL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VVL')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VVL')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VVL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('VVL')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('EML') != false){
	$config['fields'][get_time_form_id('EML')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('EML'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EML')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('EML'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EML')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('EML'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EML')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('EML'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('EML')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('EML'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('MEC') != false){
	$config['fields'][get_time_form_id('MEC')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('MEC'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MEC')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('MEC'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MEC')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('MEC'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MEC')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('MEC'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MEC')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('MEC'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}


if(get_time_form_id('ECC') != false){
	$config['fields'][get_time_form_id('ECC')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('ECC'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECC')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('ECC'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECC')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('ECC'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECC')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('ECC'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECC')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('ECC'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}


if(get_time_form_id('ECB') != false){
	$config['fields'][get_time_form_id('ECB')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('ECB'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECB')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('ECB'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECB')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('ECB'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECB')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('ECB'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ECB')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('ECB'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('RBL') != false){
	$config['fields'][get_time_form_id('RBL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('RBL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RBL')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('RBL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RBL')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('RBL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RBL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('RBL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RBL')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('RBL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('PiL') != false){
	$config['fields'][get_time_form_id('PiL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('PiL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PiL')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('PiL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PiL')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('PiL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PiL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('PiL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('PiL')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('PiL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('MeL') != false){
	$config['fields'][get_time_form_id('MeL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('MeL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MeL')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('MeL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MeL')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('MeL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MeL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('MeL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('MeL')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('MeL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('FBL') != false){
	$config['fields'][get_time_form_id('FBL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('FBL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FBL')]['time_forms.date_to'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('FBL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FBL')]['time_forms.reason'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('FBL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FBL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('FBL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('FBL')]['time_forms.form_status_id'] = array(
		'f_id' => 94,
		'fg_id' => get_time_form_id('FBL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}

if(get_time_form_id('ADDL') != false){
	$config['fields'][get_time_form_id('ADDL')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('ADDL'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ADDL')]['time_forms.date_to'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('ADDL'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 16,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ADDL')]['time_forms.reason'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('ADDL'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ADDL')]['time_forms_upload.upload_id'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('ADDL'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('ADDL')]['time_forms.form_status_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('ADDL'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}


if(get_time_form_id('RES') != false){
	$config['fields'][get_time_form_id('RES')]['time_forms.date_from'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('RES'),
		'label' => 'From',
		'description' => 'Date From',
		'table' => 'time_forms',
		'column' => 'date_from',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RES')]['time_forms.date_to'] = array(
		'f_id' => 90,
		'fg_id' => get_time_form_id('RES'),
		'label' => 'To',
		'description' => 'Date To',
		'table' => 'time_forms',
		'column' => 'date_to',
		'uitype_id' => 6,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 3,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RES')]['time_forms.reason'] = array(
		'f_id' => 91,
		'fg_id' => get_time_form_id('RES'),
		'label' => 'Reason',
		'description' => 'Reason',
		'table' => 'time_forms',
		'column' => 'reason',
		'uitype_id' => 2,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 4,
		'datatype' => 'required',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RES')]['time_forms_upload.upload_id'] = array(
		'f_id' => 92,
		'fg_id' => get_time_form_id('RES'),
		'label' => 'File Upload',
		'description' => 'File Upload',
		'table' => 'time_forms_upload',
		'column' => 'upload_id',
		'uitype_id' => 9,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 5,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
	$config['fields'][get_time_form_id('RES')]['time_forms.form_status_id'] = array(
		'f_id' => 93,
		'fg_id' => get_time_form_id('RES'),
		'label' => 'Status',
		'description' => 'Form Status',
		'table' => 'time_forms',
		'column' => 'form_status_id',
		'uitype_id' => 1,
		'display_id' => 3,
		'quick_edit' => 1,
		'sequence' => 1,
		'datatype' => 'V',
		'active' => '1',
		'encrypt' => 0
	);
}