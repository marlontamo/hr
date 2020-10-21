<?php //delete me
	function save()
	{
		parent::save( true );
		if( $this->response->saved )
        {
        	$this->mod->_create_config( $this->record_id );
        	
        	$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
        }

        $this->_ajax_return();
	}