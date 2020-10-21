<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('company_model', 'mod');
		parent::__construct();
		$this->lang->load('company');
	}
	
    function save()
    {
    	$post = $_POST;
    	$this->response->record_id = $this->record_id = $post['record_id'];
		unset( $post['record_id'] );

    	$company_code_check = $this->db->get_where($this->mod->table, array('company_code' => $post[$this->mod->table]['company_code'], 'deleted' => 0));
    	
    	if($company_code_check && $company_code_check->num_rows() > 0){
    		$company = $company_code_check->row();
    		if($company->company_id !== $this->record_id){
	    		$validation_rules[] = array(
						'field'   => 'users_company[company_code]',
						'label'   => 'Company Code',
						'rules'   => 'required|is_unique[users_company.company_code]'
		            );

	    		if( sizeof( $validation_rules ) > 0 )
		        {
		            $this->load->library('form_validation');
		            $this->form_validation->set_rules( $validation_rules );
		            if ($this->form_validation->run() == false)
		            {
		                foreach( $this->form_validation->get_error_array() as $f => $f_error )
		                {
		                    $this->response->message[] = array(
		                        'message' => $f_error,
		                        'type' => 'warning'
		                        );  
		                }

		                $this->_ajax_return();
		            }
		        }
			}else{
				unset( $post[$this->mod->table]['company_code'] );
			}
    	}

        parent::save( true );

        if( $this->response->saved )
        {
            $this->db->where($this->mod->primary_key, $this->record_id);
            $this->db->update($this->mod->table, array('modified_on' => date('Y-m-d H:s:i')));

            $this->response->message[] = array(
                'message' => lang('common.save_success'),
                'type' => 'success'
            );

            $company_contact = $this->input->post('users_company_contact');
            if(!empty($company_contact)){
                foreach($company_contact as $contact_type => $contact){
                    foreach($contact as $type => $contact_no){
                        foreach($contact_no as $no){
                            foreach($no as $indx => $n){
                                 $records = array(
                                    'company_id' => $this->response->record_id,
                                    'contact_type' => $contact_type,
                                    'contact_no' => $n,
                                    'type' => $type,
                                    'contacts_id' => ($type=='update') ? $indx : ''
                                );
                                $this->mod->save_company_contact($records);     
                            }
                        }
                    }     
                }
            }

            //to populate overtime rates per company as default

            $result = $this->db->get_where('payroll_overtime_rates',array('company_id' => $this->response->record_id));
            if (!$result || $result->num_rows() < 1){
                $this->db->query("INSERT INTO {$this->db->dbprefix}payroll_overtime_rates (company_id,overtime_id,overtime_code,overtime,overtime_rate,sequence,class) 
                                  SELECT {$this->response->record_id},overtime_id,overtime_code,overtime,overtime_rate,sequence,class FROM {$this->db->dbprefix}payroll_overtime_rates_default
                                ");
            }
        }else{
            // $this->response->message[] = array(
            //     'message' => lang('common.inconsistent_data'),
            //     'type' => 'error'
            // );
        }     

        $this->_ajax_return();
    }


	public function delete()
    { 
        $this->_ajax_only();

        $records = $this->input->post('records');
        //purging incorrect concat of string
    //     $records = explode(',', $records);
    //     $this->db->where_in($this->mod->primary_key, $records);
    //     $result = $this->db->get($this->mod->table);
    //     $result_data = $result->result();
    //     if($result->num_rows() > 0 )
    //     {           
    //     	$count = 0;
    //     	foreach($result_data as $row){
    //     		if(isset($row->can_delete) && $row->can_delete == '0'){
				// 	$count++;
				// }
    //     	}
  
    //     	if($count > 0){
    //     		$this->response->message[] = array(
    //             	'message' => lang('common.can_delete'),
    //             	'type' => 'error'
    //         	);
    //         	$this->_ajax_return();
    //         	goto stop;	
    //     	}
            
    //     }

    //     stop:


		if( (empty( $this->record_id ) && !$this->permission['add']) || ($this->record_id && !$this->permission['edit']) )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}

		$records = $this->input->post('records');
		$records = explode(',', $records);

		//create system logs
		// $this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', $this->mod->primary_key, array(), $records);

		$results = $this->mod->_delete( $records );
		

		foreach($results as $result){
			$this->response->message[] = array(
				'message' => $result['message'], 
				'type' => $result['type']
			);
		}

		$this->_ajax_return();
	}

	public function single_upload_header()
	{
		define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
		//$this->load->library("UploadHandler", 'uploadhandler');
		$this->load->library("UploadHandler");

		$file_uploaded = $_FILES['files']['name']; 
		$file_ext = pathinfo($file_uploaded[0], PATHINFO_EXTENSION);
		$allowable_file_type = array('jpg', 'jpeg', 'gif', 'png');

		if (!in_array($file_ext, $allowable_file_type)){			
			$this->response->message[] = array(
				'message' => 'Allow only image files.',
				'type' => 'warning'
			);
			$this->response->uploaded = false;
			$this->_ajax_return();
		}

		$files = $this->uploadhandler->post();
		$file = $files[0];

		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}

		$directory = substr($file->url, 0, strrpos( $file->url, '/')).'/'.$file->name;
		list($width, $height, $type, $attr) = getimagesize($directory);

		//create header image
		$header_folder = 'uploads/'.$this->mod->mod_code . '/header/';
		if (!file_exists($header_folder)) {
		    mkdir($header_folder, 0755, true);
            copy(APPPATH .'index.html', $header_folder.'index.html');
		}
		$options = array(
	                'max_width' =>  $width,
	                'max_height' => ($height < 25) ? $height : 25
	                );

		$this->create_scaled_image($file->name,'header', $options);
		$file->site_url = $file->url;
		$file->url = $header_folder.$file->name;

		$this->response->file = $file;
		$this->_ajax_return();
	}

	public function single_upload_print()
	{
		define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
		//$this->load->library("UploadHandler", 'uploadhandler');
		$this->load->library("UploadHandler");

		$file_uploaded = $_FILES['files']['name']; 
		$file_ext = pathinfo($file_uploaded[0], PATHINFO_EXTENSION);
		$allowable_file_type = array('jpg', 'jpeg', 'gif', 'png');

		if (!in_array($file_ext, $allowable_file_type)){			
			$this->response->message[] = array(
				'message' => 'Allow only image files.',
				'type' => 'warning'
			);
			$this->response->uploaded = false;
			$this->_ajax_return();
		}

		$files = $this->uploadhandler->post();
		$file = $files[0];

		if( isset($file->error) && $file->error != "" )
		{
			$this->response->message[] = array(
				'message' => $file->error,
				'type' => 'error'
			);	
		}

		$directory = substr($file->url, 0, strrpos( $file->url, '/')).'/'.$file->name;
		list($width, $height, $type, $attr) = getimagesize($directory);

		//create print image
		$print_folder = 'uploads/'.$this->mod->mod_code . '/print/';
		if (!file_exists($print_folder)) {
		    mkdir($print_folder, 0755, true);
            copy(APPPATH .'index.html', $print_folder.'index.html');
		}
		$options = array(
	                'max_width' =>  $width,
	                'max_height' => ($height < 100) ? $height : 100
	                );

		$this->create_scaled_image($file->name,'print', $options);
		$file->site_url = $file->url;
		$file->url = $print_folder.$file->name;

		$this->response->file = $file;
		$this->_ajax_return();
	}
	

    function create_scaled_image($file_name, $version, $options) {
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
        	$version_dir = $this->get_upload_path(null, $version);
            $new_file_path = $version_dir.'/'.$file_name;
    	}else{
        	$new_file_path = $file_path;
    	}

        if (!function_exists('getimagesize')) {
            error_log('Function not found: getimagesize');
            return false;
        }
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $max_width = $options['max_width'];
        $max_height = $options['max_height'];
        $scale = min(
            $max_width / $img_width,
            $max_height / $img_height
        );
        if ($scale >= 1) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        if (!function_exists('imagecreatetruecolor')) {
            error_log('Function not found: imagecreatetruecolor');
            return false;
        }
        if (empty($options['crop'])) {
            $new_width = $img_width * $scale;
            $new_height = $img_height * $scale;
            $dst_x = 0;
            $dst_y = 0;
            $new_img = imagecreatetruecolor($new_width, $new_height);
        } else {
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = $img_width / ($img_height / $max_height);
                $new_height = $max_height;
            } else {
                $new_width = $max_width;
                $new_height = $img_height / ($img_width / $max_width);
            }
            $dst_x = 0 - ($new_width - $max_width) / 2;
            $dst_y = 0 - ($new_height - $max_height) / 2;
            $new_img = imagecreatetruecolor($max_width, $max_height);
        }
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                $src_img = imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
                imagealphablending($new_img, false);
                imagesavealpha($new_img, true);
                $src_img = imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                imagedestroy($new_img);
                return false;
        }
        $success = imagecopyresampled(
            $new_img,
            $src_img,
            $dst_x,
            $dst_y,
            0,
            0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path, $image_quality);
        // Free up memory (imagedestroy does not delete files):
        imagedestroy($src_img);
        imagedestroy($new_img);
        return $success;
    }

    function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_path = $version.'/';
        }
        return UPLOAD_DIR.$version_path.$file_name;
    }
}