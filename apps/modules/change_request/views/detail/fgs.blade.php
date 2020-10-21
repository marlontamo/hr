<div id="personal_request" class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('my_change_request.change_request') }} <small class="text-muted">{{ lang('common.view') }}</small></div>
	</div>
    <div class="portlet-body form" id="main_form">
    	<form name="change-request-form">
	    	<input type="hidden" id="partner_id" name="partner_id" value="{{ $partner_id }}">
			<input type="hidden" id="created_on" name="created_on" value="{{ $created_on }}">
	    	<!-- BEGIN FORM-->
	        <div class="form-body">
			    @if( sizeof( $record ) > 0 )
		    		<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">{{ lang('my_change_request.employee') }} :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record[0]['employee_name'] }}</span>
								</div>
							</div>
						</div>
					</div>
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">{{ lang('my_change_request.company') }} :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record[0]['company'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">{{ lang('my_change_request.dept') }} :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ $record[0]['department'] }}</span>
								</div>
							</div>
						</div>
					</div>	
		            <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-4 col-sm-4 text-right text-muted margin-none">{{ lang('my_change_request.submitted_on') }} :</label>
								<div class="col-md-7 col-sm-7">
									<span>{{ date("F d, Y - h:i a", strtotime($record[0]['partners_personal_request_created_on'])) }}</span>
								</div>
							</div>
						</div>
					</div>	
					<div class="portlet">
						<div class="portlet-title margin-top-25">
							<div class="caption">{{ lang('my_change_request.requested_item') }}</div>
							<div class="tools">
								<a class="collapse" href="javascript:;"></a>
							</div>
						</div>
						<p class="margin-bottom-25">{{ lang('my_change_request.req_note') }}</p>	
						<div class="portlet-body form">
			    			<table class="table table-condensed table-striped table-hover" >
								<thead>
									<tr>
										<th width="20%" class="padding-top-bottom-10" >{{ lang('my_change_request.item') }}</th>
										<th width="30%" class="padding-top-bottom-10 hidden-xs" >{{ lang('my_change_request.current') }}</th>
										<th width="30%" class="padding-top-bottom-10">{{ lang('my_change_request.request') }}</th>
										<th width="20%" class="padding-top-bottom-10" >{{ lang('common.actions') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($record as $request)
										<tr>
											<td>{{ $request['label'] }}</td> 
											<td></td>
											<td>{{ $request['partners_personal_request_key_value'] }}</td>
											<td>
												<div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;&nbsp;{{ lang('my_change_request.approved') }}&nbsp;&nbsp;&nbsp;" data-off-label="&nbsp;{{ lang('my_change_request.decline') }}&nbsp;">
													<input type="hidden" name="personal_id[{{ $request['record_id'] }}]" value="{{ $request['status'] }}"/>
													<input type="checkbox" class="dontserializeme toggle" name="temp-personal_id[]" value="{{ $request['record_id'] }}" {{ ($request['status'] == 3) ?  'checked="checked"' : '' }} />
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
			    			</table>
			    		</div>
		    		</div>
			    @endif	
	        </div>
	        <!-- END FORM--> 
	    </form>
    </div>
</div>
