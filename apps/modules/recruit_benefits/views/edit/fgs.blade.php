<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Benefit Packages</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
			<p>Benefit Packages</p>
		<div class="portlet-body form">			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Benefit Package Name</label>
				<div class="col-md-7">							<input type="text" class="form-control" name="recruitment_benefit_package[benefit]" id="recruitment_benefit_package-benefit" value="{{ $record['recruitment_benefit_package.benefit'] }}" placeholder="Enter Benefit Package Name" /> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Rank/Type</label>
				<div class="col-md-7"><?php									                            		$db->select('employment_type_id,employment_type');
	                            			                            		$db->order_by('employment_type', '0');
	                            		$db->where('deleted', '0');
	                            		$options = $db->get('partners_employment_type'); 	                            $recruitment_benefit_package_rank_id_options = array('' => 'Select...');
                        		foreach($options->result() as $option)
                        		{
                        			                        				$recruitment_benefit_package_rank_id_options[$option->employment_type_id] = $option->employment_type;
                        			                        		} ?>							<div class="input-group">
								<span class="input-group-addon">
	                            <i class="fa fa-list-ul"></i>
	                            </span>
	                            {{ form_dropdown('recruitment_benefit_package[rank_id]',$recruitment_benefit_package_rank_id_options, $record['recruitment_benefit_package.rank_id'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_benefit_package-rank_id"') }}
	                        </div> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Description</label>
				<div class="col-md-7">							<textarea class="form-control" name="recruitment_benefit_package[description]" id="recruitment_benefit_package-description" placeholder="Enter Description" rows="4">{{ $record['recruitment_benefit_package.description'] }}</textarea> 				</div>	
			</div>			<div class="form-group">
				<label class="control-label col-md-3">Is Active</label>
				<div class="col-md-7">							<div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
						    	<input type="checkbox" value="1" @if( $record['recruitment_benefit_package.status_id'] ) checked="checked" @endif name="recruitment_benefit_package[status_id][temp]" id="recruitment_benefit_package-status_id-temp" class="dontserializeme toggle"/>
						    	<input type="hidden" name="recruitment_benefit_package[status_id]" id="recruitment_benefit_package-status_id" value="@if( $record['recruitment_benefit_package.status_id'] ) 1 else 0 @endif"/>
							</div> 				</div>	
			</div>	</div>
</div>