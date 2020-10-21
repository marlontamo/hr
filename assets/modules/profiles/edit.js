$(document).ready(function(){
	$('.module').dblclick(function(event){
	  	if(event.target.type !== 'checkbox'){
	    	$(':checkbox', this).trigger('click');
	  	}
	});	
});