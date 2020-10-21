<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Shift Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
		<div class="portlet-body form">		
			<div class="form-group">
				<label class="control-label col-md-3">Company</label>
				<div class="col-md-7">
					<?php $company = $mod->_get_shift_options( $record_id, true , true, 2); ?>
                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	                    <select name="time_shift[company_id][]" id="time_shift-company_id" class="select2me form-control" multiple>
                        	{{ $company }}
                        </select>
	                </div>
	            </div>	
			</div>
			<div class="form-group hidden">
				<label class="control-label col-md-3">Department</label>
				<div class="col-md-7">
					<?php $department = $mod->_get_shift_options( $record_id, true , true, 4); ?>
                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	                    <select name="time_shift[department_id][]" id="time_shift-department_id" class="select2me form-control" multiple>
	                    	{{ $department }}
                        </select>
	                </div>
	            </div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>Shift</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="time_shift[shift]" id="time_shift-shift" value="{{ $record['time_shift.shift'] }}" placeholder="Enter Shift" />
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>From</label>
				<div class="col-md-7">
					<div class="input-group bootstrap-timepicker">                                       
						<input type="text" class="form-control timepicker-default" name="time_shift[time_start]" id="time_shift-time_start" value="{{ date('h:i A',strtotime($record['time_shift.time_start'])) }}" />
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>
					</div>
				</div>	
			</div>
			<div class="form-group">
				<label class="control-label col-md-3"><span class="required">* </span>To</label>
				<div class="col-md-7">
					<div class="input-group bootstrap-timepicker">                                       
						<input type="text" class="form-control timepicker-default" name="time_shift[time_end]" id="time_shift-time_end" value="{{ date('h:i A',strtotime($record['time_shift.time_end'])) }}" />
						<span class="input-group-btn">
							<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
						</span>
					</div>
				</div>	
			</div>
<!-- 			<div class="form-group">
				<label class="control-label col-md-3">Color</label>
				<div class="col-md-7">

					<div class="input-group color colorpicker-default" data-color="{{ $record['time_shift.color'] or '#3865a8' }}" data-color-format="rgba">
						<input type="text" class="form-control" readonly name="time_shift[color]" id="time_shift-color" value="{{ $record['time_shift.color'] }}" placeholder="Enter Color" />
						<span class="input-group-btn">
							<button class="btn default" type="button"><i style="background-color: {{ $record['time_shift.color'] or '#3865a8' }};position: relative;right:0"></i></button>
						</span>
					</div>

					
				</div>	
			</div> -->
<!-- 			<div class="form-group">
				<label class="control-label col-md-3">Default Calendar</label>
				<div class="col-md-7">
						<?php $db->select('calendar_id,calendar');
	                          $db->order_by('calendar', '0');
	                          $db->where('deleted', '0');
	                          $options = $db->get('time_shift_weekly');
	                          $time_shift_weekly_calendar_id_options = array('' => 'Select...');
                        	  	foreach($options->result() as $option){
                        			$time_shift_weekly_calendar_id_options[$option->calendar_id] = $option->calendar;
                        		} ?>
                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-list-ul"></i></span>
	                    {{ form_dropdown('time_shift[default_calendar]',$time_shift_weekly_calendar_id_options, $record['time_shift.default_calendar'], 'class="form-control select2me" data-placeholder="Select..."') }}
	                </div>
	            </div>	
			</div> -->
			<div class="form-group">
				<label class="control-label col-md-3">Use Tag</label>
				<div class="col-md-7">
                    <div class="make-switch" data-off="danger" data-on="success" data-on-label="&nbsp;{{ lang('common.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('common.no') }}&nbsp;">
				    	<input type="checkbox" value="1" {{ ($record['time_shift.use_tag'] == 1) ? 'checked="checked"' : ''  }}  class="dontserializeme toggle" id="time_shift-use_tag-temp"/>
				    	<input type="hidden" name="time_shift[use_tag]" id="time_shift-use_tag" value="{{ $record['time_shift.use_tag'] }}"/>
					</div>
					<span class="text-muted help-block">Strict use of time-in and time-out</span>
	            </div>	
			</div>
		</div>
</div>