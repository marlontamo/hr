<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="education-category">{{ lang('recruitform.friend_relative') }}</div>
        <div class="actions">
            <a class="btn btn-default" onclick="add_form('friend_relative', 'friend_relative')">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>
</div>

<!-- Previous Trainings : start doing the loop-->
<div id="personal_friend_relative">
    <input type="hidden" name="friend_relative_count" id="friend_relative_count" value="1" />
    <div class="portlet">
        <div class="portlet-title">
            <!-- <div class="caption" id="education-category">Company Name</div> -->
            <div class="tools">
                <a class="text-muted" id="delete_friend_relative-1" onclick="remove_form(this.id, 'friend_relative', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
                    <!-- START FORM -->
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.employee_name') }}
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                            
                            <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal_history[friend-relative-employee][]" id="recruitment_personal_history-friend-relative-employee">
                                <option value="">{{ lang('recruitform.select') }}</option>
                                    @if( sizeof( $employee ) > 0 )
                                        @foreach( $employee as $key => $val )
                                            <option value="{{ $val['user_id'] }}"> {{ $val['full_name'] }} </option>
                                        @endforeach
                                    @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.position') }}
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-position][]" id="friend-relative-position">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.dept') }}
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-dept][]" id="recruitment-friend-relative-dept">
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.relation') }}
                        </label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" maxlength="64" name="recruitment_personal_history[friend-relative-relation][]" id="friend-relative-relation">
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>