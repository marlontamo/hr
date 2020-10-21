<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Originaly CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
//modification by Yeb Reitsma

require APPPATH."third_party/MX/Config.php";

class MY_Config extends MX_Config {

    function site_url($uri = '')
    {    
        if (is_array($uri))
        {
            $uri = implode('/', $uri);
        }

        if (function_exists('get_instance'))        
        {
            $CI =& get_instance();
            $uri = $CI->lang->localized($uri);       
        }

        return parent::site_url($uri);
    }

    public function load($file = 'config', $use_sections = FALSE, $fail_gracefully = FALSE, $_module = '') {
        $file_orig = $file;

        if (in_array($file, $this->is_loaded, TRUE)) return $this->item($file);

        $_module OR $_module = CI::$APP->router->fetch_module();
      
        

        list($path, $file) = Modules::find($file, $_module, 'config/');
         // print_r($file);
        
        
        if ($path === FALSE) {
             
            parent::load($file_orig, $use_sections, $fail_gracefully);                  
            return $this->item($file);
        }  

        if(CLIENT_DIR != '' && is_dir(MODPATH.CLIENT_DIR.'/'.$_module.'/config/')){
            $client_path = str_replace('apps/modules', MODPATH.CLIENT_DIR, $path);
            
               if ($client_config = Modules::load_file($file, $client_path, 'config')) {
                 /* reference to the config array */
                $current_config =& $this->config;
                if ($use_sections === TRUE) {
                    
                    if (isset($current_config[$file])) {
                        $current_config[$file] = array_merge($current_config[$file], $client_config);
                    } else {
                        $current_config[$file] = $client_config;
                    }
                    
                } else {
                    $current_config = array_merge($current_config, $client_config);
                }
                $this->is_loaded[] = $file;
                unset($client_config);
                return $this->item($file);
            }
        }   
        

        if ($config = Modules::load_file($file, $path, 'config')) {
             /* reference to the config array */
            $current_config =& $this->config;
            if ($use_sections === TRUE) {
                
                if (isset($current_config[$file])) {
                    $current_config[$file] = array_merge($current_config[$file], $config);
                } else {
                    $current_config[$file] = $config;
                }
                
            } else {
                $current_config = array_merge($current_config, $config);
            }
            $this->is_loaded[] = $file;
            unset($config);
            return $this->item($file);
        }
    }


}

// END MY_Config Class

/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */ 