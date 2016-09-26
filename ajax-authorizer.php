<?php 
/*
Plugin Name: Ajax Autorizer
Plugin URI: http://profglobal.ru/
Description: Ajax autorizer - бесплатный плагин для регистрации, входа пользователей на Wordpress
Version: 1.0.0
Author: Vitaliy Karakushan
Author URI: http://profglobal.ru/
License: GPLv2 or later
Text Domain: ajax-autorizer
*/

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once 'functions.php';
require_once 'shortcodes.php';

//Начало формы админ меню
if (count($_POST)) {
	if (isset($_POST['aa_auth_sub'])) {
		update_option('aa_auth',$_POST['aa_auth']);
	}
}
add_action('admin_menu', 'aa_auth_admin_menu');
//Регистрирует страницу настроек в меню "Настройки"
function aa_auth_admin_menu(){
	add_options_page("Ajax Authorizer", "Ajax Authorizer", 8, "aa_auth", "aa_auth_options_page");
}
//Выводит html код страницы настроек плагина
function aa_auth_options_page(){
	$aa_auth=get_option('aa_auth');
	$roles=wp_roles();
	/*echo "<pre>";
	print_r(wp_get_current_user());
	echo "</pre>";*/

	echo '<div class="wrap">';
	echo "<h2>Ajax Authorizer Options</h2>"; ?>
	<form action="<?php esc_url($_SERVER['REQUEST_URI']) ?>" method="post" class="">
		<p>	
			<label>Ссылка переадресации при удачной авторизации:</label><br>
			<input type="text" name="aa_auth[success_redirect]" value="<?=$aa_auth['success_redirect']?>">
		</p>
		<p>	
			<label>Использовать переадресацию для ролей:</label><br>
			<select name="aa_auth[redirect_role]">
				<option value="all_users">Все пользователи</option>
				<?php if ($roles): ?>
					<?php foreach ($roles->role_names as $key => $role): ?>
						<option value="<?php echo $key ?>" <?php selected($key,$aa_auth['redirect_role']) ?>><?php echo $role ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
		</p>
		<p><input type="submit" name="aa_auth_sub" class="button button-primary button-large" value="Сохранить"></p>
		
	</form>
	<? echo '</div>';
}
//Конец формы админ меню





function aa_scripts_styles() {

	$locale=substr(get_locale(),0,2);
	wp_enqueue_script( 'jquery-validation', plugin_dir_url( __FILE__ ).'node_modules/jquery-validation/dist/jquery.validate.js', array( 'jquery' ), false, false);
	wp_enqueue_script( 'validation-messages', plugin_dir_url( __FILE__ ).'node_modules/jquery-validation/dist/localization/messages_'.$locale.'.js', array( 'jquery' ), false, false);
	wp_localize_script('jquery-validation', 'aa_ajax', 
		array(
			'url' => admin_url('admin-ajax.php')
			)
		);
	wp_enqueue_script( 'ajax-authorizer', plugin_dir_url( __FILE__ ).'js/ajax-authorizer.js', array( 'jquery','jquery-validation' ), false, false);
	wp_enqueue_style('ajax-authorizer',plugin_dir_url( __FILE__ ).'css/ajax-authorize.css');
}

add_action( 'wp_enqueue_scripts', 'aa_scripts_styles' );

add_action('init', 'aa_textdomain');
function aa_textdomain() {
	load_textdomain('ajax-autorizer',dirname(__FILE__).'/languages/ajax-autorizer-'.get_locale().'.mo');
}

