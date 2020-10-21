<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Training_calendar extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('training_calendar_model', 'mod');
		$this->load->model('training_calendar_manage_model', 'tcmm');
		$this->load->model('training_calendar_admin_model', 'tcam');
		parent::__construct();
	}

	function index()
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

/*		$this->db->order_by('type', 'asc');
		$partners_movement_type = $this->db->get_where('partners_movement_type', array('deleted' => 0));
		$data['partners_movement_type'] = $partners_movement_type->result();

		$this->db->order_by('cause', 'asc');
		$partners_movement_cause = $this->db->get_where('partners_movement_cause', array('deleted' => 0));
		$data['partners_movement_cause'] = $partners_movement_cause->result();
*/
        $data['training_calendar'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $data['training_calendar_manage'] = isset($permission[$this->tcmm->mod_code]['list']) ? $permission[$this->tcmm->mod_code]['list'] : 0;
        $data['training_calendar_admin'] = isset($permission[$this->tcam->mod_code]['list']) ? $permission[$this->tcam->mod_code]['list'] : 0;

		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}	

	function edit(){
		
		parent::edit( '', true );

		//get sections if there are any
		$training_cost_tab = array();

		$training_costs = $this->db->get_where('training_calendar_budget', array('training_calendar_id' => $this->record_id));

		if($training_costs->num_rows() > 0){
			$training_cost_tab = $training_costs->result_array();
		}

		$data['training_cost_tab'] = $training_cost_tab;
		$data['calendar_id'] = $this->record_id;
		$data['cost_count'] = $this->input->post('cost_count');

		$session_tab = array();

		$sessions = $this->db->get_where('training_calendar_session', array('training_calendar_id' => $this->record_id));

		if($sessions->num_rows() > 0){
			$session_tab = $sessions->result_array();
		}

		$data['session_tab'] = $session_tab;
		$data['training_calendar_id'] = $this->record_id;
		$data['session_count'] = $this->input->post('session_count');

		$this->load->vars($data);
		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
	}

	function detail(){
		parent::detail( '', true );

		//get sections if there are any
		$training_cost_tab = array();

		$training_costs = $this->db->get_where('training_calendar_budget', array('training_calendar_id' => $this->record_id));

		if($training_costs->num_rows() > 0){
			$training_cost_tab = $training_costs->result_array();
		}

		$data['training_cost_tab'] = $training_cost_tab;
		$data['calendar_id'] = $this->record_id;

		$session_tab = array();

		$sessions = $this->db->get_where('training_calendar_session', array('training_calendar_id' => $this->record_id));

		if($sessions->num_rows() > 0){
			$session_tab = $sessions->result_array();
		}

		$data['session_tab'] = $session_tab;
		$data['training_calendar_id'] = $this->record_id;
		$data['session_count'] = $this->input->post('session_count');

		$this->load->vars($data);
		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
	}

	function _rebuild_array($array, $fkey = null, $key_field = '' )
	{
		if (!is_array($array)) {
			return array();
		}

		$new_array = array();

		$count = count(end($array));
		$index = 0;

		while ($count >= $index) {
			foreach ($array as $key => $value) {

				if( isset( $array[$key][$index] ) ){

					$new_array[$index][$key] = $array[$key][$index];
					if (!is_null($fkey) && !empty($key_field)) {
						$new_array[$index][$key_field] = $fkey;
					}

				}
				else{

					continue;

				}
			}

			$index++;
		}

		return $new_array;
	}

	public function get_training_course_info(){
		//debug($this->input->post('training_calendar-course_id'));die();
		$this->_ajax_only();
			if( $this->input->post('course') ){

				$course_id = $this->input->post('course');

				$training_course_info = "SELECT * FROM ww_training_course c 
					LEFT JOIN ww_training_provider p ON p.`provider_id` = c.`provider_id`
					LEFT JOIN ww_training_category cat ON cat.`category_id` = c.`category_id`
	                    			WHERE c.course_id  = '" . $course_id . "' ";

	                    $training_course_info = $this->db->query($training_course_info);

				if($training_course_info->num_rows() > 0){
					//$training_course_info->row();

				$this->response->training_provider = $training_course_info->row('provider');
				$this->response->training_category = $training_course_info->row('category');
					$this->response->message[] = array(
	                'message' => 'Succesfully called!',
	                'type' => 'success'
	                );
				}
				

			}
			/*else{

				$training_calendar_id = $this->input->post('record_id');

				$this->db->join('training_course','training_course.course_id = training_calendar.course_id','left');
				$this->db->join('training_category','training_category.training_category_id = training_course.training_category_id','left');
				$this->db->join('training_provider','training_provider.provider_id = training_course.provider_id','left');
				$this->db->where('training_calendar.training_calendar_id',$training_calendar_id);
				$training_calendar_info = $this->db->get('training_calendar');

				if($training_calendar_info > 0){
					$training_calendar_info->row(); 
					$response->training_provider = $training_calendar_info->training_provider;
					$response->training_category = $training_calendar_info->training_category;
				}

				

			}*/

		

		//$this->load->view('template/ajax', array('json' => $response));
		$this->_ajax_return();

	}

	function add_form() {
		$this->_ajax_only();

		$data['count'] = $this->input->post('count');
		$data['counting'] = $this->input->post('counting');
		$data['category'] = $this->input->post('category');

		$this->response->count = ++$data['count'];
		$this->response->counting = ++$data['counting'];

		$this->load->helper('file');
		$this->response->add_form = $this->load->view('edit/forms/'.$this->input->post('add_form'), $data, true);
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();
	}

	function get_training_cost_form() {
		$this->_ajax_only();

		if( !$this->permission['edit'] )
		{
			$this->response->message[] = array(
				'message' => lang('common.insufficient_permission'),
				'type' => 'warning'
			);
			$this->_ajax_return();
		}
	
		$data['cost_count'] = $this->input->post('cost_count');
		$data['training_calendar_id'] = $this->input->post('training_calendar_id');

		$this->load->helper('form');

		$this->load->view('edit/forms/training_cost', $data);
	}

	function calculate_total_cost_pax(){

        $subtotal_budget_cost = $this->input->post('sub_total');
        $subtotal_budget_pax  = $this->input->post('sub_pax');

		$this->response->total_cost = ($subtotal_budget_cost) ? number_format($subtotal_budget_cost,2,'.',',') : 0;
		$this->response->total_pax = $subtotal_budget_pax;
		
		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
			);

		$this->_ajax_return();

    }

	function get_employees()
	{
        $this->_ajax_only();
		$location_id = $this->input->post('location_id');
		$company_id = $this->input->post('company_id');
		$branch_id = $this->input->post('branch_id');
		$department_id = $this->input->post('department_id');


        $qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile u ON partners.user_id = u.user_id
                WHERE partners.deleted = 0 
                ";
        if ($location_id && $location_id != 'null'){
            $qry .= " AND location_id IN ({$location_id}) ";
        }
        if ($company_id && $company_id != 'null'){
            $qry .= " AND u.company_id IN ({$company_id}) ";
        }        
        if ($branch_id && $branch_id != 'null'){
            $qry .= " AND u.branch_id IN ({$branch_id}) ";
        }
        if ($department_id && $department_id != 'null'){
            $qry .= " AND u.department_id IN ({$department_id})  ";
        }      
        $qry .= " ORDER BY partners.alias ASC";

        $employees = $this->db->query( $qry );

        $this->response->count = 0;
        $this->response->employees = '';
        if ($employees && $employees->num_rows() > 0){
	        $this->response->count = $employees->num_rows();
	        foreach( $employees->result() as $employee )
	        {   
	            $data['partner_id_options'][$employee->user_id] = $employee->alias;
	            $this->response->employees .= '<option value="'.$employee->user_id.'" selected="selected">'.$employee->alias.'</option>';
	        }
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
	}

	function add_participants(){

		$user_id = $this->input->post('user_id');
		$html = "";

        $qry = "SELECT partners.alias, partners.partner_id, partners.user_id 
                FROM partners
                INNER JOIN users_profile u ON partners.user_id = u.user_id
                WHERE partners.deleted = 0 AND partners.user_id IN ({$user_id})
                ";

        $qry .= " ORDER BY partners.alias ASC";

        $employee_list = $this->db->query( $qry );

		$participant_status_list = $this->db->get('training_calendar_participant_status')->result();

		foreach( $employee_list->result() as $employee_info ){

			$rand = rand(1,10000);

			$html .= '<tr>
	    		<td style="text-align:center;">'.$employee_info->alias.'</td>';
	    		
	    	$html .= '<td style="text-align:center;">
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input type="checkbox" value="1" name="participants['.$rand.'][temp]" id="participants-nominate" class="toggle participants-nominate"/>
				    	<input type="hidden" name="participants['.$rand.'][nominate]" class="participants-nominate-val" value="0"/>
					</div>
	    		</td>
	    		<td style="text-align:center;">
	    			<select name="participants['.$rand.'][status]" class="form-control participant_status select2me">';
	    			foreach( $participant_status_list as $participant_status ){
	    				$html .= '<option value="'.$participant_status->participant_status_id.'">'.$participant_status->participant_status.'</option>';
	    			}
	    	$html .= '</select>
	    		</td>
	    		<td style="text-align:center;">
					<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
				    	<input type="checkbox" value="1" name="participants['.$rand.'][temp]" id="participants-no_show" class="toggle participants-no_show"/>
				    	<input type="hidden" name="participants['.$rand.'][no_show]" class="participants-no_show-val" value="0"/>
					</div> 
	    		</td>
	    		<td style="text-align:center;">
	    			<a class="btn btn-xs text-muted delete-participant" href="javascript:void(0)"><i class="fa fa-trash-o"></i> Delete</a>
	    			<input type="hidden" class="participants" name="participants['.$rand.'][id]" value="'.$employee_info->user_id.'" />
	    		</td>
	    	</tr>';
		}

		$this->response->content_list = $html;

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
	}

	function get_employee_filter(){

		$this->db->join('users_profile','users_profile.user_id = partners.user_id','left');

		if( $this->input->post('nid') ){
			$nid = substr_replace($this->input->post('nid'), "", -1);
			$id = explode(',', $nid);

			$this->db->where_not_in('partners.user_id',$id,true);
		}

		$employees = $this->db->get('partners');	

        foreach( $employees->result() as $employee ){
        	$this->response->employees .= '<option value="'.$employee->user_id.'" selected="selected">'.$employee->alias.'</option>';
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
	}	

   	function save(){
    	$this->_ajax_only();

    	$post = $_POST;

		$training_calendar = $post['training_calendar'];

		$record_id = $post['record_id'];

		$training_calendar['registration_date'] = ($training_calendar['registration_date'] != '' ? date('Y-m-d',strtotime($training_calendar['registration_date'])) : '');
		$training_calendar['last_registration_date'] = ($training_calendar['last_registration_date'] != '' ? date('Y-m-d',strtotime($training_calendar['last_registration_date'])) : '');
		$training_calendar['publish_date'] = ($training_calendar['publish_date'] != '' ? date('Y-m-d',strtotime($training_calendar['publish_date'])) : '');
		$training_calendar['revalida_date'] = ($training_calendar['revalida_date'] != '' ? date('Y-m-d',strtotime($training_calendar['revalida_date'])) : '');
		$training_calendar['feedback_category_id'] = $commaList = ($training_calendar['feedback_category_id'] != '' ? implode(', ', $training_calendar['feedback_category_id']) : '');

                unset($training_calendar['provider']);

		if(empty($record_id)){
			$this->db->insert('training_calendar', $training_calendar);	
			$record_id = $this->db->insert_id();
			$this->save_sessions($record_id);
			$this->save_training_cost($record_id);

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}
		else{
			
			$this->db->update('training_calendar', $training_calendar, array( 'training_calendar_id' => $record_id ) );
			//debug($this->db->last_query());die();
			$this->db->delete('training_calendar_session', array( 'training_calendar_id' => $record_id ) );
			$this->save_sessions($record_id);

			$this->db->delete('training_calendar_budget', array('training_calendar_id' => $record_id));
			$this->save_training_cost($record_id);

			$this->response->message[] = array(
				'message' => lang('common.save_success'),
				'type' => 'success'
			);
		}

    	$this->save_participants($post,$record_id);

        $this->response->message[] = array(
            'message' => lang('common.save_success'),
            'type' => 'success'
        );

    	$this->_ajax_return();
    }

    function save_participants($post,$record_id){

		$participant_list = $post['participants'];

		if ($record_id != ''){

			$this->db->where('training_calendar_participant.training_calendar_id',$record_id);
			$calendar_participant_list = $this->db->get('training_calendar_participant');

			if( $calendar_participant_list->num_rows() > 0 ){

				$participant_count = 0;
				$calendar_participant_list = $calendar_participant_list->result();

				foreach( $calendar_participant_list as $calendar_participant_info ){

					$participant_count = 0;

					foreach( $participant_list as $participant_info ){
						if( $participant_info['id'] == $calendar_participant_info->user_id ){
							$participant_count++;
						}
					}

					if( $participant_count == 0 ){

						$this->db->delete('training_calendar_participant',array('training_calendar_id' => $record_id, 'user_id'=>$calendar_participant_info->user_id));
					}

				}

			}
		}

		foreach( $participant_list as $participant_info ){
			$this->db->join('users_profile','users_profile.user_id = training_calendar_participant.user_id','left');
			$this->db->where('training_calendar_participant.training_calendar_id',$record_id);
			$this->db->where('training_calendar_participant.user_id',$participant_info['id']);
			$calendar_participant_info = $this->db->get('training_calendar_participant');

			if( $calendar_participant_info && $calendar_participant_info->num_rows() > 0 ){

				$calendar_participant_info_result = $calendar_participant_info->row();

				$participant_status = $participant_info['status'];

				if( $participant_status == "" ){
					$participant_status = $calendar_participant_info_result->participant_status_id;
				}

				$previous_participant_status = $calendar_participant_info_result->participant_status_id;
				$no_show = "";

				if( $participant_info['nominate'] == 1 ){
					if( $calendar_participant_info_result->participant_status_id == 1 ){
						$participant_status = '5';
					}
				}
				else{
					if( $calendar_participant_info_result->participant_status_id == 5 ){
						$participant_status = '1';
					}
				}


				if( $participant_info['no_show'] != 1 && $participant_info['no_show'] != 0  ){

					if( $calendar_participant_info_result->no_show == 1 ){
						$no_show = $calendar_participant_info_result->no_show;
					}
					else{
						$no_show = 0;
					}

				}
				else{

					$no_show = $participant_info['no_show'];

				}

				$data = array(
					'participant_status_id' => $participant_status,
					'no_show' => $no_show,
					'nominate' => $participant_info['nominate'],
					'previous_participant_status_id' => $previous_participant_status
				);

				if( $no_show == 1 && $calendar_participant_info_result->send_no_show_notification == 0 ){
		            $data['send_no_show_notification'] = 1;
				}
				
				$this->db->update('training_calendar_participant',$data,array('calendar_participant_id' => $participant_info['calendar_participant_id']));

			}
			else{

				$data = array(
					'training_calendar_id'=>$record_id,
					'participant_status_id' => $participant_info['status'],
					'user_id' => $participant_info['id'],
					'no_show' => $participant_info['no_show'],
					'nominate' => $participant_info['nominate'],
					'previous_participant_status_id' => $participant_info['status']
				);

				$this->db->insert('training_calendar_participant',$data);

			}

		}
    }

	function save_training_cost($record_id){
		$post = $this->input->post('training_cost');

		$data = $this->_rebuild_array($post, $record_id, 'training_calendar_id');

		foreach( $data as $cost ){

				$this->db->insert('training_calendar_budget',$cost);
		}
	}    

	public function save_sessions($record_id)
	{
		$post = $this->input->post('session');

		$data = $this->_rebuild_array($post, $record_id, 'training_calendar_id');

		foreach( $data as $session ){

			$session['session_date'] = ($session['session_date'] != '' ? date('Y-m-d',strtotime($session['session_date'])) : '');

			$this->db->insert('training_calendar_session',$session);

		}
	}

	public function get_session_form()
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
		
		$data['session_count'] = $this->input->post('session_count');
		$data['training_calendar_id'] = $this->input->post('training_calendar_id');

		$this->load->helper('form');

		$this->load->view('edit/training_session', $data);
	}
}
