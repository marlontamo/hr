<div class="portlet">
	<div class="portlet-title">
		<div class="caption" id="education-category">{{ lang('recruitform.licensure') }}</div>
		<div class="actions">
            <a class="btn btn-default" onclick="add_form('licensure_examination', 'licensure')">
                <i class="fa fa-plus"></i>
            </a>
		</div>
	</div>
</div>

<div id="personal_licensure">
    <input type="hidden" name="licensure_count" id="licensure_count" value="1" />
    <div class="portlet">
        <div class="portlet-title">
            <!-- <div class="caption" id="education-category">Company Name</div> -->
            <div class="tools">
                <a class="text-muted" id="delete_licensure-1" onclick="remove_form(this.id, 'licensure', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> {{ lang('common.delete') }}</a>
                <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
            </div>
        </div>
        <div class="portlet-body form">
            <div class="form-horizontal">
                <div class="form-body">
            <!-- START FORM -->                 
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.title') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[licensure-title][]" id="recruitment_personal_history-licensure-title" placeholder="Enter Title"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.license_no') }}</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <input type="text" class="form-control" name="recruitment_personal_history[licensure-number][]" id="recruitment_personal_history-licensure-number" placeholder="Enter License Number"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('recruitform.date_taken') }}<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group input-medium pull-left">
                                <select  class="form-control form-select" data-placeholder="Select Month.." name="recruitment_personal_history[licensure-month-taken][]" id="recruitment_personal_history-licensure-month-taken">
                                    <option value="January">{{ lang('cal_january') }}</option>
                                    <option value="February">{{ lang('cal_february') }}</option>
                                    <option value="March">{{ lang('cal_march') }}</option>
                                    <option value="April">{{ lang('cal_april') }}</option>
                                    <option value="May">{{ lang('cal_may') }}</option>
                                    <option value="June">{{ lang('cal_june') }}</option>
                                    <option value="July">{{ lang('cal_july') }}</option>
                                    <option value="August">{{ lang('cal_august') }}</option>
                                    <option value="September">{{ lang('cal_september') }}</option>
                                    <option value="October">{{ lang('cal_october') }}</option>
                                    <option value="November">{{ lang('cal_november') }}</option>
                                    <option value="December">{{ lang('cal_december') }}</option>
                                </select>
                            </div>
                            <span class="pull-left padding-left-right-10">-</span>
                            <span class="pull-left"><input type="text" class="form-control input-small mask_number_year" maxlength="4" name="recruitment_personal_history[licensure-year-taken][]" id="recruitment_personal_history-licensure-year-taken" placeholder="Year"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 small">{{ lang('common.remarks') }}</label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <textarea rows="3" class="form-control"name="recruitment_personal_history[licensure-remarks][]" id="recruitment_personal_history-licensure-remarks" ></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-md-3 small">Supporting Documents</label>
                        <div class="col-md-9">                          
                            <div data-provides="fileupload" class="fileupload fileupload-new" id="users_profile-photo-container"> -->
                                        <!-- @if( !empty($record['users_profile.photo']) ) -->
                                            <?php 
                                                // $file = FCPATH . urldecode( $record['users_profile.photo'] );
                                                // if( file_exists( $file ) )
                                                // {
                                                //     $f_info = get_file_info( $file );
                                                // }
                                            ?>
                                            <!-- @endif -->
                                <!-- <input type="hidden" name="users_profile[photo]" id="users_profile-photo" value=""/>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="uneditable-input">
                                            <i class="fa fa-file fileupload-exists"></i> 
                                            <span class="fileupload-preview"> -->
                                                <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->
                                            <!-- </span>
                                        </span>
                                    </span>
                                    <span class="btn default btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" id="users_profile-photo-fileupload" type="file" name="files[]">
                                    </span>
                                    <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </div>

</div>