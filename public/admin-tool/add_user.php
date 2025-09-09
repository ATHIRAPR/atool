<?php
require_once ("include/init.php.inc");
require_once ("include/smarty.php.inc");
require_once ("include/db.php.inc");
require_once ("include/auth.php.inc");
require_once ("include/util.php.inc");
// 選択された左メニュー項目
$smarty->assign ( "func_info", array (
		"user" => 1 
) );
// ユーザ管理権限が無い場合は、エラーにする
if ($role_info ['user_role_flg'] != 1) {
	// エラーメッセージ表示
	show_error_page ( array (
			"ユーザ管理者の権限がありません" 
	), "manage.php", "トップページへ戻る" );
	exit ();
}
$rmm = new RoleMasterManager ();
$role_all = $rmm->get_all ();
foreach ( $role_all as $role ) {
	$role_options [$role ['id']] = $role ['role_nm'];
}
$smarty->assign ( "role_options", $role_options );
$status_options = array (
		0 => "休止",
		1 => "使用中" 
);
$smarty->assign ( "status_options", $status_options );
if ($_SERVER ['REQUEST_METHOD'] === "GET") {
	// ユーザ登録画面表示
	$smarty->display ( "add_user.tpl.html" );
	set_mb_encoding_output ();
} else if ($_SERVER ['REQUEST_METHOD'] === "POST") {
	// ユーザ新規登録処理
	$login_nm = $_POST ['login_nm'] = mb_convert_encoding ( $_POST ['login_nm'], "UTF-8", $OUTPUT_ENCODING );
	$password = $_POST ['password'] = mb_convert_encoding ( $_POST ['password'], "UTF-8", $OUTPUT_ENCODING );
	$role_id = $_POST ['role_id'] = mb_convert_encoding ( $_POST ['role_id'], "UTF-8", $OUTPUT_ENCODING );
	$status_flg = $_POST ['status_flg'] = mb_convert_encoding ( $_POST ['status_flg'], "UTF-8", $OUTPUT_ENCODING );
	$user_nm = $_POST ['user_nm'] = mb_convert_encoding ( $_POST ['user_nm'], "UTF-8", $OUTPUT_ENCODING );
	$department_nm = $_POST ['department_nm'] = mb_convert_encoding ( $_POST ['department_nm'], "UTF-8", $OUTPUT_ENCODING );
	$tel = $_POST ['tel'] = mb_convert_encoding ( $_POST ['tel'], "UTF-8", $OUTPUT_ENCODING );
	$email = $_POST ['email'] = mb_convert_encoding ( $_POST ['email'], "UTF-8", $OUTPUT_ENCODING );
	// 入力チェック、すべて必須
	if (! $login_nm) {
		$msg_array [] = "ログイン名が入力されていません";
	}
	if (! $password) {
		$msg_array [] = "パスワードが入力されていません";
	}
	if (! $user_nm) {
		$msg_array [] = "名前が入力されていません";
	}
	if (! $department_nm) {
		$msg_array [] = "会社/所属が入力されていません";
	}
	if (! $tel) {
		$msg_array [] = "電話番号が入力されていません";
	}
	if (! $email) {
		$msg_array [] = "E-MAILが入力されていません";
	}
	if (0 < count ( $msg_array )) {
		// ユーザ新規登録の入力画面を表示する(エラーメッセージ)
		$smarty->assign ( "data", $_POST );
		show_template_page ( "add_user.tpl.html", $msg_array );
		exit ();
	}
	// login_nmの重複チェック
	$uim = new UserInfoManager ();
	$user_info = $uim->search_user_nm ( $login_nm );
	if ($user_info) {
		// 既に同じログインIDが存在するので登録不可
		// エラーメッセージ表示
		$smarty->assign ( "data", $_POST );
		show_template_page ( "add_user.tpl.html", array (
				"入力されたユーザIDは既に登録済みです" 
		) );
		exit ();
	}
	// ユーザ登録データ
	$update_user_info = array (
			"login_nm" => $login_nm,
			"password" => pw_hash ( $password ),
			"role_id" => $role_id,
			"status_flg" => $status_flg,
			"user_nm" => $user_nm,
			"department_nm" => $department_nm,
			"tel" => $tel,
			"email" => $email,
			"update_dt" => date ( "Y/m/d H:i:s" ) 
	);
	$id = $uim->add ( $update_user_info ); // ユーザ新規追加処理
	if ($id) {
		// ユーザ登録成功
		$smarty->assign ( "is_succeed", true );
		show_template_page ( "add_user_result.tpl.html", $msg_array );
		exit ();
	} else {
		// ユーザ登録失敗
		show_error_page ( array (
				"ユーザの新規登録に失敗しました" 
		), "manage_user.php", "ユーザ管理へ戻る" );
		exit ();
	}
}
exit ();
?>
