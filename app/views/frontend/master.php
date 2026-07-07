<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-Frame-Options" content="deny"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta property="fb:app_id"      content="<?php echo $facebook_appid; ?>" /> 
    <meta property="og:url"         content="<?php echo current_url() ?>" />
    <meta property="og:type"        content="article" />
    <meta property="og:title"       content="<?php echo (isset($meta_title_custom)) ? $meta_title_custom:$meta_title ?>" />
    <meta property="og:description" content="<?php echo (isset($meta_desc_custom)) ? $meta_desc_custom:$meta_description ?>" />
    <meta property="og:image"       content="<?php echo (isset($meta_image)) ? $meta_image:base_url('assets/images/default.jpg') ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="<?php echo base_url() ?>" />
    <meta name="twitter:site" content="<?php echo (isset($meta_title_custom)) ? $meta_title_custom:$meta_title ?>" />
    <meta name="twitter:title" content="<?php echo (isset($meta_title_custom)) ? $meta_title_custom:$meta_title ?>" />
    <meta name="twitter:image" content="<?php echo (isset($meta_image)) ? $meta_image:base_url('assets/images/default.jpg') ?>" />
    <meta name="twitter:description" content="<?php echo (isset($meta_desc_custom)) ? $meta_desc_custom:$meta_description ?>">

    <title><?php echo isset($meta_title_custom) ? $meta_title_custom : $meta_title; ?></title>
    <meta name="description" content="<?php echo (isset($meta_desc_custom)) ? $meta_desc_custom:$meta_description ?>"/>
    <meta name="keywords" content="<?php echo isset($meta_keywords) ? $meta_keywords : ''; ?>"/>

    <link href="<?php echo base_url(); ?>assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(); ?>assets/libs/slidebars/slidebars.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(); ?>assets/libs/slick/slick.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(); ?>assets/libs/slick/slick-theme.css" rel="stylesheet" type="text/css" media="all">

    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo base_url(); ?>assets/css/style-mobile.css" rel="stylesheet" type="text/css" media="all">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo-parasol.png">
    <?php echo $styles; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- ANTI CLICKJACK -->
    <style id="antiClickjack">body{display:none !important;}</style>

    <script src="<?php echo base_url(); ?>assets/libs/jquery-1.11.0.min.js"></script>

    <script>
    var baseurl = '<?php echo base_url(); ?>';
    </script>

    <script type="text/javascript">
    if (self === top) { var antiClickjack = document.getElementById("antiClickjack");antiClickjack.parentNode.removeChild(antiClickjack);} else {top.location = self.location;}
    </script>

    <?php
    /*
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-91244681-1', 'auto');
        ga('send', 'pageview');
    </script>
    */
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-55FDZRB1N7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-55FDZRB1N7');
    </script>

    <?php echo $scripts; ?>

</head>
<body>

    <div id="wrapper" canvas="container">
        <header>
            <?php   if (isset($header)) {
                echo $header;
            } else {
                $this->load->view('frontend/header');
            }
            ?>
        </header>
        <section id="body">
            <?php echo $content; ?>
        </section>
        <footer>
            <?php   if (isset($footer)) {
                echo $footer;
            } else {
                $this->load->view('frontend/footer');
            }
            ?>
        </footer>
    </div>

    <div class="mobilemenu-container" off-canvas="id-1 left overlay">
        <img src="<?php echo base_url('assets/images/mobiletop.jpg') ?>" alt="">
        <ul class="mobile-menu">
            <li><a class="<?php echo $this->router->class=='home' ? 'active' : ''; ?>" href="<?php echo base_url('') ?>">Home</a></li>
            <li><a class="<?php echo $this->router->class=='about' ? 'active' : ''; ?>" href="<?php echo base_url('about') ?>">About</a></li>
            <li><a class="<?php echo $this->router->class=='products' ? 'active' : ''; ?>" href="<?php echo base_url('products') ?>">Products</a></li>
            <li><a class="<?php echo $this->router->class=='facts' ? 'active' : ''; ?>" href="<?php echo base_url('facts') ?>">Sun Facts</a></li>
            <li><a class="<?php echo $this->router->class=='articles' ? 'active' : ''; ?>" href="<?php echo base_url('articles') ?>">Articles</a></li>
            <li><a class="<?php echo $this->router->class=='news' ? 'active' : ''; ?>" href="<?php echo base_url('news') ?>">News & Promo</a></li>
            <li><a class="<?php echo $this->router->class=='spot' ? 'active' : ''; ?>" href="<?php echo base_url('spot') ?>">Beauty Spot</a></li>
            <li><a class="<?php echo $this->router->class=='ask' ? 'active' : ''; ?>" href="<?php echo base_url('ask') ?>">Ask Expert</a></li>
        </ul>

        <div class="mobile-socmed">
            <a href="#" target="_BLANK"><i class="fa fa-facebook"></i></a> 
            <a href="#" target="_BLANK"><i class="fa fa-twitter"></i></a> 
            <a href="#" target="_BLANK"><i class="fa fa-instagram"></i></a> 
        </div>
    </div>
    
    <div id="popup-overlay"></div>
    <?php echo isset($popup) ? $popup : ''; ?>
    
    <div id="fb-root"></div>

    <script src="<?php echo base_url(); ?>assets/libs/slick/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/slidebars/slidebars.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery.form/jquery.form.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
      

    <?php echo isset($google_analytic) ? $google_analytic : ''; ?> 
    <div class="c-circle-menu js-menu">
      <button class="c-circle-menu__toggle js-menu-toggle">
        <span>Toggle</span>
      </button>
      <ul class="c-circle-menu__items">
        <li class="c-circle-menu__item">
          <a target="_blank" href="https://shopee.co.id/houseofdermaskincare" class="c-circle-menu__link">
            <img src="<?php echo base_url(); ?>assets/images/shopee.png" alt="">
          </a>
        </li>
        <li class="c-circle-menu__item">
          <a target="_blank" href="https://www.blibli.com/merchant/houseofdermaskincare/HOE-60039?page=1&start=0&pickupPointCode=&cnc=&multiCategory=true&sort=7" class="c-circle-menu__link">
            <img src="<?php echo base_url(); ?>assets/images/blibli.png" alt="">
          </a>
        </li>
        <li class="c-circle-menu__item">
          <a target="_blank" href="https://www.lazada.co.id/shop/house-of-derma-skin-care-sort-popularity/?spm=a2o4j.pdp.seller.1.45723612oH5U8h" class="c-circle-menu__link">
            <img src="<?php echo base_url(); ?>assets/images/lazada.png" alt="">
          </a>
        </li>
        <li class="c-circle-menu__item">
          <a target="_blank" href="https://www.tokopedia.com/parasol-melanox" class="c-circle-menu__link">
            <img src="<?php echo base_url(); ?>assets/images/tokopedia.png" alt="">
          </a>
        </li>
      </ul>
      <div class="c-circle-menu__mask js-menu-mask"></div>
    </div>
<link rel="stylesheet" href="<?php echo base_url('assets/css/circle-menu.css') ?>">
<script src="<?php echo base_url('assets/js/circleMenu.min.js') ?>"></script>
<script>
  var el = '.js-menu';
  var myMenu = cssCircleMenu(el);
</script>
</body>
</html>