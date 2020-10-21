<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function debug( $var, $return = false )
{
	$debug = "<pre>";
	$debug .= print_r( $var, true );
	$debug .= "</pre>";

	if( $return )
		return $debug;
	else
		echo $debug;
}

function theme_path( $return = false, $add_base_url = true )
{
	$theme_path = 'assets/';
	switch( true )
	{
		case $return && $add_base_url:
			return base_url() . $theme_path;
			break;
		case $return && !$add_base_url:
			return $theme_path;
			break;
		case !$return && $add_base_url:
			echo base_url() . 'assets/';
			break;
		case !$return && !$add_base_url:
			echo 'assets/';
			break;
	}	
}

function get_module_js( $module = array(), $load_custom = true  )
{
	if( !empty( $module ) )
	{
		$ci=& MY_Controller::$instance; 
		$modules = 'modules';
		if(CLIENT_DIR != '' && is_dir(FCPATH.'assets/client/'.CLIENT_DIR.'/'.$module->mod_code.'/') ){
			$modules = 'client/'.CLIENT_DIR;
		}

		$main_js = FCPATH.'assets/'.$modules.'/'.$module->mod_code.'/'.$module->mod_code.'.js';
		if( !file_exists( $main_js ) )
		{
			$module->theme_path = theme_path( true, false );
			$mod_js = $ci->load->view('templates/mod_js', $module, true);
			$ci->load->helper('file');
			
			if( !is_dir( FCPATH.'assets/'.$modules.'/'.$module->mod_code ) ){
				mkdir( FCPATH.'assets/'.$modules.'/'.$module->mod_code, 0777, TRUE);
				$indexhtml = read_file( APPPATH .'index.html');
                write_file(FCPATH.'assets/'.$modules.'/'.$module->mod_code. '/index.html', $indexhtml);
			}

			write_file($main_js , $mod_js);
		}
		echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/'.$module->mod_code.'.js"></script>';

		$custom_js = 'assets/'.$modules.'/'.$module->mod_code.'/'.$module->mod_code.'_custom.js';
		
		if( $load_custom && file_exists( $custom_js ) )
		{
			echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/'.$module->mod_code.'_custom.js"></script>';
		}		
	}
}

function get_edit_js( $module = array() )
{
	if( !empty( $module ) )
	{
		$ci=& MY_Controller::$instance; 
		$modules = 'modules';
		if(CLIENT_DIR != '' && is_dir(FCPATH.'assets/client/'.CLIENT_DIR.'/'.$module->mod_code.'/') ){
			$modules = 'client/'.CLIENT_DIR;
		}


		$main_js = FCPATH.'assets/'.$modules.'/'.$module->mod_code.'/edit.js';
		if( !file_exists( $main_js ) )
		{
			//create routine to include validations and include scripts here, todolater

			$ci->load->helper('file');
			
			if( !is_dir( FCPATH.'assets/'.$modules.'/'.$module->mod_code ) ){
				mkdir( FCPATH.'assets/'.$modules.'/'.$module->mod_code, 0777, TRUE);
				$indexhtml = read_file( APPPATH .'index.html');
                write_file(FCPATH.'assets/'.$modules.'/'.$module->mod_code . '/index.html', $indexhtml);
			}

			write_file($main_js , '');
		}
		echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/edit.js"></script>';

		$custom_js = 'assets/'.$modules.'/'.$module->mod_code.'/edit_custom.js';
		
		if( file_exists( $custom_js ) )
		{
			echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/edit_custom.js"></script>';
		}		
	}
}

function get_detail_js( $module = array() )
{
	if( !empty( $module ) )
	{
		$ci=& MY_Controller::$instance; 
		$modules = 'modules';
		if(CLIENT_DIR != '' && is_dir(FCPATH.'assets/client/'.CLIENT_DIR.'/'.$module->mod_code.'/') ){
			$modules = 'client/'.CLIENT_DIR;
		}


		$main_js = FCPATH.'assets/'.$modules.'/'.$module->mod_code.'/detail.js';
		if( !file_exists( $main_js ) )
		{
			//create routine to include validations and include scripts here, todolater

			$ci->load->helper('file');
			
			if( !is_dir( FCPATH.'assets/'.$modules.'/'.$module->mod_code ) ){
				mkdir( FCPATH.'assets/'.$modules.'/'.$module->mod_code, 0777, TRUE);
				$indexhtml = read_file( APPPATH .'index.html');
                write_file(FCPATH.'assets/'.$modules.'/'.$module->mod_code . '/index.html', $indexhtml);
			}

			write_file($main_js , '');
		}
		echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/detail.js"></script>';

		$custom_js = 'assets/'.$modules.'/'.$module->mod_code.'/detail_custom.js';
		
		if( file_exists( $custom_js ) )
		{
			echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/detail_custom.js"></script>';
		}		
	}
}

