<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_play_badges`.`badge_id` as record_id, ww_play_badges.image_path as "play_badges_image_path", ww_play_badges.description as "play_badges_description", ww_play_badges.points as "play_badges_points", ww_play_badges.badge as "play_badges_badge", ww_play_badges.badge_code as "play_badges_badge_code", `ww_play_badges`.`created_on` as "play_badges_created_on", `ww_play_badges`.`created_by` as "play_badges_created_by", `ww_play_badges`.`modified_on` as "play_badges_modified_on", `ww_play_badges`.`modified_by` as "play_badges_modified_by"
FROM (`ww_play_badges`)
WHERE (
	ww_play_badges.image_path like "%{$search}%" OR 
	ww_play_badges.description like "%{$search}%" OR 
	ww_play_badges.points like "%{$search}%" OR 
	ww_play_badges.badge like "%{$search}%" OR 
	ww_play_badges.badge_code like "%{$search}%"
)';