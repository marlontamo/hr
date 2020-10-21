<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="test-category">Test Profile</div>
        <div class="tools">
            <a class="collapse" href="javascript:;"></a>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-horizontal">
            <div class="form-body">
                <!-- START FORM -->             
                <div class="form-group">
                    <label class="control-label col-md-3">Exam Type</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <select  class="form-control select2me" data-placeholder="Select..." name="test_category" id="test_category">
                                <option value="Government Examination">Government Examination</option>
                                <option value="Professional Examination">Professional Examination</option>
                                <option value="Application Exam">Application Exam</option>
                            </select>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" onclick="add_form('test_profile', 'test')"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                        <div class="help-block">
                            Choose exam type to add.
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="personal_test">
    <?php $test_count = count($test_tab); ?>
    <input type="hidden" name="test_count" id="test_count" value="{{ $test_count }}" />
    <?php 
    $count_test = 0;
    foreach($test_tab as $index => $test){  
        $count_test++;
        ?>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption" id="test-category">
                    <input type="hidden" name="partners_personal_history[test-category][]" id="partners_personal_history-test-category" 
                    value="<?php echo array_key_exists('test-category', $test) ? $test['test-category'] : ""; ?>" />
                    <?php echo array_key_exists('test-category', $test) ? $test['test-category'] : ""; ?></div>
                    <div class="tools">
                <a class="text-muted" id="delete_test-<?php echo $count_test;?>" onclick="remove_form(this.id, 'test', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> Delete</a>
                        <!-- <a class="collapse pull-right" href="javascript:;"></a> -->
                    </div>
                </div>
                <div class="portlet-body form">
                    <div class="form-horizontal">
                        <div class="form-body">
                            <!-- START FORM --> 
                            <div class="form-group">
                                <label class="control-label col-md-3">Title<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="partners_personal_history[test-title][]" id="partners_personal_history-test-title" 
                                    value="<?php echo array_key_exists('test-title', $test) ? $test['test-title'] : ""; ?>" placeholder="Enter Title"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Date Taken<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                        <input type="text" class="form-control" name="partners_personal_history[test-date-taken][]" id="partners_personal_history-test-date-taken"
                                        value="<?php echo array_key_exists('test-date-taken', $test) ? $test['test-date-taken'] : ""; ?>" placeholder="Enter Date Taken" >
                                        <span class="input-group-btn">
                                        <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Location<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="partners_personal_history[test-location][]" id="partners_personal_history-test-location" 
                                    value="<?php echo array_key_exists('test-location', $test) ? $test['test-location'] : ""; ?>" placeholder="Enter Location"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Score/Rating<span class="required">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="partners_personal_history[test-score][]" id="partners_personal_history-test-score" 
                                    value="<?php echo array_key_exists('test-score', $test) ? $test['test-score'] : ""; ?>" placeholder="Enter Score/Rating"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Result</label>
                                <div class="col-md-6">
                                    <div class="make-switch" data-on="success" data-off="danger" data-on-label="&nbsp;Passed&nbsp;" data-off-label="&nbsp;Failed&nbsp;">
                                        <?php $testresult = array_key_exists('test-result', $test) ? $test['test-result'] : ""; ?>
                                        <input type="checkbox" value="1" @if( $testresult ) checked="checked" @endif name="partners_personal_history[test-result][temp][]" id="partners_personal_history-test-result-temp" class="dontserializeme toggle exam_result"/>
                                        <input type="hidden" name="partners_personal_history[test-result][]" id="partners_personal_history-test-result" 
                                        value="<?php echo array_key_exists('test-result', $test) ? $test['test-result'] : 0; ?>"/>
                                    </div> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Remarks</label>
                                <div class="col-md-6">
                                    <textarea rows="3" class="form-control"name="partners_personal_history[test-remarks][]" id="partners_personal_history-test-remarks" ><?php echo array_key_exists('test-remarks', $test) ? $test['test-remarks'] : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Supporting Documents</label>
                                <div class="col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload" id="partners_personal_history-test-attachments-container">
                                    <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                        <?php 
                                            $docs = array_key_exists('test-attachments', $test) ? $test['test-attachments'] : "";
                                            if(empty($docs)){
                                                $filename = '';
                                            }else{
                                                $filename = urldecode(basename($docs));
                                            }
                                        ?>

                                        <input type="hidden" name="partners_personal_history[test-attachments][]" id="partners_personal_history-test-attachments" value="{{$docs}}">
                                    <!-- </div> -->
                                        <!-- <div class="fileupload-preview thumbnail " style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>                             -->
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i> 
                                                    <span class="fileupload-preview">{{$filename}}</span>
                                                </span>
                                            </span>
                                            <div id="test-attachments-container">
                                                <span class="btn default btn-file add_file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                    <input type="file" name="files[]" class="default file test_attach" id="partners_personal_history-test-attachments-fileupload" />
                                                </span>
                                                <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                                            </div>
                                        </div>
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
                        <button class="btn green btn-sm" type="button" onclick="save_partner( $(this).parents('form') )" ><i class="fa fa-check"></i> Save</button>
                        <button class="btn blue btn-sm" type="submit"><i class="fa fa-undo"></i> Reset</button>                               
                    </div>
                </div>
            </div>
        </div>