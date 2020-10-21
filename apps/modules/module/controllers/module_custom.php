<?php //delete me
    function save()
    {
        parent::save( true );
        
        $error = true;
        if( $this->response->saved )
        {
            $error = false;
            $result = $this->mod->_get( 'edit', $this->record_id );
            $mod = $result->row_array();

            if( !empty( $mod['modules.mod_code'] ) )
            {
                //create module folders
                $this->load->helper('file');
                $mod_path = APPPATH . 'modules/'. $mod['modules.mod_code'] .'/';

                if( !is_dir( $mod_path ) )
                {
                    mkdir( $mod_path, 0777, TRUE);
                    $indexhtml = read_file( APPPATH .'index.html');
                    write_file($mod_path.'index.html', $indexhtml);
                }

                //other folders
                $subfolders = array(
                    'controllers/',
                    'config/',
                    'views/',
                    'views/edit/',
                    'views/edit/fgs/'
                );

                foreach( $subfolders as $subfolder )
                {
                    $paths[$subfolder] = $mod_path . $subfolder;
                    if( !is_dir( $mod_path . $subfolder ) )
                    {
                        mkdir( $mod_path . $subfolder, 0777, TRUE);
                        if(!isset( $indexhtml ))
                        {
                            $indexhtml = read_file( APPPATH .'index.html'); 
                        }
                        write_file($mod_path . $subfolder.'index.html', $indexhtml);  
                    }  
                }

                //create files
                $this->mod->create_controller( $mod['modules.mod_code'] );
                $this->mod->create_model( $mod );
                $this->mod->create_field_configs( $mod );               
            
                //save list template 
                $to_write = $mod['modules.list_template_header'];
                $list_template_header = APPPATH . 'modules/'. $mod['modules.mod_code'] .'/views/list_template_header.blade.php';
                write_file($list_template_header, $to_write);

                $to_write = $mod['modules.list_template'];
                $list_template = APPPATH . 'modules/'. $mod['modules.mod_code'] .'/views/list_template.blade.php';
                write_file($list_template, $to_write);

                $to_write = '';
                $list_filter = APPPATH . 'modules/'. $mod['modules.mod_code'] .'/views/list_filter.blade.php';
                write_file($list_filter, $to_write);

                //add to routes
                $this->mod->create_routes();

                //delete access rights file for admin
                $this->db->delete('profiles_permission', array('profile_id' => 1));
                $actions = $this->db->get_where('modules_actions', array('deleted' => 0));
                $modules = $this->db->get_where('modules', array('deleted' => 0));
                foreach( $modules->result() as $mod )
                {
                    foreach ($actions->result() as $action)
                    {
                        $this->db->insert('profiles_permission', array('profile_id' => 1, 'mod_id' => $mod->mod_id, 'action_id' => $action->action_id, 'grant' => 1));
                    }
                }
                
                $permission = APPPATH . 'config/roles/1/permission.php';
                if( file_exists($permission) )
                {
                    unlink( $permission );
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

    function get_fg_list()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $mod_id = $this->input->post('mod_id');

        if( !$mod_id )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_data'),
                'type' => 'error'
            );
            $this->_ajax_return();
        }

        $record_check = $this->mod->_exists( $mod_id );
        if( $record_check !== true )
        {
            $this->response->message[] = array(
                'message' => 'The module you are requesting does not exists and/or has been deleted.',
                'type' => 'error'
            );
            $this->_ajax_return();   
        }

        $result = $this->mod->_get( 'edit', $mod_id );
        $mod = $result->row_array();
        require( APPPATH . 'modules/'. $mod['modules.mod_code'] .'/config/field_groups.php' );
        $fgs = $config['fieldgroups'];

        $this->response->fgs = '';

        foreach( $fgs as $fg_id => $fg )
        {
            $fg['mod_id'] = $mod_id;
            $this->response->fgs .= $this->load->blade('templates/fg_list_edit', $fg, true);
        }

        $this->_ajax_return();
    }

    function get_f_list()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $mod_id = $this->input->post('mod_id');

        if( !$mod_id )
        {
            $this->response->message[] = array(
                'message' => lang('common.insufficient_data'),
                'type' => 'error'
            );
            $this->_ajax_return();
        }

        $record_check = $this->mod->_exists( $mod_id );
        if( $record_check !== true )
        {
            $this->response->message[] = array(
                'message' => 'The module you are requesting does not exists and/or has been deleted.',
                'type' => 'error'
            );
            $this->_ajax_return();   
        }

        $uitype = array();
        $uitypes = $this->db->get_where('uitypes', array('deleted' => 0));
        foreach( $uitypes->result() as $ui )
        {
            $uitype[$ui->uitype_id] = $ui->uitype;
        }

        $result = $this->mod->_get( 'edit', $mod_id );
        $mod = $result->row_array();

        require( APPPATH . 'modules/'. $mod['modules.mod_code'] .'/config/field_groups.php' );
        $fieldgroups = $config['fieldgroups'];

        require( APPPATH . 'modules/'. $mod['modules.mod_code'] .'/config/fields.php' );
        $fields = $config['fields'];

        $this->response->fields = '';
        foreach( $fields as $fg_id => $fs )
        {
            foreach( $fs as $f_name => $field )
            {
                $field['mod_id'] = $mod_id;
                $field['uitype'] = $uitype[$field['uitype_id']];
                $field['fieldgroup'] = $fieldgroups[$field['fg_id']]['label'];
                $this->response->fields .= $this->load->blade('templates/field_list_edit', $field, true);
            }
        }
        $this->_ajax_return();
    }

    function edit_fg()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->load->model('field_group_model', 'fg');
        $this->lang->load('field_group');
        $data['fg'] = $this->fg;
        
        $mod_id = $data['mod_id'] = $this->input->post('mod_id');
        $fg_id = $data['fg_id'] = $this->input->post('fg_id');
        
        $data['label'] = '';
        $data['sequence'] = '';
        $data['description'] = '';
        $data['display_id'] = '3';
        $data['active'] = '1';

        if( $fg_id )
        {
            $this->load->model('module_model');
            $record_check = $this->module_model->_exists( $mod_id );
            if( $record_check !== true )
            {
                $this->response->message[] = array(
                    'message' => 'The module you are requesting does not exists and/or has been deleted.',
                    'type' => 'error'
                );
                $this->_ajax_return();   
            }

            $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();
            require( APPPATH . 'modules/'. $mod['mod_code'] .'/config/field_groups.php' );
            $fgs = $config['fieldgroups'];
            $fg = $fgs[$fg_id];
            $data['label'] = $fg['label'];
            $data['sequence'] = $fg['sequence'];
            $data['description'] = $fg['description'];
            $data['display_id'] = $fg['display_id'];
            $data['active'] = $fg['active'];
        }

        $this->load->helper('form');
        $view['title'] = 'Add/Edit Field Group';
        $view['content'] = $this->load->view('edit/edit_fg_form', $data, true);
        
        $this->response->edit_fg_form = $this->load->view('templates/modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }

    function edit_field()
    {
        $this->_ajax_only();

        if( !$this->permission['add'] && !$this->permission['edit'] )
        {
            $this->response->message[] = array(
                'message' => 'You dont have sufficient permission to get the list of field groups for this module, please notify the System Administrator.',
                'type' => 'warning'
            );
            $this->_ajax_return();
        }

        $this->load->model('field_model', 'field');
        $this->lang->load('field');
        $data['field'] = $this->field;
        
        $mod_id = $data['mod_id'] = $this->input->post('mod_id');
        $f_id = $data['f_id'] = $this->input->post('f_id');
        
        $data['fg_id'] = '';
        $data['label'] = '';
        $data['description'] = '';
        $data['table' ] = '';
        $data['column'] = '';
        $data['uitype_id'] = '1';
        $data['display_id'] = '3';
        $data['quick_edit'] = '1';
        $data['sequence'] = '';
        $data['datatype'] = '';
        $data['active'] = '1';
        $data['encrypt'] = 0;

        //search dropdown
        $data['searchable_type_id'] = 1;
        $data['searchable_table'] = '';
        $data['multiple'] = 0;
        $data['group_by'] = '';
        $data['searchable_label'] = '';
        $data['value'] = '';
        $data['textual_value_column'] = '';

        $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();

        if( $f_id )
        {
            $this->load->model('module_model');
            $record_check = $this->module_model->_exists( $mod_id );
            if( $record_check !== true )
            {
                $this->response->message[] = array(
                    'message' => 'The module you are requesting does not exists and/or has been deleted.',
                    'type' => 'error'
                );
                $this->_ajax_return();   
            }
            
            require( APPPATH . 'modules/'. $mod['mod_code'] .'/config/fields.php' );
            $fields = $config['fields'];
            $break = false;
            foreach( $fields as $fg_id => $fs  )
            {    
                foreach($fs as $f_name => $field )
                {
                    if( $field['f_id'] == $f_id )
                    {
                        $data['fg_id'] = $field['fg_id'];
                        $data['label'] = $field['label'];
                        $data['description'] = $field['description'];
                        $data['table' ]= $field['table'];
                        $data['column'] = $field['column'];
                        $data['uitype_id'] = $field['uitype_id'];
                        $data['display_id'] = $field['display_id'];
                        $data['quick_edit'] = $field['quick_edit'];
                        $data['sequence'] = $field['sequence'];
                        $data['datatype'] = $field['datatype'];
                        $data['active'] = isset($field['active']) ? $field['active'] : 1;
                        $data['encrypt'] = $field['encrypt'];
                        if( $field['uitype_id'] == 4 ){
                            $data['searchable_type_id'] = $field['searchable']['type_id'];
                            $data['searchable_table'] = $field['searchable']['table'];
                            $data['multiple'] = $field['searchable']['multiple'];
                            $data['group_by'] = $field['searchable']['group_by'];
                            $data['searchable_label'] = $field['searchable']['label'];
                            $data['value'] = $field['searchable']['value'];
                            $data['textual_value_column'] = $field['searchable']['textual_value_column'];
                        }
                        $break = true;
                        break;
                    }
                    if( $break ) break;  
                }
            }
        }

        $this->load->helper('form');
        $view['title'] = 'Add/Edit Field Group';
       
        require( APPPATH . 'modules/'. $mod['mod_code'] .'/config/field_groups.php' );
        foreach( $config['fieldgroups'] as $fg_id => $fg){
            $data['fg_options'][$fg_id] = $fg['label'];
        }

        $uitypes = $this->db->get_where('uitypes', array('deleted' => 0));
        foreach($uitypes->result() as $uitype)
        {
            $data['uitype_options'][$uitype->uitype_id] = $uitype->uitype;   
        }

        $searchable_types = $this->db->get_where('searchable_type', array('deleted' => 0));
        foreach($searchable_types->result() as $s_type)
        {
            $data['s_type_options'][$s_type->searchable_type_id] = $s_type->searchable_type;   
        }

        $view['content'] = $this->load->view('edit/edit_field_form', $data, true);
        
        $this->response->edit_field_form = $this->load->view('templates/modal', $view, true);
        
        $this->response->message[] = array(
            'message' => '',
            'type' => 'success'
        );

        $this->_ajax_return();
    }