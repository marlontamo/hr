<?php //delete me
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
        switch( $this->record_id )
        {
            case 6: // Preliminary Report
            case 8: // Preliminary earnings 
            case 9: // Preliminary deductions
            case 10: // Register Report
            case 11: // Register Earnings
            case 12: // Register Deductions
            case 13: // Deduction Schedule Detail
            case 14: // ATM Registers
            case 15: // Non ATM REgisters
            case 17: // Journal Voucher
            case 18: // Payslip
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
        switch( $this->record_id )
        {
            case 6: // Preliminary Report
            case 8: // Preliminary earnings 
            case 9: // Preliminary deductions
            case 10: // Register Report
            case 11: // Register Earnings
            case 12: // Register Deductions
            case 13: // Deduction Schedule Detail
            case 14: // ATM Registers
            case 15: // Non ATM REgisters
                $data['content'] = $this->load->blade('pages.param_form_custom')->with( $this->load->get_cached_vars() );
                break;
            default;
                $data['content'] = $this->load->blade('pages.param_form')->with( $this->load->get_cached_vars() );

        }

        $data['title'] = $data['main']->report_name;
        $this->response->quick_edit_form = $this->load->view('templates/modal', $data, true);

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
                        'uitype_id' => $uitype_id[$index],
                        'table' => $table[$index],
                        'value_column' => $value_column[$index],
                        'label_column' => $label_column[$index]
                    );

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
                            $insert['filter'] = $filter[$index];
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
                    foreach($filters  as $filter)
                    {
                        $cached_filter_bracket[] = $filter['column'] . $filter['operator'] . '"' . $filter['filter'] . '" ' .$filter['logical_operator'];
                    }

                    $cached_filter[] = '('. implode( " ", $cached_filter_bracket ) .')';
                }
            }

            if(isset($_POST['report_generator_grouping']))
            {
                //reset grouping
                $this->db->where('report_id', $this->record_id);
                $this->db->delete('report_generator_grouping');

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

            if(isset($_POST['report_generator_sorting']))
            {
                //reset sorting
                $this->db->where('report_id', $this->record_id);
                $this->db->delete('report_generator_sorting');

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
        
            if( isset($_POST['report_generator_letterhead']) )
            {
                //reset letterhead
                $this->db->where('report_id', $this->record_id);
                $this->db->delete('report_generator_letterhead');

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

        $post = $_POST;
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
                }
                $filter_ctr++;
            }
        }

        if(isset( $post['filter']) )
        {
            foreach( $report['editable_filters']->result() as $row )
            {
                $filter[$row->filter_id] = $row;
            }

            foreach ($post['filter'] as $filter_id => $value) {
                if(empty($value))
                {
                    $this->response->message[] = array(
                        'message' => 'Please fillup every filter.',
                        'type' => 'warning'
                    );
                    $this->_ajax_return();
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
                }
                $filter_ctr++;
            }

            $this->load->library('parser');
            $this->parser->set_delimiters('{$', '}');
            $query = $this->mod->export_query( $report, $post['filter'] );
            
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
        
        if( isset( $_POST['get_result'] ) )
        {
            return $result;
        }

        if( $result->num_rows() > 0 )
        {
            switch( $post['file'] )
            {
                case 'excel':
                    $filename = $this->mod->export_excel( $report['main'], $report['columns'], $result );
                    break;
                case 'csv':
                    $filename = $this->mod->export_csv( $report['main'], $report['columns'], $result );
                    break;
                case 'pdf':
                    $filename = $this->mod->export_pdf( $report['main'], $report['columns'], $result );
                    break;
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
                foreach ($post['filter'] as $filter_id => $value) {
                    $row = $filter[$filter_id];
            
                    $insert = array(
                        'result_id' => $insert_id,
                        'column' => $row->column,
                        'operator' => $row->operator,
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

        $report = $this->mod->get_report( $this->input->post( 'record_id' ) );
        $query = $this->mod->export_query( $report, $_POST['filter'] );
        $result = $this->db->query($query);
        if( $result->num_rows() > 0 )
        {
            switch( $this->input->post( 'record_id' ) )
            {
                case 6: // Preliminary Report
                case 10: // Register Report
                    switch( $_POST['file'] )
                    {
                        case 'excel':
                            $filename = $this->export_excel( $report['main'], $result );
                            break;
                        case 'csv':
                            $filename = $this->mod->export_csv( $report['main'], $report['columns'], $this->db->query($query) );
                            break;
                        case 'pdf':
                            $filename = $this->export_pdf_payroll_sheet( $query, $report['main'] );
                            break;
                    }
                    break;
                case 8: // Preliminary earnings 
                case 9: // Preliminary deductions
                case 11: // Register Earnings
                case 12: // Register Deductions
                    $main_query = $this->get_main_query( $report,  $_POST['filter'] );
                    switch( $_POST['file'] )
                    {
                        case 'excel':
                            $filename = $this->export_excel( $query, $report );
                            break;
                        case 'csv':
                            $filename = $this->export_csv( $query );
                            break;
                        case 'pdf':
                            $filename = $this->export_pdf_earnings_deductions( $main_query, $report['main'] );
                            break;
                    }
                    break;            
                
                case 13: // Deduction Schedule Detail
                    switch( $_POST['file'] )
                    {
                        case 'excel':
                            $filename = $this->export_excel( $query, $report );
                            break;
                        case 'csv':
                            $filename = $this->export_csv( $query );
                            break;
                        case 'pdf':
                            $filename = $this->export_pdf_deductions_dtl( $query, $report['main'] );
                            break;
                    }
                    break;
                case 14: // ATM Registers
                case 15: // Non ATM REgisters
                    switch( $_POST['file'] )
                    {
                        case 'excel':
                            $filename = $this->export_excel( $query, $report );
                            break;
                        case 'csv':
                            $filename = $this->export_csv( $query   );
                            break;
                        case 'pdf':
                            $filename = $this->export_pdf_atm_registers( $query, $report['main'] );
                            break;
                    }
                    break;
                case 17: // Journal Voucher
                    switch( $_POST['file'] )
                    {
                        case 'excel':
                            $filename = $this->export_excel( $query, $report );
                            break;
                        case 'csv':
                            $filename = $this->export_csv( $query   );
                            break;
                        case 'pdf':
                            $filename = $this->export_pdf_journal_voucher( $query, $report['main'] );
                            break;
                    }
                    break;
                case 18; // payslip
                    switch( $_POST['file'] )
                        {
                            case 'excel':
                                $filename = $this->export_excel( $query, $report );
                                break;
                            case 'csv':
                                $filename = $this->export_csv( $query   );
                                break;
                            case 'pdf':
                                $filename = $this->export_pdf_payslip( $query, $report['main'] );
                                break;
                        }
                        break;
                    
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

    function export_pdf_payroll_sheet( $query, $report ){

        $gt_basic = 0;
        $gt_cola = 0;
        $gt_overtime = 0;
        $gt_transpo = 0;
        $gt_comm = 0;
        $gt_other_inc_taxable = 0;
        $gt_other_inc_nt = 0;
        $gt_absences = 0;
        $gt_gross_pay = 0;
        $gt_whtax = 0;
        $gt_sss_emp = 0;
        $gt_phic_emp = 0;
        $gt_hdmf_emp = 0;
        $gt_other_ded = 0;
        $gt_netpay = 0;

        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(7,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $res = $this->db->query($query);
        $header = $res->row();

        $total_no_employees = $res->num_rows();
        $allowed_count_per_page = 40;
        $page_with = $total_no_employees/$allowed_count_per_page;
        $page_floor = floor($page_with);

        $number_of_page = $page_floor;
        if($page_with > $page_floor)
        {
            $number_of_page = $page_floor + 1;
        }        
        if($total_no_employees != 0)
        {   
            $cnt = 1;
            
            for($i=1;$i<=$number_of_page; $i++)
            {  
                $html = '';

                $html .= '
                    <table>
                        <tr>
                            <td style=" width:100% ; text-align:center ; "><strong>'.$header->Company.'</strong></td>
                        </tr>
                        <tr>
                            <td style=" width:100% ; text-align:center ; "><strong>PAYROLL SHEET</strong></td>
                        </tr>
                        <tr>
                            <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : '.date("m/d/Y",strtotime($header->{'Date From'})).'  - '.date("m/d/Y",strtotime($header->{'Date To'})).'</strong></td>
                        </tr>
                        <tr>
                            <td style=" width:100% ; text-align:left ; "></td>
                        </tr>
                        <tr> 
                            <td style=" width: 5% ; text-align:left;"><strong>&nbsp;</strong></td>
                            <td style=" width:15% ; text-align:left;"><strong>&nbsp;</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 2% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 10% ; text-align:center;"><strong>OTHER INCOME</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>GROSS</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>&nbsp;</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>OTHER</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>&nbsp;</strong></td>
                        </tr>
                        <tr> 
                            <td style=" width: 5% ; text-align:left;"><strong>EMP. NO.</strong></td>
                            <td style=" width:15% ; text-align:left;"><strong>EMPLOYEE NAME</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>BASIC</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>COLA</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>OVERTIME</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>TRANSPO</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>COMM</strong></td>
                            <td style=" width: 6% ; text-align:right; font-size:6;"><strong>(TAXABLE)</strong></td>
                            <td style=" width: 6% ; text-align:right; font-size:6;"><strong>(NON-TAX)</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>ABSENCES</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>PAY</strong></td>
                            <td style=" width: 5% ; text-align:right;"><strong>WTAX</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>SSS</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>PHIC</strong></td>
                            <td style=" width: 4% ; text-align:right;"><strong>HDMF</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>DED</strong></td>
                            <td style=" width: 6% ; text-align:right;"><strong>NETPAY</strong></td>
                        </tr>
                        <tr>
                            <td style=" width:100% ; font-size:2 ; "></td>
                        </tr>
                        <tr>
                            <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                        </tr>';
                $query_res = $query;
                $limit = ($i - 1) * $allowed_count_per_page;

                $query_dtl = $query_res." LIMIT {$limit},{$allowed_count_per_page}";
                $payroll_detail_res = $this->db->query($query_dtl);
                
                $count = 0;
                $t_basic = 0;
                $t_cola = 0;
                $t_overtime = 0;
                $t_transpo = 0;
                $t_comm = 0;
                $t_other_inc_taxable = 0;
                $t_other_inc_nt = 0;
                $t_absences = 0;
                $t_gross_pay = 0;
                $t_whtax = 0;
                $t_sss_emp = 0;
                $t_phic_emp = 0;
                $t_hdmf_emp = 0;
                $t_other_ded = 0;
                $t_netpay = 0;

                foreach ($payroll_detail_res->result() as $key => $value){

                    $html .='<tr>
                                    <td style=" width: 5% ; text-align:left ">'.$value->{'Id Number'}.'</td>
                                    <td style=" width:15% ; text-align:left">'.$value->{'Full Name'}.'</td>
                                    <td style=" width: 6% ; text-align:right">'.number_format($value->Basic,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($value->Cola,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->Overtime,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($value->Transpo,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($value->Comm,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->{'Oth Inc Taxable'},2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->{'Oth Inc Nontax'},2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->Absences,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->{'Gross Pay'},2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($value->Whtax,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($value->Sss,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($value->Phic,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($value->Hdmf,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->{'Oth Ded'},2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($value->Netpay,2,'.',',').'</td>
                                </tr>';
                    $t_basic += $value->Basic;
                    $t_cola += $value->Cola;
                    $t_overtime += $value->Overtime;
                    $t_transpo += $value->Transpo;
                    $t_comm += $value->Comm;
                    $t_other_inc_taxable += $value->{'Oth Inc Taxable'};
                    $t_other_inc_nt += $value->{'Oth Inc Nontax'};
                    $t_absences += $value->Absences;
                    $t_gross_pay += $value->{'Gross Pay'};
                    $t_whtax += $value->Whtax;
                    $t_sss_emp += $value->Sss;
                    $t_phic_emp += $value->Phic;
                    $t_hdmf_emp += $value->Hdmf;
                    $t_other_ded += $value->{'Oth Ded'};
                    $t_netpay += $value->Netpay;
                    
                    $gt_basic += $value->Basic;
                    $gt_cola += $value->Cola;
                    $gt_overtime += $value->Overtime;
                    $gt_transpo += $value->Transpo;
                    $gt_comm += $value->Comm;
                    $gt_other_inc_taxable += $value->{'Oth Inc Taxable'};
                    $gt_other_inc_nt += $value->{'Oth Inc Nontax'};
                    $gt_absences += $value->Absences;
                    $gt_gross_pay += $value->{'Gross Pay'};
                    $gt_whtax += $value->Whtax;
                    $gt_sss_emp += $value->Sss;
                    $gt_phic_emp += $value->Phic;
                    $gt_hdmf_emp += $value->Hdmf;
                    $gt_other_ded += $value->{'Oth Ded'};
                    $gt_netpay += $value->Netpay;
                    
                    $count++;
                    $cnt++;
                }
                $html .='   <tr>
                                    <td style=" width:100% ; font-size:2 ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:20% ; text-align:left  ; ">Total : '.($count).'</td>
                                    <td style=" width: 6% ; text-align:right">'.number_format($t_basic,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($t_cola,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_overtime,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($t_transpo,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($t_comm,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_other_inc_taxable,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_other_inc_nt,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_absences,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_gross_pay,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($t_whtax,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($t_sss_emp,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($t_phic_emp,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($t_hdmf_emp,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_other_ded,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($t_netpay,2,'.',',').'</td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>';

                if( ( $cnt - 1 ) == $total_no_employees ){
                    $html .='   <tr><td></td></tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:20% ; text-align:left  ; ">Grand Total : '.($total_no_employees).'</td>
                                    <td style=" width: 6% ; text-align:right">'.number_format($gt_basic,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($gt_cola,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_overtime,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($gt_transpo,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($gt_comm,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_other_inc_taxable,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_other_inc_nt,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_absences,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_gross_pay,2,'.',',').'</td>
                                    <td style=" width: 5% ; text-align:right;">'.number_format($gt_whtax,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($gt_sss_emp,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($gt_phic_emp,2,'.',',').'</td>
                                    <td style=" width: 4% ; text-align:right;">'.number_format($gt_hdmf_emp,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_other_ded,2,'.',',').'</td>
                                    <td style=" width: 6% ; text-align:right;">'.number_format($gt_netpay,2,'.',',').'</td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>';
                }
                    
                
                if($count != $allowed_count_per_page)
                {
                    for ($space=1; $space <= ($allowed_count_per_page - $count); $space++) 
                    {
                        $html .= '<tr><td></td></tr>';
                    }   
                }
                $html .='   <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                </tr>
                                <tr>
                                    <td style=" width:50%  ; text-align:left   ; font-size:7  ; ">Run Date: '.date("F d, Y H:i A").'</td>
                                    <td style=" width:50%  ; text-align:right  ; font-size:7  ; ">Page '.$i.' of '.$number_of_page.'</td>
                                </tr>
                            </table>';

                $pdf->addPage('L', 'LEGAL', true); 
                $pdf->writeHTML($html, true, false, false, false, '');
                
            }
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->Output($filename, 'F');   
            return $filename;
        }
    }

    function export_pdf_earnings_deductions( $query, $report ){

        $title = $this->db->query("SELECT * FROM {$this->db->dbprefix}report_generator WHERE report_id = {$this->input->post('record_id')} ")->row();

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
        $hdr = $this->db->query($query)->row();
        $header = $query.' GROUP BY transaction_label ORDER BY transaction_label';
        $header_result = $this->db->query($header)->result();
        $header_row = $this->db->query($header)->num_rows();

        $tot_emp = $query.' GROUP BY id_number';
        $total_no_employees = $this->db->query($tot_emp)->num_rows();
        if( $header_row > 10 ){
            $allowed_count_per_page = 30;
        }
        else{
            $allowed_count_per_page = 60;
        }
        $page_with = $total_no_employees/$allowed_count_per_page;
        $page_floor = floor($page_with);

        $number_of_page = $page_floor;
        if($page_with > $page_floor)
        {
            $number_of_page = $page_floor + 1;
        }        
        if($total_no_employees != 0)
        {   
            if($header_row > 0){
                $html_h = '
                            <tr>
                                <td style=" width:100% ; text-align:center ; "><strong>'.$hdr->Company.'</strong></td>
                            </tr>
                            <tr>
                                <td style=" width:100% ; text-align:center ; "><strong>'.$title->report_name.'</strong></td>
                            </tr>
                            <tr>
                                <td style=" width:100% ; text-align:center ; "><strong>PAYROLL PERIOD : '.date("m/d/Y",strtotime($hdr->{'Date From'})).'  - '.date("m/d/Y",strtotime($hdr->{'Date To'})).'</strong></td>
                            </tr>
                            <tr>
                                <td style=" width:100% ; text-align:left ; "></td>
                            </tr>
                        </table>
                        <table>
                            <tr>
                                <td style="text-align:left; font-size:7;"><strong>EMP. NO.</strong></td>
                                <td colspan="2" style="text-align:left; font-size:7;"><strong>EMPLOYEE NAME</strong></td>';
                for ($count=0; $count < $header_row  ; $count++) { 
                    $tran_lbl = $header_result[$count]->{'Transaction Label'};
                    $html_h .='<td style="text-align:right;vertical-align:top;"><strong>'.$tran_lbl.'</strong></td>';
                }

                $html_h .='<td style="text-align:right;vertical-align:top; font-size:7;"><strong>TOTAL</strong></td>';
                $html_h .= '  </tr>';
                $gtotal_amount = 0;
                for($i=1;$i<=$number_of_page; $i++)
                {
                    $html = '<table>';
                    $html .= $html_h;
                    $html .= '<tr><td style=" width:100%; border-top:1px solid black; font-size:3;">&nbsp;</td></tr>';
                    $html .= '</table><table>';
                    
                    $query_emp = $query;
                    $limit = ($i - 1) * $allowed_count_per_page;

                    $query_dtl_emp = $query_emp." GROUP BY id_number LIMIT {$limit},{$allowed_count_per_page}";
                    $emp = $this->db->query($query_dtl_emp);

                    $count_emp = 0;
                    foreach ($emp->result() as $key => $employee) {
                        $html .='<tr>
                                    <td style="text-align:left;">'.$employee->{'Id Number'}.'</td>
                                    <td colspan = "2" style="text-align:left;">'.$employee->{'Full Name'}.'</td>';
                    
                        $dtl_result = $header_result;
                        $total_amount = 0;
                        for ($ctr2=0; $ctr2 < $header_row  ; $ctr2++) {    
                            $dtl_value = $query." AND id_number = '".$employee->{'Id Number'}."' AND transaction_label = '".$dtl_result[$ctr2]->{'Transaction Label'}."'";

                            $res_value = $this->db->query($dtl_value)->row();
                            if($res_value){
                                $html .='<td style="text-align:right;vertical-align:top;">'.($res_value->Amount != 0 ? number_format($res_value->Amount,2,'.',',') : '-' ).'</td>';
                                $total_amount += $res_value->Amount;
                            }
                            else {
                                $html .='<td style="text-align:right;vertical-align:top;"> - </td>';
                            }
                            
                        }
                        $html .='<td style="text-align:right;vertical-align:top;">'.($total_amount != 0 ? number_format($total_amount,2,'.',',') : '-' ).'</td>';
                        $html .='   </tr>';
                        $count_emp++;
                    }
                    $total_sum_value = 0;
                    $html .= '</table>';
                    if($i == $number_of_page) {
                        $html .= '<table>
                                    <tr><td style=" width:100%; border-top:1px solid black; font-size:3;">&nbsp;</td></tr>
                                    </table><table>
                                    <tr>
                                        <td colspan = "3" >Grand Total</td>';
                        $res_total = 0;

                        for ($ctr2=0; $ctr2 < $header_row  ; $ctr2++) {    

                            $dtl_total = $query." AND transaction_label = '".$dtl_result[$ctr2]->{'Transaction Label'}."'";
                            $result_total = $this->db->query($dtl_total)->result();
                            $sum_value = 0;
                            foreach ($result_total as $value) {
                                    $sum_value += $value->Amount;
                            }
                            $html .='<td style="text-align:right;vertical-align:top; font-size:7;">'.($sum_value != 0 ? number_format($sum_value,2,'.',',') : '-' ).'</td>';
                            $total_sum_value += $sum_value;
                        }
                    
                        $html .='   <td style="text-align:right;vertical-align:top;font-size:7;">'.($total_sum_value != 0 ? number_format($total_sum_value,2,'.',',') : '-' ).'</td>
                                    </tr>
                                    <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                    </tr>
                                    <tr>
                                    <td style=" width:100% ; font-size:2 ; border-top-width:1px ; "></td>
                                    </tr>';
                        if($count != $allowed_count_per_page)
                        {
                            for ($space=1; $space <= ($allowed_count_per_page - $count_emp); $space++) 
                            {
                                $html .= '<tr><td></td></tr>';
                            }   
                        }
                        $html .='   <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                                    <tr><td style=" width:100%  ;border-bottom:1px solid black; font-size:3;">&nbsp;</td></tr>
                                    <tr>
                                        <td style=" width:50%  ; text-align:left   ; font-size:7  ; " colspan="3">Run Date: '.date("F d, Y H:i A").'</td>
                                        <td style=" width:50%  ; text-align:right  ; font-size:7  ; " colspan="3">Page '.$i.' of '.$number_of_page.'</td>
                                    </tr>
                                </table>';
                    } else {
                        if($count != $allowed_count_per_page)
                        {
                            for ($space=1; $space <= ($allowed_count_per_page - $count_emp); $space++) 
                            {
                                $html .= '<tr><td></td></tr>';
                            }   
                        }
                        $html .= '<table>
                                    <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
                                    <tr><td style="border-top:1px solid black; font-size:3;"></td></tr>
                                    <tr>
                                        <td style=" width:50%  ; text-align:left   ; font-size:7  ; " colspan="3">Run Date: '.date("F d, Y H:i A").'</td>
                                        <td style=" width:50%  ; text-align:right  ; font-size:7  ; " colspan="3">Page '.$i.' of '.$number_of_page.'</td>
                                    </tr>
                                </table>';
                    }
                    if( $header_row > 10 ){
                        $pdf->addPage('L', 'LEGAL', true); 
                    } else {
                        $pdf->addPage('P', 'A4', true); 
                    }
                    $pdf->writeHTML($html, true, false, false, false, '');
                }

                $this->load->helper('file');
                $path = 'uploads/reports/' . $report->report_code .'/pdf/';
                $this->check_path( $path );
                $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
                $pdf->Output($filename, 'F');   
                return $filename;
            }
        }
    }

    function export_pdf_atm_registers( $query, $report ){

        $title = $this->db->query("SELECT * FROM {$this->db->dbprefix}report_generator WHERE report_id = {$this->input->post('record_id')} ")->row();

        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(7,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $res = $this->db->query($query);
        $header = $res->row();

        $total_no_employees = $res->num_rows();
        $allowed_count_per_page = 40;
        $page_with = $total_no_employees/$allowed_count_per_page;
        $page_floor = floor($page_with);

        $number_of_page = $page_floor;
        if($page_with > $page_floor)
        {
            $number_of_page = $page_floor + 1;
        }        
        if($total_no_employees != 0)
        {   
            for($i=1;$i<=$number_of_page; $i++)
            {  
                $html = '';
                $html .= '<table>
                                <tr>
                                    <td style=" width:50%  ; text-align:left   ; font-size:7  ; " colspan="3">Run Date: '.date("F d, Y H:i A").'</td>
                                    <td style=" width:50%  ; text-align:right  ; font-size:7  ; " colspan="3">Page '.$i.' of '.$number_of_page.'</td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td width="100%" style="text-align:center; font-size:10; "><strong>'.$header->Company.'</strong></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:center;">'.$header->Address.'</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:center; font-size:10; "><strong>'.$title->report_name.'</strong></td>
                                </tr>
                                <tr>
                                    <td width:100% style="font-size:10px;"></td>
                                </tr>
                                <tr>
                                    <td width="5%" style="text-align:left;">No.</td>
                                    <td width="20%" style="text-align:center;">Account #</td>
                                    <td width="20%" style="text-align:right;">Amount</td>
                                    <td width="1%" style="text-align:left;">&nbsp;</td>
                                    <td width="35%" style="text-align:left;">Employee Name</td>
                                    <td width="19%" style="text-align:center;">Remarks</td>
                                </tr>
                                <tr> 
                                    <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
                                </tr>
                                <tr> 
                                    <td width="100%" style="font-size:4;"></td>
                                </tr>';

                $query_res = $query;
                $limit = ($i - 1) * $allowed_count_per_page;

                $query_dtl = $query_res." LIMIT {$limit},{$allowed_count_per_page}";
                $dtl = $this->db->query($query_dtl);
                
                $Department= '';
                $amount = 0;
                $count = 0;
                $total_line = 0;
                $tot_amount = 0;
                $cnt_line = 0   ;
                foreach ($dtl->result() as $dtl_res) {
                    $html.='<tr>
                                        <td width=" 5%"  style="text-align:Left;  ">'.$cnt_line.'.</td>
                                        <td width="20%"  style="text-align:Left;  ">'.$dtl_res->{'Bank Account'}.'</td>
                                        <td width="20%"  style="text-align:right; ">'.number_format($dtl_res->Amount,2,".",",").'</td>
                                        <td width=" 1%"  style="text-align:Left;  ">&nbsp;</td>
                                        <td width="35%"  style="text-align:left;  ">'.$dtl_res->{'Full Name'}.'</td>
                                        <td width="19%"  style="text-align:left;  ">&nbsp;</td>
                                    </tr>';

                    $tot_amount += $dtl_res->Amount;
                    $Department = $dtl_res->Department;
                    $count++;
                    $cnt_line++;
                    $total_line++;
                }
                
                if($total_line != $allowed_count_per_page)
                {
                    for ($space=1; $space <= ($allowed_count_per_page - $count); $space++) 
                    {
                        $html .= '<tr><td></td></tr>';
                    }   
                }

                $html.='
                    <tr> 
                        <td width="100%" style="font-size:4;"></td>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
                    </tr>
                    <tr>
                        <td width="70%"  style="text-align:Left;"><strong>Total for this page : '.( $count - 1 ).'</strong></td>
                        <td width="30%"  style="text-align:right;"><strong>'.number_format($tot_amount,2,".",",").'</strong></td>
                    </tr>
                    </table>';

                $html .= '<table>
                            <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td width="30%"  style="text-align:left;">Prepared By: </td>
                                <td width="3%"  style="text-align:center;"></td>
                                <td width="30%"  style="text-align:left;">Checked By: </td>
                                <td width="3%"  style="text-align:center;"></td>
                                <td width="30%"  style="text-align:left;">Approved By:</td>
                                <td width="3%"  style="text-align:center;"></td>
                            </tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                                <td style="text-align:right;"></td>
                                <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                                <td style="text-align:right;"></td>
                                <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                                <td style="text-align:right;"></td>                                    
                            </tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td width="12%" style="text-align:left; ">Pay Period</td>
                                <td width="5%" style="text-align:center; "> : </td>
                                <td width="20%" style="text-align:left; "> Paydate</td>
                                <td width="63%" ></td>
                            </tr>
                            <tr>
                                <td width="12%" style="text-align:left; ">Pay Date</td>
                                <td width="5%" style="text-align:center; "> : </td>
                                <td width="20%" style="text-align:left; "> paydate </td>
                                <td width="63%" ></td>
                            </tr>
                            <tr>
                                <td width="12%" style="text-align:left; ">Pay Coverage</td>
                                <td width="5%" style="text-align:center; "> : </td>
                                <td width="20%" style="text-align:left; "> from to</td>
                                <td width="63%" ></td>
                            </tr>
                            <tr><td></td></tr><tr><td></td></tr>
                            <tr>
                                <td width="12%" style="text-align:left; ">User</td>
                                <td width="5%" style="text-align:center; "> : </td>
                                <td width="20%" style="text-align:left; "> user info </td>
                                <td width="63%" ></td>
                            </tr>
                        </table>';

                $pdf->addPage('P', 'A4', true); 
                $pdf->writeHTML($html, true, false, false, false, '');
                
            }
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->Output($filename, 'F');   
            return $filename;
        }
    }

    function export_pdf_deductions_dtl( $query, $report ){

        $cnt_line = 0;

        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(7,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $res = $this->db->query($query);
        $header = $res->row();
        $total_no_employees = $res->num_rows();
        $allowed_count_per_page = 35;
        $page_with = $total_no_employees/$allowed_count_per_page;
        $page_floor = floor($page_with);

        $number_of_page = $page_floor;
        if($page_with > $page_floor)
        {
            $number_of_page = $page_floor + 1;
        }        
        if($total_no_employees != 0)
        {   

            for($i=1;$i<=$number_of_page; $i++)
            {  
                $html = '';
                $html .= '<table>
                                <tr>
                                    <td style=" width:50%  ; text-align:left  " colspan="3">Run Date: '.date("F d, Y H:i A").'</td>
                                    <td style=" width:50%  ; text-align:right " colspan="3">Page '.$i.' of '.$number_of_page.'</td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td width="100%" style="text-align:center; font-size:10; "><strong>'.$header->Company.'</strong></td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:center;">'.$header->Address.'</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="text-align:center; font-size:10; "><strong>DEDUCTION SCHEDULE DETAIL REPORT</strong></td>
                                </tr>
                                <tr>
                                    <td width:100% style="font-size:10;"></td>
                                </tr>
                                <tr>
                                    <td width="30%" style="text-align:left;">Employee Name</td>
                                    <td width="12%" style="text-align:center;">Ref. #</td>
                                    <td width="12%" style="text-align:center;">Date</td>
                                    <td width="17%" style="text-align:center;">Advance Amount</td>
                                    <td width="12%" style="text-align:center;">Advance Granted</td>
                                    <td width="17%" style="text-align:right;">Deductions</td>
                                </tr>
                                <tr> 
                                    <td width="100%" style="font-size:1; border-bottom:1px solid black;"></td>
                                </tr>
                                <tr> 
                                    <td width="100%" style="font-size:4;"></td>
                                </tr>';

                $query_res = $query;
                $limit = ($i - 1) * $allowed_count_per_page;

                $query_dtl = $query_res." LIMIT {$limit},{$allowed_count_per_page}";
                $dtl = $this->db->query($query_dtl);
                
                $Transaction_lbl = '';
                $count = 0;
                $tot_amount = 0;
                $total_line = 0;
                $gtot_amount = 0;
                $gtot_adv_amt = 0;
                foreach ($dtl->result() as $dtl_res) {
                    
                    if( $Transaction_lbl == '' || $Transaction_lbl != $dtl_res->{'Transaction Label'} ) {
                        if($Transaction_lbl == '') {
                            $html.='<tr> 
                                        <td width="100%" style="font-size:4;"></td>
                                    </tr>
                                    <tr>
                                        <td width="100%"><strong>'.$dtl_res->{'Transaction Label'}.'</strong></td>
                                    </tr>';
                            $total_line++;
                        } else {
                            $html.='<tr> 
                                        <td width="100%" style="font-size:4;"></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"  style="text-align:right;font-size:2;"></td>
                                        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
                                        <td width="12%"  style="text-align:Left;font-size:2;"></td>
                                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"  style="text-align:right;"><strong>Total '.$label.'</strong></td>
                                        <td width=" 4%"  style="text-align:Left;"></td>
                                        <td width="17%"  style="text-align:right;"><strong> </strong></td>
                                        <td width="12%"  style="text-align:Left;"></td>
                                        <td width="17%"  style="text-align:right;"><strong>'.number_format($tot_amount,2,".",",").'</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"  style="text-align:right;font-size:2;"></td>
                                        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                                        <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ;"></td>
                                        <td width="12%"  style="text-align:Left;font-size:2;"></td>
                                        <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ; "></td>
                                    </tr>
                                    <tr> 
                                        <td width="100%" style="font-size:4;"></td>
                                    </tr>
                                    <tr>
                                        <td width="100%"><strong>'.$dtl_res->{'Transaction Label'}.'</strong></td>
                                    </tr>';
                            $total_line++;
                            $tot_amount = 0;
                        }
                    }
                    $html.='<tr>
                                <td width="30%" style="text-align:left;">'.$dtl_res->{'Full Name'}.'</td>
                                <td width="12%" style="text-align:center;">'.$dtl_res->{'Reference No'}.'</td>
                                <td width="12%" style="text-align:center;">'.$dtl_res->{'Payroll Date'}.'</td>
                                <td width="17%" style="text-align:right;"> </td>
                                <td width="12%" style="text-align:center;"> </td>
                                <td width="17%" style="text-align:right;">'.number_format($dtl_res->Amount,2,'.',',').'</td>
                            </tr>';

                    $tot_amount += $dtl_res->Amount;
                    $gtot_amount += $dtl_res->Amount;
                    $Transaction_lbl = $dtl_res->{'Transaction Label'};
                    $label = $dtl_res->{'Transaction Label'};
                    $count++;
                    $total_line++;
                }

                $html.='
                    <tr>
                            <td width="50%"  style="text-align:right;font-size:2;"></td>
                            <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                            <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
                            <td width="12%"  style="text-align:Left;font-size:2;"></td>
                            <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
                    </tr>
                    <tr>
                        <td width="50%"  style="text-align:right;"><strong>Total '.$label.'</strong></td>
                        <td width=" 4%"  style="text-align:Left;"></td>
                        <td width="17%"  style="text-align:right;"><strong> </strong></td>
                        <td width="12%"  style="text-align:Left;"></td>
                        <td width="17%"  style="text-align:right;"><strong>'.number_format($tot_amount,2,".",",").'</strong></td>
                    </tr>
                    <tr>
                        <td width="50%"  style="text-align:right;font-size:2;"></td>
                        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ;"></td>
                        <td width="12%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-bottom-width: 1px solid black ; "></td>
                    </tr>';
                
                if($total_line != $allowed_count_per_page)
                {
                    for ($space=1; $space <= ($allowed_count_per_page - $count); $space++) 
                    {
                        $html .= '<tr><td></td></tr>';
                    }   
                }

                $html.='
                    <tr> 
                        <td width="100%" style="font-size:4;"></td>
                    </tr>
                    <tr>
                        <td width="50%"  style="text-align:right;"><strong>Grand Total</strong></td>
                        <td width=" 4%"  style="text-align:Left;"></td>
                        <td width="17%"  style="text-align:right;"><strong>'.number_format($gtot_adv_amt,2,".",",").'</strong></td>
                        <td width="12%"  style="text-align:Left;"></td>
                        <td width="17%"  style="text-align:right;"><strong>'.number_format($gtot_amount,2,".",",").'</strong></td>
                    </tr>
                    <tr>
                        <td width="50%"  style="text-align:right;font-size:2;"></td>
                        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
                        <td width="12%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
                    </tr>
                    <tr>
                        <td width="50%"  style="text-align:right;font-size:2;"></td>
                        <td width=" 4%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ;"></td>
                        <td width="12%"  style="text-align:Left;font-size:2;"></td>
                        <td width="17%"  style="text-align:right;font-size:2;border-top-width: 1px solid black ; "></td>
                    </tr>
                    </table>';
                $html .= '
                    <table>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr>
                            <td width="30%"  style="text-align:left;">Prepared By: </td>
                            <td width="3%"  style="text-align:center;"></td>
                            <td width="30%"  style="text-align:left;">Checked By: </td>
                            <td width="3%"  style="text-align:center;"></td>
                            <td width="30%"  style="text-align:left;">Approved By:</td>
                            <td width="3%"  style="text-align:center;"></td>
                        </tr>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr>
                            <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:left; border-top-width: 1px solid black ; "> </td>
                            <td style="text-align:right;"></td>                                    
                        </tr>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr>
                            <td width="12%" style="text-align:left; ">Pay Period</td>
                            <td width="5%" style="text-align:center; "> : </td>
                            <td width="20%" style="text-align:left; "> Paydate </td>
                            <td width="63%" ></td>
                        </tr>
                        <tr>
                            <td width="12%" style="text-align:left; ">Pay Date</td>
                            <td width="5%" style="text-align:center; "> : </td>
                            <td width="20%" style="text-align:left; "> Paydate</td>
                            <td width="63%" ></td>
                        </tr>
                        <tr>
                            <td width="12%" style="text-align:left; ">Pay Coverage</td>
                            <td width="5%" style="text-align:center; "> : </td>
                            <td width="20%" style="text-align:left; "> From To </td>
                            <td width="63%" ></td>
                        </tr>
                        <tr><td></td></tr><tr><td></td></tr>
                        <tr>
                            <td width="12%" style="text-align:left; ">User</td>
                            <td width="5%" style="text-align:center; "> : </td>
                            <td width="20%" style="text-align:left; "> nick name </td>
                            <td width="63%" ></td>
                        </tr>
                    </table>';

                $pdf->addPage('P', 'A4', true); 
                $pdf->writeHTML($html, true, false, false, false, '');
                
            }
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->Output($filename, 'F');   
            return $filename;
        }
    }

    function export_pdf_journal_voucher( $query, $report ){

        $this->load->library('Pdf');
        $user = $this->config->item('user');

        $pdf = new Pdf();
        $pdf->SetTitle( $report->report_name );
        $pdf->SetFontSize(7,true);
        $pdf->SetAutoPageBreak(true, 5);
        $pdf->SetAuthor( $user['lastname'] .', '. $user['firstname'] . ' ' .$user['middlename'] );
        $pdf->SetDisplayMode('real', 'default');

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $res = $this->db->query($query);
        $header = $res->row();
        if( $res->num_rows() > 0 )
        {   
            $html ='';
            $html .= '<table>
                    <tr>
                        <td width="100%" style="text-align:center; font-size:10; "><strong>'.$header->Company.'</strong></td>
                    </tr>
                    <tr>
                        <td width="100%" style="text-align:center;">'.$header->Address.'</td>
                    </tr>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td width="100%" style="text-align:left; font-size:11; "><i><strong>Journal Voucher</strong></i></td>
                    </tr>
                    <tr>
                        <td style=" width:100%  ; text-align:left   ; ">System Date: '.date("m/d/y").'</td>
                    </tr>
                    <tr>
                        <td style=" width:100%  ; text-align:left   ; ">Period Coverage : '.date("m/d/y",strtotime($header->{'Date From'})).' - '.date("m/d/y",strtotime($header->{'Date To'})).'</td>
                    </tr>
                    <tr>
                        <td width:100% style="font-size:15;"></td>
                    </tr>
                    <tr>
                        <td width="4%" style="text-align:left;"></td>
                        <td width="30%" style="text-align:left; border-bottom-width: 1px solid black; "><strong>Particulars</strong></td>
                        <td width="10%" style="text-align:right; "></td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Debit</strong></td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-bottom-width: 1px solid black; "><strong>Credit</strong></td>
                    </tr>
                    <tr> 
                        <td width="100%" style="font-size:6;">&nbsp;</td>
                    </tr>';
            $total_debit = 0;
            $total_credit = 0;
            foreach ($res->result() as $dtl_res) {
                
                $html .= '<tr>
                        <td width="4%" style="text-align:left;"></td>
                        <td width="30%" style="text-align:left;">'.$dtl_res->{'Transaction Class'}.'</td>
                        <td width="10%" style="text-align:right;"></td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right;">'.( $dtl_res->Debit >= 0 ? "0.00" : number_format($dtl_res->Debit,2,'.',',') ).'</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right;">'.( $dtl_res->Credit >= 0 ? "0.00" : number_format($dtl_res->Credit,2,'.',',') ).'</td>
                    </tr>';
                $total_debit += $dtl_res->Debit;
                $total_credit += $dtl_res->Credit;
            }
            
            $html.='
                    <tr>
                        <td width="4%" style="text-align:left;">&nbsp;</td>
                        <td width="30%" style="text-align:left;">&nbsp;</td>
                        <td width="10%" style="text-align:right;">&nbsp;</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-bottom-width: 1px solid black; font-size:4; ">&nbsp;</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-bottom-width: 1px solid black; font-size:4; ">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="4%" style="text-align:left;">&nbsp;</td>
                        <td width="30%" style="text-align:left;">&nbsp;</td>
                        <td width="10%" style="text-align:right;">&nbsp;</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right;"><strong>'.number_format($total_debit,2,'.',',').'</strong></td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right;"><strong>'.number_format($total_credit,2,'.',',').'</strong></td>
                    </tr>
                    <tr>
                        <td width="4%" style="text-align:left;">&nbsp;</td>
                        <td width="30%" style="text-align:left;">&nbsp;</td>
                        <td width="10%" style="text-align:right;">&nbsp;</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-top-width: 1px solid black; font-size:4; ">&nbsp;</td>
                        <td width="3%" style="text-align:left;">&nbsp;</td>
                        <td width="20%" style="text-align:right; border-top-width: 1px solid black; font-size:4; ">&nbsp;</td>
                    </tr>';
            
            if( $res->num_rows() < 50 ){
                for ($space=1; $space <= ( 50 - $res->num_rows() ); $space++) 
                {
                    $html .= '<tr><td></td></tr>';
                } 
            }
            $html .= '
                    <tr>
                        <td width="30%"  style="text-align:left;">Prepared By: </td>
                        <td width="3%"  style="text-align:center;"></td>
                        <td width="30%"  style="text-align:left;">Checked By: </td>
                        <td width="3%"  style="text-align:center;"></td>
                        <td width="30%"  style="text-align:left;">Approved By:</td>
                        <td width="3%"  style="text-align:center;"></td>
                    </tr>
                    <tr><td></td></tr><tr><td></td></tr>
                    <tr>
                        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                        <td style="text-align:right;"></td>
                        <td style="text-align:left; border-top-width: 1px solid black ; "></td>
                        <td style="text-align:right;"></td>                                    
                    </tr>
                </table>';

            $pdf->addPage('P', 'A4', true); 
            $pdf->writeHTML($html, true, false, false, false, '');
                
            
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->Output($filename, 'F');   
            return $filename;
        }
    }

    function export_pdf_payslip( $query, $report ){
    
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

        $result = $this->db->query($query." AND type = 'Netpay'")->result();
        
        
        $pdata['result'] = $result;
        foreach ($result as $value) {
            $pdata['earning'] = $this->db->query($query." AND type = 'Earnings' AND user_id = ".$value->{'User Id'} )->result();
            $pdata['deduction'] = $this->db->query($query." AND type = 'Deductions' AND user_id = ".$value->{'User Id'} )->result();
            $pdata['result'] = $value;
            $html = $this->load->view("templates/payslip", $pdata, true);
            $pdf->SetMargins(5, 5, 5);
            $pdf->AddPage('L','P5',true);
        
            $this->load->helper('file');
            $path = 'uploads/reports/' . $report->report_code .'/pdf/';
            $this->check_path( $path );
            $filename = $path . strtotime(date('Y-m-d H:i:s')) . '-' . $report->report_code . ".pdf";
            $pdf->writeHTML($html, true, false, false, false, '');
        }
        $pdf->Output($filename, 'F');

        return $filename;
    }
	