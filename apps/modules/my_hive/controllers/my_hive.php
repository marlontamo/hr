<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_hive extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_hive_model', 'mod');
		parent::__construct();
	}

	public function index()
	{
		if( !$this->permission['list'] )
		{
			echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
			die();
		}

		$sql_profile = "SELECT usp.* FROM {$this->db->dbprefix}users_profile usp WHERE usp.user_id = {$this->user->user_id}";
		$qry_profile = $this->db->query($sql_profile)->row_array();

		$sql_play = "SELECT pp.* FROM play_partner pp WHERE pp.user_id = {$this->user->user_id}";
		$qry_play = $this->db->query($sql_play)->row_array();

		$sql_badge = "SELECT ppb.* FROM play_partner_badge ppb WHERE ppb.user_id = {$this->user->user_id}";
		$qry_badge = $this->db->query($sql_badge)->result_array();

		$sql_redemption = "SELECT prb.* FROM {$this->db->dbprefix}play_redeemable prb WHERE prb.deleted = 0";
		$qry_redemption = $this->db->query($sql_redemption)->result_array();

		$data['redemptions'] = $qry_redemption;
		$data['badge_details'] = $qry_badge;
		$data['play_details'] = $qry_play;
		$data['profile'] = $qry_profile;

		$this->load->vars( $data );
		echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
	}

	function redeem_product()
	{
		$this->_ajax_only();

		$data = array();
		$record_id = $this->input->post('record_id');

		$sql_redemption = " SELECT prb.* FROM {$this->db->dbprefix}play_redeemable prb 
							WHERE prb.deleted = 0 AND prb.item_id = {$record_id} ";
		$qry_redemption = $this->db->query($sql_redemption)->row_array();

		$data['redemption'] = $qry_redemption;

		$this->load->helper('form');
		$this->load->helper('file');
		$this->response->redeem_form = $this->load->view('form/redeem', $data, true);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function save_item()
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
		$data = array();
		$record_id = $this->input->post('record_id');	

		$sp_play_redeemed = $this->db->query("CALL sp_play_redeemed('".$this->user->user_id."', '".$record_id."')");
		mysqli_next_result($this->db->conn_id);

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

}