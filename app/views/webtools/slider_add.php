<div class="col-xs-12">
    <div class="box box-danger">
         
         <div class="box-header with-border">
            <h3 class="box-title">Add new slider</h3>
         </div>
         
        <form role="form" id="ajax_form" method="POST" enctype="multipart/form-data" action="<?php echo $formurl; ?>">
            <div class="box-body">

            	<div class="alert-cont">
            		
            	</div>

				<div class="form-group">
					<label for="title">Title</label>
					<input required class="form-control" type="text" name="title" placeholder="Title" value="<?php echo (!empty($slide_data)) ? $slide_data->title:'' ?>">
				</div>

				<div class="form-group">
					<label for="desc">Description</label>
					<textarea name="desc" id="" cols="30" rows="10" class="form-control"><?php echo (!empty($slide_data)) ? $slide_data->desc:'' ?></textarea>
				</div>

				<div class="form-group">
					<label for="background">Background (Min height: 400px, Min width: 1920px, Max: 2MB)</label>
					<?php if (!empty($slide_data)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/slider/bg/'.$slide_data->background) ?>" alt=""><br><br>
					<?php endif ?>
					<input type="file" name="background">
				</div>

				<div class="form-group">
					<label for="image">Image</label>
					<?php if (!empty($slide_data) AND !empty($slide_data->image)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/slider/img/'.$slide_data->image) ?>" alt=""><br><br>
					<?php endif ?>
					<input type="file" name="image">
				</div>

				<div class="form-group">
					<label for="link">Link</label>
					<input value="<?php echo (!empty($slide_data)) ? $slide_data->link:'#' ?>" class="form-control" type="text" name="link" placeholder="Link">
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
        	tinyMCE.triggerSave();
        	
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