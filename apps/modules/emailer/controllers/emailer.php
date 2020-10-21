<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Emailer extends MY_PublicController
{
	public function __construct()
	{
		$this->load->model('emailer_model', 'mod');
		parent::__construct();
	}

	public function send_from_queue()
	{
		//send from default
		$mails = $this->mod->get_queued(0, 5); //try sending 5 records
		$this->_send_mail($mails);

		//send from other DB's
		$multidb = $this->load->config('multidb', true, true);
		if( $multidb )
		{
			foreach( $multidb as $dbname => $db )
			{
				$this->db = $this->load->database($db, TRUE);
				$connected = $this->db->initialize();
				if( $connected )
				{
					$this->mod->db = $this->db;
					$mails = $this->mod->get_queued(0, 5); //try sending 5 records
					$this->_send_mail($mails);	
				}	
			}
		}
	}

	private function _send_mail( $mails )
	{
		if($mails->num_rows() > 0)
		{
			//settings
			$this->load->config('outgoing_mailserver');
			$mail_config = $this->config->item('outgoing_mailserver');
			$meta = $this->load->config('system');

			$this->load->library('email', $mail_config);
			foreach( $mails->result() as $mail ) 
			{
				$this->email->set_newline("\r\n");
				$this->email->from($mail_config['from_address'], $mail_config['from_name']);

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

				if( trim($mail->subject) != '' ) 
				{
					$this->email->subject($mail->subject);
					$this->email->message($mail->body);
					$this->mod->change_status($mail->id, 'sending');
					$this->mod->attempt( $mail->id, ($mail->attempts + 1) );
					
					if ( !$this->email->send() )
					{
						log_message('error', $this->email->print_debugger());
						if( ($mail->attempts + 1) < 5 ){
							$this->mod->change_status($mail->id, 'queued');
						}
					}
					else{
						$this->mod->sent( $mail->id );
					}
				}
				else{
					$this->mod->change_status($mail->id, 'sending');
				}

				$this->email->clear();
			}
		}
	}
}
