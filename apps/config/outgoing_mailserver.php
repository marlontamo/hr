<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['outgoing_mailserver'] = array();
$config['outgoing_mailserver']['protocol'] = "smtp";
$config['outgoing_mailserver']['smtp_host'] = "ssl://smtp.gmail.com";
$config['outgoing_mailserver']['smtp_user'] = "noreply@email.com";
$config['outgoing_mailserver']['smtp_pass'] = "password";
$config['outgoing_mailserver']['smtp_port'] = 465;
$config['outgoing_mailserver']['from_address'] = "noreply@email.com";
$config['outgoing_mailserver']['from_name'] = "Emplopad";
$config['outgoing_mailserver']['encryption'] = "should you choose encryption ";
$config['outgoing_mailserver']['mailtype'] = 'html';
