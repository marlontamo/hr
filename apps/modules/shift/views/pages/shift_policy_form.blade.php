
<div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>Company</th>
							<th>Value</th>
							<th>Employee Type</th>
							<th>Employee Status</th>
							<th>Partners</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($companies as $company_id =>  $company)
							<tr class="small">
								<td>{{ $company }}</td>
								<td>
									<a href="#" class="company_class_value" company="{{ $company_id }}" class-value="{{ $class_value }}" 
										data-type="{{ $data_type }}" data-pk="{{ $class_id }}"  data-original-title="" 
										{{ ($data_type == "combodate") ? 'data-template="HH:mm" data-format="HH:mm" viewformat="HH:mm"' : '' }}>
										{{ (!empty($class_company) && isset($class_company[$company_id]))  ? $class_company[$company_id]['class_value'] : $shift_value }}
									</a>
								</td>
								<td>
									<a href="#" class="employee_type" company="{{ $company_id }}" class-value="{{ $class_value }}" 
										data-type="select2" data-pk="{{ $class_id }}" data-original-title="" 
										data-value="{{ (!empty($class_company) && isset($class_company[$company_id]))  ? ($class_company[$company_id]['employment_type_id'] == 'ALL') ? '' : $class_company[$company_id]['employment_type_id'] : '' }}">
										{{ (!empty($class_company) && isset($class_company[$company_id])) ? ($class_company[$company_id]['employment_type_id'] == 'ALL') ? 'ALL' : '' : '' }}
									</a>
								</td>
								<td>
									<a href="#"  class="employee_status"  company="{{ $company_id }}" class-value="{{ $class_value }}" 
										data-type="select2" data-pk="{{ $class_id }}"  data-original-title="" 
										data-value="{{ (!empty($class_company) && isset($class_company[$company_id]))  ? ($class_company[$company_id]['employment_status_id'] == 'ALL') ? '' : $class_company[$company_id]['employment_status_id'] : '' }}">
										{{ (!empty($class_company) && isset($class_company[$company_id]))  ? ($class_company[$company_id]['employment_status_id'] == 'ALL') ? 'ALL' : '' : '' }}
									</a>
								</td>
								<td>
									<a href="#"  class="employees" company="{{ $company_id }}" class-value="{{ $class_value }}" 
										data-type="select2" data-pk="{{ $class_id }}"  data-original-title="" 
										data-value="{{ (!empty($class_company) && isset($class_company[$company_id]))  ? ($class_company[$company_id]['partners_id'] == 'ALL' || $class_company[$company_id]['partners_id'] == 'NONE') ? '' : $class_company[$company_id]['partners_id'] : '' }}">
										{{ (!empty($class_company) && isset($class_company[$company_id]))  ? ($class_company[$company_id]['partners_id'] == 'ALL' || $class_company[$company_id]['partners_id'] == 'NONE') ? $class_company[$company_id]['partners_id'] : '' : '' }}
									</a>
								</td>
								
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

<script type="text/javascript">
	var employment_types = [];
	 $.each({{ $employment_type }},
	 	 function (k, v) {
            employment_types.push({
                id: k,
                text: v
            });
        });

	$('.employee_type').editable({
		url: base_url + module_url + '/save_company_policy',
        inputclass: 'form-control input-medium',
        source: employment_types,
        select2 : {multiple: true},
        params: function(params) {
                var company = $(this).attr("company");
                var class_value = $(this).attr("class-value");
                var data = {};
                data['shift_id'] = {{ $shift_id }};
                data['company_id'] = company;
                data['value'] = params.value;
                data['class_id'] = params.pk;
                data['class_value'] = class_value;
                data['value_type'] = 'employment_type_id';
                return data;
            },
        success: function(response) {
		        handle_ajax_message( response.message );

		        if( response.saved )
                    {
                        $('.modal-container').data( 'bs.modal', null );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                    }
		    },
    });
	
	var employment_status = [];
	$.each({{ $employment_status }},
	 	 function (k, v) {
            employment_status.push({
                id: k,
                text: v
            });
        });

	$('.employee_status').editable({
		url: base_url + module_url + '/save_company_policy',
        inputclass: 'form-control input-medium',
        source: employment_status,
        select2 : {multiple: true},
        params: function(params) {
                var company = $(this).attr("company");
                var class_value = $(this).attr("class-value");
                var data = {};
                data['shift_id'] = {{ $shift_id }};
                data['company_id'] = company;
                data['value'] = params.value;
                data['class_id'] = params.pk;
                data['class_value'] = class_value;
                data['value_type'] = 'employment_status_id';
                return data;
            },
        success: function(response) {
		        handle_ajax_message( response.message );

		        if( response.saved )
                    {
                        $('.modal-container').data( 'bs.modal', null );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                    }
		    },
    });

    var employees = [];
	$.each({{ $employees }},
	 	 function (k, v) {
            employees.push({
                id: k,
                text: v
            });
        });

	$('.employees').editable({
		url: base_url + module_url + '/save_company_policy',
        inputclass: 'form-control input-medium',
        source: employees,
        select2 : {multiple: true},
        params: function(params) {
                var company = $(this).attr("company");
                var class_value = $(this).attr("class-value");
                var data = {};
                data['shift_id'] = {{ $shift_id }};
                data['company_id'] = company;
                data['value'] = params.value;
                data['class_id'] = params.pk;
                data['class_value'] = class_value;
                data['value_type'] = 'partners_id';
                return data;
            },
        success: function(response) {
		        handle_ajax_message( response.message );

		        if( response.saved )
                    {
                        $('.modal-container').data( 'bs.modal', null );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                    }
		    },
    });

	$('.company_class_value').editable({
		url: base_url + module_url + '/save_company_policy',
    	params: function(params) {
                var company = $(this).attr("company");
                var class_value = $(this).attr("class-value");
                var data = {};
                data['shift_id'] = {{ $shift_id }};
                data['company_id'] = company;
                data['value'] = params.value;
                data['class_id'] = params.pk;
                data['class_value'] = class_value;
                data['value_type'] = 'class_value';
                return data;
            },
    	 success: function(response) {
		        handle_ajax_message( response.message );

		        if( response.saved )
                    {
                        $('.modal-container').data( 'bs.modal', null );

                        if (typeof(after_save) == typeof(Function)) after_save( response );
                        if (typeof(callback) == typeof(Function)) callback( response );

                    }
		    },
	});

</script>