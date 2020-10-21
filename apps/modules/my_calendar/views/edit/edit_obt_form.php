<!-- BEGIN FORM-->
<form action="<?php echo $url?>/save_form" class="form-horizontal" name="edit-forms-form" id="edit-forms-form">	
	<div class="modal-body padding-bottom-0">
		<div class="row">
			<div class="col-md-8">
				<div class="portlet">
                    <div class="portlet-body form">
	            			<input type="hidden" name="forms_id" id="forms_id" value="<?php echo $forms_id?>">
	            			<input type="hidden" name="form_id" id="form_id" value="<?php echo $form_id?>">
	            			<input type="hidden" name="form_code" id="form_code" value="<?php echo $form_code?>">
	            			<input type="hidden" name="forms_title" id="forms_title" value="<?php echo $forms_title?>">
	            			<input type="hidden" name="form_status_id" id="form_status_id" value="<?php echo $form_status_id['val']?>">
	            			<input type="hidden" name="focus_date" id="focus_date" value="<?php echo $focus_date ?>">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.type')?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select <?= $disabled?> id="bt_type" name="bt_type" class="form-control select2me" data-placeholder="Select...">
                                        	<option value="1" <?php echo $bt_type == 1 ? "selected" : ""; ?>>Standard</option>
                                            <option value="2" <?php echo $bt_type == 2 ? "selected" : ""; ?>>Date Range</option>
                                        </select>
                                        <div class="help-block small">
											Select BT Type.
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.location')?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="location" name="location" value="<?php echo $location['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.from')?><span class="required">*</span></label>
                                    <div class="col-md-7">
										<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">   
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											<?=lang('my_calendar.select_sd')?> and <?=lang('my_calendar.time')?>
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.to')?><span class="required">*</span></label>
                                    <div class="col-md-7">
										<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p" data-date-start-date="+0d">
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											<?=lang('my_calendar.select_ed')?> and <?=lang('my_calendar.time')?>
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.reason')?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <textarea <?= $disabled?> rows="4" class="form-control" id="reason" name="reason" ><?php echo $reason['val']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
										<label class="control-label col-md-4"><?=lang('my_calendar.file_upload')?></label>
										<div class="col-md-7">
											<div class="fileupload fileupload-new" data-provides="fileupload"  id="time_forms_upload-upload_id-container">
												<input <?= $disabled?> type="hidden" name="upload_id[]" id="time_forms_upload-upload_id" value="<?php echo implode(",", $upload_id['val']) ?>"/>
											<span class="btn default btn-file" <?= $disabled?>>
                                				<span class="fileupload-new"><i class="fa fa-paper-clip"></i> <?=lang('my_calendar.select')?></span>
												<!-- <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span> -->
												<input type="file" name="files[]" multiple="" id="time_forms_upload-upload_id-fileupload" />
											</span>
												<ul class="padding-none margin-top-11">
													<?php 
													implode($upload_id['val']);
														if( count($upload_id['val']) > 0 ) {
															// $upload_ids =  explode(',', $upload_id['val']);
															// print_r($upload_id['val']);
															foreach( $upload_id['val'] as $upload_id_val )
															{
																$upload = $db->get_where('system_uploads', array('upload_id' => $upload_id_val))->row();
																$file = FCPATH . urldecode( $upload->upload_path );
																if( file_exists( $file ) )
																{
																	$f_info = get_file_info( $file );
																	$f_type = filetype( $file );

																	$finfo = finfo_open(FILEINFO_MIME_TYPE);
																	$f_type = finfo_file($finfo, $file);

																	switch( $f_type )
																	{
																		case 'image/jpeg':
																			$icon = 'fa-picture-o';
																			break;
																		case 'video/mp4':
																			$icon = 'fa-film';
																			break;
																		case 'audio/mpeg':
																			$icon = 'fa-volume-up';
																			break;
																		default:
																			$icon = 'fa-file-text-o';
																	}
																	echo '<li class="padding-3 fileupload-delete-'.$upload_id_val.'" style="list-style:none;">
															            <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															            <span>'. basename($f_info['name']) .'</span>
															            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id_val.'" href="javascript:void(0)"></a></span>
															        </li>';
																}
															}
														}
													?>
												</ul>
