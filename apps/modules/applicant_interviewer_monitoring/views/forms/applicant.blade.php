
<form class="rec-kiosk-form form-horizontal" id="form-1" partner_id="1" method="post">
    <div class="modal-body padding-bottom-0">
        <div class="">
            <div class="portlet">
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                        <div class="form-group">
                            <label class="control-label col-md-4">Hiring Type
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-7">
                                
                                <select  name= "recruitment_request[applicant_type]" class="form-control select2me" data-placeholder="Select..." id="recruitment_request-applicant_type">
                                    <option value="1">External</option>
                                    <option value="2">Internal</option>
                                </select>
                            
                            </div>
                        </div>
                        <div id="applicant_external">
                            <div class="form-group">
                                <label class="control-label col-md-4">Last Name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                    <input type="text" class="form-control" name="recruitment[lastname]" id="recruitment-lastname" value="" placeholder="Enter Last Name"/>
                                    <input type="hidden" class="form-control" name="record_id" id="record_id" value="" placeholder="Enter Last Name"/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">First Name
                                    <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                    <input type="text" class="form-control" name="recruitment[firstname]" id="recruitment-firstname" value="" placeholder="Enter First Name"/>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Middle Name
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                    <input type="text" class="form-control" name="recruitment[middlename]" id="recruitment-middlename" value="" placeholder="Enter Middle Name"/>
                                    </div>
                                    
                                </div>
                            </div>
                            


                            <div class="form-group">
                                <label class="control-label col-md-4">Mobile Phone<span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                        <i class="fa fa-mobile"></i>
                                    <input type="text" class="form-control" maxlength="16" name="recruitment_personal[mobile][]" id="recruitment_personal-mobile" placeholder="Enter Mobile Number" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Phone
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                        <i class="fa fa-phone"></i>
                                <input type="text" class="form-control" maxlength="16" name="recruitment_personal[phone][]" id="recruitment_personal[phone]" placeholder="Enter Telephone Number" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Email
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-icon">
                                        <i class="fa fa-envelope"></i>
                                    <input type="text" class="form-control" name="recruitment[email]" id="recruitment-email" value="" placeholder="Enter Email Address"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">How did you learn about HDI? 
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <select  class="form-control select2me" data-placeholder="Select..." name="recruitment_personal[how_hiring_heard]" id="recruitment_personal-how_hiring_heard">
                                    <option value="">Please Select</option>
                                    <option value="Ads">Ads</option>
                                    <option value="Jobstreet">Linkedin</option>
                                    <option value="Jobstreet">Jobstreet</option>
                                    <option value="Referral">Referral</option>
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4">Position Sought
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <select class="form-control select2me position_sought" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
                                    <option value="">Please Select</option>

                                        @if( sizeof( $mrf ) > 0 )
                                            @foreach( $mrf as $year => $mrfs )
                                                @foreach( $mrfs as $mrf )
                                                    <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} </option>
                                                @endforeach
                                            @endforeach
                                        @endif
                                </select>
                                <input type="hidden" class="form-control mrf_req" name="recruitment[request_id]" id="recruitment-request_id" value="" placeholder="Enter Position Sought"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-4">Upload Resume
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <div class="fileupload fileupload-new" data-provides="fileupload" id="recruitment_personal-resume-container">
                                    <!-- <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"> -->
                                        <?php 
                                            $filename = ''; 
                                            // if(strtolower($filename) == 'avatar.png'){
                                            //     $record['resume'] = '';
                                            //     $filename = '';
                                            // }
                                        ?>

                                        <!-- <img class= "resume-display"
                                            id="img-preview" 
                                            src="{{ base_url($record['resume']) }}" 
                                             style="width: 200px; height: 150px;" /> -->
                                        <input type="hidden" name="recruitment_personal[resume]" id="recruitment_personal-resume" value="">
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
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select File</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" name="files[]" class="default file" id="recruitment_personal-resume-fileupload" />
                                        </span>
                                        <a data-dismiss="fileupload" class="btn red fileupload-exists fileupload-delete"><i class="fa fa-trash-o"></i> Remove</a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div id="applicant_internal">
                            <div class="form-group">
                                <label class="control-label col-md-4">Position Sought
                                <span class="required">*</span>
                                </label>
                                <div class="col-md-7">
                                <select class="form-control select2me position_sought" data-placeholder="Select..." name="recruitment_personal[position_sought]" id="recruitment_personal-position_sought">
                                    <option value="">Please Select</option>

                                        @if( sizeof( $mrf2 ) > 0 )
                                            @foreach( $mrf2 as $year => $mrfs )
                                                @foreach( $mrfs as $mrf )
                                                    <option value="{{ $mrf->position }}" mrf_id="{{ $mrf->request_id }}"> {{ $mrf->position }} </option>
                                                @endforeach
                                            @endforeach
                                        @endif
                                </select>
                                <input type="hidden" class="form-control mrf_req" name="recruitment[request_id]" id="recruitment-request_id" value="" placeholder="Enter Position Sought"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Partner
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
                    <!-- END FORM--> 
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer margin-top-0">
        <button type="button" data-dismiss="modal" class="btn btn-default btn-sm">Close</button>
        <button type="button" data-loading-text="Loading..." class="demo-loading-btn btn btn-success btn-sm" onclick="save_applicant($(this).parents('form'))">Add Applicant</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('#applicant_internal').hide();
        $( "#recruitment_request-applicant_type" ).change(function() {
            if($(this).val() == 2){
                $('#applicant_external').hide();
                $('#applicant_internal').show();
            }else{
                $('#applicant_external').show();
                $('#applicant_internal').hide();
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
    });
    });
</script>