<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['field_validations'] = array();
$config['field_validations']['payroll_partners.total_year_days'][] = array(
	'field'   => 'payroll_partners[total_year_days]',
	'label'   => 'Total Year Days',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_partners.payroll_rate_type_id'][] = array(
	'field'   => 'payroll_partners[payroll_rate_type_id]',
	'label'   => 'Rate Type',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.payroll_schedule_id'][] = array(
	'field'   => 'payroll_partners[payroll_schedule_id]',
	'label'   => 'Payroll Schedule',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.salary'][] = array(
	'field'   => 'payroll_partners[salary]',
	'label'   => 'Rate',
	'rules'   => 'required|numeric'
);
$config['field_validations']['payroll_partners.company_id'][] = array(
	'field'   => 'payroll_partners[company_id]',
	'label'   => 'Company',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.taxcode_id'][] = array(
	'field'   => 'payroll_partners[taxcode_id]',
	'label'   => 'Tax Code',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.bank_id'][] = array(
	'field'   => 'payroll_partners[bank_id]',
	'label'   => 'Bank Name',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.minimum_takehome'][] = array(
	'field'   => 'payroll_partners[minimum_takehome]',
	'label'   => 'Minimum Takehome',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners.sensitivity'][] = array(
	'field'   => 'payroll_partners[sensitivity]',
	'label'   => 'Sensitivity',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.sss_no'][] = array(
	'field'   => 'payroll_partners[sss_no]',
	'label'   => 'SSS No.',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.sss_mode'][] = array(
	'field'   => 'payroll_partners[sss_mode]',
	'label'   => 'SSS Transaction Mode',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.sss_amount'][] = array(
	'field'   => 'payroll_partners[sss_amount]',
	'label'   => 'Amount',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners.sss_week'][] = array(
	'field'   => 'payroll_partners[sss_week]',
	'label'   => 'Week',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.hdmf_no'][] = array(
	'field'   => 'payroll_partners[hdmf_no]',
	'label'   => 'PagIbig No.',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.hdmf_mode'][] = array(
	'field'   => 'payroll_partners[hdmf_mode]',
	'label'   => 'HDMF Transaction Mode',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.hdmf_amount'][] = array(
	'field'   => 'payroll_partners[hdmf_amount]',
	'label'   => 'Amount',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners.hdmf_week'][] = array(
	'field'   => 'payroll_partners[hdmf_week]',
	'label'   => 'Week',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.phic_no'][] = array(
	'field'   => 'payroll_partners[phic_no]',
	'label'   => 'PhilHealth No.',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.phic_mode'][] = array(
	'field'   => 'payroll_partners[phic_mode]',
	'label'   => 'PHIC Transaction Mode',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.phic_amount'][] = array(
	'field'   => 'payroll_partners[phic_amount]',
	'label'   => 'Amount',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners.phic_week'][] = array(
	'field'   => 'payroll_partners[phic_week]',
	'label'   => 'Week',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.tin'][] = array(
	'field'   => 'payroll_partners[tin]',
	'label'   => 'TIN',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.tax_mode'][] = array(
	'field'   => 'payroll_partners[tax_mode]',
	'label'   => 'WHTAX Transaction Mode',
	'rules'   => 'required'
);
$config['field_validations']['payroll_partners.tax_amount'][] = array(
	'field'   => 'payroll_partners[tax_amount]',
	'label'   => 'Amount',
	'rules'   => 'numeric'
);
$config['field_validations']['payroll_partners.tax_week'][] = array(
	'field'   => 'payroll_partners[tax_week]',
	'label'   => 'Week',
	'rules'   => 'required'
);
