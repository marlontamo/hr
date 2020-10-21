<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT ww_partners_clearance.*, 
										`ww_partners_clearance`.`clearance_id` as record_id, 
										`ww_partners_clearance`.`created_on` as "partner_clearance_created_on", 
										`ww_partners_clearance`.`created_by` as "partner_clearance_created_by", 
										`ww_partners_clearance`.`modified_on` as "partner_clearance_modified_on", 
										`ww_partners_clearance`.`modified_by` as "partner_clearance_modified_by", 
										`ww_partners_clearance_status`.`status` as clearance_status,
										`ww_partners`.`alias` as "display_name",
										`ww_users_position`.`position` as "position",
										`ww_partners`.`user_id` as "user_id",
										`ww_partners_clearance`.`action_id` as "action_id"
								FROM (`ww_partners_clearance`) 
								INNER JOIN ww_partners_clearance_status ON `ww_partners_clearance`.`status_id` = `ww_partners_clearance_status`.`status_id` 
								INNER JOIN ww_partners ON `ww_partners_clearance`.`partner_id` = `ww_partners`.`partner_id` 
								INNER JOIN ww_users_profile ON `ww_partners`.`partner_id` = `ww_users_profile`.`partner_id` 
								INNER JOIN ww_users_position ON `ww_users_position`.`position_id` = `ww_users_profile`.`position_id` 
								WHERE (	`ww_partners_clearance_status`.`status` like "%{$search}%" OR 
											ww_users_position.position like "%{$search}%" OR 
											ww_partners.alias like "%{$search}%"
											 )';