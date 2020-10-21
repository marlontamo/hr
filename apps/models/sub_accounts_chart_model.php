<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class sub_accounts_chart_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 236;
		$this->mod_code = 'sub_accounts_chart';
		$this->route = 'payroll/sub_accounts_chart';
		$this->url = site_url('payroll/sub_accounts_chart');
		$this->primary_key = 'account_sub_id';
		$this->table = 'payroll_account_sub';
		$this->icon = 'fa-copy';
		$this->short_name = 'Sub Accounts Chart';
		$this->long_name  = 'Sub Accounts Chart';
		$this->description = '';
		$this->path = APPPATH . 'modules/sub_accounts_chart/';

		parent::__construct();
	}

	function _get_applied_to_options( $record_id, $mark_selected = false, $category = "" )
	{
		if( $mark_selected )
		{
			$selected = array();
			$account_sub = $this->db->get_where('ww_payroll_account_sub', array('account_sub_id' => $record_id));
			foreach( $account_sub->result() as $row )
			{
				$selected = $row->category_val_id;
			}
		}

		if( !empty($record_id) )
		{
			$result = $this->_get( 'edit', $record_id );
			$record = $result->row_array();
			$category = $record['payroll_account_sub.category_id'];
		}

		$options = '';
		switch( $category )
		{
			case 1: // branch
				$qry = "SELECT branch as label, branch_id as value
				FROM {$this->db->dbprefix}users_branch
				WHERE deleted = 0
				ORDER BY branch asc";
				break;
			case 2: //department
				$qry = "SELECT department as label, department_id as value
				FROM {$this->db->dbprefix}users_department
				WHERE deleted = 0
				ORDER BY department asc";
				break;
			case 3: //division
				$qry = "SELECT division as label, division_id as value
				FROM {$this->db->dbprefix}users_division
				WHERE deleted = 0
				ORDER BY division asc";
				break;
			case 4: // group
				$qry = "SELECT `group` as label, group_id as value
				FROM {$this->db->dbprefix}users_group
				WHERE deleted = 0
				ORDER BY `group` asc";
				break;
			case 5: // position
				$qry = "SELECT position as label, position_id as value
				FROM {$this->db->dbprefix}users_position
				WHERE deleted = 0
				ORDER BY position asc";
				break;
			case 6: // section
				$qry = "SELECT section as label, section_id as value
				FROM {$this->db->dbprefix}users_section
				WHERE deleted = 0
				ORDER BY section asc";
				break;
		}

		$lists = $this->db->query( $qry );
		foreach( $lists->result() as $row )
		{
			if( $mark_selected && $row->value == $selected ){
				$options .= '<option value="'. $row->value .'" selected>'.$row->label.'</option>';
			}
			else{
				$options .= '<option value="'. $row->value .'">'.$row->label.'</option>';
			}	
		}
		return $options;
	}
}