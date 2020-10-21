<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_payslip extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('my_payslip_model', 'mod');
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

        $data['payslip'] = isset($this->permission['list']) ? $this->permission['list'] : 0;
        $this->load->model('my_contribution_model', 'contribution');
        $data['contribution'] = isset($permission[$this->contribution->mod_code]['list']) ? $permission[$this->contribution->mod_code]['list'] : 0;
        $this->load->model('my_tax_model', 'tax');
        $data['tax'] = isset($permission[$this->tax->mod_code]['list']) ? $permission[$this->tax->mod_code]['list'] : 0;
        $this->load->model('my_loans_model', 'loan');
        $data['loan'] = isset($permission[$this->loan->mod_code]['list']) ? $permission[$this->loan->mod_code]['list'] : 0;

        $this->load->vars($data);        
        echo $this->load->blade('pages.listing')->with( $this->load->get_cached_vars() );
    }

    function _list_options_active( $record, &$rec )
    {
        //temp remove until view functionality added
        if( $this->permission['detail'] )
        {
            $rec['detail_url'] = $this->mod->url . '/generate/' . $record['record_id'].'/'.$record['payroll_date'];
            $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
        }
    }

    function check_password()
    {
        $this->_ajax_only();

        $data = array();
        $this->load->helper('form');
        $view['title'] = 'Batch Transaction Upload';
        $view['content'] = $this->load->view('edit/my_payslip_password', $data, true);
        
        $this->response->my_payslip_password = $this->load->view('templates/my_payslip_password_modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function check_details()
    {
        $this->_ajax_only();

        $data = array();

        $record_id = $this->input->post('record_id');
        $payroll_date = $this->input->post('payroll_date');
        
        $this->db->select('*');
        $this->db->from('time_record_process');
        $this->db->join('payroll_transaction','payroll_transaction.transaction_id = time_record_process.transaction_id');
        $this->db->where('time_record_process.deleted', 0);
        $this->db->where('time_record_process.user_id', $record_id);
        $this->db->where('time_record_process.payroll_date', $payroll_date);
        $data['details'] = $this->db->get()->result_array();

        $this->load->helper('form');
        $view['title'] = '';
        $view['content'] = $this->load->view('edit/my_payslip_details', $data, true);
        
        $this->response->my_payslip_password = $this->load->view('templates/my_payslip_details_modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }
  
    function validate_password() {
        $this->_ajax_only();
        $record_id = $_POST['record_id'];
        $payroll_date = $_POST['payroll_date'];
        $password = $_POST['password'];
        $this->load->library('phpass');

        $this->db->where('deleted', 0);
        $this->db->where('user_id', $record_id );
        $this->db->select('user_id, hash');
        $user = $this->db->get('users')->row();
        
        if ($this->phpass->check($password , $user->hash)){
            
            $filename = $this->generate_payslip( $record_id, $payroll_date, $password );

            $this->response->message[] = array(
                'message' => 'Download file ready.',
                'type' => 'success'
            );

            $this->response->filename = $filename;
        }
        else{
             $this->response->message[] = array(
                'message' => 'Incorrect Password!.',
                'type' => 'warning'
            );
        }
        $this->_ajax_return();
    }

    function generate_payslip( $record_id , $payroll_date, $password ){
        
        $query = "SELECT * FROM partner_payslip WHERE user_id = {$record_id} AND payroll_date = '{$payroll_date}' ";
        $this->load->library('Pdf');
        $user = $this->config->item('user');
       
        $pdf = new Pdf();
        $pdf->SetProtection(array('print', 'copy'), $password, null, 0, null);
        $pdf->SetTitle( 'My Payslip' );
        $pdf->SetFontSize(8,true);
        $pdf->SetAutoPageBreak(true, 5);
        // $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
        $pdf->SetDisplayMode('real', 'default');

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $result = $this->db->query($query." AND type = 'Netpay' ")->result();
        
        foreach ($result as $value) {
            $pdata['query'] = $query; 
            $pdata['value'] = $value;
            $html = $this->load->view("templates/mypayslip_abraham", $pdata, true);
            $pdf->SetMargins(5, 0, 5);
            $pdf->AddPage('L','P5',true);
            $this->load->helper('file');
            $path = 'uploads/reports/mypayslip/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $record_id. ".pdf";
            $pdf->writeHTML($html, true, false, true, false, '');
        }
        
        $pdf->Output($filename, 'F');
        return $filename;
    }

    private function check_path( $path, $create = true ){
        if( !is_dir( FCPATH . $path ) ){
            if( $create )
            {
                $folders = explode('/', $path);
                $cur_path = FCPATH;
                foreach( $folders as $folder )
                {
                    $cur_path .= $folder;

                    if( !is_dir( $cur_path ) )
                    {
                        mkdir( $cur_path, 0777, TRUE);
                        $indexhtml = read_file( APPPATH .'index.html');
                        write_file( $cur_path .'/index.html', $indexhtml);
                    }

                    $cur_path .= '/';
                }
            }
            return false;
        }
        return true;
    }
}