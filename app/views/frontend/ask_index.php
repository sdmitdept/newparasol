<fdiv class="section header-section">
	<div class="page-header-container" style="background-image:url('<?php echo base_url('uploads/slider/') ?>')">
		<div class="page-head-content">
			<div class="container">
				<div class="expert-head-area">
					<h1>HELLO</h1>
					<!-- <h1>dr. Nila</h1> -->
					<p>Anda punya pertanyaan seputar perlindungan kulit dari sinar matahari? Dapatkan jawaban terpercaya dari expert kami</p>
				</div>
			</div>
		</div>
	</div>
	<div class="top-curved">
		<img src="<?php echo base_url('assets/images/garisa.png') ?>" alt="">
	</div>
</div>

<div class="section ask-container">
	<div class="container">
		<form action="<?php echo base_url('ask/submit') ?>" id="askform" method="POST" >
			<div class="row form-row">
				<div class="col-md-6">
					<input type="text" required class="styled" value="" name="name" id="name" placeholder="Full Name">
				</div>
				<div class="col-md-6">
					<input type="email" required class="styled" value="" name="email" id="email" placeholder="Email">
				</div>
			</div>
			<div class="row form-row">
				<div class="col-md-12">
					<textarea name="question" required class="styled" id="question" cols="30" rows="10" placeholder="Type your question here..."></textarea>
				</div>
			</div>
			<div class="row form-submit">
				<div class="g-recaptcha" id="askcapcay" data-sitekey="6Lfwmg8UAAAAAE7rwGC_op7W97rCK1FfD9xLXNXq"></div>
			</div>
			<div class="row form-submit">
				<button type="submit" id="formsubmit" class="btn btn-orange btn-send">SEND</button>
				<!-- <input type="submit" id="formsubmit" value="SEND" class="btn btn-orange btn-send"> -->
			</div>
		</form>
	</div>
</div>

<div class="section answeredquestion">
	<div class="container">
		<h1 class="section-title section-white"><b>Answered</b> Questions</h1>
	</div>
	<div class="container">
		<div class="questionanswers">
			<div class="answer-resize"></div>
			<div class="gutter-sizer"></div>
	
		</div>
	</div>
	<div class="container moreartikel">
		<button id="buttonload" class="btn btn-green">Lihat Semua Jawaban</button>
	</div>
</div>

<script>
var $grid_layout;

$(document).ready(function() {


	var theForm = $("#askform");
	var theButton = $("#formsubmit");

	$(theForm).validate({
	    ignore: '', // ignore hidden fields
	    errorClass: 'validation-error-label',
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

	    	if (typeelement == "radio") {

	    		error.insertAfter($(element).parent().parent().parent().parent().parent());

	    	} else if( $(element).attr("name") == "g-recaptcha-response" ) {
	    		error.insertAfter($(element).parent());
	    	} else {
	        	error.insertAfter(element);
	    	}
	    },
	    rules: {
	        email: {
	            email: true
	        },
	        "g-recaptcha-response": {
	        	required: true
	        }
	    },
	    messages: {
	    	name: "Anda harus mengisi nama lengkap anda",
	    	email : {
	    		required: "Anda harus mengisi alamat email anda",
	    		email: "Alamat email anda tidak sesuai format"
	    	},
	    	question: "Anda harus mengisi pertanyaan",
	    	"g-recaptcha-response" : "Pastikan anda bukan robot"
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
			$(theButton).html('SEND');

			console.log(data.msg);

            if(data.code==200){
				openPopup("popup-terkirim");
				grecaptcha.reset();
            }else {
				grecaptcha.reset();
            }
        },
        complete: function(xhr) {
			// grecaptcha.reset()
        	$(theButton).prop('disabled',false);
			$(theButton).html('SEND');
        },
        error: function(xhr) {
			grecaptcha.reset();
			$(theButton).prop('disabled',false);
			$(theButton).html('SEND');
        }
    })

	$grid_layout = $('.questionanswers').masonry({
        itemSelector: '.questionanswer-box',
        columnWidth: '.answer-resize',
        gutter: '.gutter-sizer',
        percentPosition: true,
        stagger: 30
    });

    var buttonload = $("#buttonload");
    var containeranswer = $(".questionanswers");

    var current_page;
	var next_url = baseurl+'ask/get_answer';

	get_answer(buttonload,containeranswer);

	$(buttonload).click(function() {
		get_answer(this,containeranswer);
	})

    function get_answer(button,container) {
		$.ajax({
		    url     : next_url,
		    type    : $(this).attr('method'),
		    dataType: 'json',
		    //data    : $(this).serialize(),
		    // contentType: false,
		    // cache: false,
		    // processData:false,
		    beforeSend: function() {
		    	$(button).prop('disabled',true);
		    	$(button).html('<i class="fa fa-spinner fa-spin"></i>');
		    },
		    success : function(data) {
		    	$(button).prop('disabled',false);
		    	$(button).html('Lihat Semua Artikel');

		    	if (data.page != current_page) {
		    		current_page = data.page;
		    		var items = data.data;

					$.each(items, function(index,value) {
						var $item = $(value);
			        	$grid_layout.append($item).masonry('appended',$item);
						// $grid_layout.masonry();
					})
					next_url = data.next_url;
		    	} else {

		    	}

				console.log("page: "+current_page);
				
		    },
		    error   : function( xhr, err ) {
		    	$(button).prop('disabled',false);
		    	$(button).html('Lihat Semua Artikel');
		    }
		});
	}

})

function expand_answer(button) {
	var container = $(button).parent();

	container.toggleClass("expand");
	$grid_layout.masonry();
}

</script>

