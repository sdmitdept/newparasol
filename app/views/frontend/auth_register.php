	<form id="form-register" method="post" action="<?php echo base_url('auth/register_process'); ?>">

	<div class="box-register">
		<div class="head">REGISTER</div>
		<div class="body">
			
			<?php if(!empty($msg)): ?>
			<?php echo $msg; ?>
			<?php endif; ?>

				<div>
					<label>Email<span>*</span></label>
					<input type="text" name="email" required />
				</div>

				<div>
					<label>Username<span>*</span></label>
					<input type="text" name="username" minlength="6" maxlength="20" required />
					<p>Alphanumeric min 6 max 20 character</p>
				</div>

				<div>
					<label>Name<span>*</span></label>
					<input type="text" name="name" minlength="2" maxlength="35" required />
					<p></p>
				</div>

				<div>
					<label>Password<span>*</span></label>
					<input type="password" name="password" minlength="6" required />
					<p>Min 6 character</p>
				</div>

				<div class="btn-register2-wrap">
					<input class="btn-register2" type="submit" value="register">
				</div>
				
				<label><span>* required field (harus diisi)</span></label>

		</div>
	</div>

	</form>