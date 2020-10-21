   <link href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css"/>
   <link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/jquery-file-upload/css/jquery.fileupload-ui.css">
    <form>
        <div class="modal-body">
            <div class="row">
                <div class="portlet">
                    <div class="portlet-body">
                    
                            <div class="border-bottom padding-5">
                                <h5>Report</h5>
                                <div class="clearfix padding-bottom-15" id="feedback_box">
                                    <select name="msg_code" id="msg_code" class="form-control select2me">
                                        <option value="feedback">Suggestions/Feedback</option>
                                        <option value="technical_report">Technical/System Report</option>
                                    </select>
                                </div>
                            </div>
                            <div class="padding-5">
                                <h5>Tell us</h5>
                                <div class="clearfix padding-bottom-15" id="report_box">
                                    <textarea class="form-control margin-bottom-10" rows="2" name="feedback" id="feedback" placeholder="Briefly explain your experience."></textarea>
                                </div>
                            </div>
                            <div class="padding-5 padding-bottom-15">
                               <input type="checkbox" value="1" class="toggle dontserializeme" id="include_screenshot" > Include a screenshot with my report
                               <div id="screen"></div>
                                <input type="hidden" name="img_val" id="img_val" value="" class="dontserializeme" />
                            </div>
                            <div class="padding-5">
                                 <p class="text-muted small">Upload Screenshot</p>
                                     
                                    <div class="fileupload fileupload-new" data-provides="fileupload" id="upload-photo-container">                            
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <input type="hidden" name="upload-photo" id="upload-photo" value="">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i> 
                                                    <span class="fileupload-preview"></span>
                                                </span>
                                            </span>
                                            <div id="photo-container">
                                                <span class="btn default btn-file">
                                                    <span class="fileupload-new"><i class="fa fa-paper-clip"></i>Upload</span>
                                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> </span>
                                                    <input type="file" name="files[]" class="default file" id="upload-photo-fileupload" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                         
                            </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>    
        <div class="modal-footer margin-top-0">
            <button class="btn btn-sm green" id="save_feedback" onclick="save_record( $(this).parents('form') )">Send Feedback</button> 
            <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        </div>
    </form>


<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js"></script>
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
<script type="text/javascript">
    $('.modal-backdrop').attr('data-html2canvas-ignore', true);
    $('#goto_feedback_box').click(function () { 
        $('#feedback_box').show();
    });
    $('#close_feedback_box').click(function () { 
        $('#feedback_box').hide();
    });

    $('#goto_report_box').click(function () { 
        $('#report_box').show();
    });

    $('#close_report_box').click(function () { 
        $('#report_box').hide();
    });

    $("#include_screenshot").on("click", function(){
        var elem = $(this);
        if(elem.is(':checked')){
           capture();
        }else{
            $('canvas').hide();
        }
    });

    $('#upload-photo-fileupload').fileupload({ 
        url: base_url + 'single_upload_support_box',
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
            $('#upload-photo-container .fileupload-preview').html(file.name);
            $('#photo-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#photo-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
            $('#upload-photo').val(file.url);
        }

    }).bind('fileuploadfail', function (e, data) { 
        $.unblockUI();
        notify('error', data.errorThrown);
    });

function save_record( form, action, callback )
{
    
    form.submit( function(e){ e.preventDefault(); } );
    $.blockUI({ message: saving_message(),
        onBlock: function(){
            form.submit( function(e){ e.preventDefault(); } );

            var attachment = "";
            if($("#include_screenshot").is(':checked')){
                attachment = '&canvas_attachment='+$('#img_val').val();
            }
            
            var data = form.find(":not('.dontserializeme')").serialize();
            $.ajax({
                url: base_url + 'save_feedback',
                type:"POST",
                data: data+attachment,
                dataType: "json",
                async: false,
                success: function ( response ) {
                    handle_ajax_message( response.message );

                    if( response.saved )
                    {
                         $('.modal-container').modal('hide');
                        if( response.action == 'insert' )
                            $('#record_id').val( response.record_id );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                    }
                }
            });
        },
        baseZ: 300000000
    });
    $.unblockUI();
}

/*    function save(type, message, code, image)
    {
        var data = "msg_code="+code+"&message="+message;

        if($("#include_screenshot").is(':checked')){
            data = "msg_code="+code+"&message="+message+'&image='+image;
        }

        $.ajax({
            url: base_url + type,
            type:"POST",
            dataType: "json",
            data: data,
            async: false,
            success: function ( response ) {
                handle_ajax_message( response.message );

                if( response.saved )
                    $('.modal-container').modal('hide');
            }
        });
    }
*/
    function capture() {

        html2canvas(document.body, {
            onrendered: function(canvas) {
                $('#screen').html(canvas);
                $('canvas').css('width', '100%');
                $('canvas').css('height', '100%');
                $('#img_val').val(canvas.toDataURL("image/png"));
            }
        });
    }

</script>