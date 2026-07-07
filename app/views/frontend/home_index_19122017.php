<div class="section header-section header-slider">
	<div class="home-slider">
	<?php foreach ($slide_data as $key => $value): ?>
		<div class="slideritem" style="background-image:url('<?php echo base_url('uploads/slider/bg/'.$value->background) ?>')">
			<div class="container slide-container">
				<div class="table-container">
					<div class="inner left-slider">
						<h1><?php echo $value->title ?></h1>
						<p class="desc"><?php echo $value->desc ?></p>
						<a href="<?php echo $value->link ?>"><img src="<?php echo base_url('assets/images/btn-selengkapnya.png') ?>" alt="" class="btn-image"></a>
					</div>
					<div class="inner right-slider">
					<?php if (!empty($value->image)): ?>
						<img src="<?php echo base_url('uploads/slider/img/'.$value->image) ?>" alt="parasol" class="">
					<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach ?>
	</div>
	<div class="top-curved">
		<img src="<?php echo base_url('assets/images/garisa.png') ?>" alt="">
	</div>
</div>
<div class="section">
	<div class="container">
		<div class="home-featured-place">
			<div class="place-overlay">
				<div class="bg-blur"></div>
				<div class="place-overlay-container">
					<img src="<?php echo base_url('assets/images/mark.png') ?>" alt="">
					<h1>
						SKIN ALERT <br>
						<b>BEAUTY SPOT</b>
					</h1>
					<p>Find all the beauty spot in Indonesia & know their skin danger level</p>
					<a href="<?php echo base_url('spot') ?>"><img class="btn-image" src="<?php echo base_url('assets/images/btn-explore.png') ?>" alt=""></a>	
				</div>
			</div>
			
		</div>
	</div>
</div>
<div class="section">
	<div class="container">
		<div class="col-md-6">
			<h1 class="section-title section-orange">Sun <b>Facts</b></b></h1>
			<div class="home-box left-box">
				<div class="table-container">
					<div class="inner">
						<h1>MAKE FRIENDS <br> WITH THE SUN</h1>
						<a href="<?php echo base_url('facts') ?>"><img src="<?php echo base_url('assets/images/btn-selengkapnya.png') ?>" alt="" class="btn-image"></a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<h1 class="section-title section-orange">Ask <b>Expert</b></h1>
			<div class="home-box right-box">
				<div class="table-container">
					<div class="inner">
						<h1>SKIN PROTECTION <br><span class="light">EXPERT</span></h1>
						<a href="<?php echo base_url('ask') ?>"><img src="<?php echo base_url('assets/images/btn-ask.png') ?>" alt="" class="btn-image"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section featured-home-artikel">
	<div class="container">
		<h1 class="section-title">Latest <b>Articles</b></h1>
	</div>
	<div class="container home-3">
	<?php foreach ($latest_articles as $key => $value) { ?>
		<div class="home-box-3" style="background-image:url('<?php echo base_url('uploads/articles/r/600x300-'.$value->featured_image) ?>')">
			<div class="table-container">
				<div class="inner">
					<h1><?php echo $value->title ?></h1>
					<a href="<?php echo base_url('articles/detail/'.$value->article_id) ?>"><button class="btn btn-white">Baca Selengkapnya</button></a>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
	<div class="container moreartikel">
		<a href="<?php echo base_url('articles') ?>"><img src="<?php echo base_url('assets/images/btn-semua.png') ?>" alt="" class="btn-image"></a>
	</div>
</div>

<script>
$(document).ready(function() {
	$(".home-slider").slick({
		arrows: false
	})

	$('.home-3').slick({
		dots: false,
		infinite: false,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: false,
	  responsive: [
	    {
	      breakpoint: 1024,
	      settings: 'unslick'
	    },
	    {
	      breakpoint: 761,
	      settings: {
	      	settings: 'unslick'
	      }
	    },
	    {
	      breakpoint: 600,
	      settings: {
	        slidesToShow: 2,
	        slidesToScroll: 1,
	        centerMode: true,
	        initialSlide: 1
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 1,
	        slidesToScroll: 1,
	        centerMode: true
	      }
	    },
	    // You can unslick at a given breakpoint now by adding:
	    // settings: "unslick"
	    // instead of a settings object
	  ]
	});

})
</script>