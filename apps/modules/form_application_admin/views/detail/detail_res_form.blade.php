@extends('layouts/master')

@section('page_styles')
	@parent
    <link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
    <link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
@stop

@section('page-header')
	
	<div class="row">
	<div class="col-md-12">
		<!-- BEGIN PAGE TITLE & BREADCRUMB-->
		<h3 class="page-title">
			{{ $mod->long_name }} <small>{{ $mod->description }}</small>
		</h3>
		<ul class="page-breadcrumb breadcrumb">
			<li class="btn-group">
				<a href="{{ $mod->url }}"><button class="btn blue" type="button">
				<span>{{ lang('form_application_admin.back') }}</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">{{ lang('form_application_admin.home') }}</a> 
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<!-- jlm i class="fa {{ $mod->icon }}"></i -->
				<a href="{{ $mod->url }}">{{ $mod->long_name }}</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>{{ ucwords( $mod->method )}}</li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>

@stop


@section('page_content')
	@parent

	<div class="row">
        <div class="col-md-9">
        		<input type="hidden" name="view" id="view" value="detail" >
				<input type="hidden" name="orig_res_type" id="orig_res_type" value="{{ $res_type }}">
				<input type="hidden" name="curr_date" id="curr_date" value="{{ date('F d, Y') }}">
				<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
				<input type="hidden" name="form_code" id="form_code" value="{{ $form_code }}">
				<input type="hidden" id="form_id" name="form_id" value="{{ $form_id }}">
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">Replacement Schedule Form <small class="text-muted">{{ lang('form_application_admin.view') }}</small></div>
						</div>
	                    <div class="portlet-body form" id="main_form">
	                        <!-- BEGIN FORM-->
	                            <div class="form-body">
	                            	<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.employee') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['display_name'] }}</span>
												</div>
											</div>
										</div>
									</div>
									<?php if( $record['time_forms_form_status_id'] != 1 ){ ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.date_filed') }} :</label>
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Type :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $res_type_desc; }}</span>
												</div>
											</div>
										</div>
									</div>

								<div name="et_ut_type" id="et_ut_type" class="@if($res_type==2) hidden @endif">
	                                <div class="row @if($res_type==1) hidden @endif">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.date') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_to['val'] }} - <?php echo date('D',strtotime($date_to['val'])); ?></span>
												</div>
											</div>
										</div>
									</div>
	                                <div class="row @if($res_type==0) hidden @endif">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.date') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_from['val'] }} - <?php echo date('D',strtotime($date_from['val'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.time') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span><?php echo $ut_time_in_out; ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div name="in_between_type" id="in_between_type" class="@if($res_type!=2) hidden @endif">
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.from') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_from['val'] }}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.to') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $date_to['val'] }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.reason') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_reason'] }}</span>
												</div>
											</div>
										</div>
									</div>
	                                
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.file_upload') }} :</label>
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
																	$filepath = base_url()."time/applicationmanage/download_file/".$upload_id_val;
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

									<?php if( count($remarks) > 0 ){
										?>

									<hr />
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.approver_remarks') }} :</label>
			                        <?php
						                    for($j=0; $j < count($remarks); $j++){
						                        if(array_key_exists('comment', $remarks[$j])){
						                        	if($j > 0){
			                         ?>
					                         <label class="control-label col-md-4 col-sm-4 text-right text-muted">&nbsp</label>
					                         <?php } ?>
				                         <div class="col-md-7 col-sm-7">
		                                    <span style='display:block; word-wrap:break-word;'>
		                                        <?php
		                                            echo "<b>".$remarks[$j]['display_name']."</b>:";
		                                        ?>
		                                        <span class="text-right text-danger">
		                                        <?php
		                                            if( ($remarks[$j]['comment_date']) && ($remarks[$j]['comment_date']) <> '0000-00-00 00:00:00' )
		                                            	echo date("F d, Y - h:i a", strtotime($remarks[$j]['comment_date']));
		                                        ?>
		                                    	</span>
		                                    </span>
		                                    <div style='display:block; word-wrap:break-word;'>
		                                        <?php
		                                            echo ($remarks[$j]['comment']=="") ? "&nbsp;" : $remarks[$j]['comment'];
		                                        ?>
		                                    </div>
										 </div>

									<?php 		}
											}
											?>

			                                </div>
										</div>
									</div>
									<?php } ?>

									<?php if($form_status_id['val'] == 8){ ?>
									<hr />
		                                <?php 
											foreach ($disapproved_cancelled_remarks as $key => $value) :
												$dis_cancel_by = '';
												$title = '';											
												if ($form_status_id['val'] == 7){
													$title = lang('form_application_admin.disaproved');
													$dis_cancel_by = $value['approver_name'];
												}
												elseif ($form_status_id['val'] == 8){
													$title = lang('form_application_admin.cancel_by');
													$dis_cancel_by = $value['employee_name'];
												}													
										?>
				                                <div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.cancel_by') }} :</label>
															<div class="col-md-7 col-sm-7">
																<span>{{ $dis_cancel_by }}</span>
																<br />
																<?php 
																$date = date("F d, Y H:i:s", strtotime($value['date']));
															    if(date("H:i:s", strtotime($date)) == "00:00:00"){
															       $comment_date = 'on '.date("F d, Y", strtotime($date));
															    }else{
															    	if($value['date'] == '0000-00-00 00:00:00'){
															    		$comment_date = '';
															    	} else {
															    		$comment_date = 'on '.date("F d, Y g:ia", strtotime($date));
															    	}
															    } 
																?>
																<span class="help-block small">{{ $value['form_status'] }} {{ $comment_date }}</span>
															</div>
														</div>
													</div>
												</div>
												<div class="row hidden">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ $value['form_status'] }}date :</label>
															<div class="col-md-7 col-sm-7">
																<span>{{ date('F d, Y g:ia', strtotime($value['date'])) }}</span>
															</div>
														</div>
													</div>
												</div>
				                                <div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label class="control-label col-md-4 col-sm-4 text-right text-muted">&nbsp;</label>
															<div class="col-md-7 col-sm-7">
																<span>{{ ($value['comment'] == '') ? '' : $value['comment'] }}</span>
															</div>
														</div>
													</div>
												</div>
									<?php
											endforeach;
										}
									?>

									<hr />
									
	                           		<?php if( $form_approver_details['approver_status_id'] < 8 && in_array($approver_details['form_status_id'], array(2,4,5,6)) && $form_approver_details['within_cutoff']){ ?>

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
				                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application_admin.remarks') }}<span class="required">* </span></label>
				                                    <div class="col-md-5 col-sm-6">
				                                        <textarea id="comment-{{ $form_approver_details['forms_id'] }}" class="form-control" rows="3"></textarea>
				                                        <label class="control-label col-md-7 text-muted small"> {{ lang('form_application_admin.required_disapp') }}</label>
				                                    </div>
				                                </div>
											</div>
										</div>

									<?php } ?>



	                            </div>

	                            <div class="form-actions fluid" align="center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                            	<?php if( $form_approver_details['approver_status_id'] < 8 && in_array($approver_details['form_status_id'], array(2,4,5)) && $record['time_forms_form_status_id'] != 8 && $record['time_forms_form_status_id'] != 6){ ?>
                                            		<a href="#" class="approve_view btn btn-default btn-sm btn-success" data-forms-id="{{ $form_approver_details['forms_id'] }}" data-form-owner="{{ $form_approver_details['user_id'] }}" data-user-name="" data-user-id="{{ $form_approver_details['approver_id'] }}" data-decission="1" >{{ lang('form_application_admin.approved') }}</a>
                                            		<?php if($form_approver_details['within_cutoff']){ ?>
                                            			<a href="#" class="disapprove_view btn btn-sm btn-danger" data-forms-id="{{ $form_approver_details['forms_id'] }}" data-form-owner="{{ $form_approver_details['user_id'] }}" data-user-name="" data-user-id="{{ $form_approver_details['approver_id'] }}" data-decission="0" >{{ lang('form_application_admin.disapproved') }}</a>
                                            	<?php } }
                                            		else if ($form_approver_details['approver_status_id'] == 6 ){
                                            			if($form_approver_details['within_cutoff']){
                                            		 ?>

                                            		<a href="#" class="disapprove_view btn btn-sm btn-danger" data-forms-id="{{ $form_approver_details['forms_id'] }}" data-form-owner="{{ $form_approver_details['user_id'] }}" data-user-name="" data-user-id="{{ $form_approver_details['approver_id'] }}" data-decission="0" >{{ lang('form_application_admin.disapproved') }}</a>

                                            	<?php
                                            			}
                                            		}
                                            	?>
	                                        	<a href="{{ $mod->url }}" class="btn btn-default btn-sm">{{ lang('form_application_admin.back_tolist') }}</a>
	                                        </div>
                                        </div>
                                    </div>
                                </div>
	                        <!-- END FORM--> 
	                    </div>
	            	</div>



       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="portlet-body">
					<div class="clearfix">
						<div class="panel panel-success">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<h4 class="panel-title">{{ lang('form_application_admin.shift_details') }}</h4>
							</div>
							
							<!-- Table -->
								<table class="table">
									<thead>
										<tr>
											<th class="small">{{ lang('form_application_admin.shift') }}</th>
											<th class="small">{{ lang('form_application_admin.schedule') }}</th>
											<th class="small">{{ lang('form_application_admin.logs') }}</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="small">{{ lang('form_application_admin.time_in') }}</td>
											<td class="small text-info" id="shift_time_start" name="shift_time_start"><?php echo array_key_exists('shift_time_start', $shift_details) ? date("g:ia", strtotime($shift_details['shift_time_start'])) : '-'; ?></td>
											<td class="small text-info" id="logs_time_in" name="logs_time_in"><?php echo array_key_exists('logs_time_in', $shift_details) ? $shift_details['logs_time_in'] != '-' ? date("g:ia", strtotime($shift_details['logs_time_in'])) : '-' : '-'; ?></td>
										</tr>
										<tr>
											<td class="small">{{ lang('form_application_admin.time_out') }}</td>
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
							<table class="table">
								<?php foreach($approver_list as $index => $value){ ?>
								<tr>
									<td><?=$value['lastname'].', '.$value['firstname'] ?>
										<br><small class="text-muted"><?=$value['position']?></small>
									<?php if($record['time_forms_form_status_id'] > 2){ 
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
								<?php } ?>
									</td>
									<td>
									<?php if ($approver_details['user_id'] == $value['approver_id'] && $form_approver_details['approver_status_id'] < 6){ ?>
									<a onclick="reassign_approver({{ $value['approver_id'] }}, {{ $form_approver_details['forms_id'] }})" 
									id="assign_approver" name="assign_approver" class="btn btn-default btn-sm btn-success">{{ lang('form_application_admin.reassign') }}</a>
									</td>
									<?php } ?>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div> 
					
				</div>
			</div>
		</div>			
	</div>
	<div class="modal fade" id="reassign_approver_modal" name="reassign_approver_modal">
	</div>
@stop

@section('page_plugins')
	@parent
@stop

@section('page_scripts')
	@parent
@stop

@section('view_js')
	@parent
    <script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
    <script type="text/javascript" src="{{ theme_path() }}plugins/select2/select2.min.js"></script>
@stop


