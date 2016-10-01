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

	$user_pass=filter_input(INPUT_GET,'aa_password',FILTER_SANITIZE_SPECIAL_CHARS);
	$first_name=filter_input(INPUT_GET,'aa_name',FILTER_SANITIZE_SPECIAL_CHARS);
	$last_name=filter_input(INPUT_GET,'aa_last_name',FILTER_SANITIZE_SPECIAL_CHARS);
	$user_email=sanitize_email($_REQUEST['aa_email']);
	
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
		echo "true";
	} else {
		echo $user_id->get_error_message();
	} 
	exit();
}

// Аякс вход пользователя
add_action('wp_ajax_aa_login', 'aa_login_user');
add_action('wp_ajax_nopriv_aa_login', 'aa_login_user');
function aa_login_user()
{
	$username = $_REQUEST['aa_username'];
	$password = $_REQUEST['aa_password'];

	if (is_email($username) ) {
		if (email_exists($username)) {
			$user=get_user_by('email',$username);
			$username=$user->user_login;

		}else{
			echo json_encode(array('status'=>0,'redirect'=>false,'error'=>'К сожалению пользователя с таким email не существует на сайте'));
			exit;
		}
	}else{
		if (!username_exists($username)) {
			echo json_encode(array('status'=>0,'redirect'=>false,'error'=>'К сожалению такого пользователя не существует на сайте'));
			exit;
		}
	}
	
// Авторизуем
	$auth = wp_authenticate( $username, $password );
    $user_data=get_userdata($auth->ID);

    $aa_auth=get_option('aa_auth');
    $redirect=empty($aa_auth['success_redirect'])?'':esc_url($aa_auth['success_redirect']);

    $redirect_role=empty($aa_auth['redirect_role'])?'all_users':$aa_auth['redirect_role'];
    $role=wp_roles()->roles[$redirect_role]['name'];//получаем название допущенной роли на текущем языке



// Проверка ошибок
	if ( is_wp_error( $auth ) ) {
		echo json_encode(array('status'=>0,'redirect'=>false,'error'=>$auth->get_error_message()));
		exit;
	}
	else {
        //если разрешён вход для одного типа пользователей
        if ($aa_auth['block_form']==1 && !in_array($redirect_role, $user_data->roles)){

            echo json_encode(array('status'=>0,'redirect'=>false,'error'=>'Вы не входите в категорию пользователей "'.$role.'"'));
            exit;
        }

		nocache_headers();
		wp_clear_auth_cookie();
		wp_set_auth_cookie( $auth->ID );


		if ($redirect_role=='all_users' || in_array($redirect_role, $user_data->roles)) {
			echo json_encode(array('status'=>1,'redirect'=>$redirect));
		}else{
			echo json_encode(array('status'=>1,'redirect'=>false));
		}
		exit;
	}
}