<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4><?php echo lang('dashboard.mobile_info') ?></h4>
    <p class="clearfix text-muted small"><?php echo lang('dashboard.mobile_desc') ?></p>

</div>
<div class="modal-body padding-bottom-0">
    <div class="row">
        <div class="portlet">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" id="update_mobile" name="update_mobile">
                    <div class="form-body">
                        
                        <div class="form-group">
                            <div class="col-md-4" >
                                <img src="<?php echo theme_path() ?>img/enter_mobile-3.png" style="width: 120px; margin-left: 20px;">
                            </div>
                            
                            <div class="col-md-7">
                                <label class="control-label" style="margin-top:20px;"><?php echo lang('dashboard.mobile_no') ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <!-- <i class="fa fa-mobile"></i> -->
                                        <img src="<?php echo theme_path() ?>img/flags/<?php echo strtolower($countries['iso2']) ?>.png" class="flag">
                                    </span>
                                    <input type="text" class="form-control" maxlength="16" name="defaultconfig" id="partners_personal-mobile" name="partners_personal[mobile]" value="+<?php echo $countries['calling_code'] ?>">
                                    
                                </div>
                                 <small class="text-muted"> '+<?php echo $countries['calling_code'] ?>' represents country code</small>
                                 <br>
                                 <span id="invalid_mobile" class="required" style="color:#a11"></span>
                            </div>
                        </div>

                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
    </div>
</div>    
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?php echo lang('dashboard.mobile_skip') ?></button>
    <a type="button" class="btn green btn-sm" onclick="update_mobilephone($(this).closest('form'))"><?php echo lang('dashboard.mobile_update') ?></a>
</div>
