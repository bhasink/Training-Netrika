<?php

function stm_lms_settings_profiles_section()
{

    $pages = STM_LMS_Settings::stm_get_post_type_array('page');

    return array(
        'name' => esc_html__('Profiles', 'masterstudy-lms-learning-management-system'),
        'fields' => array(
            'user_premoderation' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable Email Confirmation', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('All new registration will have an E-mail with account verification', 'masterstudy-lms-learning-management-system'),
                'columns' => 50
            ),
            'register_as_instructor' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Disable Instructor Registration', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Remove checkbox "Register as instructor" from registration', 'masterstudy-lms-learning-management-system'),
                'columns' => 50
            ),
            'disable_instructor_premoderation' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Disable Instructor Pre-moderation', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Set user role "instructor" automatically', 'masterstudy-lms-learning-management-system'),
                'columns' => 50
            ),
            'instructor_can_add_students' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Add students to own course', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Instructor will have a tool in an account to add student by email to course', 'masterstudy-lms-learning-management-system'),
                'columns' => 50
            ),
            'course_premoderation' => array(
                'type' => 'checkbox',
                'label' => esc_html__('Enable Course Pre-moderation', 'masterstudy-lms-learning-management-system'),
                'hint' => esc_html__('Course will have Pending status, until you approve it', 'masterstudy-lms-learning-management-system'),
                'pro' => true,
                'columns' => 50
            ),
            'instructors_page' => array(
                'type' => 'select',
                'label' => esc_html__('Instructors Archive Page', 'masterstudy-lms-learning-management-system'),
                'options' => $pages,
                'columns' => 50
            ),
            'profile_style' => array(
                'type' => 'select',
                'label' => esc_html__('Profile Page Style', 'masterstudy-lms-learning-management-system'),
                'options' => array(
                    'default' => esc_html__('Default', 'masterstudy-lms-learning-management-system'),
                    'classic' => esc_html__('Classic', 'masterstudy-lms-learning-management-system'),
                ),
                'value' => 'default',
                'columns' => 50
            ),
            'cancel_subscription' => array(
                'type' => 'select',
                'label' => esc_html__('Cancel subscription page', 'masterstudy-lms-learning-management-system'),
                'options' => $pages,
                'hint' => esc_html__('If you want to display link to Cancel Subscription page, choose page and add to page content shortcode [pmpro_cancel].', 'masterstudy-lms-learning-management-system'),
                'columns' => 50
            ),

        )
    );
}