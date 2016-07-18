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

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'functions.php';
require_once 'shortcodes.php';

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

?>