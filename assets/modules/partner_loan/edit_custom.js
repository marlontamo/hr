$(document).ready(function(){
	$('input[name="partner_name"]').typeahead({
	    source: function(query, process) {
	        employees = [];
	        map = {};
	        
	        $.getJSON(base_url + module.get('route') + '/user_lists_typeahead', function(data){
	            var users = data.users;
	            for( var i in users)
	            {
	                employee = users[i];
	                map[employee.label] = employee;
	                employees.push(employee.label);
	            }
	         
	            process(employees);    
	        });
	        
	    },
	    updater: function (item) {
	        $('#payroll_partners_loan-user_id').val(map[item].value);
	        return item;
	    },
	    click: function (e) {
	      e.stopPropagation();
	      e.preventDefault();
	      this.select();
	    }
	});

	$('input[name="partner_name"]').focus(function(){
	    $(this).val('');
	    $('#payroll_partners_loan-user_id').val('');
	});

	var amount = $("#payroll_partners_loan-amount");
	var interest = $("#payroll_partners_loan-interest");
	var no_payments = $("#payroll_partners_loan-no_payments");
	var principal = $("#payroll_partners_loan-loan_principal");

	// System Amortization when change on amount
    amount.keyup(function(){
        var sys_amort = isNaN(parseInt(amount.val().replace(",","") / no_payments.val() ) ) ? 0 : ( amount.val().replace(",","") / no_payments.val() );
        $("#payroll_partners_loan-system_amortization").val(sys_amort.toFixed(2));
    });

    // System Interest when change on interest
    interest.keyup(function(){
        var sys_interest = isNaN(parseInt(interest.val().replace(",","") / no_payments.val() ) ) ? 0 : ( interest.val().replace(",","") / no_payments.val() );
        $("#payroll_partners_loan-system_interest").val(sys_interest.toFixed(2));
        var amount_w_interest = parseInt(principal.val().replace(",","") * interest.val() / 100) + parseInt(principal.val().replace(",",""));
        var amount_with_interest = isNaN(amount_w_interest) ? 0 : ( amount_w_interest );
        $(amount).val(amount_with_interest.toFixed(2));
    });

    // amount when change on loan principals
    principal.keyup(function(){
        var amount_w_interest = parseInt(principal.val().replace(",","") * interest.val() / 100) + parseInt(principal.val().replace(",",""));
        var amount_with_interest = isNaN(amount_w_interest) ? 0 : ( amount_w_interest );
        $(amount).val(amount_with_interest.toFixed(2));
    });

    no_payments.keyup(function(){
    	// System Amortization when change on amount
        var sys_amort = isNaN(parseInt(amount.val().replace(",","") / no_payments.val() ) ) ? 0 : ( amount.val().replace(",","") / no_payments.val() );
        $("#payroll_partners_loan-system_amortization").val(sys_amort.toFixed(2));
        // System Interest when change on interest
        var sys_interest = isNaN(parseInt(interest.val().replace(",","") / no_payments.val() ) ) ? 0 : ( interest.val().replace(",","") / no_payments.val() );
        $("#payroll_partners_loan-system_interest").val(sys_interest.toFixed(2));
    });

});