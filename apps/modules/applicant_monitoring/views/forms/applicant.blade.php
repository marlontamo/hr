
<form class="rec-kiosk-form form-horizontal" id="form-1" partner_id="1" method="post">
    <div class="modal-body padding-bottom-0">
        <div class="">
            <div class="portlet">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                        <div class="form-group">
                            <label class="control-label col-md-4">{{ lang('applicant_monitoring.hiring_type') }}
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-list-ul"></i>
                                            </span>    
                                    <select  name= "recruitment_request[applicant_type]" class="form-control select2me" data-placeholder="Select..." id="recruitment_request-applicant_type">
                                        <option value="1">{{ lang('applicant_monitoring.external') }}</option>
                                        <option value="2">{{ lang('applicant_monitoring.internal') }}</option>
                                        <option value="3">{{ lang('applicant_monitoring.rehire') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="applicant_external">
                            <div class="form-group">
                                    <label class="control-label col-md-4">{{ lang('applicant_monitoring.pos_sought') }}<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select class="form-control select2me position_sought" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
                                            <option value="">Please Select</option>
                                                @if( sizeof( $mrf ) > 0 )
                                                    @foreach( $mrf as $year => $mrfs )
                                                        @foreach( $mrfs as $mrf )
                                                            <option value="{{ $mrf->position_sought }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position_sought }} ({{ $mrf->document_no }})</option>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                        </select>
                                        <input type="hidden" class="form-control mrf_req" name="recruitment[request_id]" id="recruitment-request_id" value="" placeholder="Enter Position Sought"/>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="control-label col-md-4">Applicant<span class="required">*</span></label>
                                    <div class="col-md-7">
                                        <select class="form-control select2me applicants" data-placeholder="Select..." name="recruitment[recruit_id]" id="recruitment-recruit_id">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                            </div>
                            @if(in_array('sourcing_tools', $recruitment_keys))
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ lang('applicant_monitoring.sourcing_tools') }}
                                </label>
                                <div class="col-md-7">
                                    <?php
                                    $db->select('sourcing_tool_id,sourcing_tool');
                                    $db->order_by('sourcing_tool', '0');
                                    $db->where('deleted', '0');
                                    $options = $db->get('recruitment_sourcing_tools');
                                    $recruitment_sourcing_tools_id_options = array('' => 'Please Select...');
                                    foreach($options->result() as $option)
                                    {
                                        $recruitment_sourcing_tools_id_options[$option->sourcing_tool_id] = $option->sourcing_tool;
                                    } 
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-list-ul"></i>
                                        </span>
                                        {{ form_dropdown('recruitment_personal[sourcing_tools]',$recruitment_sourcing_tools_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="recruitment_personal-sourcing_tools"') }}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(in_array('sourcing_free_sites', $recruitment_keys))
                            <div id="free_sites">
                                <div class="form-group">
                                    <label class="control-label col-md-4">{{ lang('applicant_monitoring.free_sites') }}
                                    </label>
                                    <div class="col-md-7">
                                        <?php
                                        $db->select('sourcing_free_sites_id,sourcing_free_sites');
                                        $db->order_by('sourcing_free_sites', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('recruitment_sourcing_free_sites');
                                        $recruitment_sourcing_free_sites_id_options = array('' => 'Please Select...');
                                        foreach($options->result() as $option)
                                        {
                                            $recruitment_sourcing_free_sites_id_options[$option->sourcing_free_sites_id] = $option->sourcing_free_sites;
                                        } 
                                        ?>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                            <i class="fa fa-list-ul"></i>
                                            </span>
                                            {{ form_dropdown('recruitment_personal[sourcing_free_sites]',$recruitment_sourcing_free_sites_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="recruitment_personal-sourcing_free_sites"') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div id="applicant_internal">
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ lang('applicant_monitoring.pos_sought') }}
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <select class="form-control select2me position_sought" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought2">
                                    <option value="">Please Select</option>
                                        @if( sizeof( $mrf2 ) > 0 )
                                            @foreach( $mrf2 as $year => $mrfs )
                                                @foreach( $mrfs as $mrf )
                                                    <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} ({{ $mrf->document_no }})</option>
                                                @endforeach
                                            @endforeach
                                        @endif
                                </select>
                                <input type="hidden" class="form-control mrf_req" name="recruitment[request_id]" id="recruitment-request_id2" value="" placeholder="Enter Position Sought"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ lang('applicant_monitoring.partner') }}
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <?php
                                    $db->select('user_id,full_name');
                                    $db->order_by('full_name', '0');
                                    $db->where('deleted', '0');
                                    $options = $db->get('users');
                                    $recruitment_user_id_options = array('' => 'Select...');
                                    foreach($options->result() as $option)
                                    {
                                        $recruitment_user_id_options[$option->user_id] = $option->full_name;
                                    } 
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-list-ul"></i>
                                        </span>
                                        {{ form_dropdown('recruitment_request[user_id]',$recruitment_user_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-user_id"') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="applicant_internal_resign">
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ lang('applicant_monitoring.pos_sought') }}
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <select class="form-control select2me position_sought" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought3">
                                    <option value="">Please Select</option>
                                        @if( sizeof( $mrf2 ) > 0 )
                                            @foreach( $mrf2 as $year => $mrfs )
                                                @foreach( $mrfs as $mrf )
                                                    <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} ({{ $mrf->document_no }})</option>
                                                @endforeach
                                            @endforeach
                                        @endif
                                </select>
                                <input type="hidden" class="form-control mrf_req" name="recruitment[request_id]" id="recruitment-request_id3" value="" placeholder="Enter Position Sought"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ lang('applicant_monitoring.partner') }}
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <?php
                                    $db->select('user_id,full_name');
                                    $db->order_by('full_name', '0');
                                    $db->where('deleted', '0');
                                    $db->where('active', '0');
                                    $options = $db->get('users');
                                    $recruitment_user_id_options = array('' => 'Select...');
                                    foreach($options->result() as $option)
                                    {
                                        $recruitment_user_id_options[$option->user_id] = $option->full_name;
                                    } 
                                    ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-list-ul"></i>
                                        </span>
                                        {{ form_dropdown('recruitment_request[user_id]',$recruitment_user_id_options, '', 'class="form-control select2me" data-placeholder="Select..." id="recruitment_request-user_id"') }}
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    <!-- END FORM--> 
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">{{ lang('common.close') }}</button>
        <button type="button" data-loading-text="Loading..." class="demo-loading-btn btn btn-success btn-sm" onclick="save_applicant($(this).parents('form'))">{{ lang('applicant_monitoring.add_applicant') }}</button>
    </div>
