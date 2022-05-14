function selectPlan(plan_id){
	$("#plan_info").hide();
	$("html, body").animate({ scrollTop: 0 }, "slow");
	$(".plan_id").val(plan_id);

	var plan_info = $(".plan_price_"+plan_id).html();
	$(".pay_info_plan").html(plan_info);

	var plan_name = $(".plan_name_"+plan_id).html();
	$(".plan_name").html(plan_name);
	$("#account_info").show();
}



/*When user click the chnage_mem.. button*/
$(document).on('click','.change_membership',function(e){
    e.preventDefault();
	$("#account_info").hide();   
	$("#plan_info").show();
	$("html, body").animate({ scrollTop: 320 }, "slow");
});

////////////////Auth js//////////////

/*this function handle login request form login poppup in index page*/
$(document).on('click','.sign-up-form-button',function(e){
    e.preventDefault();
    var formId = $('form.sign-up-form').attr('id');
	var url = $('form.sign-up-form').attr('action');
	var data = $('form.sign-up-form').serialize();

	// if($("#password").val() !== $("#password_confirmation").val()) {
	// 	alert("both password not match");
	// 	return false;
	// }
	if($("#tearm_condition").prop("checked") == false){
		alert("Tearm & Condition checkbox is required.");
		return false;
	}

	if($("#privacy-policy").prop("checked") == false){
		alert("Privacy Policy checkbox is required.");
		return false;
	}


	if($("#gdpr").prop("checked") == false){
		alert("Legal Disclaimer (GDPR) checkbox is required.");
		return false;
	}


	$(".loader").show();

		$.ajax({
		    url: url,
		    data: data,
		    type: 'post',
		    dataType:'json',
		    success: function(data) {
		    	$(".loader").hide();
		    	if(data.status == 1){
		    		if(data.payment_gateway == 'Paypal'){
		    			window.location.replace(data.url);
		    		} else {
		    			$("body").append(data.card_form);
		    			$("#knp-form").submit();
		    		}
		    		
		    		return false;
		    	}
		    	
		    },
		    error: function(error){
			    //$(".divLoading").hide();
			    $(".loader").hide();
		        if(error.status === 422 ){
		        	$('.invalid-feedback').remove();
			      	var err = error.responseJSON;
	                $.each(err.errors, function (i, v) {
	                	$('input[name='+i+']').after('<span class="invalid-feedback" role="alert"><strong>'+v+'</strong></span>');
	                
	                });
	                $('.invalid-feedback').show();
	                return false;
	                
			    }else{
			      	alert('Please refresh the page or try again');
			      	//$('.alertModal').modal('show');
			    }
	        }
		});


});
