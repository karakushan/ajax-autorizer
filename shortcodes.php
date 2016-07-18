<?php 
add_shortcode('aa_login','aa_login');
add_shortcode('aa_register','aa_register');
function aa_login($value='')
{
	if (is_user_logged_in()) {
		return '<p class="aa_user_looged">Вы уже вошли на сайт. Авторизация не требуется. <a href="'.wp_logout_url($_SERVER['REQUEST_URI']).'" title="Выход">Выход</a></p>';
	}
	
	$login_template=plugin_dir_path( __FILE__ ).'template/login.php';

	if (file_exists($login_template)) {
		require_once ($login_template);
	}else{
		return "Файл шаблона формы входа не найден!";
	}
}
function aa_register($value='')
{
	if (is_user_logged_in()) {
		return '<p class="aa_user_looged">Вы уже вошли на сайт. Регистрация не требуется. <a href="'.wp_logout_url($_SERVER['REQUEST_URI']).'" title="Выход">Выход</a></p>';
	}
	$register_template=plugin_dir_path( __FILE__ ).'template/register.php';
	if (file_exists($register_template)) {
		require_once ($register_template);
	}else{
		return "Файл шаблона формы регистраиции не найден!";
	}
}

?>