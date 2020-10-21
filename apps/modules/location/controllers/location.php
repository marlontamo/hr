<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Location extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('location_model', 'mod');
        $this->load->model('record','rec');
		parent::__construct();
        $this->lang->load('location');
	}

    public function delete()
    {
        $this->_ajax_only();

        $records = $this->input->post('records');
        $this->db->where_in($this->mod->primary_key, $records);
        $result = $this->db->get($this->mod->table);
        $result_data = $result->row();
        if($result->num_rows() > 0 && $result_data->can_delete == 0)
        {           
            $this->response->message[] = array(
                'message' => lang('common.can_delete'),
                'type' => 'error'
            );
            $this->_ajax_return();
        }

        $data['modified_on'] = date('Y-m-d H:i:s');
        $data['modified_by'] = $this->user->user_id;
        $data['deleted'] = 1;

        $this->db->where_in($this->mod->primary_key, $records);
        $this->db->update($this->mod->table, $data);

        //create system logs
        $this->rec->audit_logs($this->user->user_id, $this->mod->mod_code, 'delete', $this->mod->primary_key, '', $records);

        if( $this->db->_error_message() != "" ){
            $this->response->message[] = array(
                'message' => $this->db->_error_message(),
                'type' => 'error'
            );
        }
        else{
            $this->response->message[] = array(
                'message' => lang('common.delete_record', $this->db->affected_rows()),
                'type' => 'success'
            );
        }

        $this->_ajax_return();
    }
            
}