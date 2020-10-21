<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( !class_exists('Record') )
{
	require __DIR__ . '/record.php';
}

class demographic_model extends Record
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
		$this->mod_id = 126;
		$this->mod_code = 'demographic';
		$this->route = 'demographics';
		$this->url = site_url('demographics');
		$this->primary_key = 'x';
		$this->table = 'x';
		$this->icon = 'fa-folder';
		$this->short_name = 'Demographics';
		$this->long_name  = 'Demographics';
		$this->description = '';
		$this->path = APPPATH . 'modules/demographic/';

		parent::__construct();
	}

	function get_gender_per_status_data($company_id = 0, $department_id = 0, $date = 0)
    {
    	if( empty($date) )
    		$date = date('Y-m-d');
        else
            $date = date('Y-m-d', strtotime($date));

    	$male = array(
    		'grand_total' => 0,
    		'total' => array()
    	);
    	$female = array(
    		'grand_total' => 0,
    		'total' => array()
    	);
        $status = array();
    	$statuses = $this->db->get_where('partners_employment_status', array('deleted' => 0, 'active' => 1));
    	foreach( $statuses->result() as $_status )
    	{
    		$status[$_status->employment_status_id] = $_status;

            //male
    		$qry = "select a.* 
    		from {$this->db->dbprefix}partners a
    		LEFT JOIN {$this->db->dbprefix}partners_personal b on a.partner_id = b.partner_id
            LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
    		WHERE a.status_id={$_status->employment_status_id} AND b.key = 'gender' and b.key_value='Male' AND
            a.effectivity_date <= '{$date}' AND
            if( a.resigned_date is null or a.resigned_date = '0000-00-00', 1, a.resigned_date > '{$date}' )";
    		if( !empty( $company_id ) )
            {
                $qry .= " AND c.company_id = {$company_id}";
            }

            if( !empty( $department_id ) )
            {
                $qry .= " AND c.department_id = {$department_id}";
            }

            $res = $this->db->query( $qry );
            $male['grand_total'] += $res->num_rows();
    		$male['total'][$_status->employment_status_id] = $res->num_rows();

    		//female
    		$qry = "select a.* 
    		from {$this->db->dbprefix}partners a
    		LEFT JOIN {$this->db->dbprefix}partners_personal b on a.partner_id = b.partner_id
    		LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
            WHERE a.status_id={$_status->employment_status_id} AND b.key = 'gender' and b.key_value='Female' AND
            a.effectivity_date <= '{$date}' AND
            if( a.resigned_date is null or a.resigned_date = '0000-00-00', 1, a.resigned_date > '{$date}' )";
            if( !empty( $company_id ) )
            {
                $qry .= " AND c.company_id = {$company_id}";
            }

            if( !empty( $department_id ) )
            {
                $qry .= " AND c.department_id = {$department_id}";
            }

    		$res = $this->db->query( $qry );
    		$female['grand_total'] += $res->num_rows();
    		$female['total'][$_status->employment_status_id] = $res->num_rows();
    	}

    	return array('male' => $male, 'female' => $female, 'statuses' => $status,'status_count' => $statuses->num_rows());
    }

    function get_age_profile_data( $company_id = 0, $department_id = 0, $date = 0 )
    {
        $age_bracket = array(
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65 and Over' => 0
        );

        if( empty($date) )
            $date = date('Y-m-d');
        else
            $date = date('Y-m-d', strtotime($date));
    
        $qry = "SELECT b.birth_date 
        FROM ww_partners a
        LEFT JOIN ww_users_profile b ON b.user_id = a.user_id
        WHERE b.birth_date IS NOT NULL AND a.effectivity_date <= '{$date}' AND
        IF( a.resigned_date IS NULL OR a.resigned_date = '0000-00-00', 1, a.resigned_date > '{$date}' )";
        if( !empty( $company_id ) )
        {
            $qry .= " AND b.company_id = {$company_id}";
        }

        if( !empty( $department_id ) )
        {
            $qry .= " AND b.department_id = {$department_id}";
        }        
        $qry .= " ORDER BY b.birth_date";
        $bdates = $this->db->query( $qry );
        $total = $bdates->num_rows();
        $today   = new DateTime($date);
        foreach( $bdates->result() as $bdate )
        {
            $bage = new DateTime($bdate->birth_date);
            $age = $bage->diff($today)->y;
            switch( true )
            {
                case $age >= 18 AND $age <= 24:
                    $age_bracket['18-24']++;
                    break; 
                case $age >= 25 AND $age <= 34:
                    $age_bracket['25-34']++;
                    break; 
                case $age >= 35 AND $age <= 44:
                    $age_bracket['35-44']++;
                    break; 
                case $age >= 45 AND $age <= 54:
                    $age_bracket['45-54']++;
                    break; 
                case $age >= 55 AND $age <= 64:
                    $age_bracket['55-64']++;
                    break; 
                case $age >= 65:
                    $age_bracket['65 and Over']++;
                    break;  
            }
        }

        return array( 'total' => $total, 'age_bracket' => $age_bracket);
    }

    function get_gender_stats( $company_id = 0, $department_id = 0, $date = 0 )
    {
        $bracket = array(
            '18-24' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            ),
            '25-34' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            ),
            '35-44' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            ),
            '45-54' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            ),
            '55-64' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            ),
            '65 and Over' => array(
                'Male' => array('count' => 0, 'percentage' => 0),
                'Female' => array('count' => 0, 'percentage' => 0)
            )
        );

        $count = array(
            "Male" => 0,
            "Female" => 0
        );

        if( empty($date) )
            $date = date('Y-m-d');
        else
            $date = date('Y-m-d', strtotime($date));
    
        $qry = "SELECT b.birth_date, c.key_value
        FROM ww_partners a
        LEFT JOIN ww_users_profile b ON b.user_id = a.user_id
        LEFT JOIN ww_partners_personal c ON c.partner_id = a.partner_id and c.key = 'gender'
        WHERE b.birth_date IS NOT NULL AND a.effectivity_date <= '{$date}' AND
        IF( a.resigned_date IS NULL OR a.resigned_date = '0000-00-00', 1, a.resigned_date > '{$date}' )";
        if( !empty( $company_id ) )
        {
            $qry .= " AND b.company_id = {$company_id}";
        }

        if( !empty( $department_id ) )
        {
            $qry .= " AND b.department_id = {$department_id}";
        }        
        $qry .= " ORDER BY b.birth_date";
        $bdates = $this->db->query( $qry );
        $total = $bdates->num_rows();
        $today   = new DateTime($date);
        foreach( $bdates->result() as $bdate )
        {
            if(!empty($bdate->key_value))
            {
                $bdate->key_value = ucfirst($bdate->key_value);
                $bage = new DateTime($bdate->birth_date);
                $age = $bage->diff($today)->y;
                $count[$bdate->key_value]++;
                switch( true )
                {
                    case $age >= 18 AND $age <= 24:
                        $bracket['18-24'][$bdate->key_value]['count']++;
                        break; 
                    case $age >= 25 AND $age <= 34:
                        $bracket['25-34'][$bdate->key_value]['count']++;
                        break; 
                    case $age >= 35 AND $age <= 44:
                        $bracket['35-44'][$bdate->key_value]['count']++;
                        break; 
                    case $age >= 45 AND $age <= 54:
                        $bracket['45-54'][$bdate->key_value]['count']++;
                        break; 
                    case $age >= 55 AND $age <= 64:
                        $bracket['55-64'][$bdate->key_value]['count']++;
                        break; 
                    case $age >= 65:
                        $bracket['65 and Over'][$bdate->key_value]['count']++;
                        break;  
                }
            }
        }

        foreach( $bracket as $age_bracket => $gender_bracket )
        {
            foreach($bracket[$age_bracket] as $gender => $total)
            {
				if($count[$gender]==0)
					$bracket[$age_bracket][$gender]['percentage'] = 0;
				else
					$bracket[$age_bracket][$gender]['percentage'] = round($total['count'] / $count[$gender] * 100, 0);
            }   
        }

        return $bracket;
    }

    function get_type_per_status($company_id = 0, $department_id = 0, $date = 0)
    {
        if( empty($date) )
            $date = date('Y-m-d');
        else
            $date = date('Y-m-d', strtotime($date));

        $status = array();
        $type = array();
        $count = array();
        $statuses = $this->db->get_where('partners_employment_status', array('deleted' => 0, 'active' => 1));
        $types = $this->db->get_where('partners_employment_type', array('deleted' => 0));
        foreach( $statuses->result() as $_status )
        {
            foreach( $types->result() as $_type )
            {
                $qry = "select a.*
                FROM {$this->db->dbprefix}partners a
                LEFT JOIN ww_users_profile b ON b.user_id = a.user_id
                WHERE a.status_id={$_status->employment_status_id} and a.employment_type_id = {$_type->employment_type_id}";
                if( !empty( $company_id ) )
                {
                    $qry .= " AND b.company_id = {$company_id}";
                }

                if( !empty( $department_id ) )
                {
                    $qry .= " AND b.department_id = {$department_id}";
                } 

                $res = $this->db->query( $qry );
                if( $res->num_rows() != 0 )
                {
                    $count[$_status->employment_status_id][$_type->employment_type_id] = $res->num_rows();
                    $type[$_type->employment_type_id] = $_type;
                    $status[$_status->employment_status_id] = $_status;
                }
            }
        }

        return array('status' => $status, 'type' => $type, 'total_status' => sizeof($status), 'total_types' => sizeof($type), 'count' => $count);
    }

    function get_tenure_stats( $company_id = 0, $department_id = 0, $date = 0 )
    {
        $cdate = strtotime( date('Y-m-d') );
        if( empty($date) )
            $date = date('Y-m-d');
        else{
            $date = date('Y-m-d', strtotime($date));
            $cdate = strtotime( $date );
        }
        
        $tenure = array(
            'Below 1 yr' => 0,
            '1 - 5 yrs' => 0,
            '6 - 10 yrs' => 0,
            '11 - 20 yrs' => 0,
            'Above 20 yrs' => 0,
        );

        $qry = "select a.effectivity_date
        FROM {$this->db->dbprefix}partners a
        LEFT JOIN {$this->db->dbprefix}users b on b.user_id = a.user_id
        LEFT JOIN {$this->db->dbprefix}users_profile c on c.user_id = a.user_id
        WHERE a.deleted = 0 AND b.deleted = 0 AND b.active = 1 AND a.status_id < 8 AND
        (a.resigned_date > '{$date}' OR a.resigned_date IS NULL OR a.resigned_date = '0000-00-00')";

        if( !empty( $company_id ) )
        {
            $qry .= " AND c.company_id = {$company_id}";
        }

        if( !empty( $department_id ) )
        {
            $qry .= " AND c.department_id = {$department_id}";
        }

        $partners = $this->db->query( $qry );
        foreach( $partners->result() as $partner )
        {
            $hdate = strtotime( $partner->effectivity_date );
            $service = $cdate - $hdate;
            $service = date('Y', $service);
            $service = $service - 1970;
            switch( true )
            {
                case $service == 0:
                    $tenure['Below 1 yr']++;
                    break;
                case $service <= 5:
                    $tenure['1 - 5 yrs']++;
                    break;
                case $service <= 10:
                    $tenure['6 - 10 yrs']++;
                    break;
                case $service <= 20:
                    $tenure['11 - 20 yrs']++;
                    break;
                default:
                    $tenure['Above 20 yrs']++;
            }
        }

        $total = $partners->num_rows();
        return array( 'tenure' => $tenure, 'total' => $total);
    }

    function get_population_division_status( $company_id = 0, $department_id = 0, $date = 0 )
    {
        $cdate = strtotime( date('Y-m-d') );
        if( empty($date) )
            $date = date('Y-m-d');
        else{
            $date = date('Y-m-d', strtotime($date));
            $cdate = strtotime( $date );
        }
        
        $qry = "SELECT IFNULL(IF(TRIM(pp.key_value)='','(not set)',TRIM(pp.key_value)),'(not set)') AS city, COUNT(up.partner_id) population
   
                FROM users_profile up
                JOIN partners p ON p.user_id = up.user_id
                JOIN ww_partners_personal pp ON pp.partner_id = up.partner_id
                JOIN ww_partners_key pk ON pk.key_id = pp.key_id AND UPPER(pk.key_code) = 'CITY_TOWN'

                WHERE up.active = '1' AND (p.resigned_date > '{$date}' OR p.resigned_date IS NULL OR p.resigned_date = '0000-00-00')";

        if( !empty( $company_id ) )
        {
            $qry .= " AND up.company_id = {$company_id}";
        }

        if( !empty( $department_id ) )
        {
            $qry .= " AND up.department_id = {$department_id}";
        }

        $qry .= " GROUP BY 1 ORDER BY population DESC, 2";

        $population = $this->db->query( $qry );
 
        $total = '';
        $percent = '';
        foreach( $population->result() as $result )
        {
           $total += $result->population;
        }

        foreach( $population->result() as $result )
        {
           $result->percent = round($result->population/$total * 100, 0);
        }
        // $single_male_percent = round($total_single_male/$total * 100, 0);
        // $single_female_percent = round($total_single_female/$total * 100, 0);
        // $other_male_percent = round($total_other_male/$total * 100, 0);
        // $other_female_percent = round($total_other_female/$total * 100, 0);

        return array( 
                'population' => $population->result(), 
                'total' => $total
            );
    }

    function get_long_lat( $company_id = 0, $department_id = 0, $date = 0)
    {
        $cdate = strtotime( date('Y-m-d') );
        if( empty($date) )
            $date = date('Y-m-d');
        else{
            $date = date('Y-m-d', strtotime($date));
            $cdate = strtotime( $date );
        }

        $qry = "SELECT pp.key_value as long_lat, u.full_name as alias, up.photo, up.company, pos.position

        FROM users_profile up
        JOIN ww_partners p ON p.user_id = up.user_id
        LEFT JOIN ww_partners_personal pp ON pp.partner_id = up.partner_id AND pp.key_id = '195'
        LEFT JOIN ww_users_position pos ON pos.position_id = up.position_id
        LEFT JOIN ww_users u on u.user_id = up.user_id
        
        WHERE up.active = '1'
        AND (p.resigned_date > '{$date}' OR p.resigned_date IS NULL OR p.resigned_date = '0000-00-00')
        AND pp.key_value  IS NOT NULL
        ";

        if( !empty( $company_id ) )
        {
            $qry .= " AND up.company_id = {$company_id}";
        }

        if( !empty( $department_id ) )
        {
            $qry .= " AND up.department_id = {$department_id}";
        }

        $data = $this->db->query( $qry );

        $result = array();
        $image_dir_thumb = FCPATH.'uploads/users/thumbnail';
        $image_dir_full = FCPATH.'uploads/users';

        $result = $data->result();

        foreach($result as $row)
        {
            $img = basename(base_url($row->photo));
            $file_name_thumbnail = $image_dir_thumb.$img;
            $file_name_full = $image_dir_full.$img;

            if(file_exists($file_name_thumbnail)){
                $img = base_url()."uploads/users/thumbnail".$img;
            }
            else if(file_exists($file_name_full)){
                $img = base_url()."uploads/users/thumbnail".$img;
            }
            else{
                $img = base_url()."uploads/users/thumbnail/avatar.png";
            }

            $row->photo = $img;
        }

        // debug($result);
        return array( 'data' => $data->result(), 'count' => $data->num_rows() );
    }

}