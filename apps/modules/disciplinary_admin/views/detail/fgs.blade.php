<?php
$disable = '';
if($record['incident_status_id'] == 6){
	$disable = 'disabled';
}
?>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('disciplinary_admin.da') }}
			<span class="text-muted small">{{ lang('common.info') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.involved') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
								$record['involved_partners'] = empty($record['involved_partners']) ? 0 : $record['involved_partners'];
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['involved_partners']})";		
								$select_users = $db->query($get_users)->result_array();
								foreach($select_users as $value){
								?>
								<span>{{$value['firstname']}} {{$value['lastname']}}</span>
								<br />
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.offense') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['offense']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.complainants') }} :</label>
						<div class="col-md-7 col-sm-7">
							<?php 
								$record['complainants'] = empty($record['complainants']) ? 0 : $record['complainants'];
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['complainants']})";		
								$select_users = $db->query($get_users)->result_array();
								foreach($select_users as $value){
								?>
								<span>{{$value['firstname']}} {{$value['lastname']}}</span>
								<br />
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div><div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.date_time_offense') }} :</label>
						<div class="col-md-7 col-sm-7">{{date('F d, Y - h:i a', strtotime($record['date_time_of_offense']))}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.attachments') }} :</label>
						<div class="controls col-md-6">							
                            <!-- <ul class="padding-none margin-top-10"> -->
                            @if( !empty($record['attachments']) )
								<?php 
									$file = FCPATH . urldecode( $record['attachments']);
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
												echo '<a class="fancybox-button" href="'.base_url($record['attachments']).'"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            	<span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'video/mp4':
												$icon = 'fa-film';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											case 'audio/mpeg':
												$icon = 'fa-volume-up';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
								            <span>'. basename($f_info['name']) .'</span></a>';
												break;
											default:
												$icon = 'fa-file-text-o';
												echo '<a href="'.base_url($record['attachments']).'" target="_blank"><span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
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
				</div>
			</div>
		</div>
    </div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('disciplinary_admin.details_offense') }}
			<!-- <span class="text-muted small">view</span> -->
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p class="margin-bottom-25">{{ lang('disciplinary_admin.note_detail_offense') }}</p>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.witnesses') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
								$record['witnesses'] = empty($record['witnesses']) ? 0 : $record['witnesses']; 
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['witnesses']})";		
								$select_users = $db->query($get_users)->result_array();
								foreach($select_users as $value){
								?>
								<span>{{$value['firstname']}} {{$value['lastname']}}</span>
								<br />
								<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.location') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['location']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.details_violation') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['violation_details']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary_admin.damages') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['damages']}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!-- <div class="portlet">
	<div class="portlet-title">
		<div class="caption">Immediate Remarks</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">This section contains immediate superior remarks.</p>

	<div class="portlet-body">
	        <div class="form-body">
		        <div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-md-4 col-sm-4 text-right text-muted">
								<span class="required">* </span>
								Immediate Remark/s :
							</label>
							<div class="col-md-7 col-sm-7">
	                    		{{$record['app_remarks']}}
							</div>
						</div>
					</div>
				</div>
	        </div>
	</div>
</div> -->

<!--HR Remarks-->
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('disciplinary_admin.sanctions_details') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('disciplinary_admin.note_sanctions') }}</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form action="#" class="form-horizontal"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required">* </span>
							{{ lang('disciplinary_admin.sanctions') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							<?php
								$where = "FIND_IN_SET (ww_partners_offense_sanction.sanction_id,'".$record["sanction_id_selected"]."')";

								$db->select('sanction_id,CONCAT(offense_level," - ",sanction) AS sanction',false);
								$db->order_by('sanction_category_id', '0');
								$db->where('partners_offense_sanction.deleted', '0');
								$db->where($where);
								$db->join('partners_offense_level','partners_offense_sanction.offense_level_id = partners_offense_level.offense_level_id');
								$options = $db->get('partners_offense_sanction');

								$partners_offense_sanction_options = array(''=>'select...');
                        		foreach($options->result() as $option)
                        		{
                        			$partners_offense_sanction_options[$option->sanction_id] = $option->sanction;
                        		} 

                        		$optionoth = 'class="form-control select2me "'. $disable .' data-placeholder="Select..." id="partners_disciplinary_action-sanction_id"'
                        	?>
                        	<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('partners_disciplinary_action[sanction_id]',$partners_offense_sanction_options, explode(',', $record['da_sanction_id']), $optionoth) }}
	                        </div>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary_admin.suspend_from') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" <?php echo $disable ?> class="form-control" name="partners_disciplinary_action[date_from]" id="partners_disciplinary_action-date_from" value="{{ ($record['da_date_from'] != '1970-01-01') ? $record['da_date_from'] : '' }}" placeholder="">
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 	
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary_admin.suspend_to') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							<div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
								<input type="text" <?php echo $disable ?> class="form-control" name="partners_disciplinary_action[date_to]" id="partners_disciplinary_action-date_to" value="{{ ($record['da_date_to'] != '1970-01-01') ? $record['da_date_to'] : '' }}" placeholder="">
								<span class="input-group-btn">
									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div> 	
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary_admin.suspension') }} :
							<br>
							<span class="small text-muted">{{ lang('disciplinary_admin.days') }}</span>
						</label>
						<div class="col-md-7 col-sm-7">
							<input type="text" <?php echo $disable ?> class="form-control" name="partners_disciplinary_action[suspension_days]" id="partners_disciplinary_action-suspension_days" value="{{ $record['da_suspension_days'] }}" /> 
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary_admin.payment_damage') }}
						</label>
						<div class="col-md-7 col-sm-7">
							<input type="text" <?php echo $disable ?> class="form-control" name="partners_disciplinary_action[damages_payment]" id="partners_disciplinary_action-damages_payment" value="{{ $record['da_damages_payment'] }}" /> 
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required">* </span>
							{{ lang('common.remarks') }} :
						</label>
						<div class="col-md-7 col-sm-7">
                    		<textarea <?php echo $disable ?> rows="4" class="form-control" name="partners_disciplinary_action[remarks]">{{$record['da_remarks']}}</textarea>
						</div>
					</div>
				</div>
			</div>
	       
		</div>
        <!-- </form> -->
	</div>
</div>
<!--End-->