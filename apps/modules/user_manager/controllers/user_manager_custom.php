<?php //delete me
	public function index(){
		echo $this->load->blade('list')->with( $this->load->get_cached_vars() );
		die();
	}
	