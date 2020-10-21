<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$permission = array();
$permission['payroll_employee']['list'] = 1;
$permission['payroll_employee']['detail'] = 1;
$permission['payroll_employee']['add'] = 1;
$permission['payroll_employee']['edit'] = 1;
$permission['payroll_employee']['delete'] = 1;

$config['permission'] = $permission;