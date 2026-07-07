<div class="col-xs-12">
    <div class="box box-danger">
         
         <div class="box-header with-border">
            <h3 class="box-title"></h3>
         </div>
         
        <form role="form" id="ajax_form" method="POST" enctype="multipart/form-data" action="<?php echo $formurl; ?>">
            <div class="box-body">

            	<div class="alert-cont">
            		
            	</div>

				<div class="form-group">
					<label for="name">Name</label>
					<input required class="form-control" type="text" name="name" placeholder="Place Name" value="<?php echo (!empty($spot_data)) ? $spot_data->name:'' ?>">
				</div>

                <div class="form-group">
					<label for="city">City</label>
					<input required class="form-control" type="text" name="city" placeholder="City Name" value="<?php echo (!empty($spot_data)) ? $spot_data->city:'' ?>">
				</div>

                <div class="form-group">
					<label for="lat">Latitude</label>
					<input required class="form-control" type="text" name="lat" value="<?php echo (!empty($spot_data)) ? $spot_data->lat:'' ?>">
				</div>

                <div class="form-group">
					<label for="lon">Longitude</label>
					<input required class="form-control" type="text" name="lon" value="<?php echo (!empty($spot_data)) ? $spot_data->lon:'' ?>">
				</div>

                <div class="form-group">
					<label for="spf">SPF</label>
					<input required class="form-control" type="text" name="spf" value="<?php echo (!empty($spot_data)) ? $spot_data->spf:'' ?>">
				</div>

				<div class="form-group">
					<label for="featured_image">Featured Image</label>
					<?php if (!empty($spot_data) AND !empty($spot_data->picture)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/places/'.$spot_data->picture) ?>" alt=""><br><br>
					<?php endif ?>
					<input type="file" name="featured_image">
				</div>
			  
			</div>
			<div class="box-footer">
				<button class="btn btn-danger" id="submitform" type="submit">Save</button>
			</div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {

	var theForm = $("#ajax_form");
	var theButton = $("#submitform");

	$(theForm).validate({
	    ignore: '', // ignore hidden fields
	    errorClass: 'help-block',
	    successClass: 'validation-valid-label',
	    highlight: function(element, errorClass) {
	        $(element).removeClass(errorClass);
	    },
	    unhighlight: function(element, errorClass) {
	        $(element).removeClass(errorClass);
	    },
	    // Different components require proper error label placement
	    errorPlacement: function(error, element) {

	    	var typeelement = $(element).attr("type");

	    	$(element).parent().addClass("has-error");

	    	if (typeelement == "radio") {

	    		error.insertAfter($(element).parent().parent().parent().parent().parent());

	    	} else if( $(element).attr("name") == "g-recaptcha-response" ) {
	    		error.insertAfter($(element).parent());
	    	} else {
	        	error.insertAfter(element);
	    	}
	    },
	    rules: {

	    },
	    messages: {

	    }
	});

	$(theForm).ajaxForm({
        dataType:  'json',
        beforeSend: function() {
			if (theForm.valid()) {
				$(theButton).prop('disabled',true);
				$(theButton).html('<i class="fa fa-spinner fa-spin"></i>');
			} else {
				return false;
			}
        },
        success: function(data) {

        	$(theButton).prop('disabled',false);
			$(theButton).html('Save');

            if(data.code==200){
            	window.location = data.redirect;
            }else {
            	$(".alert-cont").empty().append(data.msg);
            	$('html, body').animate({
					scrollTop: $(".box-header").offset().top
				}, 500);
            }
        },
        complete: function(xhr) {
        	$(theButton).prop('disabled',false);
			$(theButton).html('Save');
        },
        error: function(xhr) {
			$(theButton).prop('disabled',false);
			$(theButton).html('Save');
            alert('error')
        }
    })

})
</script>