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
										<label class="col-md-3 col-sm-3 text-muted">Attachments</label>
										<?php
											$attachment = $db->get_where('partners_clearance_signatories_attachment',array('clearance_signatories_id' => $sign['clearance_signatories_id']));
											if ($attachment && $attachment->num_rows() > 0){
												foreach ($attachment->result() as $row) {
										?>
													<div class="controls col-md-6">							
							                            <!-- <ul class="padding-none margin-top-10"> -->
							                            @if( !empty($row->attachments) )
															<?php 
																$file = FCPATH . urldecode( $row->attachments);
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
																			echo '<a class="fancybox-button" href="'.base_url($row->attachments).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															            	<span>'. basename($f_info['name']) .'</span></a>';
																			break;
																		case 'video/mp4':
																			$icon = 'fa-film';
																			echo '<a href="'.base_url($row->attachments).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															            <span>'. basename($f_info['name']) .'</span></a>';
																			break;
																		case 'audio/mpeg':
																			$icon = 'fa-volume-up';
																			echo '<a href="'.base_url($row->attachments).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
															            <span>'. basename($f_info['name']) .'</span></a>';
																			break;
																		default:
																			$icon = 'fa-file-text-o';
																			echo '<a href="'.base_url($row->attachments).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
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
										<?php
												}
											}										
										?>
									</div>									
									<div class="accountability">
										@if(count($account) >0)
											@foreach($account as $val)
											<div>			
												<input disabled value="{{$val['accountability']}}" type="text" class="form-control" name="partners_clearance_signatories_accountabilities[accountability][]">
											</div>
											<br />
											@endforeach
										@else
										<div>
											<!-- <span class="pull-right small text-muted"> -->
							                   <!-- <a class="pull-right small text-muted" onclick="delete_account(this)" >Delete</a> -->
							                <!-- </span><br> -->
											<input disabled type="text" class="form-control" name="partners_clearance_signatories_accountabilities[accountability][]">
										</div>
										@endif
						            </div>
					        	</td>
							</tr>
							<tr >
								<td class="active"><span class="bold">{{ lang('clearance_manage.remarks') }}</span></td>
								<td>
									<textarea disabled rows="2" class="form-control" name="partners_clearance_signatories[remarks]">{{ $sign['remarks'] }}</textarea>
								</td>
							</tr>
							<tr>
								<td class="active"><span class="bold">{{ lang('clearance_manage.status') }}</td>
								<td>
									<select  disabled class="form-control select2me" data-placeholder="Select..." name="partners_clearance_signatories[status_id]">
					                    <option value=''>Select...</option>
					                    <option value='4' @if($sign['status_id']==4) selected @endif>{{ lang('common.clear') }}</option>
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