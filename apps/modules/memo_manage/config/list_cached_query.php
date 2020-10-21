<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_memo`.`memo_id` as record_id, ww_memo.attachment as "memo_attachment", ww_memo.memo_body as "memo_memo_body", T1.memo_type as "memo_memo_type_id", T2.apply_to as "memo_apply_to_id", ww_memo.memo_title as "memo_memo_title", DATE_FORMAT(ww_memo.publish_from, \'%M %d, %Y\') as "memo_publish_from", DATE_FORMAT(ww_memo.publish_to, \'%M %d, %Y\') as "memo_publish_to", IF(ww_memo.publish = 1, "Yes", "No") as "memo_publish", IF(ww_memo.comments = 1, "Yes", "No") as "memo_comments", `ww_memo`.`created_on` as "memo_created_on", `ww_memo`.`created_by` as "memo_created_by", `ww_memo`.`modified_on` as "memo_modified_on", `ww_memo`.`modified_by` as "memo_modified_by"
FROM (`ww_memo`)
LEFT JOIN `ww_memo_type` T1 ON `T1`.`memo_type_id` = `ww_memo`.`memo_type_id`
LEFT JOIN `ww_memo_apply_to` T2 ON `T2`.`apply_to_id` = `ww_memo`.`apply_to_id`
WHERE (
	ww_memo.attachment like "%{$search}%" OR 
	ww_memo.memo_body like "%{$search}%" OR 
	T1.memo_type like "%{$search}%" OR 
	T2.apply_to like "%{$search}%" OR 
	ww_memo.memo_title like "%{$search}%" OR 
	DATE_FORMAT(ww_memo.publish_from, \'%M %d, %Y\') like "%{$search}%" OR 
	DATE_FORMAT(ww_memo.publish_to, \'%M %d, %Y\') like "%{$search}%" OR 
	IF(ww_memo.publish = 1, "Yes", "No") like "%{$search}%" OR 
	IF(ww_memo.comments = 1, "Yes", "No") like "%{$search}%"
)';