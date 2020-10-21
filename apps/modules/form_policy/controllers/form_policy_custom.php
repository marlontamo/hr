<?php //delete me

	public function get_list(){
		
		$this->_ajax_only();

		if( !$this->permission['list'] ){

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

		$page = $this->input->post('page');
		$search = $this->input->post('search');
		$filter = "";
		$filter_by = $this->input->post('filter_by');
		$filter_value = $this->input->post('filter_value');
		
		if( $filter_by && !empty($filter_by) )
		{
			$filter = 'AND '. $filter_by .' = "'.$filter_value.'"';
		}

		$trash = $this->input->post('trash') == 'true' ? true : false;

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
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash); 
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

			$this->_list_options( $record, $rec );
			
			$record = array_merge($record, $rec);
			$this->response->list .= $this->load->blade('list_template', $record, true);
		}

		$this->_ajax_return();		
	}