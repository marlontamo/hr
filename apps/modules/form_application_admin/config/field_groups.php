<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
if(get_time_form_id('SL') != false){
	$config['fieldgroups'][get_time_form_id('SL')] = array(
		'fg_id' => get_time_form_id('SL'),
		'label' => 'Sick Leave Form',
		'description' => 'Sick Leave Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('VL') != false){
	$config['fieldgroups'][get_time_form_id('VL')] = array(
		'fg_id' => get_time_form_id('VL'),
		'label' => 'Annual Leave Form',
		'description' => 'Annual Leave Form',
		'display_id' => 4,
		'sequence' => 2,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('EL') != false){
	$config['fieldgroups'][get_time_form_id('EL')] = array(
		'fg_id' => get_time_form_id('EL'),
		'label' => 'Emergency Leave Form',
		'description' => 'Emergency Leave Form',
		'display_id' => 4,
		'sequence' => 3,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('LIP') != false){
	$config['fieldgroups'][get_time_form_id('LIP')] = array(
		'fg_id' => get_time_form_id('LIP'),
		'label' => 'Leave Incentive Program',
		'description' => 'Leave Incentive Program',
		'display_id' => 4,
		'sequence' => 2,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('SIL') != false){
	$config['fieldgroups'][get_time_form_id('SIL')] = array(
		'fg_id' => get_time_form_id('SIL'),
		'label' => 'Service Incentive Leave',
		'description' => 'Service Incentive Leave',
		'display_id' => 4,
		'sequence' => 2,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('HL') != false){
	$config['fieldgroups'][get_time_form_id('HL')] = array(
		'fg_id' => get_time_form_id('HL'),
		'label' => 'Home Leave',
		'description' => 'Home Leave',
		'sequence' => 2,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('FLV') != false){
	$config['fieldgroups'][get_time_form_id('FLV')] = array(
		'fg_id' => get_time_form_id('FLV'),
		'label' => 'Force Leave',
		'description' => 'Force Leave',
		'sequence' => 2,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('FL') != false){
	$config['fieldgroups'][get_time_form_id('FL')] = array(
		'fg_id' => get_time_form_id('FL'),
		'label' => 'Bereavement Leave Form',
		'description' => 'Bereavement Leave Form',
		'display_id' => 4,
		'sequence' => 4,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('ML') != false){
	$config['fieldgroups'][get_time_form_id('ML')] = array(
		'fg_id' => get_time_form_id('ML'),
		'label' => 'Maternity Leave Form',
		'description' => 'Maternity Leave Form',
		'display_id' => 4,
		'sequence' => 5,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms_maternity.delivery_id',
			'time_forms_maternity.pregnancy_no',
			'time_forms_maternity.expected_date',
			'time_forms_maternity.actual_date',
			'time_forms_maternity.return_date',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('PL') != false){
	$config['fieldgroups'][get_time_form_id('PL')] = array(
		'fg_id' => get_time_form_id('PL'),
		'label' => 'Paternity Leave Form',
		'description' => 'Paternity Leave Form',
		'display_id' => 4,
		'sequence' => 5,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms_maternity.actual_date',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('LWOP') != false){
	$config['fieldgroups'][get_time_form_id('LWOP')] = array(
		'fg_id' => get_time_form_id('LWOP'),
		'label' => 'Leave Without Pay Form',
		'description' => 'Leave Without Pay Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('BL') != false){
	$config['fieldgroups'][get_time_form_id('BL')] = array(
		'fg_id' => get_time_form_id('BL'),
		'label' => 'Birthday Leave Form',
		'description' => 'Birthday Leave Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('SLW') != false){
	$config['fieldgroups'][get_time_form_id('SLW')] = array(
		'fg_id' => get_time_form_id('SLW'),
		'label' => 'Special Leave for Women Form',
		'description' => 'Special Leave for Women Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('OBT') != false){
	$config['fieldgroups'][get_time_form_id('OBT')] = array(
		'fg_id' => get_time_form_id('OBT'),
		'label' => 'Business Trip Form',
		'description' => 'Business Trip Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms_obt.location',
			'time_forms_obt.company_to_visit',
			'time_forms_obt.name',
			'time_forms_obt.position',
			'time_forms_obt.contact_no',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('OT') != false){
	$config['fieldgroups'][get_time_form_id('OT')] = array(
		'fg_id' => get_time_form_id('OT'),
		'label' => 'Overtime Form',
		'description' => 'Overtime Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.focus_date',			
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('UT') != false){
	$config['fieldgroups'][get_time_form_id('UT')] = array(
		'fg_id' => get_time_form_id('UT'),
		'label' => 'Undertime Form',
		'description' => 'Undertime Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.focus_date',			
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('DTRP') != false){
	$config['fieldgroups'][get_time_form_id('DTRP')] = array(
		'fg_id' => get_time_form_id('DTRP'),
		'label' => 'Manual Attendance Form',
		'description' => 'Manual Attendance Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.focus_date',
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('CWS') != false){
	$config['fieldgroups'][get_time_form_id('CWS')] = array(
		'fg_id' => get_time_form_id('CWS'),
		'label' => 'Replacement Schedule Form',
		'description' => 'Replacement Schedule Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms_date.shift_id',
			'time_forms_date.shift_to',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('ET') != false){
	$config['fieldgroups'][get_time_form_id('ET')] = array(
		'fg_id' => 10,
		'label' => 'Excused Tardiness Form',
		'description' => 'Excused Tardiness Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('SPL') != false){
	$config['fieldgroups'][get_time_form_id('SPL')] = array(
		'fg_id' => get_time_form_id('SPL'),
		'label' => 'Solo Parent Leave Form',
		'description' => 'Solo Parent Leave Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('VVL') != false){
	$config['fieldgroups'][get_time_form_id('VVL')] = array(
		'fg_id' => get_time_form_id('VVL'),
		'label' => 'Victim of Violence Leave Form',
		'description' => 'Victim of Violence Leave Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('EML') != false){
	$config['fieldgroups'][get_time_form_id('EML')] = array(
		'fg_id' => get_time_form_id('EML'),
		'label' => "Employee’s Marriage Leave Form",
		'description' => "Employee’s Marriage Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('MEC') != false){
	$config['fieldgroups'][get_time_form_id('MEC')] = array(
		'fg_id' => get_time_form_id('MEC'),
		'label' => "Marriage of Child Leave Form",
		'description' => "Marriage of Child Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('ECC') != false){
	$config['fieldgroups'][get_time_form_id('ECC')] = array(
		'fg_id' => get_time_form_id('ECC'),
		'label' => "Childs Circumcision Leave Form",
		'description' => "Childs Circumcision Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('ECB') != false){
	$config['fieldgroups'][get_time_form_id('ECB')] = array(
		'fg_id' => get_time_form_id('ECB'),
		'label' => "Childs Baptism Leave Form",
		'description' => "Childs Baptism Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('RBL') != false){
	$config['fieldgroups'][get_time_form_id('RBL')] = array(
		'fg_id' => get_time_form_id('RBL'),
		'label' => "Relatives Bereavement Leave Form",
		'description' => "Relatives Bereavement Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('MeL') != false){
	$config['fieldgroups'][get_time_form_id('MeL')] = array(
		'fg_id' => get_time_form_id('MeL'),
		'label' => "Pilgrimage Leave Form",
		'description' => "Pilgrimage Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('OT') != false){
	$config['fieldgroups'][24] = array(
		'fg_id' => 24,
		'label' => "Menstruation Leave Form",
		'description' => "Menstruation Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('FBL') != false){
	$config['fieldgroups'][get_time_form_id('FBL')] = array(
		'fg_id' => get_time_form_id('FBL'),
		'label' => "Family Bereavement Leave Form",
		'description' => "Family Bereavement Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('PUL') != false){
	$config['fieldgroups'][get_time_form_id('PUL')] = array(
		'fg_id' => get_time_form_id('PUL'),
		'label' => "Public Leave Form",
		'description' => "Public Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}
if(get_time_form_id('ADDL') != false){
	$config['fieldgroups'][get_time_form_id('ADDL')] = array(
		'fg_id' => get_time_form_id('ADDL'),
		'label' => "Additional Leave Form",
		'description' => "Additional Leave Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);  
}
if(get_time_form_id('RES') != false){
	$config['fieldgroups'][get_time_form_id('RES')] = array(
		'fg_id' => get_time_form_id('RES'),
		'label' => "Replacement Schedule Form",
		'description' => "Replacement Schedule Form",
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);  
}
if(get_time_form_id('EXL') != false){
	$config['fieldgroups'][get_time_form_id('EXL')] = array(
		'fg_id' => get_time_form_id('EXL'),
		'label' => 'Exceptional Leave Form',
		'description' => 'Exceptional Leave Form',
		'display_id' => 4,
		'sequence' => 3,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('MS') != false){
	$config['fieldgroups'][get_time_form_id('MS')] = array(
		'fg_id' => get_time_form_id('MS'),
		'label' => 'Mandatory Saturday Form',
		'description' => 'Mandatory Saturday Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('RL') != false){
	$config['fieldgroups'][get_time_form_id('RL')] = array(
		'fg_id' => get_time_form_id('RL'),
		'label' => 'Reserve Leave Form',
		'description' => 'Reserve Leave Form',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}

if(get_time_form_id('DTRU') != false){
	$config['fieldgroups'][get_time_form_id('DTRU')] = array(
		'fg_id' => get_time_form_id('DTRU'),
		'label' => 'Daily Time Record Updating',
		'description' => 'Daily Time Record Updating',
		'display_id' => 4,
		'sequence' => 1,
		'active' => 1,
		'fields' => array(
			'time_forms.date_from',
			'time_forms.date_to',
			'time_forms.reason',
			'time_forms_upload.upload_id',
			'time_forms.form_status_id'
		)
	);
}