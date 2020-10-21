<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_revalida_master extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_revalida_master_model', 'mod');
		parent::__construct();
	}

   	function save(){
    	$this->_ajax_only();

		parent::save( true );
		
		if( $this->response->saved )
		{
	    	$post = $_POST['training_revalida_master'];

			if( $this->input->post('draft') == 1 ){
				$draft = 1;
			}
			else{
				$draft = 0;
			}

			$this->db->where('training_revalida_master_id',$this->record_id);
			$this->db->update('training_revalida_master',array('draft'=>$draft));

			unset($post['revalida_type']);

			$category_data = $this->_rebuild_array($post, $this->record_id);

			if( $this->record_id != '-1' ){

				$category_result = $this->db->get_where('training_revalida_category',array('training_revalida_master_id'=>$this->input->post('record_id')))->result();

				foreach( $category_result as $category_info ){

					$this->db->where('training_revalida_category_id',$category_info->training_revalida_category_id);
					$this->db->delete('training_revalida_item');

				}
				
				$this->db->where('training_revalida_master_id',$this->record_id);
				$this->db->delete('training_revalida_category');

			}

			foreach( $category_data as $category_info ){

				$data = array(
					'training_revalida_master_id' => $this->record_id,
					'revalida_category' => $category_info['revalida_category'],
					'revalida_category_weight' => $category_info['revalida_category_weight'],
				);

				$this->db->insert('training_revalida_category',$data);

				$category_id = $this->db->insert_id();
				$item_data = $this->_rebuild_array($_POST['training_revalida_master'][$category_info['item_rand']], $this->record_id);

				foreach( $item_data as $item_info ){

					$item = array(
						'training_revalida_category_id'=>$category_id,
						'training_revalida_item_no'=>$item_info['training_revalida_item_no'],
						'description'=>$item_info['description'],
						'score_type'=>$item_info['score_type'],
						'item_weight'=>$item_info['item_weigth']
					);

					$this->db->insert('training_revalida_item',$item);

				}

			}
		}

        $this->response->message[] = array(
            'message' => lang('common.save_success'),
            'type' => 'success'
        );

    	$this->_ajax_return();
    }

	function add(){
		parent::add( '', true );

		$data['category'] = $this->_get_revalida_detail($this->record_id,'category');;

		$this->load->vars($data);

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function edit(){
		parent::edit( '', true );

		$item_result = $this->db->get('training_revalida_score_type');
		$item_list = $item_result->result_array();
		$data['item_score_type_list'] = $item_list;


		$data['category'] = $this->_get_revalida_detail($this->record_id,'category');

		foreach( $data['category'] as $key => $val ){

			$category_rand = rand(1,100000000);

			$data['category'][$key]['category_rand'] = $category_rand;
			$data['category'][$key]['items'] = $this->_get_revalida_detail($data['category'][$key]['training_revalida_category_id'],'item');
		}

		$this->load->vars($data);

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function detail(){
		parent::detail( '', true );

		$item_result = $this->db->get('training_revalida_score_type');
		$item_list = $item_result->result_array();
		$data['item_score_type_list'] = $item_list;


		$data['category'] = $this->_get_revalida_detail($this->record_id,'category');

		foreach( $data['category'] as $key => $val ){

			$category_rand = rand(1,100000000);

			$data['category'][$key]['category_rand'] = $category_rand;
			$data['category'][$key]['items'] = $this->_get_revalida_detail($data['category'][$key]['training_revalida_category_id'],'item');
		}

		$this->load->vars($data);

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
	}

	private function _get_revalida_detail($record_id = 0, $detail_type = "") {
		if ($record_id == 0) {
			$record_id = $this->input->post('record_id');
		}

		$response = array();

		if( $detail_type == 'category' ){
			$table = 'training_revalida_'.$detail_type;
			$this->db->where('training_revalida_master_id', $record_id);
			$this->db->order_by('training_revalida_category_id', 'ASC');
		}
		elseif( $detail_type == 'item' ){
			$table = 'training_revalida_'.$detail_type;
			$this->db->where('training_revalida_category_id', $record_id);
			$this->db->order_by('training_revalida_item_no', 'ASC');
		}

		$result = $this->db->get($table);

		if ($result){
			$response = $result->result_array();
		}
		

		return $response;
	}

	function get_form($type) {
		if ($type == '') {
			show_error("Insufficient data supplied.");
		} else {
			$data = array();
			if( $type == 'item' ){
				$item_result = $this->db->get('training_revalida_score_type');
				$item_list = $item_result->result_array();
				$data['item_score_type_list'] = $item_list;
				$data['item_count'] = $this->input->post('item_count');
				$data['category_rand'] = $this->input->post('category_rand');
			}
			else{
				$data['category_count'] = $this->input->post('category_count');
				$data['category_rand'] = rand(1,100000000);
			}

			$this->load->helper('file');
			$this->response->html = $this->load->view('edit/master/'.$type.'_form', $data, true);
			
			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
				);

			$this->_ajax_return();
		}
	}

	private function _rebuild_array($array, $fkey = null, $key_field = '') {
		if (!is_array($array)) {
			return array();
		}

		$new_array = array();

		$count = count(end($array));
		$index = 0;

		while ($count >= $index) {

			foreach ($array as $key => $value) {

				if( isset( $array[$key][$index] ) ){

					$new_array[$index][$key] = $array[$key][$index];
					if (!is_null($fkey)) {
						$new_array[$index]['training_revalida_master_id'] = $fkey;
					}

				}
				else{

					continue;

				}
			}

			$index++;
		}

		return $new_array;
	}

}