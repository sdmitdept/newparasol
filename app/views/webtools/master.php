<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>WebTools</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <link rel="stylesheet" href="<?php echo assets_url('libs/bootstrap/css/bootstrap.min.css'); ?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo assets_url('libs/font-awesome/css/font-awesome.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo assets_url('libs/ionicons/css/ionicons.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo assets_url('libs/adminlte/css/AdminLTE.min.css'); ?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo assets_url('libs/adminlte/css/skins/skin-blue.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo assets_url('libs/adminlte/plugins/iCheck/flat/blue.css'); ?>">
        
        <?php echo $styles; ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	
		<!-- jQuery 2.1.4 -->
        <script src="<?php echo assets_url('libs/adminlte/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>P</b>A</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Parasol</b> Admin</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					    <span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li>
								<a href="<?php echo site_url('webtools/auth/logout'); ?>"><i class="fa fa-power-off"></i> logout</a>
							</li>
						</ul>
					</div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>
						<li>
							<a href="<?php echo site_url('webtools/dashboard'); ?>">
								<i class="fa fa-th"></i> <span>Dashboard</span>
							</a>
						</li>

						<li class="treeview <?php echo $this->router->class=='slider' ? 'active' : ''; ?>">
							<a href="<?php echo site_url('webtools/slider'); ?>">
								<i class="fa fa-user-secret"></i>
								<span>Slider</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->router->class=='slider' && $this->router->method=='add'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/slider/add'); ?>"><i class="fa fa-circle-o"></i> Add</a>
								</li>
								<li class="<?php echo $this->router->class=='slider' && $this->router->method=='index'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/slider/index'); ?>"><i class="fa fa-circle-o"></i> List</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php echo $this->router->class=='articles' ? 'active' : ''; ?>">
							<a href="<?php echo site_url('webtools/articles'); ?>">
								<i class="fa fa-user-secret"></i>
								<span>Articles & Promo</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->router->class=='articles' && $this->router->method=='add'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/articles/add'); ?>"><i class="fa fa-circle-o"></i> Add</a>
								</li>
								<li class="<?php echo $this->router->class=='articles' && $this->router->method=='index'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/articles/index'); ?>"><i class="fa fa-circle-o"></i> List</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php echo $this->router->class=='spot' ? 'active' : ''; ?>">
							<a href="<?php echo site_url('webtools/questions'); ?>">
								<i class="fa fa-user-secret"></i>
								<span>Beauty Spot</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->router->class=='spot' && $this->router->method=='add'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/spot/add'); ?>"><i class="fa fa-circle-o"></i> Add</a>
								</li>
								<li class="<?php echo $this->router->class=='spot' && $this->router->method=='index'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/spot'); ?>"><i class="fa fa-circle-o"></i> List</a>
								</li>
							</ul>
						</li>

						<li class="treeview <?php echo $this->router->class=='questions' ? 'active' : ''; ?>">
							<a href="<?php echo site_url('webtools/questions'); ?>">
								<i class="fa fa-user-secret"></i>
								<span>Questions</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->router->class=='questions' && $this->router->method=='index'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/questions'); ?>"><i class="fa fa-circle-o"></i> List</a>
								</li>
								<li class="<?php echo $this->router->class=='questions' && $this->router->method=='answered'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/questions/answered'); ?>"><i class="fa fa-circle-o"></i> Answered</a>
								</li>
							</ul>
						</li>
						
						<?php if($user->group!=3): ?>
						
						<li class="treeview <?php echo $this->router->class=='admin' ? 'active' : ''; ?>">
							<a href="<?php echo site_url('webtools/admin'); ?>">
								<i class="fa fa-user-secret"></i>
								<span>Admin</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li class="<?php echo $this->router->class=='admin' && $this->router->method=='index'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/admin'); ?>"><i class="fa fa-circle-o"></i> List</a>
								</li>
								<li class="<?php echo $this->router->class=='admin' && $this->router->method=='add'  ? 'active' : ''; ?>">
									<a href="<?php echo site_url('webtools/admin/add'); ?>"><i class="fa fa-circle-o"></i> Add new</a>
								</li>
							</ul>
						</li>
						
						<?php endif; ?>

					</ul>
				</section>
				<!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
				<!-- Content Header (Page header) -->
				
				<section class="content-header">
					<h1><?php echo $page_title; ?> <small><?php echo $page_subtitle; ?></small></h1>
				</section>


				<!-- Main content -->
				<section class="content">
					<div class="row">
						<?php echo $content; ?>
					</div>
				</section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            
            <!--
            <footer class="main-footer">
              <div class="pull-right hidden-xs">
                <b>Version</b> 2.3.0
              </div>
              <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
            </footer>
              -->

            
        </div><!-- ./wrapper -->
        
        <!-- jQuery UI 1.11.4 -->
        <script src="<?php echo assets_url('libs/adminlte/plugins/jQueryUI/jquery-ui.min.js'); ?>"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo assets_url('libs/bootstrap/js/bootstrap.min.js'); ?>"></script>
        
        <!-- Slimscroll -->
        <script src="<?php echo assets_url('libs/adminlte/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    	<script src="<?php echo base_url(); ?>assets/libs/jquery.form/jquery.form.min.js"></script>
    	<script src="<?php echo base_url(); ?>assets/libs/jquery-validation/jquery.validate.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo assets_url('libs/adminlte/plugins/fastclick/fastclick.min.js'); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo assets_url('libs/adminlte/js/app.min.js'); ?>"></script>
        <script src="<?php echo assets_url('libs/tinymce/jquery.tinymce.min.js'); ?>"></script>
        <script src="<?php echo assets_url('libs/tinymce/tinymce.min.js'); ?>"></script>
        <script src="<?php echo assets_url('js/webtools.js'); ?>"></script>

        <script type="text/javascript">
        var baseurl = '<?php echo base_url(); ?>';
        </script>

        <?php echo $scripts; ?>
        
    </body>
</html>