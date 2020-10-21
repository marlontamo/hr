<!-- Previous Trainings : start doing the loop-->
<div id="personal_friend_relative">
    <input type="hidden" name="friend_relative_count" id="friend_relative_count" value="1" />
    <div class="portlet">
        <div class="portlet-title">
            <!-- <div class="caption" id="education-category">Company Name</div> -->
            <div class="tools">
                <a class="text-muted" id="delete_friend_relative-<?php echo $count;?>" onclick="remove_form(this.id, 'friend_relative', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
                    <!-- START FORM -->
                    <div class="form-group">
                        <label class="control-label col-md-3 small"><?php echo lang('applicants.employee_name') ?>
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                            
                            <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal_history[friend-relative-employee][]" id="recruitment_personal_history-friend-relative-employee">
                                <option value=""><?php echo lang('applicants.select') ?></option>
                                    <?php
                                    if ( sizeof( $employee ) > 0 ){
                                        foreach( $employee as $key => $val ){
                                    ?>
                                            <option value="<?php echo $val["user_id"] ?>"><?php echo $val["full_name"] ?> </option>
                                    <?php
                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small"><?php echo lang('applicants.position') ?>
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-position][]" id="friend-relative-position">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small"><?php echo lang('applicants.dept') ?>
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-dept][]" id="recruitment-friend-relative-dept">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small"><?php echo lang('applicants.relation') ?>
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-relation][]" id="friend-relative-relation">
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>