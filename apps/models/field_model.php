<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class field_model extends Record
{
	var $mod_id;
	var $mod_code;
	var $route;
	var $url;
	var $primary_key;
	var $table;
	var $icon;
	var $short_name;
	var $long_name;
	var $description;
	var $path;

	public function __construct()
	{
		$this->mod_id = 13;
		$this->mod_code = 'field';
		$this->route = 'admin/fields';
		$this->url = site_url('admin/fields');
		$this->primary_key = 'f_id';
		$this->table = 'fields';
		$this->icon = 'fa-field';
		$this->short_name = 'Fields';
		$this->long_name  = 'Fields';
		$this->description = 'Field Groups';
		$this->path = APPPATH . 'modules/fields/';

		parent::__construct();
	}

	function _save_field()
	{
		$response = new stdClass();
		$mod_id = $this->input->post('mod_id');
		$f_id = $this->input->post('f_id');

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
                'message' => lang('field.module_not_found'),
                'type' => 'error'
            );
            return $response;   
        }

        $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();
        if( empty($f_id) )
        {
        	$f_id = $mod['f_id'] + 1;
        	$this->db->update('modules', array('f_id' => $f_id), array('mod_id' => $mod_id));
        }

        $table = $this->input->post('table');
        $column = $this->input->post('column');
        $fg_id = $this->input->post('fg_id');
        $label = $this->input->post('label');
        $description = $this->input->post('description');
        $uitype_id = $this->input->post('uitype_id');
        $display_id = $this->input->post('display_id');
        $quick_edit = $this->input->post('quick_edit');
        $sequence = $this->input->post('sequence');
        $datatype = $this->input->post('datatype');
        $active = $this->input->post('active');
        $encrypt = $this->input->post('encrypt');

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
			array(
				'field' => 'table',
				'label' => 'Table',
				'rules' => 'required'
			),
			array(
				'field' => 'column',
				'label' => 'Column',
				'rules' => 'required'
			),
			array(
				'field' => 'uitype_id',
				'label' => 'UI Type',
				'rules' => 'required|integer'
			),
        );

        if( $uitype_id == 4 || $uitype_id == 10 )
        {
            $validation_rules[] = array(
                'field' => 'searchable_type_id',
                'label' => 'Searchable Type',
                'rules' => 'required'
            );
        	$validation_rules[] = array(
        		'field' => 'searchable_table',
				'label' => 'Searchable Table',
				'rules' => 'required'
        	);
        	$validation_rules[] = array(
        		'field' => 'searchable_label',
				'label' => 'Searchable Label',
				'rules' => 'required'
        	);

        	$validation_rules[] = array(
        		'field' => 'value',
				'label' => 'Searchable Value Column',
				'rules' => 'required'
        	);
        }

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

		$field_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/fields.php';
        
		
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        $to_write .= "$". "config['fields'] = array();\r\n";

        $to_write .= "$". "config['fields'][{$fg_id}]['". $table . "." .$column ."'] = array(\r\n";
		$to_write .= "\t'f_id' => {$f_id},\r\n";
        $to_write .= "\t'fg_id' => {$fg_id},\r\n";
        $to_write .= "\t'label' => '{$label}',\r\n";
        $to_write .= "\t'description' => '{$description}',\r\n";
        $to_write .= "\t'table' => '{$table}',\r\n";
        $to_write .= "\t'column' => '{$column}',\r\n";
        $to_write .= "\t'uitype_id' => {$uitype_id},\r\n";
        $to_write .= "\t'display_id' => {$display_id},\r\n";
        $to_write .= "\t'quick_edit' => {$quick_edit},\r\n";
        $to_write .= "\t'sequence' => {$sequence},\r\n";
        $to_write .= "\t'datatype' => '{$datatype}',\r\n";
        $to_write .= "\t'active' => '{$active}',\r\n";
        $to_write .= "\t'encrypt' => {$encrypt}";
        
        if( $uitype_id == 4 || $uitype_id == 10 )
        {
        	$to_write .= ",\r\n\t'searchable' => array(\r\n";
        	$to_write .= "\t\t'type_id' => '". $this->input->post('searchable_type_id') ."',\r\n";
            $to_write .= "\t\t'table' => '". $this->input->post('searchable_table') ."',\r\n";
        	$to_write .= "\t\t'multiple' => ". $this->input->post('multiple') .",\r\n";
        	$to_write .= "\t\t'group_by' => '". $this->input->post('group_by') ."',\r\n";
        	$to_write .= "\t\t'label' => '". $this->input->post('searchable_label') ."',\r\n";
        	$to_write .= "\t\t'value' => '". $this->input->post('value') ."',\r\n";
        	$to_write .= "\t\t'textual_value_column' => '". $this->input->post('textual_value_column') ."'\r\n";
        	$to_write .= "\t)"; 	
        }

        $to_write .= "\r\n);\r\n";

		if( file_exists( $field_config ) )
		{
			require( $field_config );
       		$fields = $config['fields'];
            foreach( $fields as $fg_id => $fs )
            {
           		foreach( $fs as $f_name => $field )
           		{
           			if( $f_name != $table .'.'. $column )
           			{
           				$to_write .= "$". "config['fields'][".$field['fg_id']."]['{$f_name}'] = array(\r\n";
    		            $to_write .= "\t'f_id' => ". $field['f_id'] .",\r\n";
    		            $to_write .= "\t'fg_id' => ". $field['fg_id'] .",\r\n";
    		            $to_write .= "\t'label' => '". $field['label'] ."',\r\n";
    		            $to_write .= "\t'description' => '". $field['description'] ."',\r\n";
    		            $to_write .= "\t'table' => '". $field['table'] ."',\r\n";
    		            $to_write .= "\t'column' => '". $field['column'] ."',\r\n";
    		            $to_write .= "\t'uitype_id' => ". $field['uitype_id'] .",\r\n";
    		            $to_write .= "\t'display_id' => ". $field['display_id'] .",\r\n";
    		            $to_write .= "\t'quick_edit' => ". $field['quick_edit'] .",\r\n";
    		            $to_write .= "\t'sequence' => ". $field['sequence'] .",\r\n";
    		            $to_write .= "\t'datatype' => '". $field['datatype'] ."',\r\n";
    		            $to_write .= "\t'active' => '". $field['active'] ."',\r\n";
    		            $to_write .= "\t'encrypt' => ". $field['encrypt'];
    		            
    		            if( isset($field['searchable']) )
    		            {
    		            	$to_write .= ",\r\n\t'searchable' => array(\r\n";
    		            	$to_write .= "\t\t'type_id' => '". $field['searchable']['type_id'] ."',\r\n";
                            $to_write .= "\t\t'table' => '". $field['searchable']['table'] ."',\r\n";
    		            	$to_write .= "\t\t'multiple' => ". $field['searchable']['multiple'] .",\r\n";
    		            	$to_write .= "\t\t'group_by' => '". $field['searchable']['group_by'] ."',\r\n";
    		            	$to_write .= "\t\t'label' => '". $field['searchable']['label'] ."',\r\n";
    		            	$to_write .= "\t\t'value' => '". $field['searchable']['value'] ."',\r\n";
    		            	$to_write .= "\t\t'textual_value_column' => '". $field['searchable']['textual_value_column'] ."'\r\n";
    		            	$to_write .= "\t)";
    		            }

    		            $to_write .= "\r\n);\r\n";
           			}
           		}
            }
        }

        $this->load->helper('file');
        write_file($field_config, $to_write);

        require( $field_config );
        if(sizeof( $config['fields'] > 0 ))
        {
            $validation_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/field_validations.php';
            $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
            $to_write .= "$". "config['field_validations'] = array();\r\n";
            foreach($config['fields'] as $fg_id => $fields){
                foreach( $fields as $f_name => $field )
                {
                    if( !empty($field['datatype']) )
                    {
                        switch( $field['uitype_id'] )
                        {
                            case 12:
                                $to_write .= "$". "config['field_validations']['{$f_name}_from'][] = array(\r\n";
                                $to_write .= "\t'field'   => '{$field['table']}[{$field['column']}_from]',\r\n";
                                $to_write .= "\t'label'   => '{$field['label']} from',\r\n";
                                $to_write .= "\t'rules'   => '{$field['datatype']}'";
                                $to_write .= "\r\n);\r\n";
                                $to_write .= "$". "config['field_validations']['{$f_name}_to'][] = array(\r\n";
                                $to_write .= "\t'field'   => '{$field['table']}[{$field['column']}_to]',\r\n";
                                $to_write .= "\t'label'   => '{$field['label']} to',\r\n";
                                $to_write .= "\t'rules'   => '{$field['datatype']}'";
                                $to_write .= "\r\n);\r\n";
                                break;
                            default:
                                $to_write .= "$". "config['field_validations']['{$f_name}'][] = array(\r\n";
                        $to_write .= "\t'field'   => '{$field['table']}[{$field['column']}]',\r\n";
                        $to_write .= "\t'label'   => '{$field['label']}',\r\n";
                        $to_write .= "\t'rules'   => '{$field['datatype']}'";
                        $to_write .= "\r\n);\r\n";
                        }
                        
                    }
                }
            }
            write_file($validation_config, $to_write);
        }

        $this->_delete_cached_queries( $mod['mod_code'] );
        $this->load->model('field_group_model', 'fg');
        $this->lang->load('field_group');
        $response = (object) array_merge( (array)$response, (array)$this->fg->_create_edit_fgs( $mod['mod_code'] ) );

        $this->load->model('module_model', 'module');
        $response = (object) array_merge( (array)$response, (array)$this->module->_create_edit_page_scripts_styles( $mod['mod_code'] ) );

		$response->fg_id = $fg_id;
        $response->saved = true; 
		$response->message[] = array(
            'message' => lang('field.field_saved'),
            'type' => 'success'
        );

        return $response;
	}

	function _delete_field()
	{
		$response = new stdClass();

		$mod_id = $this->input->post('mod_id');
        $fields = $this->input->post('fields');

        $this->load->model('module_model');
        $record_check = $this->module_model->_exists( $mod_id );
        if( $record_check !== true )
        {
            $response->message[] = array(
                'message' => lang('field.module_not_found'),
                'type' => 'error'
            );
            return $response;   
        }

        $mod = $this->db->get_where('modules', array('mod_id' => $mod_id))->row_array();
        $fields_config = APPPATH . 'modules/'. $mod['mod_code'] .'/config/fields.php';
        if( file_exists($fields_config) )
        {
            require( $fields_config );
            $fields = explode(',', $fields);
            if( sizeof($config['fields']) > 0 )
            {
                $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
                $to_write .= "$". "config['fields'] = array();\r\n";
                
                foreach( $config['fields'] as $fs )
                {
                    foreach( $fs as $f_name => $field )
                    {
                        if( !in_array($field['f_id'], $fields))
                        {
                            $to_write .= "$". "config['fields'][".$field['fg_id']."]['{$f_name}'] = array(\r\n";
                            $to_write .= "\t'f_id' => ". $field['f_id'] .",\r\n";
                            $to_write .= "\t'fg_id' => ". $field['fg_id'] .",\r\n";
                            $to_write .= "\t'label' => '". $field['label'] ."',\r\n";
                            $to_write .= "\t'description' => '". $field['description'] ."',\r\n";
                            $to_write .= "\t'table' => '". $field['table'] ."',\r\n";
                            $to_write .= "\t'column' => '". $field['column'] ."',\r\n";
                            $to_write .= "\t'uitype_id' => ". $field['uitype_id'] .",\r\n";
                            $to_write .= "\t'display_id' => ". $field['display_id'] .",\r\n";
                            $to_write .= "\t'quick_edit' => ". $field['quick_edit'] .",\r\n";
                            $to_write .= "\t'sequence' => ". $field['sequence'] .",\r\n";
                            $to_write .= "\t'datatype' => '". $field['datatype'] ."',\r\n";
                            $to_write .= "\t'active' => '". $field['active'] ."',\r\n";
                            $to_write .= "\t'encrypt' => ". $field['encrypt'];
                            
                            if( isset($field['searchable']) )
                            {
                                $to_write .= ",\r\n\t'searchable' => array(\r\n";
                                $to_write .= "\t\t'type_id' => '". $field['searchable']['type_id'] ."',\r\n";
                                $to_write .= "\t\t'table' => '". $field['searchable']['table'] ."',\r\n";
                                $to_write .= "\t\t'multiple' => ". $field['searchable']['multiple'] .",\r\n";
                                $to_write .= "\t\t'group_by' => '". $field['searchable']['group_by'] ."',\r\n";
                                $to_write .= "\t\t'label' => '". $field['searchable']['label'] ."',\r\n";
                                $to_write .= "\t\t'value' => '". $field['searchable']['value'] ."',\r\n";
                                $to_write .= "\t\t'textual_value_column' => '". $field['searchable']['textual_value_column'] ."'\r\n";
                                $to_write .= "\t)";
                            }

                            $to_write .= "\r\n);\r\n"; 
                        }
                    }
                }
                $this->load->helper('file');
                write_file($fields_config , $to_write);
            }   
        }

        $this->_delete_cached_queries( $mod['mod_code'] );
        $this->load->model('field_group_model', 'fg');
        $this->lang->load('field_group');
        $response = (object) array_merge( (array)$response, (array)$this->fg->_create_edit_fgs( $mod['mod_code'] ) );
        $this->load->model('module_model', 'module');
        $response = (object) array_merge( (array)$response, (array)$this->module->_create_edit_page_scripts_styles( $mod['mod_code'] ) );

        $response->message[] = array(
            'message' => lang('field.delete_success'),
            'type' => 'success'
        );

        return $response;
	}

    public function _delete_cached_queries( $module )
    {
        //delete cached queries
        $list_cache = APPPATH . 'modules/'. $module .'/config/list_cached_query.php';
        $edit_cache = APPPATH . 'modules/'. $module .'/config/edit_cached_query.php';
        if( file_exists($list_cache) ) unlink($list_cache);
        if( file_exists($edit_cache) ) unlink($edit_cache);
    }
}