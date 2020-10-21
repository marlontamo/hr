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
            <div class="caption">Loan Set Up</div>
            <div class="tools"><a class="collapse" href="javascript:;"></a></div>
        </div>
        <div class="portlet-body form">         
            <div class="form-group">
                    <label class="control-label col-md-3"><span class="required">* </span>Loan Code</label>
                    <div class="col-md-7">                          
                        <input type="text" disabled="disabled" class="form-control" name="payroll_loan[loan_code]" id="payroll_loan-loan_code" value="{{ $record['payroll_loan.loan_code'] }}" placeholder="Enter Loan Code" />                 
                    </div>  
            </div>          
            <div class="form-group">
                    <label class="control-label col-md-3"><span class="required">* </span>Loan Name</label>
                    <div class="col-md-7">                          
                        <input type="text" disabled="disabled" class="form-control" name="payroll_loan[loan]" id="payroll_loan-loan" value="{{ $record['payroll_loan.loan'] }}" placeholder="Enter Loan Name" />                
                    </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Loan Type</label>
                <div class="col-md-7">
                        <?php   
                            $db->select('loan_type_id,loan_type');
                            $db->order_by('loan_type', '0');
                            $db->where('deleted', '0');
                            $options = $db->get('payroll_loan_type');                               
                            $payroll_loan_loan_type_id_options = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $payroll_loan_loan_type_id_options[$option->loan_type_id] = $option->loan_type;
                            } 
                        ?>                            
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ul"></i>
                        </span>
                        {{ form_dropdown('payroll_loan[loan_type_id]',$payroll_loan_loan_type_id_options, $record['payroll_loan.loan_type_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                    </div>              
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Loan Mode</label>
                <div class="col-md-7">
                        <?php                                                                     
                            $db->select('loan_mode_id,loan_mode');
                            $db->order_by('loan_mode', '0');
                            $db->where('deleted', '0');
                            $options = $db->get('payroll_loan_mode');                               
                            $payroll_loan_loan_mode_id_options = array('' => 'Select...');
                            foreach($options->result() as $option)
                            {
                                $payroll_loan_loan_mode_id_options[$option->loan_mode_id] = $option->loan_mode;
                            } 
                        ?>                            
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ul"></i>
                            </span>
                            {{ form_dropdown('payroll_loan[loan_mode_id]',$payroll_loan_loan_mode_id_options, $record['payroll_loan.loan_mode_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                        </div>              
                    </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Principal Transaction</label>
                <div class="col-md-7">
                    <?php                                                                     
                        $options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
                                   FROM {dbprefix}payroll_transaction a
                                   LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
                                   WHERE a.deleted = 0 AND b.transaction_class_code = 'LNEMPL'"));                                 
                        $payroll_loan_principal_transid_options = array('' => 'Select...');
                        foreach($options->result() as $option)
                        {
                            $payroll_loan_principal_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        } 
                    ?>                            
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ul"></i>
                        </span>
                            {{ form_dropdown('payroll_loan[principal_transid]',$payroll_loan_principal_transid_options, $record['payroll_loan.principal_transid'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                                
                    </div>              
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3"><span class="required">* </span>Amortization Transaction</label>
                <div class="col-md-7">
                    <?php                                                                     
                        $options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
                        FROM {dbprefix}payroll_transaction a
                        LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
                        WHERE a.deleted = 0 AND b.transaction_class_code = 'LOAN_AMORTIZATION'"));                              
                        $payroll_loan_amortization_transid_options = array('' => 'Select...');
                        foreach($options->result() as $option)
                        {
                            $payroll_loan_amortization_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                        } 
                    ?>                            
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ul"></i>
                        </span>
                        {{ form_dropdown('payroll_loan[amortization_transid]',$payroll_loan_amortization_transid_options, $record['payroll_loan.amortization_transid'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                    </div>              
                </div>  
            </div>          
            <div class="form-group">
                <label class="control-label col-md-3">Amount Limit</label>
                <div class="col-md-7">                          
                    <input type="text" disabled="disabled" class="form-control text-right" name="payroll_loan[amount_limit]" id="payroll_loan-amount_limit" value="{{ $record['payroll_loan.amount_limit'] }}" placeholder="Enter Amount Limit" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/>                 
                </div>  
            </div>  
        </div>
    </div>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption">Interest Set Up</div>
            <div class="tools"><a class="collapse" href="javascript:;"></a></div>
        </div>
    <div class="portlet-body form">         
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Interest Transaction</label>
            <div class="col-md-7">
                <?php                                                                     
                    $options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.transaction_code, a.transaction_id, a.transaction_label, b.transaction_class
                    FROM {dbprefix}payroll_transaction a
                    LEFT JOIN {dbprefix}payroll_transaction_class b ON b.transaction_class_id =  a.transaction_class_id
                    WHERE a.deleted = 0 AND b.transaction_class_code = 'LOAN_INTEREST'"));                              
                    $payroll_loan_interest_transid_options = array('' => 'Select...');
                    foreach($options->result() as $option)
                    {
                        $payroll_loan_interest_transid_options[$option->transaction_class][$option->transaction_id] = $option->transaction_label;
                    } 
                ?>                            
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[interest_transid]',$payroll_loan_interest_transid_options, $record['payroll_loan.interest_transid'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div>              
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Interest Mode</label>
            <div class="col-md-7">
                <?php                                                                     
                    $db->select('interest_type_id,interest_type');
                    $db->order_by('interest_type', '0');
                    $db->where('deleted', '0');
                    $options = $db->get('payroll_loan_interest_type');                              
                    $payroll_loan_interest_type_id_options = array('' => 'Select...');
                    foreach($options->result() as $option)
                    {
                        $payroll_loan_interest_type_id_options[$option->interest_type_id] = $option->interest_type;
                    } 
                ?>                            
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[interest_type_id]',$payroll_loan_interest_type_id_options, $record['payroll_loan.interest_type_id'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div>              
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Debit</label>
            <div class="col-md-7">
                <?php                                                                     
                    $options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
                    FROM {dbprefix}payroll_account a
                    LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
                    WHERE a.deleted = 0 AND b.deleted = 0"));                               
                    $payroll_loan_debit_options = array('' => 'Select...');
                    foreach($options->result() as $option)
                    {
                        $payroll_loan_debit_options[$option->account_type][$option->account_id] = $option->account_name;
                    } 
                ?>                            
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-list-ul"></i>
                    </span>
                    {{ form_dropdown('payroll_loan[debit]',$payroll_loan_debit_options, $record['payroll_loan.debit'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                </div>              
            </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3"><span class="required">* </span>Credit</label>
                <div class="col-md-7">
                    <?php                                                                     
                        $options = $db->query(str_replace('{dbprefix}', $db->dbprefix, "SELECT a.*, b.account_type
                        FROM {dbprefix}payroll_account a
                        LEFT JOIN {dbprefix}payroll_account_type b on b.account_type_id = a.account_type_id
                        WHERE a.deleted = 0 AND b.deleted = 0"));                               
                        $payroll_loan_credit_options = array('' => 'Select...');
                        foreach($options->result() as $option)
                        {
                            $payroll_loan_credit_options[$option->account_type][$option->account_id] = $option->account_name;
                        } 
                    ?>                            
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ul"></i>
                        </span>
                        {{ form_dropdown('payroll_loan[credit]',$payroll_loan_credit_options, $record['payroll_loan.credit'], 'disabled="disabled" class="form-control select2me" data-placeholder="Select..."') }}
                    </div>              
                </div>  
        </div>          
        <div class="form-group">
            <label class="control-label col-md-3">Monthly Interest</label>
            <div class="col-md-7">                          
                <input type="text" disabled="disabled" class="form-control" name="payroll_loan[interest]" id="payroll_loan-interest" value="{{ $record['payroll_loan.interest'] }}" placeholder="Enter Monthly Interest" data-inputmask="'alias': 'decimal', 'autoGroup': true, 'groupSeparator': ',', 'groupSize': 3, 'repeat': 13, 'greedy' : false"/>                
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
