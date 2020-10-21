<div class="portlet">
    <div class="portlet-title">
        <div class="caption small" id="family-category">
            <input type="hidden" name="recruitment_personal_history[family-relationship][]" 
            id="recruitment_personal_history-family-relationship" value="<?php echo $category; ?>" />
            <?php echo $category; ?></div>
            <div class="tools">
                <a class="text-muted" id="delete_family-<?php echo $count;?>" onclick="remove_form(this.id, 'family', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> Delete</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
                    <!-- START FORM --> 
                    <div class="form-group">
                        <label class="control-label col-md-3 small">Name<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-name][]" id="recruitment_personal_history-family-name<?php echo $count;?>" placeholder="Enter Title"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">Birthday<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control" onchange="_calculateAge(this, <?php echo $count ?>);"
                                name="recruitment_personal_history[family-birthdate][]" 
                                id="recruitment_personal_history-family-birthdate<?php echo $count;?>" placeholder="Enter Birthday" >
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">Age</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input readonly type="text" class="form-control" name="recruitment_personal_history[family-age][]" id="recruitment_personal_history-family-age<?php echo $count;?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">Occupation</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-occupation][]" id="recruitment_personal_history-family-occupation<?php echo $count ?>" placeholder="Enter Occupation"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">Employer</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[family-employer][]" id="recruitment_personal_history-family-employer<?php echo $count ?>" placeholder="Enter Employer"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script language="javascript">
    $(document).ready(function(){
        $('select.form-select').select2();

        if (jQuery().datepicker) {
            $('#users_profile-birth_date').parent('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); 
        }

    });
</script>