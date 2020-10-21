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
									<label class="control-label col-md-4">Type<span class="required">*</span></label>
									<div class="col-md-6">
										<div class="make-switch" data-on-label="&nbsp;In&nbsp;" data-off-label="&nbsp;Out&nbsp;">
											<input <?= $disabled?> type="checkbox" value="0" <?php echo ($ut_type == 1) ? "checked" : ""; ?> class="toggle" id="ut_type-temp" name="ut_type-temp" class="dontserializeme toggle" />
											<input type="hidden" value="<?php echo ($ut_type == 1) ? 1: 0; ?>" checked class="toggle" id="ut_type" name="ut_type"/>
										</div>
		                            <!-- <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
		                                <input type="checkbox" value="1" @if( $record['modules.disabled'] ) checked="checked" @endif name="modules[disabled][temp]" id="modules-disabled-temp" class="dontserializeme toggle"/>
		                                <input type="hidden" value="@if( $record['modules.disabled'] ) 1 else 0 @endif" name="modules[disabled]" id="modules-disabled"/>
		                            </div> -->
										<!-- /input-group -->
										<div class="help-block small">
											Select Time In/Out.
										</div>
									</div>
								</div>   
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $date_from['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											Select Date
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $date_to['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input <?= $disabled?> type="text" size="16" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to['val']; ?>">
                                            <span class="input-group-btn">
                                            <button class="btn default date-set" type="button" <?= $disabled?>><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
										<div class="help-block small">
											Select Date
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
									<label class="control-label col-md-4">Time
										<span class="required">*</span></label>
									<div class="col-md-6">
										<div class="input-group bootstrap-timepicker">                                       
											<input <?= $disabled?> type="text" class="form-control timepicker-default" id="ut_time_in_out" name="ut_time_in_out" value="<?php echo $ut_time_in_out; ?>">
											<span class="input-group-btn">
											<button class="btn default" type="button"<?= $disabled?>><i class="fa fa-clock-o"></i></button>
											</span>

										</div>
										<!-- /input-group -->
										<div class="help-block small">
											Select Time.
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
											<span class="btn default btn-file" <?= $disabled?>>
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
						</div> -->
						
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

		if (jQuery().datepicker) {
		    $('.date-picker').datepicker({
		        rtl: App.isRTL(),
		        autoclose: true
		    });
		    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}

		//disabled datepicker
		if($('#form_status_id').val()>2){
    		$('.date-picker').removeClass('date-picker');
    		$('.bootstrap-timepicker').removeClass('bootstrap-timepicker');
   		}
   		
        check_ut_type($('#ut_type').val());
        $('#ut_time_in_out').timepicker({defaultTime: $('#ut_time_in_out').val()});

	});

  	$("#date_from").change(function(){
  		get_shift_details($(this).val(), $("#date_to").val(), 10, 1, $('#ut_type').val());
  		$("#date_to").val($("#date_from").val());
	});

  	$("#date_to").change(function(){
  		get_shift_details($("#date_from").val(), $(this).val(), 10, 2, $('#ut_type').val());
  		$("#date_from").val($("#date_to").val());
	});

	$('#ut_type-temp').change(function(){
		if( $(this).is(':checked') ){
			$('#ut_type').val('1');
			check_ut_type(1);
		}else{
			$('#ut_type').val('0');
			check_ut_type(0);
		}
  		get_shift_details($("#date_from").val(), $("#date_to").val(), 10, 1, $('#ut_type').val());
	});

	function check_ut_type(ut_type){
		if(ut_type == 1){
			$('.modal-title').html('Excused Tardiness Form');
			$('#date_to').parent().parent().parent().hide();
			$('#date_from').parent().parent().parent().show();
			$('#date_to').val($('#date_from').val());
		}else{
			$('.modal-title').html('Undertime Form');
			$('#date_from').parent().parent().parent().hide();
			$('#date_to').parent().parent().parent().show();
			$('#date_from').val($('#date_to').val());
  		}
  	}
	</script>