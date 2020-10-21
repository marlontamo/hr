<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT * FROM (`partner_contribution`) 
WHERE 
(
	`year` like "%{$search}%" OR 
	`month` like "%{$search}%" OR 
	`WTax` like "%{$search}%" 
)
';