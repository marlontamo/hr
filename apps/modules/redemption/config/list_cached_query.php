<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_play_redeemable`.`item_id` as record_id, ww_play_redeemable.image_path as "play_redeemable_image_path", ww_play_redeemable.description as "play_redeemable_description", ww_play_redeemable.points as "play_redeemable_points", ww_play_redeemable.item as "play_redeemable_item", `ww_play_redeemable`.`created_on` as "play_redeemable_created_on", `ww_play_redeemable`.`created_by` as "play_redeemable_created_by", `ww_play_redeemable`.`modified_on` as "play_redeemable_modified_on", `ww_play_redeemable`.`modified_by` as "play_redeemable_modified_by"
FROM (`ww_play_redeemable`)
WHERE (
	ww_play_redeemable.image_path like "%{$search}%" OR 
	ww_play_redeemable.description like "%{$search}%" OR 
	ww_play_redeemable.points like "%{$search}%" OR 
	ww_play_redeemable.item like "%{$search}%"
)';