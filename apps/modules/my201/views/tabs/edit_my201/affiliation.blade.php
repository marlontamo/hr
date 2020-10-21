<?php $editable = false?>
<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('my201.affiliation') }}</div>
	    @if(in_array('employment', $partners_keys))
	        @if($is_editable['employment'])
	        <?php $editable = true?>
			<div class="actions">
		        <a class="btn btn-default" onclick="add_form('affiliation', 'affiliation')">
		            <i class="fa fa-plus"></i>
		        </a>
			</div>
		    @endif
        @endif
	</div>
</div>

<div id="personal_affiliation">
    <?php $affiliation_count = count($skill_tab); ?>
    <input type="hidden" name="affiliation_count" id="affiliation_count" value="{{ $affiliation_count }}" />
    <?php 
    $count_affiliation = 0;
    $months_options = array(
        '' => 'Select...',
        'January' => 'January', 
        'February' => 'February', 
        'March' => 'March', 
        'April' => 'April', 
        'May' => 'May', 
        'June' => 'June', 
        'July' => 'July', 
        'August' => 'August', 
        'September' => 'September', 
        'October' => 'October', 
        'November' => 'November', 
        'December' => 'December'
        );
    foreach($affiliation_tab as $index => $affiliation){ 
        $count_affiliation++;
?>
<div class="portlet">
	@if($editable)
		<div class="portlet-title">
			<div class="tools">
	            <a class="text-muted" id="delete_affiliation-<?php echo $count_affiliation;?>" onclick="remove_form(this.id, 'affiliation', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
			</div>
		</div>
	@endif
	<div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
		<!-- START FORM -->
				@if(in_array('affiliation-name', $partners_keys))
	               	<div class="form-group">
	                    <label class="control-label col-md-3">{{ lang('my201.affiliation_name') }}<span class="required">*</span></label>
	                    <div class="col-md-6">
	                        <input type="text" {{ ($is_editable['affiliation-name'] == 1) ? '' : 'readonly="readonly"' }} class="form-control" name="partners_personal_history[affiliation-name][]" id="partners_personal_history-affiliation-name" 
	                        value="<?php echo array_key_exists('affiliation-name', $affiliation) ? $affiliation['affiliation-name'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('my201.affiliation_name') }}"/>
	                    </div>
	                </div>
	            @endif
	            @if(in_array('affiliation-position', $partners_keys))
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.position') }}<span class="required">*</span></label>
                    <div class="col-md-6">
                        <input type="text" {{ ($is_editable['affiliation-position'] == 1) ? '' : 'readonly="readonly"' }} class="form-control" name="partners_personal_history[affiliation-position][]" id="partners_personal_history-affiliation-position" 
                        value="<?php echo array_key_exists('affiliation-position', $affiliation) ? $affiliation['affiliation-position'] : ""; ?>" placeholder="{{ lang('common.enter') }} {{ lang('my201.position') }}"/>
                    </div>
                </div>
                @endif
	            
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.start_date') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                    	@if(in_array('affiliation-month-start', $partners_keys))
                        <div class="input-group input-medium pull-left">
                            <?php $affiliation_month_hired = array_key_exists('affiliation-month-start', $affiliation) ? $affiliation['affiliation-month-start'] : "";
                            	 $disabled = ($is_editable['affiliation-month-start'] == 1) ? '' : 'disabled';
                             ?>
                    		{{ form_dropdown('partners_personal_history[affiliation-month-start][]',$months_options, $affiliation_month_hired, 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
                        </div>
                        @endif
                        @if(in_array('affiliation-year-start', $partners_keys))
                        <span class="pull-left padding-left-right-10">-</span>
                        <span class="pull-left">
                            <input type="text" {{ ($is_editable['affiliation-year-start'] == 1) ? '' : 'readonly="readonly"' }} class="form-control input-small" maxlength="4" name="partners_personal_history[affiliation-year-start][]" id="partners_personal_history-affiliation-year-start" 
                        value="<?php echo array_key_exists('affiliation-year-start', $affiliation) ? $affiliation['affiliation-year-start'] : ""; ?>"placeholder="Year">
                        </span>    
                        @endif                        
                    </div>
                </div>
	            
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('my201.end_date') }}<span class="required">*</span></label>
                    <div class="col-md-9">
                    	@if(in_array('affiliation-month-end', $partners_keys))
                        <div class="input-group input-medium pull-left">
                            <?php $affiliation_month_end = array_key_exists('affiliation-month-end', $affiliation) ? $affiliation['affiliation-month-end'] : ""; 
                            		 $disabled = ($is_editable['affiliation-month-end'] == 1) ? '' : 'disabled';
                            ?>
                    		{{ form_dropdown('partners_personal_history[affiliation-month-end][]',$months_options, $affiliation_month_end, 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
                        </div>
                        @endif
                        @if(in_array('affiliation-year-end', $partners_keys))
                        <span class="pull-left padding-left-right-10">-</span>
                        <span class="pull-left">
                            <input type="text" {{ ($is_editable['affiliation-year-end'] == 1) ? '' : 'readonly="readonly"' }} class="form-control input-small" maxlength="4" name="partners_personal_history[affiliation-year-end][]" id="partners_personal_history-affiliation-year-end" 
                        value="<?php echo array_key_exists('affiliation-year-end', $affiliation) ? $affiliation['affiliation-year-end'] : ""; ?>"placeholder="{{ lang('my201.year') }}">
                        </span> 
                        @endif                           
                    </div>
                </div>
                
			</div>
		</div>
	</div>
</div>
<?php } ?>
</div>
<div class="form-actions fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-offset-3 col-md-8">
                @if($editable)
                    <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                    <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
                @endif  
            </div>
        </div>
    </div>
</div>
