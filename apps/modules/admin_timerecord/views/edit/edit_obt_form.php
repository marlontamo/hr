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
                                    <div class="col-md-7">
                                        <select <?= $disabled?> id="bt_type" name="bt_type" class="form-control selectM3" data-placeholder="Select...">
                                        	<option value="1" <?php echo $bt_type == 1 ? "selected" : ""; ?>>Standard</option>
                                            <option value="2" <?php echo $bt_type == 2 ? "selected" : ""; ?>>Date Range</option>
                                        </select>
                                        <div class="help-block small">
											Select BT Type.
										</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $location['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="location" name="location" value="<?php echo $location['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Makati City">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $date_from['label']; ?><span class="required">*</span></label>
                                    <div class="col-md-7">
										<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p" data-date-start-date="+0d">   
                                            <!-- <input type="hidden" class="form-control" id="date_from_tmp" name="date_from" value="<?php echo $date_from['val']; ?>"> -->
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

								<hr>

								<div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $company_to_visit['label']; ?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="company_to_visit" name="company_to_visit" value="<?php echo $company_to_visit['val']?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Doe">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $name['label']; ?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="name" name="name" value="<?php echo $name['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $position['label']; ?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="position" name="position" value="<?php echo $position['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><?php echo $contact_no['label']; ?></label>
                                    <div class="col-md-7">
                                        <input <?= $disabled?> id="contact_no" name="contact_no" value="<?php echo $contact_no['val']; ?>" type="text" class="form-control" maxlength="25" name="defaultconfig" id="maxlength_defaultconfig" placeholder="Doe">
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
									<h4 class="panel-title">Leave Credits</h4>
								</div>
								
								<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">Type</th>
											<th class="small">Used</th>
											<th class="small">Bal</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($leave_balance as $index => $value){ ?>
										<tr>
											<td class="small"><?=$value['form']?><br/>
												<small class="text-muted">exp. <?=date('M d, Y', strtotime($value['period_extension']))?></small>
											</td>
											<td class="small text-info"><?=number_format($value['used'])?></td>
											<td class="small text-success"><?=number_format($value['balance'])?></td>
										</tr>
										<?php } ?>
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
        $('.selectM3').select2('destroy');   
        $('.selectM3').select2();

        var minDate = $("#date_from").val();
        minDate = new Date(minDate);
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

	});
</script>