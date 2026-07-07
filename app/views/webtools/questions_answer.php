<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-body">

            <blockquote>
				<p><?php echo $question_data->question ?></p>
				<small><?php echo $question_data->name ?></small>
			</blockquote>

			<form action="<?php echo base_url('webtools/questions/save_answer/'.$question_id) ?>" method="POST" id="answerform">
				
				<div class="form-group">
					<label for="answer">Answer</label>
					<textarea required name="answer" id="answer" cols="30" rows="10" class="form-control simple-editor"></textarea>
				</div>

				<div class="box-footer">
                	<button type="submit" id="answerbutton" class="btn btn-primary">Submit</button>
              	</div>

			</form>

		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	var theForm = $("#answerform");
	var theButton = $("#answerbutton");

	

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
	        answer: {
	        	required: true
	        }
	    },
	    messages: {
	    	answer: "Anda harus mengisi jawaban anda"
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
			$(theButton).html('Submit');

            if(data.code==200){
            	window.location = data.redirect;
            }else {
            	alert('data.msg')
            }
        },
        complete: function(xhr) {
        	$(theButton).prop('disabled',false);
			$(theButton).html('Submit');
        },
        error: function(xhr) {
			$(theButton).prop('disabled',false);
			$(theButton).html('Submit');
            alert('error')
        }
    })

});
</script>