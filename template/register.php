<p class="aa-form-info"></p>
<form action="" method="POST" role="form" id="aa-register-form" class="aa-form">
	<input type="hidden" name="action" value="reg_user">
	<div class="form-row ">
		<div class="col-6">
			
			<input type="text" name="aa_name"  id="aa_name" placeholder="<?php _e( 'First Name', 'ajax-autorizer' ); ?>">
		</div>

		<div class="col-6">
			<input type="text" name="aa_last_name" id="aa_last_name" placeholder="<?php _e( 'Last Name', 'ajax-autorizer' ); ?>">
		</div>
	</div>
	<div class="form-row">

	
		<div class="col-6">

			<input type="email" name="aa_email"  id="aa_email" placeholder="<?php _e( 'E-mail', 'ajax-autorizer' ); ?>">
		</div>
		<div class="col-6">
			<input type="password" name="aa_password"  id="aa_rpassword" placeholder="<?php _e('Password', 'ajax-autorizer' ); ?>">
		</div>
	</div>	
	<div class="form-row">
		<div class="col-6 " style="margin-left: 36%;">
			<p>
				<input type="checkbox" name="aa_investors" class="" id="aa_investors" value="1"> <label for="aa_investors"><?php _e('Investor', 'ajax-autorizer' ); ?></label>
			</p>
		<p>
				<input type="checkbox" name="aa_an_investor" class="" id="aa_an_investor" value="1"> <label for="aa_an_investor"><?php _e('I am an investor', 'ajax-autorizer' ); ?></label>
		</p>
		</div>

	</div>	
	<hr>
	<div class="form-row ">
		<div class="col-12 text-center">
			<button type="submit" class="btn-submit"><?php _e('Register','ajax-autorizer') ?></button>
		</div>
	</div>
</form>