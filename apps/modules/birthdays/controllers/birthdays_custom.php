<?php //delete me
    public function index()
    {
   
        $data['cur_year'] = date('Y');
        $data['year'] = date('Y');
        $data['prev_year'] = date('Y') - 1;
        $data['next_year'] = date('Y') + 1;
        $this->load->vars( $data );

        echo $this->load->blade('birthday_listing_custom')->with( $this->load->get_cached_vars() );
    }

    public function get_list()
    {

        $cur_month = ($this->input->post('search') ? date('m', strtotime($this->input->post('search'))) : date('m'));
        $cur_year = date('Y');

        if ($this->input->post('year') && $this->input->post('search')) {
            $cur_year = $this->input->post('year');
           
        }elseif($this->input->post('search') && !$this->input->post('year')){
            $cur_year = date('Y', strtotime($this->input->post('search')));
        }

        $year = ($this->input->post('year') ? $this->input->post('search') : date('Y'));

        if ($this->input->post('type') == 'prev'){
            $cur_month = date('m',strtotime('-1 month' .  $this->input->post('search')));
        }

        if ($this->input->post('type') == 'next'){
            $cur_month = date('m',strtotime('+1 month' .  $this->input->post('search')));
        }

        $this->_ajax_only();
        if( !$this->permission['list'] )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_permission'),
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->response->show_import_button = false;
        if( $this->input->post('page') == 1 )
        {
            $this->load->model('upload_utility_model', 'import');
            if( $this->import->get_templates( $this->mod->mod_id ) )
                $this->response->show_import_button = true;
        }

        $page = $this->input->post('page');
        $search = $cur_month;
        $page = ($page-1) * 10; //echo $page;
        $page = ($page < 0 ? 0 : $page);

        $records = $this->mod->_get_list($page, 10, $search); 
        $this->response->filter = date('F Y', strtotime($cur_year.'-'.$cur_month));
        $this->response->records_retrieve = sizeof($records);
        $this->response->list = '';
        $this->response->current_month = $cur_month;
        $this->response->year = $cur_year;
        foreach( $records as $record )
        {
        
            $parts = pathinfo($record['photo']);
            $record['photo'] = str_replace($parts['filename'], 'thumbnail/'.$parts['filename'], $record['photo']);

            $rec = array(
                'detail_url' => '',
                'edit_url' => '',
                'delete_url' => '',
                'options' => ''
            );

            $class = '';
            $class_auto = '';
            $remarks = '';
            $cur_birth_date = $cur_year.'-'.date('m-d', strtotime($record['birth_date']));
            $cur_date = date('Y-m-d');

            $rec['cur_year'] = $cur_year; //($year && $this->input->post('search')) ? $this->input->post('search') : ($this->input->post('search')) ? date('Y', strtotime($this->input->post('search'))) : date('Y');
            $rec['cur_birth_date'] = $cur_birth_date;

            $count = $this->count_days($cur_birth_date, $cur_date, $cur_year);
            $rec['days_status']  = $count['status'];
            $rec['greetings']  = $count['greetings'];

            if( $this->permission['detail'] )
            {
                $rec['detail_url'] = $this->mod->url . '/detail/' . $record['celebrant_id'];
                $rec['options'] .= '<li><a href="'.$rec['detail_url'].'"><i class="fa fa-info"></i> View</a></li>';
            }

            if( $this->permission['edit'] )
            {
                $rec['edit_url'] = $this->mod->url . '/edit/' . $record['celebrant_id'];
            }   
            
            if( isset( $this->permission['delete'] ) && $this->permission['delete'] )
            {
                $rec['delete_url'] = $this->mod->url . '/delete/' . $record['celebrant_id'];
                $rec['options'] .= '<li><a href="'.$rec['delete_url'].'"><i class="fa fa-trash-o"></i> Delete</a></li>';
            }

            $record = array_merge($record, $rec);
            
            $this->response->list .= $this->load->blade('list_template_custom', $record, true);
        }
    
        $this->_ajax_return();
    }   

    public function get_birthday_greetings(){
        
        $this->load->model('dashboard_model', 'dashboard');

        $this->_ajax_only();
        $data = array();
        
        $year = date('Y');
        $data['celebrant']['celebrant_id'] = $this->input->post('celebrant_id');
        $data['celebrant']['celebrant_name'] = $this->input->post('celebrant_name');
        $data['celebrant']['birth_date'] = $this->input->post('birth_date');

        $count = $this->count_days($this->input->post('birth_date'), date('Y-m-d'), $year);

        $data['celebrant']['greet'] = $count['greetings'];
        $data['greetings'] = $this->dashboard->getBirthdayGreetings($data['celebrant']);//print_r($data['greetings']); die();
        $this->response->greetings = $this->load->view('customs/birthday_greetings', $data, true);


        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    public function get_filter(){
        $year = $this->input->post('year');

        $cur_year = date('Y');
        $prev_year = date('Y') - 1;
        $next_year = date('Y') + 1;
        $record = array('year' => $this->input->post('year'),'prev_year' => $prev_year,'next_year' => $next_year, 'cur_year' => $cur_year);
        $this->response->html = $this->load->view('list_template_filter', $record, true);
        $this->_ajax_return();      
    } 


    public function update_greetings(){

        $this->_ajax_only();
        $data = array();
        $this->load->model('dashboard_model', 'dashboard');
        $this->current_user = $this->config->item('user');
        
        $greetings_content      = mysqli_real_escape_string($this->db->conn_id, $this->input->post('new_greetings'));
        $display_name           = $this->current_user['lastname']. ", ". $this->current_user['firstname'];

        $data['current_user']   = $this->session->userdata['user']->user_id;
        $data['user_id']        = $this->session->userdata['user']->user_id;        // THE CURRENT LOGGED IN USER 
        $data['display_name']   = $display_name;                                    // THE CURRENT LOGGED IN USER'S DISPLAY NAME
        $data['content']        = $greetings_content;                               // THE MAIN FEED BODY
        $data['birtday']        = $this->input->post('birthday');
        $data['recipient_id']   = $this->input->post('celebrant');
        $data['status']         = 'info';                                           // DANGER, INFO, SUCCESS & WARNING
        

  
        // NOW SAVE THE POSTED DATA AND GET THE INSERT ID
        $latest = $this->dashboard->newGreetingsData($data);

        // GET LATEST POSTED DATA AND RETURN IT BACK TO THE UI
        $data['latest'] = $this->dashboard->getLatestGreetingsData($latest);

        $this->response->greetings = $this->load->view('customs/greetings_only', $data, true);

        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();      
    }

    public function count_days($bdate, $date, $year)
    {
        $days = strtotime($bdate) - strtotime($date);
        $bday = $days /(60 * 60 * 24);
        $current_month = date('n');
        $bday_month = date('n', strtotime( $bdate ));
        $current_year = date('Y');
        
        switch( true )
        {
            case $current_year == $year && $current_month == $bday_month:
                switch( true )
                {
                    case $bday == 0:
                        $bdays['status'] =  'today';
                        $bdays['greetings'] = true; 
                        break;
                    case $bday == 1:
                        $bdays['status'] =  'tomorrow';
                        $bdays['greetings'] = true; 
                        break;
                    case $bday == -1:
                        $bdays['status'] =  'yesterday';
                        $bdays['greetings'] = true; 
                        break;
                    case $bday >= 2 && $bday <= 6:
                        $bdays['status'] =  abs($bday) . ' days to go';
                        $bdays['greetings'] = false; 
                        break;
                    case $bday == 7:
                        $bdays['status'] =  'next week';
                        $bdays['greetings'] = false;
                        break;
                    case $bday > 7:
                        $bdays['status'] =  abs($bday) . ' days to go';
                        $bdays['greetings'] = false; 
                        break;
                    case $bday <= -2 && $bday >= -6:
                        $bdays['status'] =  abs($bday) . ' days ago';
                        $bdays['greetings'] = true; 
                        break;
                    case $bday == -7:
                        $bdays['status'] =  'last week';
                        $bdays['greetings'] = false; 
                        break;
                    default:
                        $bdays['status'] =  'past celebrant';
                        $bdays['greetings'] = false; 
                }
                break;
            case $current_year == $year && $current_month < $bday_month: 
            case $current_year < $year:
                $bdays = array('status' => 'upcoming', 'greetings' => false);
                break;
            case $current_year == $year && $current_month > $bday_month:
            case $current_year > $year:             
                $bdays['status'] =  'past celebrant';
                $bdays['greetings'] = false;  
        }
        return $bdays;
        
    }