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
				<span>Back</span>
				</button></a>
			</li>
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ base_url('') }}">Home</a> 
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
        		<input type="hidden" name="record_id" id="record_id" value="<?php echo $record_id; ?>" >
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">{{$record['form']}} <small class="text-muted">view</small></div>
						</div>

						<div id="date_selected" name="date_selected" class="hidden">							
							<h5>View Options:</h5>
							<div class="portlet-body form">
							    <!-- BEGIN FORM-->

							    <?php foreach ($selected_dates as $index => $value){

							        // $array_keys = array_keys($value);
							        // $array_values = array_values($value);

							    ?>

							    <div class="row">
							        <div class="col-md-12">
							            <div class="form-group">
							                <label class="control-label col-md-4 col-sm-4 text-right text-muted"><?php echo date('F d, Y', strtotime($value['date'])); ?>  <span class="small text-muted"> - <?php echo date('D', strtotime($value['date'])); ?> :</span></label>
							                <div class="col-md-7 col-sm-7">
							                    <span>
							                        <?php 
							                            echo $value['duration'];
							                        ?>
							                    </span>
							                </div>
							            </div>
							        </div>
							    </div>


							    <?php } ?>


							    <div class="fluid">
							        <hr>
							        <div class="row">
							            <div class="col-md-12">
							                <div class="col-md-offset-4 col-md-8">
							                    <a href="#" onclick="back_to_mainform()" id="back_form_details" class="btn btn-default btn-sm">Back</a>
							                </div>
							            </div>
							        </div>
							    </div>
							    <!-- END FORM--> 
							</div>
						</div>

	                    <div class="portlet-body form" id="main_form">
	                        <!-- BEGIN FORM-->
	                            <div class="form-body">
									<?php if( $record['form_status_id'] != 1 ){ ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Date Filed :</label>
												<div class="col-md-7 col-sm-7">
													<span><?php echo date('F d, Y - D',strtotime($record['date_sent'])) ?></span>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Schedule :</label>
												<div class="col-md-7 col-sm-7">
													<span><?php echo $record['scheduled'] == 'NO' ? "Unscheduled" : "Scheduled"; ?></span>
												</div>
											</div>
										</div>
									</div>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">From :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['date_from'] }} - <?php echo date('D',strtotime($record['date_from'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">To :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['date_to'] }} - <?php echo date('D',strtotime($record['date_to'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Note :</label>
			                                    <div class="col-md-6">
													<div class="btn-grp">
														<button id="goto_vl_co" class="btn blue" type="button"><small>View Options</small></button>
													</div>
			                                        <div class="help-block small">
														Click view options to see details for each date.
													</div>
			                                    </div>
			                                </div>
			                            </div>
									</div>
	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Reason :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['reason'] }}</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Files Upload :</label>
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
									<?php 
										if(count($approvers) > 0){
											$app_count = 1;
											foreach($approvers as $approver){
									?>
			                                <div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Approver <?php echo $app_count; ?> :</label>
			                                    <div class="col-md-5 col-sm-6">
			                                        <span class="bold"><?php echo $approver['display_name']; ?>
			                                        </span>&nbsp;
			                                       <!--  <span class="badge badge-success"><?php echo $approver['form_status']; ?>
			                                        </span> -->
										        <?php 
										            switch($approver['form_status_id']){ 
										                case 1:
										                    ?><span class="badge badge-danger">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 2:
										                    ?><span class="badge badge-warning">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 3:
										                    ?><span class="badge badge-warning">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 4:
										                    ?><span class="badge badge-info">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 5:
										                    ?><span class="badge badge-info">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 6:
										                    ?><span class="badge badge-success">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 7:
										                    ?><span class="badge badge-important">{{ $approver['form_status'] }}</span><?php
										                break;
										                case 8:
										                    ?><span class="badge badge-default">{{ $approver['form_status'] }}</span><?php
										                break;
										         } ?>
			                                        <br>
			                                        <span class="small text-muted">
			                                        	@if($approver['comment_date'] != '0000-00-00 00:00:00') 
			                                        	{{date('F d, Y', strtotime($approver['comment_date']))}} - 
				                                        <?php echo date("D",strtotime($approver['comment_date'])); ?>
				                                        @endif
				                                    </span>
			                                        <br>
			                                        <p>{{$approver['comment']}}
			                                        </p>
			                                    </div>
			                                </div>
									<?php
											$app_count++;
											}
										}
									?>
										</div>
									</div>
									
	                            </div>
	                            <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-offset-4 col-md-8">
	                                        	<a href="{{ $mod->url }}" class="btn btn-default btn-sm">Back to list</a>
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
										<td class="small text-info"><?=floatval($value['used'])?></td>
										<td class="small text-success"><?=floatval($value['balance'])?></td>
									</tr>
									<?php } ?>
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
									 <?php 
									 // if($record['form_status_id'] > 2){ 
								 //            $form_style = 'info';
								 //            switch($value['form_status_id']){
								 //                case 8:
								 //                    $form_style = 'default';
								 //                break;
								 //                case 7:
								 //                    $form_style = 'danger';
								 //                break;
								 //                case 6:
								 //                    $form_style = 'success';
								 //                break;
								 //                case 5:
								 //                case 4:
								 //                case 3:
								 //                case 2:
								 //                    $form_style = 'warning';
								 //                break;
								 //                case 1:
								 //                    $form_style = 'info';
								 //                break;
								 //            }
								        ?>
									<!-- <br><p><span class="badge badge-<?php echo $form_style ?>"><?=$value['form_status']?></span></p> </li> -->
								<?php 
									// }
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
	<script>	
	    $(document).ready(function(){
	    	
	        $('#goto_vl_co').live('click', function(){
	        	$('#main_form').addClass('hidden');
	        	$('#date_selected').removeClass('hidden');
	        });
	        
	        $('#back_form_details').live('click', function(){
	        	$('#main_form').removeClass('hidden');
	        	$('#date_selected').addClass('hidden');
	        });

	    });

	</script>
@stop

@section('view_js')
	@parent
@stop


