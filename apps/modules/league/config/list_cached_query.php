<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_play_league`.`league_id` as record_id, ww_play_league.description as "play_league_description", ww_play_league.league as "play_league_league", ww_play_league.league_code as "play_league_league_code", `ww_play_league`.`created_on` as "play_league_created_on", `ww_play_league`.`created_by` as "play_league_created_by", `ww_play_league`.`modified_on` as "play_league_modified_on", `ww_play_league`.`modified_by` as "play_league_modified_by"
FROM (`ww_play_league`)
WHERE (
	ww_play_league.description like "%{$search}%" OR 
	ww_play_league.league like "%{$search}%" OR 
	ww_play_league.league_code like "%{$search}%"
)';