<div class="section header-section header-slider">
	<div class="home-slider">
	<?php foreach ($slide_data as $key => $value): ?>
		<div class="slideritem" style="background-image:url('<?php echo base_url('uploads/slider/bg/'.$value->background) ?>')">
			<div class="container slide-container">
				<div class="table-container">
					<div class="inner left-slider">
						<h1><?php echo $value->title ?></h1>
						<p class="desc"><?php echo $value->desc ?></p>
						<a href="<?php echo base_url($value->link);  ?>"><img src="<?php echo base_url('assets/images/btn-selengkapnya.png') ?>" alt="" class="btn-image"></a>
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
<div class="section" id="video">
	<div class="container">
		<div class="col-md-8" >
			<div class="youtubelargeview mb-4">
                <div id="player"></div>
            </div>
            <div class="thumbnailvideo row ">
                <div class="carousel">
                    <div class="col-xs-3 thumb_video thumb_video_1">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/7_8kSPYCDc8/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                    <div class="col-xs-3 thumb_video thumb_video_2">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/z-U47zaIT5w/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                    <div class="col-xs-3 thumb_video thumb_video_3">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/EV462hyL9OQ/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                    <div class="col-xs-3 thumb_video thumb_video_4">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/jHX_a-cwkgw/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                    <div class="col-xs-3 thumb_video thumb_video_5">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/UDvNkQ5f0_c/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                    <div class="col-xs-3 thumb_video thumb_video_6">
                        <img style="width: 100%;" class="img-fluid" src="http://i3.ytimg.com/vi/yahr3NeQfl8/maxresdefault.jpg" />
                        <div class="playbutton"><img src="<?php echo base_url('assets/images/playbutton.png') ?>" /></div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-4">
			<div class="header1">STAY COOL</div>
            <div class="header2">WITH</div>
            <div class="header3" style="border-bottom: 1px solid #f7941e;">SUNSHINE</div>
            <div class="descvideo" >
                Ekspresi bebas kulit sehat<br />
                Terlindung dari efek buruk<br />
                Sinar Matahari

            </div>
		</div>
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
<style>
     .slick-next {
        right: 10px;
        background: rgb(243, 243, 243) !important;
        border-radius: 7px;
    }
    
    .slick-prev {
        left: 10px;
        z-index: 2;
        background: rgb(243, 243, 243) !important;
        border-radius: 7px;
    }
    

    .slick-prev:before,
    .slick-next:before {
        color: rgb(0, 0, 0);
    }
</style>
<script>
    $(document).ready(function(){
        $('.carousel').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            dots:true,
        });
    });
</script>
<script>
$(document).ready(function() {
	$(".home-slider").slick({
		arrows: false,
		autoplay: true
	})
    $(".thumb_video_1").click(function(){
        video1();
    })
    $(".thumb_video_2").click(function(){
        video2();
    })
    $(".thumb_video_3").click(function(){
        video3();
    })
    $(".thumb_video_4").click(function(){
        video4();
    })
    $(".thumb_video_5").click(function(){
        video5();
    })
    $(".thumb_video_6").click(function(){
        video6();
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
<script>

      // 1. This code loads the IFrame Player API code asynchronously.
      var video = 1;
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 2. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          width: '100%',
          playerVars: {
                'autoplay': 1,
                'controls': 1,
                'rel' : 0,
                'fs' : 0,
            },
          videoId: '7_8kSPYCDc8',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 3. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        player.stopVideo();
        //event.target.playVideo();
        $(".thumb_video").removeClass("active");
        $(".thumb_video_1").addClass("active");
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        event.target.mute();
        }
      }
       
      var done = false;
      function onPlayerStateChange(event) {
        
      }
      function stopVideo() {
        player.stopVideo();
      }
      
      
    function onPlayerStateChange(event) {
        if (event.data == YT.PlayerState.ENDED) {
            video++;
            if (video == 6){
                video = 1;
            }
            if (video == 1){
                video1(); 
            }
            if (video == 2){
                video2();   
            }
            if (video == 3){
                video3();
            }
            if (video == 4){
                video4();
            }
            if (video == 5){
                video5();
            }
	    if (video == 6){
		video6();
	    }
        }
        if (event.data == YT.PlayerState.PLAYING){
        }
    }
    function video1(){
        player.loadVideoById("7_8kSPYCDc8");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_1").addClass("active");
    }
    function video2(){
        player.loadVideoById("z-U47zaIT5w");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_2").addClass("active");
    }
    function video3(){
        player.loadVideoById("EV462hyL9OQ");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_3").addClass("active");
    }
    function video4(){
        player.loadVideoById("jHX_a-cwkgw");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_4").addClass("active");
    }
    function video5(){
        player.loadVideoById("UDvNkQ5f0_c");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_5").addClass("active");
        
    }
    function video6(){
        player.loadVideoById("yahr3NeQfl8");
        $(".thumb_video").removeClass("active");
        $(".thumb_video_6").addClass("active");
    }
</script>


