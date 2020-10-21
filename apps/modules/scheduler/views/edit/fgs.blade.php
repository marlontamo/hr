<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Scheduler Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>

	<div class="portlet-body form">	</div>

	<div class="portlet-body form">			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('scheduler.title') }}<span class="required">*</span></label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="scheduler[title]" id="scheduler-title" value="{{ $record['scheduler.title'] }}" placeholder="Enter Title" /> 				
			</div>	
		</div>			
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('scheduler.sp_function') }}<span class="required">*</span></label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="scheduler[sp_function]" id="scheduler-sp_function" value="{{ $record['scheduler.sp_function'] }}" placeholder="Enter SP Function" /> 				
			</div>	
		</div>	
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('scheduler.arguments') }}<span class="required">*</span></label>
			<div class="col-md-7">							
				<input type="text" class="form-control" name="scheduler[arguments]" id="scheduler-arguments" value="{{ $record['scheduler.arguments'] }}" placeholder="Enter Function Arguments" /> 				
			</div>	
		</div>					
		<div class="form-group">
			<label class="control-label col-md-3">{{ lang('scheduler.description') }}<span class="required">*</span></label>
			<div class="col-md-7">
				<textarea rows="3" class="form-control"name="scheduler[description]" id="scheduler-description" >{{ $record['scheduler.description'] }}</textarea>
			</div>	
		</div>		
	</div>
</div>