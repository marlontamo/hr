<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load the MX_Controller class */
require APPPATH."third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
	public static $instance;

	var $response;
	var $permission;
	var $record_id = '';
	var $record = array();

	public function __construct()
	{
		self::$instance || self::$instance =& $this;
		parent::__construct();
		$this->response = new stdClass();
		
		//choose database
		if( $this->session->userdata('current_db') && $this->session->userdata('current_db') != "default" )
		{
			$current_db = $data['current_db'] = $this->session->userdata('current_db');
			$multidb = $this->load->config('multidb', true, true);
			if( $multidb && isset( $multidb[$this->session->userdata('current_db')] ) )
			{
				$this->db = $this->load->database($multidb[$this->session->userdata('current_db')], TRUE);
				$connected = $this->db->initialize();
				if( $connected )
				{
					$data['db'] = $this->db;
				}
				else{
					echo "Cant connect to database";
					die();
				}
			}
		}
		else{
			$data['current_db'] = 'default';
			$this->db->initialize(); //use default
		}
		
		//add the path of the current module
		// if(CLIENT_MODULE != '' && is_dir(APPPATH.CLIENT_MODULE.'/'.$this->mod->mod_code.'/controllers/')){
		// 	$this->mod->path = str_replace('modules', CLIENT_MODULE, $this->mod->path);
		// }
		// debug($this->mod->path);
		// die();
		$views_paths = $this->config->item('views_paths');
		$views_paths[] = $this->mod->path . 'views/' ;
		$views_paths[] = APPPATH . 'views/';
		$this->config->set_item('views_paths', $views_paths);
		$this->mod->method = $this->router->fetch_method();

		$data['mod'] = $this->mod;
		$data['db'] = $this->db;
		$data['lang'] = $this->lang->lang();
		$data['user_language'] = $this->config->item('language');
		if( !IS_AJAX )
		{
			$this->load->config('system');
			$data['system'] = $this->config->item('system');
		}

		//load language
		$this->lang->load('common');
		$this->lang->load('menu');
		$mod_lang = APPPATH . 'language/'.$this->config->item('language').'/'. $this->mod->mod_code .'_lang.php';


		if( file_exists( $mod_lang ) )
		{
			$this->lang->load( $this->mod->mod_code );
		}
		
		if(file_exists(APPPATH.'language/'.$this->config->item('language').'/'.CLIENT_DIR.'/'. $this->mod->mod_code .'_lang.php')){
			$this->lang->load( CLIENT_DIR.'/'.$this->mod->mod_code);
		}

		$mod_lang = FCPATH . 'assets/language/'.$this->config->item('language').'/'. $this->mod->mod_code .'_lang.js';
		if( file_exists( $mod_lang ) )
		{
			$data['mod_lang'] = 'language/'.$this->config->item('language').'/'. $this->mod->mod_code .'_lang.js';
		}

		if( $this->session->userdata('user') )
		{
			$this->user = $this->session->userdata('user');
			$data['user'] = $this->_get_user_config();
			$this->db->update('users', array('lastactivity' => time()), array('user_id' => $this->user->user_id));
		}

		$this->load->vars( $data );
	}

	public function _ajax_only()
	{
		if( !IS_AJAX )
		{
			$this->session->set_flashdata('flashmessage', array('msg_type' => 'attention', 'msg' => lang('common.no_direct_access') ));
			redirect('');
		}
	}

	public function _ajax_return()
	{
		if( !isset($this->response->message) )
		{
			$this->response->message[] = array(
				'message' => lang('common.no_proper_response'),
				'type' => 'warning'
			);
		}

		if( $this->input->post('selector') )
		{
			$this->response->selector = $this->input->post('selector');
			$this->response->item_selector = $this->input->post('item_selector');
		}

		header('Content-Type: application/json');
		echo json_encode( $this->response );
		die();
	}

	public function single_upload()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
		
		$this->load->library("UploadHandler");

		$files = $this->uploadhandler->post();
		$file = $files[0];
		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}
		$this->response->file = $file;
		$this->_ajax_return();
	}

	public function multiple_upload()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
		$this->load->library("UploadHandler");
		$files = $this->uploadhandler->post();
		$file = $files[0];
		if( isset($file->error) && $file->error != "" ){
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);
		}
		else{
			$data = array(
				'upload_path' => $file->url,
				'created_by' => $this->user->user_id,
			);
			$this->db->insert('system_uploads', $data);
			$file->upload_id = $this->db->insert_id();
			
			switch( $file->type )
			{
				case 'image/jpeg':
					$icon = 'fa-picture-o';
					break;
				case 'video/mp4':
					$icon = 'fa-film';
					break;
				case 'audio/mpeg':
					$icon = 'fa-volume-up';
					break;
				default:
					$icon = 'fa-file-text-o';
			}
			$file->icon = '<li class="padding-3 fileupload-delete-'.$file->upload_id.'" style="list-style:none;">
	            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
	            <span>'. $file->name .'</span>
	            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$file->upload_id.'" href="javascript:void(0)"></a></span>
	        </li>';
		}
		$this->response->file = $file;
		$this->_ajax_return();
	}

	function _get_user_config()
	{
		$userconfig_path = APPPATH . 'config/'. $this->session->userdata('current_db') .'/users/'. $this->user->user_id .'.php';
		if( !file_exists( $userconfig_path ) )
		{
			$this->load->model('users_model', 'users');
			$this->users->_create_config( $this->user->user_id );
		}
		$userconfig = $this->session->userdata('current_db') .'/users/'. $this->user->user_id .'.php';
		$this->load->config( $userconfig, false, true );
		return $this->config->item('user');
	}

	function send_sms()
	{
		$this->load->helper('string');
		$this->load->config('chikka');
		$chikka = $this->config->item('chikka');

		$message_id = random_string('numeric', 32);
		$chikka['post']['message_type'] = "SEND";
		$chikka['post']['message_id'] = $message_id;
		$chikka['post']['mobile_number'] = '63----------';
		$chikka['post']['message'] = '';		

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
		die();
	}
}

