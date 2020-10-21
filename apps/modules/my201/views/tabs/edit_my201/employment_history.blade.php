<?php $editable = false?>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption" id="employment-category">{{ lang('my201.employment_history') }}</div>
            @if(in_array('employment', $partners_keys))
                @if($is_editable['employment'])
                <?php $editable = true?>
                <div class="actions">
                    <a class="btn btn-default" onclick="add_form('employment_history', 'employment')">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                @endif
            @endif

        </div>
    </div>

<div id="personal_employment">
    <?php $employment_count = count($employment_tab); ?>
    <input type="hidden" name="employment_count" id="employment_count" value="{{ $employment_count }}" />
    <?php 
    $count_employment = 0;
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
    foreach($employment_tab as $index => $employment){ 
        $count_employment++;
    ?>
    <div class="portlet">
        @if($editable)
        <div class="portlet-title">
            <div class="tools">
                <a class="text-muted" id="delete_employment-<?php echo $count_employment;?>" onclick="remove_form(this.id, 'employment', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
            </div>
        </div>
        @endif
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
            <!-- START FORM --> 
                    @if(in_array('employment-company', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.company_name') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" {{ ($is_editable['employment-company'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[employment-company][]" id="partners_personal_history-employment-company" 
                            value="<?php echo array_key_exists('employment-company', $employment) ? $employment['employment-company'] : ""; ?>" placeholder="Enter Company"/>
                        </div>
                    </div>
                    @endif
                    @if(in_array('employment-position-title', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.position') }}<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" {{ ($is_editable['employment-position-title'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[employment-position-title][]" id="partners_personal_history-employment-position-title" 
                            value="<?php echo array_key_exists('employment-position-title', $employment) ? $employment['employment-position-title'] : ""; ?>" placeholder="Enter Position"/>
                        </div>
                    </div>
                    @endif
                    @if(in_array('employment-location', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.location') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" {{  ($is_editable['employment-location'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[employment-location][]" id="partners_personal_history-employment-location" 
                            value="<?php echo array_key_exists('employment-location', $employment) ? $employment['employment-location'] : ""; ?>" placeholder="Enter Location"/>
                        </div>
                    </div>
                    @endif
                    @if(in_array('employment-month-hired', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.hire_date') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <?php $employment_month_hired = array_key_exists('employment-month-hired', $employment) ? $employment['employment-month-hired'] : ""; 
                                    $disabled = ($is_editable['employment-month-hired'] == 1) ? '' : 'disabled';
                                ?>
                                {{ form_dropdown('partners_personal_history[employment-month-hired][]',$months_options, $employment_month_hired, 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
                            </div>
                            <span class="pull-left padding-left-right-10">-</span>
                            <span class="pull-left">
                                <input type="text" class="form-control input-small" maxlength="4" {{  ($is_editable['employment-year-hired'] == 1) ? '' : 'readonly="readonly"' }} name="partners_personal_history[employment-year-hired][]" id="partners_personal_history-employment-year-hired" 
                            value="<?php echo array_key_exists('employment-year-hired', $employment) ? $employment['employment-year-hired'] : ""; ?>"placeholder="Year">
                            </span>                            
                        </div>
                    </div>
                    @endif
                    @if(in_array('employment-month-end', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.end_date') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <?php $employment_month_end = array_key_exists('employment-month-end', $employment) ? $employment['employment-month-end'] : ""; 
                                        $disabled = ($is_editable['employment-month-end'] == 1) ? '' : 'disabled';
                                ?>
                                {{ form_dropdown('partners_personal_history[employment-month-end][]',$months_options, $employment_month_end, 'class="form-control select2me" '.$disabled.' data-placeholder="Select..."') }}
                            </div>
                            <span class="pull-left padding-left-right-10">-</span>
                            <span class="pull-left">
                                <input type="text" class="form-control input-small" {{  ($is_editable['employment-year-end'] == 1) ? '' : 'readonly="readonly"' }} maxlength="4" name="partners_personal_history[employment-year-end][]" id="partners_personal_history-employment-year-end" 
                            value="<?php echo array_key_exists('employment-year-end', $employment) ? $employment['employment-year-end'] : ""; ?>"placeholder="Year">
                            </span>                            
                        </div>
                    </div>
                    @endif
                    @if(in_array('employment-duties', $partners_keys))
                    <div class="form-group">
                        <label class="control-label col-md-3">{{ lang('my201.duties') }}</label>
                        <div class="col-md-6">
                            <textarea rows="3" {{ ($is_editable['employment-month-end'] == 1) ? '' : 'readonly="readonly"' }} class="form-control"name="partners_personal_history[employment-duties][]" id="partners_personal_history-employment-duties" ><?php echo array_key_exists('employment-duties', $employment) ? $employment['employment-duties'] : ""; ?></textarea>
                        </div>
                    </div>
                    @endif
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