function get_list_js( $module = array() )
{
	if( !empty( $module ) )
	{
		$ci=& MY_Controller::$instance; 
		$modules = 'modules';
		if(CLIENT_DIR != '' && is_dir(FCPATH.'assets/client/'.CLIENT_DIR.'/'.$module->mod_code.'/') ){
			$modules = 'client/'.CLIENT_DIR;
		}
		
		$main_js = FCPATH.'assets/'.$modules.'/'.$module->mod_code.'/lists.js';
		if( !file_exists( $main_js ) )
		{
			//create routine to include validations and include scripts here, todolater

			$ci->load->helper('file');
			
			if( !is_dir( FCPATH.'assets/'.$modules.'/'.$module->mod_code ) ){
				mkdir( FCPATH.'assets/'.$modules.'/'.$module->mod_code, 0777, TRUE);
				$indexhtml = read_file( APPPATH .'index.html');
                write_file(FCPATH.'assets/'.$modules.'/'.$module->mod_code . '/index.html', $indexhtml);
			}

			write_file($main_js , '');
		}
		echo '<script src="'.base_url().'assets/'.$modules.'/'.$module->mod_code.'/lists.js"></script>';	
	}
}

function create_menu_tree( $menu_list )
{ ?>
	<ol class="dd-list"> <?php
	foreach( $menu_list as $menu )
	{ ?>
		<li class="dd-item" data-id="<?php echo $menu['menu']->menu_item_id?>">
			<div class="dd-check">
				<input type="checkbox" parent_id="<?php echo $menu['menu']->parent_menu_item_id?>" class="menu-item" name="menu_item_id[]" menu_id="<?php echo $menu['menu']->menu_item_id?>" <?php if( $menu['menu']->checked ) echo 'checked="checked"';?> value="<?php echo $menu['menu']->menu_item_id?>">
			</div>
			<div class="dd-handle">
				<?php echo $menu['menu']->label?>
			</div>
			<span class="dd-action pull-right">
				<a href="javascript:quick_edit(<?php echo $menu['menu']->menu_item_id?>)"><i class="fa fa-pencil"></i> Edit</a>
				<?php if(property_exists($menu['menu'],'can_delete') && $menu['menu']->can_delete != 0 ){ ?>
            		<a href="javascript:delete_record(<?php echo $menu['menu']->menu_item_id?>, refresh_menu)"><i class="fa fa-trash-o"></i> Delete</a>
				<?php }else{ ?>
					<a disabled="disabled" onclick="return false" style="color:gray; text-decoration: none; cursor: default;" href="javascript:delete_record(<?php echo $menu['menu']->menu_item_id?>, refresh_menu)"><i class="fa fa-trash-o"></i> Delete</a>
				<?php } ?>
			</span><?php
			if( sizeof( $menu['children'] ) > 0 )
			{ 
				create_menu_tree( $menu['children'] );	
			} ?>
		</li> <?php
	} ?>
	</ol><?php
}

function get_system_config( $group, $item )
{
	$ci=& MY_Controller::$instance; 
	
	$config = $ci->load->config( $group );
	if( $config )
		if( isset( $config[$item] ) )
			return $config[$item];
		else
			false;
	else
		return false;
}

