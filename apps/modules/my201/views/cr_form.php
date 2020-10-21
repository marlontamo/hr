<div class="modal-body padding-bottom-0">
	<div class="row">
		<div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label col-md-3">Select</label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <?php
                                    echo form_dropdown('key_class_id', $key_classes, '', 'class="form-control select2me keyslist" data-placeholder="Select..."');
                                ?>
                            
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="add_class()"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                            
                            <div class="help-block text-muted small">
                            	Select Item and Add.
                        	</div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM--> 
        </div>

         <div class="portlet">
            <hr>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" class="form-horizontal" id="draft-keys-form">
                    <div class="form-body" id="draft-keys">
                        {{ $draft }}
                    </div>
                </form>
                <!-- END FORM--> 
            </div>
        </div>
	</div>
</div>
<div class="modal-footer margin-top-0">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Cancel</button>
    <!-- <button class="btn blue btn-sm" type="button" onclick="save_request(1)" > Save as Draft</button> -->  
    <butoon type="button" class="btn green btn-sm" onclick="save_request(2)">Submit</button>
</div>

<script>
    $('select.keyslist').select2({
        placeholder: "Select an option",
        allowClear: true
    });

</script>