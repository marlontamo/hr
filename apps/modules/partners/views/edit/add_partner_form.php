<form class="form-horizontal" name="add-partner-form" id="add-partner-form">
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="bl_container">
                    <div class="portlet-body">

                        <div class="col-md-12" id="partners_add_basic">
                            <div class="portlet">
                                <div class="portlet-title">
                                    <h4>Basic Information</h4>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <input type="hidden" class="form-control" name="record_id" id="record_id" value=""/>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Title<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                               <i class="fa fa-list-ul"></i>
                                                             </span>
                                                        <select data-placeholder="Select..." class="form-control select2me" name="users_profile[title]" id="users_profile-title" >
                                                            <option value="">Select...</option>
                                                            <option value="Mr.">Mr.</option>
                                                            <option value="Mrs.">Mrs.</option>
                                                            <option value="Miss">Miss</option>
                                                        </select>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Last Name<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="users_profile[lastname]" id="users_profile-lastname" placeholder="Enter Last Name"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">First Name<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="users_profile[firstname]" id="users_profile-firstname" placeholder="Enter First Name"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Middle Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="users_profile[middlename]" id="users_profile-middlename" placeholder="Enter Middle Name"/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- END FORM--> 
                                </div>
                            </div>
                            <div class="portlet">
                                <div class="portlet-title">
                                    <h4>Company Information</h4>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Company<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('company_id,company');
                                                        $db->where('deleted', '0');
														$db->order_by('company');
                                                        $options = $db->get('users_company');
                                                    ?>
                                                   <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-building"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[company_id]" id="users_profile-company_id">                                                            
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->company_id == $record['users_profile.company_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->company_id.'">'.$option->company.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Department<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('department_id,department');
                                                        $db->where('deleted', '0');
														$db->order_by('department');
                                                        $options = $db->get('users_department');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[department_id]" id="users_profile-department_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->department_id == $record['users_profile.department_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->department_id.'">'.$option->department.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if (in_array('division', $partners_keys)) { ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Division</label>
                                                <div class="col-md-8">
                                                <?php   $db->select('division_id,division');
                                                        $db->where('deleted', '0');
														$db->order_by('division');
                                                        $options = $db->get('users_division');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[division_id]" id="users_profile-division_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->division_id == $record['users_profile.division_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->division_id.'">'.$option->division.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <?php if (in_array('branch', $partners_keys)) { ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Branch</label>
                                                <div class="col-md-8">
                                                <?php   $db->select('branch_id,branch');
                                                        $db->where('deleted', '0');
														$db->order_by('branch');
                                                        $options = $db->get('users_branch');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[branch_id]" id="users_profile-branch_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->branch_id == $record['users_profile.branch_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->branch_id.'">'.$option->branch.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>  
                                            <?php if (in_array('section', $partners_keys)) { ?>
                                            <div class="form-group ">
                                                <label class="control-label col-md-3"><?php echo $partners_labels['section'] ?></label>
                                                <div class="col-md-8">
                                                    <?php   
                                                        $db->select('section_id,section');
                                                        $db->where('deleted', '0');
														$db->order_by('section');
                                                        $options = $db->get('users_section');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-list-ul"></i>
                                                        </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[section_id]" id="users_profile-section_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    echo '<option value="'.$option->section_id.'">'.$option->section.'</option>';
                                                                } 
                                                            ?>
                                                        </select>                                                        
                                                    </div>
                                                </div>  
                                            </div>
                                            <?php } ?>                                                                                     
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Position Title<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('position_id,position');
                                                        $db->where('deleted', '0');
														$db->order_by('position');
                                                        $options = $db->get('users_position');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-user"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[position_id]" id="users_profile-position_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->position_id == $record['users_profile.position_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->position_id.'">'.$option->position.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Role<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('role_id,role');
                                                        $db->where('role_id >', 1);
                                                        $db->where('deleted', '0');
                                                        $db->order_by('role');
                                                        $options = $db->get('roles');
                                                ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-user"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users[role_id]" id="users-role_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->role_id == $record['users_profile.role_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->role_id.'">'.$option->role.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Reports To<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('user_id,full_name');
                                                        $db->where('active', '1');
														$db->where('deleted','0');
														$db->order_by('full_name');
                                                        $options = $db->get('users');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[reports_to_id]" id="users_profile-reports_to_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    // $selected = ($option->division_id == $record['users_profile.division_id']) ? "selected" : "";
                                                                    echo '<option value="'.$option->user_id.'">'.$option->full_name.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Location<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('location_id,location');
                                                        $db->where('deleted', '0');
														$db->order_by('location');
                                                        $options = $db->get('users_location');
                                                    ?>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="users_profile[location_id]" id="users_profile-location_id">
                                                            <option value="">Select...</option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    echo '<option value="'.$option->location_id.'">'.$option->location.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Project</label>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                        </span>
                                                        <select  class="form-control select2me" name="users_profile[project_id]" id="users_profile-project_id">
                                                            <option value="">Select...</option>
                                                            <?php
																$this->db->order_by('project');
                                                                $option = $this->db->get_where('users_project', array('deleted' => 0));
                                                                foreach($option->result() as $option)
                                                                {
                                                                    echo '<option value="'.$option->project_id.'">'.$option->project.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">ID Number<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="partners[id_number]" id="partners-id_number" placeholder="Enter ID Number" value="<?php echo $series ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Biometric ID<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="partners[biometric]" id="partners-biometric" placeholder="Enter Biometric ID"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Schedule<span class="required">*</span></label>
                                                <div class="col-md-8">
                                                <?php   $db->select('calendar_id,calendar,default');
                                                        $db->where('deleted', '0');
														$db->order_by('default,calendar');
                                                        $options = $db->get('time_shift_weekly');
                                                    ?>
													<!-- ?php
														$optcal = array();
														foreach($options->result() as $option)
														{
															$optcal[$option->default][$option->calendar_id] = $option->calendar;
														} 
														form_dropdown('calendar_id',$optcal,'','class="form-control select2me" data-placeholder="Select..." name="partners[calendar_id]" id="partners-calendar_id"');
													? -->
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-group"></i>
                                                         </span>
                                                        <select  class="form-control select2me" data-placeholder="Select..." name="partners[shift_id]" id="partners-shift_id">
                                                            <option></option>
                                                            <?php
                                                                foreach($options->result() as $option)
                                                                {
                                                                    echo '<option value="'.$option->calendar_id.'">'.$option->calendar.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    <!-- END FORM--> 
                                </div>
                            </div>
                            <div class="portlet">
                                <div class="portlet-title">
                                    <h4>Personal Info</h4>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="control-label col-md-3">Email<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="users[email]" id="users-email" placeholder="Enter Email"/>
                                            </div>
                                        </div>
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Gender<span class="required">*</span></label>
                                                <div class="col-md-6">
                                                <?php
                                                    $options = array('Male' => lang('common.male'), 'Female' => lang('common.female'));
                                                ?>
                                                   <div class="input-group">
                                                        <span class="input-group-addon">
                                                           <i class="fa fa-user"></i>
                                                         </span>
                                                        <select class="form-control select2me" data-placeholder="Select..." name="partners_personal[gender]" id="partners_personal-gender"> 
                                                            <?php
                                                                foreach($options as $key => $option)
                                                                {
                                                                    echo '<option value="'.$key.'">'.$option.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Birthday<span class="required">*</span></label>
                                                <div class="col-md-6">
                                                    <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                                        <input type="text" class="form-control" name="users_profile[birth_date]" id="users_profile-birth_date" placeholder="Enter Birthday" >
                                                        <span class="input-group-btn">
                                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3"><?php echo lang('partners.civil_status')?><span class="required">*</span></label>
                                                <div class="col-md-6">
                                                <?php
                                                    $options = array('Single' => 'Single', 'Married' => 'Married', 'Divorced' => 'Divorced');
                                                ?>
                                                        <select class="form-control select2me" data-placeholder="Select..." name="partners_personal[civil_status]" id="partners_personal-civil_status" >
                                                             <?php
                                                                foreach($options as $key => $option)
                                                                {
                                                                    echo '<option value="'.$key.'">'.$option.'</option>';
                                                                } 
                                                            ?>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- END FORM--> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="margin-top:0;">
        
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>

            <span>
                <a class="btn green btn-sm" onclick="save_new_partner( $(this).parents('form') )">Save</a>
            </span>
        
        
    </div>
</form>

<script language="javascript">
                
$('.select2me').select2({
    placeholder: "Select an option",
    allowClear: true
});
if (jQuery().datepicker) {
    $('.date-picker').datepicker({
        rtl: App.isRTL(),
        autoclose: true
    });
    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
}

</script>