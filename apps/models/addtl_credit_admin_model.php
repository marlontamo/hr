<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class addtl_credit_admin_model extends Record
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
		$this->mod_id = 187;
		$this->mod_code = 'addtl_credit_admin';
		$this->route = 'time/addtl_credit_admin';
		$this->url = site_url('time/addtl_credit_admin');
		$this->primary_key = 'forms_id';
		$this->table = 'time_forms';
		$this->icon = '';
		$this->short_name = 'Additional Leave Admin - Credit';
		$this->long_name  = 'Additional Leave Admin - Credit';
		$this->description = '';
		$this->path = APPPATH . 'modules/addtl_credit_admin/';

		parent::__construct();
	}

		
	function _get_list($start, $limit, $search, $filter, $trash = false)
	{
		$data = array();				
		
		$qry = "SELECT tfotl.*, tf.*, tfs.form_status, 
				tform.form, tf.forms_id as record_id,
				IF( tfotl.used_by_form = 0, tfotl.credit, 
				(tfotl.credit - tfotl.used )) as balance
				FROM {$this->db->dbprefix}time_forms_ot_leave tfotl 
				INNER JOIN {$this->db->dbprefix}time_forms tf 
				ON tfotl.forms_id = tf.forms_id 
				INNER JOIN {$this->db->dbprefix}time_form_status tfs 
				ON tf.form_status_id = tfs.form_status_id
				INNER JOIN {$this->db->dbprefix}time_form tform 
				ON tform.form_id = tf.form_id
				WHERE tf.form_status_id = 6 AND tf.type = 'File' "; //approved only

		if( $trash )
		{
			$qry .= " AND tf.deleted = 1";
		}
		else{
			$qry .= " AND tf.deleted = 0";	
		}
		
		$qry .= ' '. $filter;
		$qry .= " LIMIT $limit OFFSET $start";

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($qry, array('search' => $search), TRUE);
		// echo "<pre>$qry";
		$result = $this->db->query( $qry );
		if($result->num_rows() > 0)
		{			
			foreach($result->result_array() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}

	public function _get( $view, $record_id )
	{
		switch( $view )
		{
			case 'detail':
				$cached_query = "SELECT tf.forms_id AS record_id, tf.created_on,
				tf.date_sent, tf.date_from, tf.date_to, tf.reason, tf.form_id, 
				tf.scheduled, tf.form_status_id, tform.form, tform.form_code,
				tf.user_id
				 FROM {$this->db->dbprefix}time_forms tf 
				 LEFT JOIN {$this->db->dbprefix}time_form tform
				 ON tf.form_id = tform.form_id
				 WHERE tf.forms_id = '{$record_id}' ";
				break;
			case 'edit':
				$cached_query = "SELECT tfol.*, tf.date_from, tf.reason, 
				IF( tfol.used_by_form = 0, tfol.credit, 
				(tfol.credit - tfol.used )) as balance
				 FROM {$this->db->dbprefix}time_forms_ot_leave tfol 
				 LEFT JOIN {$this->db->dbprefix}time_forms tf 
				 ON tf.forms_id = tfol.forms_id
				 WHERE tfol.forms_id = '{$record_id}' ";
				break;
			case 'quick_edit':
		}

		$this->load->library('parser');
		$this->parser->set_delimiters('{$', '}');
		$qry = $this->parser->parse_string($cached_query, array('record_id' => $record_id), TRUE);

		return $this->db->query( $qry );
	}

	function getApprovers($record_id){ 
		
		$data = array();

		$qry = "SELECT * FROM {$this->db->dbprefix}time_forms_approver 
				WHERE forms_id={$record_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}

	function getSelectedDates($record_id){
		
		$data = array();

		$qry = "SELECT tfd.date, td.duration_id, td.duration
				FROM {$this->db->dbprefix}time_forms_date tfd
				LEFT JOIN {$this->db->dbprefix}time_duration td 
				ON tfd.duration_id = td.duration_id 
				WHERE tfd.forms_id={$record_id}"; // WHERE user_id = '$userID';
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				$data[] = $row;
			}			
		}
			
		$result->free_result();
		return $data;	
	}
}