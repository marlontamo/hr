<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="education-category">{{ lang('applicants.friend_relative') }}</div>
        <div class="actions">
            <a class="btn btn-default" onclick="add_form('friend                                                                                                                                                                                                            _relative', 'friend_relative')">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
</div>

<!-- Previous Trainings : start doing the loop-->
<div id="personal_friend_relative">
    <?php $friend_relative_count = count($friend_relative_tab); ?>
    <input type="hidden" name="friend_relative_count" id="friend_relative_count" value="{{ $friend_relative_count }}" />
    <?php 
    $count_friend_relative = 0;
    foreach($friend_relative_tab as $index => $friend_relative){ 
        $count_friend_relative++;
    ?>    
        <div class="portlet">
            <div class="portlet-title">
                <!-- <div class="caption" id="education-category">Company Name</div> -->
                <div class="tools">
                    <a class="text-muted" id="delete_friend_relative-<?php echo $count_friend_relative;?>" onclick="remove_form(this.id, 'friend_relative', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
                    <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <!-- START FORM -->
                        <div class="form-group">
                            <label class="control-label col-md-3 small">{{ lang('applicants.employee_name') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-9">
                                
                                <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal_history[friend-relative-employee][]" id="recruitment_personal_history-friend-relative-employee">
                                    <option value="">{{ lang('applicants.select') }}</option>
                                        <?php $selected = ''; ?>
                                        @if( sizeof( $employee ) > 0 )
                                            @foreach( $employee as $key => $val )
                                                <?php
                                                if(array_key_exists('friend-relative-employee', $friend_relative) && $friend_relative['friend-relative-employee'] == $val['user_id']) {
                                                    $selected = 'selected="selected"';
                                                }
                                                else{
                                                    $selected = '';
                                                }
                                                ?>
                                                <option <?php echo $selected ?> value="{{ $val['user_id'] }}"> {{ $val['full_name'] }} </option>
                                            @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 small">{{ lang('applicants.position') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <input value="<?php echo array_key_exists('friend-relative-position', $friend_relative) ? $friend_relative['friend-relative-position'] : ""; ?>" type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-position][]" id="friend-relative-position">
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 small">{{ lang('applicants.dept') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <input value="<?php echo array_key_exists('friend-relative-dept', $friend_relative) ? $friend_relative['friend-relative-dept'] : ""; ?>" type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-dept][]" id="recruitment-friend-relative-dept">
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 small">{{ lang('applicants.relation') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-icon">
                                    <input value="<?php echo array_key_exists('friend-relative-relation', $friend_relative) ? $friend_relative['friend-relative-relation'] : ""; ?>" type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-relation][]" id="friend-relative-relation">
                                </div>
                                
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
                <a class="btn default btn-sm" href="{{ $mod->url }}" type="button" >{{ lang('common.back_to_list') }}</a>                                
            </div>
        </div>
    </div>
</div>