function get_system_series($series_code, $code, $increment = false )
{
    if($series_code == 'ID_NUMBER'){
        if(CLIENT_DIR == 'riofil'){
        	$series_code = 'RIOFIL_ID_NUMBER';
        }
        elseif(CLIENT_DIR == 'bayleaf'){
            $series_code = 'BAYLEAF_ID_NUMBER';
        }
        elseif(CLIENT_DIR == 'optimum'){
        	
        	switch($code){

        		case 'OSI': $series_code = 'OPTIMUM-OSI_ID_NUMBER'; break;
        		case 'OEME': $series_code = 'OPTIMUM-OEME_ID_NUMBER'; break;
        		case 'OIC': $series_code = 'OPTIMUM-OIC_ID_NUMBER'; break;
        		case 'OTI': $series_code = 'OPTIMUM-OTI_ID_NUMBER'; break;

        		default : $series_code = 'ID_NUMBER';
        	}
        }
    }

	$ci=& MY_Controller::$instance; 

	$ci->db->limit(1, 0);
	$system_series = $ci->db->get_where('system_series', array('series_code' => $series_code));
	$system_series_format = '';

	if($system_series && $system_series->num_rows() > 0){
		$system_series = $system_series->row();
		$format = $system_series->series_format;

		$sequence = ($increment) ? $system_series->sequence+1 : $system_series->sequence;
        
		if($series_code == 'ID_NUMBER'){
			if(strlen($sequence) < 3){
				$sequence = sprintf("%03d",$sequence);
			}

			$format = str_replace('{company_code}', $code, $format);
			$format = str_replace('{year}', date('y'), $format);
			$format = str_replace('{series}', $sequence, $format);

			$id_number_qry = "SELECT  partner_id, id_number
								FROM {$ci->db->dbprefix}partners 
								WHERE id_number = '{$format}' 
								AND deleted = 0
								LIMIT 1;
								";
			$idnum_sql = $ci->db->query( $id_number_qry );
			if($idnum_sql && $idnum_sql->num_rows() > 0){
				$format = get_system_series($series_code, $code, true);
			}
		}

		if($series_code == 'AHI_ID_NUMBER'){
			if(strlen($sequence) < 5){
				$sequence = sprintf("%05d",$sequence);
			}
			
			$format = $sequence;

			$id_number_qry = "SELECT  partner_id, id_number
								FROM {$ci->db->dbprefix}partners 
								WHERE id_number = '{$format}' 
								AND deleted = 0
								LIMIT 1;
								";
			$idnum_sql = $ci->db->query( $id_number_qry );
			if($idnum_sql && $idnum_sql->num_rows() > 0){
				$format = get_system_series($series_code, $code, true);
			}
		}

        if($series_code == 'RIOFIL_ID_NUMBER'){
            if(strlen($sequence) < 3){
				$sequence = sprintf("%03d",$sequence);
			}

			$format = str_replace('{project_code}', $code, $format);
			$format = str_replace('{series}', $sequence, $format);

			$id_number_qry = "SELECT  partner_id, id_number
								FROM {$ci->db->dbprefix}partners 
								WHERE id_number = '{$format}' 
								AND deleted = 0
								LIMIT 1;
								";
			$idnum_sql = $ci->db->query( $id_number_qry );
			if($idnum_sql && $idnum_sql->num_rows() > 0){
				$format = get_system_series($series_code, $code, true);
			}
        }

        if($series_code == 'BAYLEAF_ID_NUMBER'){
            $format = str_replace('{location_code}', $code, $format);
            $temp_format = str_replace('{series}', '', $format);
            
            $qry = "SELECT  partner_id, id_number
                                FROM {$ci->db->dbprefix}partners 
                                WHERE id_number LIKE '%{$temp_format}%' 
                                AND deleted = 0";
            
            $sql = $ci->db->query( $qry );                  
            if($sql && $sql->num_rows() > 0){
                $sequence = $sql->num_rows() + 1;
            }else{
                $sequence = 1;
            }

            if(strlen($sequence) < 5){
                $sequence = sprintf("%05d",$sequence);
            }

            $format = str_replace('{series}', $sequence, $format);

            $id_number_qry = "SELECT  partner_id, id_number
                                FROM {$ci->db->dbprefix}partners 
                                WHERE id_number = '{$format}' 
                                AND deleted = 0
                                LIMIT 1;
                                ";

            $idnum_sql = $ci->db->query( $id_number_qry );

            if($idnum_sql && $idnum_sql->num_rows() > 0){
                $format = get_system_series($series_code, $code, true);
            }
        }

        if($series_code == 'OPTIMUM-OSI_ID_NUMBER' || $series_code == 'OPTIMUM-OEME_ID_NUMBER' || $series_code == 'OPTIMUM-OIC_ID_NUMBER' || $series_code == 'OPTIMUM-OTI_ID_NUMBER'){
			if(strlen($sequence) < 3){
				$sequence = sprintf("%03d",$sequence);
			}

			if($code != 'OSI'){
				$format = str_replace('{company_code}', $code, $format);
			}
			else{
				$format = str_replace('{company_code}', '', $format);
			}

			$format = str_replace('{year}', date('Y'), $format);
			$format = str_replace('{series}', $sequence, $format);

			$id_number_qry = "SELECT  partner_id, id_number
								FROM {$ci->db->dbprefix}partners 
								WHERE id_number = '{$format}' 
								AND deleted = 0
								LIMIT 1;
								";
			$idnum_sql = $ci->db->query( $id_number_qry );
			if($idnum_sql && $idnum_sql->num_rows() > 0){
				$format = get_system_series($series_code, $code, true);
			}
		}

        if($series_code == 'PRF_CONTROL_NO'){
            

            $format = str_replace('{code}', $code, $format);
            $format = str_replace('{year}', date('y'), $format);
            $temp_format = str_replace('{series}', '', $format);
            

            $qry = "SELECT  request_id, document_no
                                FROM {$ci->db->dbprefix}recruitment_request 
                                WHERE document_no LIKE '%{$temp_format}%' 
                                AND deleted = 0";
     
            $sql = $ci->db->query( $qry );                  
            if($sql && $sql->num_rows() > 0){
                $sequence = $sql->num_rows() + 1;
            }else{
                $sequence = 1;
            }

            if(strlen($sequence) < 3){
                $sequence = sprintf("%03d",$sequence);
            }

            $format = str_replace('{series}', $sequence, $format);

            $id_number_qry = "SELECT  request_id, document_no
                                FROM {$ci->db->dbprefix}recruitment_request 
                                WHERE document_no = '{$format}' 
                                AND deleted = 0
                                LIMIT 1;
                                ";

            $idnum_sql = $ci->db->query( $id_number_qry );

            if($idnum_sql && $idnum_sql->num_rows() > 0){
                $format = get_system_series($series_code, $code, true);
            }
        }

		$system_series_format = $format;
	}

	return $system_series_format;

}

