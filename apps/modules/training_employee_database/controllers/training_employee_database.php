<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_employee_database extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_employee_database_model', 'mod');
		parent::__construct();
	}

 	function ted_export_excel(){

        $filename = $this->mod->export_excel();

        $this->response->message[] = array(
            'message' => 'Download file ready.',
            'type' => 'success'
        );

        $this->response->filename = $filename;
        $this->_ajax_return();
    }

    function detail(){
        parent::detail( '', true );

        $this->db->join('training_calendar','training_calendar.training_calendar_id = training_employee_database.calendar_id','left');
        $this->db->join('training_course','training_course.course_id = training_calendar.course_id','left');
        $this->db->join('training_provider','training_provider.provider_id = training_course.provider_id','left');
        /*$this->db->join('training_subject_schedule','training_subject_schedule.training_subject_schedule_id = training_subject.training_subject_schedule_id','left');*/
        $this->db->where('training_employee_database.employee_database_id',$this->input->post('record_id'));
        $employee_training = $this->db->get('training_employee_database');

       // debug($this->db->last_query());die();

        $data['employee_training_total'] = $employee_training->num_rows();

        if( $employee_training->num_rows() > 0 ){

            $employee_training_result = $employee_training->result_array();

            foreach( $employee_training_result as $key => $employee_training_info ){

                $employee_training_result[$key]['start_date'] = ($employee_training_result[$key]['start_date'] && $employee_training_result[$key]['start_date'] != '0000-00-00' && $employee_training_result[$key]['start_date'] != '1970-01-01' ? date('d F Y',strtotime($employee_training_result[$key]['start_date'])) : '');
                $employee_training_result[$key]['end_date'] = ($employee_training_result[$key]['end_date'] && $employee_training_result[$key]['end_date'] != '0000-00-00' && $employee_training_result[$key]['end_date'] != '1970-01-01' ? date('d F Y',strtotime($employee_training_result[$key]['end_date'])) : '');
                $employee_training_result[$key]['bond_start_date'] = ($employee_training_result[$key]['bond_start_date'] && $employee_training_result[$key]['bond_start_date'] != '0000-00-00' && $employee_training_result[$key]['bond_start_date'] != '1970-01-01' ? date('d F Y',strtotime($employee_training_result[$key]['bond_start_date'])) : '');
                $employee_training_result[$key]['bond_end_date'] = ($employee_training_result[$key]['bond_end_date'] && $employee_training_result[$key]['bond_end_date'] != '0000-00-00' && $employee_training_result[$key]['bond_end_date'] != '1970-01-01' ? date('d F Y',strtotime($employee_training_result[$key]['bond_end_date'])) : '');

                $bond_start_date_obj = new DateTime($employee_training_result[$key]['bond_start_date']);
                $bond_end_date_obj = new DateTime($employee_training_result[$key]['bond_end_date']);

                $diff = $bond_start_date_obj->diff($bond_end_date_obj);

                if( strtotime(date('d F Y')) > strtotime($employee_training_result[$key]['bond_end_date']) ){
                    $employee_training_result[$key]['bond_status'] = "Fulfilled";
                }
                else{
                    $employee_training_result[$key]['bond_status'] = "On-Going";
                }

            }

        }


        $data['employee_training'] = $employee_training_result;
        $this->load->vars($data);
        
        $this->load->helper('form');
        $this->load->helper('file');
        echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
    }
}