</form>

<script>
$(document).ready(function(){
    $('#applicant_internal').hide();
    $('#applicant_internal_resign').hide();
    $( "#recruitment_request-applicant_type" ).change(function() {
        if($(this).val() == 2){
            $('#applicant_external *').prop('disabled', true);
            $('#applicant_internal_resign *').prop('disabled', true);
            $('#applicant_internal *').prop('disabled', false);

            $('#applicant_external').hide();
            $('#applicant_internal_resign').hide();
            $('#applicant_internal').show();
        }else if($(this).val() == 3){
            $('#applicant_external *').prop('disabled', true);
            $('#applicant_internal *').prop('disabled', true);
            $('#applicant_internal_resign *').prop('disabled', false);

            $('#applicant_external').hide();
            $('#applicant_internal').hide();
            $('#applicant_internal_resign').show();
        }else{
            $('#applicant_internal *').prop('disabled', true);
            $('#applicant_internal_resign *').prop('disabled', true);
            $('#applicant_external *').prop('disabled', false);

            $('#applicant_external').show();
            $('#applicant_internal').hide();
            $('#applicant_internal_resign').hide();
        }
    });

    $('select.select2me').select2();

    $('#recruitment_personal-resume-fileupload').fileupload({ 
        url: base_url + module.get('route') + '/single_upload',
        autoUpload: true,
        contentType: false,
    }).bind('fileuploadadd', function (e, data) {
        $.blockUI({ message: '<div>Attaching file, please wait...</div><img src="'+base_url+'assets/img/ajax-loading.gif" />' });
    }).bind('fileuploaddone', function (e, data) { 

        $.unblockUI();
        var file = data.result.file;
        if(file.error != undefined && file.error != "")
        {
            notify('error', file.error);
        }
        else{
            $('#recruitment_personal-resume-container .fileupload-preview').html(file.name);

            $('#resume-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
            $('#resume-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
            $('#recruitment_personal-resume').val(file.url);
        }
    }).bind('fileuploadfail', function (e, data) { 
        $.unblockUI();
        notify('error', data.errorThrown);
    });

    $('#resume-container .fileupload-delete').click(function(){
        $('#recruitment_personal-resume').val('');
        $('#recruitment_personal-resume-container .fileupload-preview').html('');
        // $("#img-preview").attr('src', base_url + 'assets/img/avatar.png');
        $('#resume-container .fileupload-new').each(function(){ $(this).css('display', 'inline-block') });
        $('#resume-container .fileupload-exists').each(function(){ $(this).css('display', 'none') });
    });

    if( $('#recruitment_personal-resume').val() != "" )
    {
        $('#recruitment_personal-resume-container .fileupload-new').each(function(){ $(this).css('display', 'none') });
        $('#recruitment_personal-resume-container .fileupload-exists').each(function(){ $(this).css('display', 'inline-block') });
    }

    if( $('#recruitment-request_id').val() != "" )
    {
        $('#recruitment_personal-position_sought option[mrf_id='+$('#recruitment-request_id').val()+']').attr('selected', 'selected');  
    }
    $('#recruitment_personal-position_sought').change(function(){
        var mrf_id = $('#recruitment_personal-position_sought option:selected').attr('mrf_id');
        $('#recruitment-request_id').val( mrf_id );
        $('.mrf_req').val( mrf_id );
        $('.position_sought').val( $(this).val() );

        if ($(this).val() == ''){
            $('#recruitment-recruit_id').html('');
            return true;
        }

        $.ajax({
            url: base_url + module.get('route') + '/get_applicants',
            type:"POST",
            data: {'position':$(this).val()},
            dataType: "json",
            async: false,
            success: function ( response ) {
                $('#recruitment-recruit_id').html(response.applicants);
            }
        });

    });

   /* $('#recruitment-recruit_id').change(function() {
        $.ajax({
            url: base_url + module.get('route') + '/get_applicant_details',
            type:"POST",
            data: {'recruit_id':$(this).val()},
            dataType: "json",
            async: false,
            success: function ( response ) {
                // console.log(response.personal)
               // $('#recruitment-recruit_id').html(response.applicants);
            }
        });
        
    });*/

    if( $('#recruitment-request_id2').val() != "" )
    {
        $('#recruitment_personal-position_sought2 option[mrf_id='+$('#recruitment-request_id2').val()+']').attr('selected', 'selected');  
    }
    $('#recruitment_personal-position_sought2').change(function(){
        var mrf_id = $('#recruitment_personal-position_sought2 option:selected').attr('mrf_id');
        $('#recruitment-request_id2').val( mrf_id );
        $('.mrf_req').val( mrf_id );
        $('.position_sought').val( $(this).val() );
    });

    if( $('#recruitment-request_id3').val() != "" )
    {
        $('#recruitment_personal-position_sought3 option[mrf_id='+$('#recruitment-request_id3').val()+']').attr('selected', 'selected');  
    }
    $('#recruitment_personal-position_sought3').change(function(){
        var mrf_id = $('#recruitment_personal-position_sought3 option:selected').attr('mrf_id');
        $('#recruitment-request_id3').val( mrf_id );
        $('.mrf_req').val( mrf_id );
        $('.position_sought').val( $(this).val() );
    });

    $('#free_sites').hide();
    $('#recruitment_personal-how_hiring_heard').change(function(){
        if($(this).val() == 4) {
            $('#free_sites').show();
        } else {
            $('#free_sites').hide();
        }
    });

});
</script>
