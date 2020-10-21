var Login = function () {

	var handleLogin = function() {

		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                remember: {
	                    required: false
	                }
	            },

	            messages: {
	                username: {
	                    required: "Username is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger span').html( 'Enter your username and password.' );
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	            	authentication.login();
	            }
	        });

	        $('.login-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.login-form').validate().form()) {
	                    $('.login-form').submit(); //form validation success, call ajax form submit
	                }
	                return false;
	            }
	        });

        	$('input[type="password"]').keypress(function (e) {

				kc = e.keyCode?e.keyCode:e.which;
				sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
				if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk)){
                    $('#caps-lock').show();
                }else{
                    $('#caps-lock').hide();
                }

			});
	}

	var handleForgetPassword = function () {
		$('.forget-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                }
	            },

	            messages: {
	                email: {
	                    required: "Email is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
	            	request_reset_pass();
	            }
	        });

	        $('.forget-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.forget-form').validate().form()) {
	                    $('.forget-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#forget-password, #request-again').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.reset-form').hide();
	            jQuery('.forget-form').show();
	        });

	        jQuery('#back-btn, #login-now').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.reset-form').hide();
	            jQuery('.forget-form').hide();
	        });

	}

	var handleRegister = function () {

		function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='assets/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }


		$("#select2_sample4").select2({
		  	placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
            allowClear: true,
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function (m) {
                return m;
            }
        });


			$('#select2_sample4').change(function () {
                $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
            });



         $('.register-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            ignore: "",
	            rules: {
	                
	                fullname: {
	                    required: true
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                address: {
	                    required: true
	                },
	                city: {
	                    required: true
	                },
	                country: {
	                    required: true
	                },

	                username: {
	                    required: true
	                },
	                password: {
	                    required: true
	                },
	                rpassword: {
	                    equalTo: "#register_password"
	                },

	                tnc: {
	                    required: true
	                }
	            },

	            messages: { // custom messages for radio buttons and checkboxes
	                tnc: {
	                    required: "Please accept TNC first."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   

	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('has-error'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            errorPlacement: function (error, element) {
	                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
	                    error.insertAfter($('#register_tnc_error'));
	                } else if (element.closest('.input-icon').size() === 1) {
	                    error.insertAfter(element.closest('.input-icon'));
	                } else {
	                	error.insertAfter(element);
	                }
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });

			$('.register-form input').keypress(function (e) {
	            if (e.which == 13) {
	                if ($('.register-form').validate().form()) {
	                    $('.register-form').submit();
	                }
	                return false;
	            }
	        });

	        jQuery('#register-btn').click(function () {
	            jQuery('.login-form').hide();
	            jQuery('.register-form').show();
	        });

	        jQuery('#register-back-btn').click(function () {
	            jQuery('.login-form').show();
	            jQuery('.register-form').hide();
	        });
	}

	var load_bg_image = function() {
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
    
    return {
        //main function to initiate the module
        init: function () {
        	
            handleLogin();
            handleForgetPassword();
            handleRegister();        

          /*  $.backstretch([
		        root_url + "assets/img/bg/mobile-home.png",
		        root_url + "assets/img/bg/mobile-lifestyle.png",
		        root_url + "assets/img/bg/mobile-searching.png"
		        ], {
		          fade: 1000,
		          duration: 8000
		    }); */
		    load_bg_image();
        }

    };

}();


