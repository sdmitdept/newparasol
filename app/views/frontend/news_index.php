<div class="section header-section">
	<div class="page-header-container" style="background-image:url('<?php echo base_url('assets/images/head-news.jpg') ?>')">
		<div class="page-head-content">
			<div class="container">
				<div class="page-head-area">
					<h1>NEWS<br>
					<b>PROMO</b></h1>
				</div>
			</div>
			<div class="head-line"></div>
			
		</div>
	</div>
	<div class="top-curved">
		<img src="<?php echo base_url('assets/images/garisa.png') ?>" alt="">
	</div>
</div>

<div class="section news-container">
	<div class="container artikelcontainer">
		
	</div>
	<div class="container">
		<div class="row moreartikel">
			<button class="btn btn-green" id="morebutton">Lihat Semua Artikel</button>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	var current_page;
	var next_url = baseurl+'news/get_article';

	$("#morebutton").click(function() {
		if (next_url != "") {
			get_artikel(this,".artikelcontainer");
		} else {
			
		}
	})

	get_artikel('#morebutton','.artikelcontainer');

	function get_artikel(button,container) {
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
			        	$(container).append($item);
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
</script>