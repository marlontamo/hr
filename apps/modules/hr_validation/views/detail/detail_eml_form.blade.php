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
        		<input type="hidden" name="record_id" id="record_id" value="<?php echo $forms_id; ?>" >
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">Employee’s Marriage Leave <small class="text-muted">view</small></div>
						</div>
	                    <div class="portlet-body form" id="main_form">
	                        <!-- BEGIN FORM-->
	                            <div class="form-body">
	                            	<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Employee :</label>
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Date Filed :</label>
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
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">From :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_date_from'] }} - <?php echo date('D',strtotime($record['time_forms_date_from'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">To :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_date_to'] }} - <?php echo date('D',strtotime($record['time_forms_date_to'])); ?></span>
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Selected Dates :</label>

			                                    <div class="col-md-6">
											    <?php 
											    if(count($selected_dates['dates']) > 0 ){
											    $countSelectedDates = 0;
											    	foreach ($selected_dates['dates'] as $index => $value){

											        $array_keys = array_keys($value);
											        $array_values = array_values($value);
											    ?>
											    <span style="display:block; word-wrap:break-word;" class="<?php if( $countSelectedDates > 4 ) echo 'hidden'; ?> toggle-<?php echo $countSelectedDates; ?>">
				                                    <?php echo $index; ?> 
				                                    <span class="small"> - <?php echo $array_keys[0]; ?> :
				                                    </span>
				                                    <span class="text-info">
								                        <?php 
								                            foreach( $selected_dates['duration'] as $duration_info ){
								                                if( $duration_info['duration_id'] == $array_values[0] ){
								                                    echo $duration_info['duration'];
								                                }
								                            }
								                        ?>
								                    </span>
								                </span>
							                	<?php if( ($countSelectedDates+1) % 5 == 0 && $countSelectedDates > 1 && (($countSelectedDates+1) < count($selected_dates['dates'])) ){ ?>
							            			<span class="<?php if( $countSelectedDates != 4 ) echo 'hidden'; ?> toggler-<?php echo $countSelectedDates; ?>" style="display:block; word-wrap:break-word;">
								            			<span class="btn btn-xs blue btn-border-radius" onclick="selectedDates_showmore(<?php echo $countSelectedDates; ?>)"> see more <i class="fa fa-arrow-circle-o-right"></i> 
								            			</span>
							            			</span>						            		
												<?php 
													}
													$countSelectedDates++;
													}
												}
												?>
			                                	</div>

			                                </div>
			                            </div>
									</div>

	                                <div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Reason :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_reason'] }}</span>
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
																	$filepath = base_url()."time/applicationadmin/download_file/".$upload_id_val;
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
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Approver Remarks :</label>
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
									<?php
										} ?>

									<hr />
									<?php if( $form_approver_details['approver_status_id'] < 8 && in_array($approver_details['form_status_id'], array(2,4,5))){ ?>

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
				                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Remarks :</label>
				                                    <div class="col-md-5 col-sm-6">
				                                        <textarea class="form-control" rows="3" name="validate_remarks" id="validate_remarks"></textarea>
				                                    </div>
				                                </div>
											</div>
										</div>

									<?php } ?>



	                            </div>

	                            <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-offset-4 col-md-8">
                                            	<?php if( $form_approver_details['approver_status_id'] < 8 && in_array($approver_details['form_status_id'], array(2,4,5))){ ?>
				                                	<a href="#" class="approve_view btn btn-default btn-sm btn-success" onclick="update_request( $(this).closest('form'), 'approve')" >{{ lang('form_application_admin.hr_valid') }}</a>
				                                	<a href="#" class="disapprove_view btn btn-sm btn-danger" onclick="update_request( $(this).closest('form'), 'disapprove')" >{{ lang('form_application_admin.hr_invalid') }}</a>
                                            	<?php } ?>
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
									<?php if($record['time_forms_form_status_id'] > 2 && $record['time_forms_form_status_id'] != 8){ 
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


