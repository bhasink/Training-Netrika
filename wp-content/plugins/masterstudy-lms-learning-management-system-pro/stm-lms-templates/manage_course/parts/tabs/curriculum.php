<?php if (!defined('ABSPATH')) exit; //Exit if accessed directly ?>

<?php

ob_start();
include STM_LMS_PATH . '/wp-custom-fields-theme-options/metaboxes/components_js/answers.php';
include STM_LMS_PATH . '/wp-custom-fields-theme-options/metaboxes/components_js/questions.php';
$script = ob_get_clean();
wp_add_inline_script(
	'stm-lms-manage_course',
	str_replace(array(
		'<script>', '</script>'),
		array('', ''),
		$script
	),
	'before'
)
?>

<?php STM_LMS_Templates::show_lms_template('manage_course/forms/js/modal'); ?>
<?php STM_LMS_Templates::show_lms_template('manage_course/forms/js/lesson'); ?>
<?php STM_LMS_Templates::show_lms_template('manage_course/forms/js/assignment'); ?>
<?php STM_LMS_Templates::show_lms_template('manage_course/forms/js/quiz'); ?>
<stm-modal></stm-modal>

<div class="stm_metaboxes_grid">
    <div class="stm_metaboxes_grid__inner">

        <?php do_action('stm_lms_manage_course_before_curriculum') ?>

<!--        <stm-curriculum v-bind:posts="['stm-lessons', 'stm-quizzes', 'stm-assignments']"-->
<!--                        v-bind:stored_ids="fields['curriculum']"-->
<!--                        --><?php //do_action('stm_lms_manage_course_curriculum_atts'); ?>
<!--                        v-on:get-ids="fields['curriculum'] = $event">-->
<!--        </stm-curriculum>-->

        <?php

        $field_value = "fields['curriculum']";
        ob_start();
        include STM_LMS_PATH . '/settings/curriculum/field.php';

        echo str_replace('item_edit_link"', 'item_edit_link" @click.prevent="emitMethod(item)"', ob_get_clean());

        ?>


    </div>
</div>


<input type="hidden"
       name="curriculum"
       v-model="fields['curriculum']"/>