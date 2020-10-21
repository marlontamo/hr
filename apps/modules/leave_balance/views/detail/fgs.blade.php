<div id="vl_container" class="portlet">
	<div class="portlet-title">
		<div class="caption">Leave Balance <small class="text-muted">view</small></div>
	</div>
    <div class="portlet-body form" id="main_form">
    <!-- BEGIN FORM-->
        <div class="form-body">
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">Year :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{ $record['time_form_balance_year'] }}</span>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">Leave Type :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{ $record['time_form_balance_form'] }}</span>
						</div>
					</div>
				</div>
			</div>	
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">Previous Credit :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{ $record['time_form_balance_previous'] }}</span>
						</div>
					</div>
				</div>
			</div>	
            <div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label col-md-4 col-sm-4 text-right text-muted">Current Credit :</label>
						<div class="col-md-7 col-sm-7">
							<span>{{ $record['time_form_balance_current'] }}</span>
						</div>
					</div>
				</div>
			</div>			
        </div>
    <!-- END FORM--> 
    </div>
</div>
