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
	            			<input type="hidden" name="focus_date" id="focus_date" value="<?php echo $focus_date['val'] ?>">
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
									<label class="control-label col-md-4"><?php echo lang('my_calendar.ot_date') ?><span class="required">* </span></label>
									<div class="col-md-7">							
										<div class="input-group date date-picker" data-date-format="MM dd, yyyy">                                       
												<input type="text" size="16" class="form-control" name="focus_date" id="time_forms-focus_date" value="<?php echo $focus_date['val'] ?>" />
												<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
												</span>
										</div> 				
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
											<?=lang('my_calendar.select_date_time')?>
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
											<?=lang('my_calendar.select_date_time')?>
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
											<span class="btn default btn-file" <?= $disabled?> >
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
		$('#time_forms-focus_date').datepicker({
		    isRTL: App.isRTL(),
		    format: "MM dd, yyyy",
		    autoclose: true,
		    todayBtn: false,
		    pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
		    minuteStep: 1
		});        
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

	    $('#date_from').change(function () {
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

		//disabled datepicker
		if($('#form_status_id').val()>2){
    		$('.form_datetime').removeClass('form_datetime');
   		}		

	   	if (jQuery().datepicker) {
	        $('#time_forms-focus_date').parent('.date-picker').datepicker({
	            format: "MM dd, yyyy",
	            autoclose: true,
	            todayBtn: false,
	            pickerPosition: "bottom-left",
	            minuteStep: 1             
	        }).on('changeDate', function(ev) {
	            var focus_date = Date.parse($('#time_forms-focus_date').val());  

	            if ($('#date_to').length > 0){
	                var currentdate = new Date(); 
	                var current_time = currentdate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}); //currentdate.toLocaleTimeString();
	                var focus_date_original = $('#time_forms-focus_date').val() + ' - ' + current_time;

	                $('#date_from').val(focus_date_original);
	                $('#date_to').val(focus_date_original);

	                var date_from = Date.parse($('#date_from').val());
	                var date_to = Date.parse($('#date_to').val());
	            }

	            var no_days_before = dateDiff(focus_date,date_from,'days');
	            var no_days_after = dateDiff(focus_date,date_to,'days');

	            if ((focus_date < date_from) && no_days_before > 1){
	                $('#time_forms-focus_date').val('')
	                notify('error', 'Focus date should less than or equal to 1 day');
	            }

	            if ((focus_date > date_to) && no_days_after > 1){
	                $('#time_forms-focus_date').val('')
	                notify('error', 'Focus date should less than or equal to 1 day');
	            }    

	            if ($('form_code').val() == 'DTRP'){
	                if ((focus_date < date_to) && no_days_after > 1){
	                    $('#time_forms-focus_date').val('')
	                    notify('error', 'Focus date should less than or equal to 1 day');
	                }   
	            }   

	        });
	    } 

	    $('#date_from,#date_to').live('change',function(e){
	        var focus_date = Date.parse($('#time_forms-focus_date').val());
	        if ($('#time_forms-date_to').length > 0){
	            var date_from = Date.parse($('#time_forms-date_to').val());
	            var date_to = Date.parse($('#time_forms-date_to').val());
	        }
	        else{
	            var date_from = Date.parse($('#date_from').val());
	            var date_to = Date.parse($('#date_to').val());
	        }

	        var no_days_before = dateDiff(focus_date,date_from,'days');
	        var no_days_after = dateDiff(focus_date,date_to,'days');

	        if ((focus_date < date_from) && no_days_before > 1){
	            $('#time_forms-focus_date').val('')
	            notify('error', 'Focus date should less than or equal to 1 day');
	        }

	        if ((focus_date > date_to) && no_days_after > 1){
	            $('#time_forms-focus_date').val('')
	            notify('error', 'Focus date should less than or equal to 1 day');
	        }  
	    });	      
	});

  	$("#date_from").change(function(){ 
	  	if($(this).val() != "" && $("#date_to").val() != ""){
  			get_shift_details($(this).val(), $("#date_to").val(), 9, 1);
  		}
	});

 //  	$("#date_to").change(function(){ 
 //  			get_shift_details($("#date_from").val(), $(this).val(), 9, 2);
	// });

</script>