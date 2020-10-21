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
$config['fieldgroups'][11] = array(
	'fg_id' => 11,
	'label' => 'Manual Attendance Form',
	'description' => 'Manual Attendance Form',
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
$config['fieldgroups'][15] = array(
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

$config['fieldgroups'][16] = array(
	'fg_id' => 16,
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

$config['fieldgroups'][17] = array(
	'fg_id' => 17,
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

$config['fieldgroups'][18] = array(
	'fg_id' => 18,
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

$config['fieldgroups'][19] = array(
	'fg_id' => 19,
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

$config['fieldgroups'][20] = array(
	'fg_id' => 20,
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

$config['fieldgroups'][21] = array(
	'fg_id' => 21,
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

$config['fieldgroups'][22] = array(
	'fg_id' => 22,
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

$config['fieldgroups'][23] = array(
	'fg_id' => 23,
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

$config['fieldgroups'][25] = array(
	'fg_id' => 25,
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

$config['fieldgroups'][26] = array(
	'fg_id' => 26,
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
$config['fieldgroups'][27] = array(
	'fg_id' => 27,
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
