<?php
    if( !empty( $header->template ) )
    {
        echo $this->parser->parse_string($header->template, $vars, TRUE);
    }
?>

<?php
    //prep data
    $result = $result->result_array();
    $headers = array();
    $template = '';
    


 foreach ($result as $key => $row) { 
    if($r_company == 'all'){
        $company = ucfirst($r_company);
    } else {
        $company = $row['Company Id'];
        $company_name = $row['Company'];
    }
}
// Headers
$dept = $this->db->query("SELECT GROUP_CONCAT(CONCAT('''',department ,'''') ORDER BY department) as dept_name
                            FROM ww_users_department
                            WHERE deleted = 0");
$dept = $dept->row()->dept_name;
$dept = explode(',', $dept);


$proj = $this->db->query("SELECT GROUP_CONCAT(CONCAT('''',`project`,'''') ORDER BY project) as proj_name
                            FROM ww_users_project   
                            WHERE deleted = 0");
$proj = $proj->row()->proj_name;
$proj = explode("','", $proj);
// regular
// get above manager active
$dep_reg_mgr = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 1, ''1,2,3,4'' , $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_mgr = $dep_reg_mgr->row()->dept;
// get above manager inactive
$dep_reg_mgr_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 1, ''1,2,3,4'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_mgr_inc = $dep_reg_mgr_inc->row()->dept;
// get asst mgr active
$dep_reg_asst = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 1, ''10'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_asst = $dep_reg_asst->row()->dept;
// get asst mgr inactive
$dep_reg_asst_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 1, ''10'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_asst_inc = $dep_reg_asst_inc->row()->dept;
// get oth mgr active
$dep_reg_oth = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 1, ''5,6'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_oth = $dep_reg_oth->row()->dept;
// get oth mgr inactive
$dep_reg_oth_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 1, ''5,6'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_reg_oth_inc = $dep_reg_oth_inc->row()->dept;


// PROJECT
// get above manager active
$pro_reg_mgr = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 1, ''1,2,3,4'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_reg_mgr = $pro_reg_mgr->row()->proj;
// get above manager inactive
$pro_reg_mgr_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 1, ''1,2,3,4'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_reg_mgr_inc = $pro_reg_mgr_inc->row()->proj;
// get asst mgr active
$pro_reg_asst = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 1, ''10'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_reg_asst = $pro_reg_asst->row()->proj;

// get asst mgr inactive
$pro_reg_asst_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 1, ''10'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_reg_asst_inc = $pro_reg_asst_inc->row()->proj;
// get oth mgr active
$pro_reg_oth = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 1, ''5,6'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_reg_oth = $pro_reg_oth->row()->proj;
// get oth mgr inactive
$pro_reg_oth_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 1, ''5,6'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_reg_oth_inc = $pro_reg_oth_inc->row()->proj;


// project employee
// get above manager active
$dep_pe_mgr = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 4, ''1,2,3,4'' , $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_mgr = $dep_pe_mgr->row()->dept;
// get above manager inactive
$dep_pe_mgr_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 4, ''1,2,3,4'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_mgr_inc = $dep_pe_mgr_inc->row()->dept;
// get asst mgr active
$dep_pe_asst = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 4, ''10'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_asst = $dep_pe_asst->row()->dept;
// get asst mgr inactive
$dep_pe_asst_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 4, ''10'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_asst_inc = $dep_pe_asst_inc->row()->dept;
// get oth mgr active
$dep_pe_oth = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 1, ''Department'', 4, ''5,6'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_oth = $dep_pe_oth->row()->dept;
// get oth mgr inactive
$dep_pe_oth_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',department_id,', 0, ''Department'', 4, ''5,6'' ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_pe_oth_inc = $dep_pe_oth_inc->row()->dept;


// PROJECT
// get above manager active
$pro_pe_mgr = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 4, ''1,2,3,4'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_pe_mgr = $pro_pe_mgr->row()->proj;
// get above manager inactive
$pro_pe_mgr_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 4, ''1,2,3,4'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_pe_mgr_inc = $pro_pe_mgr_inc->row()->proj;
// get asst mgr active
$pro_pe_asst = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 4, ''10'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_pe_asst = $pro_pe_asst->row()->proj;

// get asst mgr inactive
$pro_pe_asst_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 4, ''10'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_pe_asst_inc = $pro_pe_asst_inc->row()->proj;
// get oth mgr active
$pro_pe_oth = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 1, ''Project'', 4, ''5,6'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_pe_oth = $pro_pe_oth->row()->proj;
// get oth mgr inactive
$pro_pe_oth_inc = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count(',project_id,', 0, ''Project'', 4, ''5,6'' ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_pe_oth_inc = $pro_pe_oth_inc->row()->proj;

//monthly
//department
$dep_monthly_active = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',department_id,', 1,''Department'', 2 ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_monthly_active = $dep_monthly_active->row()->dept;

$dep_monthly_inactive = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',department_id,', 0,''Department'', 2 ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");

$dep_monthly_inactive = $dep_monthly_inactive->row()->dept;
//project
$pro_monthly_active = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',project_id,', 1,''Project'', 2 ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_monthly_active = $pro_monthly_active->row()->proj;

$pro_monthly_inactive = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',project_id,', 0,''Project'', 2 ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_monthly_inactive = $pro_monthly_inactive->row()->proj;

//daily
//department
$dep_daily_active = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',department_id,', 1,''Department'', 6 ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");
$dep_daily_active = $dep_daily_active->row()->dept;

$dep_daily_inactive = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',department_id,', 0,''Department'', 6 ,  $company ) as ''',department,'''') ORDER BY department) AS dept  
                                FROM ww_users_department 
                                WHERE deleted = 0");

$dep_daily_inactive = $dep_daily_inactive->row()->dept;
//project
$pro_daily_active = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',project_id,', 1,''Project'', 6 ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");
$pro_daily_active = $pro_daily_active->row()->proj;

$pro_daily_inactive = $this->db->query("SELECT GROUP_CONCAT(CONCAT('get_manpower_count_by_rate_type(',project_id,', 0,''Project'', 6 ,  $company ) as ''',project,'''') ORDER BY project) AS proj  
                                FROM ww_users_project 
                                WHERE deleted = 0");

$pro_daily_inactive = $pro_daily_inactive->row()->proj;



//Regular
//Department
$arr_dep_reg_mgr = $this->db->query("SELECT $dep_reg_mgr");
$arr_dep_reg_mgr = $arr_dep_reg_mgr->result_array();

$arr_dep_reg_mgr_inc = $this->db->query("SELECT $dep_reg_mgr_inc");
$arr_dep_reg_mgr_inc = $arr_dep_reg_mgr_inc->result_array();

$arr_dep_reg_asst = $this->db->query("SELECT $dep_reg_asst");
$arr_dep_reg_asst = $arr_dep_reg_asst->result_array();

$arr_dep_reg_asst_inc = $this->db->query("SELECT $dep_reg_asst_inc");
$arr_dep_reg_asst_inc = $arr_dep_reg_asst_inc->result_array();

$arr_dep_reg_oth = $this->db->query("SELECT $dep_reg_oth");
$arr_dep_reg_oth = $arr_dep_reg_oth->result_array();

$arr_dep_reg_oth_inc = $this->db->query("SELECT $dep_reg_oth_inc");
$arr_dep_reg_oth_inc = $arr_dep_reg_oth_inc->result_array();

//Project
$arr_pro_reg_mgr = $this->db->query("SELECT $pro_reg_mgr");
$arr_pro_reg_mgr = $arr_pro_reg_mgr->result_array();

$arr_pro_reg_mgr_inc = $this->db->query("SELECT $pro_reg_mgr_inc");
$arr_pro_reg_mgr_inc = $arr_pro_reg_mgr_inc->result_array();

$arr_pro_reg_asst = $this->db->query("SELECT $pro_reg_asst");
$arr_pro_reg_asst = $arr_pro_reg_asst->result_array();

$arr_pro_reg_asst_inc = $this->db->query("SELECT $pro_reg_asst_inc");
$arr_pro_reg_asst_inc = $arr_pro_reg_asst_inc->result_array();

$arr_pro_reg_oth = $this->db->query("SELECT $pro_reg_oth");
$arr_pro_reg_oth = $arr_pro_reg_oth->result_array();

$arr_pro_reg_oth_inc = $this->db->query("SELECT $pro_reg_oth_inc");
$arr_pro_reg_oth_inc = $arr_pro_reg_oth_inc->result_array();

//Project Employee
//Department
$arr_dep_pe_mgr = $this->db->query("SELECT $dep_pe_mgr");
$arr_dep_pe_mgr = $arr_dep_pe_mgr->result_array();

$arr_dep_pe_mgr_inc = $this->db->query("SELECT $dep_pe_mgr_inc");
$arr_dep_pe_mgr_inc = $arr_dep_pe_mgr_inc->result_array();

$arr_dep_pe_asst = $this->db->query("SELECT $dep_pe_asst");
$arr_dep_pe_asst = $arr_dep_pe_asst->result_array();

$arr_dep_pe_asst_inc = $this->db->query("SELECT $dep_pe_asst_inc");
$arr_dep_pe_asst_inc = $arr_dep_pe_asst_inc->result_array();

$arr_dep_pe_oth = $this->db->query("SELECT $dep_pe_oth");
$arr_dep_pe_oth = $arr_dep_pe_oth->result_array();

$arr_dep_pe_oth_inc = $this->db->query("SELECT $dep_pe_oth_inc");
$arr_dep_pe_oth_inc = $arr_dep_pe_oth_inc->result_array();

//Project
$arr_pro_pe_mgr = $this->db->query("SELECT $pro_pe_mgr");
$arr_pro_pe_mgr = $arr_pro_pe_mgr->result_array();

$arr_pro_pe_mgr_inc = $this->db->query("SELECT $pro_pe_mgr_inc");
$arr_pro_pe_mgr_inc = $arr_pro_pe_mgr_inc->result_array();

$arr_pro_pe_asst = $this->db->query("SELECT $pro_pe_asst");
$arr_pro_pe_asst = $arr_pro_pe_asst->result_array();

$arr_pro_pe_asst_inc = $this->db->query("SELECT $pro_pe_asst_inc");
$arr_pro_pe_asst_inc = $arr_pro_pe_asst_inc->result_array();

$arr_pro_pe_oth = $this->db->query("SELECT $pro_pe_oth");
$arr_pro_pe_oth = $arr_pro_pe_oth->result_array();

$arr_pro_pe_oth_inc = $this->db->query("SELECT $pro_pe_oth_inc");
$arr_pro_pe_oth_inc = $arr_pro_pe_oth_inc->result_array();

//monthly
$arr_pro_monthly_active = $this->db->query("SELECT $pro_monthly_active");
$arr_pro_monthly_active = $arr_pro_monthly_active->result_array();

$arr_dep_monthly_active = $this->db->query("SELECT $dep_monthly_active");
$arr_dep_monthly_active = $arr_dep_monthly_active->result_array();

$arr_pro_monthly_inactive = $this->db->query("SELECT $pro_monthly_inactive");
$arr_pro_monthly_inactive = $arr_pro_monthly_inactive->result_array();

$arr_dep_monthly_inactive = $this->db->query("SELECT $dep_monthly_inactive");
$arr_dep_monthly_inactive = $arr_dep_monthly_inactive->result_array();

//daily
$arr_pro_daily_active = $this->db->query("SELECT $pro_daily_active");
$arr_pro_daily_active = $arr_pro_daily_active->result_array();

$arr_dep_daily_active = $this->db->query("SELECT $dep_daily_active");
$arr_dep_daily_active = $arr_dep_daily_active->result_array();

$arr_pro_daily_inactive = $this->db->query("SELECT $pro_daily_inactive");
$arr_pro_daily_inactive = $arr_pro_daily_inactive->result_array();

$arr_dep_daily_inactive = $this->db->query("SELECT $dep_daily_inactive");
$arr_dep_daily_inactive = $arr_dep_daily_inactive->result_array();


//Fot total
$reg_manager_total = 0;
$reg_manager_inc_total = 0;
$reg_assist_total = 0;
$reg_assist_inc_total = 0;
$reg_others_total = 0;
$reg_others_inc_total = 0;

$pro_manager_total = 0;
$pro_manager_inc_total = 0;
$pro_assist_total = 0;
$pro_assist_inc_total = 0;
$pro_others_total = 0;
$pro_others_inc_total = 0;
?>

    

 <table  style="page-break-after:always;">
    <tr>
        <td colspan="<?php echo count($dept) + count($proj) + 2; ?>" width="100%" style="text-align:center; font-size:10; "><strong><?php echo $company_name; ?> Manpower Status</strong></td>
    </tr>
    <tr>
        <td colspan="<?php echo count($dept) + count($proj) + 2; ?>" width="100%" style="text-align:center; font-size:10; "><strong>As of <?php echo date("F d, Y"); ?></strong></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;"></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;"></td>
        <td colspan="<?php echo count($dept); ?>" width="100%" style="text-align:left;">Co</td>
        <td width="100%" style="text-align:left;">LTI Office</td>
        <td colspan="<?php echo count($proj); ?>" width="100%" style="text-align:left;">Project</td>
        <td rowspan="3" width="100%" style="text-align:left;">Total</td>
    </tr>
    <tr>
        <td width="100%" style="text-align:center; font-size:10; "></td>
<?php
    $dept_count = count($dept);
    foreach ($dept as $value) { ?>
        
            <td rowspan="2" width="100%" style="text-align:center; font-size:10; "><?php echo str_replace("'", "", $value); ?></td>
            
    <?php } ?>
    <td rowspan="2" width="100%" style="text-align:center; font-size:10; ">Equip.</td>

    <?php 
    $proj_count = count($proj);
    foreach ($proj as $value) { ?>
        
            <td rowspan="2" width="100%" style="text-align:center; font-size:10; "><?php echo str_replace("'", "", $value); ?></td>
       
    <?php } ?>
     </tr>

    <?php
    //Department Regular
    $total_act = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_act[$i] = 0;
    }
    $total_inact = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_inact[$i] = 0;
    }
    //Project Regular
    $total_act_proj = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_act_proj[$i] = 0;
    }
    $total_inact_proj = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_inact_proj[$i] = 0;
    }

    //Department Project Employee
    $total_act_pe = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_act_pe[$i] = 0;
    }
    $total_inact_pe = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_inact_pe[$i] = 0;
    }
    //Project Project Employee
    $total_act_proj_pe = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_act_proj_pe[$i] = 0;
    }
    $total_inact_proj_pe = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_inact_proj_pe[$i] = 0;
    }

    //Department Monthly
    $total_act_gt = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_act_gt[$i] = 0;
    }
    $total_inact_gt = array();
    for ($i=0; $i < $dept_count; $i++) { 
        $total_inact_gt[$i] = 0;
    }
    //Project Monthy
    $total_act_proj_gt = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_act_proj_gt[$i] = 0;
    }
    $total_inact_proj_gt = array();
    for ($i=0; $i < $proj_count; $i++) { 
        $total_inact_proj_gt[$i] = 0;
    }

     ?>
     <!-- debug($total1); -->
    <tr>
        <td width="100%" style="text-align:left;"></td>
    </tr>
    
     <tr>
        <td width="100%" style="text-align:left;">Current Employee</td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Regular</td>
    </tr>

    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Manager and above</td>
        <?php
         $dep_reg_mngr_tot = 0;
         $pro_reg_mngr_tot = 0;
         foreach ($arr_dep_reg_mgr as $key => $row) {
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_mngr_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_reg_mgr as $key => $row) {
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_reg_mngr_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_mngr_tot + $pro_reg_mngr_tot; ?></td>
        <?php $reg_manager_total = $dep_reg_mngr_tot + $pro_reg_mngr_tot;  ?>
    </tr>
    <tr>
        <?php 
        $dep_reg_mngr_inc_tot = 0;
         $pro_reg_mngr_inc_tot = 0;
        foreach ($arr_dep_reg_mgr_inc as $key => $row) { 
              $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_mngr_inc_tot += $val; }} ?>   
         <td width="100%" style="text-align:left;"></td>
         <?php foreach ($arr_pro_reg_mgr_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $pro_reg_mngr_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_mngr_inc_tot + $pro_reg_mngr_inc_tot; ?></td>
        <?php $reg_manager_inc_total = $dep_reg_mngr_inc_tot + $pro_reg_mngr_inc_tot;  ?>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Assistant Manager</td>
        <?php
        $dep_reg_asst_tot = 0;
         $pro_reg_asst_tot = 0;
         foreach ($arr_dep_reg_asst as $key => $row) { 
              $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_asst_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_reg_asst as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_reg_asst_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_asst_tot + $pro_reg_asst_tot; ?></td>
        <?php $reg_assist_total = $dep_reg_asst_tot + $pro_reg_asst_tot;  ?>
    </tr>
    <tr>
        <?php 
        $dep_reg_asst_inc_tot = 0;
         $pro_reg_asst_inc_tot = 0;
        foreach ($arr_dep_reg_asst_inc as $key => $row) { 
              $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact[$a] += $val;
                    $a++;
                ?>
                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_asst_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_reg_asst_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_reg_asst_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_asst_inc_tot + $pro_reg_asst_inc_tot; ?></td>
        <?php $reg_assist_inc_total = $dep_reg_asst_inc_tot + $pro_reg_asst_inc_tot;  ?>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Others</td>
        <?php
        $dep_reg_oth_tot = 0;
         $pro_reg_oth_tot = 0;
         foreach ($arr_dep_reg_oth as $key => $row) { 
              $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act[$a] += $val;
                    $a++;
                ?>
                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_oth_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_reg_oth as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_reg_oth_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_oth_tot + $pro_reg_oth_tot; ?></td>
        <?php $reg_others_total = $dep_reg_oth_tot + $pro_reg_oth_tot;  ?>
    </tr>
    <tr>
        <?php 
        $dep_reg_oth_inc_tot = 0;
         $pro_reg_oth_inc_tot = 0;
        foreach ($arr_dep_reg_oth_inc as $key => $row) { 
              $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_reg_oth_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_reg_oth_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj[$a] += $val;
                    $a++;
                ?>


                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_reg_oth_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_reg_oth_inc_tot + $pro_reg_oth_inc_tot; ?></td>
        <?php $reg_others_inc_total = $dep_reg_oth_inc_tot + $pro_reg_oth_inc_tot;  ?>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;v-align:middle;font-color:red;">Total</td>

        <?php
        $dep_act_tot = 0;
         $pro_act_tot = 0;
         foreach ($total_act as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $dep_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_act_proj as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $pro_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_act_tot + $pro_act_tot; ?></td>
    </tr>
    <tr>       
        <?php
        $dep_inact_tot = 0;
         $pro_inact_tot = 0;
         foreach ($total_inact as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $dep_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_inact_proj as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $pro_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_inact_tot + $pro_inact_tot; ?></td>
    </tr>
    <tr>
        <td width="100%" style="text-align:left;">Project</td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Manager and above</td>
        <?php
        $dep_pe_mgr_tot = 0;
         $pro_pe_mgr_tot = 0;
         foreach ($arr_dep_pe_mgr as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_pe_mgr_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_pe_mgr as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_mgr_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_mgr_tot + $pro_pe_mgr_tot; ?></td>
    </tr>
    <tr>
        <?php 
        $dep_pe_mgr_inc_tot = 0;
         $pro_pe_mgr_inc_tot = 0;
        foreach ($arr_dep_pe_mgr_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_pe_mgr_inc_tot += $val;  }} ?>   
         <td width="100%" style="text-align:left;"></td>
         <?php foreach ($arr_pro_pe_mgr_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_mgr_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_mgr_inc_tot + $pro_pe_mgr_inc_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Assistant Manager</td>
        <?php
        $dep_pe_asst_tot = 0;
         $pro_pe_asst_tot = 0;
         foreach ($arr_dep_pe_asst as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_pe_asst_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_pe_asst as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_asst_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_asst_tot + $pro_pe_asst_tot; ?></td>
    </tr>
    <tr>
        <?php 
        $dep_pe_asst_inc_tot = 0;
         $pro_pe_asst_inc_tot = 0;
        foreach ($arr_dep_pe_asst_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_pe_asst_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_pe_asst_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_asst_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_asst_inc_tot + $pro_pe_asst_inc_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Others</td>
        <?php
        $dep_pe_oth_tot = 0;
         $pro_pe_oth_tot = 0;
         foreach ($arr_dep_pe_oth as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_pe_oth_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_pe_oth as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_oth_tot += $val;} }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_oth_tot + $pro_pe_oth_tot; ?></td>
    </tr>
    <tr>
        <?php 
        $dep_pe_oth_inc_tot = 0;
         $pro_pe_oth_inc_tot = 0;
        foreach ($arr_dep_pe_oth_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $dep_pe_oth_inc_tot += $val; }} ?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_pe_oth_inc as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj_pe[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_pe_oth_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_pe_oth_inc_tot + $pro_pe_oth_inc_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;v-align:middle;font-color:red;">Total</td>
        
        <?php
        $dep_act_tot = 0;
         $pro_act_tot = 0;

         foreach ($total_act_pe as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $dep_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_act_proj_pe as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $pro_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_act_tot + $pro_act_tot; ?></td>
    </tr>
    <tr>       
        <?php
        $dep_inact_tot = 0;
         $pro_inact_tot = 0;

         foreach ($total_inact_pe as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $dep_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_inact_proj_pe as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $pro_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_inact_tot + $pro_inact_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Monthly Total</td>
        <?php
        $dep_monthly_tot = 0;
         $pro_monthly_tot = 0;
         foreach ($arr_dep_monthly_active as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_monthly_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_monthly_active as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_monthly_tot += $val;} }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_monthly_tot + $pro_monthly_tot; ?></td>
    </tr>
    <tr>
        <?php
        $dep_monthly_inc_tot = 0;
         $pro_monthly_inc_tot = 0;
         foreach ($arr_dep_monthly_inactive as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_monthly_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_monthly_inactive as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_monthly_inc_tot += $val;} }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_monthly_inc_tot + $pro_monthly_inc_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;">Daily</td>
        <?php
        $dep_daily_tot = 0;
         $pro_daily_tot = 0;
         foreach ($arr_dep_daily_active as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_daily_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_daily_active as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_act_proj_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_daily_tot += $val;} }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_daily_tot + $pro_daily_tot; ?></td>
    </tr>
    <tr>
        <?php
        $dep_daily_inc_tot = 0;
         $pro_daily_inc_tot = 0;
         foreach ($arr_dep_daily_inactive as $key => $row) { 
            $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php  $dep_daily_inc_tot += $val; } }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($arr_pro_daily_inactive as $key => $row) { 
           $a = 0; 
            foreach($row as $key2 => $val){
                    $total_inact_proj_gt[$a] += $val;
                    $a++;
                ?>

                <td width="100%" style="text-align:center; font-size:10; "><?php echo $val; ?></td>
                
        <?php $pro_daily_inc_tot += $val;} }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_daily_inc_tot + $pro_daily_inc_tot; ?></td>
    </tr>
    <tr>
        <td rowspan="2" width="100%" style="text-align:left;v-align:middle;font-color:red;">G Total</td>

        <?php
        $dep_act_tot = 0;
         $pro_act_tot = 0;
         foreach ($total_act_gt as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $dep_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_act_proj_gt as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10;font-color:red; "><?php echo $row; ?></td>
                
        <?php $pro_act_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_act_tot + $pro_act_tot; ?></td>
    </tr>
    <tr>       
        <?php
        $dep_inact_tot = 0;
         $pro_inact_tot = 0;
         foreach ($total_inact_gt as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $dep_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"></td>
        <?php
         foreach ($total_inact_proj_gt as $key => $row) { ?>

                <td width="100%" style="text-align:center; font-size:10; font-color:red;"><?php echo $row; ?></td>
                
        <?php $pro_inact_tot += $row; }?>
        <td width="100%" style="text-align:left;"><?php echo $dep_inact_tot + $pro_inact_tot; ?></td>
    </tr>

<?php
    // exit();
    if( !empty( $footer->template ) )
    {
        echo $this->parser->parse_string($footer->template, $vars, TRUE);
    }
?>