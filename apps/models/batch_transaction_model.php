<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class batch_transaction_model extends Record
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
		$this->mod_id = 65;
		$this->mod_code = 'batch_transaction';
		$this->route = 'payroll/batch_transactions';
		$this->url = site_url('payroll/batch_transactions');
		$this->primary_key = 'batch_entry_id';
		$this->table = 'payroll_entry_batch';
		$this->icon = 'fa-folder';
		$this->short_name = 'Batch Transactions';
		$this->long_name  = 'Batch Transactions';
		$this->description = '';
		$this->path = APPPATH . 'modules/batch_transaction/';

		parent::__construct();
	}

	function _get_group_lists( $group )
	{
		$lists = array();
		$items = array();
		switch( $group )
		{
			case 'company':
				$lists = $this->_get_companies();
				break;
			case 'department':
				$lists = $this->_get_departments();
				break;
			case 'branch':
				$lists = $this->_get_branch();
				break;				
			case 'position':
				$lists = $this->_get_positions();
				break;
			case 'employee_type':
				$lists = $this->_get_employee_types();
				break;
			case 'location':
				$lists = $this->_get_locations();
				break;
		}

		foreach( $lists as $item )
		{
			$items[] = '<a href="javascript:toggle_item( \''.$item['id'].'\' )" class="list-group-item small ">
			<span class="pull-left margin-right-10"><input type="checkbox" onclick="toggle_checkbox( \''.$item['id'].'\' )" class="checkboxes" name="group_id[]" value="'.$item['id'].'" /></span>
			<span class="text-info">'.$item['label'].'</span></a>';
		}

		return implode('', $items);
	}

	private function _get_companies()
	{
		$lists = array();
		$this->db->order_by('company', 'asc');
		$companies = $this->db->get_where('users_company', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->company_id,
				'label' => $row->company
			);
		}
		return $lists;
	}

	private function _get_divisions()
	{
		$lists = array();
		$this->db->order_by('division', 'asc');
		$companies = $this->db->get_where('users_division', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->division_id,
				'label' => $row->division
			);
		}
		return $lists;
	}

	private function _get_branch()
	{
		$lists = array();
		$this->db->order_by('branch', 'asc');
		$companies = $this->db->get_where('users_branch', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->branch_id,
				'label' => $row->branch
			);
		}
		return $lists;
	}
	
	private function _get_departments()
	{
		$lists = array();
		$this->db->order_by('department', 'asc');
		$companies = $this->db->get_where('users_department', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->department_id,
				'label' => $row->department
			);
		}
		return $lists;
	}

	private function _get_positions()
	{
		$lists = array();
		$this->db->order_by('position', 'asc');
		$companies = $this->db->get_where('users_position', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->position_id,
				'label' => $row->position
			);
		}
		return $lists;
	}

	private function _get_locations()
	{
		$lists = array();
		$this->db->order_by('location', 'asc');
		$companies = $this->db->get_where('users_location', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->location_id,
				'label' => $row->location
			);
		}
		return $lists;
	}

	private function _get_employee_types()
	{
		$lists = array();
		$this->db->order_by('employment_type', 'asc');
		$companies = $this->db->get_where('partners_employment_type', array('deleted' => '0'));
		foreach( $companies->result() as $row )
		{
			$lists[] = array(
				'id' => $row->employment_type_id,
				'label' => $row->employment_type
			);
		}
		return $lists;
	}
		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = $this->_get_list_cached_query();
		
		if( $trash )
		{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 1";
		}
		else{
			$qry .= " AND {$this->db->dbprefix}{$this->table}.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		$qry .= " ORDER BY {$this->db->dbprefix}{$this->table}.payroll_date DESC,
				{$this->db->dbprefix}{$this->table}.remarks,
				{$this->db->dbprefix}{$this->table}.created_on DESC,
				{$this->db->dbprefix}{$this->table}.remarks";
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);

		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

}