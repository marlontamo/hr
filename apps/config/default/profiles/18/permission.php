<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$permission = array();
$permission['dashboard']['list'] = 1;
$permission['dashboard']['generate'] = 1;
$permission['work_calendar']['list'] = 1;
$permission['work_calendar']['detail'] = 1;
$permission['work_calendar']['add'] = 1;
$permission['work_calendar']['edit'] = 1;
$permission['work_calendar']['delete'] = 1;
$permission['timerecord_manage']['list'] = 1;
$permission['timerecord_manage']['detail'] = 1;
$permission['timerecord_manage']['add'] = 1;
$permission['timerecord_manage']['edit'] = 1;

$config['permission'] = $permission;