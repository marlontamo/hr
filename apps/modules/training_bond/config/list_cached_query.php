<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$config["list_cached_query"] = 'SELECT `ww_training_bond`.`bond_id` as record_id, ww_training_bond.rls_days as "training_bond_rls_days", ww_training_bond.rls_months as "training_bond_rls_months", ww_training_bond.cost_to as "training_bond_cost_to", ww_training_bond.cost_from as "training_bond_cost_from", `ww_training_bond`.`created_on` as "training_bond_created_on", `ww_training_bond`.`created_by` as "training_bond_created_by", `ww_training_bond`.`modified_on` as "training_bond_modified_on", `ww_training_bond`.`modified_by` as "training_bond_modified_by"
FROM (`ww_training_bond`)
WHERE (
	ww_training_bond.rls_days like "%{$search}%" OR 
	ww_training_bond.rls_months like "%{$search}%" OR 
	ww_training_bond.cost_to like "%{$search}%" OR 
	ww_training_bond.cost_from like "%{$search}%"
)';