<!-- 											<span class="fileupload-preview" style="margin-left:5px;"></span>
											<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a> -->
										</div>
										<div class="help-block small">
											<?=lang('my_calendar.supp_docs')?>
										</div>
									</div>
								</div>

								<hr>

								<div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.comp_name')?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="company_to_visit" name="company_to_visit" value="<?php echo $company_to_visit['val']?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.contact_person')?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="name" name="name" value="<?php echo $name['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.pos_title')?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="position" name="position" value="<?php echo $position['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.contact_num')?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="contact_no" name="contact_no" value="<?php echo $contact_no['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="">
                                    </div>
                                </div>
                                
					<?php
					$with_remarks = array(2, 7, 8);
					if($form_status_id['val'] <= 8 && $form_status_id['val'] != 1){ 
						?>
						<hr />
					<?php				
					$disapproved_cancellation_status = array(7, 8);	
					$show_disabled = false;
					if(in_array($form_status_id['val'], $disapproved_cancellation_status)){
						$show_disabled = true;
						?>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $form_status;?> by</label>
                                    <div class="col-md-7 col-sm-7">
                                        <input <?= $disabled?> id="approver_name" name="approver_name" value="<?php echo $approver_name; ?>" type="text" class="form-control" >
                                    </div>
                                </div>
                        <?php
                    }
                    ?>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?=lang('my_calendar.remarks')?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <textarea <?php echo ($show_disabled == true) ? $disabled : "" ?> rows="4" class="form-control" id="cancelled_comment" name="cancelled_comment" ><?php echo $comment; ?></textarea>
                                    </div>
                                </div>

						<?php
					}
					?>
                            </div>
                            
                    </div>
            	</div>
            	<br>
            	<!--Other Request-->
            <div class="portlet margin-top-25">
				<div class="portlet-title">
					<div class="caption">Other Request</div>
					<div class="tools">
						<a class="collapse" ></a>
					</div>
				</div>
				<p class="margin-bottom-25">This section contains other request listing.</p>

				<div class="portlet-body">
					<!-- BEGIN FORM-->
					<?php
						if ($disabled == ""){
					?>
					<div class="form-group">
                    	<label class="control-label col-md-3">Purpose</label>
                        <div class="col-md-6">
						<?php	                            	                            		
							$db->select('purpose_id,purpose');
                    		$db->where('deleted', '0');
                    		$options = $db->get('time_forms_obt_purpose');
							$time_forms_obt_purpose_options = array('' => 'Select...');
                    		foreach($options->result() as $option)
                    		{
                    			$time_forms_obt_purpose_options[$option->purpose_id] = $option->purpose;
                    		} 
                    		?>	
                            <div class="input-group">
                                
                    <?php echo form_dropdown('obt_purpose',$time_forms_obt_purpose_options, '', 'id="obt_purpose" class="form-control select2me" data-placeholder="Select..."') ?>
                            
                                <span class="input-group-btn">
                                <button type="button" class="btn btn-success" onclick="add_form('obt_purpose', 'obt_transpo')">
                                	<i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                            <div class="help-block small">
                            	Select purpose type.
                        	</div>
                            <!-- /input-group -->
                        </div>
                    </div>
					<?php
						}
					?>
                    <br>
                    <!-- Table -->
                    <table class="table table-condensed table-striped table-hover" >
                        <thead>
                            <tr>
                            	<th width="20%" class="padding-top-bottom-10" >Purpose</th>
                            	<th width="20%" class="padding-top-bottom-10" >Amount</th>
                            	<th width="25%" class="padding-top-bottom-10" >Remarks</th>
                            	<th width="15%" class="padding-top-bottom-10" >Actions</th>
                            </tr>
                        </thead>
                        <tbody id="obt_transpo">
						<?php
							if(count($obt_transpo) > 0){
								foreach($obt_transpo as $index => $value){
									if ($disabled != ""){
						?>
							<tr rel="0">
							    <!-- this first column shows the year of this holiday item -->
							    <td>
							        <?php       
							        // echo "here1";      exit();                                                              
							            $db->select('purpose_id,purpose');
							            $db->where('deleted', '0');
							            $db->where('purpose_id', $value['purpose_id']);
							            $options = $db->get('time_forms_obt_purpose')->row_array();
							            echo "<span>".$options['purpose']."</span>";
							        ?>
							    </td>
							     <td>
							        <span><?php echo $value['amount'] ?> </span>
							    </td>
							    <td>
							        <span><?php echo $value['remarks'] ?></span>
							    </td>
							    <td>
							    	&nbsp;
							        <!-- <a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a> -->
							    </td>
							    
							</tr>
							<?php
								}else{
							?>
							 <tr rel="0">
							    <!-- this first column shows the year of this holiday item -->
							    <td>
							        <?php       
							        // echo "here1";      exit();                                                              
							            $db->select('purpose_id,purpose');
							            $db->where('deleted', '0');
							            $options = $db->get('time_forms_obt_purpose');
							            $time_forms_obt_purpose_options = array('' => 'Select...');
							            foreach($options->result() as $option)
							            {
							                $time_forms_obt_purpose_options[$option->purpose_id] = $option->purpose;
							            } 

							            echo form_dropdown('time_forms_obt_transpo[purpose_id][]', $time_forms_obt_purpose_options, $value['purpose_id'], 'id="obt_purpose" class="form-control select2me" data-placeholder="Select..."');
							        ?>
							    </td>
							     <td>
							        <input value="<?php echo $value['amount'] ?>" type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[amount][]" id="time_forms_obt_transpo-amount" >
							    </td>
							    <td>
							        <input value="<?php echo $value['remarks'] ?>" type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[remarks][]" id="time_forms_obt_transpo-remarks" >
							    </td>
							    <td>
							        <a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
							    </td>
							    
							</tr>
							<?php
									}
								}
							}
							?>
                        </tbody>
                    </table>
				</div>
			</div>
			</div>
			<div class="col-md-4">

				<div class="portlet">
					<div class="portlet-body">
						<div class="clearfix">
							<div class="panel panel-success">
								<!-- Default panel contents -->
								<div class="panel-heading">
									<h4 class="panel-title"><?=lang('my_calendar.shift_details')?></h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small"><?=lang('my_calendar.shift')?></th>
											<th class="small"><?=lang('my_calendar.schedule')?></th>
											<th class="small"><?=lang('my_calendar.logs')?></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small"><?=lang('my_calendar.time_in')?></td>
											<td class="small text-info" id="shift_time_start" name="shift_time_start"><?php echo array_key_exists('shift_time_start', $shift_details) ? date("g:ia", strtotime($shift_details['shift_time_start'])) : '-'; ?></td>
											<td class="small text-info" id="logs_time_in" name="logs_time_in"><?php echo array_key_exists('logs_time_in', $shift_details) ? $shift_details['logs_time_in'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_in'])) : '-' : '-'; ?></td>
										</tr>
										<tr>
											<td class="small"><?=lang('my_calendar.time_out')?></td>
											<td class="small text-info" id="shift_time_end" name="shift_time_end"><?php echo array_key_exists('shift_time_end', $shift_details) ? date("g:ia", strtotime(date("Y-m-d")." ".$shift_details['shift_time_end'])) : "-"; ?></td>
											<td class="small text-info" id="logs_time_out" name="logs_time_out"><?php echo array_key_exists('logs_time_out', $shift_details) ? $shift_details['logs_time_out'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_out'])) : '-' : '-'; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="clearfix">
							<div class="panel panel-success">
								<div class="panel-heading">
								<h4 class="panel-title"><?=lang('my_calendar.approvers')?></h4>
							</div>

							<ul class="list-group">
								<?php foreach($approver_list as $index => $value){ ?>
									<li class="list-group-item"><?=$value['lastname'].', '.$value['firstname']?>
										<br><small class="text-muted"><?=$value['position']?></small>
									<?php if($form_status_id['val'] > 2){ 
								            $form_style = 'info';
								            switch($value['form_status_id']){
								                case 8:
								                    $form_style = 'default';
								                break;
								                case 7:
								                    $form_style = 'danger';
								                break;
								                case 6:
								                    $form_style = 'success';
								                break;
								                case 5:
								                case 4:
								                case 3:
								                case 2:
								                    $form_style = 'warning';
								                break;
								                case 1:
								                    $form_style = 'info';
								                break;
								            }
								        ?>
									<br><p><span class="badge badge-<?php echo $form_style ?>"><?=$value['form_status']?></span></p> </li>
								<?php }
								} ?>
							</ul>
							</div>
						</div> 

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer margin-top-0">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm"><?=lang('common.close')?></button>
		<?php 
			if( $form_status_id['val'] < 7 || empty($form_status_id['val']) ){ 
				if($form_status_id['val'] == 1 || empty($form_status_id['val'])){ ?>
					<button type="button" class="btn blue btn-sm" onclick="save_form( $(this).parents('form'), 1 )"><?=lang('common.save_draft')?></button>
					<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 2 )"><?=lang('common.submit')?></button>
		<?php 	
				}elseif($form_status_id['val'] < 3 ){ 
		?>
					<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 2 )"><?=lang('common.submit')?></button>
					<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )"><?=lang('common.cancel_app')?></button>
			<?php 
				}elseif($form_status_id['val'] != 1 ){
		?>
					<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )"><?=lang('common.cancel_app')?></button>
		<?php 
				} 
			}
		?>
	</div>
