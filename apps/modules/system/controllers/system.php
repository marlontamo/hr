<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class System extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('system_model', 'mod');
		parent::__construct();
		$this->lang->load('system_settings');
	}

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
		$data['mail_config'] = $this->mod->_get_config('outgoing_mailserver'); 
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
			
			if( count($_POST) > 0 ){

			$qry = array();
					
			foreach( $_POST as $field => $value ){
				$previous_main_data = $this->db->get_where($this->mod->table, array('config_group_id' => $_POST['config_group_id'], 'key' => $field))->row_array();

				if($value == "on") $value = '1';
					
				if($field != "config_group_id"){
					if($field == 'bg_image'){
						//for bg_image
					}
					else{
						$qry[] = "UPDATE ww_config SET VALUE = '$value' WHERE config_group_id = '".$_POST['config_group_id']."' AND `key` = '$field';";
					}

				}

				if(is_array($value)){
					//for bg_image
				}
				else{
					//create system logs
					$this->mod->audit_logs($this->user->user_id, $this->mod->mod_code, 'update', $this->mod->table, '', $value);
				}
							
			}

			$result = $this->mod->_update_config($qry);

			if($result){
				$this->mod->_create_config( $this->input->post('config_group_id') );

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

	public function delete_bg_image()
	{
		$this->_ajax_only();
		if(isset($_POST['bg_image']))
		{
		    $bgm = $_POST['bg_image'];
		    //$this->db->delete('config', array( 'config_id' => $bgm ) );
		    
            $this->db->update( 'config', array( 'deleted' => 1 ) , array( 'config_id' => $bgm ) );
		    $this->response->message = array(
				'message' => 'Successful.',
				'type' => 'success'
			);

		}
		
		else{
			$this->response->message = array(
				'message' => 'Failed.',
				'type' => 'error'
			);	
		} 
		
		$this->_ajax_return();	
	}

	public function single_upload_login()
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

		//create login image
		$login_folder = 'uploads/'.$this->mod->mod_code . '/login/';
		if (!file_exists($login_folder)) {
		    mkdir($login_folder, 0755, true);
            copy(APPPATH .'index.html', $login_folder.'index.html');
		}
		$options = array(
	                'max_width' =>  $width,
	                'max_height' => ($height < 150) ? $height : 150
	                );

		$this->create_scaled_image($file->name,'login', $options);
		$file->site_url = $file->url;
		$file->url = $login_folder.$file->name;

		$this->response->file = $file;
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

    function create_scaled_image($file_name, $version, $options) 
    {
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

    function get_upload_path($file_name = null, $version = null) 
    {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_path = $version.'/';
        }
        return UPLOAD_DIR.$version_path.$file_name;
    }

	function create_config( $config_group_id )
	{
		$this->mod->_create_config( 5 );
	}

	function multiple_upload_image()
	{
		$this->_ajax_only();
		define('UPLOAD_DIR', 'assets/img/bg/');
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
				'config_group_id' => '2',
				'key' => 'bg_image',
				'value' => $file->url,
				'created_by' => $this->user->user_id,
			);
			$this->db->insert('config', $data);
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
				<div class="thumbnail" style="height: 100px;">
				    <img class="padding-right-5 style="height: 100px;" src="'. base_url().$file->url .'" alt="HDI Workwise">
				    <a style="float: none; margin-top: -10px;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$file->upload_id.'" href="javascript:void(0)"></a>
				</div>
	        </li>';
		}
		$this->response->file = $file;
		$this->_ajax_return();
	}
}