<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Benefit Packages</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<!-- <p>Benefit Packages</p> -->
	<div class="portlet-body form">
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>
				Benefit Package Name
			</label>
			<div class="col-md-7">
				<input type="text" class="form-control" name="recruitment_benefit_package[benefit]" id="recruitment_benefit_package-benefit" value="{{ $record['recruitment_benefit_package.benefit'] }}" placeholder="Enter Benefit Package Name" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>
				Rank/Type
			</label>
			<div class="col-md-7">
				<?php
				$db->select('employment_type_id,employment_type');
				$db->order_by('employment_type', '0');
				$db->where('deleted', '0');
				$options = $db->get('partners_employment_type');
				$recruitment_benefit_package_rank_id_options = array('' => 'Select...');
				foreach($options->result() as $option)
				{
					$recruitment_benefit_package_rank_id_options[$option->employment_type_id] = $option->employment_type;
				} ?>
				<div class="input-group">
					<span class="input-group-addon">
						<i class="fa fa-list-ul"></i>
					</span>
					{{ form_dropdown('recruitment_benefit_package[rank_id]',$recruitment_benefit_package_rank_id_options, $record['recruitment_benefit_package.rank_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_benefit_package-rank_id"') }}
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				<span class="required">* </span>
				Description
			</label>
			<div class="col-md-7">
				<textarea class="form-control" name="recruitment_benefit_package[description]" id="recruitment_benefit_package-description" placeholder="Enter Description" rows="4">{{ $record['recruitment_benefit_package.description'] }}</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">
				Is Active
			</label>
			<div class="col-md-7">
				<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
					<input type="checkbox" value="1" @if( $record['recruitment_benefit_package.status_id'] || empty($record_id)) checked="checked" @endif name="recruitment_benefit_package[status_id][temp]" id="recruitment_benefit_package-status_id-temp" class="dontserializeme toggle"/>
					<input type="hidden" name="recruitment_benefit_package[status_id]" id="recruitment_benefit_package-status_id" value="@if( $record['recruitment_benefit_package.status_id']  || empty($record_id) ) 1 @else 0 @endif"/>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Benefits</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">		
		<div class="form-group">
			<label class="control-label col-md-4">Benefit</label>
			<div class="col-md-5">
				<div class="input-group">
					<input type="text" class="form-control" maxlength="64" id="benefit_desc" name="benefit_desc" placeholder="Enter Benefit Name..">

					<span class="input-group-btn">
						<button type="button" class="btn btn-success" onclick="add_form('benefit_desc', 'benefit')"><i class="fa fa-plus"></i></button>
					</span>
				</div>
				<div class="help-block small">
					Enter Benefit Name.
				</div>
				<!-- /input-group -->
			</div>
		</div>
		<div class="portlet margin-top-25">
			<div class="portlet-body" >
				<!-- Table -->
				<table class="table table-condensed table-striped table-hover" >
					<thead>
						<tr>
							<th width="35%" class="padding-top-bottom-10" >Benefit Name</th>
							<th width="30%" class="padding-top-bottom-10" >Amount</th>
							<th width="18%" class="padding-top-bottom-10" >Is Active</th>
							<th width="13%" class="padding-top-bottom-10" >Action</th>
						</tr>
					</thead>
					<tbody id="benefit" class="benefit_desc">
						@if(is_array($benefits))
							@foreach($benefits as $index => $value)
							<tr>
								<td>
									<input type="hidden" class="form-control" maxlength="64" value="{{$value['benefit_id']}}" name="recruitment_benefit[benefit_id][]" id="recruitment_benefit-benefit_id">
									<input type="text" class="form-control" maxlength="64" value="{{$value['benefit']}}" name="recruitment_benefit[benefit][]" id="recruitment_benefit-benefit">
								</td>
								<td>
									<input type="text" class="form-control text-right" maxlength="64" value="{{$value['amount']}}" name="recruitment_benefit[amount][]" id="recruitment_benefit-amount">
								</td>
								<td>
									<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
										<input type="checkbox" value="1" @if( $value['status_id'] ) checked="checked" @endif name="recruitment_benefit[status_id][temp][]" id="recruitment_benefit-status_id-temp" class="dontserializeme toggle benefit_stat"/>
										<input type="hidden" name="recruitment_benefit[status_id][]" id="recruitment_benefit-status_id" value="@if( $value['status_id'] ) 1 else 0 @endif" class="score_status_id"/>
									</div>
									<!-- <select  class="form-control select2me input-sm" data-placeholder="Select..." name="recruitment_benefit[status_id][]" id="recruitment_benefit-status_id">
										<option value="1" @if($value['status_id'] == 1) {{"selected"}} @endif>Yes</option>
										<option value="0" @if($value['status_id'] == 0) {{"selected"}} @endif>No</option>
									</select> -->
								</td>
								<td>
									<a class="btn btn-xs text-muted delete_row" data-record-id="{{$value['benefit_id']}}" ><i class="fa fa-trash-o"></i> Delete</a>
								</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>