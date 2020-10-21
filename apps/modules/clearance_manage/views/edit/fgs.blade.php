<div class="portlet">
	<div class="portlet-title">
		<div class="caption bold">{{ lang('clearance_manage.clearance_form') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
			</div>
	</div>

    <div class="portlet-body" >

    	<p class="margin-bottom-25 small">&nbsp;</span></p>

    	<!-- EMPLOYEES INFO-->
    	<div class="portlet">
			<div class="portlet-body">

            	<table class="table table-bordered table-striped">
					<tbody>
						<tr class="success">
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.employee') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['firstname']}} {{$record['lastname']}}">
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.department') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['department']}}">
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.company') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['company']}}">
									</div>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.effectivity') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['effectivity_date']}}">
									</div>
								</div>
							</td>
						</tr>
						<tr class="success">
							<td>
<!-- 								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.tat') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['turn_around_time']}}">
									</div>
								</div> -->
							</td>
							<td>
								<div class="form-group">
									<label class="control-label col-md-3 bold">{{ lang('clearance_manage.clearance_status') }}</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly value="{{$record['clearance_status']}}">
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

        <!-- BEGIN OF FORM-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">{{ lang('clearance_manage.signatories') }}</div>
				<div class="tools">
					<a class="collapse" href="javascript:;"></a>
					</div>
			</div>
			<div class="portlet-body">				
				<!-- <div class="clearfix"> -->
					
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo $sign['panel_title'] ?>
								<!-- <span class="pull-right "><a class="small text-muted" onclick="delete_signatories(<?php echo $value['clearance_signatories_id']?>)" href="#">Delete</a></span>
								<span class="pull-right "><a class="small text-muted"> &nbsp;|&nbsp; </a></span>
								<span class="pull-right "><a class="small text-muted"  onclick="add_sign(<?php echo $value['clearance_signatories_id']?>)" href="#">Edit</a></span> -->
							</h3>
						</div>
							
						<table class="table">
							<tr>
								<td width="30%" class="active">
									<span class="bold">{{ lang('clearance_manage.sign') }}</span>
								</td>
								<td>
									<input type="text" class="form-control" readonly value="{{ $sign['firstname'] }} {{ $sign['lastname'] }}">
									<input type="hidden" class="form-control" name="partners_clearance_signatories[clearance_signatories_id]" value="{{$sign['clearance_signatories_id']}}">
								</td>
							</tr>
							<tr>
								<td class="active"><span class="bold">{{ lang('clearance_manage.accountabilities') }}</span></td>
								<td>
									<div class="form-group">
										<label class="control-label col-md-3">
											<span>
							                	<button type="button" class="btn btn-success btn-xs" data-toggle="modal" href="#temp_section" onclick="add_account($(this),<?php echo $sign["clearance_layout_sign_id"] ?>)">Add Item</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							                </span>																	
										</label>
										<div class="col-md-7">
											&nbsp;
							            </div>	
						            </div>	
									<div class="form-group">													
										<label class="control-label col-md-3">Attachments</label>
										<div class="col-md-7">
											<div data-provides="fileupload" class="fileupload fileupload-new" id="clearace_signatories-attachments-container">
												<input type="hidden" name="partners_clearance_signatories[attachments]" id="clearace_signatories-attachments" value=""/>
												<div class="input-group">
													<span class="input-group-btn">
														<span class="uneditable-input">
														<i class="fa fa-file fileupload-exists"></i> 
														<span class="fileupload-preview"></span>
														</span>
													</span>
													<span class="btn default btn-file">
														<span class="fileupload-new"><i class="fa fa-paper-clip"></i>Select File</span>
														<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
														<input type="file" class="clearace_signatories-attachments-fileupload" id="clearace_signatories-attachments-fileupload" type="file" name="files[]">
													</span>
													<a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i>Remove</a>
												</div>
											</div>
										</div>
									</div>							            									
					                <div class="form-group">
										<label class="col-md-3 col-sm-3 text-muted">Attachments</label>
										<div class="controls col-md-6">
											<?php
												$attachments = $db->get_where('partners_clearance_signatories_attachment',array('clearance_signatories_id' => $sign['clearance_signatories_id'], 'type' => 0));
												if ($attachments && $attachments->num_rows() > 0){
													$sign['attachments'] = $attachments->row()->attachments;
												}
												else{
													$sign['attachments'] = '';
												}
											?>																		
				                            <!-- <ul class="padding-none margin-top-10"> -->
				                            @if( !empty($sign['attachments']) )
												<?php 
													$file = FCPATH . urldecode( $sign['attachments']);
													if( file_exists( $file ) )
													{
														$f_info = get_file_info( $file );
														$f_type = filetype( $file );

				/*										$finfo = finfo_open(FILEINFO_MIME_TYPE);
														$f_type = finfo_file($finfo, $file);*/

														switch( $f_type )
														{
															case 'image/jpeg':
																$icon = 'fa-picture-o';
																echo '<a class="fancybox-button" href="'.base_url($sign['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
												            	<span>'. basename($f_info['name']) .'</span></a>';
																break;
															case 'video/mp4':
																$icon = 'fa-film';
																echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
												            <span>'. basename($f_info['name']) .'</span></a>';
																break;
															case 'audio/mpeg':
																$icon = 'fa-volume-up';
																echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
												            <span>'. basename($f_info['name']) .'</span></a>';
																break;
															default:
																$icon = 'fa-file-text-o';
																echo '<a href="'.base_url($sign['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
												            <span>'. basename($f_info['name']) .'</span></a>';
														}
												        	// <li class="padding-3 fileupload-delete-'.$record_id.'" style="list-style:none;">
												        	// </li>
												            // <span class="padding-left-10"><a style="float: none;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$record_id.'" href="javascript:void(0)"></a></span>
													}
												?>
											@endif
				                            <!-- </ul> -->
										</div>
									</div>										
									<div class="accountability">
										@if(count($account) > 0)
											@foreach($account as $val)
											<div>			
												<input readonly="readonly" value="{{$val['accountability']}}" type="text" class="form-control" name="partners_clearance_signatories_accountabilities[accountability][]">
											</div>
											<br />
											@endforeach
										@else
										<div>
											<input readonly="readonly" type="text" class="form-control" name="partners_clearance_signatories_accountabilities[accountability][]">
										</div>
										@endif
						            </div>
					        	</td>
							</tr>
							<tr >
								<td class="active"><span class="bold">{{ lang('clearance_manage.remarks') }}</span></td>
								<td>
									<textarea rows="2" class="form-control" name="partners_clearance_signatories[remarks]">{{ $sign['remarks'] }}</textarea>
								</td>
							</tr>
							<tr>
								<td class="active"><span class="bold">{{ lang('clearance_manage.status') }}</td>
								<td>
									<select  class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id]">
					                    <option value=''>Select...</option>
					                    <option value='4' @if($sign['status_id']==4) selected @endif>{{ lang('common.cleared') }}</option>
					                    <option value='3' @if($sign['status_id']==3) selected @endif>Pending</option>
					                </select>
								</td>
							</tr>
						</table>
					</div>

				<!-- </div> -->
			</div>
		</div>
		<!-- END OF FORM-->


    </div>
</div>