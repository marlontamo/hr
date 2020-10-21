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
                <label class="control-label col-md-3"><span class="required">* </span>Bank Type</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[bank_type]" id="payroll_bank-bank_type" value="{{ $record['payroll_bank.bank_type'] }}" placeholder="Enter Bank Type" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Bank Code Numeric</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[bank_code_numeric]" id="payroll_bank-bank_code_numeric" value="{{ $record['payroll_bank.bank_code_numeric'] }}" placeholder="Enter Bank Code Numeric" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Bank Code Alpha</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[bank_code_alpha]" id="payroll_bank-bank_code_alpha" value="{{ $record['payroll_bank.bank_code_alpha'] }}" placeholder="Enter Bank Code Alpha" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Account Name</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[bank]" id="payroll_bank-bank" value="{{ $record['payroll_bank.bank'] }}" placeholder="Enter Account Name" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Account Number</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[account_no]" id="payroll_bank-account_no" value="{{ $record['payroll_bank.account_no'] }}" placeholder="Enter Account Number" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Batch Number</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[batch_no]" id="payroll_bank-batch_no" value="{{ $record['payroll_bank.batch_no'] }}" placeholder="Enter Batch Number" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Ceiling Amount</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[ceiling_amount]" id="payroll_bank-ceiling_amount" value="{{ $record['payroll_bank.ceiling_amount'] }}" placeholder="Enter Ceiling Amount" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Branch Code</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[branch_code]" id="payroll_bank-branch_code" value="{{ $record['payroll_bank.branch_code'] }}" placeholder="Enter Branch Code" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-7">                          
                    <textarea class="form-control" disabled="disabled" name="payroll_bank[description]" id="payroll_bank-description" placeholder="Enter Description" rows="4">{{ $record['payroll_bank.description'] }}</textarea>                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Address</label>
                <div class="col-md-7">                          
                    <textarea class="form-control" disabled="disabled" name="payroll_bank[address]" id="payroll_bank-address" placeholder="Enter Address" rows="4">{{ $record['payroll_bank.address'] }}</textarea>                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Branch Officer</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[branch_officer]" id="payroll_bank-branch_officer" value="{{ $record['payroll_bank.branch_officer'] }}" placeholder="Enter Branch Officer" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Branch Position</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[branch_position]" id="payroll_bank-branch_position" value="{{ $record['payroll_bank.branch_position'] }}" placeholder="Enter Branch Position" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Signatory 1</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[signatory_1]" id="payroll_bank-signatory_1" value="{{ $record['payroll_bank.signatory_1'] }}" placeholder="Enter Signatory 1" />                 
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Signatory 2</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control" name="payroll_bank[signatory_2]" id="payroll_bank-signatory_2" value="{{ $record['payroll_bank.signatory_2'] }}" placeholder="Enter Signatory 2" />                 
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
