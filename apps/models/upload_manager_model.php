<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class upload_manager_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 222;
		$this->mod_code = 'upload_manager';
		$this->route = 'uploadmanager';
		$this->url = site_url('uploadmanager');
		$this->primary_key = 'log_id';
		$this->table = 'system_upload_log';
		$this->icon = 'fa-cloud-upload';
		$this->short_name = 'Upload Manager';
		$this->long_name  = 'Upload Manager';
		$this->description = '';
		$this->path = APPPATH . 'modules/upload_manager/';

		parent::__construct();
	}

    public function upload($data)
    {
        $check_duplicate = $this->check_duplicate_data($data); 

        $upload_data = array(
            'company' => $data['A'],
            'company_code' => $data['B'],
            'address' => $data['C'],
            'city' => $data['D'],
            'country' => $data['E'],
            'zipcode' => $data['F'],
            'vat' => $data['G'],
        );
        $count = 1;
        if ( $check_duplicate ) 
        {
            $this->db->where('company_code', $data['B']);
            $this->db->or_where('company', $data['A']); 
            $this->db->update('users_company', $upload_data);

            $count++;
        } else {
            $this->db->insert('users_company', $upload_data);

            $count++;
        }

        return $count;
    }

    public function check_duplicate_data($post)
    {
        if ( $post )
        {      
            $data = array(
                'company' => $post['A'],
                'company_code' => $post['B']
            );

            $recruitment_email = $this->db->get_where('users_company', $data);

            if ( $recruitment_email->num_rows() > 0 ) 
            {
                return TRUE;
            } else {
                return FALSE;
            }   
        }

    }

}