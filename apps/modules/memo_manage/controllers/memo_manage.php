<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Memo_manage extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('memo_manage_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

        $user_setting = APPPATH . 'config/users/'. $this->user->user_id .'.php';
        $user_id = $this->user->user_id;
        $this->load->config( "users/{$user_id}.php", false, true );
        $user = $this->config->item('user');

        $this->load->config( 'roles/'. $user['role_id'] .'/permission.php', false, true );
        $permission = $this->config->item('permission');

        $data['memo_manage'] = isset($this->permission['list']) ? $this->permission['list'] : 0;

        $this->load->model('memo_model', 'memo');
        $data['memo'] = isset($permission[$this->memo->mod_code]['list']) ? $permission[$this->memo->mod_code]['list'] : 0;
     
        $this->load->vars($data);  
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	function get_applied_to_options()
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

		$this->response->options = $this->mod->_get_applied_to_options( '', false, $this->input->post('apply_to') );

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function save()
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

		$reemail = 0;
		if(isset($_POST['reemail'])){
			$reemail = $_POST['reemail'];
			unset( $_POST['reemail'] );
		}
		$_POST['memo']['memo_body'] = mb_convert_encoding($_POST['memo']['memo_body'], 'HTML-ENTITIES', 'UTF-8');
		
		$this->db->trans_begin();
		$this->response = $this->mod->_save( true, false );

		if( $this->response->saved ){
			
			if( isset($_POST['memo']['applied_to']) )
			{
				$applied_to = $_POST['memo']['applied_to'];
				$this->db->delete('memo_recipient', array('memo_id' => $this->response->record_id));

				foreach( $applied_to as $apply_to )
				{
					$insert = array(
						'memo_id' => $this->response->record_id,
						'apply_to' => $apply_to
					);
					$this->db->insert('memo_recipient', $insert);
				}

				$this->db->trans_commit();

				// if(strtotime($_POST['memo']['publish_from']) <= strtotime(date('Y-m-d')) && strtotime($_POST['memo']['publish_to']) >= strtotime(date('Y-m-d'))){
					$this->db->query("CALL sp_partners_memo_feeds( {$this->response->record_id}, '{$this->mod->mod_code}' )");
					mysqli_next_result($this->db->conn_id);
					if($reemail == 1 && $_POST['memo']['email'] == 1){
						$this->db->query("CALL sp_partners_memo_email( {$this->response->record_id} )");
						mysqli_next_result($this->db->conn_id);
					}
				// }

			}
			else{
				$this->db->trans_rollback();
				$this->response->saved = false;
				$this->response->message[] = array(
					'message' => 'Please choose applied to.',
					'type' => 'warning'
				);
				$this->_ajax_return();
			}

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}
		else{
			$this->db->trans_rollback();
		}
		
		

		$this->_ajax_return();
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

		header('Content-type: application/json');
		echo json_encode( $this->response );
		die();
	}


	public function single_upload()
	{
		define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
		//$this->load->library("UploadHandler", 'uploadhandler');
		$this->load->library("UploadHandler");

		$file_uploaded = $_FILES['files']['name']; 
		$file_ext = pathinfo($file_uploaded[0], PATHINFO_EXTENSION);
		$allowable_file_type = array('jpg', 'jpeg', 'gif', 'png', 'pdf');

		if (!in_array($file_ext, $allowable_file_type)){			
			$this->response->message[] = array(
				'message' => 'Allow only image and pdf files.',
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

		//create dashboard image
		$dashboard_folder = 'uploads/'.$this->mod->mod_code . '/dashboard/';
		if (!file_exists($dashboard_folder)) {
		    mkdir($dashboard_folder, 0755, true);
            copy(APPPATH .'index.html', $dashboard_folder.'index.html');
		}
		$options = array(
	                'max_width' => ($width < 480) ? $width : 480,
	                'max_height' => $height
	                );

		$this->create_scaled_image($file->name,'dashboard', $options);
	
        if (strtolower(substr(strrchr($file->name, '.'), 1)) == 'pdf') {
			//create dashboard-sized image
			$base_path = str_replace("\\", "/", FCPATH);
			$thumbFormat = 'jpg';
			$pdf_thumbName = substr($file->name, 0, strrpos( $file->name, '.'));
			$pdf_dash = new imagick($base_path.$directory.'[0]');
			$pdf_dash->setImageFormat($thumbFormat);
			$pdf_dash->thumbnailImage( 480, 480);
			// write to disk
			$pdf_dash->writeImage($base_path.$dashboard_folder.$pdf_thumbName.'.'.$thumbFormat );

			//create thumbnail-sized image
			$thumbnail_folder = 'uploads/'.$this->mod->mod_code . '/thumbnail/';
			if (!file_exists($thumbnail_folder)) {
			    mkdir($thumbnail_folder, 0755, true);
	            copy(APPPATH .'index.html', $thumbnail_folder.'index.html');
			}
			$pdf_thumb = new imagick($base_path.$directory.'[0]');
			$pdf_thumb->setImageFormat($thumbFormat);
			$pdf_thumb->thumbnailImage( 45, 43);
			// write to disk
			$pdf_thumb->writeImage($base_path.$thumbnail_folder.$pdf_thumbName.'.'.$thumbFormat );
		}

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
			$rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
			$rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
		}
	}
}