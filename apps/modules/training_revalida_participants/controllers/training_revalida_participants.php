<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_revalida_participants extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_revalida_participants_model', 'mod');
		parent::__construct();
	}

	public function feedback_list($calendar_id)
	{
		$calendar = array('calendar_id' => $calendar_id);
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		echo $this->load->blade('pages.listing', $calendar)->with( $this->load->get_cached_vars() );
	}

	public function get_list($calendar_id)
	{
		$this->_ajax_only();
		
		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response->show_import_button = false;
		if( $this->input->post('page') == 1 )
		{
			$this->load->model('upload_utility_model', 'import');
			if( $this->import->get_templates( $this->mod->mod_id ) )
				$this->response->show_import_button = true;
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;
		$records = $this->_get_list( $trash , $calendar_id );
		$this->_process_lists( $records, $trash );
		
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

		$this->_ajax_return();
	}

	private function _process_lists( $records, $trash )
	{
		$this->response->records_retrieve = sizeof($records);
		$this->response->list = '';
		foreach( $records as $record )
		{
			$rec = array(
				'detail_url' => '#',
				'edit_url' => '#',
				'delete_url' => '#',
				'options' => ''
			);

			if(!$trash){
				$this->_list_options_active( $record, $rec );
			}else{
				$this->_list_options_trash( $record, $rec );
			}

			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true)->with( $this->load->get_cached_vars() );
		}
	}

	private function _get_list( $trash, $calendar_id )
	{
		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( is_array( $filter_by ) )
		{
			foreach( $filter_by as $filter_by_key => $filter_value )
			{
				if( $filter_value != "" ) $filter = 'AND '. $filter_by_key .' = "'.$filter_value.'"';	
			}
		}
		else{
			if( $filter_by && $filter_by != "" )
			{
				$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
			}
		}

		if( $page == 1 )
		{
			$searches = $this->session->userdata('search');
			if( $searches ){
				foreach( $searches as $mod_code => $old_search )
				{
					if( $mod_code != $this->mod->mod_code )
					{
						$searches[$this->mod->mod_code] = "";
					}
				}
			}
			$searches[$this->mod->mod_code] = $search;
			$this->session->set_userdata('search', $searches);
		}
		
		$page = ($page-1) * 10;
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash, $calendar_id);
		return $records;
	}

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	private function _edit( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}

		//Get Participant and Calendar Details
		$this->db->select('training_calendar.training_revalida_master_id');
		$this->db->join('training_calendar','training_calendar.training_calendar_id = training_revalida.training_calendar_id','left');
		$this->db->where('training_revalida.training_revalida_id',$this->record_id);
		$participant_details = $this->db->get('training_revalida')->row();
		
		//Get Feedback Questionnaire Items
		$answer_details_count = $this->db->get_where('training_revalida_score',array('training_revalida_id' => $this->record_id ))->num_rows();

		if( $answer_details_count > 0 ){
			$this->db->select('training_revalida_category.training_revalida_category_id, training_revalida_category.revalida_category, training_revalida_item.*');
			$this->db->join('training_revalida_category','ww_training_revalida_category.training_revalida_master_id = ww_training_revalida_master.training_revalida_master_id','left');
			$this->db->join('training_revalida_item','training_revalida_item.training_revalida_category_id = training_revalida_category.training_revalida_category_id','left');
			$this->db->where_in('training_revalida_master.training_revalida_master_id',explode(',',$participant_details->training_revalida_master_id));
			$this->db->where('training_revalida_item.inactive = 0');
			$this->db->order_by('training_revalida_item.training_revalida_category_id','ASC');
			$this->db->order_by('training_revalida_item.training_revalida_item_no','ASC');
			$questionnaire_details = $this->db->get('training_revalida_master');
		} else {
			$this->db->select('training_revalida_category.training_revalida_category_id, training_revalida_category.revalida_category, training_revalida_item.*');
			$this->db->join('training_revalida_category','ww_training_revalida_category.training_revalida_master_id = ww_training_revalida_master.training_revalida_master_id','left');
			$this->db->join('training_revalida_item','training_revalida_item.training_revalida_category_id = training_revalida_category.training_revalida_category_id','left');
			$this->db->where_in('training_revalida_master.training_revalida_master_id',explode(',',$participant_details->training_revalida_master_id));
			$this->db->where('training_revalida_item.inactive = 0');
			$this->db->order_by('training_revalida_item.training_revalida_category_id','ASC');
			$this->db->order_by('training_revalida_item.training_revalida_item_no','ASC');
			$questionnaire_details = $this->db->get('training_revalida_master');
		}

		$data['revalida_questionnaire_item_count'] = $questionnaire_details->num_rows();

		if( $questionnaire_details->num_rows() > 0 ){
			$data['revalida_questionnaire_items'] = $questionnaire_details->result_array();
			foreach( $data['revalida_questionnaire_items'] as $key => $val ){
				$revalida_questionnaire_score = $this->db->get_where('training_revalida_score',array('training_revalida_id'=>$this->record_id, 'training_revalida_item_id'=> $data['revalida_questionnaire_items'][$key]['training_revalida_item_id'] ));
				

				if( $revalida_questionnaire_score->num_rows() > 0 ){
					$revalida_questionnaire_score_info = $revalida_questionnaire_score->row();

					$data['revalida_questionnaire_items'][$key]['score'] = $revalida_questionnaire_score_info->score;
					$data['revalida_questionnaire_items'][$key]['remarks'] = $revalida_questionnaire_score_info->remarks;
				}
			}
		}

		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'edit', $this->record_id );
			if( $new )
			{
				$field_lists = $result->list_fields();
				foreach( $field_lists as $field )
				{
					$data['record'][$field] = '';
				}
			}
			else{
				$record = $result->row_array();
				foreach( $record as $index => $value )
				{
					$record[$index] = trim( $value );	
				}
				$data['record'] = $record;
			}

			$this->record = $data['record'];
			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
			}
		}
		else
		{
			$this->load->vars( $data );
			if( !$child_call ){
				echo $this->load->blade('pages.error', array('error' => $record_check))->with( $this->load->get_cached_vars() );
			}
		}
	}

	function get_total_average(){

		$feedback_item = $this->input->post('revalida_item');

		$this->db->select('users.full_name, training_calendar.training_revalida_category_id');
		$this->db->join('training_calendar','training_calendar.training_calendar_id = training_revalida.training_calendar_id','left');
		$this->db->join('users','users.user_id = training_revalida.employee_id','left');
		$this->db->where('training_revalida.training_revalida_id',$this->input->post('record_id'));
		$participant_details = $this->db->get('training_revalida')->row();

		$this->db->select('training_revalida_category.training_revalida_category_id, training_revalida_category.revalida_category, training_revalida_item.*');
		$this->db->join('training_revalida_item','training_revalida_item.training_revalida_category_id = training_revalida_category.training_revalida_category_id','left');
		$this->db->where_in('training_revalida_category.training_revalida_category_id',explode(',',$participant_details->training_revalida_category_id));
		$this->db->where_in('training_revalida_item.score_type',array(1,2,4,5));
		$this->db->order_by('training_revalida_category.training_revalida_category_id','ASC');
		$this->db->order_by('training_revalida_item.training_revalida_item_no','ASC');
		$questionnaire_list = $this->db->get('training_revalida_category');
		$questionnaire_details_count = $questionnaire_list->num_rows();
		$questionnaire_details = $questionnaire_list->result();
		$sub_total = 0;
		$sub_total_score = 0;
		$sub_total_average = 0;
		$current_category_id = 0;
		$total_no_items = 0;  
		$revalida_item[] = 0;
		foreach( $questionnaire_details as $questionnaire_detail_info ){
		 	$sub_total += isset($revalida_item[$questionnaire_detail_info->training_revalida_item_id]) ? $revalida_item[$questionnaire_detail_info->training_revalida_item_id] : null;
		}

		$average_score = ( $sub_total / ( $questionnaire_details_count * 5 ) ) * 100;

		$this->response->total_score = $sub_total;
		$this->response->average_score = number_format($average_score,2,'.','');
		
		$this->_ajax_return();

	}

	public function save()
	{
		$this->_ajax_only();
		$this->record_id = $this->input->post('record_id');

		$training_feedback_data = array();
		if( $this->record_id ){
			$scores = $this->input->post('training_revalida');
			$training_revalida_data = array(
				'revalida_status_id' => 3,
				'total_score' => $scores['total_score'],
				'average_score' => $scores['average_score']
			);
			$this->db->where('training_revalida_id', $this->record_id);
			$this->db->update('training_revalida', $training_revalida_data);
		}

		

		$this->db->where('training_revalida_id',$this->input->post('record_id'));
		$this->db->delete('training_revalida_score');
		$this->db->select('users.full_name, training_calendar.training_revalida_master_id');
		$this->db->join('training_calendar','training_calendar.training_calendar_id = training_revalida.training_calendar_id','left');
		$this->db->join('users','users.user_id = training_revalida.employee_id','left');
		$this->db->where('training_revalida.training_revalida_id', $this->record_id);
		$participant_details = $this->db->get('training_revalida')->row();

		$this->db->select('training_revalida_category.training_revalida_category_id, training_revalida_category.revalida_category, training_revalida_item.*');
		$this->db->join('training_revalida_category','training_revalida_category.training_revalida_master_id = training_revalida_master.training_revalida_master_id','left');
		$this->db->join('training_revalida_item','training_revalida_item.training_revalida_category_id = training_revalida_category.training_revalida_category_id','left');
		$this->db->where_in('training_revalida_master.training_revalida_master_id',explode(',',$participant_details->training_revalida_master_id));
		$this->db->order_by('training_revalida_item.training_revalida_item_no','ASC');
		$questionnaire_list = $this->db->get('training_revalida_master');
		$questionnaire_details = $questionnaire_list->result();

		$revalida_item = $this->input->post('revalida_item');

		foreach( $questionnaire_details as $questionnaire_detail_info ){

			if( in_array( $questionnaire_detail_info->score_type, array(1,2,4,5) ) ){

				$data = array(
					'training_revalida_id' => $this->record_id,
					'training_revalida_item_id' => $questionnaire_detail_info->training_revalida_item_id,
					'score' => isset($revalida_item[$questionnaire_detail_info->training_revalida_item_id]) ? $revalida_item[$questionnaire_detail_info->training_revalida_item_id] : null
				);
				
			}
			else{
				$data = array(
					'training_revalida_id' => $this->record_id,
					'training_revalida_item_id' => $questionnaire_detail_info->training_revalida_item_id,
					'remarks' => isset($revalida_item[$questionnaire_detail_info->training_revalida_item_id]) ? $revalida_item[$questionnaire_detail_info->training_revalida_item_id] : null
				);

			}
			$this->db->insert('training_revalida_score',$data);

		}

		$this->response->message[] = array(
            'message' => lang('common.save_success'),
            'type' => 'success'
        );

    	$this->_ajax_return();
	}

}