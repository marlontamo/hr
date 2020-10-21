@extends('layouts.master')

@section('page_content')
@parent

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="row">
    <div class="col-md-11">
        <!-- BEGIN FORM-->
        <div class="row">
            <!-- FORM -->
            <div class="col-md-12">

                <div class="portlet">
                    <div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                                <div class="note note-default">

                                    <h3 class="page-title">
                                    {{ lang('partner_manager.resources') }}: <small> {{ lang('partner_manager.set_con') }}</small>
                                    </h3>
                                    <p class="small">{{ lang('partner_manager.p_set_con') }}</p>

                                    <hr/>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.job_class')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('career_stream') }}" href="{{ get_mod_route('career_stream') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.job_rlevel')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('career_level') }}" href="{{ get_mod_route('career_level') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.j_grade')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('job_grade') }}" href="{{ get_mod_route('job_grade') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.p_grade')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('pay_grade') }}" href="{{ get_mod_route('pay_grade') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.p_rates')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('pay_set_rates') }}" href="{{ get_mod_route('pay_set_rates') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.com_level')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('partners_competency_level') }}" href="{{ get_mod_route('partners_competency_level') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.specialization')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('specialization') }}" href="{{ get_mod_route('specialization') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="portlet">
                    <div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                                <div class="note note-default">

                                    <h3 class="page-title">
                                    {{ lang('partner_manager.clearance') }}: <small> {{ lang('partner_manager.set_con') }}</small>
                                    </h3>
                                    <p class="small">{{ lang('partner_manager.p_set_con') }}</p>

                                    <hr/>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.clearance_sign')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('clearance_sign') }}" href="{{ get_mod_route('clearance_sign') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.exit_int')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('exit_interview_manager') }}" href="{{ get_mod_route('exit_interview_manager') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                       
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="portlet">
                    <div class="portlet-body form">
                        <form action="#" class="form-horizontal">
                            <div class="form-body" style="padding-bottom:0px;">

                                <div class="note note-default">

                                    <h3 class="page-title">
                                    {{ lang('partner_manager.code_conduct') }}: <small> {{ lang('partner_manager.set_con') }}</small>
                                    </h3>
                                    <p class="small">{{ lang('partner_manager.p_set_con') }}</p>

                                    <hr/>

                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.code_discipline')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('code_discipline') }}" href="{{ get_mod_route('code_discipline') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>  
                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.offense_category')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('offense_category') }}" href="{{ get_mod_route('offense_category') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>  
                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.offense_level')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('offense_level') }}" href="{{ get_mod_route('offense_level') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <div class="col-md-9 margin-bottom-10">
                                            <h4>{{ lang('partner_manager.sanction_category')}}</h4>
                                            <div class="text-muted small"></div>
                                        </div>
                                        <div class="col-md-3 margin-bottom-25">
                                            <a class="btn btn-default" type="button" rel="{{ get_mod_route('offense_sanction_category') }}" href="{{ get_mod_route('offense_sanction_category') }}">{{ lang('partner_manager.view_list_button') }}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END FORM-->
    </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('page_plugins')
@parent
<script type="text/javascript" src="{{ theme_path() }}plugins/jquery.infiniteScroll.js"></script>
<script type="text/javascript" src="{{ theme_path() }}modules/common/lists.js"></script>
@stop

@section('view_js')
@parent
{{ get_list_js( $mod ) }}
@stop
