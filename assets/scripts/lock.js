var Lock = function () {

    return {
        //main function to initiate the module
        init: function () {
			/*$.backstretch([
		        root_url + "assets/img/bg/mobile-home.png",
		        root_url + "assets/img/bg/mobile-lifestyle.png",
		        root_url + "assets/img/bg/mobile-searching.png"
			], {
				fade: 1000,
				duration: 8000
			}); */
			load_bg_image();
			
			$('#screenlock input').keypress(function (e) {
	            $('.input-group').removeClass('has-error');
	            if (e.which == 13) {
	                if ( validate_password() ) {
	                    unlock();
	                }
	                return false;
	            }
	        });

	        $('#screenlock').submit(function(e){
	        	e.preventDefault();
	        	if ( validate_password() ) {
                    unlock();
                }

	        	return false;
	        });
        }

    };

}();

function validate_password()
{
	var password = $('#screenlock input[name="password"]').val();
	if( password == "" )
	{
		$('.alert-danger span').html( 'Enter your password.' );
	    $('.alert-danger').show();
	    $('.input-group').addClass('has-error');
	    return false;
	}
	$('.alert-danger').slideUp();
	return true;
}

function unlock()
{
	$.ajax({
		url: base_url + module.get('route') + '/unlock',
		type:"POST",
		async: false,
		data: {password: $('#screenlock input[name="password"]').val()},
		dataType: "json",
		async: false,
		success: function ( response ) {
			if(response.message.type == 'success')
            {
                if(response.redirect != undefined )
                    window.location = response.redirect;    
                else
                window.location = base_url;
            }
            else
            {
                $('.alert-danger span').html( response.message.message );
                $('.alert-danger').slideDown();
            }
		},
		error: function (x, status, error) {
            switch( x.status )
            {
            	case 403:
            		$('.alert-danger span').html( 'Sorry, your session has expired. You will be redirected to login screen in a few moments.' );
               		$('.alert-danger').slideDown();
                	setTimeout( 'window.location.href = base_url + "login"', 5000);
                	break;
                case 404:
                	$('.alert-danger span').html( 'Sorry, the resource you\'re trying to access does not exists. Please notify the system administrator.' );
               		$('.alert-danger').slideDown();
                	break;
                default:
                	$('.alert-danger span').html( 'An error occurred: ' + status + '\nError: ' + error );
               		$('.alert-danger').slideDown();
            }
        }
	});
}

function load_bg_image() {
		var urlArray = new Array();
    	var combinedUrl = '';
		$.ajax({
			url: base_url + module.get('route') + '/load_bg_image',
			type:"POST",
			async: false,
			data: {},
			dataType: "json",
			async: false,
			success: function ( response ) {

				if(response.message.type == 'success')
	            {
	            	var objects = response.message.bg;
	            	for(var key in objects) {
					    var value = objects[key];
					   	urlArray.push(root_url + value['value']);
					}

					combinedUrl = urlArray.join(', ');
					if(combinedUrl != ''){
						$.backstretch( urlArray, {
					          fade: 1000,
					          duration: 8000
					    });
					}
					
	            }
	            else
	            {
	                $('.alert-danger span').html( response.message.message );
	                $('.alert-danger').slideDown();
	            }

			},
			error: function (x, status, error) {
	            switch( x.status )
	            {
	                case 404:
	                	$('.alert-danger span').html( 'Sorry, the resource you\'re trying to access does not exists. Please notify the system administrator.' );
	               		$('.alert-danger').slideDown();
	                	break;
	                default:
	                	$('.alert-danger span').html( 'An error occurred: ' + status + '\nError: ' + error );
	               		$('.alert-danger').slideDown();
	            }
	        }
		});
	}