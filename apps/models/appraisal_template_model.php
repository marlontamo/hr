<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class appraisal_template_model extends Record
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
		$this->mod_id = 106;
		$this->mod_code = 'appraisal_template';
		$this->route = 'appraisal/templates';
		$this->url = site_url('appraisal/templates');
		$this->primary_key = 'template_id';
		$this->table = 'performance_template';
		$this->icon = 'fa-folder';
		$this->short_name = 'Appraisal Templates';
		$this->long_name  = 'Appraisal Templates';
		$this->description = '';
		$this->path = APPPATH . 'modules/appraisal_template/';

		parent::__construct();
	}

	function _get_applicable_options( $to_id, $to = "" )
	{
		switch( $to_id )
		{
			case 1: //employment type
				$value = "employment_type_id";
				$label = "employment_type";
				$table = $this->db->dbprefix."partners_employment_type";
				break;
			case 2: //employment status
				$value = "employment_status_id";
				$label = "employment_status";
				$table = $this->db->dbprefix."partners_employment_status";
				break;
			case 3: //position
				$value = "position_id";
				$label = "position";
				$table = $this->db->dbprefix."users_position";
				break;
			case 4: //employee
				$value = "user_id";
				$label = "alias";
				$table = "partners";
				break;
			case 5: //company
				$value = "company_id";
				$label = "company";
				$table = $this->db->dbprefix."users_company";
				break;
			case 6: //job class
				$value = "job_class_id";
				$label = "job_class";
				$table = $this->db->dbprefix."users_job_class";
				break;
		}

		$qry = "SELECT {$value} as value, {$label} as label FROM {$table} WHERE deleted = 0";
		if( !empty( $to ) )
		{
			$qry .= " AND {$value} in ({$to})";
		}
	
		$options = $this->db->query( $qry );
		$applicable_to_options = array();
        foreach($options->result() as $option){
        	$applicable_to_options[$option->value] = $option->label;
        }


        return $applicable_to_options;
	}

	function build_sections( $template_id )
	{
		$sections = array();

		//start from parents
		$this->db->order_by('sequence');
		$parents = $this->db->get_where('performance_template_section', array('parent_id' => 0, 'deleted' => 0, 'template_id' => $template_id));
		foreach( $parents->result() as $parent )
		{
			//check if has children
			$children = $this->_get_children( $parent->template_section_id );
			$parent->children = $children;
			$sections[] = $parent;
		}
		return $sections;
	}

	private function _get_children( $template_section_id )
	{
		$sections = array();
		$this->db->order_by('sequence');
		$children = $this->db->get_where('performance_template_section', array('parent_id' => $template_section_id, 'deleted' => 0));
		foreach( $children->result() as $child )
		{
			/*//check if has children
			$grandchild = $this->_get_children( $child->template_section_id );
			$child->children = $grandchild;*/
			$sections[] = $child;
		}

		return $sections;
	}

	function get_template( $record_id )
	{
		$this->db->limit(1);
		return $this->db->get_where($this->table, array($this->primary_key => $record_id))->row();
	}
}