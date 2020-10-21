<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/typeahead.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>


<script type="text/javascript" src="<?php echo theme_path(); ?>plugins/bootstrap-tagsinput/typeahead.js"></script>
<div class="modal-body padding-bottom-0">
	<div class="row">
		<div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="#" class="form-horizontal">
                <div class="form-body">
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Employee <span class="required">*</span></label>
                        <div class="col-md-7">
                            <input type="hidden" name="user_id" type="text" class="form-control">
                            <input type="text" name="partner_name" type="text" class="form-control" autocomplete="off">
                            <div class="help-block text-muted small">
                                Enter employeed name.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3">Select</label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <?php
                                    echo form_dropdown('key_class_id', $key_classes, '', 'class="form-control select2me" data-placeholder="Select..."');
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
    <button class="btn blue btn-sm" type="button" onclick="save_request(1)" > Save as Draft</button>  
    <butoon type="button" class="btn green btn-sm" onclick="save_request(2)">Submit</button>
</div>

<script>
    $('input[name="partner_name"]').typeahead({
        source: function(query, process) {
            employees = [];
            map = {};
            
            $.getJSON(base_url + module.get('route') + '/user_lists_typeahead', function(data){
                var users = data.users;
                for( var i in users)
                {
                    employee = users[i];
                    map[employee.label] = employee;
                    employees.push(employee.label);
                }
             
                process(employees);    
            });
            
        },
        updater: function (item) {
            $('input[name="user_id"]').val(map[item].value);
            return item;
        },
        click: function (e) {
          e.stopPropagation();
          e.preventDefault();
          this.select();
        }
    });

    $('input[name="partner_name"]').focus(function(){
        $(this).val('');
        $('input[name="user_id"]').val('');
    });
</script>