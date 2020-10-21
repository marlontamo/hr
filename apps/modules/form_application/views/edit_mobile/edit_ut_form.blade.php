@include('edit/page_styles')
@if(isset($mod_lang))
<script src="{{ theme_path() }}{{ $mod_lang }}"></script>
@endif


	<div class="row">
        <div class="col-md-9">
			<form class="form-horizontal" action="<?php echo $url?>/save_form">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				<input type="hidden" id="form_id" name="form_id" value="{{ $form_id }}">
				<input type="hidden" name="forms_title" id="forms_title" value="{{ $form_title }}">
				<input type="hidden" name="form_code" id="form_code" value="{{ $form_code }}">
				<input type="hidden" name="view" id="view" value="edit" >

				
				<div class="portlet">
					<div class="portlet-title">
						<div class="caption">{{ $form_title }}</div>
						<div class="tools"><a class="collapse" href="javascript:;"></a></div>
					</div>
					<div class="portlet-body form">						

							<div class="form-group">
								<label class="control-label col-md-4">{{ lang('form_application.date') }}<span class="required">* </span></label>
								<div class="col-md-6">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
												<input type="text" class="form-control" name="time_forms[date_from]" id="time_forms-date_from" value="{{ $date_from['val'] }}" placeholder="">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				
											<div class="help-block small">
											{{ lang('form_application.select_date') }}
										</div>
								</div>	
							</div>

							<div class="form-group">
								<label class="control-label col-md-4">{{ lang('form_application.date') }}<span class="required">* </span></label>
								<div class="col-md-6">							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
												<input type="text" class="form-control" name="time_forms[date_to]" id="time_forms-date_to" value="{{ $date_to['val'] }}" placeholder="">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
											</div> 				
											<div class="help-block small">
											{{ lang('form_application.select_date') }}
										</div>
										</div>	
							</div>			

							 <div class="form-group">
									<label class="control-label col-md-4">{{ lang('form_application.time') }}
										<span class="required">*</span></label>
									<div class="col-md-6">
										<div class="input-group bootstrap-timepicker">                                       
											<input type="text" class="form-control timepicker-default" id="ut_time_in_out" name="ut_time_in_out" value="<?php echo $ut_time_in_out; ?>">
											<span class="input-group-btn">
											<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
											</span>

										</div>
										<!-- /input-group -->
										<div class="help-block small">
											{{ lang('form_application.select_time') }}
										</div>
									</div>
								</div> 





							<div class="form-group">
								<label class="control-label col-md-4">{{ lang('form_application.reason') }}<span class="required">* </span></label>
								<div class="col-md-6">							<textarea class="form-control" name="time_forms[reason]" id="time_forms-reason" placeholder="" rows="4">{{ $record['time_forms.reason'] }}</textarea> 				</div>	
							</div>			



							<div class="form-group">
								<label class="control-label col-md-4">{{ lang('form_application.file_upload') }}</label>
								<div class="col-md-6">							<div data-provides="fileupload" class="fileupload fileupload-new" id="time_forms_upload-upload_id-container">
				                                <input type="hidden" name="time_forms_upload[upload_id]" id="time_forms_upload-upload_id" value="<?php echo implode(",", $upload_id['val']) ?>"/>
				                                <span class="btn default btn-sm btn-file">
				                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select</span>
				                                <input type="file" id="time_forms_upload-upload_id-fileupload" type="file" name="files[]" multiple="">
				                                </span>
				                                <ul class="padding-none margin-top-10">
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
																	$filepath = base_url()."time/application/download_file/".$upload_id_val;
																	echo '<li class="padding-3 fileupload-delete-'.$upload_id_val.'" style="list-style:none;">
															            <a href="'.$filepath.'">
																		<span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															            <span>'. basename($f_info['name']) .'</span>
															            <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id_val.'" href="javascript:void(0)"></a></span>
															        </a></li>';
																}
															}
														}
													?>
				                                </ul>
				                            </div> 	
				                            <div class="help-block small">
												{{ lang('form_application.supp_docs') }}
											</div>				
				                        </div>	
							</div>	

	<?php
					if($form_status_id['val'] < 7 && $form_status_id['val'] != 1 && !empty($form_status_id['val'])){ 
		?>
		<hr />

		<div class="form-group">
			<label class="control-label col-md-4">{{ lang('form_application.remarks') }}<span class="required">* </span></label>
			<div class="col-md-6">							
				<textarea class="form-control" name="cancelled_comment" id="cancelled_comment" placeholder="" rows="4"></textarea> 				
				<label class="control-label col-md-7 text-muted small"> {{ lang('form_application.required_cancel') }}</label>
			</div>	
		</div>	

		<?php
	}
	?>

						</div>
				</div>
				<div name="change_options" id="change_options">
								</div>



				<div class="formsactions-btn fluid">
				  <div class="row">
				    <div class="col-md-12">
				      <div class="col-md-offset-4 col-md-8">
						<?php 
							if( $form_status_id['val'] < 7 || empty($form_status_id['val']) ){ 
								if($form_status_id['val'] == 1 || empty($form_status_id['val'])){ ?>
									<button type="button" class="btn blue btn-sm" onclick="save_form( $(this).parents('form'), 1 )">{{ lang('form_application.save_draft') }}</button>
									<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 2 )">{{ lang('form_application.submit') }}</button>
						<?php 	
								}elseif($form_status_id['val'] < 3 ){ 
						?>
									<button type="button" class="btn green btn-sm" onclick="save_form( $(this).parents('form'), 2 )">{{ lang('form_application.submit') }}</button>
									<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )">{{ lang('form_application.cancel_app') }}</button>	
							<?php 
								}elseif($form_status_id['val'] != 1 ){
						?>
									<button type="button" class="btn red btn-sm" onclick="save_form( $(this).parents('form'), 8 )">{{ lang('form_application.cancel_app') }}</button>	
						<?php 
								} 
							}
						?>
				         <a class="close-pop btn default btn-sm">{{ lang('form_application.back') }}</a>
				      </div>
				    </div>
				  </div>
				</div>




			</form>
       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="portlet-body">
					<div class="clearfix">
						<div class="panel panel-success">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<h4 class="panel-title">{{ lang('form_application.shift_details') }}</h4>
							</div>
							
							<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">{{ lang('form_application.shift') }}</th>
											<th class="small">{{ lang('form_application.schedule') }}</th>
											<th class="small">{{ lang('form_application.logs') }}</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">{{ lang('form_application.time_in') }}</td>
											<td class="small text-info" id="shift_time_start" name="shift_time_start"><?php echo array_key_exists('shift_time_start', $shift_details) ? date("g:ia", strtotime($shift_details['shift_time_start'])) : '-'; ?></td>
											<td class="small text-info" id="logs_time_in" name="logs_time_in"><?php echo array_key_exists('logs_time_in', $shift_details) ? $shift_details['logs_time_in'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_in'])) : '-' : '-'; ?></td>
										</tr>
										<tr>
											<td class="small">{{ lang('form_application.time_out') }}</td>
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
								<h4 class="panel-title">{{ lang('form_application.approvers') }}</h4>
							</div>

							<ul class="list-group">
								<?php foreach($approver_list as $index => $value){ ?>
									<li class="list-group-item"><?=$value['lastname'].', '.$value['firstname']?><br><small class="text-muted"><?=$value['position']?></small> </li>
								<?php } ?>
							</ul>
						</div>
					</div> 
			
				</div>
			</div>
		</div>		
	</div>

@include('edit/page_plugins')
@include('edit/page_scripts')
<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
{{ get_module_js( $mod ) }}
{{ get_edit_js( $mod ) }}
<script>
	function init_form_specific()
	{
		init_form();
		check_ut_type($('#ut_type').val());

	  	$("#time_forms-date_from").change(function(){
		  	$("#time_forms-date_to").val($("#time_forms-date_from").val());
		  	if($(this).val() != "" && $("#time_forms-date_to").val() != ""){
		  		get_shift_details($(this).val(), $("#time_forms-date_to").val(), 10, 1, $('#ut_type').val());
	  		}
		});

	  	$("#time_forms-date_to").change(function(){		  		
	  		$("#time_forms-date_from").val($("#time_forms-date_to").val());
		  	if($(this).val() != "" && $("#time_forms-date_from").val() != ""){
		  		get_shift_details($("#time_forms-date_from").val(), $(this).val(), 10, 2, $('#ut_type').val());
	  		}
		});
	}
	function check_ut_type(ut_type){

		$('.modal-title').html('Undertime Form');
		$('#time_forms-date_from').parent().parent().parent().hide();
		$('#time_forms-date_to').parent().parent().parent().show();
		$('#time_forms-date_from').val($('#date_to').val());

  	}
</script>