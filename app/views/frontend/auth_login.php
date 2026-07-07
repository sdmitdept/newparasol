<a class="btn-login" href="<?php echo $fb_login_url; ?>">Facebook Connect</a>
<a class="btn-login" href="<?php echo $tw_login_url; ?>">Twitter Connect</a>

<p>Login dengan email/username</p>

			<?php if(!empty($msg)): ?>
				<p style="margin: 20px 0;"><?php echo $msg; ?></p>
			<?php endif; ?>

<form action="<?php echo site_url('auth/login_process'); ?>" method="POST">
	<p><input type="text" name="token" placeholder="email/username"></p>
	<p><input type="password" name="password" placeholder="password"></p>
	<p><input type="submit"></p>
</form>