</form>
<!-- END FORM--> 

<script>

    var getStartDate = function(date1, date2, days){

        if(date2.getTime() < date1.getTime()){
            days = "-" + days + "d";
        }
        else{
            days = "+" + days + "d";
        }

        return days;
    }

    var getDateDifference = function(date1, date2){

        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return diffDays;
    }

	$(document).ready(function(){

        /*!***
        * MARCH 20, 2014
        * WORK-AROUND FOR THIS BOOTSTRAP CALENDAR 
        * DON'T WORK PROPERLY ON AJAX LOADED ELEMENTS
        *****/
        
        // GET CURRENT DATE
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var minDate = $("#date_from").val();
        minDate = new Date(minDate);

        var days; 
        days = getDateDifference(now, minDate);
        /*!***
        * THIS IS A TEMPORARY CODE 
        * AND HAS NOT YET BEEN OPTIMIZED
        *****/	

        $('select.select2me').select2();
		$('#date_from').parent(".form_datetime").datetimepicker({
		    isRTL: App.isRTL(),
		    format: "MM dd, yyyy - HH:ii p",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});
		$('#date_to').parent(".form_datetime").datetimepicker({
		    isRTL: App.isRTL(),
            startDate: minDate,
		    format: "MM dd, yyyy - HH:ii p",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});

	    $('#date_from').change(function () {
		    days = getDateDifference(now, new Date( $(this).val() ));
		    $('#date_to').parent('.form_datetime').datetimepicker("remove");
		    // if (jQuery().datepicker) {
	    		$('#date_to').parent('.form_datetime').datetimepicker({
		    		isRTL: App.isRTL(),
                	startDate: new Date( $(this).val() ),
				    format: "MM dd, yyyy - HH:ii p",
				    autoclose: true,
				    todayBtn: false,
				    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
				    minuteStep: 1
			    });
			// }
			var date_to = new Date($("#date_to").val());
			var date_from = new Date($("#date_from").val());
			if(date_from > date_to){
				$("#date_to").val($("#date_from").val());
			}
	    });

		//disabled datetimepicker
		if($('#form_status_id').val()>2){
    		$('.form_datetime').removeClass('form_datetime');
   		}
   		
	  	$("#date_from").change(function(){ 
		  	if($(this).val() != "" && $("#date_to").val() != ""){
	  			get_shift_details($(this).val(), $("#date_to").val(), 9, 1);
	  		}
		});


		$(".delete_row").live('click', function(){
		    delete_child( $(this), '' )
		});

	});

	function delete_child( record, callback )
	{
	    bootbox.confirm("Are you sure you want to delete this item?", function(confirm) {
	        if( confirm )
	        {
	            _delete_child( record, callback );
	        } 
	    });
	}

	function _delete_child( records, callback )
	{
	    var child_id = records.data('record-id');
	    if(child_id > 0){
	        $.ajax({
	            url: base_url + module.get('route') + '/delete_child',
	            type:"POST",
	            data: 'records='+records+'&child_id='+child_id,
	            dataType: "json",
	            async: false,
	            beforeSend: function(){
	                $('body').modalmanager('loading');
	            },
	            success: function ( response ) {
	                $('body').modalmanager('removeLoading');
	                handle_ajax_message( response.message );
	                console.log()
	                if(response.record_deleted == 1){
	                    setTimeout(function(){
	                        $('body').modalmanager('removeLoading');
	                        records.closest('tr').remove();
	                    }, 500);
	                }
	            }
	        });
	    }else{
	        notify('success', "Record successfully deleted");
	        setTimeout(function(){
	            $('body').modalmanager('removeLoading');
	            records.closest('tr').remove();
	        }, 500);
	    }
	}

	//add other request 
	function add_form(add_form, mode, sequence){

	     form_value = $('#'+add_form).val();

	    if($.trim(form_value) != ""){
	        $.ajax({
	            url: base_url + module.get('route') + '/add_form',
	            type:"POST",
	            async: false,
	            data: 'add_form='+mode+'&form_value='+form_value,
	            dataType: "json",
	            beforeSend: function(){
	            },
	            success: function ( response ) {

	                for( var i in response.message )
	                {
	                    if(response.message[i].message != "")
	                    {
	                        var message_type = response.message[i].type;
	                        notify(response.message[i].type, response.message[i].message);
	                    }
	                }
	                if( typeof(response.add_form) != 'undefined' )
	                {   
	                    $('#'+add_form).val('');
	                    // $('#add_'+mode).remove();
	                    $('#'+mode).append(response.add_form);
	                }

	            }
	        }); 
	    }else{
	        notify('warning', 'Please select purpose.');
	    }
	}
</script>