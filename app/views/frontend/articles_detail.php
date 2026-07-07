<div class="section header-section desktoponly">
	<div class="page-header-container" style="background-image:url('<?php echo base_url('uploads/articles/'.$article_data->header_image) ?>')">
		<div class="page-head-content">
			<div class="container">
				<div class="page-head-area">
					<h1><b><?php echo $article_data->title ?></b></h1>
				</div>
			</div>
			<div class="head-line"></div>
			
		</div>
	</div>
	<div class="top-curved">
		<img src="<?php echo base_url('assets/images/garisb.png') ?>" alt="">
	</div>
</div>

<div class="section header-section mobileonly">
	<div class="page-header-container" style="background-image:url('<?php echo base_url('uploads/articles/'.$article_data->header_image_m) ?>')">
		<div class="page-head-content">
			<div class="container">
				<div class="page-head-area">
					<h1><b><?php echo $article_data->title ?></b></h1>
				</div>
			</div>
			<div class="head-line"></div>
			
		</div>
	</div>
	<div class="top-curved">
		<img src="<?php echo base_url('assets/images/garisb.png') ?>" alt="">
	</div>
</div>

<div class="section article-detail-container">
	<div class="container">
		<div class="row article-item">
			<div class="col-md-8">
				<?php echo $article_data->content ?>
			</div>
			<div class="col-md-4">
				<!-- ads -->
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

})
</script>