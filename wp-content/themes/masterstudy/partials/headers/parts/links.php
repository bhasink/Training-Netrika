<?php

if (function_exists('stm_lms_register_style')) {
	stm_lms_register_style('enterprise');
	stm_lms_register_script('enterprise');
}

if (is_user_logged_in()):
	$target = 'stm-lms-modal-become-instructor';
	$modal = 'become_instructor';

	if (function_exists('stm_lms_register_style')) {
		stm_lms_register_style('become_instructor');
		stm_lms_register_script('become_instructor');
	}
	?>


<a href="https://netrika.com/"
       class="stm_lms_bi_link normal_font">
         <!--<i class="lnr lnr-bullhorn secondary_color"></i>-->
        <span><?php esc_html_e('Home', 'home'); ?></span>
    </a>
    <a href="/trainer/"
       class="stm_lms_bi_link normal_font"
     >
         <!--<i class="lnr lnr-bullhorn secondary_color"></i>-->
        <span><?php esc_html_e('Trainers', 'masterstudy'); ?></span>
    </a>

<?php else: ?>



	<?php if (class_exists('STM_LMS_User')): ?>
<a href="https://netrika.com/"
           class="stm_lms_bi_link normal_font">
             <!--<i class="lnr lnr-bullhorn secondary_color"></i>-->
            <span><?php esc_html_e('Home', 'home'); ?></span>
        </a>

        <a href="/trainer/"
           class="stm_lms_bi_link normal_font">
             <!--<i class="lnr lnr-bullhorn secondary_color"></i>-->
            <span><?php esc_html_e('Trainers', 'masterstudy'); ?></span>
        </a>



	<?php endif; ?>
<?php endif; ?>

<a href="/index.php/about-us/" class="stm_lms_bi_link normal_font" >
    <!-- <i class="stmlms-case secondary_color"></i>-->
    <span><?php esc_html_e('About Us', 'masterstudy'); ?></span>
</a>
<a href="/index.php/blogs/" class="stm_lms_bi_link normal_font">
    <!--<i class="stmlms-case secondary_color"></i>-->
    <span><?php esc_html_e('Blog', 'blog'); ?></span>
</a>
<a href="/contact/" class="stm_lms_bi_link normal_font" target="_blank">
    <!--<i class="stmlms-case secondary_color"></i>-->
    <span><?php esc_html_e('Contact Us', 'blog'); ?></span>
</a>