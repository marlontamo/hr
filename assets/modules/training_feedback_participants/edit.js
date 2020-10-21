$(document).ready(function(){

$('.feedback_average').live('click',function(){
	get_total_average();
});

function get_total_average(){
	var url = base_url + module.get('route') + '/get_total_average';
    var data = $('#form_feedback_participants').serialize();

	$.ajax({
        url: url,
        dataType: 'json',
        type:"POST",
        data: data,
        success: function (response) {
        	$('input[name="training_feedback[total_score]"]').val(response.total_score);
        	$('input[name="training_feedback[average_score]"]').val(response.average_score);
        }
	});
}

});