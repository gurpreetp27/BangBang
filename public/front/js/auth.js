////////////////Auth js//////////////

/*this function handle login request form login poppup in index page*/
$(document).on('click','.sign-in-form-button',function(e){
	e.preventDefault();
	var formId = $('form.sign-in-form').attr('id');
		var url = $('form.sign-in-form').attr('action');
		var data = $('form.sign-in-form').serialize();
	$(".loader").show();
		$.ajax({
		    url: url,
		    data: data,
		    type: 'post',
		    dataType:'json',
		    success: function(data) {
		    	$(".loader").hide();
		    	if(data.auth == 1){
		    		location.reload(true);
		    		return false;
		    	}
		    	
		    },
		    error: function(error){
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


/*this function handle login request form login poppup in index page*/
$(document).on('click','.register_now',function(e){
	e.preventDefault();

	if($("#password1").val() !== $("#password2").val()) {
		return false;
	}
	else {
		$(".loader").show();
		$("#register_form").submit();
	}

});