<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["edit_cached_query"] = 'SELECT `ww_taxcode`.`taxcode_id` as record_id, `ww_taxcode`.`created_on` as "taxcode.created_on", `ww_taxcode`.`created_by` as "taxcode.created_by", `ww_taxcode`.`modified_on` as "taxcode.modified_on", `ww_taxcode`.`modified_by` as "taxcode.modified_by", ww_taxcode.taxcode as "taxcode.taxcode", ww_taxcode.amount as "taxcode.amount", ww_taxcode.description as "taxcode.description"
FROM (`ww_taxcode`)
WHERE `ww_taxcode`.`taxcode_id` = "{$record_id}"';