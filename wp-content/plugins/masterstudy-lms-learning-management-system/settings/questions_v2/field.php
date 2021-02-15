<?php

/**
 * @var $field
 * @var $field_id
 * @var $field_value
 * @var $field_label
 * @var $field_name
 * @var $section_name
 *
 */

include STM_WPCFTO_PATH . '/metaboxes/components_js/answers.php';
wp_enqueue_script('stm-lms-questions', STM_LMS_URL . '/settings/questions_v2/js/questions.js');
wp_localize_script('stm-lms-questions', 'stm_lms_questions',
    get_terms('stm_lms_question_taxonomy', array(
        'hide_empty' => false,
        'count' => true
    )
));

wp_enqueue_script('stm-lms-questions-search', STM_LMS_URL . '/settings/questions_v2/js/search.js');
wp_enqueue_script('stm-lms-questions-image', STM_LMS_URL . '/settings/questions_v2/js/image.js');

stm_lms_register_style('admin/questions');
stm_lms_register_style('admin/curriculum_v2');

?>

    <stm_questions_v2 inline-template
                      v-bind:posts="<?php echo esc_attr($field) ?>['post_type']"
                      v-bind:stored_ids="<?php echo esc_attr($field) ?>['value']"
                      v-on:get-questions="<?php echo esc_attr($field) ?>['value'] = $event">
        <?php stm_lms_questions_v2_load_template('main'); ?>
    </stm_questions_v2>

<?php if (!empty($field_name)) : ?>
    <!-- Here We store actual value in hidden input -->
    <!-- Mostly it needed for metabox area, where WordPress saves field automatically after post update -->
    <input type="hidden"
           name="<?php echo esc_attr($field_name); ?>"
           v-bind:placeholder="<?php echo esc_attr($field_label); ?>"
           v-bind:id="'<?php echo esc_attr($field_id); ?>'"
           v-model="<?php echo esc_attr($field_value); ?>"/>

<?php endif;