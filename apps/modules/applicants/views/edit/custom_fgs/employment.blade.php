<div class="portlet">
	<div class="portlet-title">
		<div class="caption">{{ lang('applicants.app_info') }}</div>
		<div class="tools">
			<a class="collapse" href="javascript:;"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- START FORM -->
        <div class="form-horizontal" >
			<div class="form-body">
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.encoded_on') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-file-o"></i>
                             </span>
                            <input type="text" class="form-control" value="Applicants" readonly/>
                            <input type="hidden" class="form-control" name="recruitment[source_id]" id="recruitment-source_id" value="1" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('common.status') }}
                    </label>
                    <div class="col-md-5">  
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-file-o"></i>
                             </span>
                            <input type="text" class="form-control" value="{{ $record['recruit_status'] }}" readonly/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.dt_application') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-5">
                        <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control" name="recruitment[recruitment_date]" id="recruitment-recruitment_date" value="{{ $record['recruitment_date'] }}" placeholder="Enter Application Date" >
                            <span class="input-group-btn">
                            <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.pos_sought') }}
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-user"></i>
                             </span>
                            <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">

                                <option value="">Please Select</option>
                                    @if( sizeof( $mrf ) > 0 )
                                        @foreach( $mrf as $year => $mrfs )
                                            @foreach( $mrfs as $mrf )
                                                <?php
                                                if($mrf->position_sought == $record['position_sought']) {
                                                    $selected = 'selected="selected"';
                                                }
                                                else{
                                                    $selected = '';
                                                }
                                                ?>                                            
                                                <option <?php echo $selected ?> value="{{ $mrf->position_sought }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position_sought }} ({{ $mrf->document_no }})</option>
                                            @endforeach
                                        @endforeach
                                    @endif
                            </select>

                            <input type="hidden" class="form-control" name="recruitment[request_id]" id="recruitment-request_id" value="{{ $record['request_id'] }}" placeholder="Enter Position Sought"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.oth_pos') }}
                    </label>
                    <div class="col-md-5">
                        <div class="input-icon">
                            <input type="text" class="form-control" maxlength="64" name="recruitment[oth_position]" value="{{ $record['oth_position'] }}" placeholder="Enter Other Position" id="recruitment-firstname">
                        </div>
                    </div>
                </div>                
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.desired_salary') }}</label>
                    <div class="col-md-5">
                       <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-money"></i>
                             </span>
                            <input type="text" class="form-control" name="recruitment_personal[desired_salary]" id="recruitment_personal-desired_salary" value="{{ $record['desired_salary'] }}" placeholder="Enter Desired Salary"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                            <select class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[salary_pay_mode]" id="recruitment_personal-salary_pay_mode" >
                                <option value="Monthly">{{ lang('applicants.monthly') }}</option>
                                <option value="Hourly">{{ lang('applicants.hourly') }}</option>
                            </select>
                        </div>
                        <small class="help-block">
                            {{ lang('applicants.note_sal_payment') }}
                        </small>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.currently_employed') }}</label>
                    <div class="col-md-5">
                        <div class="make-switch" data-on-label="&nbsp;{{ lang('applicants.yes') }}&nbsp;" data-off-label="&nbsp;{{ lang('applicants.no') }}&nbsp;">
                            <input type="checkbox" value="1" @if( $record['currently_employed'] ) checked="checked" @endif name="recruitment_personal[currently_employed][temp]" id="recruitment_personal-currently_employed-temp" class="dontserializeme toggle"/>
                            <input type="hidden" name="recruitment_personal[currently_employed]" id="recruitment_personal-currently_employed" value="@if( $record['currently_employed'] ) 1 @else 0 @endif"/>
                        </div> 
                    </div>
                </div>
<!--                 <div class="form-group">
                    <label class="control-label col-md-3"> Sourcing Tools<br>
                        <span class="text-muted small">{{ lang('applicants.note') }}</span>
                    </label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-addon">
                               <i class="fa fa-map-marker"></i>
                             </span>
                           
                                <?php
                                    $db->select('sourcing_tool_id,sourcing_tool');
                                    $db->order_by('sourcing_tool', '0');
                                    $db->where('deleted', '0');
                                    $options = $db->get('recruitment_sourcing_tools');
                                    $recruitment_sourcing_tools_id_options = array('' => 'Please Select...');
                             
                                    foreach($options->result() as $option){
                                        $recruitment_sourcing_tools_id_options[$option->sourcing_tool_id] = $option->sourcing_tool;
                                    }
                                ?>
                                {{ form_dropdown('recruitment_personal[sourcing_tools]',$recruitment_sourcing_tools_id_options, $record['sourcing_tools'], 'class="form-control select2me" data-placeholder="Select..." id="recruitment_personal-sourcing_tools"') }}

                               
                        </div>
                        <small class="help-block">
                            {{ lang('applicants.note_mode_payment') }}
                        </small>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="control-label col-md-3">{{ lang('applicants.resume') }}</label>
                    <div class="col-md-9">
                        <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-resume-container">
                            <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                <?php 
                                    $filename = urldecode(basename($record['resume'])); 
                                    // if(strtolower($filename) == 'avatar.png'){
                                    //     $record['resume'] = '';
                                    //     $filename = '';
                                    // }
                                ?>

                                <!-- <img class= "resume-display"
                                    id="img-preview" 
                                    src="{{ base_url($record['resume']) }}" 
                                     style="width: 200px; height: 150px;" /> -->
                                <input type="hidden" name="recruitment_personal[resume]" id="recruitment_personal-resume" value="{{ $record['resume'] }}">
                            <!-- </div> -->
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>                            
                            <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="uneditable-input">
                                            <i class="fa fa-file fileupload-exists"></i> 
                                            <span class="fileupload-preview">{{ $filename }}</span>
                                        </span>
                                    </span>
                                    <div id="resume-container">
                                <span class="btn default btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('applicants.select_file') }}</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" name="files[]" class="default file" id="recruitment_personal-resume-fileupload" />
                                </span>
                                <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> {{ lang('common.remove') }}</a>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-actions fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-offset-3 col-md-8">
                            <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )"><i class="fa fa-check"></i> {{ lang('common.save') }} @if (empty($record['record_id'])) and {{ lang('common.next') }} @endif</button>
                            <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> {{ lang('common.reset') }}</button>
                            <a class="btn default btn-sm" href="{{ $mod->url }}" type="button" >{{ lang('common.back_to_list') }}</a>                           
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
	</div>
</div>
