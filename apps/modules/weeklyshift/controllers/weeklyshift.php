<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Weeklyshift extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('weeklyshift_model', 'mod');
		parent::__construct();
		$this->lang->load('weeklyshift');
	}
function save(){

		$error = false;
		$shift_weekly = $_POST['shift_weekly'];
		unset($_POST['shift_weekly']);

		parent::save(true);

		$record_id = $this->record_id;

		if( $record_id == '' ){
			$record_id = $this->response->record_id;
		}

		foreach( $shift_weekly['shift'] as $week_no => $shift_id ){

			$time_shift_insert = $this->mod->call_sp_time_shift_insert($record_id,$week_no,$shift_id);

			if(!$time_shift_insert){
				$error = true;
			}

		}

		if( $error ){

			$this->response->message[] = array(
	            'message' => 'Error saving weekly shift!',
	            'type' => 'error'
	        );

		}
		else{

			$this->response->message[] = array(
	            'message' => lang('common.save_success'),
	            'type' => 'success'
	        );

		}


		$this->_ajax_return();

	}

public function add( $record_id = '' )
{
		
	parent::add($record_id,true);

	$data['sunday_shift'] = '';
	$data['monday_shift'] = '';
	$data['tuesday_shift'] = '';
	$data['wednesday_shift'] = '';
	$data['thursday_shift'] = '';
	$data['friday_shift'] = '';
	$data['saturday_shift'] = '';

	$this->load->vars($data);

	$this->load->helper('form');
	$this->load->helper('file');
	echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );


}

function detail($record_id = ''){

	parent::detail($record_id,true);

	$get_time_shift_weekly = $this->mod->get_time_shift_weekly_calendar($this->record_id);

	foreach( $get_time_shift_weekly as $weekly_info ){

		switch($weekly_info['week_no']){
			case 1:
				$data['sunday_shift'] = $weekly_info['week_name'];
			break;
			case 2:
				$data['monday_shift'] = $weekly_info['week_name'];
			break;
			case 3:
				$data['tuesday_shift'] = $weekly_info['week_name'];
			break;
			case 4:
				$data['wednesday_shift'] = $weekly_info['week_name'];
			break;
			case 5:
				$data['thursday_shift'] = $weekly_info['week_name'];
			break;
			case 6:
				$data['friday_shift'] = $weekly_info['week_name'];
			break;
			case 7:
				$data['saturday_shift'] = $weekly_info['week_name'];
			break;

		}
	}

	$this->load->vars($data);

	$this->load->helper('form');
	$this->load->helper('file');
	echo $this->load->blade('pages.detail')->with( $this->load->get_cached_vars() );
}

function edit($record_id = ''){


		parent::edit($record_id,true);

		$get_time_shift_weekly = $this->mod->get_time_shift_weekly_calendar($this->record_id);

		foreach( $get_time_shift_weekly as $weekly_info ){

			switch($weekly_info['week_no']){
				case 1:
					$data['sunday_shift'] = $weekly_info['shift_id'];
				break;
				case 2:
					$data['monday_shift'] = $weekly_info['shift_id'];
				break;
				case 3:
					$data['tuesday_shift'] = $weekly_info['shift_id'];
				break;
				case 4:
					$data['wednesday_shift'] = $weekly_info['shift_id'];
				break;
				case 5:
					$data['thursday_shift'] = $weekly_info['shift_id'];
				break;
				case 6:
					$data['friday_shift'] = $weekly_info['shift_id'];
				break;
				case 7:
					$data['saturday_shift'] = $weekly_info['shift_id'];
				break;

			}
		}

		$this->load->vars($data);

		$this->load->helper('form');
		$this->load->helper('file');
		echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );

	}}