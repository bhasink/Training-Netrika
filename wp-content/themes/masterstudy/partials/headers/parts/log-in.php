<?php
wp_enqueue_script('vue.js');
wp_enqueue_script('vue-resource.js');

if (function_exists('stm_lms_register_style')) {
	enqueue_login_script();
	stm_lms_register_style('login');
	stm_lms_register_style('register');
	enqueue_register_script();
}
?>

<a href="https://training.netrika.com/lms-login"
   class="stm_lms_log_in"
   >
    <i class="stmlms-user"></i>
    <span><?php esc_html_e('Log in', 'masterstudy'); ?></span>
</a>