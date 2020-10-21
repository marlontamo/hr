<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function base_url($uri = '')
{
  $CI =& get_instance();
  //$uri = $CI->lang->lang() . '/' . $uri; 
  return $CI->config->base_url($uri);
}

/* End of file MY_url_helper.php */
/* Location: ./application/helpers/MY_url_helper */