function get_mod_route( $mod_code, $uri = "", $add_base = true)
{
	$ci=& MY_Controller::$instance; 
	$routes = $ci->router->routes;
	foreach( $routes as $route => $controller )
	{
		$route = str_replace('^(en|id)/', '', $route);
		
		if( !empty($uri) )
			$route .= "/" . $uri;
		
		if($controller === $mod_code)
		{
			if( $add_base )
				return site_url( $route );
			else
				return $route;
		}
	}
}

function get_partner_id( $user_id = 0 ){
	$ci=& MY_Controller::$instance; 
	
	$ci->db->limit(1, 0);
	$partner = $ci->db->get_where('partners', array('user_id' => $user_id))->row();
	return $partner->partner_id;
}

function array_mesh() {
    // Combine multiple associative arrays and sum the values for any common keys
    // The function can accept any number of arrays as arguments
    // The values must be numeric or the summed value will be 0
     
    // Get the number of arguments being passed
    $numargs = func_num_args();
     
    // Save the arguments to an array
    $arg_list = func_get_args();
     
    // Create an array to hold the combined data
    $out = array();
 
    // Loop through each of the arguments
    for ($i = 0; $i < $numargs; $i++) {
        $in = $arg_list[$i]; // This will be equal to each array passed as an argument
 
        // Loop through each of the arrays passed as arguments
        foreach($in as $key => $value) {
            // If the same key exists in the $out array
            if(array_key_exists($key, $out)) {
                // Sum the values of the common key
                $sum = $in[$key] + $out[$key];
                // Add the key => value pair to array $out
                $out[$key] = $sum;
            }else{
                // Add to $out any key => value pairs in the $in array that did not have a match in $out
                $out[$key] = $in[$key];
            }
        }
    }
     
    return $out;
}

function is_mobile()
{
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
	else
		return false;
}

function date_local_timezone($date, $timezone)
{
	$datetime = new DateTime($date);
	$local_time = new DateTimeZone( $timezone );
	$datetime->setTimezone($local_time);
	return $datetime->format('Y-m-d H:i:s');
}

function localize_timeline($datetime, $timezone)
{
	$localdatetime = date_local_timezone( $datetime, $timezone );
	$localdatetime = strtotime( $localdatetime );
	$nowdatetime = date('Y-m-d H:i:s', time());
	$nowdatetime = date_local_timezone( $nowdatetime, $timezone );
	$nowdatetime = strtotime( $nowdatetime );

	$diff = ($nowdatetime - $localdatetime) / 60;
	$diff = round($diff);
	switch( true )
	{
		case $diff == 0:
			return 'just now';
			break;
		case $diff == 1:
			return '1 min ago';
			break;
		case $diff >= 2 && $diff < 60:
			return $diff .' mins ago';
			break;
		case $diff == 60:
			return 'an hr ago';
			break;
		case $diff > 60 && $diff < 1440:
			return floor( ($diff/60) ) .' hrs ago';
			break;
		case $diff == 1440:
			return 'a day ago';
			break;
		default:
			return date('M d, Y \a\t h:iA', $localdatetime);
	}
}

