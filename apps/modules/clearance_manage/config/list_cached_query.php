<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT ww_partners_clearance.*, 
								`ww_partners_clearance`.`clearance_id` as record_id, 
								`ww_partners_clearance`.`created_on` as "partner_clearance_created_on", 
								`ww_partners_clearance`.`created_by` as "partner_clearance_created_by", 
								`ww_partners_clearance`.`modified_on` as "partner_clearance_modified_on", 
								`ww_partners_clearance`.`modified_by` as "partner_clearance_modified_by", 
								`ww_partners`.`alias` as "display_name",
								`ww_users_position`.`position` as "position",
								IF(ww_partners_clearance.turn_around_time="0000-00-00", null, DATE_FORMAT(ww_partners_clearance.turn_around_time,"%M %d, %Y")) as turn_around_time,
								IF(ww_partners_clearance.effectivity_date="0000-00-00", null, DATE_FORMAT(ww_partners_clearance.effectivity_date,"%M %d, %Y")) as effectivity_date,								
								IF(ww_partners_clearance.date_cleared="0000-00-00", null, DATE_FORMAT(ww_partners_clearance.date_cleared,"%M %d, %Y")) as date_cleared,								
								ww_partners_clearance_status.status as clearance_status, 
								ww_partners_clearance_signatories.status_id as clearance_status_id
								FROM (`ww_partners_clearance`) 
								INNER JOIN ww_partners ON `ww_partners_clearance`.`partner_id` = `ww_partners`.`partner_id` 
								INNER JOIN ww_users_profile ON `ww_partners`.`partner_id` = `ww_users_profile`.`partner_id` 
								INNER JOIN ww_users_position ON `ww_users_position`.`position_id` = `ww_users_profile`.`position_id` 
								INNER JOIN ww_partners_clearance_signatories ON ww_partners_clearance.clearance_id = ww_partners_clearance_signatories.clearance_id 
								INNER JOIN ww_partners_clearance_status ON ww_partners_clearance_signatories.status_id = ww_partners_clearance_status.status_id 								
								AND ww_partners_clearance_signatories.user_id = {$user_id} 
								WHERE ( ww_partners_clearance_status.status like "%{$search}%" OR 
										ww_users_position.position like "%{$search}%" OR 
										ww_partners.alias like "%{$search}%" )';