<?php //delete me
	function _save_fg()
    {
        $response = new stdClass();
        $response->saved = false; 
        $mod_id = $this->input->post('mod_id');
        $fg_id = $this->input->post('fg_id');

        if( !$mod_id )
        {
            $response->message[] = array(
                'message' => lang('common.insufficient_data'),
                'type' => 'error'
            );
            return $response;
        }

        $this->load->model('module_model');
        $record_check = $this->module_model->_exists( $mod_id );
        if( $record_check !== true )
        {
            $response->message[] = array(
                'message' => lang('field_group.module_not_found'),
                'type' => 'error'
            );
            return $response;   
        }

        $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();
        if( empty($fg_id) )
        {
            $fg_id = $mod['fg_id'] + 1;
            $this->db->update('modules', array('fg_id' => $fg_id), array('mod_id' => $mod_id));
        }

        $validation_rules = array(
            array(
                'field' => 'label',
                'label' => 'Label',
                'rules' => 'required'
            ),
            array(
                'field' => 'sequence',
                'label' => 'Sequence',
                'rules' => 'required|integer'
            ),
        );

        $this->load->library('form_validation');
        $this->form_validation->set_rules( $validation_rules );
        if ($this->form_validation->run() == false)
        {
            foreach( $this->form_validation->get_error_array() as $f => $f_error )
            {
                $response->message[] = array(
                    'message' => $f_error,
                    'type' => 'warning'
                );  
            }
            return $response;
        }

        //sequencing
        $sequence[$this->input->post('sequence')][] = $fg_id;
        
        $fg_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/field_groups.php';
        $f_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/fields.php';
        
        $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        $to_write .= "$". "config['fieldgroups'] = array();\r\n";

        if( file_exists( $fg_config ) )
        {
            require( $fg_config );
            $fgs = $config['fieldgroups'];
            
            //sequencing
            foreach( $fgs as $saved_id => $fg )
            {
                if( $saved_id != $fg_id )
                {
                    $sequence[$fg['sequence']][] = $saved_id;
                }
            }

            ksort($sequence);
        }

        if( file_exists( $f_config ) )
        {
            require( $f_config );
            $fields = $config['fields'];
            foreach( $fields as $_fg_id => $fields )
            {
               foreach( $fields as $f_name => $field )
                {
                    $fg_field[$field['fg_id']][$field['sequence']][] = $f_name;
                } 
            }
        }

        $real_sequence = 1;
        foreach($sequence as $sequence => $seq)
        {    
            foreach($seq as $index => $saved_id ){
                if( $saved_id == $fg_id ){
                    $fg['label'] = $this->input->post('label');
                    $fg['description'] = $this->input->post('description');
                    $fg['display_id'] = $this->input->post('display_id');
                    $fg['active'] = $this->input->post('active');
                }
                else{
                    $fg = $fgs[$saved_id];
                }
                
                $fg['sequence'] = $real_sequence;
                $real_sequence++;

                $to_write .= "$"."config['fieldgroups'][$saved_id] = array(\r\n";
                $to_write .= "\t'fg_id' => $saved_id,\r\n";
                $to_write .= "\t'label' => '".$fg['label']."',\r\n";
                $to_write .= "\t'description' => '".$fg['description']."',\r\n";
                $to_write .= "\t'display_id' => ".$fg['display_id'].",\r\n";
                $to_write .= "\t'sequence' => ".$fg['sequence'].",\r\n";
                $to_write .= "\t'active' => ".$fg['active'].",\r\n";
                $to_write .= "\t'fields' => array(";
            
                if( isset($fg_field[$saved_id]) )
                {
                    $fields = $fg_field[$saved_id];
                    ksort( $fields );

                    foreach( $fields as $sequence => $_f_name )
                    {
                        foreach( $_f_name as $f_name )
                        {
                            $fields[$sequence] = "\r\n\t\t'{$f_name}'"; 
                        }
                    }

                    $to_write .= implode(',', $fields);
                    $to_write .= "\r\n";
                }

                $to_write .= "\t)\r\n";
                $to_write .= ");\r\n";
            }
        }

        $this->load->helper('file');
        write_file($fg_config , $to_write);

        $this->_delete_cached_queries( $mod['mod_code'] );
        $response = (object) array_merge( (array)$response, (array)$this->_create_edit_fgs( $mod['mod_code'] ) );

        $this->load->model('module_model', 'module');
        $response = (object) array_merge( (array)$response, (array)$this->module->_create_edit_page_scripts_styles( $mod['mod_code'] ) );

        $response->fg_id = $fg_id;
        $response->saved = true; 
        $response->message[] = array(
            'message' => lang('field_group.fg_saved'),
            'type' => 'success'
        );

        return $response;
    }

    function _delete_fg()
    {
        $response = new stdClass();

        $mod_id = $this->input->post('mod_id');
        $fgs = $this->input->post('fgs');

        $this->load->model('module_model');
        $record_check = $this->module_model->_exists( $mod_id );
        if( $record_check !== true )
        {
            $response->message[] = array(
                'message' => lang('field_group.module_not_found'),
                'type' => 'error'
            );
            return $response;   
        }

        $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();
        $fg_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/field_groups.php';
        if( file_exists($fg_config) )
        {
            require( $fg_config );
            $fgs = explode(',', $fgs);
            if( sizeof($config['fieldgroups']) > 0 )
            {
                $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
                $to_write .= "$". "config['fieldgroups'] = array();\r\n";
                foreach( $config['fieldgroups'] as $fg_id => $fg )
                {
                    if( !in_array($fg_id, $fgs))
                    {
                        $to_write .= "$"."config['fieldgroups'][$fg_id] = array(\r\n";
                        $to_write .= "\t'fg_id' => $fg_id,\r\n";
                        $to_write .= "\t'label' => '".$fg['label']."',\r\n";
                        $to_write .= "\t'description' => '".$fg['description']."',\r\n";
                        $to_write .= "\t'display_id' => ".$fg['display_id'].",\r\n";
                        $to_write .= "\t'sequence' => ".$fg['sequence'].",\r\n";
                        $to_write .= "\t'active' => ".$fg['active'].",\r\n";
                        $to_write .= "\t'fields' => array(";

                        if( sizeof($fg['fields']) > 0 )
                        {
                            $fields = array();
                            foreach( $fg['fields'] as $f_name )
                            {
                                $fields[] = "\r\n\t\t'{$f_name}'"; 
                            }
                            
                            $to_write .= implode(',', $fields);
                        }
                        
                        $to_write .= "\t)\r\n";
                        $to_write .= ");\r\n"; 
                    }
                }
                $this->load->helper('file');
                write_file($fg_config , $to_write);
            }   
        }
        
        $this->_delete_cached_queries( $mod['mod_code'] );
        $response = (object) array_merge( (array)$response, (array)$this->_create_edit_fgs( $mod['mod_code'] ) );

        $this->load->model('module_model', 'module');
        $response = (object) array_merge( (array)$response, (array)$this->module->_create_edit_page_scripts_styles( $mod['mod_code'] ) );

        $response->message[] = array(
            'message' => lang('field_group.delete_success'),
            'type' => 'success'
        );
        return $response;
    }

    private function _delete_cached_queries( $module )
    {
        $this->load->model('field_model', 'field');
        $this->lang->load('field');
        $this->field->_delete_cached_queries( $module );
    }

    public function _create_edit_fgs( $mod_code )
    {
        $response = new stdClass();
        $fg_config = APPPATH . 'modules/'. $mod_code .'/config/field_groups.php';
        $field_config = APPPATH . 'modules/'. $mod_code .'/config/fields.php';
        if( !file_exists( $fg_config ) )
        {
            $response->message[] = array(
                'message' => lang('field_group.fg_config_not_found'),
                'type' => 'error'
            );
            return $response;
        }

        if( !file_exists( $field_config ) )
        {
            $response->message[] = array(
                'message' => lang('field_group.field_config_not_found'),
                'type' => 'error'
            );
            return $response;
        }

        $this->load->helper('file');

        require( $fg_config );
        require( $field_config );
        $fgs = '';
        foreach( $config['fieldgroups'] as $fg_id => $fg )
        {
            $fields = isset($config['fields'][$fg_id]) ? $config['fields'][$fg_id] : array();
            $fg_file = APPPATH . 'modules/'. $mod_code .'/views/edit/fgs/'.$fg_id.'.blade.php';
            $form = $this->load->view('templates/fgs', array('fg' => $fg, 'fields' => $fields), true);
            $fgs .= $form;
            write_file( $fg_file, $form);
        }

        //converge all fgs to 1 file
        $fgs_file = APPPATH . 'modules/'. $mod_code .'/views/edit/fgs.blade.php';
        write_file( $fgs_file, $fgs);

        $response->message[] = array(
            'message' => lang('field_group.create_form_success'),
            'type' => 'success'
        );
        return $response;
    }
    