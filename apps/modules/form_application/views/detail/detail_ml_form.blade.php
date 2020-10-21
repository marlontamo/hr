@extends('layouts/master')

@section('page_styles')
	@parent
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
				<span>{{ lang('form_application.back') }}</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">{{ lang('form_application.home') }}</a> 
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
        		<input type="hidden" name="record_id" id="record_id" value="<?php echo $forms_id; ?>" >
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">{{ $form_title }} <small class="text-muted">{{ lang('form_application.view') }}</small></div>
						</div>
	                    <div class="portlet-body form" id="main_form">
	                        <!-- BEGIN FORM-->
	                            <div class="form-body">
									<?php if( $record['time_forms_form_status_id'] >= 6 ){ ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ $label_adc }} :</label>
												<div class="col-md-7 col-sm-7">
													<span><?php echo ($date_adc && $date_adc != '0000-00-00 00:00:00' && $date_adc != 'January 01, 1970' && $date_adc != '1970-01-01' ? date('F d, Y g:ia - D',strtotime($date_adc)) : "" ) ?></span>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>		                            	
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.delivery') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>
														<?php
															$db->select('delivery_id,delivery');
						                            		$db->where('deleted', '0');
						                            		$options = $db->get('time_delivery');

						                            		foreach($options->result() as $option){
						                            			if( $record['time_forms_maternity_delivery_id'] == $option->delivery_id ){
						                            				echo $option->delivery;
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.from') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_date_from'] }} - <?php echo date('D',strtotime($record['time_forms_date_from'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.to') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_date_to'] }} - <?php echo date('D',strtotime($record['time_forms_date_to'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.note') }} :</label>
			                                    <div class="col-md-6">
													<div class="btn-grp">
														<button id="goto_vl_co" class="btn blue" type="button"><small>{{ lang('form_application.view_options') }}</small></button>
													</div>
			                                        <div class="help-block small">
														{{ lang('form_application.click_viewopt') }}
													</div>
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.num_preg') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_maternity_pregnancy_no'] }}</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.expected_delivery') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_maternity_expected_date'] }} - <?php echo date('D',strtotime($record['time_forms_maternity_expected_date'])); ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.actual_delivery') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_maternity_actual_date'] }} - <?php echo date('D',strtotime($record['time_forms_maternity_actual_date'])); ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.report_date') }} :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_maternity_return_date'] }} - <?php echo date('D',strtotime($record['time_forms_maternity_return_date'])); ?></span>
												</div>
											</div>
										</div>
									</div>

									<?php if( count($remarks) > 0 && $form_status_id['val'] == 6){
										?>

									<hr />
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('form_application.approver_remarks') }} :</label>
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

									<?php if($form_status_id['val'] == 7 || $form_status_id['val'] == 8){
										?>
									<hr />
	                                <?php 
										foreach ($disapproved_cancelled_remarks as $key => $value) :
											$dis_cancel_by = '';
											$title = '';											
											if ($form_status_id['val'] == 7){
												$title = lang('form_application.disaproved');
												$dis_cancel_by = $value['approver_name'];
											}
											elseif ($form_status_id['val'] == 8){
												$title = lang('form_application.cancel_by');
												$dis_cancel_by = $value['employee_name'];
											}												
									?>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ $title }} :</label>
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
									
	                            </div>
	                            <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-offset-4 col-md-8">
	                                        	<a href="{{ $mod->url }}" class="btn btn-default btn-sm">{{ lang('form_application.back_tolist') }}</a>
	                                        </div>
                                        </div>
                                    </div>
                                </div>
	                        <!-- END FORM--> 
	                    </div>
	            	</div>

	            	<div name="change_options" id="change_options">
								</div>



       	</div>  
    	<div class="col-md-3 visible-lg visible-md">
			<div class="portlet">
				<div class="portlet-body">
					<div class="clearfix">
						<div class="panel panel-success">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<h4 class="panel-title">{{ lang('form_application.leave_credits') }}</h4>
							</div>
							
							<!-- Table -->
							<table class="table">
								<thead>
									<tr>
										<th class="small">{{ lang('form_application.type') }}</th>
										<th class="small">{{ lang('form_application.used') }}</th>
										<th class="small">{{ lang('form_application.bal') }}</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($leave_balance as $index => $value){ ?>
									<tr>
										<td class="small"><?=$value['form']?><br/>
											<small class="text-muted">exp. <?=date('M d, Y', strtotime($value['period_extension']))?></small>
										</td>
										<td class="small text-info"><?=floatval($value['used'])?></td>
										<td class="small text-success"><?=floatval($value['balance'])?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					
					@if( count($special_leaves) > 1 || ( count($special_leaves) == 1 && $special_leaves[0]['used'] > 0) )
					<div class="clearfix">
						<div class="panel panel-success">
							<!-- Default panel contents -->
							<div class="panel-heading">
								<h4 class="panel-title">Special Leave Credits</h4>
							</div>
							
							<!-- Table -->
							<table class="table">
								<thead>
									<tr>
										<th class="small">{{ lang('form_application.type') }}</th>
										<th class="small">{{ lang('form_application.used') }}</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($special_leaves as $index => $value){ 
										if($value['used'] > 0){ ?>
									<tr>
										<td class="small"><?=$value['form']?><br/>
											<!-- <small class="text-muted">exp. <?=date('M d, Y', strtotime($value['period_extension']))?></small> -->
										</td>
										<td class="small text-info"><?=floatval($value['used'])?></td>
									</tr>
									<?php } 
									} ?>
								</tbody>
							</table>
						</div>
					</div>
					@endif

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
@stop

@section('page_plugins')
	@parent
@stop

@section('page_scripts')
	@parent
@stop

@section('view_js')
	@parent
@stop


