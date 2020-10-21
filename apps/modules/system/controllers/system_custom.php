<?php //delete me
	public function index(){

		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$data['sys_config'] = $this->mod->_get_config('system');
		$data['mail_config'] = $this->mod->_get_config('outgoing_mailser'); 
		$data['other_config'] = $this->mod->_get_config('other_settings'); 
		$this->load->vars($data);
		echo $this->load->blade('record_flat')->with( $this->load->get_cached_vars() );
	}

	public function save(){ 

		$this->_ajax_only();

		if( !$this->permission['list'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}		

		$qry_string = "";
		$data = array();
				
				
		if( count($_POST) > 0 ){

			$qry = array();
					
			foreach( $_POST as $field => $value ){

				if($value == "on") $value = '1';
					
				if($field != "config_group_id"){
					$qry[] = "UPDATE ww_config SET VALUE = '$value' WHERE config_group_id = '".$_POST['config_group_id']."' AND `key` = '$field';";
				}			
			}
			
			$result = $this->mod->_update_config($qry);

			if($result){

				$this->response->message[] = array(
					'message' => 'Data successfully saved/updated!',
					'type' => 'success'
				);
				$this->_ajax_return();
			}
		}
		else{

			$this->response->message[] = array(
				'message' => 'You have entered insufficient data.',
				'type' => 'warning'
			);
			$this->_ajax_return();
		}				
	}