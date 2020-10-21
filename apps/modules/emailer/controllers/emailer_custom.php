<?php //delete me
	public function send_from_queue()
	{
		$mails = $this->mod->get_queued(0, 5); //try sending 5 records
		
		if($mails->num_rows() > 0)
		{
			//settings
			$this->load->config('outgoing_mailserver');
			$mail_config = $this->config->item('outgoing_mailserver');
			$meta = $this->load->config('system');

			$this->load->library('email', $mail_config);
			$this->email->set_newline("\r\n");
			$this->email->from($mail_config['from_address'], $mail_config['from_name']);

			foreach( $mails->result() as $mail ) 
			{
				//$this->mod->change_status($mail->id, 'sending');			

				if( trim($mail->to) == '' )
				{
					$this->email->to($mail_config['smtp_username']);
				}
				else{
					$this->email->to($mail->to);	
				}

				if( trim($mail->cc) != '' )
				{
					$this->email->cc($mail->cc);	
				}

				if( trim($mail->bcc) != '' )
				{
					$this->email->bcc($mail->bcc);	
				}

				if( trim($mail->attachment) != '' )
				{
					$attachments  = explode('|', $mail->attachment);
					foreach( $attachments as $attachment )
					{
						$this->email->attach( $attachment );
					}	
				}	

				$this->email->subject($mail->subject);
				$this->email->message($mail->body);
				$this->mod->change_status($mail->id, 'sending');
				$this->mod->attempt( $mail->id, ($mail->attemps + 1) );
				
				if ( !$this->email->send() )
				{
					log_message('error', $this->email->print_debugger());
					$this->mod->change_status($mail->id, 'queued');
					
				}
				else{
					$this->mod->sent( $mail->id );
				}
			}
		}
	}
	