class MY_PrivateController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		if( $this->session->userdata('screenlock') )
		{
			if( $this->input->post('mobileapp') )
			{
				$this->response->screenlock = true;
				$this->_ajax_return();
			}
			else
				redirect( 'screenlock' );
		}

		$this->load->model('authentication_model', 'authentication');
		$this->user = $this->authentication->_login_check();

		//check for new login and redirect
		if( $this->session->userdata('uri_request') && $controller != 'login' ){
			$redirect = $this->session->userdata('uri_request');
			$this->session->unset_userdata( 'uri_request' );
			redirect( $redirect );
		}

		$current_db_config_path = APPPATH . 'config/'.$this->session->userdata('current_db');
		
		$user = $data['user'] = $this->_get_user_config();
		$data['localize_time'] = false;
		if( date_default_timezone_get() != $user['timezone']  ) $data['localize_time'] = true;

		$data['business_group'] = $this->session->userdata('business_group');
		$data['chatroomid'] = $data['business_group'][$this->session->userdata('current_db')]->group_id;

		//load menu
		$role_menu_path = APPPATH . 'views/menu/' . $this->session->userdata('current_db');
		$role_menu = $role_menu_path .'/'. $user['role_id'] .'.blade.php';
		if( !file_exists( $role_menu ) )
		{
			$this->load->model('menu');
			$this->menu->create_role_menu( $user['role_id'], $role_menu );
		}
		
		//load permission
		$role_permission = $current_db_config_path .'/roles/'. $user['role_id'] .'/permission.php';
		if( !file_exists( $role_permission ) )
		{
			$this->load->model('roles_model', 'roles');
			$this->roles->_create_permission_file( $user['role_id'] );
		}
		$this->load->config( $this->session->userdata('current_db') .'/roles/'. $user['role_id'] .'/permission.php', false, true );
		$this->permission = $data['permission'] = $this->_check_permission( $this->mod->mod_code );

		if( !$this->permission )
		{
			if( IS_AJAX )
			{
				$this->response->message[] = array(
					'message' => lang('common.no_permission'),
					'type' => 'warning'
				);
				$this->_ajax_return();
			}
			else{
				$this->load->vars( $data );
				echo $this->load->blade('pages.no_permission')->with( $this->load->get_cached_vars() );
				die();
			}
		}

		//manage search per module
		$data['search'] = '';
		$searches = $this->session->userdata('search');
		if( $searches )
		{
			foreach( $searches as $mod_code => $search )
			{
				if( $mod_code != $this->mod->mod_code )
				{
					$searches[$mod_code] = '';	
				}
				else{
					$data['search'] = $search;
					$searches[$mod_code] = $search;
				}
			}
			$this->session->set_userdata('search', $searches);
		}


		$sql_play = "SELECT pp.* FROM play_partner pp WHERE pp.user_id = {$this->user->user_id}";
		$qry_play = $this->db->query($sql_play)->row_array();
		
		$data['play_details'] = $qry_play;
		//load data to view
		$this->load->vars( $data );
		
		if (method_exists($this,'_after_construct')) {
			$this->_after_construct();
		}
	}

	function chat_users()
	{
		$this->_ajax_only();
		$this->load->model('users_model');
		$this->response->users = $this->users_model->chat_users();
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function seen_pm()
	{
		$this->_ajax_only();
		if( $this->input->post('from') )
		{
			$this->load->model('users_model');
			$this->users_model->seen_pm( $this->input->post('from') );
		}
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function send_pm()
	{
		$this->_ajax_only();
		if( $this->input->post('to') && $this->input->post('message') )
		{
			$this->load->model('users_model');
			$this->users_model->send_pm( $this->input->post('to'), $this->input->post('message') );
		}
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function get_recent_pm()
	{
		$this->_ajax_only();
		if( $this->input->post('from') )
		{
			$this->load->model('users_model');
			$this->response->pm = $this->users_model->get_recent_pm( $this->input->post('from') );
			if( $this->response->pm ) $this->response->pm = array_reverse($this->response->pm);
		}
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		$this->_ajax_return();
	}

	function test_openbr()
	{
		$percentage = exec('br -algorithm FaceRecognition -compare C:\openbr\me2.jpg C:\openbr\me3.jpg') * 100;
		echo $percentage;
	}

	function _check_permission( $mod_code ){
		$permission = $this->config->item('permission');
		$this->load->config('default_permission');
		$default_permission = $this->config->item('default_permission');
		$permission = isset($permission[$mod_code]) ? array_merge($default_permission,$permission[$mod_code]) : 0;
		return $permission;
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	public function add( $record_id = '', $child_call = false )
	{
		if( !$this->permission['add'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call, true );
	}

	public function detail( $record_id, $child_call = false )
	{
		if( !$this->permission['detail'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_detail( $child_call );
	}

	private function _detail( $child_call, $new = false )
	{
		$record_check = false;
		$this->record_id = $data['record_id'] = '';	

		if( !$new )
		{
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
		}

		$this->record_id = $data['record_id'] = $_POST['record_id'];
		
		$record_check = $this->mod->_exists( $this->record_id );
		if( $new || $record_check === true )
		{
			$result = $this->mod->_get( 'detail', $this->record_id );
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
				echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
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

	public function edit( $record_id = "", $child_call = false )
	{
		if( !$this->permission['edit'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$this->_edit( $child_call );
	}

	function quick_edit( $child_call = false )
	{
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->_quick_edit( $child_call, false );
		$this->_ajax_return();
	}

	function quick_add( $child_call = false )
	{
		$this->_ajax_only();

		if( !$this->permission['add'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.no_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->_quick_edit( $child_call, true );
		
		if( !$child_call )
			$this->_ajax_return();
	}

	private function _quick_edit( $child_call, $new = false )
	{
		$this->record_id = $data['record_id'] = '';

		if( !$new ){
			if( !$this->_set_record_id() )
			{
				echo $this->load->blade('pages.insufficient_data')->with( $this->load->get_cached_vars() );
				die();
			}

			$this->record_id = $data['record_id'] = $_POST['record_id'];
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
				$data['record'] = $result->row_array();
			}

			$this->record = $data['record'];
			$this->load->vars( $data );

			if( !$child_call ){
				$this->load->helper('form');
				$this->load->helper('file');
				
				$data['title'] = $this->mod->short_name .' - Quick Edit';
				$data['content'] = $this->load->blade('pages.quick_edit')->with( $this->load->get_cached_vars() );

				$this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

				$this->response->message[] = array(
					'message' => '',
					'type' => 'success'
				);
			}
		}
		else
		{
			$this->load->vars( $data );
			$this->response->message[] = array(
				'message' => $record_check,
				'type' => 'error'
			);
		}	
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
				$record = array();
				if ($result && $result->num_rows() > 0){
					$record = $result->row_array();
				}
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

	public function get_import_form()
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

		$this->load->model('upload_utility_model', 'import');
		$mod_id = $this->input->post('mod_id');
		$vars['templates'] = $this->import->get_templates( $mod_id );
		if( $vars['templates'] )
		{
			$this->load->vars( $vars );

			$data['title'] = $this->mod->short_name .' - Import';
			$data['content'] = $this->load->blade('common.import-form')->with( $this->load->get_cached_vars() );

			$this->response->import_form = $this->load->view('templates/modal', $data, true);

			$this->response->message[] = array(
				'message' => '',
				'type' => 'success'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.no_import_settings'),
				'type' => 'warning'
			);
		}
		
		$this->_ajax_return();
	}

	public function import()
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
		
		$template_id = $this->input->post('template_id');
		$file = $this->input->post('template');

		if( !file_exists( urldecode($file) ) )
		{
			$this->response->message[] = array(
				'message' => lang('upload_utility.file_missing'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);

		$this->db->limit(1);
		$template = $this->db->get_where( 'system_upload_template', array('deleted' => 0,'template_id' => $template_id) )->row();
		$accepted_file_types = explode(',', $template->accepted_file_types);

		if (!in_array($ext, $accepted_file_types)) {
            $this->response->message[] = array(
				'message' => lang('upload_utility.file_type_not_accepted'),
				'type' => 'warning'
			);
			$this->_ajax_return();
        }

        $csv_convert = false;
        if( in_array($ext, array('xls', 'xlsx')) )
        {
        	$csv_convert = time().'.csv';
        	$this->load->library('excel');
        	$inputFileType = PHPExcel_IOFactory::identify(urldecode($file));
        	$reader = PHPExcel_IOFactory::createReader($inputFileType);
			//$reader->setReadDataOnly(true);
			$excel = $reader->load(urldecode($file)); 
			$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
			$writer->setDelimiter("\t");
			$writer->save($csv_convert);
        }

        $this->load->model('upload_utility_model', 'import');
        $response = $this->import->upload( urldecode($file), $template, $csv_convert );
		$this->response =  (object) array_merge((array) $this->response, (array) $response);

		$this->response->message[] = array(
			'message' => 'Upload success!',
			'type' => 'success'
		);
		$this->_ajax_return();

		$this->_ajax_return();	
	}

	public function reset_all_config()
	{
		$this->_ajax_only();

		if( $this->config->item('role_id', 'user') === 1 )
		{
			//delete all config
			$this->load->model('module_model');
			$this->module_model->_reset_all();

			//delete menus
			$this->load->model('menu');
			$this->menu->_delete_all_menu_files();

			$this->response->message[] = array(
				'message' => 'Reset successfull.',
				'type' => 'success'
			);
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);	
		}

		$this->_ajax_return();
	}

	public function reset_routes()
	{
		if( $this->config->item('role_id', 'user') === 1 )
		{
			//delete all config
			$this->load->model('module_model');
			$this->module_model->create_routes();
		}
		else{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();	
		}
	}

	public function save( $child_call = false )
	{
		$this->_ajax_only();

		if( !$this->_set_record_id() )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);
			$this->_ajax_return();	
		}
		
		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$this->response = $this->mod->_save( $child_call );
		$this->record_id = $this->response->record_id;
		
		
		if( !$child_call )
		{
			$this->_ajax_return();
		}

	}

	public function _set_record_id()
	{
		if( !isset($_POST['record_id']) && $this->uri->rsegment(3) )
		{
			$_POST['record_id'] = $this->uri->rsegment(3);
		}

		if( !isset($_POST['record_id']) )
		{
			return false;
		}

		$this->record_id = $this->mod->record_id = $this->input->post( 'record_id');
		return true;
	}

	public function get_list()
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
		$records = $this->_get_list( $trash );
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

	private function _get_list( $trash )
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
		$records = $this->mod->_get_list($page, 10, $search, $filter, $trash);
		return $records;
	}

	function _list_options_active( $record, &$rec )
	{
		//temp remove until view functionality added
		if( $this->permission['detail'] )
		{
			$rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
			$rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
		}

		if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}	
		
		if( isset($this->permission['delete']) && $this->permission['delete'] )
		{	
			if(isset($record['can_delete']) && $record['can_delete'] == 1){
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}elseif(isset($record['can_delete']) && $record['can_delete'] == 0){
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a disabled="disabled" style="color:#B6B6B4" onclick="return false" href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}else{
				$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
				$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
			}
		}
	}

	function _list_options_trash( $record, &$rec )
	{
		if( $this->permission['edit'] )
		{
			$rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
			$rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
		}

		if( $this->permission['restore'] )
		{
			$rec['options'] .= '<li><a href="javascript:restore_record( '. $record['record_id'] .' )"><i class="fa fa-refresh"></i> '.lang('common.restore').'</a></li>';
		}
	}

	function delete()
	{
		$this->_ajax_only();
		
		if( !$this->permission['delete'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$this->response = $this->mod->_delete( $records );

		$this->_ajax_return();
	}

	function restore()
	{
		$this->_ajax_only();
		
		if( !$this->permission['restore'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		if( !$this->input->post('records') )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'warning'
			);
			$this->_ajax_return();	
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		$this->response = $this->mod->_restore( $records );

		$this->_ajax_return();
	}

	function get_notification()
	{
		$this->_ajax_only();

		$this->load->model('notification_model', 'notification');
		$this->response = $this->notification->_get_user_notification( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();
	}

	function get_group_notification()
	{
		$this->_ajax_only();

		$this->load->model('group_notification_model', 'gn');
		$this->response = $this->gn->get_notifications( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success',
            'user' => $this->user->user_id
        );
		$this->_ajax_return();
		
	/*	$this->_ajax_only();

		$this->load->model('group_notification_model', 'gn');
		$notifs = $this->gn->get_notifications( $this->user->user_id );
		$this->response->total_unread = 0;
		if( $notifs )
		{
			//debug($notifs);
			$this->response->notification = array();
			$this->response->total_notification = sizeof($notifs);	
			foreach( $notifs as $notif )
			{
				if( $notif->read == 0 )
					$this->response->total_unread++;

				$this->response->notification[] = $this->load->view('templates/group_notif', array('notif' => $notif), true);
			}	
		}

		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();  */
	}

	function get_inbox()
	{
		$this->_ajax_only();

		$this->load->model('inbox_model', 'inbox');
		$this->response = $this->inbox->_get_user_messages( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();
	}

	function unnotify()
	{
		$this->_ajax_only();
		$this->load->model('notification_model', 'notification');
		$this->response = $this->notification->_unnotify( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();	
	}

	function unnotify_group()
	{
		$this->_ajax_only();
		$this->load->model('group_notification_model', 'gn');
		$this->response = $this->gn->_unnotify( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();	
	}

	function uninbox()
	{
		$this->_ajax_only();
		$this->load->model('inbox_model', 'inbox');
		$this->response = $this->inbox->_uninbox( $this->user->user_id );
		$this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
		$this->_ajax_return();	
	}

	public function exec_cmd()
	{
		echo exec('node assets/scripts/node_curl.js "get_user_1_notification" "{broadcaster: 1, notify: true}"');
	}

	function sess_keepalive()
	{
		$this->_ajax_only();
		$this->_ajax_return();
	}

	public function get_user_preview()
	{
		$this->_ajax_only();
		$this->load->model('users_model', 'user_preview');

		$data 				= array();
		$data['user'] 		= $this->user_preview->_get_user_preview( $this->input->post('user_id') );
		$data['contacts'] 	= $this->user_preview->_get_user_contacts( $this->input->post('user_id') );

		if($data['user']){
			$this->response->title 		= $data['user']->user_name;
			$this->response->content 	= $this->load->view('common/user_preview', $data, true);
		}
		else{
			$this->response->title 		= lang('common.no_preview_title');
			$this->response->content 	= lang('common.no_preview_content');			
		}
		
		$this->_ajax_return();
	}

	function user_lists_typeahead()
	{
		$this->_ajax_only();
		$this->load->model('dashboard_model', 'dashboard');
		$this->response->users = $this->dashboard->getUsersTagList();
		$this->_ajax_return();
	}

	public function tag_user(){
		$this->_ajax_only();
		$data = array();
		$this->load->model('dashboard_model', 'dashboard');
		$data = $this->dashboard->getUsersTagList();
		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	function change_business_group()
	{
		$this->_ajax_only();
		$group = $this->input->post('group');
		if( $group )
		{
			$groups = $this->session->userdata('business_group');
			if( in_array($group, array_keys($groups) ) )
			{
				$users = $this->session->userdata('business_user');
				if( isset( $users[$group] ) )
				{
					$this->session->set_userdata('current_db', $group);	
					$this->session->set_userdata('user', $users[$group]);

					$this->response->success = true;
					$this->response->message[] = array(
						'message' => '',
						'type' => 'success'
					);
				}
				else{
					$this->response->message[] = array(
						'message' => lang('common.user_not_found'),
						'type' => 'warning'
					);	
				}
			}
			else{
				$this->response->message[] = array(
					'message' => lang('common.group_not_found'),
					'type' => 'warning'
				);
			}
		}
		else{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);	
		}
		
		$this->_ajax_return();	
	}

	function change_lang()
	{
		$this->_ajax_only();
		$lang = $this->input->post('lang');
		if( !$lang )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_data'),
				'type' => 'error'
			);	
		}
		
		$this->db->update('users', array('language' => $lang), array('user_id' => $this->user->user_id));
		$this->load->model('users_model');
		$this->users_model->_create_config($this->user->user_id);
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);
		
		$uri = $this->input->post('uri');
		if( $uri )
		{
			$base_url = base_url();
			$uri = str_replace($base_url, '', $uri);
			$this->response->uri = $base_url . $this->lang->switch_uri($lang, $uri);	
		}

		$this->_ajax_return();
	}
}

class MY_PublicController extends MY_Controller
{

}

/* End of file */
/* Location: application/core */