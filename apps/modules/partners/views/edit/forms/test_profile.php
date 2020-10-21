<div class="portlet">
    <div class="portlet-title">
        <div class="caption" id="test-category">
            <input type="hidden" name="partners_personal_history[test-category][]" id="partners_personal_history-test-category" 
            value="<?php echo $category; ?>" />
            <?php echo $category; ?></div>
            <div class="tools">
                <a class="text-muted" id="delete_test-<?php echo $count;?>" onclick="remove_form(this.id, 'test', 'history')"  style="margin-botom:-15px;" href="#"><i class="fa fa-trash-o"></i> Delete</a>
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
                            <input type="text" class="form-control" name="partners_personal_history[test-title][]" id="partners_personal_history-test-title" placeholder="Enter Title"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Date Taken<span class="required">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                <input type="text" class="form-control" name="partners_personal_history[test-date-taken][]" id="partners_personal_history-test-date-taken" value="" placeholder="Enter Date Taken" >
                                <span class="input-group-btn">
                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Location<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[test-location][]" id="partners_personal_history-test-location" placeholder="Enter Location"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Score/Rating<span class="required">*</span></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="partners_personal_history[test-score][]" id="partners_personal_history-test-score" placeholder="Enter Score/Rating"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Result</label>
                        <div class="col-md-6">
                            <div class="make-switch" data-on="success" data-off="danger" data-on-label="&nbsp;Passed&nbsp;" data-off-label="&nbsp;Failed&nbsp;">
                                <input type="checkbox" value="1" checked="checked" name="partners_personal_history[test-result][temp][]" id="partners_personal_history-test-result-temp" class="dontserializeme toggle exam_result"/>
                                <input type="hidden" name="partners_personal_history[test-result][]" id="partners_personal_history-test-result" value="1"/>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Remarks</label>
                        <div class="col-md-6">
                            <textarea rows="3" class="form-control"name="partners_personal_history[test-remarks][]" id="partners_personal_history-test-remarks" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Supporting Documents</label>
                        <div class="col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload" id="partners_personal_history-test-attachments-container">
                                <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                    <?php 
                                        $filename = ''; 
                                    ?>

                                    <input type="hidden" name="partners_personal_history[test-attachments][]" id="partners_personal_history-test-attachments" value="">
                                <!-- </div> -->
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>                            
                                <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="uneditable-input">
                                                <i class="fa fa-file fileupload-exists"></i> 
                                                <span class="fileupload-preview"></span>
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
<script language="javascript">
    $(document).ready(function(){

        $('.make-switch').not(".has-switch")['bootstrapSwitch']();

        $('.exam_result').change(function(){
            if( $(this).is(':checked') ){
                $(this).parent().next().val(1);
            }
            else{
                $(this).parent().next().val(0);
            }
        });        
        $('label[for="partners_personal_history-test-result-temp"]').css('margin-top', '0');

        $('.test_attach').fileupload({ 
            url: base_url + module.get('route') + '/single_upload',
            autoUpload: true,
            contentType: false,
        }).bind('fileuploadadd', function (e, data) {
            $.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+root_url+'assets/img/ajax-loading.gif" />' });
        }).bind('fileuploaddone', function (e, data) { 

            $.unblockUI();
            var file = data.result.file;
            if(file.error != undefined && file.error != "")
            {
                notify('error', file.error);
            }
            else{
                $(this).parent().parent().parent().children('span').children('span').children('span.fileupload-preview').html(file.name);
                $(this).parent().children('span.fileupload-new').css('display', 'none');
                $(this).parent().children('.fileupload-exists').css('display', 'inline-block');
                $(this).parent().parent().children('.fileupload-delete').css('display', 'inline-block');
                $(this).parent().parent().parent().parent().children('input:hidden:first').val(file.url);
            }
        }).bind('fileuploadfail', function (e, data) { 
            $.unblockUI();
            notify('error', data.errorThrown);
        });

        $('.fileupload-delete').click(function(){
            $(this).parent().parent().parent().children('input:hidden:first').val('');
            $(this).parent().parent().children('span').children('span').children('span.fileupload-preview').html('');
            $(this).parent().children('span.add_file').children('span.fileupload-new').css('display', 'inline-block');
            $(this).parent().children('span.add_file').children('span.fileupload-exists').css('display', 'none');
            $(this).css('display', 'none');

            // $('#users_profile-photo').val('');
            // $('#users_profile-photo-container .fileupload-preview').html('');
            // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
            // $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
            // $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
        });


    });
</script>