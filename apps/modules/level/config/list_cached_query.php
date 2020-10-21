<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_play_level`.`level_id` as record_id, ww_play_level.description as "play_level_description", ww_play_level.points_to as "play_level_points_to", ww_play_level.points_fr as "play_level_points_fr", T2.league as "play_level_league_id", ww_play_level.level as "play_level_level", `ww_play_level`.`created_on` as "play_level_created_on", `ww_play_level`.`created_by` as "play_level_created_by", `ww_play_level`.`modified_on` as "play_level_modified_on", `ww_play_level`.`modified_by` as "play_level_modified_by"
FROM (`ww_play_level`)
LEFT JOIN `ww_play_league` T2 ON `T2`.`league_id` = `ww_play_level`.`league_id`
WHERE (
	ww_play_level.description like "%{$search}%" OR 
	ww_play_level.points_to like "%{$search}%" OR 
	ww_play_level.points_fr like "%{$search}%" OR 
	T2.league like "%{$search}%" OR 
	ww_play_level.level like "%{$search}%"
)';