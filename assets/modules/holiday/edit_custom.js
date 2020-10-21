$(document).ready(function(){
	init_location();

	$('#time_holiday-legal-temp').change(function(){
		init_location();
	});
});

function init_location()
{
	if( $('#time_holiday-legal').val() == 1 )
	{
		$('#time_holiday_location-location_id').select2('disable');
  		$('#time_holiday_location-location_id').select2('data', null)
		// $('#time_holiday_location-location_id').multiselect('uncheckAll');
		// $('#time_holiday_location-location_id').multiselect('disable');
	}
	else{
		// $('#time_holiday_location-location_id').multiselect('enable');
		$('#time_holiday_location-location_id').select2('enable');
	}
}