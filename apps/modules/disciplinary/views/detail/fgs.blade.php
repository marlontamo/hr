<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('disciplinary.da') }}
			<span class="text-muted small">{{ lang('common.info') }}</span>
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.involved') }} :</label>
						<div class="col-md-8 col-sm-8">
							<?php 
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.offense') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['offense']}}</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.complainants') }} :</label>
						<div class="col-md-7 col-sm-7">
							<?php 
								$get_users = " SELECT us.*, pos.position FROM users_profile us
											JOIN ww_users_position pos ON us.position_id = pos.position_id
											WHERE us.user_id IN ({$record['complainants']})";		
								$select_users = $db->query($get_users);
								if ($select_users && $select_users->num_rows() > 0){
									foreach($select_users->result_array() as $value){
							?>
										<span>{{$value['firstname']}} {{$value['lastname']}}</span>
										<br />
							<?php
									}
								}
							?>
						</div>
					</div>
				</div>
			</div><div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.date_time_offense') }} :</label>
						<div class="col-md-7 col-sm-7">{{date('F d, Y - h:i a', strtotime($record['date_time_of_offense']))}}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
	                <div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.attachments') }} :</label>
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
		<div class="caption">{{ lang('disciplinary.details_offense') }}
			<!-- <span class="text-muted small">view</span> -->
		</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<p class="margin-bottom-25">{{ lang('disciplinary.note_detail_offense') }}</p>
	<div class="portlet-body form">
		<div class="form-body">
	    	<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.witnesses') }} :</label>
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
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.location') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['location']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.details_violation') }} :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{$record['violation_details']}}</span>
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">{{ lang('disciplinary.damages') }} :</label>
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
		<div class="caption">{{ lang('disciplinary.sanctions_details') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<p class="margin-bottom-25">{{ lang('disciplinary.note_sanctions') }}</p>

	<div class="portlet-body">
		<!-- BEGIN FORM-->
        <!-- <form action="#" class="form-horizontal"> -->
        <div class="form-body">
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required"><!-- * --> </span>
							{{ lang('disciplinary.sanctions') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['da_sanction']}}
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary.suspend_from') }} :
						</label>
						<div class="col-md-7 col-sm-7">							
							{{($record['da_date_from'] != '1970-01-01' && $record['da_date_from'] != '0000-00-00' && $record['da_date_from'] != '' ? date('F d, Y', strtotime($record['da_date_from'])) : '')}}	
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary.suspend_to') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{($record['da_date_from'] != '1970-01-01' && $record['da_date_to'] != '0000-00-00' && $record['da_date_to'] != '' ? date('F d, Y', strtotime($record['da_date_to'])) : '')}}
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary.suspension') }} :
							<br>
							<span class="small text-muted">{{ lang('disciplinary_manage.days') }}</span>
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['da_suspension_days']}}
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<!-- <span class="required">* </span> -->
							{{ lang('disciplinary.payment_damage') }}  :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['da_damages_payment']}}
						</div>
					</div>
				</div>
			</div>
	        <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">
							<span class="required"><!-- * --> </span>
							{{ lang('common.remarks') }} :
						</label>
						<div class="col-md-7 col-sm-7">
							{{$record['da_remarks']}}
						</div>
					</div>
				</div>
			</div>
	       
		</div>
        <!-- </form> -->
	</div>
</div>
<!--End-->