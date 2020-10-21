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
                            	<!-- <div class="form-group">
                                    <label class="control-label col-md-4">Type<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select  class="form-control selectM3" data-placeholder="Select..." id="ot_type" name="ot_type">
                                        	<option value="1">Pre-shift</option>
                                            <option value="2">Post-shift</option>
                                            <option value="3">Pre and Post-shift</option>
                                        </select>
                                        <div class="help-block small">
											Select OT Type.
										</div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $date_from['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
										<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">  
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											Select Start Date and Time
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $date_to['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
										<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p" data-date-start-date="+0d">
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											Select End Date and Time
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $reason['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <textarea <?= $disabled?> rows="4" class="form-control" id="reason" name="reason" ><?php echo $reason['val']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
										<label class="control-label col-md-4"><?php echo $upload_id['label'] ?></label>
										<div class="col-md-7">
											<div class="fileupload fileupload-new" data-provides="fileupload"  id="time_forms_upload-upload_id-container">
												<input <?= $disabled?> type="hidden" name="upload_id[]" id="time_forms_upload-upload_id" value="<?php echo implode(",", $upload_id['val']) ?>"/>
											<span class="btn default btn-file" <?= $disabled?> >
                                				<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select</span>
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
											Supporting Documents
										</div>
									</div>
								</div>
                                
                            </div>
                            
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
									<h4 class="panel-title">Shift Details</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">Shift</th>
											<th class="small">Schedule</th>
											<th class="small">Logs</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">Time in</td>
											<td class="small text-info" id="shift_time_start" name="shift_time_start"><?php echo date("g:ia", strtotime($shift_details['shift_time_start'])); ?></td>
											<td class="small text-info" id="logs_time_in" name="logs_time_in"><?php echo $shift_details['logs_time_in'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_in'])) : '-'; ?></td>
										</tr>
										<tr>
											<td class="small">Time out</td>
											<td class="small text-info" id="shift_time_end" name="shift_time_end"><?php echo date("g:ia", strtotime(date("Y-m-d")." ".$shift_details['shift_time_end'])); ?></td>
											<td class="small text-info" id="logs_time_out" name="logs_time_out"><?php echo $shift_details['logs_time_out'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_out'])) : '-'; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<!-- <div class="clearfix">
							<div class="panel panel-success">
								<div class="panel-heading">
									<h4 class="panel-title">Approver/s</h4>
								</div>

								<ul class="list-group">
									<li class="list-group-item">Mahistardo, John<br><small class="text-muted">Manager</small> </li>
									<li class="list-group-item">Mendoza, Joel<br><small class="text-muted">Director</small> </li>
								</ul>
							</div>
						</div>
						 -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer margin-top-0">
		<button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
		<?php if($form_status_id['val'] < 3 || empty($form_status_id['val'])){
				if($form_status_id['val'] != 2){ ?>
		<button type="button" class="btn blue btn-sm" onclick="save_form( $(this).parents('form'), 1 )">Save as draft</button>
		<?php 	}else{ ?>
		<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )">Cancel</button>
		<?php 	} ?>
		<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 2 )">Submit</button>
		<?php } ?>
	</div>
</form>
<!-- END FORM--> 

<script>
	$(document).ready(function(){
        $('.selectM3').select2('destroy');   
        $('.selectM3').select2();
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
            startDate: new Date($("#date_from").val()),
		    format: "MM dd, yyyy - HH:ii p",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});

		//disabled datepicker
		if($('#form_status_id').val()>2){
    		$('.form_datetime').removeClass('form_datetime');
   		}		

	});

  	$("#date_from").change(function(){ 
  		get_shift_details($(this).val(), $("#date_to").val(), 9, 1);
	    // days = getDateDifference(now, new Date( $(this).val() ));
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

 //  	$("#date_to").change(function(){ 
 //  			get_shift_details($("#date_from").val(), $(this).val(), 9, 2);
	// });

</script>