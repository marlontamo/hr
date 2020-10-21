<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["post_list_query"] = 'Select a.*, gettimeline(a.created_on) as timeline, b.full_name, c.photo, d.position
FROM `ww_groups_post` a
LEFT JOIN `ww_users` b on b.user_id = a.created_by
LEFT JOIN `ww_users_profile` c on c.user_id = a.created_by
LEFT JOIN `ww_users_position` d on d.position_id = c.position_id
WHERE (
	b.full_name like "%{$search}%" OR 
	d.position like "%{$search}%"
)';