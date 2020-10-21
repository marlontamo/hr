<?php //delete me
	function send_sms( $sms )
	{
		$this->load->helper('string');
		$this->load->config('chikka');
		$chikka = $this->config->item('chikka');

		$message_id = random_string('numeric', 32);
		//$message_id = "29290290hdisystemtechnologiesinc";
		$chikka['post']['message_type'] = "SEND";
		$chikka['post']['message_id'] = $message_id;
		$chikka['post']['mobile_number'] = $sms['mobile'];
		$chikka['post']['message'] = $sms['message'];		

		$query_string = "";
		foreach($chikka['post'] as $key => $frow)
		{
			$query_string .= '&'.$key.'='.$frow;
		}
		
		$curl_handler = curl_init();
		curl_setopt($curl_handler, CURLOPT_URL, $chikka['api']);
		curl_setopt($curl_handler, CURLOPT_POST, count($chikka['post']));
		curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
		curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl_handler, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl_handler);
		if( curl_errno($curl_handler) )
		{
		    $this->response->message[] = array(
				'message' => curl_error($curl_handler),
				'type' => 'error'
			);

		    echo 'error:' . curl_error($curl_handler);
		}
		else{
			$this->response = $response;
		}
		
		curl_close($curl_handler);
		header('Content-type: application/json');
		echo json_encode( $this->response );
		//die();
	}
	
	
	public function send_from_queue()
	{
		$mails = $this->mod->get_queued(0, 5); //try sending 5 records
		
		if($mails->num_rows() > 0)
		{

			foreach( $mails->result() as $mail ) 
			{
				$this->send_sms( array('mobile' => $mail->to, 'message' => $mail->body) );
				$this->mod->sent( $mail->id );
			}
		}
	}
	