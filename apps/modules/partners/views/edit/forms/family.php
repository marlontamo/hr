<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="family-category">
            <input type="hidden" name="partners_personal_history[family-relationship][]" 
            id="partners_personal_history-family-relationship" value="<?php echo $category; ?>" />
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
                        <label class="control-label col-md-3">Name<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[family-name][]" id="partners_personal_history-family-name<?php echo $count;?>" placeholder="Enter Title"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Birthday<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control" onchange="_calculateAge(this, <?php echo $count ?>);"
                                name="partners_personal_history[family-birthdate][]" 
                                id="partners_personal_history-family-birthdate<?php echo $count;?>" placeholder="Enter Birthday" >
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Age</label>
                        <div class="col-md-6">
                            <input disabled type="text" class="form-control" name="partners_personal_history[family-age][]" id="partners_personal_history-family-age<?php echo $count;?>" />
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Dependent</label>
                        <div class="col-md-5">
                            <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" value="0" name="partners_personal_history[family-dependent][temp][]" id="partners_personal_history-family-dependent-temp" class="dontserializeme toggle dependent"/>
                                <input type="hidden" name="partners_personal_history[family-dependent][]" id="partners_personal_history-family-dependent" value="0"/>
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
        $('.make-switch').not(".has-switch")['bootstrapSwitch']();
        $('label[for="partners_personal_history-family-dependent-temp"]').css('margin-top', '0');

        $('.dependent').change(function(){
            if( $(this).is(':checked') ){
                $(this).parent().next().val(1);
            }
            else{
                $(this).parent().next().val(0);
            }
    });

    });
</script>