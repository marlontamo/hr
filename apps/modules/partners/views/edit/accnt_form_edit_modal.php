    <link href="<?=theme_path()?>plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
   <link type="text/css" rel="stylesheet" href="<?=theme_path()?>plugins/jquery-file-upload/css/jquery.fileupload-ui.css">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Accountabilities <small class="text-muted">edit</small></h4>
    </div>
    <form class="form-horizontal" id="form-12" partner_id="12" method="POST">
    <div class="modal-body padding-bottom-0">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet" id="bl_container">
                    <div class="portlet-body">
                        <!-- BEGIN FORM-->
                            <div action="#" class="form-horizontal">
                                <div class="form-body">
                                            <input type="hidden" class="form-control" maxlength="25" name="sequence" id="sequence" value="<?php echo $sequence; ?>" >
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Item Name<span class="required">*</span></label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-name]" id="partners_personal_history-accountabilities-name" value="<?php echo array_key_exists('accountabilities-name', $details) ? $details['accountabilities-name'] : ""; ?>" placeholder="Enter Item Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Item Code</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-code]" id="partners_personal_history-accountabilities-code" value="<?php echo array_key_exists('accountabilities-code', $details) ? $details['accountabilities-code'] : ""; ?>" placeholder="Enter Item Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Quantity</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" maxlength="25" name="partners_personal_history[accountabilities-quantity]" id="partners_personal_history-accountabilities-quantity" value="<?php echo array_key_exists('accountabilities-quantity', $details) ? $details['accountabilities-quantity'] : ""; ?>" placeholder="Enter Item Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Date Issued </label>
                                        <div class="col-md-7">
                                        <?php 
                                            $month_issued = array_key_exists('accountabilities-month-issued', $details) ? $details['accountabilities-month-issued'] : ""; 
                                            $day_issued = array_key_exists('accountabilities-day-issued', $details) ? $details['accountabilities-day-issued']."," : ""; 
                                            $year_issued = array_key_exists('accountabilities-year-issued', $details) ? $details['accountabilities-year-issued'] : "";
                                            $date_issued = $month_issued." ".$day_issued." ".$year_issued;                                     
                                        ?>
                                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" class="form-control" name="partners_personal_history[accountabilities-date-issued]" id="partners_personal_history-accountabilities-date-issued" value="<?php echo array_key_exists('accountabilities-date-issued', $details) ? $details['accountabilities-date-issued'] : ''; ?>" placeholder="Enter Date Issued" >
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Date Returned</label>
                                        <div class="col-md-7">
                                        <?php 
                                            $month_returned = array_key_exists('accountabilities-month-returned', $details) ? $details['accountabilities-month-returned'] : ""; 
                                            $day_returned = array_key_exists('accountabilities-day-returned', $details) ? $details['accountabilities-day-returned']."," : ""; 
                                            $year_returned = array_key_exists('accountabilities-year-returned', $details) ? $details['accountabilities-year-returned'] : ""; 
                                            $date_returned = $month_returned." ".$day_returned." ".$year_returned; 
                                        ?>
                                            <div class="input-group input-medium date date-picker" data-date-format="MM dd, yyyy">
                                            <input type="text" class="form-control" name="partners_personal_history[accountabilities-date-returned]" id="partners_personal_history-accountabilities-date-returned" value="<?php echo array_key_exists('accountabilities-date-returned', $details) ? $details['accountabilities-date-returned'] : ''; ?>" placeholder="Enter Date Returned" >
                                                <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Attachment</label>
                                        <div class="col-md-7">
                                            <div data-provides="fileupload" class="fileupload fileupload-new" id="partners_personal_history-accountabilities-attachment-container">
                                            <input type="hidden" name="partners_personal_history[accountabilities-attachment]" id="partners_personal_history-accountabilities-attachment" value="<?php echo array_key_exists('accountabilities-attachment', $details) ? $details['accountabilities-attachment'] : ""; ?>"/>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                <span class="btn default btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select file</span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                    <input type="file" id="partners_personal_history-accountabilities-attachment-fileupload" type="file" name="files[]">
                                                </span>
                                                <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                                                
                                                <ul class="padding-none margin-top-11">
                                                    <!-- <i class="fa fa-file fileupload-exists"></i>  -->
                                                    <span class="fileupload-preview">
                                                        <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->

                                                        <?php
                                                        $attachment_file = array_key_exists('accountabilities-attachment', $details) ? $details['accountabilities-attachment'] : ""; 
                                                        if (!empty($attachment_file)){
                                                            $file = FCPATH . urldecode( $attachment_file );
                                                            if( file_exists( $file ) )
                                                            {
                                                                $f_info = get_file_info( $file );
                                                                $f_type = filetype( $file );

/*                                                                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                                                $f_type = finfo_file($finfo, $file);*/

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
                                                                $filepath = base_url()."partners/download_file/".$details_data_id['accountabilities-attachment'];
                                                                $file_view = base_url().$details['accountabilities-attachment'];

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

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea rows="3" class="form-control" name="partners_personal_history[accountabilities-remarks]" id="partners_personal_history-accountabilities-remarks" ><?php echo array_key_exists('accountabilities-remarks', $details) ? $details['accountabilities-remarks'] : ""; ?></textarea>
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
        <!-- <button type="button" class="btn green">Save</button> -->
        <button type="button" class="btn green" onclick="save_partner( $(this).parents('form') )">Save</button>
    </div>
    </form>

<script>
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });
            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

   //attachments
$('#partners_personal_history-accountabilities-attachment-fileupload').fileupload({
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
        $('#partners_personal_history-accountabilities-attachment').val(file.url);
        $('#partners_personal_history-accountabilities-attachment-container .fileupload-preview').html(file.name);
        $('#partners_personal_history-accountabilities-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#partners_personal_history-accountabilities-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }
}).bind('fileuploadfail', function (e, data) {
    $.unblockUI();
    notify('error', data.errorThrown);
});

$('#partners_personal_history-accountabilities-attachment-container .fileupload-delete').click(function(){
    $('#partners_personal_history-accountabilities-attachment').val('');
    $('#partners_personal_history-accountabilities-attachment-container .fileupload-preview').html('');
    $('#partners_personal_history-accountabilities-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
    $('#partners_personal_history-accountabilities-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
});

if( $('#partners_personal_history-accountabilities-attachment').val() != "" )
{
    $('#partners_personal_history-accountabilities-attachment-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
    $('#partners_personal_history-accountabilities-attachment-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
}
</script>

