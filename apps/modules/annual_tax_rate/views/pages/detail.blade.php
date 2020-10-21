@extends('layouts/master')

@section('page_styles')
	@parent
	@include('detail/page_styles')
@stop

@section('page_content')
	@parent

<div class="row">

    <div class="col-md-9">

    <form method="post" fg_id="1" class="form-horizontal">
        <!-- Edit -->
        <div class="portlet">
    <div class="portlet-title">
        <div class="caption">{{ lang('annual_tax_rate.basic_info') }}</div>
        <div class="tools"><a class="collapse" href="javascript:;"></a></div>
    </div>
    <div class="portlet-body form">         
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.salary_from') }}</label>
            <div class="col-md-7">                          
                <input type="text" disabled="disabled" class="form-control" name="payroll_annual_tax[salary_from]" id="payroll_annual_tax-salary_from" value="{{ $record['payroll_annual_tax.salary_from'] }}" placeholder="{{ lang('annual_tax_rate.p_salary_from') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'"/>               
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.salary_to') }}</label>
            <div class="col-md-7">                          
                <input type="text" disabled="disabled" class="form-control" name="payroll_annual_tax[salary_to]" id="payroll_annual_tax-salary_to" value="{{ $record['payroll_annual_tax.salary_to'] }}" placeholder="{{ lang('annual_tax_rate.p_salary_to') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'" />               
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.fixed_amt') }}</label>
            <div class="col-md-7">                          
                <input type="text" disabled="disabled" class="form-control" name="payroll_annual_tax[amount]" id="payroll_annual_tax-amount" value="{{ $record['payroll_annual_tax.amount'] }}" placeholder="{{ lang('annual_tax_rate.p_fixed_amt') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'" />                
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>{{ lang('annual_tax_rate.ex_rate') }}</label>
            <div class="col-md-7">                          
                <input type="text" disabled="disabled" class="form-control" name="payroll_annual_tax[rate]" id="payroll_annual_tax-rate" value="{{ $record['payroll_annual_tax.rate'] }}" placeholder="{{ lang('annual_tax_rate.p_ex_rate') }}" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false'" />                
            </div>  
        </div>  
    </div>

            @include('buttons/detail')

                        <!-- <div class="form-actions fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-offset-3 col-md-9"> -->
                                        <!-- <button class="btn green btn-sm" type="button" onclick="save_fg( $(this).parents('form') )"><i class="fa fa-check"></i> Save</button> -->
                                        <!-- <button 
                                            class="btn green btn-sm" 
                                            type="button" 
                                            onclick="save_record( $(this).closest('form'), '')"><i class="fa fa-check"></i> Save
                                        </button>
                                        <button class="btn blue btn-sm" type="submit" onclick="save_record( $(this).parents('form'), 'new')">Save &amp; Add New</button>
                                        <a href="{{ $mod->url }}" class="btn default btn-sm">Back</a> 
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <!-- </form> -->
                     <!-- END FORM -->
                <!-- </div> -->
            <!-- </div> -->
        </div>
        </form>
        <!-- End Edit -->
    </div>
	
    
    <!--RIGHT SIDE ACTION BUTTONS-->
    <!-- <div class="col-md-3 visible-lg">
    
        <div class="portlet" id="abId0.45087891281582415">
            <div class="clearfix margin-bottom-20" id="abId0.23150411853566766">
                <div class="input-icon right margin-bottom-10" id="abId0.6490198103711009">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="Search..." class="form-control">
                </div>

                <div class="btn-group btn-group-justified">
                    <a class="btn btn-default" id="goadd"><i class="fa fa-plus"></i> Add</a>
                    <a class="btn btn-default" href="#"><i class="fa fa-times"></i> Delete</a>
                </div>
                <div class="btn-group btn-group-justified margin-bottom-10">
                    <a class="btn btn-default" id="trash"><i class="fa fa-trash-o"></i> Trash Bin</a>
                    <a class="btn btn-default" href="admin_user.php"><i class="fa fa-chevron-left"></i> Back</a>
                </div>

            </div>
        </div>
    </div> -->
    <!--END RIGHT SIDE ACTION BUTTONS-->
    
</div>

@stop


@section('page_plugins')
	@parent
	@include('detail/page_plugins')
@stop


@section('page_scripts')
	@parent

	@include('detail/page_scripts')

    <script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.iframe-transport.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-process.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/jquery-file-upload/js/jquery.fileupload-ui.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
    <script src="{{ theme_path() }}plugins/bootstrap-switch/static/js/bootstrap-switch.min.js" type="text/javascript" ></script>
@stop


@section('view_js')
	@parent

	{{ get_edit_js( $mod ) }}

@stop
