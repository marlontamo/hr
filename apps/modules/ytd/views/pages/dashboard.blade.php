@extends('layouts.master')

@section('page_styles')
	<link href="{{ theme_path() }}plugins/select2/select2_metro.css" rel="stylesheet" type="text/css"/>
	<link href="{{ theme_path() }}plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="assets/plugins/jquery-nestable/jquery.nestable.css" />
    <link rel="stylesheet" type="text/css" href="assets/plugins/fuelux/css/tree-metronic.css" />
@stop

@section('page_content')
	@parent
	@include('dashboard')
@stop

@section('page_plugins')
	@parent
	<script src="{{ theme_path() }}plugins/select2/select2.min.js" type="text/javascript" ></script>
	<script src="{{ theme_path() }}plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
@stop

@section('view_js')
<script type="text/javascript" >
	$('select[name="pay_year"]').change(function(){
		get_ytd();
	});

	$('select[name="user_id"]').change(function(){
		get_ytd();
	});

	function get_ytd()
	{
		var pay_year = $('select[name="pay_year"]').val();
		var user_id = $('select[name="user_id"]').val();
		if( pay_year != "" && user_id != "" )
		{
			$.ajax({
			    url: base_url + module.get('route') + '/get_ytd',
			    type: "POST",
			    async: false,
			    data: { pay_year: pay_year, user_id: user_id },
			    dataType: "json",
			    beforeSend: function () {
					$("#loader").show();
					$("#no_record").hide();
			    },
			    success: function (response) {
					$("#loader").hide();
					if( response.records == 0)
					{
						$("#no_record").show();
						$("#ytd_table").hide();
					}else{
						$("#ytd_body").html(response.ytd_record);
						$("#ytd_table").show();
					}
			    }
			});	
		}	
	}
</script>
@stop
