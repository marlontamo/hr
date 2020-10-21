<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Attachments <small class="text-muted">edit</small></h4>
</div>
<form class="form-horizontal" id="form-13" partner_id="13" method="POST">
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="bl_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                        <div class="form-horizontal">
                            <div class="form-body">
                                <input type="hidden" class="form-control" maxlength="25" name="sequence" id="sequence" value="<?php echo $sequence; ?>" >
                                <div class="form-group">
                                    <label class="control-label col-md-4">Filename<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" maxlength="25" name="partners_personal_history[attachment-name]" id="partners_personal_history-attachment-name" value ="<?php echo array_key_exists('attachment-name', $details) ? $details['attachment-name'] : ""; ?>" placeholder="Enter File Name">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label col-md-4">Category<span class="required">*</span></label>
                                    <div class="col-md-7">
                                            <select  class="form-control select2me" data-placeholder="Select..." name="partners_personal_history[attachment-category]" id="partners_personal_history-attachment-category">
                                                <?php //$selected_category =  array_key_exists('attachment-category', $details) ? $details['attachment-category'] : ""; ?>
                                                <option value="My Account">My Account</option>
                                                <option value="Partners">Partners</option>
                                                <option value="Time Record">Time Record</option>
                                                <option value="Personnel">Personnel</option>
                                                <option value="Admin">Admin</option>
                                            </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-md-4">Upload<span class="required">*</span></label>
                                    <div class="col-md-7">                          
                                        <div data-provides="fileupload" class="fileupload fileupload-new" id="partners_personal_history-file-container">
                                            <input type="hidden" name="partners_personal_history[attachment-file]" id="partners_personal_history-file" value="<?php echo array_key_exists('attachment-file', $details) ? $details['attachment-file'] : ""; ?>"/>
                                            <div class="input-group">
                                                <span class="input-group-btn"><!-- 
                                                    <span class="uneditable-input"> -->
                                                    <!-- </span>
                                                </span> -->
                                                <span class="btn default btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                    <input type="file" id="partners_personal_history-file-fileupload" type="file" name="files[]">
                                                </span>
                                                <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                                                
                                                <ul class="padding-none margin-top-11">
                                                    <!-- <i class="fa fa-file fileupload-exists"></i>  -->
                                                    <span class="fileupload-preview">
                                                        <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->

                                                        <?php
                                                        $attachment_file = array_key_exists('attachment-file', $details) ? $details['attachment-file'] : ""; 
                                                        if (!empty($attachment_file)){
                                                            $file = FCPATH . urldecode( $attachment_file );
                                                            if( file_exists( $file ) )
                                                            {
                                                                $f_info = get_file_info( $file );
                                                                $f_type = filetype( $file );

                                                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                                $f_type = finfo_file($finfo, $file);

                                                                switch( $f_type )
                                                                {
                                                                    case 'image/jpeg':
                                                                    $icon = 'fa-picture-o';
                                                                    break;
                                                                    case 'video/mp4':
                                                                    $icon = 'fa-film';
                                                                    break;
                                                                    case 'audio/mpeg':
                                                                    $icon = 'fa-volume-up';
                                                                    break;
                                                                    default:
                                                                    $icon = 'fa-file-text-o';
                                                                }
                                                                $filepath = base_url()."partners_immediate/download_file/".$details_data_id['attachment-file'];
                                                                $file_view = base_url().$details['attachment-file'];

                                                                echo '<li class="padding-3" style="list-style:none;"><a href="'.$filepath.'">
                                                                <span class="padding-right-5"><i class="fa '. $icon .' text-muted padding-right-5"></i></span>
                                                                <span>'. basename($f_info['name']) .'</span>
                                                                </a>
                                                                </li>';
                                                            }
                                                        }
                                                        ?>
                                                    </span>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- END FORM--> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="button" class="btn green" onclick="save_partner( $(this).parents('form') )">Save</button>
    </div>
</form>

<script language="javascript">

//attachments
$('#partners_personal_history-file-fileupload').fileupload({
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
        $('#partners_personal_history-file').val(file.url);
        $('#partners_personal_history-file-container .fileupload-preview').html(file.name);
        $('#partners_personal_history-file-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#partners_personal_history-file-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }
}).bind('fileuploadfail', function (e, data) {
    $.unblockUI();
    notify('error', data.errorThrown);
});

$('#partners_personal_history-file-container .fileupload-delete').click(function(){
    $('#partners_personal_history-file').val('');
    $('#partners_personal_history-file-container .fileupload-preview').html('');
    $('#partners_personal_history-file-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
    $('#partners_personal_history-file-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#partners_personal_history-file').val() != "" )
{
    $('#partners_personal_history-file-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
    $('#partners_personal_history-file-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
</script>