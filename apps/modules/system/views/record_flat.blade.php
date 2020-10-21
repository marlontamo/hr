@extends('layouts.master')

@section('page_styles')
	@parent
	
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/select2/select2_metro.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css"/>
	<link rel="stylesheet" type="text/css" href="{{ theme_path() }}plugins/bootstrap-switch/static/stylesheets/bootstrap-switch-metro.css"/>
@stop

@section('page_content')
	@parent

<div class="row">

    <div class="col-md-12">

        <div class="tab-content">

            <div class="tab-pane active" id="tab_0">

                <div class="portlet" style="cursor:pointer">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('system_settings.general_settings') }}</div>
                        <div class="tools ">
                            <a href="javascript:;" class="expand"></a>
                        </div>
    					<!-- <div class="tools">
    						<i class="fa fa-angle-down"></i>
    					</div>
     -->            </div>
                    <p class="small">{{ lang('system_settings.p_general_settings') }}</p>

                    <div class="portlet-body form" style="display:none;">
                        <!-- BEGIN FORM-->
                        <form action="#" id="config-general-settings" class="form-horizontal form" name="config-general-settings" method="post" enctype="multipart/form-data">

                            <div class="form-body">

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ $sys_config['application_title'][0] }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="application_title" value="{{ $sys_config['application_title'][1] }}" placeholder="Emplopad">
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.app_title_note') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ $sys_config['author'][0] }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="author" value="{{ $sys_config['author'][1] }}" placeholder="Teemworx">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ $sys_config['footer'][0] }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="footer" value="{{ $sys_config['footer'][1] }}" placeholder="&copy; $year $title.">
                                    </div>
                                </div>

                                <div class="form-group last">
                                    <label class="col-md-3 control-label">{{ $sys_config['copyright_details'][0] }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="copyright_details" value="{{ $sys_config['copyright_details'][1] }}" placeholder="&copy; $year $author">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ $sys_config['use_logo'][0] }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="use_logo" value="0" />
                                            <input type="checkbox" {{ $sys_config['use_logo'][1] == '1' ? 'checked': '' }} name="use_logo" class="toggle" />
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.app_title_note2') }} </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ $sys_config['logo'][0] }}
                                    @if( !empty($sys_config['logo']['desc']) )
                                        &nbsp;{{ $sys_config['logo']['desc'] }}
                                    @endif 
                                    </label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload" id="login_logo-photo-container">
                                            <div class="fileupload-new thumbnail" style="height: 150px;">
                                                <img id="logo-img-preview" style="height: 150px;" src="{{ base_url() . $sys_config['logo'][1] }}" alt="{{ $sys_config['application_title'][1] }}" />
                                                <input type="hidden" name="logo" id="image_filename" value="{{ $sys_config['logo'][1] }}">
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 150px; line-height: 20px;"></div>
                                            <span class="help-block small">
                                                {{ lang('system_settings.login_lockscreen_note') }}
                                            </span>
                                            <div id="logo-photo-container">
                                                <span class="btn default btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('system_settings.select_image') }}</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('system_settings.change') }}</span>
                                                <input type="file" name="files[]" class="default file" id="config-general-logo" />
                                                </span>
                                                <a href="#" class="btn red fileupload-exists fileupload-delete" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> {{ lang('system_settings.remove') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ $sys_config['header_logo'][0] }}
                                    @if( !empty($sys_config['header_logo']['desc']) )
                                        &nbsp;{{ $sys_config['header_logo']['desc'] }}
                                    @endif 
                                    </label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload" id="headerlogo-photo-container">
                                            <div class="fileupload-new thumbnail" style="height: 40px;">
                                                <img id="header_logo-img-preview" style="height: 40px;" src="{{ base_url() . $sys_config['header_logo'][1] }}" alt="{{ $sys_config['application_title'][1] }}" />
                                                <input type="hidden" name="header_logo" id="header_logo-image_filename" value="{{ $sys_config['header_logo'][1] }}">
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 30px; line-height: 20px;"></div>
                                            <span class="help-block small">
                                                {{ lang('system_settings.page_header_note') }}
                                            </span>
                                            <div id="header_logo-photo-container">
                                                <span class="btn default btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('system_settings.select_image') }}</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('system_settings.change') }}</span>
                                                <input type="file" name="files[]" class="default file" id="config-general-header_logo" />
                                                </span>
                                                <a href="#" class="btn red fileupload-exists fileupload-delete" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> {{ lang('system_settings.remove') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ $sys_config['print_logo'][0] }}
                                    @if( !empty($sys_config['print_logo']['desc']) )
                                        &nbsp;{{ $sys_config['print_logo']['desc'] }}
                                    @endif 
                                    </label>
                                    <div class="col-md-9">
                                        <div class="fileupload fileupload-new" data-provides="fileupload" id="printlogo-photo-container">
                                            <div class="fileupload-new thumbnail" style="height: 100px;">
                                                <img id="print_logo-img-preview" style="height: 100px;" src="{{ base_url() . $sys_config['print_logo'][1] }}" alt="{{ $sys_config['application_title'][1] }}" />
                                                <input type="hidden" name="print_logo" id="print_logo-image_filename" value="{{ $sys_config['print_logo'][1] }}">
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 100px; line-height: 20px;"></div>
                                            <span class="help-block small">
                                                {{ lang('system_settings.print_logo_email_note') }}
                                            </span>
                                            <div id="print_logo-photo-container">
                                                <span class="btn default btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> {{ lang('system_settings.select_image') }}</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> {{ lang('system_settings.change') }}</span>
                                                <input type="file" name="files[]" class="default file" id="config-general-print_logo" />
                                                </span>
                                                <a href="#" class="btn red fileupload-exists fileupload-delete" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> {{ lang('system_settings.remove') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.login_bg_image') }}
                                    @if( !empty($sys_config['bg_image']['desc']) )
                                        &nbsp;{{ $sys_config['bg_image']['desc'] }}
                                    @endif 
                                    </label>
                                    <div class="col-md-9">
                                        <div data-provides="fileupload" class="fileupload fileupload-new" id="bg_image-upload_id-container">
                                            <input type="hidden" name="bg_image[upload_id]" id="bg_image-upload_id" />
                                            <span class="btn btn-primary btn-sm btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 
                                                <i class="fa fa-plus" type="file"></i>
                                                <span>Add Images...</span>
                                                </span>
                                                <input type="file" id="bg_image-upload_id-fileupload" type="file" name="files[]" multiple="">

                                            </span>
                                            <span class="help-block small">
                                                {{ lang('system_settings.bg_image_note') }}
                                            </span>
                                            <ul class="padding-none margin-top-10">
                                            <?php 

                                            $upload_ids = $db->get_where('config', array('key' => 'bg_image', 'deleted' => 0))->result_array();
                                           
                                            foreach( $upload_ids as $upload_id )
                                            {
                                                $upload = $db->get_where('config', array('config_id' => $upload_id['config_id']))->row();

                                                
                                                echo '<li class="padding-3 fileupload-delete-'.$upload_id['config_id'].'" style="list-style:none;">
                                                        <div class="thumbnail" style="height: 100px;">
                                                            <img class="padding-right-5 style="height: 100px;" src="'. base_url().$upload_id['value'] .'" alt="Loading...">
                                                            <a style="float: none; margin-top: -10px;" data-dismiss="fileupload" class="close fileupload-delete" upload_id="'.$upload_id['config_id'].'" href="javascript:void(0)"></a>
                                                        </div>
                                                    </li>';
                                                
                                            }

                                            ?>
                                                   
                                            </ul>
                                        </div> 
                                    </div>
                                    <!-- <input type="file" name="favicon" class="default file" id="config-general-favicon" /> -->
                                </div>

                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="config_group_id" value="{{ $sys_config['config_group_id'][1] }}">
                                    <button 
                                        type="submit" 
                                        class="btn green submit" 
                                        id="submit-general-settings" 
                                        name="submit-general-settings"
                                        onclick="save_record( $(this).closest('form'), ''); return false;">
                                        <i class="fa fa-check"></i> {{ lang('system_settings.submit') }}
                                    </button>
                                    <button type="button" class="btn default">{{ lang('system_settings.cancel') }}</button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>

                <div class="portlet" style="cursor:pointer">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('system_settings.email_settings') }}</div>
                        <div class="tools">
                            <a href="javascript:;" class="expand"></a>
                        </div>
                    </div>
                    <p class="small">{{ lang('system_settings.email_settings_note') }}</p>

                    <div class="portlet-body form" style="display:none;">
                        <!-- BEGIN FORM-->
                        <form action="#" id="config-email-settings" class="form-horizontal form" name="config-email-settings">
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.email_server') }}</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
    											<i class="fa fa-cloud"></i>
    										</span>
                                            <select class="form-control selectM3" name="protocol" data-placeholder="Select...">
                                                <option value="mail" {{ $mail_config[ 'protocol'][1]=='mail' ? 'selected': '' }}>{{ lang('system_settings.php_mail_func') }}</option>
                                                <option value="sendmail" {{ $mail_config[ 'protocol'][1]=='sendmail' ? 'selected': '' }}>{{ lang('system_settings.send_mail') }}</option>
                                                <option value="smtp" {{ $mail_config[ 'protocol'][1]=='smtp' ? 'selected': '' }}>{{ lang('system_settings.smtp') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.email_type') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning" data-on-label="&nbsp;HTML&nbsp;" data-off-label="&nbsp;Plain&nbsp;">
                                            <input type="radio" name="mailtype" value="html" class="toggle" {{ $mail_config[ 'mailtype'][1]=='html' ? 'checked': '' }} />
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.email_type_note') }}</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.server_address') }}</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="smtp_host" value="{{ $mail_config['smtp_host'][1] }}" placeholder="smtp://">
                                        <!-- <span class="help-block">Host.</span> -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.port') }}</label>
                                    <div class="col-md-1">
                                        <input type="text" class="form-control" name="smtp_port" value="{{ $mail_config['smtp_port'][1] }}" placeholder="465">
                                        <!-- <span class="help-block">Port.</span> -->
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.username') }}</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
    																<i class="fa fa-envelope"></i>
    															</span>
                                            <input type="text" class="form-control" name="smtp_user" value="{{ $mail_config['smtp_user'][1] }}" placeholder="noreply@teemworx.com">
                                        </div>
                                        <!-- <span class="help-block">Port.</span> -->
                                    </div>
                                </div>

                                <div class="form-group last">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.password') }}</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
    																<i class="fa fa-key"></i>
    															</span>
                                            <input type="password" class="form-control" name="smtp_pass" value="{{ $mail_config['smtp_pass'][1] }}" placeholder="{{ lang('system_settings.p_password') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="config_group_id" value="{{ $mail_config['config_group_id'][1] }}">
                                    <button 
                                        type="submit" 
                                        class="btn green submit" 
                                        id="submit-email-settings" 
                                        name="submit-email-settings"
                                        onclick="save_record( $(this).closest('form'), ''); return false;">
                                        <i class="fa fa-check"></i> {{ lang('system_settings.submit') }}
                                    </button>
                                    <button type="button" class="btn default">{{ lang('system_settings.cancel') }}</button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>

                <div class="portlet" style="cursor:pointer">
                    <div class="portlet-title">
                        <div class="caption">{{ lang('system_settings.other_settings') }}</div>
                        <div class="tools">
                            <a href="javascript:;" class="expand"></a>
                        </div>
                    </div>
                    <p class="small">{{ lang('system_settings.other_settings_note') }}</p>

                    <div class="portlet-body form" style="display:none;">
                        <!-- BEGIN FORM-->
                        <form action="#" id="config-other-settings" class="form-horizontal form" name="config-other-settings">
                            <div class="form-body">

                                @if(isset($other_config['enable_chat']))
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.enable_chat') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="enable_chat" value="0" />
                                            <input type="radio" name="enable_chat" class="toggle" {{ $other_config[ 'enable_chat'][1]=='1' ? 'checked': '' }} />
                                        </div>
                                        <!-- <span class="help-block" style="font-size:80%">.</span> -->
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['enable_captcha']))
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.enable_captcha') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="enable_captcha" value="0" />
                                            <input type="radio" name="enable_captcha" class="toggle" {{ $other_config[ 'enable_captcha'][1]=='1' ? 'checked': '' }}/>
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.enable_captcha_note') }}</span>
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['enable_geolocation']))
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.enable_geolocation') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="enable_geolocation" value="0" />
                                            <input type="radio" name="enable_geolocation" class="toggle" {{ $other_config[ 'enable_geolocation'][1] == '1' ? 'checked': '' }}/>
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.enable_geolocation_note') }}</span>
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['enable_language']))
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.enable_language') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="enable_language" value="0" />
                                            <input type="radio" name="enable_language" class="toggle" {{ $other_config[ 'enable_language'][1] == '1' ? 'checked': '' }}/>
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.enable_language_note') }}</span>
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['warnafter']))
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.warn_after') }}</label>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <span class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</span>
                                            <input type="text" name="warnafter" class="form-control" value="{{ $other_config['warnafter'][1] }}" placeholder="1800">
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.warn_after_note') }}</span>
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['redirafter']))
                                <div class="form-group last">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.redirect_after') }}</label>
                                    <div class="col-md-2">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                                    <i class="fa fa-clock-o"></i>
                                                                </span>
                                            <input type="text" name="redirafter" class="form-control" value="{{ $other_config['redirafter'][1] }}" placeholder="1800">
                                        </div>
                                        <span class="help-block" style="font-size:80%">{{ lang('system_settings.redirect_after_note') }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>

                                <hr style="border-style: dashed;" />
                                @if(isset($other_config['enable_open_season']))
                                <div class="form-group">
                                    <label class="control-label col-md-3">{{ lang('system_settings.enable_open_season') }}</label>
                                    <div class="col-md-9">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="hidden" name="enable_open_season" value="0" />
                                            <input type="radio" name="enable_open_season" class="toggle" {{ $other_config[ 'enable_open_season'][1] == '1' ? 'checked': '' }}/>
                                        </div>
                                        <!-- span class="help-block" style="font-size:80%">{{ lang('system_settings.enable_open_session_note') }}</span -->
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['date_from']))
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.date_from') }}</label>
                                    <div class="col-md-2">
                                        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" name="date_from" value="{{ ($other_config['date_from'][1] == '0000-00-00') ? '' : $other_config['date_from'][1] }}" placeholder="{{ lang('system_settings.p_date_from') }}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(isset($other_config['date_to']))
                                <div class="form-group">
                                    <label class="col-md-3 control-label">{{ lang('system_settings.date_to') }}</label>
                                    <div class="col-md-2">
                                        <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" name="date_to" value="{{ ($other_config['date_to'][1] == '0000-00-00') ? '' : $other_config['date_to'][1] }}" placeholder="{{ lang('system_settings.p_date_to') }}" >
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            <div class="form-actions fluid">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="hidden" name="config_group_id" value="{{ $other_config['config_group_id'][1] }}">
                                    <button 
                                        type="submit" 
                                        class="btn green submit" 
                                        id="submit-other-settings" 
                                        name="submit-other-settings"
                                        onclick="save_record( $(this).closest('form'), ''); return false;">
                                        <i class="fa fa-check"></i> {{ lang('system_settings.submit') }}
                                    </button>
                                    <button type="button" class="btn default">{{ lang('system_settings.cancel') }}</button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>

            <!-- <div class="tab-pane active" id="tab_1">
            </div>

            <div class="tab-pane active" id="tab_2">
            </div>

            <div class="tab-pane active" id="tab_3">
            </div> -->

        </div>

    </div>
</div>
@stop

@section('page_plugins')
	@parent
    
    <script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>
    <script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
    
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-fileupload/bootstrap-fileupload.js"></script>

    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/load-image.min.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>



    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
     <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-image.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

@stop

@section('page_scripts')
	@parent
	
    
    {{ get_module_js( $mod ) }}
    <script type="text/javascript" src="{{ theme_path() }}modules/system/edit.js"></script>    
@stop

@section('view_js')
	@parent

	<script>
		jQuery(document).ready(function() {       
		
           	$('.selectM3').select2('destroy');   
        	$('.selectM3').select2();
        });
	</script>
@stop