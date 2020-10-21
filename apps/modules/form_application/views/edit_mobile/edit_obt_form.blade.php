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
					<div class="tools"><a class="collapse" ></a></div>
				</div>
				<div class="portlet-body form" id="main_form">			

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.type') }}<span class="required">* </span></label>
						<div class="col-md-6">
							<?php	                        

							$business_trip_type_options = array();
							$business_trip_type_options[1] = 'Standard';
							$business_trip_type_options[2] = 'Date Range';

							?>							
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list-ul"></i>
								</span>
								{{ form_dropdown('time_forms[bt_type]',$business_trip_type_options, $bt_type, 'class="form-control select2me" data-placeholder="Select..."') }}
							</div> 				
						</div>	
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.location') }}</label>
						<div class="col-md-6">							
							<input type="text" class="form-control" name="time_forms_obt[location]" id="time_forms_obt-location" value="{{ $record['time_forms_obt.location'] }}" placeholder=""/> 				</div>	
						</div>


						<div class="form-group">
							<label class="control-label col-md-4">{{ lang('form_application.from') }}<span class="required">* </span></label>
							<div class="col-md-6">							<div class="input-group date form_datetime" data-date-format="MM dd, yyyy - HH:ii p">                                       
								<input type="text" size="16" class="form-control" name="time_forms[date_from]" id="time_forms-datetime_from" value="{{ $date_from['val'] }}" />
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
						</div>	



						<div class="form-group">
							<label class="control-label col-md-4">{{ lang('form_application.to') }}<span class="required">* </span></label>
							<div class="col-md-6">							<div class="input-group date form_datetime">                                       
								<input type="text" size="16" class="form-control" name="time_forms[date_to]" id="time_forms-datetime_to" value="{{ $date_to['val'] }}" />
								<span class="input-group-btn">
									<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 				</div>	
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
									<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('form_application.select') }}</span>
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


					<hr />

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.comp_name') }}</label>
						<div class="col-md-6">							
							<input type="text" class="form-control" name="time_forms_obt[company_to_visit]" id="time_forms_obt-company_to_visit" value="{{ $record['time_forms_obt.company_to_visit'] }}" placeholder=""/> 				
						</div>	
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.contact_person') }}</label>
						<div class="col-md-6">							
							<input type="text" class="form-control" name="time_forms_obt[name]" id="time_forms_obt-name" value="{{ $record['time_forms_obt.name'] }}" placeholder=""/> 				
						</div>	
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.pos_title') }}</label>
						<div class="col-md-6">							
							<input type="text" class="form-control" name="time_forms_obt[position]" id="time_forms_obt-position" value="{{ $record['time_forms_obt.position'] }}" placeholder=""/> 				
						</div>	
					</div>

					<div class="form-group">
						<label class="control-label col-md-4">{{ lang('form_application.contact_num') }}</label>
						<div class="col-md-6">							
							<input type="text" class="form-control" name="time_forms_obt[contact_no]" id="time_forms_obt-contact_no" value="{{ $record['time_forms_obt.contact_no'] }}" placeholder=""/> 				
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
					<div class="form-group">
                    	<label class="control-label col-md-4">Purpose</label>
                        <div class="col-md-4">
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
                                
                    {{ form_dropdown('obt_purpose',$time_forms_obt_purpose_options, '', 'id="obt_purpose" class="form-control select2me" data-placeholder="Select..."') }}
                            
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
                    <br>
                    <!-- Table -->
                    <table class="table table-condensed table-striped table-hover" >
                        <thead>
                            <tr>
                            	<th width="20%" class="padding-top-bottom-10" >Purpose</th>
                            	<th width="20%" class="padding-top-bottom-10" >Amount</th>
                            	<th width="25%" class="padding-top-bottom-10" >Remarks</th>
                            	<th width="10%" class="padding-top-bottom-10" >Status</th>
                            	<th width="10%" class="padding-top-bottom-10" >Actions</th>
                            </tr>
                        </thead>
                        <tbody id="obt_transpo">
                        <?php
                        	$request_status_id = 0;
                        ?>
						@if(count($obt_transpo) > 0)
							@foreach($obt_transpo as $index => $value)
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
							        <input value="{{ $value['amount'] }}" type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[amount][]" id="time_forms_obt_transpo-amount" >
							    </td>
							    <td>
							        <input value="{{ $value['remarks'] }}" type="text" class="form-control" maxlength="64" name="time_forms_obt_transpo[remarks][]" id="time_forms_obt_transpo-remarks" >
							    </td>
							    <td>
								    <?php								    	
							            switch($value['status_id']){ 
							                case 1: ?><span class="badge badge-danger">{{ $value['obt_status'] }}</span><?php break;
							                case 2: ?><span class="badge badge-warning">{{ $value['obt_status'] }}</span><?php break;
							                case 3: ?><span class="badge badge-warning">{{ $value['obt_status'] }}</span><?php break;
							                case 4: ?><span class="badge badge-info">{{ $value['obt_status'] }}</span><?php break;
							                case 5: ?><span class="badge badge-info">{{ $value['obt_status'] }}</span><?php break;
							                case 6: ?><span class="badge badge-success">{{ $value['obt_status'] }}</span><?php break;
							                case 7: ?><span class="badge badge-important">{{ $value['obt_status'] }}</span><?php break;
							                case 8: ?><span class="badge badge-default">{{ $value['obt_status'] }}</span><?php break;
							         }
							         $request_status_id = $value['status_id'];
							         $obt_status = $value['obt_status'];
							         $request_remarks = $value['request_remarks'];
							         ?>
							     </td>
							    <td>
							        <a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> Delete</a>
							    </td>
							    
							</tr>
							@endforeach
						@endif
                        </tbody>
                    </table>
				</div>
			</div>

				@if( in_array($request_status_id, array(6,7)) )
					<br>
	                <!--Other Request-->
	                <div class="portlet">
						<div class="portlet-title">
							<div class="caption">Request Remarks</div>
							<div class="tools">
								<a class="collapse" ></a>
							</div>
						</div>
						<p class="margin-bottom-25">This section contains remarks of request budget for the business trip.</p>

						<div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
	                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('common.remarks') }} :</label>
                                    	<div class="col-md-5 col-sm-6">
	                                        <textarea disabled id="request_remarks" name="request_remarks" class="form-control" rows="3">{{$request_remarks}}</textarea>
	                                    </div>
	                                </div>
								</div>
							</div>
	                    </div>
	                </div>
	            @endif
	            
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
		$("#time_forms-datetime_from").change(function(){ 
			if($(this).val() != "" && $("#time_forms-datetime_to").val() != ""){
				get_shift_details($(this).val(), $("#time_forms-datetime_to").val(), 9, 1);
			}
		});

		$('.select2me').select2({
		    placeholder: "Select an option",
		    allowClear: true
		});

		$(".delete_row").live('click', function(){
		    delete_child( $(this), '' )
		});
	}
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