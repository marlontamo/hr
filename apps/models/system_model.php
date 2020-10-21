<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class system_model extends Record
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
		$this->mod_id = 5;
		$this->mod_code = 'system';
		$this->route = 'admin/system';
		$this->url = site_url('admin/system');
		$this->primary_key = 'config_id';
		$this->table = 'config';
		$this->icon = 'fa-wrench';
		$this->short_name = 'System';
		$this->long_name  = 'System Configuration';
		$this->description = '';
		$this->path = APPPATH . 'modules/system/';

		parent::__construct();
	}

	function _get_config( $module ){
		
		$data = array();
		$qry = "SELECT c.key, c.value, c.description FROM ww_config c
				LEFT JOIN ww_config_group cg ON cg.config_group_id = c.config_group_id
				WHERE cg.group_key = '{$module}'
				UNION ALL
				SELECT 'config_group_id' as `key`, cg.config_group_id as value, '' FROM ww_config_group cg
				WHERE cg.group_key = '{$module}'"; 
				
		$result = $this->db->query($qry);
		
		if($result->num_rows() > 0){
				
			foreach($result->result_array() as $row){
				//$data[$row['key']][] = _create_proper_name( $row['key'] );
				$data[$row['key']][] = ucwords( str_replace( '_', ' ', $row['key'] ) );
				$data[$row['key']][] = $row['value'];
				$data[$row['key']]['desc'] = $row['description'];
			}
			
		}
			
		$result->free_result();
		return $data;
		
	}
	
	function _update_config( $qry ){

		$success = false;
		
		for($i=0; $i < count($qry); $i++){
			$success = $this->db->query($qry[$i]);
		}
		
		return $success;
		
	}

	function _create_config( $cg_id )
	{
		$cg = $this->db->get_where('config_group', array('config_group_id' => $cg_id))->row();
		$items = $this->db->get_where( $this->table, array('config_group_id' => $cg_id) );
		
		$config_currentdbpath = APPPATH . 'config/'; //.$this->session->userdata('current_db');
		$config = $config_currentdbpath .'/'. $cg->group_key.'.php';
		if (!is_dir($config_currentdbpath)) {
            mkdir($config_currentdbpath, 0755, true);
            copy(APPPATH .'index.html', $config_currentdbpath.'/index.html');
        }
        
		$to_write = "<?php if (!defined('BASEPATH')) exit('No direct script access allowed');\r\n\r\n";
        $to_write .= "$". "config['$cg->group_key'] = array();\r\n";

        foreach( $items->result() as $item )
        {
        	$to_write .= "$". "config['$cg->group_key']['$item->key'] = ";
        	if( $item->add_qoutes )
        		$to_write .= "\"";
        	
        	$to_write .= $item->value;

        	if( $item->add_qoutes ) 
        		$to_write .= "\"";
        	
        	$to_write .= ";\r\n";
        }

        $this->load->helper('file');
        write_file($config, $to_write);
	}
}