
	<div class="row">
        <div class="col-md-9">
        		<input type="hidden" name="view" id="view" value="detail" >
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">{{ $form_title }} <small class="text-muted">{{ lang('form_application.view') }}</small></div>
						</div>
	                    <div class="portlet-body form" id="main_form">
	                        <!-- BEGIN FORM-->
	                            <div class="form-body">
									<?php if( $record['time_forms_form_status_id'] != 1 ){ ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.date_filed') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span><?php echo date('F d, Y - D',strtotime($record['time_forms_date_sent'])) ?></span>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
	                            	<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.type') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>
														<?php

															$obt_type_options = array();
															$obt_type_options[1] = 'Standard';
															$obt_type_options[2] = 'Date Range';

						                            		foreach($obt_type_options as $index => $value){
						                            			if( $bt_type == $index ){
						                            				echo $value;
						                            			}
						                            		}
														?>
													</span>
												</div>
											</div>
										</div>
									</div>
	                            	<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.location') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_obt_location'] }}</span>
												</div>
											</div>
										</div>
									</div>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.from') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_from['val'] }}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.to') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_to['val'] }}</span>
												</div>
											</div>
										</div>
									</div>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.reason') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_reason'] }}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.file_upload') }} :</label>
												<div class="controls col-md-6">
													<ul class="padding-none">

                                                    <?php 
													implode($uploads);
														if( count($uploads) > 0 ) {

															foreach( $uploads as $upload_id_val )
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
															            <span class="padding-left-10"></span>
															        </a></li>';
																}
															}
														}
													?>


                                                </ul>
												</div>
											</div>
										</div>
									</div>

									<hr />

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.comp_name') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_obt_company_to_visit'] }}</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.contact_person') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_obt_name'] }}</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.pos_title') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_obt_position'] }}</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.contact_num') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_obt_contact_no'] }}</span>
												</div>
											</div>
										</div>
									</div>

									<?php if($form_status_id['val'] == 7 || $form_status_id['val'] == 8){
										?>
									<hr />
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ $form_status }} {{ lang('form_application.by') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $approver_name }}</span>
												</div>
											</div>
										</div>
									</div>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.remarks') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $comment }}</span>
												</div>
											</div>
										</div>
									</div>
									<?php
									}
									?>
									
	                            </div>
	                        <!-- END FORM--> 
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
						
                        <!-- Table -->
                        <table class="table table-condensed table-striped table-hover" >
                            <thead>
                                <tr>
                                	<th width="30%" class="padding-top-bottom-10" >Purpose</th>
                                	<th width="25%" class="padding-top-bottom-10" >Amount</th>
                                	<th width="30%" class="padding-top-bottom-10" >Remarks</th>
                                	<th width="15%" class="padding-top-bottom-10" >Status</th>
                                </tr>
                            </thead>
                            <tbody id="obt_transpo">
							@if(count($obt_transpo) > 0)
								@foreach($obt_transpo as $index => $value)
								 <tr rel="0">
								    <!-- this first column shows the year of this holiday item -->
								    <td>
								        <?php                                                          
								            $db->select('purpose_id,purpose');
								            $db->where('deleted', '0');
								            $db->where('purpose_id', $value['purpose_id']);
								            $options = $db->get('time_forms_obt_purpose')->row_array();
								            echo "<span>".$options['purpose']."</span>";
								        ?>
								    </td>
								     <td>
								        <span>{{ $value['amount'] }} </span>
								    </td>
								    <td>
								        <span>{{ $value['remarks'] }}</span>
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
								</tr>
								@endforeach
							@endif
                            </tbody>
                        </table>
                        <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-4 col-md-8">
                                    	<a class="btn btn-default btn-sm close-pop">{{ lang('common.close') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
				@if( isset($request_status_id) && in_array($request_status_id, array(6,7)) )
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
								<h4 class="panel-title"><?php echo $approver_title; ?></h4>
							</div>

							<ul class="list-group">
								<?php foreach($approver_list as $index => $value){ ?>
									<li class="list-group-item"><?=$value['lastname'].', '.$value['firstname']?>
										<br><small class="text-muted"><?=$value['position']?></small>
									<?php if($form_status_id['val'] > 2){ 
								            $form_style = 'info';
								            switch($value['form_status_id']){
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
								                case 8:
								                default:
								                    $form_style = 'default';
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