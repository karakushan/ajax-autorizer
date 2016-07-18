<?php 
add_action('wp_ajax_check_user', 'aa_check_user');
add_action('wp_ajax_nopriv_check_user', 'aa_check_user');
function aa_check_user()
{
	switch ($_REQUEST['check']) {
		case '1':
		$username=sanitize_user($_REQUEST['aa_username'],false );
		if (username_exists( $username )) {
			echo "false";
		} else {
			echo "true";
		}
		break;		
		case '2':
		$user_email=sanitize_email($_REQUEST['aa_email']);
		if (is_email($user_email)) {
			if (email_exists( $user_email)) {
				echo "false";
			} else {
				echo "true";
			}
		}else{
			echo "false";
		}
		break;
		
		default:
		echo "false";
		break;
	}
	exit();
}

add_action('wp_ajax_reg_user', 'aa_reg_user');
add_action('wp_ajax_nopriv_reg_user', 'aa_reg_user');
function aa_reg_user()
{
	$investor=0;
	$an_investor=0;
	$user_pass=filter_input(INPUT_GET,'aa_password',FILTER_SANITIZE_SPECIAL_CHARS);
	$first_name=filter_input(INPUT_GET,'aa_name',FILTER_SANITIZE_SPECIAL_CHARS);
	$last_name=filter_input(INPUT_GET,'aa_last_name',FILTER_SANITIZE_SPECIAL_CHARS);
	$user_email=sanitize_email($_REQUEST['aa_email']);
	if (isset($_REQUEST['aa_investors'])) {
		$investor=(int)$_REQUEST['aa_investors'];
	}
	if (isset($_REQUEST['aa_an_investor'])) {
		$an_investor=(int)$_REQUEST['aa_an_investor'];
	}
	$userdata = array(
		'user_pass'       => $user_pass,
		'user_login'      => $user_email, 
		'user_email'      => $user_email,
		'display_name'    => $first_name,
		'first_name'      => $first_name,
		'last_name'       => $last_name,
		);

	$user_id=wp_insert_user( $userdata );
	if( ! is_wp_error( $user_id ) ) {
		add_user_meta( $user_id, '_investor', $investor, true );
		add_user_meta( $user_id, '_an_investor', $an_investor, true );
		echo "true";
	} else {
		echo $user_id->get_error_message();
	} 
	exit();
}

add_action('wp_ajax_aa_login', 'aa_login_user');
add_action('wp_ajax_nopriv_aa_login', 'aa_login_user');
function aa_login_user($value='')
{
	$username = $_REQUEST['aa_username'];
	$password = $_REQUEST['aa_password'];

	if (is_email($username) ) {
		if (email_exists($username)) {
			$user=get_user_by('email',$username);
			$username=$user->user_login;
		}
	}else{
		if (!username_exists($username)) {
			exit('false');
			return;
		}
	}
	
// Авторизуем
	$auth = wp_authenticate( $username, $password );

// Проверка ошибок
	if ( is_wp_error( $auth ) ) {
		exit('false');
	}
	else {
		nocache_headers();
		wp_clear_auth_cookie();
		wp_set_auth_cookie( $auth->ID );
		exit('true');
	}
}

?>