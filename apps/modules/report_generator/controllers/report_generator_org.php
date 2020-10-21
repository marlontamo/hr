<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_generator extends MY_PrivateController
{
	public function __construct()
	{
		$this->load->model('report_generator_model', 'mod');
		parent::__construct();
        $this->lang->load( 'dashboard' );
        $this->lang->load( 'form_application_manage' );
	}

	public function add()
    {
        parent::add('', true);
        $this->after_edit_parent();
    }

    public function edit()
    {
        parent::edit('', true);
        $this->after_edit_parent();
    }

    private function after_edit_parent()
    {
        $this->load->helper('form');
        $this->load->helper('file');

        $tables = $this->db->list_tables();
        $data['tables']['0'] = 'Select...';
        foreach( $tables as $table )
        {
            $data['tables'][$table] = $table;
        }

        $data['t_count'] = 1;
        if( $this->record_id )
        {
            $this->db->where('report_id',  $this->record_id);
            $data['t_count'] = $this->db->count_all_results( 'report_generator_tables' );
            
            $report = $this->mod->get_report( $this->record_id );
            
            //set all table and column data for UI
            foreach( $report['tables'] as $table)
            {
                $columns = $this->mod->my_list_fields( $table->table );
                foreach( $columns as $column)
                {
                    $tbls[$table->alias][$table->alias.'.'.$column] = $table->alias.'.'.$column;
                    $data['tbls'][$table->alias][] = $column;
                }
            }           

            foreach( $report['tables'] as $table)
            {
                $columns = $this->mod->my_list_fields( $table->table );
                $table->join_from_columns = array();
                $fields = array();
                $table->join_to_columns = array();
                foreach( $columns as $column)
                {
                    $fields[$table->alias.'.'.$column] = $table->alias.'.'.$column;
                    $table->join_from_columns[$table->alias.'.'.$column] = $table->alias.'.'.$column;
                }

                if( $table->primary )
                {
                    $saved_table[] = $this->load->view('edit/add_primary_table', $table, true);
                }
                else{
                    $this->load->helper('form');
                    foreach($tbls as $tbl => $tbl_col)
                    {
                        if( $tbl != $table->alias )
                        {
                            $table->join_to_columns = array_merge($table->join_to_columns, $tbl_col);
                        }
                    }
                    $saved_table[] = $this->load->view('edit/add_joined_table', $table, true);      
                }
            }

            $data['saved_table'] = $saved_table;

            $formats = $this->db->get_where("report_generator_column_format", array("deleted" =>0))->result();
            foreach( $formats as $format )
            {
                $frts[$format->format_id] = $format->format;    
            }
            foreach( $report['columns'] as $column){
                $column->formats = $frts;
                $saved_column[] =  $this->load->view('edit/add_column', $column, true); 
            }

            $data['saved_column'] = $saved_column;

            $operators = $this->db->get_where('report_generator_filter_operators', array('deleted' => 0))->result();
            foreach( $operators as $operator )
            {
                $oprtrs[$operator->operator] = $operator->label;
            }
            
            if( $report['fixed_filters']->num_rows() > 0 )
            {
                foreach( $report['fixed_filters']->result() as $filter )
                {
                    $filter->operators = $oprtrs;
                    $saved_ff[] = $this->load->view('edit/add_filter', $filter, true);
                }
                $data['saved_ff'] = $saved_ff;
            }

            if( $report['editable_filters']->num_rows() > 0 )
            {
                foreach( $report['editable_filters']->result() as $filter )
                {
                    $filter->operators = $oprtrs;
                    $saved_ef[] = $this->load->view('edit/add_filter', $filter, true);
                }
                $data['saved_ef'] = $saved_ef;
            }

            if( $report['groups']->num_rows() > 0 )
            {
                foreach( $report['groups']->result() as $group )
                {
                    $saved_group[] = $this->load->view('edit/add_group', $group, true);
                }
                $data['saved_group'] = $saved_group;
            }

            if( $report['sorts']->num_rows() > 0 )
            {
                foreach( $report['sorts']->result() as $sort )
                {
                    $saved_sort[] = $this->load->view('edit/add_sort', $sort, true);
                }
                $data['saved_sort'] = $saved_sort;
            }

            $data['saved_header'] = $report['header']->template;
            $data['saved_footer'] = $report['footer']->template;
        }

        $data['uitypes'][''] = "Select...";
        $uitypes = $this->db->get_where('report_generator_filter_uitype', array('deleted' => 0));
        foreach( $uitypes->result() as $uitype )
        {
            $data['uitypes'][$uitype->uitype_id] = $uitype->uitype;
        }

        $this->load->vars( $data );
        echo $this->load->blade('pages.edit')->with( $this->load->get_cached_vars() );
    }

    function generate()
    {
        parent::edit('', true);

        $user = $this->config->item('user');
        $this->db->limit(1);
        $role_check = $this->db->get_where('report_generator_role', array('report_id' => $this->record_id, 'role_id' => $user['role_id']))->num_rows();
        if( empty($role_check) )
        {
            echo $this->load->blade('pages.insufficient_permission')->with( $this->load->get_cached_vars() );
            die();
        }

        $data = $this->mod->get_report( $this->record_id );

        $this->load->vars( $data );

        $this->load->helper('form');
        $this->load->helper('file');

        switch( $this->get_report_code( $this->input->post('record_id') ) )
        {
            case 'BDO': //Bank Remittance
                echo $this->load->blade('pages.export_custom')->with( $this->load->get_cached_vars() );
                break;
            case 'OT_ALLOWANCE': //Overtime Allowance
            case 'SSSCERT': //SSS Certificate
            case 'HDMFCERT': //Pag-Ibig Certificate
            case 'COE': //Certificate of Employment
            case 'COC': //Certificate of Contribution
            case 'BIR2316': //BIR 2316
            case 'ATTND_ADJ': //Attendance Adjustment
                echo $this->load->blade('pages.export_custom')->with( $this->load->get_cached_vars() );
                break;
            default;
                echo $this->load->blade('pages.generate')->with( $this->load->get_cached_vars() );
        }
    }

	function get_param_form()
	{
		$this->_ajax_only();

        if( !$this->permission['generate'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

		parent::edit('', true);

        $user = $this->config->item('user');
        $this->db->limit(1);
        $role_check = $this->db->get_where('report_generator_role', array('report_id' => $this->record_id, 'role_id' => $user['role_id']))->num_rows();
        if( empty($role_check) )
        {
            $this->response->message[] = array(
                'message' => 'Insufficient permission',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

		$data = $this->mod->get_report( $this->record_id );

		$this->load->vars( $data );

		$this->load->helper('form');
		$this->load->helper('file');
		switch( $this->get_report_code( $this->input->post('record_id') ) )
        {
            // 1 = hide/false and 0 show/true
            case 'NETSALARIES':
            case 'SALARIES PER DEPARTMENT':
            case 'MONTHLY_TAX_SCHED':
            case 'ALPHALIST SUMMARY':
            case 'YTD_TAX_SUMMARY':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'TERMINATION_LETTER': //Termination Letter
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYROLL_EXIT_CLEARANCE': //payroll exit clearance 
            case 'PAYROLL_MANPOWER_CHARGING': //payroll manpower charging 
            case 'PAYROLL_MANPOWER_CHARGING_SUMMARY': //payroll manpower charging summary
            case 'PAYROLL_REGISTER_POSITION_PRELIMINARY': //Payroll Register Position Preliminary
            case 'PAYROLL_REGISTER_POSITION_HISTORICAL': //Payroll Register Position Historical
            case 'SALARY_DISTRIBUTION': //Salary Distribution
            case 'OTHER_DEDUCTION': //Other Deduction
            case 'MANSTATUS': //Manpower Status
            case 'LEAVE_MONITORING': //Leave Monitoring
            case 'LMR': //Logs Monitoring Report
            case 'SL_VL_MONITORING':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'INCIDENT':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;                
            case 'AESR': // Active Employee Summary Report
            case 'AUTHORITY TO DEBIT':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;      
            case 'PAR': // Perfect Attendance Report
            case 'TARDY':          
            case 'PAYROLL REGISTER PRELIMINARY':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYROLL REGISTER HISTORICAL':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYREG_COST_CENTER':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'BANK DETAILS':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'CONTRI_LOANSUMMARY':
            case 'MONTHLYDED':
            case 'Journal Voucher':
            case 'Payslip OSI':
            case 'Payslip Bayleaf':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'Payslip Riofil':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'TAX CONTRIBUTION':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'Journal Voucher Bayleaf':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'Journal Headers Bayleaf':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'EMPLOYMENT_APPLICATION':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1,'custom' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;    
            case 'EMPLOYMENT_AGREEMENT':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1,'custom' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;                              
            case 'Journal Details Bayleaf':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
             case 'Account Code':
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'BDO': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'METROBANK': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'COE BAYLEAF': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'RELEASE WEAVER AND QUITCLAIM': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'CLEARANCE FORM': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'HIRE DATE': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'HIRE DATE': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'DAILY TIME RECORD': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'DAILY TIME RECORD OPTIMUM': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'LEAVE BALANCE DETAILED': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'LEAVE BALANCE': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PERFECT ATTENDANCE': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PARTNERS LIST': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'SIGNATORY': //Bank Remittance
                $button = array('xls' => 1, 'csv' => 0, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'LEAVE BALANCE SUMMARY': 
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'LEAVE BALANCE DETAILS REPORT': 
            case 'LEAVE_SUM':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'THIRTEEN_MONTH_BASIS': //Bank Remittance
                $button = array('xls' => 0, 'csv' => 0, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PRELIM_EARN':
            case 'PRELIM DED':
            case 'PAYREGEARN':
            case 'PAYREGDED':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            
            case 'HDMFQRT': //Pag-Ibig Quarterly
            case 'ATMREG':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'DEDSCHEDDTL':
            case 'NONATMREG':
            
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'OT_ALLOWANCE': //Overtime Allowance
            
            case 'COE': //Certificate of Employment
            case 'COC': //Certificate of Contribution
            case 'BIR2316': //BIR 2316
            case 'ATTND_ADJ': //Attendance Adjustment
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
				$data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
				break;
            case 'new_hires':
            case 'Manpower Movement Report':
            case 'attrition_report': //Attrition Report
                $button = array('xls' => 0, 'csv' => 0, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'MANCOUNT': //Manpower Count
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PRELIM': // Preliminary Report
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYREG': //Payroll Register
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYREG_PER_DEPARTMENT': //Payroll Register
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;                
            case 'SSSMR': //SSS Monthly Remittance 
            case 'HDMFMR':
            case 'PHICMRMR': //PhilHealth Monthly Remittance
            case 'PAYROLLLOAN': // Payroll Loan Report
            case 'HDMFSTLRF': //Pag-Ibig STLRF
            case 'SSSLOAN': // SSS LOAN REPORTS
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'SSSCERT': //SSS Certificate
            case 'HDMFCERT': //Pag-Ibig Certificate
            case 'PHICCERT': //Pag-Ibig Certificate
            case 'HDMFM1': //Pag-Ibig M1                
            case 'HDMFMCRF': //Pag-Ibig MCRF
            case 'HDMFP2-4': //Pag-Ibig P2 - 4
            case 'SSSR3': //SSS - R3
            case 'SSSR1A': //SSS R-1A Report
            case 'SSSR5': //SSS R5
            case 'SSSQRT': //SSS R5
            case 'PHICRF1': //PhilHealth RF1
            case 'PHICER2': //PhilHealth Er2
            case 'BIR1601C': //BIR 1601-C
            case 'PAYROLL_SUMMARY_YTD':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'SSSTD': //SSS to Disk
            case 'SSSLTD': //SSS to Disk
            case 'SSSTDR3': //SSS to R3 Disk
            case 'HDMFTD': //pagibig to disk
            case 'HDMFLTD': //pagibig loan to disk
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 1, 'txt' => 0);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'LATE': //Late Monitoring Report
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
			    break;
            case 'RESBID': //Resume Bidding
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'TAX_COMPENSATION':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'PAYROLL_PAYMENT_SUMMARY':
            case 'PAYROLL_CASH_PAYMENT':
                $button = array('xls' => 0, 'csv' => 1, 'pdf' => 1, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;
            case 'Time Record Schedule History':
                $button = array('xls' => 1, 'csv' => 1, 'pdf' => 0, 'txt' => 1);
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);
                break;                
			default;                
                $button = array('xls' => 0, 'csv' => 0, 'pdf' => 0, 'txt' => 0);
				$data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() )->with('button', $button);

		}

		$data['title'] = $data['main']->report_name;
		$this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);
        $this->response->user_id = $this->user->user_id;

		$this->response->message[] = array(
			'message' => '',
			'type' => 'success'
		);

		$this->_ajax_return();
	}

	function add_table()
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

        $data['table'] = $this->input->post('table');
        $data['join_type'] = '';
        $data['on_operator'] = '';
        $data['join_to_column'] = '';
        $data['join_to_columns'] = array();
        $data['join_from_column'] = '';
        $data['alias'] = "T".$this->input->post('t_count');

        $columns = $this->mod->my_list_fields( $this->input->post('table') );
        foreach( $columns as $column)
        {
            $fields[$data['alias'].'.'.$column] = $data['alias'].'.'.$column;
            $data['join_from_columns'][$data['alias'].'.'.$column] = $data['alias'].'.'.$column;
            $this->response->t_columns[] =  $column;
        }
        
        if( $this->input->post('primary_table') )
        {
            $this->response->table = $this->load->view('edit/add_primary_table', $data, true);
        }
        else{
            $this->load->helper('form');
            $this->response->table = $this->load->view('edit/add_joined_table', $data, true);
        }

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function add_column()
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

        $formats = $this->db->get_where("report_generator_column_format", array("deleted" =>0))->result();
        foreach( $formats as $format )
        {
            $data['formats'][$format->format_id] = $format->format; 
        }

        $data['column'] = $this->input->post('column');
        $alias = explode('.', $data['column']);
        $alias = explode('_', $alias[1]);
        $alias = implode(' ', $alias);
        $data['format_id'] = 1;
        $data['alias'] = ucwords( $alias );

        $this->load->helper('form');
        $this->response->column = $this->load->view('edit/add_column', $data, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function add_filter()
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

        $data = $_POST;
        $data['operator'] = '';
        $data['filter'] = '';
        $data['logical_operator'] = 'logical_operator';
        $data['bracket'] = '1';

        $operators = $this->db->get_where('report_generator_filter_operators', array('deleted' => 0))->result();
        foreach( $operators as $operator )
        {
            $data['operators'][$operator->operator] = $operator->label;
        }

        $this->load->helper('form');
        $this->response->filter = $this->load->view('edit/add_filter', $data, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function add_sort()
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

        $data = $_POST;
        $data['sorting'] = '';
        
        $this->load->helper('form');
        $this->response->sort = $this->load->view('edit/add_sort', $data, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function save()
    {
        parent::save(true);
        $error = true;
        if( $this->response->saved )
        {
            $error = false;
            $result = $this->mod->_get( 'edit', $this->record_id );

            if( !$this->input->post('report_generator_table') )
            {
                $this->response->message[] = array(
                    'message' => 'At least a PRIMARY TABLE is required!',
                    'type' => 'warning'
                );
                $this->_ajax_return();  
            }

            if( !$this->input->post('report_generator_columns') )
            {
                $this->response->message[] = array(
                    'message' => 'You did not specify any fields!',
                    'type' => 'warning'
                );
                $this->_ajax_return();  
            }

            //reset tables
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_role');
            $roles = $_POST['report_generator']['roles'];
            foreach( $roles as $role_id )
            {
                $insert = array(
                    'report_id' =>  $this->record_id,
                    'role_id' => $role_id
                );
            
                $this->db->insert('report_generator_role', $insert);  
            }

            //reset tables
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_tables');
        
            $tabledata = $_POST['report_generator_table'];
            $tables = $tabledata['table'];
            $primary = $tabledata['primary'];
            $alias = $tabledata['alias'];
            $join_type = $tabledata['join_type'];
            $join_from_column = $tabledata['join_from_column'];
            $on_operator = $tabledata['on_operator'];
            $join_to_column = $tabledata['join_to_column'];

            foreach( $tables as $index => $table )
            {
                $insert = array(
                    'report_id' =>  $this->record_id,
                    'table' => $table,
                    'primary' => $primary[$index],
                    'alias' => $alias[$index],
                    'join_type' => $join_type[$index],
                    'join_from_column' => $join_from_column[$index],
                    'on_operator' => $on_operator[$index],
                    'join_to_column' => $join_to_column[$index]
                );
            
                $this->db->insert('report_generator_tables', $insert);

                if( $primary[$index] )
                {
                    $cached_table[] = "FROM ". $table . " AS " . $alias[$index];
                }
                else{
                    $cached_table[] = $join_type[$index] . " " . $table . " AS " . $alias[$index] . " ON " .$join_from_column[$index] . $on_operator[$index] . $join_to_column[$index];
                }
            }

            //reset columns
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_columns');

            $columndata = $_POST['report_generator_columns'];
            $columns = $columndata['column'];
            $alias = $columndata['alias'];
            $format_id = $columndata['format_id'];

            foreach( $columns as $index => $column )
            {
                $insert = array(
                    'report_id' =>  $this->record_id,
                    'column' => $column,
                    'alias' => $alias[$index],
                    'format_id' => $format_id[$index]
                );
            
                $this->db->insert('report_generator_columns', $insert);

                switch( $format_id[$index] )
                {
                    case 2:
                        $c_select = 'DATE_FORMAT('.$column.', "%M %d, %Y")';
                        break;
                    case 3:
                        $c_select = 'DATE_FORMAT('.$column. ', "%M %d, %Y %h:%i %p")';
                        break;
                    case 4:
                        $c_select = 'DATE_FORMAT('.$column . ', "%h:%i %p")';
                        break;
                    case 6:
                        $c_select = 'IF('.$column.' = 1, "Yes", "No")';
                        break;
                    default:
                        $c_select = $column;
                }

                $cached_select[] = $c_select . ' AS "' . $alias[$index] . '"';
            }

            //reset filters
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_filters');

            if( $this->input->post('report_generator_filters') )
            {
                $fixedfiltersdata = $_POST['report_generator_filters'];
                $columns = $fixedfiltersdata['column'];
                $operator = $fixedfiltersdata['operator'];
                $filter = $fixedfiltersdata['filter'];
                $type = $fixedfiltersdata['type'];
                $logical_operator = $fixedfiltersdata['logical_operator'];
                $bracket = $fixedfiltersdata['bracket'];
                $required = $fixedfiltersdata['required'];
                $order_by = $fixedfiltersdata['order_by'];
                $filtering_only = $fixedfiltersdata['filtering_only'];
                $uitype_id = $fixedfiltersdata['uitype_id'];
                $table = $fixedfiltersdata['table'];
                $value_column = $fixedfiltersdata['value_column'];
                $label_column = $fixedfiltersdata['label_column'];
 
                foreach( $columns as $index => $column )
                {
                    $insert = array(
                        'report_id' =>  $this->record_id,
                        'column' => $column,
                        'operator' => $operator[$index],
                        'type' => $type[$index],
                        'logical_operator' => $logical_operator[$index],
                        'bracket' => $bracket[$index],
                        'required' => $required[$index],
                        'order_by' => $order_by[$index],
                        'filtering_only' => $filtering_only[$index],
                        'uitype_id' => $uitype_id[$index],
                        'table' => $table[$index],
                        'value_column' => $value_column[$index],
                        'label_column' => $label_column[$index]
                    );
                    
                    if (array_key_exists($index, $filter)){
                        switch( $uitype_id[$index] )
                        {
                            case 3:
                                $insert['filter'] = date('Y-m-d', strtotime( $filter[$index] ));
                                break;
                            case 4:
                                $insert['filter'] = date('Y-m-d H:i:s', strtotime( $filter[$index] ));
                                break;
                            case 5:
                                $insert['filter'] = date('H:i:s', strtotime( $filter[$index] ));
                                break;
                            default:
                                if (array_key_exists($index, $filter)){
                                    $insert['filter'] = $filter[$index];
                                }
                        }
                    }

                    $cached_filters[$type[$index]][$bracket[$index]][] = $insert;

                    $this->db->insert('report_generator_filters', $insert); 
                }
            }

            if(isset($cached_filters[1])){
                //put fixed filters to cache query
                foreach($cached_filters[1] as $bracket => $filters)
                {
                    $cached_filter_bracket = array();
                    $count_array = count($filters);
                    $ctr = 1;

                    foreach($filters as $filter)
                    {
                        if ($count_array == $ctr){
                            $cached_filter_bracket[] = $filter['column'] . $filter['operator'] . '"' . $filter['filter'] . '"';
                        }
                        else{
                            $cached_filter_bracket[] = $filter['column'] . $filter['operator'] . '"' . $filter['filter'] . '"' .$filter['logical_operator'];
                        }
                    }

                    $cached_filter[] = '('. implode( " ", $cached_filter_bracket ) .')';
                }
            }

            //reset grouping
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_grouping');

            if(isset($_POST['report_generator_grouping']))
            {
                $columndata = $_POST['report_generator_grouping'];
                $columns = $columndata['column'];
                foreach( $columns as $index => $column )
                {
                    $insert = array(
                        'report_id' =>  $this->record_id,
                        'column' => $column
                    );

                    $this->db->insert('report_generator_grouping', $insert);    
                }
            }

            //reset sorting
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_sorting');

            if(isset($_POST['report_generator_sorting']))
            {
                $columndata = $_POST['report_generator_sorting'];
                $columns = $columndata['column'];
                $sorting = $columndata['sorting'];
                
                foreach( $columns as $index => $column )
                {
                    $insert = array(
                        'report_id' =>  $this->record_id,
                        'column' => $column,
                        'sorting' => $sorting[$index]
                    );

                    $this->db->insert('report_generator_sorting', $insert); 
                }
            }
            //cache the main query
            $cached_query = "SELECT " . implode(",\r\n", $cached_select);
            $cached_query .= "\r\n" . implode("\r\n", $cached_table);
            if(isset( $cached_filter ))
            {
                $cached_query .= "\r\nWHERE\r\n";
                $cached_query .= implode("AND\r\n", $cached_filter);
            }
            $this->db->update("report_generator", array("main_query" =>$cached_query), array('report_id' => $this->record_id));

            //reset letterhead
            $this->db->where('report_id', $this->record_id);
            $this->db->delete('report_generator_letterhead');
                    
            if( isset($_POST['report_generator_letterhead']) )
            {
                $lhdata = $_POST['report_generator_letterhead'];
                foreach( $lhdata as $place_in => $template )
                {
                    $insert = array(
                        'report_id' =>  $this->record_id,
                        'place_in' => $place_in,
                        'template' => $template
                    );
                        
                    $this->db->insert('report_generator_letterhead', $insert);  
                }
            }


        }

        if( !$error )
        {
            $this->response->message[] = array(
                'message' => lang('common.save_success'),
                'type' => 'success'
            );
        }

        $this->_ajax_return();
    }

    function _list_options_active( $record, &$rec )
    {
        //temp remove until view functionality added
        /*if( $this->permission['detail'] )
        {
            $rec['detail_url'] = $this->mod->url . '/detail/' . $record['record_id'];
            $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
        }*/

        if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
            $rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
        }

        if( isset( $this->permission['generate'] ) && $this->permission['generate'] )
        {
            $rec['generate_url'] = $this->mod->url . '/generate/' . $record['record_id'];
        }   
        
        if( isset($this->permission['delete']) && $this->permission['delete'] )
        {
            $rec['delete_url'] = $this->mod->url . '/delete/' . $record['record_id'];
            $rec['options'] .= '<li><a href="javascript: delete_record('.$record['record_id'].')"><i class="fa fa-trash-o"></i> '.lang('common.delete').'</a></li>';
        }
    }

    function _list_options_trash( $record, &$rec )
    {
        if( isset( $this->permission['edit'] ) && $this->permission['edit'] )
        {
            $rec['edit_url'] = $this->mod->url . '/edit/' . $record['record_id'];
            $rec['quickedit_url'] = 'javascript:quick_edit( '. $record['record_id'] .' )';
        }

        if( $this->permission['restore'] )
        {
            $rec['options'] .= '<li><a href="javascript:restore_record( '. $record['record_id'] .' )"><i class="fa fa-refresh"></i> '.lang('common.restore').'</a></li>';
        }
    }

    function export()
    {
        $this->_ajax_only();

        if( !$this->permission['generate'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $post = $_POST;

        $user = $this->config->item('user');
        $this->db->limit(1);
        $role_check = $this->db->get_where('report_generator_role', array('report_id' => $post['record_id'], 'role_id' => $user['role_id']))->num_rows();
        if( empty($role_check) )
        {
            $this->response->message[] = array(
                'message' => 'Insufficient permission',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }

        ini_set('memory_limit', "512M");
        $report = $this->mod->get_report( $post['record_id'] );
        $this->load->vars( $report );
        
        $filter_ctr = 1;

        if( $report['fixed_filters']->num_rows() > 0 )
        {
            foreach( $report['fixed_filters']->result() as $row )
            {
                $params['vars']['param'.$filter_ctr] = $row->filter;
                switch( $row->uitype_id )
                {
                    case 1:
                        $label = explode( '_', $row->label_column );
                        $label = ucwords( implode( ' ', $label ) );
                        $this->db->limit(1);
                        $param_value = $this->db->get_where( $row->table, array($row->value_column => $row->filter) )->row();
                        $temp = $row->label_column;
                        $params['vars']['param'.$filter_ctr] = $param_value->$temp;
                        break;
                    case 2;
                        if( $value )
                            $params['vars']['param'.$filter_ctr] = "Yes";
                        else
                            $params['vars']['param'.$filter_ctr] = "No";

                        break;
                    case 9:
                        $label = explode( '_', $row->label_column );
                        $label = ucwords( implode( ' ', $label ) );
                        $this->db->limit(1);
                        $param_value = $this->db->get_where( $row->table, array($row->value_column => $row->filter) )->row();
                        $temp = $row->label_column;
                        $params['vars']['param'.$filter_ctr] = $param_value->$temp;
                        break;
                }
                $filter_ctr++;
            }
        }

        if(isset( $post['filter']) )
        {
            $complete_filter = $post['filter'];
            if (($this->input->post('custom') != 1 && $this->input->post('custom') == 'undefined') || $this->input->post('custom') == 0){
                foreach( $report['editable_filters']->result() as $row )
                {
                    if (!$row->filtering_only){
                        $filter[$row->filter_id] = $row;
                    }
                    else{
                        unset($post['filter'][$row->filter_id]);
                    }
                }

                foreach ($post['filter'] as $filter_id => $value) {
                    if ($value != 'all'){
/*                        if(empty($value))
                        {
                            $this->response->message[] = array(
                                'message' => 'Please fillup every filter.',
                                'type' => 'warning'
                            );
                            $this->_ajax_return();
                        }
*/
                        if(empty($value)){
                            unset($post['filter'][$filter_id]);
                        }

                        $row = $filter[$filter_id];
                        $params['vars']['param'.$filter_ctr] = $value;

                        switch( $row->uitype_id )
                        {
                            case 1:
                                $label = explode( '_', $row->label_column );
                                $label = ucwords( implode( ' ', $label ) );
                                $this->db->limit(1);
                                if($value != "all")
                                {  
        							$param_value = $this->db->get_where( $row->table, array($row->value_column => $value) )->row();
        							$temp = $row->label_column;
        							$params['vars']['param'.$filter_ctr] = $param_value->$temp;
                                }
                                break;
                            case 2;
                                if( $value )
                                    $params['vars']['param'.$filter_ctr] = "Yes";
                                else
                                    $params['vars']['param'.$filter_ctr] = "No";

                                break;
                            case 9:
                                $label = explode( '_', $row->label_column );
                                $label = ucwords( implode( ' ', $label ) );
                                $this->db->limit(1);
                                $filter_value = array_filter($value);
                                
                                if(!empty($filter_value))
                                    $this->db->where_in($row->value_column, $value);
                                // if($value != "all")
                                // {
                                    $param_value = $this->db->get( $row->table )->row();
                                    $temp = $row->label_column;

                                    $params['vars']['param'.$filter_ctr] = $param_value->$temp;
                                // }
                                break;
                        }
                        $filter_ctr++;
                    }
                }

                $this->load->library('parser');
                $this->parser->set_delimiters('{$', '}');
                $query = $this->mod->export_query( $report, $post['filter']);
            }
            else{
                $report_code = $report['main']->report_code;
                $table = $report['tables'][0]->table;
                switch ($report_code) {
                    case 'EMPLOYMENT_APPLICATION':
                        foreach ($post['filter'] as $filter_id => $value) {
                            $recruit_id = $value;
                        }                    
                        $query = "SELECT * FROM " .$table. " WHERE recruit_id = {$value} ";
                        break;
                    case 'EMPLOYMENT_AGREEMENT':
                        foreach ($post['filter'] as $filter_id => $value) {
                            $recruit_id = $value;
                        }                    
                        $query = "SELECT * FROM " .$table. " WHERE recruit_id = {$value} ";
                        break;                        
                }             
            }
        }
        else
            $query = $this->mod->export_query( $report );

        //vars for the header and footer template
        $user = $this->config->item('user');
        $params['vars']['date'] = date('M d, Y');
        $params['vars']['time'] = date('H:i a');
        $params['vars']['username'] = $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'];
        $this->load->vars($params);

        $result = $this->db->query( $query );

        // debug($result);
        if( isset( $_POST['get_result'] ) )
        {
            return $result;
        }

        if(isset($post['filter'])) {
            $post_date = array_slice($post['filter'],2);
            $posting_date = '';
            if(!empty($post_date)){
                $posting_date = $post_date[0];
            } 
        }
        
        if( $result->num_rows() > 0 )
        {
            if ($this->input->post('custom') != 1){
                switch( $post['file'] )
                {
                    case 'excel':
                        // debug($result);
                        $filename = $this->mod->export_excel( $report['main'], $report['columns'], $result, $post['filter'] );
                        break;
                    case 'csv':
                        $filename = $this->mod->export_csv( $report['main'], $report['columns'], $result );
                        break;
                    case 'pdf':
                        $filename = $this->mod->export_pdf( $report['main'], $report['columns'], $result, $complete_filter );
                        break;
                    case 'txt':
                        $filename = $this->mod->export_txt( $report['main'], $report['columns'], $result, $posting_date, $complete_filter );
                        break;
                }
            }
            else{ 
                 $report_code = $report['main']->report_code;
                switch ($report_code) {
                    case 'EMPLOYMENT_APPLICATION':
                        $filename = $this->mod->application_employment( $report['main'], $report['columns'], $result );
                        break;                    
                }
                switch ($report_code) {
                    case 'EMPLOYMENT_AGREEMENT':
                        $filename = $this->mod->employment_agreement( $report['main'], $report['columns'], $result );
                        break;                    
                }                
            }

            $insert = array(
                'report_id' => $post['record_id'],
                'filepath' => $filename,
                'file_type' => $post['file'],
                'created_by' => $this->user->user_id
            );
            $this->db->insert('report_results', $insert);
            $insert_id = $this->db->insert_id();

            //save filters
            if(isset($post['filter']))
            {   
                $filter = $post['filter'];
                foreach ($post['filter'] as $filter_id => $value) {
                    $row = $filter[$filter_id];
                    if( is_array($value) ){
                        $value = implode(',', $value);
                    }

                    $insert = array(
                        'result_id' => $insert_id,
                        'column' => (isset($row->column) ? $row->column : ''),
                        'operator' => (isset($row->operator) ? $row->operator : ''),
                        'filter' => $value
                    );
                
                    $this->db->insert('report_result_filters', $insert);
                }
            }

            $this->response->message[] = array(
                'message' => 'Download file ready.',
                'type' => 'success'
            );

            $this->response->filename = $filename;
        }
        else{
            $this->response->message[] = array(
                'message' => 'Zero results found.',
                'type' => 'warning'
            );
        }
        
        $this->_ajax_return();
           
    }

    function export_custom()
    {
        $this->_ajax_only();

        if( !$this->permission['generate'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $post = $_POST;
        $report = $this->mod->get_report( $post['record_id'] );
        $filter_ctr = 1;

        if(isset( $post['filter']) )
        {
            $complete_filter = $post['filter'];

            foreach( $report['editable_filters']->result() as $row )
            {
                if (!$row->filtering_only){
                    $filter[$row->filter_id] = $row;
                }
                else{
                    unset($post['filter'][$row->filter_id]);
                }                
            }
        }
        
        $user = $this->config->item('user');
        $this->db->limit(1);
        $role_check = $this->db->get_where('report_generator_role', array('report_id' => $_POST['record_id'], 'role_id' => $user['role_id']))->num_rows();

        if( empty($role_check) )
        {
            $this->response->message[] = array(
                'message' => 'Insufficient permission',
                'type' => 'warning'
            );

            $this->_ajax_return();
        }	

        ini_set('memory_limit', "512M");
        $report = $this->mod->get_report( $this->input->post( 'record_id' ) );
        $this->load->vars( $report );
        $this->load->library('parser');
        $this->parser->set_delimiters('{$', '}');

        $filter = (isset($post['filter'])) ? $post['filter'] : false;

        $query = $this->mod->export_query( $report,  $filter);

        $result = $this->db->query($query);

        //vars for the header and footer template
        $user = $this->config->item('user');
        $params['vars']['date'] = date('M d, Y');
        $params['vars']['time'] = date('H:i a');
        $params['vars']['username'] = $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'];
        $this->load->vars($params);

        if( $result->num_rows() > 0 )
        {
            if ( $_POST['file'] == 'excel') {
                switch ( $this->input->post( 'record_id' ) ) {
                    
                    default:
                        $filename = $this->mod->export_excel( $report['main'], $report['columns'], $result );
                        break;
                }
            }

            if ( $_POST['file'] == 'csv') {
                switch ( $this->input->post( 'record_id' ) ) {
                    
                    default:
                        $filename = $this->mod->export_csv( $report['main'], $report['columns'], $result );
                        break;
                }
            }

            if ( $_POST['file'] == 'pdf') {
                              
                switch( $this->get_report_code( $this->input->post('record_id') ) ){
                    case 'SSSCERT': //SSS Certificate
                        $_POST['report_code'] = 'SSSCERT';
                        $filename = $this->export_pdf_sss_certificate( $query, $report['main'] );
                        break;
                    case 'HDMFCERT': //Pag-Ibig Certificate
                        $_POST['report_code'] = 'HDMFCERT';
                        $filename = $this->export_pdf_pagibig_certificate( $query, $report['main'] );
                        break;
                    case 'PHICCERT': //PhilHealth Certificate
                        $_POST['report_code'] = 'PHICCERT';
                        $filename = $this->export_pdf_philhealth_certificate( $query, $report['main'] );
                        break;
                    case 29: // PhilHealth Quarterly
                        $_POST['report_code'] = '';
                        $filename = $this->export_pdf_philhealth_quarterly( $query, $report['main'] );
                        break;
                    case 'BIR2316': //BIR 2316
                        $_POST['report_code'] = 'BIR2316';
                        $filename = $this->mod->export_pdf_bir_2316( $query, $report['main'] );
                        break;
                    case 'ATTND_ADJ': //Attendance Adjustment
                        $_POST['report_code'] = 'ATTND_ADJ';
                        $filename = $this->export_pdf_attendance_adjustment( $query, $report['main'] );
                        break;
                    default:
                        $filename = $this->mod->export_pdf( $report['main'], $report['columns'], $result );
                        break;
                }
            }
            if ( $_POST['file'] == 'txt') {
                switch ( $this->input->post( 'record_id' ) ) {
                    
                    default:
                        $filename = $this->mod->export_txt( $report['main'], $report['columns'], $result, NULL, $complete_filter );
                        break;
                }
            }

            $insert = array(
                'report_id' => $this->input->post( 'record_id' ),
                'filepath' => $filename,
                'file_type' => $this->input->post( 'file' ),
                'created_by' => $this->user->user_id
            );
            $this->db->insert('report_results', $insert);
            $insert_id = $this->db->insert_id();

            //save filters
            if(isset($post['filter']))
            {
                foreach ($post['filter'] as $filter_id => $value) {
                    $row = $filter[$filter_id];
                    if( is_array($value) ){
                        $value = implode(',', $value);
                    }
            
                    // $insert = array(
                    //     'result_id' => $insert_id,
                    //     'column' => $row->column,
                    //     'operator' => $row->operator,
                    //     'filter' => $value
                    // );
                
                    //$this->db->insert('report_result_filters', $insert);
                }
            }
            
            $this->response->message[] = array(
                'message' => 'Download file ready.',
                'type' => 'success'
            );

            $this->response->filename = $filename;
        }
        else{
            $this->response->message[] = array(
                'message' => 'Zero results found.',
                'type' => 'warning'
            );
        }
        $this->_ajax_return();
    }   

    private function check_path( $path, $create = true )
    {
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

    private function get_main_query( $report, $filters = false )
	{
		if($filters)
		{
			foreach( $report['editable_filters']->result() as $row )
			{
				$filter[$row->filter_id] = $row;
			}

			foreach ($filters as $filter_id => $value) {
				$row = $filter[$filter_id];
				
				switch( $row->uitype_id )
				{
					case 3:
						$value = date('Y-m-d', strtotime( $value ));
						break;
					case 4:
						$value = date('Y-m-d H:i:s', strtotime( $value ));
						break;
					case 5:
						$value = date('H:i:s', strtotime( $value ));
						break;
				}

				$where[$row->bracket][] = $row->column . $row->operator . '"' . $value .'" ' . $row->logical_operator;
			}

			foreach( $where as $bracket => $filters )
			{
				$where_str[] = '(' . implode(' ', $filters) . ')';
			}

			if( $report['fixed_filters']->num_rows() > 0 )
				$main_query = $report['main']->main_query . " AND (" . implode(' AND ', $where_str) . ")";
			else
				$main_query = $report['main']->main_query . " WHERE " . implode(' AND ', $where_str);
		}
		else{
			$main_query = $report['main']->main_query;
		}
		return $main_query;
	}

    public function get_report_code( $record_id ){
        $res = $this->db->query("SELECT report_code FROM {$this->db->dbprefix}report_generator WHERE report_id = $record_id ")->row();
        return $res->report_code;
    }
   
    // SSS

    function export_pdf_sss_certificate( $query, $report ){
        ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $this->load->library('Pdf');
        $user = $this->config->item('user');
        
        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(12,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        
        $result = $this->db->query($query)->result_array();

        $sign = $this->db->query("SELECT up.lastname, up.firstname, up.middlename, IFNULL(p.`position`,'') as position
                            FROM {$this->db->dbprefix}users u
                            INNER JOIN {$this->db->dbprefix}users_profile up ON u.`user_id` = up.`user_id`
                            LEFT JOIN {$this->db->dbprefix}users_position p ON up.`position_id` = p.`position_id`
                            WHERE u.user_id = ".$user['user_id'])->row();
        $middlename = !empty($sign->middlename) ? substr( $sign->middlename, 0, 1).". " : "";
        $signatory = $sign->firstname.' '.$middlename.$sign->lastname;
        $position  = $sign->position;


        $pdata['result'] = $result;
        foreach ($result as $key => $value) {
            $res[$value['User Id']]['Id Number']    = $value['Id Number'];
            $res[$value['User Id']]['Title']        = $value['Title'];
            $res[$value['User Id']]['Lastname']     = $value['Lastname'];
            $res[$value['User Id']]['Firstname']    = $value['Firstname'];
            $res[$value['User Id']]['Middlename']   = $value['Middlename'];
            $res[$value['User Id']]['Full Name']    = $value['Full Name'];
            $res[$value['User Id']]['Company']      = $value['Company'];
            
            $res[$value['User Id']]['Detail'][date('m', strtotime($value['Payroll Date']))] = array( 
                            'Payroll Date'  => $value['Payroll Date'],
                            'Sss Emp'       => $value['Sss Emp'],
                            'Sss Com'       => $value['Sss Com'],
                            'Sss Ecc'        => $value['Sss Ecc'],
                            'Sbr No Sss'    => $value['Sbr No Sss'],
                            'Sbr Date Sss'  => $value['Sbr Date Sss']
                        );
        }

        foreach ($res as $val) {
            $pdata['detail'] = $val['Detail'];
            $pdata['row'] = array(
                        'Company'   => $val['Company'],
                        'Full Name' => $val['Full Name'],
                        'Title'     => $value['Title'],
                        'Lastname'  => $value['Lastname'],
                        'Middlename'=> $value['Middlename'],
                        'Firstname' => $value['Firstname'],
                        'Signatory' => $signatory,
                        'Position'  => $position
                    );
            $html = $this->load->view("templates/sss_certificate", $pdata, true);
            
            $pdf->AddPage('P','A4',true);
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->writeHTML($html, true, false, false, false, '');
        }
        
        $pdf->Output($filename, 'F');
        return $filename;
    }

    // PAGIBIG
    function export_pdf_pagibig_certificate( $query, $report ){
        ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $this->load->library('Pdf');
        $user = $this->config->item('user');
        
        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(12,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        
        $result = $this->db->query($query)->result_array();

        $sign = $this->db->query("SELECT up.lastname, up.firstname, up.middlename, IFNULL(p.`position`,'') as position
                            FROM {$this->db->dbprefix}users u
                            INNER JOIN {$this->db->dbprefix}users_profile up ON u.`user_id` = up.`user_id`
                            LEFT JOIN {$this->db->dbprefix}users_position p ON up.`position_id` = p.`position_id`
                            WHERE u.user_id = ".$user['user_id'])->row();
        $middlename = !empty($sign->middlename) ? substr( $sign->middlename, 0, 1).". " : "";
        $signatory = $sign->firstname.' '.$middlename.$sign->lastname;
        $position  = $sign->position;


        $pdata['result'] = $result;
        foreach ($result as $key => $value) {
            $res[$value['User Id']]['Id Number']    = $value['Id Number'];
            $res[$value['User Id']]['Title']        = $value['Title'];
            $res[$value['User Id']]['Lastname']     = $value['Lastname'];
            $res[$value['User Id']]['Firstname']    = $value['Firstname'];
            $res[$value['User Id']]['Middlename']   = $value['Middlename'];
            $res[$value['User Id']]['Full Name']    = $value['Full Name'];
            $res[$value['User Id']]['Company']      = $value['Company'];


            $res[$value['User Id']]['Detail'][date('m', strtotime($value['Payroll Date']))] = array( 
                            'Payroll Date'  => $value['Payroll Date'],
                            'Hdmf Emp'      => $value['Hdmf Emp'],
                            'Hdmf Com'      => $value['Hdmf Com'],
                            'Sbr No Hdmf'   => $value['Sbr No Hdmf'],
                            'Sbr Date Hdmf' => $value['Sbr Date Hdmf']
                        );
        }

        foreach ($res as $val) {
            $pdata['detail'] = $val['Detail'];
            $pdata['row'] = array(
                        'Company'   => $val['Company'],
                        'Full Name' => $val['Full Name'],
                        'Title'     => $value['Title'],
                        'Lastname'  => $value['Lastname'],
                        'Middlename'=> $value['Middlename'],
                        'Firstname' => $value['Firstname'],
                        'Signatory' => $signatory,
                        'Position'  => $position
                    );
            $html = $this->load->view("templates/hdmf_certificate", $pdata, true);
            
            $pdf->AddPage('P','A4',true);
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->writeHTML($html, true, false, false, false, '');
        }
        
        $pdf->Output($filename, 'F');
        return $filename;
    }
    
    // PHILHEALTH
    function export_pdf_philhealth_certificate($query, $report ){
        ini_set('memory_limit', '1024M');   
        ini_set('max_execution_time', 1800);
        $this->load->library('Pdf');
        $user = $this->config->item('user');
        
        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(12,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        
        $result = $this->db->query($query)->result_array();

        $sign = $this->db->query("SELECT up.lastname, up.firstname, up.middlename, IFNULL(p.`position`,'') as position
                            FROM {$this->db->dbprefix}users u
                            INNER JOIN {$this->db->dbprefix}users_profile up ON u.`user_id` = up.`user_id`
                            LEFT JOIN {$this->db->dbprefix}users_position p ON up.`position_id` = p.`position_id`
                            WHERE u.user_id = ".$user['user_id'])->row();
        $middlename = !empty($sign->middlename) ? substr( $sign->middlename, 0, 1).". " : "";
        $signatory = $sign->firstname.' '.$middlename.$sign->lastname;
        $position  = $sign->position;


        $pdata['result'] = $result;
        foreach ($result as $key => $value) {
            $res[$value['User Id']]['Id Number']    = $value['Id Number'];
            $res[$value['User Id']]['Title']        = $value['Title'];
            $res[$value['User Id']]['Lastname']     = $value['Lastname'];
            $res[$value['User Id']]['Firstname']    = $value['Firstname'];
            $res[$value['User Id']]['Middlename']   = $value['Middlename'];
            $res[$value['User Id']]['Full Name']    = $value['Full Name'];
            $res[$value['User Id']]['Company']      = $value['Company'];

            $res[$value['User Id']]['Detail'][date('m', strtotime($value['Payroll Date']))] = array( 
                            'Payroll Date'  => $value['Payroll Date'],
                            'Phic Emp'       => $value['Phic Emp'],
                            'Phic Com'       => $value['Phic Com'],
                            'Sbr No Phic'    => $value['Sbr No Phic'],
                            'Sbr Date Phic'  => $value['Sbr Date Phic']
                        );
        }

        foreach ($res as $val) {
            $pdata['detail'] = $val['Detail'];
            $pdata['row'] = array(
                        'Company'   => $val['Company'],
                        'Full Name' => $val['Full Name'],
                        'Title'     => $value['Title'],
                        'Lastname'  => $value['Lastname'],
                        'Middlename'=> $value['Middlename'],
                        'Firstname' => $value['Firstname'],
                        'Signatory' => $signatory,
                        'Position'  => $position
                    );
            $html = $this->load->view("templates/phic_certificate", $pdata, true);
            
            $pdf->AddPage('P','A4',true);
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->writeHTML($html, true, false, false, false, '');
        }
        
        $pdf->Output($filename, 'F');
        return $filename;
    }

    function export_pdf_philhealth_quarterly( $query, $report ){
        
        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(8,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdata['header'] = $this->db->query($query)->row();
        $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
        $html = $this->load->view("templates/phic_quarterly", $pdata, true);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage('L','LETTER',true);
        $background = 'uploads/payroll_report/philhealth_quarterly-1_web.jpg';
        $pdf->Image($background, 10, 10, 260, 195, 'JPG', '', '', false, 100, '', false, false, 0, false, false, false);
        $this->load->helper('file');
        $path = 'uploads/reports/' . $report->report_code .'/pdf/';
        $this->check_path( $path );
        $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
        $pdf->writeHTML($html, true, false, false, false, '');
        
        $pdf->Output($filename, 'F');

        return $filename;
    }

    function generate_certificate()
    {
        $this->_ajax_only();
        $certname = $this->input->post('certname');
        $record_id = $this->input->post('record_id');
        $data = array();

        switch($certname){
            case 'coe':
                $cert_name = "Certificate of Employment";
            break;
            case 'coc':
                $cert_name = "Certificate of Contribution";
            break;
            case 'bir2316':
                $cert_name = "BIR 2316";
            break;
        }
        $data['certname'] = $certname;
        $data['record_id'] = $record_id;

        $this->load->vars( $data );
        $this->load->helper('form');
        $this->load->helper('file');
        
        $data['title'] = 'Generate '.$cert_name;
        $data['content'] = $this->load->blade('certs.generate')->with( $this->load->get_cached_vars() );

        $this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );
        
        $this->_ajax_return();
    }

    function download_certs(){

        // $this->_ajax_only();
        $post = $_POST;
        $filename = array();
        $this->load->model('report_generator_model', 'rep_gen');
        foreach($post['users'] as $user_id){
            switch($post['certname']){
                case 'coe':
                    $filename[] = $this->rep_gen->export_coe( $user_id, $post );
                break;
                case 'coc':
                    $filename[] = $this->rep_gen->export_coc( $user_id, $post );
                break;
                case 'bir2316':
                    $bir = $this->export_pdf_bir_2316( $user_id, $post );
                    if(!empty($bir)){
                        $filename[] = $bir;
                    }    
                break;
            }
        }
        if(count($post['users']) > 1) {

            if(is_array($filename) && count($filename) > 1){
                switch($post['certname']){
                    case 'coe':
                        $path = 'uploads/reports/COE/pdf/';
                        $zipname = date('Y-m-d_Hi').'-coe.zip';
                    break;
                    case 'coc':
                        $path = 'uploads/reports/COC/pdf/';
                        $zipname = date('Y-m-d_Hi').'-coc.zip';
                    break;
                    case 'bir2316':
                        $path = 'uploads/reports/BIR2316/pdf/';
                        $zipname = date('Y-m-d_Hi').'-bir2316.zip';
                    break;
                }

                $zip = new ZipArchive;
                $zip->open($path.$zipname, ZipArchive::CREATE);
                foreach ($filename as $file) {
                  $zip->addFile( $file, substr( $file, strrpos( $file, '/' )+1 ) );
                }
                $zip->close();
                $download_file = $path . $zipname;
            } elseif(count($filename) == 1){
                $download_file = $filename[0];
            }
        } else { 
            $download_file = $filename[0];
        }
        if(!empty($download_file)) {
            $this->response->message[] = array(
                'message' => 'Download file ready.',
                'type' => 'success'
            );

            $this->response->filename = $download_file;       
        } else {
            $this->response->message[] = array(
                'message' => 'No result found.',
                'type' => 'warning'
            );
        }    
        $this->_ajax_return();
    }

    function export_pdf_bir_2316( $user_id, $post ){
        
        $_POST['background'] = 1;
        $_POST['report_code'] = 'BIR2316';
        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new myPdf();
        $pdf->SetTitle( 'BIR 2316' );
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintFooter(false);
        // $pdf->SetAutoPageBreak(true, 5);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFontSize(8,true);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage('P','FOLIO',false);
        $background = 'uploads/payroll_report/BIR_Form_2316.jpg';
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->Image($background, 0, 0, 215.9, 330.2, 'JPG', '', '', false, 100, '', false, false, 0, false, 0, false);

        $vars = array();
        // $pdata['header'] = $this->db->query($query)->row();
        // $pdata['query'] = $this->db->query($query.' ORDER BY full_name');
        // echo "<pre>";
        // print_r($user_id);
        // echo "<br>";
        // print_r($post);
        $query = "SELECT *
                    FROM payroll_bir
                    WHERE user_id = {$user_id} 
                    AND `year` = {$post['pay_year']}";
        $result = $this->db->query($query);
        if($result && $result->num_rows() > 0){
            $birData = $result->row_array();
        
            $vars['birData'] = $birData;
            $today = date('Y-m-d');
            $vars['given_date'] = date( 'jS of F Y', strtotime($today) );

            // $html = $this->load->view("templates/bir_2316", $vars, true);
            // $this->load->helper('file');

                //period
                //Year
                $year_dt = $post['pay_year']; 
                if(!empty($year_dt))
                {
                    $line = 30;
                    $yr_m_x = 43.5;   
                    //$year_dt = str_replace('-', '', $year_dt);
                    for($yr_m_s = 0 ; $yr_m_s <= strlen($year_dt); $yr_m_s++)
                    {
                        $yr_m_sub = substr($year_dt,$yr_m_s,1);
                        $pdf->MultiCell(10, 10, $yr_m_sub, 0, 'C', false, 0, $yr_m_x, $line, true, 0, false, false, 0, 'T', true);                   
                        $yr_m_x = $yr_m_x + 4;
                    }
                }
                $date_from = $birData['month_from'];
                //From
                if(!empty($date_from))
                {
                    $line = 30;
                    $fr_m_x = 141.5;   
                    $date_from = str_replace('-', '', $date_from);
                    for($fr_m_s = 0 ; $fr_m_s <= strlen($date_from); $fr_m_s++)
                    {
                        $fr_m_sub = substr($date_from,$fr_m_s,1);
                        $pdf->MultiCell(10, 10, $fr_m_sub, 0, 'C', false, 0, $fr_m_x, $line, true, 0, false, false, 0, 'T', true);                   
                        $fr_m_x = $fr_m_x + 3.5;
                    }
                }
                //To
                $date_to = $birData['month_to'];
                if(!empty($date_to))
                {
                    $line = 30;
                    $to_m_x = 181.5;   
                    $date_to = str_replace('-', '', $date_to);
                    for($to_m_s = 0 ; $to_m_s <= strlen($date_to); $to_m_s++)
                    {
                        $to_m_sub = substr($date_to,$to_m_s,1);
                        $pdf->MultiCell(10, 10, $to_m_sub, 0, 'C', false, 0, $to_m_x, $line, true, 0, false, false, 0, 'T', true);   
                        $to_m_x = $to_m_x + 3.5;
                    }
                }

                $emp_name = str_replace( '*', '', $birData['full_name']);
                $tin_id = $birData['emp_tin'];
                $reg_add = $birData['emp_address'];
                $zip_code = $birData['emp_zipcode'];
                $birth_date = $birData['birth_date'];
                $civil_status = $birData['civil_status_id'];
                
            //Tin ID
                if(!empty($tin_id))
                {
                    $line = 40;
                    $tin_id_x = 43.5;
                    $tin_id = str_replace("-", "", $tin_id);
                    for($tin_s = 0 ; $tin_s <= strlen($tin_id); $tin_s++)
                    {
                        $tin_id_sub = substr($tin_id, $tin_s,1);
                        if( in_array($tin_s, array(3, 6, 9)) ){
                            $pdf->MultiCell(10, 10, ' ', 0, 'C', false, 0, $tin_id_x, $line, true, 0, false, false, 0, 'T', true);  
                            $tin_id_x = $tin_id_x + 3.95;
                            $pdf->MultiCell(10, 10, $tin_id_sub, 0, 'C', false, 0, $tin_id_x, $line, true, 0, false, false, 0, 'T', true);  
                        }else{
                            $pdf->MultiCell(10, 10, $tin_id_sub, 0, 'C', false, 0, $tin_id_x, $line, true, 0, false, false, 0, 'T', true);  
                        } 
                        $tin_id_x = $tin_id_x + 3.95;
                    } 
                }
            //employee name
                $line = 49;
                $name_x = 18;
                $pdf->MultiCell(83, 10, $emp_name, 0, 'L', false, 0, $name_x, $line, true, 0, false, false, 0, 'T', true);   
            //permanent/registered address
                $line = 57.7;
                $regadd_x = 18;
                if(strlen($reg_add) > 40){
                    $pdf->SetFontSize(7);
                    $pdf->MultiCell(75, 10, $reg_add, 0, 'L', false, 0, $regadd_x, $line, true, 0, false, false, 0, 'T', true); 
                    $pdf->SetFontSize(10);
                }
                else{
                    $pdf->MultiCell(75, 10, $reg_add, 0, 'L', false, 0, $regadd_x, $line, true, 0, false, false, 0, 'T', true);   
                }
            //ZIP Code 6A
                if(!empty($zip_code))
                {
                    $line = 57.7;
                    $zip_code_x = 89.5;
                    for($zip_s = 0; $zip_s <= strlen($zip_code); $zip_s++ )
                    {
                        $zip_code_sub = substr($zip_code, $zip_s,1);
                        $pdf->MultiCell(10, 10,  $zip_code_sub, 0, 'C', false, 0, $zip_code_x, $line, true, 0, false, false, 0, 'T', true);   
                        $zip_code_x = $zip_code_x + 4;
                    }
                }
            //Birth Date
                // ******** BEGIN ******** //
                //for MM/DD
                    if(!empty($birth_date))
                    {
                        $line = 83.2;
                        $bday_x = 14.9;
                        $birth_date = str_replace("-", "", $birth_date);
                        for($birth_date_s = 4; $birth_date_s <= strlen($birth_date); $birth_date_s++)
                        {
                            $birth_date_sub = substr($birth_date, $birth_date_s, 1);
                            $pdf->MultiCell(10, 10, $birth_date_sub , 0, 'C', false, 0, $bday_x, $line, true, 0, false, false, 0, 'T', true);   
                            $bday_x = $bday_x + 4.3;
                        }
                    }
                //for Year
                    $birth_date_yr = date('Y',strtotime($birth_date));
                    if(!empty($birth_date_yr))
                    {
                        $line = 83.2;
                        $bday_x = 32.5;
                        for($birth_date_s = 0; $birth_date_s <= strlen($birth_date_yr); $birth_date_s++)
                        {
                            $birth_date_sub_yr = substr($birth_date_yr, $birth_date_s, 1);
                            $pdf->MultiCell(10, 10, $birth_date_sub_yr , 0, 'C', false, 0, $bday_x, $line, true, 0, false, false, 0, 'T', true);   
                            $bday_x = $bday_x + 5;
                        }
                    }
                // ********* END ********* //
            //Exempt Status
                if(!empty($civil_status))
                {
                    //$civil_status = 'M';
                    switch ($civil_status)
                    {
                        case 1: //single
                            $line = 91.15;
                            $cs_x = 32;
                            $pdf->MultiCell(10, 10, 'x', 0, 'C', false, 0, $cs_x, $line, true, 0, false, false, 0, 'T', true);   
                            break;
                        
                        case 2: //married
                            $line = 91.15;
                            $cs_x = 61.8;
                            $pdf->MultiCell(10, 10, 'x', 0, 'C', false, 0, $cs_x, $line, true, 0, false, false, 0, 'T', true);   
                            break;
                        
                        default:
                            $pdf->MultiCell(10, 10, ' ', 0, 'C', false, 0, $cs_x, $line, true, 0, false, false, 0, 'T', true);   
                            break;
                    }
                }

            //RDO Code
                $rdo_code = $birData['rdo'];
                
                if(!empty($rdo_code))
                {
                    $line = 49;
                    $rdo_code_x = 90;
                    for($rdo_s = 0; $rdo_s <= strlen($rdo_code); $rdo_s++)
                    {
                        $rdo_code_sub = substr($rdo_code, $rdo_s,1);
                        $pdf->MultiCell(10, 10, $rdo_code_sub, 0, 'C', false, 0, $rdo_code_x, $line, true, 0, false, false, 0, 'T', true);   
                        $rdo_code_x = $rdo_code_x + 5.8;
                    }
                }

            // DEPENDENT DETAILS        
                // ******** BEGIN ******** //
                $depend_res[0]['name'] = $birData['dep_name1'];
                $depend_res[0]['birth_date'] = $birData['dep_bday1'];
                $depend_res[1]['name'] = $birData['dep_name2'];
                $depend_res[1]['birth_date'] = $birData['dep_bday2'];
                $depend_res[2]['name'] = $birData['dep_name3'];
                $depend_res[2]['birth_date'] = $birData['dep_bday3'];
                $depend_res[3]['name'] = $birData['dep_name4'];
                $depend_res[3]['birth_date'] = $birData['dep_bday4'];
                foreach ($depend_res as $depends) {
                    $line = 105.4;
                    $depend_x = 18;
                    $pdf->MultiCell(70, 10, $depends['name'], 0, 'L', false, 0, $depend_x, $line, true, 0, false, false, 0, 'T', true);           

                    //dependent birth day
                    $depend_birht_date = $depends['birth_date']; 
                   
                    //MM-DD
                    
                    if(strtotime($depend_birht_date))
                    {
                        if(!empty($depend_birht_date))
                        {
                            $line = 105.4;
                            $depend_x = 72.6;   
                            $depend_birht_date = str_replace("-", "", $depend_birht_date);
                            for($depend_bday_s = 4; $depend_bday_s <= strlen($depend_birht_date); $depend_bday_s++)
                            {
                                $depend_bday_sub = substr($depend_birht_date, $depend_bday_s, 1);
                                $pdf->MultiCell(10, 10, $depend_bday_sub , 0, 'C', false, 0, $depend_x, $line, true, 0, false, false, 0, 'T', true);   
                                $depend_x = $depend_x + 4.1;
                            }
                        }
                    
                        //yearf
                        $depend_bday_year1 = date('Y', strtotime($depend_birht_date));
                        if(!empty($depend_bday_year1))
                        {
                            $line = 105.4;
                            $depend_x = 89.5;   
                            for($depend_bday_s = 0; $depend_bday_s <= strlen($depend_bday_year1); $depend_bday_s++)
                            {
                                $depend_bday_sub_y1 = substr($depend_bday_year1, $depend_bday_s, 1);
                                $pdf->MultiCell(10, 10, $depend_bday_sub_y1 , 0, 'C', false, 0, $depend_x, $line, true, 0, false, false, 0, 'T', true);   
                                $depend_x = $depend_x + 4.1;
                            }
                        }
                    }
                }
                // ********* END ********* //

                //statutory minimum wage rate per day

                $min_wage_rate_per_day = $birData['minwage_day']; 
                $line = 122;
                $min_wage_x = 74.6;
                $pdf->MultiCell(35, 10, $min_wage_rate_per_day, 0, 'R', false, 0, $min_wage_x, $line, true, 0, false, false, 0, 'T', true);   
                
                //statutory minimum wage rate per month

                $min_wage_rate_per_month = $birData['minwage_month']; 
                $line = 127.5;
                $min_wage_x = 74.6;
                $pdf->MultiCell(35, 10, $min_wage_rate_per_month, 0, 'R', false, 0, $min_wage_x, $line, true, 0, false, false, 0, 'T', true);  


            // PART II EMPLOYERS INFO
                //******** START ********//

                if(!empty($birData['comp_tin']))
                    {
                        $line = 142;
                        $tin_id_x = 43.5;
                        $employer_tin = str_replace("-", " ", $birData['comp_tin']);
                        for($tin_s = 0 ; $tin_s <= strlen($employer_tin); $tin_s++)
                        {
                            $employer_tin_sub = substr($employer_tin, $tin_s,1);
                            $pdf->MultiCell(10, 10, $employer_tin_sub, 0, 'C', false, 0, $tin_id_x, $line, true, 0, false, false, 0, 'T', true);   
                            $tin_id_x = $tin_id_x + 3.95;
                        }
                        // $pdf->MultiCell(10, 10,"0", 0, 'C', false, 0, 91.7, $line, true, 0, false, false, 0, 'T', true);   
                        // $pdf->MultiCell(10, 10,"0", 0, 'C', false, 0, 95, $line, true, 0, false, false, 0, 'T', true);   
                        // $pdf->MultiCell(10, 10,"0", 0, 'C', false, 0, 98.5, $line, true, 0, false, false, 0, 'T', true);   
                        
                    }
                $reg_company = get_registered_company();
                if(is_array($reg_company)) {
                    $company = $reg_company['registered_company'];
                }
                $line = 150.5;
                $pdf->MultiCell(100, 10, $company, 0, 'L', false, 0, 17, $line, true, 0, false, false, 0, 'T', true);  

                $company_address = $birData['comp_address']; 
                $company_zipcode = str_pad($birData['comp_zipcode'],4,"0",STR_PAD_LEFT); 
                $line = 159.5;
                if(strlen($company_address) > 40){
                    $pdf->SetFontSize(6.5);
                    $pdf->MultiCell(78, 10, $company_address, 0, 'L', false, 0, 17, $line, true, 0, false, false, 0, 'T', true); 
                    $pdf->SetFontSize(10);
                }
                else{
                    $pdf->MultiCell(50, 10, $company_address, 0, 'L', false, 0, 17, $line, true, 0, false, false, 0, 'T', true); 
                }

                $company_zipcode_x = 92.5;
                    for($tin_s = 0 ; $tin_s <= strlen($company_zipcode); $tin_s++)
                    {
                        $company_zipcode_sub = substr($company_zipcode, $tin_s,1);
                        $pdf->MultiCell(50, 10, $company_zipcode_sub, 0, 'L', false, 0, $company_zipcode_x, $line, true, 0, false, false, 0, 'T', true); 
                        $company_zipcode_x = $company_zipcode_x + 3.95;
                    }
                
                //********  END  ********//
            
            //Part IV-A SUMMARY
            
            //******** START ********//

                $item_x = 64;
            // get value

                // bonus : not included  if the paydate was January 15
                $bon_p_date = $year_dt.'-01-15';
                $item_21 = 0;
                $item_22 = 0;
                $item_23 = 0;
                $item_24 = 0;
                $item_25 = 0;
                $item_26 = 0;
                $item_28 = 0;
                $item_29 = 0;
                $item_30A = 0;
                $item_31 = 0;
                $item_32 = 0;
                $item_34 = 0;
                $item_37 = 0;
                $item_38 = 0;
                $item_39 = 0;
                $item_41 = 0;
                $item_42 = 0;
                $item_51 = 0;
                $item_53 = 0;
                $item_55 = 0;

                $item_37 = $birData['item37'];
                $item_51 = $birData['item51'];
                $item_26 = $birData['item26'];
                $item_32 = $birData['item32'];
                $item_34 = $birData['item34'];
                $item_39 = $birData['item39'];
                $item_38 = $birData['item38'];
                $item_41 = $birData['item41'];
                $item_42 = $birData['item42'];
                $item_53 = $birData['item53'];
                $item_55 = $birData['item55'];

                $item_21 = $birData['item21'];
                $item_22 = $birData['item22'];
                $item_23 = $birData['item23'];
                $item_25 = $birData['item25'];
                
                $item_28 = $birData['item28'];

                // check if minimum wage earner
                $item_29 = $birData['item29'];
                $item_30A = $birData['item30A'];
                $item_31 = $birData['item31'];

            // Item #21 = > Item #55 = Item #42 + Item #51 + Item #53
                $line = 198.5;
                $pdf->MultiCell(45, 10, ( $item_21 != "" ? number_format( $item_21 ,2,'.',',') : "0.00") , 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #22 = > Item #41 = Item #37 + Item #39 
                $line = 203.5;
                $pdf->MultiCell(45, 10, ( $item_22 != "" ? number_format( $item_22 ,2,'.',','): "0.00") , 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #23 = Item #55
                $line = 209;
                $pdf->MultiCell(45, 10, ( $item_23 != "" ? number_format( $item_23 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #24 = Previous Employer Tax
                $item24_val = ""; 
                $line = 213.8;
                $pdf->MultiCell(45, 10, ( $item24_val != "" ? number_format($item24_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #25 = Item #23 - Item #24
                $line = 219;
                $pdf->MultiCell(45, 10, ( $item_25 != "" ? number_format( $item_25 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #26 = Exemption
                $line = 224.4;
                $pdf->MultiCell(45, 10, ( $item_26 != "" ? number_format( $item_26 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #27 = 
                $item27_val = ""; 
                $line = 229.4;
                $pdf->MultiCell(45, 10, ( $item27_val != "" ? number_format($item27_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #28 = Item 25 - Item 26
                $line = 234.6;
                $pdf->MultiCell(45, 10, ( $item_28 != "" ? number_format( $item_28 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            
            // Withheld Tax will be equal to Tax Due
            // Item #29 = Tax Due
                $line = 239.8;
                $pdf->MultiCell(45, 10, ( $item_29 != "" ? number_format( $item_29 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #30A = Present Employer WTAX
                $line = 246.8;
                $pdf->MultiCell(45, 10, ( $item_30A != "" ? number_format( $item_30A ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #30B = Previous Employer WTAX
                $item30B_val = ""; 
                $line = 252.2;
                $pdf->MultiCell(45, 10, ( $item30B_val != "" ? number_format($item30B_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #31 = Tax Refund
                $line = 257.8;
                $pdf->MultiCell(45, 10, ( $item_31 != "" ? number_format( $item_31 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            //********* END *********//   7914093

         //Part IV-B Details of Compensation Income and Tax WithHeld from Present Employer
        
            //******** START ********//

            // A. Non-Taxable/Exempt Compensation Income

                $item_x = 155;
            // Item #32
                $line = 49.6;
                $pdf->MultiCell(45, 10, ( $item_32 != "" ? number_format($item_32,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #33
                $item33_val = ""; 
                $line = 60;
                $pdf->MultiCell(45, 10, ( $item33_val != "" ? number_format($item33_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #34
                $line = 67.2;
                $pdf->MultiCell(45, 10, ( $item_34 != "" ? number_format($item_34,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #35
                $item35_val = ""; 
                $line = 73.9;
                $pdf->MultiCell(45, 10, ( $item35_val != "" ? number_format($item35_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #36
                $item36_val = ""; 
                $line = 81.5;
                $pdf->MultiCell(45, 10, ( $item36_val != "" ? number_format($item36_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #37 = 13th Month Pay
                $line = 87.8;
                $pdf->MultiCell(45, 10, ( $item_37 != "" ? number_format( $item_37 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #38 = De Minimis Benefits
                $line = 96.5;
                $pdf->MultiCell(45, 10, ( $item_38 != "" ? number_format( $item_38 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #39 = Gov't Contribution
                $line = 106.3;
                $pdf->MultiCell(45, 10, ( $item_39 != "" ? number_format( $item_39 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #40
                $item40_val = ""; 
                $line = 118.8;
                $pdf->MultiCell(45, 10, ( $item40_val != "" ? number_format($item40_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #41 = Item #37 - Item #39
                $line = 128;
                $pdf->MultiCell(45, 10, ( $item_41 != "" ? number_format( $item_41 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // B. TAXABLE COMPENSATION INCOME REGULAR
            // Item #42 = Total Basic Salary
                $line = 144.9;
                $pdf->MultiCell(45, 10, ( $item_42 != "" ? number_format( $item_42 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #43
                $item43_val = ""; 
                $line = 152;
                $pdf->MultiCell(45, 10, ( $item43_val != "" ? number_format($item43_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #44
                $item44_val = ""; 
                $line = 159.1;
                $pdf->MultiCell(45, 10, ( $item44_val != "" ? number_format($item44_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #45
                $item45_val = ""; 
                $line = 165.5;
                $pdf->MultiCell(45, 10, ( $item45_val != "" ? number_format($item45_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #46
                $item46_val = ""; 
                $line = 172.1;
                $pdf->MultiCell(45, 10, ( $item46_val != "" ? number_format($item46_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #47A
                $item47A_val = ""; 
                $line = 181;
                $pdf->MultiCell(45, 10, ( $item47A_val != "" ? number_format($item47A_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #47B
                $item47B_val = ""; 
                $line = 187.8;
                $pdf->MultiCell(45, 10, ( $item47B_val != "" ? number_format($item47B_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #48
                $item48_val = ""; 
                $line = 196.2;
                $pdf->MultiCell(45, 10, ( $item48_val != "" ? number_format($item48_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #49
                $item49_val = ""; 
                $line = 203.7;
                $pdf->MultiCell(45, 10, ( $item49_val != "" ? number_format($item49_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #50
                $item50_val = ""; 
                $line = 211.6;
                $pdf->MultiCell(45, 10, ( $item50_val != "" ? number_format($item50_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #51 = 13th Month > 30K
                $line = 219.1;
                $pdf->MultiCell(45, 10, ( $item_51 != "" ? number_format( $item_51 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #52
                $item52_val = ""; 
                $line = 227.6;
                $pdf->MultiCell(45, 10, ( $item52_val != "" ? number_format($item52_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #53 = Overtime
                $line = 234.9;
                $pdf->MultiCell(45, 10, ( $item_53 != "" ? number_format( $item_53,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #54A
                $item54A_val = ""; 
                $line = 245.1;
                $pdf->MultiCell(45, 10, ( $item54A_val != "" ? number_format($item54A_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #54B
                $item54B_val = ""; 
                $line = 250.9;
                $pdf->MultiCell(45, 10, ( $item54B_val != "" ? number_format($item54B_val,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   
            // Item #55 = Item #42 + Item #51 + Item #53
                $line = 257.2;
                $pdf->MultiCell(45, 10, ( $item_55 != "" ? number_format( $item_55 ,2,'.',',') : "0.00" ), 0, 'R', false, 0, $item_x, $line, true, 0, false, false, 0, 'T', true);   

            //********* END *********//   

         // SIGNATURE
                $pdf->SetFontSize(6.5);
                // $a_name = $this->db->query("SELECT CONCAT(lastname, ', ', firstname, ' ', middleinitial) as name FROM {$this->db->dbprefix}user WHERE user_id = $authorized_id")->row();
                $hr_qry = "SELECT upr.firstname, upr.lastname, pos.position 
                            FROM {$this->db->dbprefix}users_profile upr
                            LEFT JOIN {$this->db->dbprefix}users_position pos 
                                ON upr.position_id = pos.position_id
                            WHERE upr.user_id = {$post['signatory']}";
                $hr = $this->db->query($hr_qry)->row_array();
                $authorized_name = $hr['firstname'].' '.$hr['lastname'];
                $vars['signatory_position'] = $hr['position'];
            //item 56
                $line = 267;
                $pdf->MultiCell(70, 10, $authorized_name, 0, 'C', false, 0, 29, $line, true, 0, false, false, 0, 'T', true);  
            
            //item 57
                $line = 274.5;
                $pdf->MultiCell(70, 10, $emp_name, 0, 'C', false, 0, 29, $line, true, 0, false, false, 0, 'T', true);  

             //item 58
                $line = 297.2;
                $pdf->MultiCell(70, 10, $authorized_name, 0, 'C', false, 0, 29, $line, true, 0, false, false, 0, 'T', true); 

            //item 59
                $line = 304.5;
                $pdf->MultiCell(60, 10, $emp_name, 0, 'C', false, 0, 124.8, $line, true, 0, false, false, 0, 'T', true);  


            $path = 'uploads/reports/BIR2316/pdf/';
            $this->check_path( $path );
            $filename = $path .date('Y-m-d_Hi').str_replace("ñ","n",$birData['full_name']). "-".'BIR2316' .".pdf";
            // $pdf->writeHTML($html, true, false, false, false, '');        
            $pdf->Output($filename, 'F');

                $insert = array(
                    'report_id' => $post['record_id'],
                    'filepath' => $filename,
                    'file_type' => 'pdf',
                    'created_by' => $this->user->user_id
                );
                $this->db->insert('report_results', $insert);
                $insert_id = $this->db->insert_id();
            
            return $filename;
        } else {
            return "";
        }

    }

    function export_pdf_attendance_adjustment( $query, $report ){
        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(8,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );  
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdata['query'] = $this->db->query($query.' ORDER BY `full_name`, `payroll_date`, `date`, `transaction_label`');
        $html = $this->load->view("templates/attendance_adjustment", $pdata, true);
        $pdf->SetMargins(5, 5, 5);
        $pdf->AddPage('P','A4',true);
        $this->load->helper('file');
        $path = 'uploads/reports/' . $report->report_code .'/pdf/';
        $this->check_path( $path );
        $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
        $pdf->writeHTML($html, true, false, false, false, '');
        
        $pdf->Output($filename, 'F');

        return $filename;
    } 

    function update_department()
    {
        $company = '';
        $this->_ajax_only();
        $company_id = $this->input->post('company_id');
        if(!empty($company_id) ){
            if(is_array($company_id)){
                $comp_arr = array();
                foreach ($company_id as $comp) 
                {
                    $comp_arr[] = $comp;    
                }
                $company_id = implode(',', $comp_arr);
                $company = ' AND a.company_id IN ('.$company_id.') ';
            }
            if(!is_array($company_id) && $company_id != 'all'){
                $company = ' AND a.company_id = '.$company_id;
            }

        }

        
		$departments = $this->db->query('SELECT DISTINCT a.company_id, b.department_id, c.department
										 FROM ww_payroll_partners a, ww_users_profile b, ww_users_department c
										 WHERE a.user_id=b.user_id AND c.department_id=b.department_id '.$company);

										 $this->response->departments = '<option value="" selected="selected">Select...</option>';
        foreach( $departments->result() as $department )
        {
            $this->response->departments .= '<option value="'.$department->department_id.'">'.$department->department.'</option>';
        }
        $this->_ajax_return();  
    }

    function update_partners()
    {
        $company = '';
        $this->_ajax_only();
        $company_id = $this->input->post('company_id');
        if(!empty($company_id) ){
            if(is_array($company_id)){
                $comp_arr = array();
                foreach ($company_id as $comp) 
                {
                    $comp_arr[] = $comp;    
                }
                $company_id = implode(',', $comp_arr);
                $company = ' AND a.company_id IN ('.$company_id.') ';
            }
            if(!is_array($company_id) && $company_id != 'all'){
                $company = ' AND a.company_id = '.$company_id;
            }

        }

        
        $users = $this->db->query('SELECT DISTINCT a.user_id, a.full_name
                                 FROM ww_users a
                                 WHERE a.deleted = 0 '.$company. " 
                                 ORDER BY a.full_name ASC");

        $this->response->users = '<option value="" selected="selected">Select...</option>';
        foreach( $users->result() as $user )
        {
            $this->response->users .= '<option value="'.$user->user_id.'">'.$user->full_name.'</option>';
        }
        $this->_ajax_return();  
    }
}
