<tr>
	<td>
		<input type="hidden" name="performance_appraisal_reminder[reminder_id][]" id="performance_appraisal_reminder-reminder_id" value=''/>
		<select  class="form-control select2me input-sm" data-placeholder="Select..." name="performance_appraisal_reminder[notification_id][]" id="performance_appraisal_reminder-notification_id">
		<?php
			foreach($notifications as $index => $notification)
			{
		?>
				<option value="<?php echo $notification['notification_id'] ?>" 
					<?php if($form_value==$notification['notification_id']) echo "selected";?> >
					<?php echo $notification['notification'] ?>
				</option>
		<?php
			}
		?>
		</select>
	</td>
	<td>
		<?php
			$date = "";
			if( !empty($start_date) )
			{
				switch( $form_value )
				{
					case 1://before start
					case 4://one day before
						$date = date('F d, Y', strtotime('-1 day', strtotime($start_date) ));
						break;
					case 2://on start
						$date = $start_date;
						break;
					case 3://end
						$date = $start_date;
						break;
				}
			}
		?>
		<div class="input-group date date-picker" data-date-format="MM dd, yyyy">
			<input type="text" value="<?php echo $date?>" class="form-control reminder_date" name="performance_appraisal_reminder[date][]" id="performance_appraisal_reminder-date" placeholder="Enter Date" readonly>
			<span class="input-group-btn">
				<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
			</span>
		</div>
	</td>
	<td>
		<div class="make-switch" data-on-label="&nbsp;<?=lang('performance_appraisal.on')?>&nbsp;" data-off-label="&nbsp;<?=lang('performance_appraisal.off')?>&nbsp;"  data-on="success" data-off="warning">
			<input type="checkbox" value="1" checked="checked" name="performance_appraisal_reminder[status_id][temp][]" id="performance_appraisal_reminder-status_id-temp" class="dontserializeme toggle reminder_status"/>
			<input type="hidden" name="performance_appraisal_reminder[status_id][]" id="performance_appraisal_reminder-status_id" value="1"/>
		</div>
	</td>
	<td>
		<div data-provides="fileupload" class="fileupload fileupload-new" id="performance_appraisal_reminder-file-container">
	        <input class="reminder_attach-file" type="hidden" name="performance_appraisal_reminder[file][]" id="performance_appraisal_reminder-file" />
	        <div class="input-group">
	            <span class="input-group-btn"><!-- 
	                <span class="uneditable-input"> -->
	                <!-- </span>
	            </span> -->
	            <span class="btn default btn-file add_file">
	                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> <?=lang('performance_appraisal.select_file')?></span>
	                <span class="fileupload-exists small"><i class="fa fa-undo"></i> Change</span>
	                <input type="file" class="reminder_file" id="performance_appraisal_reminder-file-fileupload" type="file" name="files[]">
	            </span>
	            <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete small"><i class="fa fa-trash-o"></i> <?=lang('common.remove')?></a>
	            
	            <ul class="padding-none margin-top-11">
	                <!-- <i class="fa fa-file fileupload-exists"></i>  -->
	                <span class="fileupload-preview">
	                    <!-- @if( isset($f_info['name'] ) ) {{ basename($f_info['name']) }} @endif -->

	                    <?php
	                    // $attachment_file = array_key_exists('attachment-file', $details) ? $details['attachment-file'] : ""; 
	                    $attachment_file = ""; 
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
	                            $filepath = base_url()."partners/download_file/".$details_data_id['attachment-file'];
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
	</td>
	<td>
		<a class="btn btn-xs text-muted delete_row" ><i class="fa fa-trash-o"></i> <?=lang('common.delete')?></a>
	</td>
</tr>
<script>
$(document).ready(function(){
	$('select.select2me').select2();
	$('.make-switch').not(".has-switch")['bootstrapSwitch']();

	$('.reminder_status').change(function(){
	    if( $(this).is(':checked') ){
	    	$(this).parent().next().val(1);
	    }
	    else{
	    	$(this).parent().next().val(0);
	    }
	});

    if (jQuery().datepicker) {
        $('.reminder_date').parent('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
        $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
    }

	//attachments
	$('.reminder_file').fileupload({
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
		    $(this).parent().parent().parent().parent().children('input:hidden:first').val(file.url);
		    $(this).parent().parent().children('ul').children('span').html(file.name);
		    $(this).parent().children('span.fileupload-new').css('display', 'none');
		    $(this).parent().children('span.fileupload-exists').css('display', 'inline-block');
		    $(this).parent().parent().children('a.fileupload-exists').css('display', 'inline-block');
		}
	}).bind('fileuploadfail', function (e, data) {
	    $.unblockUI();
	    notify('error', data.errorThrown);
	});

	$('.fileupload-delete').click(function(){
	    $(this).parent().parent().parent().children('input:hidden:first').val('');
	    $(this).parent().children('ul').children('span.fileupload-preview').html('');
	    $(this).parent().children('span.add_file').children('span.fileupload-new').css('display', 'inline-block');
	    $(this).parent().children('span.add_file').children('span.fileupload-exists').css('display', 'none');
	    $(this).css('display', 'none');
	});

});
</script>