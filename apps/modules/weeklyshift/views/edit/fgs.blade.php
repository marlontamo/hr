<div class="portlet">
	<div class="portlet-title">
		<div class="caption">Weekly Shift Information</div>
		<div class="tools"><a class="collapse" href="javascript:;"></a></div>
	</div>
	<div class="portlet-body form">
		<?php	                            	                            		


		$db->select('shift_id,shift');
		$db->where('deleted', '0');
		$orderby = '(shift +0) ASC ,shift ASC';
		$db->order_by($orderby,false);
		$options = $db->get('time_shift');
		$time_shift_options = array();
		foreach($options->result() as $option)
		{
			$time_shift_options[$option->shift_id] = $option->shift;
		} 



		?>			
		<div class="form-group">
				<label class="control-label col-md-3">Shift Name</label>
				<div class="col-md-7">							
					<input type="text" class="form-control" name="time_shift_weekly[calendar]" id="time_shift_weekly-calendar" value="{{ $record['time_shift_weekly.calendar'] }}" placeholder="Enter Shift Name"/> 				
				</div>	
		</div>	
	</div>
	<hr />
	<div class="portlet-body form">			
		<div class="form-group">
				<label class="control-label col-md-3">Monday</label>
				<div class="col-md-5">
					{{ form_dropdown('shift_weekly[shift][2]',$time_shift_options, $monday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>	
		<div class="form-group">
				<label class="control-label col-md-3">Tuesday</label>
				<div class="col-md-5">
					{{ form_dropdown('shift_weekly[shift][3]',$time_shift_options, $tuesday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">Wednesday</label>
				<div class="col-md-5">
                    {{ form_dropdown('shift_weekly[shift][4]',$time_shift_options, $wednesday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">Thursday</label>
				<div class="col-md-5">
                    {{ form_dropdown('shift_weekly[shift][5]',$time_shift_options, $thursday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">Friday</label>
				<div class="col-md-5">
                    {{ form_dropdown('shift_weekly[shift][6]',$time_shift_options, $friday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">Saturday</label>
				<div class="col-md-5">
                    {{ form_dropdown('shift_weekly[shift][7]',$time_shift_options, $saturday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
				<label class="control-label col-md-3">Sunday</label>
				<div class="col-md-5">
                    {{ form_dropdown('shift_weekly[shift][1]',$time_shift_options, $sunday_shift, 'class="form-control select2me" data-placeholder="Select..."') }}
                </div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3">Default<span class="required">*</span></label>
			<div class="col-md-6">
            <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                <input type="checkbox" value="1" @if( $record['time_shift_weekly.default'] ) checked="checked" @endif name="shift_weekly[time_shift_weekly.default]" id="shift_weekly-default-temp" class="dontserializeme toggle"/>
                <input type="hidden" value="@if( $record['time_shift_weekly.default'] ) 1 else 0 @endif" name="time_shift_weekly[default]" id="shift_weekly-default"/>
            </div>
			</div>
		</div>   
	</div>
</div>
