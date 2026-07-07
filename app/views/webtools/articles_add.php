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
					<label for="title">Title</label>
					<input required class="form-control" type="text" name="title" placeholder="Title" value="<?php echo (!empty($article_data)) ? $article_data->title:'' ?>">
				</div>

				<div class="form-group">
					<label for="type">Category</label>
					<select required name="type" id="type" class="form-control">
						<option value="1">Articles</option>
						<option value="2">News & Promo</option>
					</select>
				</div>

				<div class="form-group">
					<label for="desc">Short Description</label>
					<textarea required name="desc" id="" cols="30" rows="5" class="form-control"><?php echo (!empty($article_data)) ? $article_data->short_desc:'' ?></textarea>
				</div>

				<div class="form-group">
					<label for="content">Content</label>
					<textarea name="content" id="" cols="30" rows="10" class="fulltext-editor"><?php echo (!empty($article_data)) ? $article_data->content:'' ?></textarea>
				</div>

				<div class="form-group">
					<label for="header_image">Header Image (Min height: 500px, Min width: 1920px)</label>
					<?php if (!empty($article_data)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/articles/'.$article_data->header_image) ?>" alt=""><br><br>
					<?php endif ?>
					<input type="file" name="header_image">
				</div>

				<div class="form-group">
					<label for="header_image_m">Header Image Mobile (Min height: 600px, Min width: 640px)</label>
					<?php if (!empty($article_data)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/articles/'.$article_data->header_image_m) ?>" alt=""><br><br>
					<?php endif ?>
					<input type="file" name="header_image_m">
				</div>

				<div class="form-group">
					<label for="featured_image">Featured Image</label>
					<?php if (!empty($article_data) AND !empty($article_data->featured_image)): ?>
						<br><img width="200px" src="<?php echo base_url('uploads/articles/'.$article_data->featured_image) ?>" alt=""><br><br>
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