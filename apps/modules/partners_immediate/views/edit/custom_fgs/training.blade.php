<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="training-category">{{ lang('partners_immediate.training') }} </div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
                <!-- START FORM -->             
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('partners_immediate.category') }} </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control select2me" data-placeholder="Select..." name="training_category" id="training_category">
                                <option value="Training">{{ lang('partners_immediate.train') }} </option>
                                <option value="Seminar">{{ lang('partners_immediate.seminar') }} </option>
                            </select>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="add_form('training_seminar', 'training')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block">
                            {{ lang('partners_immediate.add_training') }}
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="personal_training">
    <?php $training_count = count($training_tab); ?>
    <input type="hidden" name="training_count" id="training_count" value="{{ $training_count }}" />
    <?php 
    $type_with_degree = array('tertiary', 'graduate studies', 'vocational');
    $count_training = 0;
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
    foreach($training_tab as $index => $training){  
        $count_training++;
        ?>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption" id="training-category">
                    <input type="hidden" name="partners_personal_history[training-category][]" id="partners_personal_history-training-category" 
                    value="<?php echo array_key_exists('training-category', $training) ? $training['training-category'] : ""; ?>" />
                    <?php echo array_key_exists('training-category', $training) ? $training['training-category'] : ""; ?></div>
                    <div class="tools">
                <a class="text-muted" id="delete_training-<?php echo $count_training;?>" onclick="remove_form(this.id, 'training', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> Delete</a>
                        <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-horizontal">
                        <div class="form-body">
                            <!-- START FORM --> 
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('partners_immediate.title') }}<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="partners_personal_history[training-title][]" id="partners_personal_history-training-title" 
                                    value="<?php echo array_key_exists('training-title', $training) ? $training['training-title'] : ""; ?>" placeholder="Enter Title"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('partners_immediate.venue') }}<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="partners_personal_history[training-venue][]" id="partners_personal_history-training-venue" 
                                    value="<?php echo array_key_exists('training-venue', $training) ? $training['training-venue'] : ""; ?>" placeholder="Enter Venue"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('partners_immediate.start_date') }}<span class="required">*</span></label>                                
                                <div class="col-md-9">
                                    <div class="input-group input-medium pull-left">
                                        <?php $training_month_hired = array_key_exists('training-start-month', $training) ? $training['training-start-month'] : ""; ?>
                                {{ form_dropdown('partners_personal_history[training-start-month][]',$months_options, $training_month_hired, 'class="form-control select2me" data-placeholder="Select..."') }}
                                    </div>
                                    <span class="pull-left padding-left-right-10">-</span>
                                    <span class="pull-left">
                                        <input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[training-start-year][]" id="partners_personal_history-training-start-year" 
                                    value="<?php echo array_key_exists('training-start-year', $training) ? $training['training-start-year'] : ""; ?>"placeholder="Year">
                                    </span>                            
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{ lang('partners_immediate.end_date') }}<span class="required">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-group input-medium pull-left">
                                        <?php $training_month_end = array_key_exists('training-end-month', $training) ? $training['training-end-month'] : ""; ?>
                                {{ form_dropdown('partners_personal_history[training-end-month][]',$months_options, $training_month_end, 'class="form-control select2me" data-placeholder="Select..."') }}
                                    </div>
                                    <span class="pull-left padding-left-right-10">-</span>
                                    <span class="pull-left">
                                        <input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[training-end-year][]" id="partners_personal_history-training-end-year" 
                                    value="<?php echo array_key_exists('training-end-year', $training) ? $training['training-end-year'] : ""; ?>"placeholder="Year">
                                    </span>                            
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
                        <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> {{ lang('common.save') }}</button>
                        <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>                               
                    </div>
                </div>
            </div>
        </div>