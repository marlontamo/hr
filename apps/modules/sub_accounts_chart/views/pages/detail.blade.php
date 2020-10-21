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
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">Basic Information</div>
                <div class="tools"><a class="collapse" href="javascript:;"></a></div>
            </div>
                <div class="portlet-body form">         
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">* </span>Sub Account Code</label>
                        <div class="col-md-7">                          
                            <input type="text" disabled="disabled" class="form-control" name="payroll_account_sub[account_sub_code]" id="payroll_account_sub-account_sub_code" value="{{ $record['payroll_account_sub.account_sub_code'] }}" placeholder="Enter Sub Account Code" />                
                        </div>  
                    </div>          
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">* </span>Sub Account Name</label>
                        <div class="col-md-7">                          
                            <input type="text" disabled="disabled" class="form-control" name="payroll_account_sub[account_sub]" id="payroll_account_sub-account_sub" value="{{ $record['payroll_account_sub.account_sub'] }}" placeholder="Enter Sub Account Name" />               
                        </div>  
                    </div>          
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">* </span>Account Name</label>
                        <div class="col-md-7">
                            <?php                                                                     
                                $db->select('account_id,account_name');
                                $db->order_by('account_name', '0');
                                $db->where('deleted', '0');
                                $options = $db->get('payroll_account');                                 
                                $payroll_account_sub_account_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $payroll_account_sub_account_id_options[$option->account_id] = $option->account_name;
                                } 
                            ?>                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_account_sub[account_id]',$payroll_account_sub_account_id_options, $record['payroll_account_sub.account_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="payroll_account_sub-account_id"') }}
                            </div>              
                        </div>  
                    </div>          
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">* </span>Category</label>
                        <div class="col-md-7">
                            <?php                                                                     
                                $db->select('category_id,category');
                                $db->order_by('category', '0');
                                $db->where('deleted', '0');
                                $options = $db->get('payroll_account_category');                                
                                $payroll_account_sub_category_id_options = array('' => 'Select...');
                                foreach($options->result() as $option)
                                {
                                    $payroll_account_sub_category_id_options[$option->category_id] = $option->category;
                                } 
                            ?>                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_account_sub[category_id]',$payroll_account_sub_category_id_options, $record['payroll_account_sub.category_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..." id="payroll_account_sub-category_id"') }}
                            </div>              
                        </div>  
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-md-3"><span class="required">* </span>Category Value</label>
                        <div class="col-md-7">
                            <?php
                                $options = "";
                                if( !empty( $record_id ) )
                                {
                                    $options = $mod->_get_applied_to_options( $record_id, true );
                                }
                            ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                <select disabled="disabled" name="payroll_account_sub[category_val_id]" id="payroll_account_sub-category_val_id" class="form-control select2me" data-placeholder="Select...">
                                    {{ $options }}
                                </select>
                            </div>
                        </div>  
                    </div>
                </div>
                @include('buttons/detail')
        </div>
    </form>
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
