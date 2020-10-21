$(document).ready(function(){
	$('#time_form_class_policy-severity').select2({
	    placeholder: "Select an option",
	    allowClear: true
	});
	$('#time_form_class_policy-role_id').multiselect();

	$('#time_form_class_policy-employment_type_id').multiselect();

	$('#time_form_class_policy-employment_status_id').multiselect();

	$('#time_form_class_policy-group_id').multiselect();

	$('#time_form_class_policy-department_id').multiselect();

	$('#time_form_class_policy-division_id').multiselect();

	$('#time_form_class_policy-company_id').multiselect();

	$('#time_form_class_policy-class_id').select2({
	    placeholder: "Select an option",
	    allowClear: true
	})
;});