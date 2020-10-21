<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$module = array(
	'mod_id' => 1,
	'mod_code' => 'dashboard',
	'route' => 'dashboard',
	'url' => base_url() . 'dashboard',
	'icon' => '',
	'primary_key' => '',
	'table' => '',
	'short_name' => 'Dashboard',
	'long_name' => 'Dashboard',
	'description' => 'Employee Dashboard',
	'path' => APPPATH . 'modules/dashboard/' 
);

if( file_exists(__DIR__ . '/dashboard_custom.php') )
	require __DIR__ . '/dashboard_custom.php';

$this->config->set_item('module', $module);