<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["photos_list_query"] = 'SELECT a.*, T1.*, T2.`upload_path`
FROM `ww_groups_post_upload` a
LEFT JOIN `ww_groups_post` T1 on T1.`post_id` = a.`post_id`
LEFT JOIN `ww_system_uploads` T2 on T2.`upload_id` = a.`upload_id`
WHERE T2.`upload_path` like "%{$search}%" AND T2.`upload_path` like "%jpg%"'; 
