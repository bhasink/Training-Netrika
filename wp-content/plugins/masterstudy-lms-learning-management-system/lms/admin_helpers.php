<?php

add_action('admin_enqueue_scripts', function() {
    stm_lms_register_script('admin/lms_sub_menu');
});

function stm_lms_add_theme_caps()
{

	$admin_users = $instructors = array();
	$admin_users[] = get_role('administrator');
	$instructors[] = get_role('stm_lms_instructor');

	if (!empty($admin_users)) {
		foreach ($admin_users as $user) {
			if (empty($user)) continue;
			foreach (array('publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private') as $cap) {
				$user->add_cap("{$cap}_stm_lms_posts");
			}
		}
	}

	if (!empty($instructors)) {
		foreach ($instructors as $user) {
			if (empty($user)) continue;
			foreach (array('publish', 'delete', 'edit') as $cap) {
				$user->add_cap("edit_posts");
				$user->add_cap("{$cap}_stm_lms_posts");
			}
		}
	}

}

add_action('init', 'stm_lms_add_theme_caps');

function stm_lms_admin_notice() {
    if(empty(get_transient('stm_lms_app_notice'))){
        require_once STM_LMS_PATH . '/announcement/app_announcement.php';
    }
}

add_action('admin_enqueue_scripts', function(){
    stm_lms_register_script( 'admin/admin', array( 'jquery' ), true );
    if(empty(get_transient('stm_lms_app_notice'))) {
        stm_lms_register_script( 'admin/app_announcement', array( 'jquery' ), true );
        stm_lms_register_style( 'admin/app_announcement' );
    }
});
add_action('admin_notices', 'stm_lms_admin_notice');

add_action('wp_ajax_stm_lms_hide_announcement', function(){
    set_transient('stm_lms_app_notice', '1', MONTH_IN_SECONDS);
});