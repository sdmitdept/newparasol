<div class="section mobile-spot-section">
	<div class="container">
		<div class="row top-spotmobile">
            <p>Find all the beauty spot in Indonesia & know their skin danger level</p>
		</div>
<!--        <div class="row">
            <div class="form-group">
                <div class="search-box-cont">
                    <img src="<?php echo base_url('assets/images/ic-place.png') ?>">
                    <input type="text" class="spot-search" placeholder="Find Destination">
                </div>
            </div>
        </div> -->
	</div>

    <div class="container">
        <?php foreach ($spots as $key => $value) { ?>
        <div class="row mobileplacerow">
            <div class="top" style="background-image:url('<?php echo base_url('uploads/places/r/600x300-'.$value->picture) ?>')">
                <h1 class="tipTemp"><img src="<?php echo base_url('assets/images/w-sunny.png') ?>"><span><?php echo number_format($value->temp,0) ?></span>°C</h1>
                <div class="tipPlace">
                    <h2><?php echo $value->name ?></h2>
                    <span class="small"><?php echo $value->city ?></span>
                </div>
                <div class="tipDetail">
                    <div class="table-container">
                        <div class="inner">
                            <b>VERY HOT</b>
                        </div>
                        <div class="inner">
                            SPF <span class="large"><?php echo $value->spf ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    
    </div>

</div>