function no_days_between_dates( $from, $to )
{
	$from = strtotime($from);
	$to = strtotime($to);
	$datediff = $to - $from;
	return  floor($datediff/(60*60*24));
}


function int_to_month( $int )
{
	switch($int)
	{
		case 1:
			return 'January';
			break;
		case 2:
			return 'February';
			break;
		case 3:
			return 'March';
			break;
		case 4:
			return 'April';
			break;
		case 5:
			return 'May';
			break;
		case 6:
			return 'June';
			break;
		case 7:
			return 'July';
			break;
		case 8:
			return 'August';
			break;
		case 9:
			return 'September';
			break;
		case 10:
			return 'October';
			break;
		case 11:
			return 'November';
			break;
		case 12:
			return 'December';
			break;
	}
}

function get_photo( $photo )
{
	$photo = basename(base_url( $photo ));
	$image_dir_thumb = FCPATH.'uploads/users/thumbnail/';
	$image_dir_full  = FCPATH.'uploads/users/';
	$file_name_thumbnail = $image_dir_thumb . $photo;
	$file_name_full = $image_dir_full . $photo;
	
	if( !file_exists(urldecode($file_name_thumbnail)) )
	{
		$avatar = base_url( "uploads/users/avatar.png" );
	}
	else{
		$avatar = base_url( "uploads/users/thumbnail/" . $photo );	
	}

	if( file_exists(urldecode($file_name_full)) && !file_exists(urldecode($file_name_thumbnail)) )
	{
		$avatar = $full = base_url('uploads/users/'.$photo);
	}
	else{
		$full = $avatar;
	}

    return array(
    	'full' => $full,
    	'avatar' => $avatar
    );
}

function get_company_logo( $user_data=array() ){
	$ci=& MY_Controller::$instance; 

	$ci->db->select('*');
	$ci->db->from('users_profile up');
	$ci->db->join('users_company uc', 'up.company_id = uc.company_id');
	$ci->db->where('up.user_id', $user_data['user_id']); 
	$ci->db->limit(1, 0);
	$user_company = $ci->db->get()->row_array();

	if(array_key_exists('logo', $user_company)){
		$photo = basename(base_url( $user_company['logo'] ));
		$company_logo = FCPATH.$user_company['logo'];

		if( !file_exists(urldecode($company_logo)) || $user_company['logo'] == '' )
		{
			$ci->db->limit(1, 0);
			$system_configuration = $ci->db->get_where('config', array('key' => 'header_logo'))->row_array();
			$display_logo = base_url( $system_configuration['value'] );
		}
		else{
			$display_logo = base_url( $user_company['logo'] );	
			
		}
	}else{
		$ci->db->limit(1, 0);
		$system_configuration = $ci->db->get_where('config', array('key' => 'header_logo'))->row_array();
		$display_logo = base_url( $system_configuration['value'] );
	}

	return $display_logo;
}

function get_registered_company(){
	$ci=& MY_Controller::$instance; 

	$reg_company = array();

	$ci->db->where_in('key', array('registered_company', 'registered_address', 'registered_tin','registered_zipcode'));
	$system_configuration = $ci->db->get_where('config');
	if($system_configuration && $system_configuration->num_rows() > 0){
		foreach ($system_configuration->result_array() as $value) {
			$reg_company[$value['key']] = $value['value'];
		}
		return $reg_company;
	} else {
		return "";
	}

}

function get_time_form_id($form_code)
{
	$ci=& MY_Controller::$instance; 

	$ci->db->where('deleted', 0);
	$ci->db->where('can_view', 1);
	$ci->db->where('form_code', $form_code);
	$ci->db->limit(1, 0);
	$time_form = $ci->db->get('time_form');
	
	if($time_form && $time_form->num_rows() > 0){
		return $time_form->row()->form_id;
	}

	return false;

}

function convert_number_to_words($number) {
    
    $hyphen      = '-';
    $conjunction = ' ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' and ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= " " . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $number;
        }
        $dec = implode('',$words);
        $string .= $dec.'/100';
    }
    
    return $string;
}
