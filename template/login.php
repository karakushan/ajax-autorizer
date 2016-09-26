<p class="aa-form-info"></p>
<form action="" method="POST" role="form" id="aa-login-form" class="aa-form">
	<input type="hidden" name="action" value="aa_login">
	<div class="form-row">
		<div class="col-12">
			
			<input type="text" name="aa_username"  id="aa_username" placeholder="<?php _e( 'Username or email', 'ajax-autorizer' ); ?>">
		</div>
	</div>	
	<div class="form-row">
		<div class="col-12">
			<input type="password" name="aa_password"  id="aa_password" placeholder="<?php _e('Password', 'ajax-autorizer' ); ?>">
		</div>

		
	</div>
	<div class="form-row text-center">
		<a href="<?php echo wp_lostpassword_url(); ?>" title="Забыли пароль?">Забыли пароль?</a> | 
		<a href="<?php echo wp_registration_url(); ?>" title="Зарегистрироваться">Регистрация</a> 
	</div>
	<div class="form-row ">
		<div class="col-12 text-center">
			<button type="submit" class="btn-submit"><?php _e('Login','ajax-autorizer') ?></button>
		</div>
	</div>
</form>