<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["members_list_query"] = 'SELECT a.*, T1.full_name, T2.photo, T3.position
FROM `ww_groups_members` a
LEFT JOIN `ww_users` T1 on T1.`user_id` = a.`user_id`
LEFT JOIN `ww_users_profile` T2 on T2.`user_id` = a.`user_id`
LEFT JOIN `ww_users_position` T3 on T3.`position_id` = T2.`position_id`
WHERE (
	T1.full_name like "%{$search}%" OR 
	T3.position like "%{$search}%"
) AND a.left_group=0';