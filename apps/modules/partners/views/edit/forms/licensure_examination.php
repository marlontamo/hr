<div class="portlet">
	<div class="portlet-title">
		<!-- <div class="caption" id="education-category">Company Name</div> -->
		<div class="tools">
            <a class="text-muted" id="delete_licensure-<?php echo $count;?>" onclick="remove_form(this.id, 'licensure', 'history')" href="#" style="margin-botom:-15px;"><i class="fa fa-trash-o"></i> Delete</a>
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
                        <input type="text" class="form-control" name="partners_personal_history[licensure-title][]" id="partners_personal_history-licensure-title" placeholder="Enter Title"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">License No.</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="partners_personal_history[licensure-number][]" id="partners_personal_history-licensure-number" placeholder="Enter License Number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Date Taken<span class="required">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group input-medium pull-left">
                            <select  class="form-control form-select" data-placeholder="Select Month.." name="partners_personal_history[licensure-month-taken][]" id="partners_personal_history-licensure-month-taken">
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <span class="pull-left padding-left-right-10">-</span>
                        <span class="pull-left"><input type="text" class="form-control input-small" maxlength="4" name="partners_personal_history[licensure-year-taken][]" id="partners_personal_history-licensure-year-taken" placeholder="Year"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Remarks</label>
                    <div class="col-md-6">
                        <textarea rows="3" class="form-control"name="partners_personal_history[licensure-remarks][]" id="partners_personal_history-licensure-remarks" ></textarea>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="control-label col-md-3">Supporting Documents</label>
                    <div class="col-md-6">                          
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
                <div class="form-group">
                    <label class="control-label col-md-3">Attachment</label>
                    <div class="col-md-6">
                        <div data-provides="fileupload" class="fileupload fileupload-new" id="partners_personal_history-licensure-attach-container">
                        <input type="hidden" name="partners_personal_history[licensure-attach][]" id="partners_personal_history-licensure-attach" value=""/>
                        <div class="input-group">
                            <span class="input-group-btn">
                            <span class="btn default btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" id="partners_personal_history-licensure-attach-fileupload" type="file" name="files[]">
                            </span>
                            <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                            
                            <ul class="padding-none margin-top-11">
                                <!-- <i class="fa fa-file fileupload-exists"></i>  -->
                                <span class="fileupload-preview">
                                    <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->

                                    <?php
                                    // $attach_file = array_key_exists('licensure-attach', $licensure) ? $licensure['licensure-attach'] : ""; 
                                    // if (!empty($attach_file)){
                                    //     $file = FCPATH . urldecode( $attach_file );
                                    //     if( file_exists( $file ) )
                                    //     {
                                    //         $f_info = get_file_info( $file );
                                    //         $f_type = filetype( $file );

                                    //         $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                    //         $f_type = finfo_file($finfo, $file);

                                    //         switch( $f_type )
                                    //         {
                                    //             case 'image/jpeg':
                                    //             $icon = 'fa-picture-o';
                                    //             break;
                                    //             case 'video/mp4':
                                    //             $icon = 'fa-film';
                                    //             break;
                                    //             case 'audio/mpeg':
                                    //             $icon = 'fa-volume-up';
                                    //             break;
                                    //             default:
                                    //             $icon = 'fa-file-text-o';
                                    //         }
                                    //         $filepath = base_url()."partners/download_file/".$details_data_id[1]['licensure-attach'];
                                    //         $file_view = base_url().$licensure['licensure-attach'];

                                    //         echo '<li class="padding-3" style="list-style:none;"><a href="'.$filepath.'">
                                    //         <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
                                    //         <span>'. basename($f_info['name']) .'</span>
                                    //         </a>
                                    //         </li>';
                                    //     }
                                    // }
                                    ?>
                                </span>
                            </ul>

                        </div>
                    </div>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>

<script>
    $(document).ready(function(){
        $('select.form-select').select2();

    });

    //attachments
    $('#partners_personal_history-licensure-attach-fileupload').fileupload({
        url: base_url + module.get('route') + '/single_upload',
        autoUpload: true,
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
            $('#partners_personal_history-licensure-attach').val(file.url);
            $('#partners_personal_history-licensure-attach-container .fileupload-preview').html(file.name);
            $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
        }
    }).bind('fileuploadfail', function (e, data) {
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#partners_personal_history-licensure-attach-container .fileupload-delete').click(function(){
        $('#partners_personal_history-licensure-attach').val('');
        $('#partners_personal_history-licensure-attach-container .fileupload-preview').html('');
        $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#partners_personal_history-licensure-attach').val() != "" )
    {
        $('#partners_personal_history-licensure-attach-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#partners_personal_history-licensure-attach-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }
</script>