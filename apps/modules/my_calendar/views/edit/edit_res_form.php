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
							<input type="hidden" name="orig_res_type" id="orig_res_type" value="<?php echo $res_type ?>">
							<input type="hidden" name="curr_date" id="curr_date" value="<?php echo date('F d, Y') ?>">
                            <div class="form-body"> 

					<div class="form-group">
						<label class="control-label col-md-4"><?php echo lang('my_calendar.schedule') ?><span class="required">* </span></label>
						<div class="col-md-7">
							<?php	                        

							$type_options = array();
							$type_options[1] = 'Excused Tardiness';
							$type_options[2] = 'In Between';
							$type_options[0] = 'Official Undertime';

							?>							
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								<?php echo form_dropdown('res_type',$type_options, $res_type, 'id="res_type" class="form-control select2me" data-placeholder="Select..."') ?>
							</div> 				
						</div>	
					</div>
					<div name="et_ut_type" id="et_ut_type">
							<div class="form-group">
								<label class="control-label col-md-4"><?php echo lang('my_calendar.date') ?><span class="required">* </span></label>
								<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
												<input type="text" class="form-control" name="date_from" id="time_forms-date_from" value="<?php echo $date_from['val'] ?>" placeholder="">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				
											<div class="help-block small">
											<?php echo lang('my_calendar.select_date') ?>
										</div>
								</div>	
							</div>

							<div class="form-group">
								<label class="control-label col-md-4"><?php echo lang('my_calendar.date') ?><span class="required">* </span></label>
								<div class="col-md-7">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
												<input type="text" class="form-control" name="date_to" id="time_forms-date_to" value="<?php echo $date_to['val'] ?>" placeholder="">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				
											<div class="help-block small">
											<?php echo lang('my_calendar.select_date') ?>
										</div>
										</div>	
							</div>			

							 <div class="form-group">
									<label class="control-label col-md-4"><?php echo lang('my_calendar.time') ?>
										<span class="required">*</span></label>
									<div class="col-md-7">
										<div class="input-group bootstrap-timepicker">                                       
											<input type="text" class="form-control timepicker-default" id="ut_time_in_out" name="ut_time_in_out" value="<?php echo $ut_time_in_out; ?>">
											<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
											</span>

										</div>
										<!-- /input-group -->
										<div class="help-block small">
											<?php echo lang('my_calendar.select_time') ?>
										</div>
									</div>
								</div> 
					</div>


					<div name="in_between_type" id="in_between_type">
						<div class="form-group">
								<label class="control-label col-md-4"><?php echo lang('my_calendar.from') ?><span class="required">* </span></label>
								<div class="col-md-7">							<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">                                       
												<input type="text" size="16" class="form-control" name="date_from" id="time_forms-datetime_from" value="<?php echo $date_from['val'] ?>" />
												<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				</div>	
							</div>	



							<div class="form-group">
								<label class="control-label col-md-4"><?php echo lang('my_calendar.to') ?><span class="required">* </span></label>
								<div class="col-md-7">							<div class="input-group date form_datetime">                                       
												<input type="text" size="16" class="form-control" name="date_to" id="time_forms-datetime_to" value="<?php echo $date_to['val'] ?>" />
												<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				</div>	
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
	$(document).ready(function(){
		
        $('select.select2me').select2();
		if (jQuery().datepicker) {
		    $('.date-picker').datepicker({
		        rtl: App.isRTL(),
		        autoclose: true
		    });
		    $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}
		

		$("#time_forms-datetime_from").datetimepicker({
		    isRTL: App.isRTL(),
		    format: "MM dd, yyyy - HH:ii p",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});

		$("#time_forms-datetime_to").datetimepicker({
		    isRTL: App.isRTL(),
		    format: "MM dd, yyyy - HH:ii p",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});
		//disabled datepicker
		if($('#form_status_id').val()>2){
    		$('.date-picker').removeClass('date-picker');
    		$('.bootstrap-timepicker').removeClass('bootstrap-timepicker');
   		}
   		
		check_res_type($('#res_type').val());
        $('#ut_time_in_out').timepicker({defaultTime: $('#ut_time_in_out').val()});

	  	$("#res_type").change(function(){
	  		check_res_type( $(this).val() );
		});

	  	$("#time_forms-date_from").change(function(){
		  	$("#time_forms-date_to").val($("#time_forms-date_from").val());
		  	if($(this).val() != "" && $("#time_forms-date_to").val() != ""){
		  		get_shift_details($(this).val(), $("#time_forms-date_to").val(), 10, 1, $('#res_type').val());
	  		}
		});

	  	$("#time_forms-date_to").change(function(){		  		
	  		$("#time_forms-date_from").val($("#time_forms-date_to").val());
		  	if($(this).val() != "" && $("#time_forms-date_from").val() != ""){
		  		get_shift_details($("#time_forms-date_from").val(), $(this).val(), 10, 2, $('#res_type').val());
	  		}
		});

	});

	function check_res_type(res_type){
		if (res_type == 0) {		//UT
			$('#time_forms-date_from').parent().parent().parent().hide();
			$('#time_forms-date_to').parent().parent().parent().show();
			if( $('#orig_res_type').val() == 2){
				$('#time_forms-date_to').val($('#curr_date').val());
				$('#time_forms-date_from').val($('#curr_date').val());
			}else{
				$('#time_forms-date_from').val($('#date_to').val());
			}		
			$("#in_between_type :input").attr("disabled", true);
			$("#et_ut_type :input").attr("disabled", false);
			$("#in_between_type").hide();
			$("#et_ut_type").show();
		}else if(res_type == 1){	//ET
			$('#time_forms-date_to').parent().parent().parent().hide();
			$('#time_forms-date_from').parent().parent().parent().show();
			if( $('#orig_res_type').val() == 2){
				$('#time_forms-date_to').val($('#curr_date').val());
				$('#time_forms-date_from').val($('#curr_date').val());
			}else{
				$('#time_forms-date_to').val($('#date_from').val());	
			}			
			$("#in_between_type :input").attr("disabled", true);
			$("#et_ut_type :input").attr("disabled", false);
			$("#in_between_type").hide();
			$("#et_ut_type").show();
		}else if(res_type == 2){	//in between
			// $('#time_forms-date_to').parent().parent().parent().show();
			// $('#time_forms-date_from').parent().parent().parent().show();
			if( !$('#forms_id').val() > 0 ){
				$('#time_forms-datetime_to').val('');
				$('#time_forms-datetime_from').val('');	
			}
			$("#in_between_type :input").attr("disabled", false);
			$("#et_ut_type :input").attr("disabled", true);
			$("#in_between_type").show();
			$("#et_ut_type").hide();
		}

  	}
	</script>