<?php

require_once STM_LMS_PATH . '/settings/main_settings/settings.php';

add_filter('wpcfto_options_page_setup', function ($setups) {

    $setups[] = array(
        'option_name' => 'stm_lms_settings',
        'page' => array(
            'page_title' => 'LMS Settings',
            'menu_title' => 'STM LMS',
            'menu_slug' => 'stm-lms-settings',
            'icon' => 'dashicons-welcome-learn-more',
            'position' => 5,
        ),
        'fields' => array(
            'section_1' => stm_lms_settings_general_section(),
            'section_2' => stm_lms_settings_courses_section(),
            'section_course' => stm_lms_settings_course_section(),
            'section_routes' => stm_lms_settings_route_section(),
            'section_3' => stm_lms_settings_payments_section(),
            'section_5' => stm_lms_settings_google_api_section(),
            'section_4' => stm_lms_settings_profiles_section(),
            'section_6' => stm_lms_settings_certificates_section(),
            'addons' => stm_lms_settings_addons_section(),
            'payout' => stm_lms_settings_payout_section(),
            'gdpr' => stm_lms_settings_gdpr_section(),
            'stm_lms_shortcodes' => stm_lms_settings_shortcodes_section(),
        )
    );

    return $setups;
}, 5, 1);

add_action("wpcfto_screen_stm_lms_settings_added", function () {

    add_submenu_page(
        'stm-lms-settings',
        'STM LMS',
        'STM LMS Settings',
        'manage_options',
        'stm-lms-settings'
    );

    $post_types = array(
        'stm-courses',
        'stm-lessons',
        'stm-quizzes',
        'stm-questions',
        'stm-assignments',
        'stm-reviews',
        'stm-orders',
        'stm-ent-groups',
    );
    if(class_exists('Stm_Lms_Statistics')){
        $post_types[] = 'stm-payout';
    }

    $taxonomies = array(
        'stm_lms_course_taxonomy'
    );


    foreach ($post_types as $post_type) {
        $post_type_data = get_post_type_object($post_type);

        if (empty($post_type_data)) continue;

        add_submenu_page(
            'stm-lms-settings',
            $post_type_data->label,
            $post_type_data->label,
            'manage_options',
            '/edit.php?post_type=' . $post_type
        );
    }

    foreach ($taxonomies as $taxonomy) {
        $tax_data = get_taxonomy($taxonomy);

        add_submenu_page(
            'stm-lms-settings',
            $tax_data->label,
            $tax_data->label,
            'manage_options',
            'edit-tags.php?taxonomy=' . $taxonomy
        );
    }

}, -1, 10);