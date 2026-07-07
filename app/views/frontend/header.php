<div class="navbar desktoponly">
	<div class="container">
		<div class="menu-container">
			<div class="menu-left logo-container">
				<img src="<?php echo base_url('assets/images/logo-parasol.png') ?>" alt="parasol">
			</div>
			<div class="menu-left">
				<ul class="mainmenu">
					<li><a class="bold-hover <?php echo $this->router->class=='home' ? 'active' : ''; ?>" href="<?php echo base_url('') ?>">Home</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='about' ? 'active' : ''; ?>" href="<?php echo base_url('about') ?>">About</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='products' ? 'active' : ''; ?>" href="<?php echo base_url('products') ?>">Products</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='facts' ? 'active' : ''; ?>" href="<?php echo base_url('facts') ?>">Sun Facts</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='articles' ? 'active' : ''; ?>" href="<?php echo base_url('articles') ?>">Articles</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='news' ? 'active' : ''; ?>" href="<?php echo base_url('news') ?>">News & Promo</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='spot' ? 'active' : ''; ?>" href="<?php echo base_url('spot') ?>">Beauty Spot</a></li>
					<li><a class="bold-hover <?php echo $this->router->class=='ask' ? 'active' : ''; ?>" href="<?php echo base_url('ask') ?>">Ask Expert</a></li>
				</ul>
			</div>
			<div class="menu-right">
				<ul class="social-icon">
					<li><a target="_BLANK" href="https://www.facebook.com/parasolindonesia/"><i class="fa fa-facebook"></i></a></li>
					<li><a target="_BLANK" href="https://twitter.com/Parasol_ID"><i class="fa fa-twitter"></i></a></li>
					<li><a target="_BLANK" href="https://www.instagram.com/parasolindonesia/"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="navbar-mobile mobileonly ">
	<a href="<?php echo base_url('') ?>"><img src="<?php echo base_url('assets/images/logo-parasol.png') ?>" alt=""></a>
	<img class="openmobilemenu" src="<?php echo base_url('assets/images/menu.png') ?>" alt="">
</div>