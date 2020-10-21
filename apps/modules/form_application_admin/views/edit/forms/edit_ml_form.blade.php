@extends('layouts/master')

@section('page_styles')
	@parent
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
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
        	<form>
        		<input type="hidden" name="view" id="view" value="detail" >
        		<input type="hidden" name="record_id" id="record_id" value="<?php echo $forms_id; ?>" >
				<div id="vl_container" class="portlet">
						<div class="portlet-title">
							<div class="caption">Maternity Leave <small class="text-muted">edit</small></div>
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
													<input type="hidden" name="time_forms[date_from]" id="time_forms-date_from" value="{{$record['time_forms_date_from']}}" >
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">To :</label>
												<div class="col-md-7 col-sm-7">
													<span id="date_to" name="date_to">{{ $record['time_forms_date_to'] }} - <?php echo date('D',strtotime($record['time_forms_date_to'])); ?></span>
													<input type="hidden" name="time_forms[date_to]" id="time_forms-date_to" value="{{$record['time_forms_date_to']}}" >
												</div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
			                                <div class="form-group">
			                                    <label class="control-label col-md-4 col-sm-4 text-right text-muted">Selected Dates :</label>

			                                    <div class="col-md-6" id="days_leaved">
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

									<hr />

	                            	<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Delivery :</label>
												<div class="col-md-7 col-sm-7">
												<?php
													$db->select('delivery_id,delivery');
				                            		$db->where('deleted', '0');
				                            		$options = $db->get('time_delivery');

				                            		foreach($options->result() as $option)
				                            		{
				                            			$time_delivery_delivery_id_options[$option->delivery_id] = $option->delivery;
				                            		} 
				                            		?>							
				                            		<div class="input-group">
														<span class="input-group-addon">
				                            				<i class="fa fa-list-ul"></i>
				                            			</span>
				                            			{{ form_dropdown('time_forms_maternity[delivery_id]',$time_delivery_delivery_id_options, $record['time_forms_maternity_delivery_id'], 'id="time_forms_maternity-delivery_id" class="form-control select2me" data-placeholder="Select..."') }}
				                        			</div> 
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">No. of Pregnancy :</label>
												<div class="col-md-7 col-sm-7">
                                   				<input type="text" value="{{ $record['time_forms_maternity_pregnancy_no'] }}" id="time_forms_maternity-pregnancy_no" name="time_forms_maternity[pregnancy_no]" maxlength="25" class="form-control">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Expected Delivery :</label>
												<div class="col-md-7 col-sm-7">
													<span>{{ $record['time_forms_maternity_expected_date'] }} - <?php if(strtotime($record['time_forms_maternity_expected_date'])) echo date('D',strtotime($record['time_forms_maternity_expected_date'])); ?></span>													
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Actual Delivery :</label>
												<div class="col-md-7 col-sm-7">
													<div class="maternity_date_from input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
														<input type="text" class="form-control" name="time_forms_maternity[actual_date]" id="time_forms_maternity-actual_date" value="{{ $record['time_forms_maternity_actual_date'] }}" placeholder="">
														<span class="input-group-btn">
															<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>
													<div class="help-block small">
														Select Actual Delivery Date
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label col-md-4 col-sm-4 text-right text-muted">Report Date :</label>
												<div class="col-md-7 col-sm-7">
													<div class="maternity_date_from input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
														<input type="text" class="form-control" name="time_forms_maternity[return_date]" id="time_forms_maternity-return_date" value="{{ $record['time_forms_maternity_return_date'] }}" placeholder="">
														<span class="input-group-btn">
															<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
														</span>
													</div>
													<div class="help-block small">
														Select Return Date
													</div>
												</div>
											</div>
										</div>
									</div>
															
	                            </div>

	                            <div class="form-actions fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-offset-4 col-md-8">
                                            	<?php if( $form_approver_details['approver_status_id'] < 8 ){ ?>
                                    			<button onclick="update_details( $(this).closest('form'), '')" class="btn green btn-sm" type="button"><i class="fa fa-check"></i> Update Details</button>
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
			</form>
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
								<h4 class="panel-title">Approver/s</h4>
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
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
@stop

@section('page_scripts')
	@parent
	<script type="text/javascript" src="{{ theme_path() }}modules/form_application_admin/update.js"></script>
	@stop

@section('view_js')
	@parent
@stop


