<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_play_badges`.`badge_id` as record_id, `ww_play_badges`.`created_on` as "play_badges.created_on", `ww_play_badges`.`created_by` as "play_badges.created_by", `ww_play_badges`.`modified_on` as "play_badges.modified_on", `ww_play_badges`.`modified_by` as "play_badges.modified_by", ww_play_badges.image_path as "play_badges.image_path", ww_play_badges.description as "play_badges.description", ww_play_badges.points as "play_badges.points", ww_play_badges.badge as "play_badges.badge", ww_play_badges.badge_code as "play_badges.badge_code"
FROM (`ww_play_badges`)
WHERE `ww_play_badges`.`badge_id` = "{$record_id}"';