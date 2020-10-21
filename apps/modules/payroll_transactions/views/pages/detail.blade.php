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
    <div class="portlet-body form">         <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Transaction Code</label>
                <div class="col-md-7">                          <input type="text" disabled="disabled" class="form-control" name="payroll_transaction[transaction_code]" id="payroll_transaction-transaction_code" value="{{ $record['payroll_transaction.transaction_code'] }}" placeholder="Enter Transaction Code"/>                 </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Transaction Label</label>
                <div class="col-md-7">                          <input type="text" disabled="disabled" class="form-control" name="payroll_transaction[transaction_label]" id="payroll_transaction-transaction_label" value="{{ $record['payroll_transaction.transaction_label'] }}" placeholder="Enter Transaction Label"/>                 </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Transaction Class</label>
                <div class="col-md-7"><?php                                                                     $db->select('transaction_class_id,transaction_class');
                                                                                $db->order_by('transaction_class', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('payroll_transaction_class');
                                        $payroll_transaction_transaction_class_id_options = array('' => 'Select...');
                                        foreach($options->result() as $option)
                                        {
                                                                                            $payroll_transaction_transaction_class_id_options[$option->transaction_class_id] = $option->transaction_class;
                                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_transaction[transaction_class_id]',$payroll_transaction_transaction_class_id_options, $record['payroll_transaction.transaction_class_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Transaction Type</label>
                <div class="col-md-7"><?php                                                                     $db->select('transaction_type_id,transaction_type');
                                                                                $db->order_by('transaction_type', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('payroll_transaction_type');
                                        $payroll_transaction_transaction_type_id_options = array('' => 'Select...');
                                        foreach($options->result() as $option)
                                        {
                                                                                            $payroll_transaction_transaction_type_id_options[$option->transaction_type_id] = $option->transaction_type;
                                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_transaction[transaction_type_id]',$payroll_transaction_transaction_type_id_options, $record['payroll_transaction.transaction_type_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3">Debit Account Code</label>
                <div class="col-md-7"><?php                                                                     $db->select('account_id,account_name');
                                                                                $db->order_by('account_name', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('payroll_account');
                                        $payroll_transaction_debit_account_id_options = array('' => 'Select...');
                                        foreach($options->result() as $option)
                                        {
                                                                                            $payroll_transaction_debit_account_id_options[$option->account_id] = $option->account_name;
                                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_transaction[debit_account_id]',$payroll_transaction_debit_account_id_options, $record['payroll_transaction.debit_account_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3">Credit Account Code</label>
                <div class="col-md-7"><?php                                                                     $db->select('account_id,account_name');
                                                                                $db->order_by('account_name', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('payroll_account');
                                        $payroll_transaction_credit_account_id_options = array('' => 'Select...');
                                        foreach($options->result() as $option)
                                        {
                                                                                            $payroll_transaction_credit_account_id_options[$option->account_id] = $option->account_name;
                                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_transaction[credit_account_id]',$payroll_transaction_credit_account_id_options, $record['payroll_transaction.credit_account_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Priority</label>
                <div class="col-md-7"><?php                                                                     $db->select('priority_id,priority');
                                                                                $db->order_by('priority', '0');
                                        $db->where('deleted', '0');
                                        $options = $db->get('payroll_transaction_priority');
                                        $payroll_transaction_priority_id_options = array('' => 'Select...');
                                        foreach($options->result() as $option)
                                        {
                                                                                            $payroll_transaction_priority_id_options[$option->priority_id] = $option->priority;
                                                                                    } ?>                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                                </span>
                                {{ form_dropdown('payroll_transaction[priority_id]',$payroll_transaction_priority_id_options, $record['payroll_transaction.priority_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                            </div>              </div>  
            </div>          <div class="form-group">
                <label class="control-label col-md-3">Is Bonus</label>
                <div class="col-md-7">                          <div class="make-switch" data-on-label="&nbsp;Yes&nbsp;" data-off-label="&nbsp;No&nbsp;">
                                <input type="checkbox" disabled="disabled" value="1" @if( $record['payroll_transaction.is_bonus'] ) checked="checked" @endif name="payroll_transaction[is_bonus][temp]" id="payroll_transaction-is_bonus-temp" class="dontserializeme toggle"/>
                                <input type="hidden" disabled="disabled" name="payroll_transaction[is_bonus]" id="payroll_transaction-is_bonus" value="@if( $record['payroll_transaction.is_bonus'] ) 1 else 0 @endif"/>
                            </div>              </div>  
            </div>          </div>
            @include('buttons/detail')
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
