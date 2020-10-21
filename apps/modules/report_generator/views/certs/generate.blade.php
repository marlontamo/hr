@section('page_styles')
<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" />
<link type="text/css" rel="stylesheet" href="{{ theme_path() }}plugins/bootstrap-tagsinput/app.css">
@show

@section('page_content')
	<form class="form-horizontal">
		<div class="modal-body padding-bottom-0">
		<input type="hidden" id="record_id" name="record_id" value="{{ $record_id }}">
		<input type="hidden" id="certname" name="certname" value="{{ $certname }}">
			@include('certs/'.$certname)
		</div>
		<div class="modal-footer margin-top-0">
			<div class="row" align="center">
				<div class="col-md-12">
				  <div class="col-md-offset-2 col-md-8">
				    <button type="button" class="btn green btn-sm" onclick="download_certs( $(this).closest('form'), '')"><i class="fa fa-check"></i>  {{ lang('dashboard.generate') }}</button>
				    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"> {{ lang('common.close') }}</button>
				  </div>
				</div>
			</div>
		</div>
	</form>
@show

@section('page_plugins')
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<script type="text/javascript" src="{{ theme_path() }}plugins/bootstrap-tagsinput/typeahead.js"></script>
	<script src="{{ theme_path() }}scripts/ui-extended-modals.js"></script> 
@show

@section('page_scripts')
	<script type="text/javascript" src="{{ theme_path() }}modules/common/edit.js"></script> 
@show

@section('view_js')
	<!-- {{ get_edit_js( $mod ) }} -->
	<script type="text/javascript">

	$(document).ready(function(){

		$('#company_id').change(function(){
			update_partners( $(this).val() );
		});

	    $('#full_name').select2({
	        placeholder: "Select partner",
	        allowClear: true
	    });
	    $('#signatory').select2({
	        placeholder: "Select signatory",
	        allowClear: true
	    });
	    $('#contribution').select2({
	        placeholder: "Select contribution",
	        allowClear: true
	    });
	    $('#pay_year').select2({
	        placeholder: "Select year",
	        allowClear: true
	    });
	});

	function update_partners( company_id )
	{
		if( company_id != "" )
		{
			$("#list-table").hide();
			$('#full_name').select2("val","");
			// $('select[name="user_id"]').select2("val","");
			$.ajax({
			    url: base_url + 'report_generator/update_partners',
			    type: "POST",
			    async: false,
			    data: {company_id: company_id},
			    dataType: "json",
			    beforeSend: function () {
		    		// $("#dept_loader").show();
		    		// $("#department_div").hide();
			    },
			    success: function (response) {
			    	$('#full_name').html(response.users);
		    		// $("#dept_loader").hide();
		    		// $("#department_div").show();
			    	// $('select[name="user_id"]').html('');
			    }
			});	
		}
		else{
			$('select[name="department_id"]').html('');
		}		
	}

	</script>

@show