<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['fieldgroups'] = array();
$config['fieldgroups'][1] = array(
	'fg_id' => 1,
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
$config['fieldgroups'][2] = array(
	'fg_id' => 2,
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
$config['fieldgroups'][3] = array(
	'fg_id' => 3,
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
$config['fieldgroups'][4] = array(
	'fg_id' => 4,
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
$config['fieldgroups'][5] = array(
	'fg_id' => 5,
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
$config['fieldgroups'][6] = array(
	'fg_id' => 6,
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
$config['fieldgroups'][7] = array(
	'fg_id' => 7,
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
$config['fieldgroups'][13] = array(
	'fg_id' => 13,
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
$config['fieldgroups'][14] = array(
	'fg_id' => 14,
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
$config['fieldgroups'][8] = array(
	'fg_id' => 8,
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
$config['fieldgroups'][9] = array(
	'fg_id' => 9,
	'label' => 'Overtime Form',
	'description' => 'Overtime Form',
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
$config['fieldgroups'][10] = array(
	'fg_id' => 10,
	'label' => 'Undertime Form',
	'description' => 'Undertime Form',
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
$config['fieldgroups'][15] = array(
	'fg_id' => 15,
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
$config['fieldgroups'][11] = array(
	'fg_id' => 11,
	'label' => 'Daily Time Record Problem Form',
	'description' => 'Daily Time Record Problem Form',
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
$config['fieldgroups'][12] = array(
	'fg_id' => 12,
	'label' => 'Change Work Schedule Form',
	'description' => 'Change Work Schedule Form',
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
