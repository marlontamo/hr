<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$permission = array();
$permission['form_application_admin']['list'] = 1;
$permission['form_application_admin']['detail'] = 1;
$permission['form_application_admin']['add'] = 1;
$permission['form_application_admin']['edit'] = 1;

$config['permission'] = $permission;