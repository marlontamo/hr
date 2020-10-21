<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload_manager extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('upload_manager_model', 'mod');
		parent::__construct();
	}

    public function index(){
        echo $this->load->blade('list')->with( $this->load->get_cached_vars() );
    }

    public function single_upload()
    {
        $this->_ajax_only();
        define('UPLOAD_DIR', 'uploads/'.$this->mod->mod_code . '/');
        $this->load->library("UploadHandler");
        $files = $this->uploadhandler->post();
        $file = $files[0];   
        $status = false;
        $count_empty=0;
        $count_success=0;

        if( isset($file->error) && $file->error != "" )
        {
            $this->response->message[] = array(
                'message' => $file->error,
                'type' => 'error'
            );  
            
        }

        if( isset($file->url) ) 
        {
            $file_upload_url = $file->url;
            if( !file_exists( urldecode($file_upload_url) ) )
            {
                $this->response->message[] = array(
                    'message' => lang('upload_manager.file_missing'),
                    'type' => 'warning'
                );
                $this->_ajax_return();
            }

            $ext = pathinfo($file_upload_url, PATHINFO_EXTENSION);
            if( in_array($ext, array('xls', 'xlsx')) )
            {
                $this->load->library('excel');
                $inputFileType = PHPExcel_IOFactory::identify(urldecode($file_upload_url));
                $objReader  = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel  = $objReader->load(urldecode($file_upload_url)); 

                $sheetInsertData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                unset($sheetInsertData[1]);
                foreach($sheetInsertData as $rec)
                { 
                    if ( !empty($rec['B']) )
                    {
                        $count_success++;
                    } else {
                        $count_empty++;
                    }
                }

                if($count_empty > 0)
                {
                    $status = false;
                } else {
                    $status = true;
                }


            } 
        }

        $this->response->count_success = $count_success;
        $this->response->count_empty = $count_empty;
        $this->response->status = $status;
        $this->response->file = $file;
        $this->_ajax_return();
    }

    public function upload()
    {
        $this->_ajax_only();
        $status = false;
        $file = $this->input->post('template');

        if( !file_exists( urldecode($file) ) )
        {
            $this->response->message[] = array(
                'message' => lang('upload_manager.file_missing'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if( in_array($ext, array('xls', 'xlsx')) )
        {
            $this->load->library('excel');
            $inputFileType = PHPExcel_IOFactory::identify(urldecode($file));
            $objReader  = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel  = $objReader->load(urldecode($file)); 

            $sheetInsertData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

            unset($sheetInsertData[1]);
            $count = array();
            foreach($sheetInsertData as $rec)
            { 
               $count[] = $this->mod->upload($rec);
            }

            $status = true;
            $this->response->message[] = array(
                'message' => 'Upload success!',
                'type' => 'success'
            );
        } else {
            $this->response->message[] = array(
                'message' => lang('upload_manager.file_type_not_accepted'),
                'type' => 'warning'
            );
        }

        $this->response->count = count($count);
        $this->response->status = $status;
        $this->_ajax_return();
    }
}