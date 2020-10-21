<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class module_model extends Record
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
		$this->mod_id = 1;
		$this->mod_code = 'module';
		$this->route = 'admin/modules';
		$this->url = site_url('admin/modules');
		$this->primary_key = 'mod_id';
		$this->table = 'modules';
		$this->icon = '';
		$this->short_name = 'Module';
		$this->long_name  = 'Module Manager';
		$this->description = 'Contains list of modules made for the system.';
		$this->path = APPPATH . 'modules/module/';

		parent::__construct();
	}

	function create_controller( $module )
    {
        $controller = APPPATH . 'modules/'. $module .'/controllers/' . $module .'.php';
        $this->load->helper('file');
        $mod_code = ucfirst($module);
        $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        $to_write .= "class {$mod_code} extends MY_PrivateController\r\n";
        $to_write .= "{\r\n";
        $to_write .= "\tpublic function __construct()\r\n";
        $to_write .= "\t{\r\n";
        $to_write .= "\t\t$". 'this->load->model(\''.$module.'_model\', \'mod\')'.";\r\n";
        $to_write .= "\t\tparent::__construct();\r\n";
        $to_write .= "\t}\r\n";
        if( file_exists(APPPATH . 'modules/'. $module .'/controllers/'.$module.'_custom.php'))
        {
            $custom = read_file( APPPATH . 'modules/'. $module .'/controllers/'.$module.'_custom.php');
            $custom = str_replace('<?php //delete me', '', $custom);
            $to_write .= $custom;
        }
        $to_write .= "}";
        write_file($controller , $to_write);
    }

    function create_model( $module )
    {
        $model = APPPATH . 'models/'. $module['modules.mod_code'] .'_model.php';
        $this->load->helper('file');
        $mod_code = ucfirst($module['modules.mod_code']);
        $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        $to_write .= "if ( !class_exists('Record') )\r\n";
        $to_write .= "{\r\n";
        $to_write .= "\trequire __DIR__ . '/record.php';\r\n";
        $to_write .= "}\r\n\r\n";
        $to_write .= "class ". $module['modules.mod_code']. "_model extends Record\r\n";
        $to_write .= "{\r\n";
        $to_write .= "\tvar $"."mod_id;\r\n";
        $to_write .= "\tvar $"."mod_code;\r\n";
        $to_write .= "\tvar $"."route;\r\n";
        $to_write .= "\tvar $"."url;\r\n";
        $to_write .= "\tvar $"."primary_key;\r\n";
        $to_write .= "\tvar $"."table;\r\n";
        $to_write .= "\tvar $"."icon;\r\n";
        $to_write .= "\tvar $"."short_name;\r\n";
        $to_write .= "\tvar $"."long_name;\r\n";
        $to_write .= "\tvar $"."description;\r\n";
        $to_write .= "\tvar $"."path;\r\n\r\n";
        $to_write .= "\tpublic function __construct()\r\n";
        $to_write .= "\t{\r\n";
        $to_write .= "\t\t$". 'this->mod_id' . " = ".$module['record_id'].";\r\n";
        $to_write .= "\t\t$". 'this->mod_code' . " = '".$module['modules.mod_code']."';\r\n";
        $to_write .= "\t\t$". 'this->route' . " = '".$module['modules.route']."';\r\n";
        $to_write .= "\t\t$". 'this->url' . " = site_url('".$module['modules.route']."');\r\n";
        $to_write .= "\t\t$". 'this->primary_key' . " = '".$module['modules.primary_key']."';\r\n";
        $to_write .= "\t\t$". 'this->table' . " = '".$module['modules.table']."';\r\n";
        $to_write .= "\t\t$". 'this->icon' . " = '".$module['modules.icon']."';\r\n";
        $to_write .= "\t\t$". 'this->short_name' . " = '".$module['modules.short_name']."';\r\n";
        $to_write .= "\t\t$". 'this->long_name' ."  = '".$module['modules.long_name']."';\r\n";
        $to_write .= "\t\t$". 'this->description' . " = '".$module['modules.description']."';\r\n";
        $to_write .= "\t\t$". 'this->path' . " = APPPATH . 'modules/".$module['modules.mod_code']."/';\r\n\r\n";
        $to_write .= "\t\tparent::__construct();\r\n";
        $to_write .= "\t}\r\n";
        
        if( file_exists(APPPATH . 'models/customs/'. $module['modules.mod_code'] .'.php'))
        {
            $custom = read_file( APPPATH . 'models/customs/'. $module['modules.mod_code'] .'.php' );
            $custom = str_replace('<?php //delete me', '', $custom);
            $to_write .= $custom;
        }

        $to_write .= "}";
        write_file($model , $to_write);   
    }

    public function create_field_configs( $module )
    {
        $fg_config = APPPATH . 'modules/'. $module['modules.mod_code'] .'/config/field_groups.php';
        $f_config = APPPATH . 'modules/'. $module['modules.mod_code'] .'/config/fields.php';
        $fv_config = APPPATH . 'modules/'. $module['modules.mod_code'] .'/config/field_validations.php';
        $f_cfgs = array();

        $this->load->helper('file');
        if( !file_exists($fg_config) )
        {
            $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
            $to_write .= "$". "config['fieldgroups'] = array();\r\n";
            write_file($fg_config, $to_write);
        }

        if( !file_exists($f_config) )
        {
            $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
            $to_write .= "$". "config['fields'] = array();\r\n";
            write_file($f_config, $to_write);
        }

        if( !file_exists($fv_config) )
        {
            $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
            $to_write .= "$". "config['field_validations'] = array();\r\n";
            write_file($fv_config, $to_write);
        }
    }

    function create_routes()
    {
        $this->load->helper('file');
        $to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        
        //modules
        $this->db->where('mod_code is not null');
        $this->db->where('mod_code !=', '');
        $modules = $this->db->get_where( $this->table, array('deleted' => 0) );
        foreach( $modules->result() as $module )
        {
            $to_write .= "$" ."route['" . $module->route . "'] = '" . $module->mod_code ."';\r\n";
            $to_write .= "$" ."route['" . $module->route . "/(.*)'] = '" . $module->mod_code ."/$2';\r\n";
            $to_write .= "$" ."route['^(en|id)/" . $module->route . "'] = '" . $module->mod_code ."';\r\n";
            $to_write .= "$" ."route['^(en|id)/" . $module->route . "/(.*)'] = '" . $module->mod_code ."/$2';\r\n";

            //menu
            $this->db->where('mod_id', $module->mod_id);
            $this->db->where('(uri is not null AND uri != "")');
            $this->db->where('(method is not null AND method != "")');
            $menu_items = $this->db->get_where( 'menu', array('deleted' => 0) );
            foreach( $menu_items->result() as $menu_item )
            {
                $to_write .= "$" ."route['^(en|id)/" . $menu_item->uri . "'] = '" . $module->mod_code ."/".$menu_item->method."';\r\n";   
            }
        }

        $to_write .= "$"."route['^(en|id)^$'] = "."'dashboard';\r\n";
        $module_routes = APPPATH . 'config/module_routes.php';
        write_file($module_routes, $to_write);   
    }

    function _create_edit_page_scripts_styles( $module )
    {
        $response = new stdClass();
        $field_config = APPPATH . 'modules/'. $module .'/config/fields.php';
        if( !file_exists( $field_config ) )
        {
            $response->message[] = array(
                'message' => lang('module.field_config_not_found'),
                'type' => 'error'
            );
            return $response;
        }

        $this->load->helper('file');

        require( $field_config );
        $styles = array();
        $plugins = array();
        $js = array();
        foreach($config['fields'] as $fg_id => $fg )
        {
            foreach($fg as $f_name => $field)
            {
                switch( $field['uitype_id'] )
                {
                    case 3: //yes no
                        $styles[] = 'switch';
                        $plugins[] = 'switch';
                        $js[] = $this->load->view('templates/uitypes/switch', $field, true);
                        break;
                    case 4: //searchable ddlb
                        $styles[] = 'select2';
                        $plugins[] = 'select2';
                        $js[] = $this->load->view('templates/uitypes/select2', $field, true);
                        break;
                    case 5: //ckeditor
                        $plugins[] = 'ckeditor';
                        $plugins[] = 'ckfinder';
                        break;
                    case 6: //datepicker
                    case 18: //Month and Year Picker
                        $styles[] = 'datepicker';
                        $plugins[] = 'datepicker';
                        $js[] = $this->load->view('templates/uitypes/datepicker', $field, true);
                        break;
                    case 8://single upload
                        $styles[] = 'upload';
                        $plugins[] = 'upload';
                        $js[] = $this->load->view('templates/uitypes/single_upload', $field, true);
                        break;
                    case 9: //multi upload
                        $styles[] = 'upload';
                        $plugins[] = 'upload';
                        $js[] = $this->load->view('templates/uitypes/multiple_upload', $field, true);
                        break;
                    case 10: //multiselect checkbox
                        $styles[] = 'multicheckbox';
                        $plugins[] = 'multicheckbox';
                        $js[] = $this->load->view('templates/uitypes/multicheckbox', $field, true);
                        break;
                     case 12: //Date From - Date To Picker
                    case 18: //Month and Year Picker
                        $styles[] = 'datepicker';
                        $plugins[] = 'datepicker';
                        $js[] = $this->load->view('templates/uitypes/datefromtopicker', $field, true);
                        break;
                    case 16: //Date and Time Picker
                        $styles[] = 'datetimepicker';
                        $plugins[] = 'datetimepicker';
                        $js[] = $this->load->view('templates/uitypes/datetimepicker', $field, true);
                        break;
                    case 17: //Time Picker
                        $styles[] = 'timepicker';
                        $plugins[] = 'timepicker';
                        $js[] = $this->load->view('templates/uitypes/timepicker', $field, true);
                        break;    
                    case 20: //Time - Minute Second Picker
                        break; 
                    case 21: //Date and Time From - Date and Time
                        break; 
                }

                $rules = explode('|', $field['datatype']);

                if( in_array( 'integer', $rules ) OR in_array( 'numeric', $rules) )
                {
                    $plugins[] = 'inputmask';
                    $js[] = $this->load->view('templates/uitypes/inputmask', $field, true);
                }  
            }
        }

        $page_styles = APPPATH . 'modules/'. $module .'/views/edit/page_styles.blade.php';
        $to_write = '';
        if(sizeof($styles) > 0)
        {
            $styles = array_unique($styles);
            $this->load->config('plugin_styles');
            $plugin_styles = $this->config->item('style');
            foreach( $styles as $style )
            {
                if(isset( $plugin_styles[$style] ) )
                {
                    $to_write .= $plugin_styles[$style];
                }
                else{
                    $to_write .= "//{$style} is not a registered plugin style\r\n";        
                }
            }
        }
        write_file($page_styles, $to_write);
       
        $page_plugins = APPPATH . 'modules/'. $module .'/views/edit/page_plugins.blade.php';
        $to_write = '';
        if(sizeof($plugins) > 0)
        {
            $plugins = array_unique($plugins);
            $this->load->config('plugin_scripts');
            $plugin_scripts = $this->config->item('plugin');
            foreach( $plugins as $plugin )
            {
                if(isset( $plugin_scripts[$plugin] ) )
                {
                    $to_write .= $plugin_scripts[$plugin];
                }
                else{
                    $to_write .= "//{$plugin} is not a registered plugin script\r\n";        
                }
            }
        }
        write_file($page_plugins, $to_write);

        $edit_js = FCPATH.'assets/modules/'.$module.'/edit.js';
        $to_write = '$(document).ready(function(){' ."\r\n";
        $js = array_unique( $js );
        if(sizeof($js) > 0)
        {
            $to_write .= implode("\r\n", $js);
        }
        $to_write .= '});';
        write_file($edit_js, $to_write);

        $page_scripts = APPPATH . 'modules/'. $module .'/views/edit/page_scripts.blade.php';
        $to_write = "";
        write_file($page_scripts, $to_write);

        $response->message[] = array(
            'message' => lang('module.create_form_success'),
            'type' => 'success'
        );
        return $response;   
    }

    function _reset_all()
    {
        $modules = $this->db->get('modules');
        foreach($modules->result() as $module )
        {
            //js
            $js = FCPATH.'assets/modules/'.$module->mod_code.'/'.$module->mod_code.'.js';
            if( file_exists( $js ) ) unlink( $js );

            if( $module->mod_code == 'module' )
                continue;

            //controller
            $controller = APPPATH . 'modules/'. $module->mod_code .'/controllers/' . $module->mod_code .'.php';
            if( file_exists( $controller ) ) unlink( $controller );
            $this->create_controller( $module->mod_code );
        }

        $this->create_routes();
    } 
}